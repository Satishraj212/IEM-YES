<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentEventController extends Controller
{
    public function index()
    {
        $events = Event::whereIn('status', ['submitted', 'approved', 'rejected'])
            ->with(['branch', 'creator', 'budget.items'])
            ->orderByRaw("CASE status
                WHEN 'submitted' THEN 1
                WHEN 'approved'  THEN 2
                WHEN 'rejected'  THEN 3
                ELSE 4 END")
            ->orderByDesc('submitted_at')
            ->get();

        $submissions = $events->map(fn ($e) => $this->formatForJs($e));

        $counts = [
            'pending'  => $events->filter(fn ($e) => $this->deriveStage($e) === 'pending')->count(),
            'ppw'      => $events->filter(fn ($e) => $this->deriveStage($e) === 'ppw')->count(),
            'approved' => $events->where('status', 'approved')->count(),
            'rejected' => $events->where('status', 'rejected')->count(),
        ];

        $universities = $events
            ->map(fn ($e) => $e->branch?->name)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('admin.student-events', compact('submissions', 'counts', 'universities') + [
            'pageTitle'    => 'Student Section',
            'pageSubtitle' => 'Event Review',
            'pageDesc'     => 'Review incoming event submissions from YES student chapters',
        ]);
    }

    // ── AJAX stage transition (called by the JS apiStage() function) ──────────

    public function updateStage(Request $request, Event $event)
    {
        $request->validate([
            'action'      => 'required|in:advance,reject,reinstate,revision',
            // Internal admin scratchpad — never shown to the chapter.
            'admin_notes' => 'nullable|string|max:2000',
            // Chapter-facing comment; required when sending an event back for revision.
            'feedback'    => ($request->input('action') === 'revision' ? 'required' : 'nullable') . '|string|max:2000',
        ]);

        abort_unless(
            in_array($event->status, ['submitted', 'approved', 'rejected']),
            422,
            'Event is not in a reviewable state.'
        );

        $internal = $request->input('admin_notes');   // internal-only
        $feedback = $request->input('feedback') ?? '';   // sent to the chapter
        $stage    = $this->deriveStage($event);

        // Stage change + audit log must be atomic: if the log write fails the
        // stage transition must roll back, otherwise the event is left half-advanced.
        $fresh = DB::transaction(function () use ($request, $event, $stage, $internal, $feedback) {
            match ($request->action) {
                'advance'  => $this->advanceStage($event, $stage, $internal),
                'reject'   => $this->rejectEvent($event, $feedback, $internal),
                'reinstate'=> $this->reinstateEvent($event),
                'revision' => $this->requestRevision($event, $feedback, $internal),
                default    => null,
            };

            $fresh = $event->fresh();
            [$logType, $logTitle] = match ($request->action) {
                'advance'   => $fresh->status === 'approved'
                    ? ['event_approved', "Student event \"{$event->title}\" approved"]
                    : ['event_advanced', "Student event \"{$event->title}\" advanced to PPW screening"],
                'reject'    => ['event_rejected',   "Student event \"{$event->title}\" rejected"],
                'reinstate' => ['event_reinstated', "Student event \"{$event->title}\" reinstated"],
                'revision'  => ['event_revision',   "Revision requested for \"{$event->title}\""],
                default     => ['event_submitted',  "Student event \"{$event->title}\" updated"],
            };
            // The chapter-facing comment is logged in the audit trail; internal notes are not.
            ActivityLog::record($event->branch_id, $logType, $logTitle, Auth::id(), $event, $feedback);

            return $fresh;
        });

        return response()->json(['success' => true, 'submission' => $this->formatForJs($fresh)]);
    }

    // ── Form-based fallbacks (used from blade if JS is unavailable) ───────────

    public function approve(Request $request, Event $event)
    {
        $event->approve(Auth::id());

        ActivityLog::record($event->branch_id, 'event_approved', "Student event \"{$event->title}\" approved", Auth::id(), $event);

        return back()->with('success', 'Event approved.');
    }

    public function reject(Request $request, Event $event)
    {
        $this->rejectEvent($event, $request->input('feedback', ''), $request->input('admin_notes'));

        ActivityLog::record($event->branch_id, 'event_rejected', "Student event \"{$event->title}\" rejected", Auth::id(), $event, $request->input('feedback', ''));

        return back()->with('error', 'Event rejected.');
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function advanceStage(Event $event, string $currentStage, ?string $internal): void
    {
        match ($currentStage) {
            'pending' => $event->update([
                'track_doc_approved' => true,
                'internal_notes'     => $internal ?? $event->internal_notes,
            ]),
            'ppw' => $event->approve(Auth::id()),
            default => null,
        };
    }

    private function rejectEvent(Event $event, string $feedback, ?string $internal): void
    {
        $event->update([
            'status'           => 'rejected',
            'track_rejected'   => true,
            'track_published'  => false,                           // pull it from the public site
            'rejection_reason' => $feedback,                       // shown to the chapter
            'internal_notes'   => $internal ?? $event->internal_notes,
        ]);
    }

    /**
     * Send the event back to the student for changes: it becomes an editable
     * draft again, carrying the admin's correction comment (shown to the chapter).
     */
    private function requestRevision(Event $event, string $feedback, ?string $internal): void
    {
        $event->update([
            'status'                => 'draft',
            'revision_note'         => $feedback,                  // shown to the chapter
            'internal_notes'        => $internal ?? $event->internal_notes,
            'track_submitted'       => false,
            'track_doc_approved'    => false,
            'track_budget_approved' => false,
            'track_published'       => false,
            'track_rejected'        => false,
            'submitted_at'          => null,
        ]);
    }

    private function reinstateEvent(Event $event): void
    {
        $event->update([
            'status'                => 'submitted',
            'track_doc_approved'    => false,
            'track_budget_approved' => false,
            'track_published'       => false,
            'track_rejected'        => false,
            'rejection_reason'      => null,
            'approved_by'           => null,
            'approved_at'           => null,
        ]);
    }

    private function deriveStage(Event $event): string
    {
        return match ($event->status) {
            'approved' => $event->track_published ? 'published' : 'approved',
            'rejected' => 'rejected',
            'submitted' => $event->track_doc_approved ? 'ppw' : 'pending',
            default    => 'pending',
        };
    }

    private function formatForJs(Event $event): array
    {
        $branch  = $event->branch;
        $creator = $event->creator;
        $stage   = $this->deriveStage($event);

        // Reconstruct stage_history so the pipeline dots render correctly
        $history = [];
        if (in_array($stage, ['ppw', 'approved', 'published'])) $history[] = 'pending';
        if (in_array($stage, ['approved', 'published']))        $history[] = 'ppw';
        if ($stage === 'published')                             $history[] = 'approved';

        // Map budget line items to the flat {name: amount} format the view expects
        $budget = [];
        if ($event->budget) {
            foreach ($event->budget->items as $item) {
                $budget[$item->name] = round($item->quantity * $item->unit_cost, 2);
            }
        }

        return [
            'id'              => $event->id,
            'title'           => $event->title,
            'university'      => $branch?->identity_name ?? 'Unknown Chapter',
            'university_full' => $branch?->identity_institution ?? $branch?->identity_name ?? 'Unknown Chapter',
            'category'        => strtolower(str_replace(' ', '', $event->category ?? 'other')),
            'event_date'      => $event->start_date?->format('j M Y') ?? 'TBC',
            'submitted_by'    => $creator?->name ?? 'Unknown',
            'submitted_date'  => ($event->submitted_at ?? $event->created_at)->format('j M Y'),
            'stage'           => $stage,
            'stage_history'   => $history,
            'budget'          => $budget,
            'budget_total'    => collect($budget)->sum(),
            'description'     => $event->description,
            'admin_notes'     => $event->internal_notes,
            'ppw_filename'    => $event->ppw_filename ?? ($event->ppw_path ? basename($event->ppw_path) : null),
            'ppw_size'        => null,
            'ppw_url'         => $event->ppw_path ? asset('storage/' . $event->ppw_path) : null,
            'poster_filename' => $event->poster_path ? basename($event->poster_path) : null,
            'poster_url'      => $event->poster_path ? asset('storage/' . $event->poster_path) : null,
            'tags'            => $event->tags ?? [],
        ];
    }
}
