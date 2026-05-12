<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentEventSubmission;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class StudentEventController extends Controller
{
    public function index()
    {
        $submissions = StudentEventSubmission::orderByDesc('created_at')
            ->get()
            ->map(fn($s) => $this->formatForJs($s));

        $counts = [
            'pending'  => StudentEventSubmission::where('stage', 'pending')->count(),
            'ppw'      => StudentEventSubmission::where('stage', 'ppw')->count(),
            'approved' => StudentEventSubmission::where('stage', 'approved')->count(),
            'rejected' => StudentEventSubmission::where('stage', 'rejected')->count(),
        ];

        $universities = StudentEventSubmission::distinct()->pluck('university')->sort()->values();

        return view('admin.student-events', compact('submissions', 'counts', 'universities') + [
            'pageTitle'    => 'Student Section',
            'pageSubtitle' => 'Event Review',
            'pageDesc'     => 'Review incoming event submissions from YES student chapters',
        ]);
    }

    public function updateStage(Request $request, StudentEventSubmission $submission)
    {
        $request->validate([
            'action'      => 'required|in:advance,reject,reinstate,revision',
            'admin_notes' => 'nullable|string',
        ]);

        $order = ['pending', 'ppw', 'approved'];

        match ($request->action) {
            'advance' => $this->advance($submission, $order),
            'reject'  => $this->rejectSubmission($submission),
            'reinstate' => fn() => $submission->update(['stage' => 'pending', 'stage_history' => []]),
            'revision'  => fn() => null, // notify logic handled externally
            default   => null,
        };

        if ($request->admin_notes !== null) {
            $submission->update(['admin_notes' => $request->admin_notes]);
        }

        if ($request->action === 'reinstate') {
            $submission->update(['stage' => 'pending', 'stage_history' => []]);
        }

        ActivityLog::log(
            'student_event_' . $request->action,
            "Student event <strong>{$submission->title}</strong> — action: {$request->action}.",
            'var(--navy)'
        );

        return response()->json(['submission' => $this->formatForJs($submission->fresh())]);
    }

    public function approve(Request $request, StudentEventSubmission $submission)
    {
        $history   = $submission->stage_history ?? [];
        $history[] = $submission->stage;
        $submission->update(['stage' => 'approved', 'stage_history' => $history,
                             'admin_notes' => $request->admin_notes]);

        ActivityLog::log('student_event_approve', "Student event {$submission->title} approved.");

        return back()->with('success', 'Submission approved.');
    }

    public function reject(Request $request, StudentEventSubmission $submission)
    {
        $history   = $submission->stage_history ?? [];
        $history[] = $submission->stage;
        $submission->update(['stage' => 'rejected', 'stage_history' => $history,
                             'admin_notes' => $request->admin_notes]);

        ActivityLog::log('student_event_reject', "Student event {$submission->title} rejected.");

        return back()->with('error', 'Submission rejected.');
    }

    private function advance(StudentEventSubmission $s, array $order): void
    {
        $idx = array_search($s->stage, $order);
        if ($idx !== false && $idx < count($order) - 1) {
            $history = $s->stage_history ?? [];
            $history[] = $s->stage;
            $s->update(['stage' => $order[$idx + 1], 'stage_history' => $history]);
        }
    }

    private function rejectSubmission(StudentEventSubmission $s): void
    {
        $history = $s->stage_history ?? [];
        $history[] = $s->stage;
        $s->update(['stage' => 'rejected', 'stage_history' => $history]);
    }

    private function formatForJs(StudentEventSubmission $s): array
    {
        return [
            'id'              => $s->id,
            'title'           => $s->title,
            'university'      => $s->university,
            'university_full' => $s->university_full,
            'category'        => $s->category,
            'event_date'      => $s->event_date,
            'submitted_by'    => $s->submitted_by,
            'submitted_date'  => $s->created_at->format('j M Y'),
            'stage'           => $s->stage,
            'stage_history'   => $s->stage_history ?? [],
            'budget'          => $s->budget ?? [],
            'budget_total'    => collect($s->budget ?? [])->sum(),
            'description'     => $s->description,
            'admin_notes'     => $s->admin_notes,
            'ppw_filename'    => $s->ppw_filename,
            'ppw_size'        => $s->ppw_size,
            'poster_filename' => $s->poster_filename,
        ];
    }
}