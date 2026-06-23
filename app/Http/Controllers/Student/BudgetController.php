<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BudgetReceipt;
use App\Models\Event;
use App\Models\StudentEventBudget;
use App\Models\StudentEventBudgetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        $budgets = StudentEventBudget::with(['event', 'items', 'receipts'])
            ->whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
            ->latest()
            ->get();

        $approvedBudgets = $budgets->where('status', 'approved');
        $totalApproved   = (float) $approvedBudgets->sum('total_approved');
        $totalReimbursed = (float) $approvedBudgets->sum('total_reimbursed');

        $stats = [
            'pending'        => $budgets->where('status', 'pending')->count(),
            'approved'       => $approvedBudgets->count(),
            'reinstate'      => $budgets->where('status', 'rejected')->count(),
            'total_approved' => $totalApproved,
            // Approved funding that was never claimed/used = approved − reimbursed.
            'unused'         => round($totalApproved - $totalReimbursed, 2),
        ];

        // A budget request is optional, may only be raised against an approved event,
        // and each event can carry at most one request — events that already have one
        // are excluded (the chapter reinstates the existing request to change it).
        $approvedEvents = Event::forBranch($branch->id)
            ->where('status', 'approved')
            ->whereDoesntHave('budget')
            ->orderBy('title')
            ->get(['id', 'title', 'start_date', 'venue', 'category']);

        return view('student-section.budget', compact('user', 'branch', 'budgets', 'stats', 'approvedEvents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'          => 'required|exists:events,id',
            'justification'     => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.name'      => 'required|string|max:255',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        // A budget request may only be raised against this chapter's *approved* event.
        $event = Event::where('branch_id', $branch->id)
            ->where('status', 'approved')
            ->findOrFail($validated['event_id']);

        // One request per event — the chapter reinstates the existing one to revise it.
        if ($event->budget()->exists()) {
            return back()->with('error', 'This event already has a budget request. Reinstate the existing request to make changes.');
        }

        DB::transaction(function () use ($validated, $event, $user, $branch) {
            $total = collect($validated['items'])
                ->sum(fn ($i) => $i['quantity'] * $i['unit_cost']);

            $budget = StudentEventBudget::create([
                'event_id'        => $event->id,
                'total_requested' => $total,
                'justification'   => $validated['justification'] ?? null,
                'status'          => StudentEventBudget::STATUS_PENDING,
            ]);

            foreach ($validated['items'] as $item) {
                StudentEventBudgetItem::create([
                    'event_budget_id' => $budget->id,
                    'name'            => $item['name'],
                    'quantity'        => $item['quantity'],
                    'unit_cost'       => $item['unit_cost'],
                ]);
            }

            ActivityLog::record(
                $branch->id,
                'budget_submitted',
                "Budget request submitted for {$event->title}",
                $user->id,
                $budget
            );
        });

        return back()->with('success', 'Budget request submitted for review.');
    }

    // ── Post-approval: submit invoices / receipts for reimbursement ────────────

    public function uploadReceipts(Request $request, StudentEventBudget $budget)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Must be this chapter's budget, and only an approved request can claim reimbursement.
        abort_unless($budget->event?->branch_id === $user->branch_id, 403);
        if ($budget->status !== StudentEventBudget::STATUS_APPROVED) {
            return back()->with('error', 'Receipts can only be submitted for an approved budget.');
        }

        $request->validate([
            'receipts'   => 'required|array|min:1',
            'receipts.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
        ]);

        $dir = "branches/{$user->branch_id}/budget-receipts";
        foreach ($request->file('receipts') as $file) {
            BudgetReceipt::create([
                'event_budget_id' => $budget->id,
                'path'            => $file->store($dir, 'public'),
                'filename'        => $file->getClientOriginalName(),
                'uploaded_by'     => $user->id,
            ]);
        }

        ActivityLog::record(
            $user->branch_id,
            'budget_receipts_submitted',
            "Invoices submitted for reimbursement: " . ($budget->event?->title ?? 'event'),
            $user->id,
            $budget
        );

        return back()->with('success', 'Invoices submitted. YES will review and process your reimbursement.');
    }

    // ── Reinstate a rejected request back into review ──────────────────────────

    public function reinstate(StudentEventBudget $budget)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless($budget->event?->branch_id === $user->branch_id, 403);
        if ($budget->status !== StudentEventBudget::STATUS_REJECTED) {
            return back()->with('error', 'Only a rejected request can be reinstated.');
        }

        DB::transaction(function () use ($budget) {
            // Clear HQ's funding figures (keep the reason as guidance) and drop it to an
            // editable DRAFT — it stays off the admin dashboard until resubmitted.
            $budget->items()->update(['approved_amount' => null]);
            $budget->update([
                'status'         => StudentEventBudget::STATUS_DRAFT,
                'total_approved' => null,
                'decided_by'     => null,
                'decided_at'     => null,
            ]);
        });

        ActivityLog::record(
            $user->branch_id,
            'budget_submitted',
            "Budget request reinstated for revision: " . ($budget->event?->title ?? 'event'),
            $user->id,
            $budget
        );

        return back()->with('success', 'Reinstated as a draft — revise the breakdown and resubmit to HQ.');
    }

    // ── Revise a draft and resubmit it to HQ (after this it is locked) ─────────

    public function update(Request $request, StudentEventBudget $budget)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        abort_unless($budget->event?->branch_id === $user->branch_id, 403);
        // Only an editable draft can be revised; once submitted the request is locked.
        if ($budget->status !== StudentEventBudget::STATUS_DRAFT) {
            return back()->with('error', 'Only a draft can be edited. Submitted requests are locked.');
        }

        $validated = $request->validate([
            'justification'     => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.name'      => 'required|string|max:255',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $budget) {
            $budget->items()->delete();
            $total = 0;
            foreach ($validated['items'] as $item) {
                $budget->items()->create([
                    'name'      => $item['name'],
                    'quantity'  => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                ]);
                $total += $item['quantity'] * $item['unit_cost'];
            }
            $budget->update([
                'total_requested' => $total,
                'justification'   => $validated['justification'] ?? null,
                'status'          => StudentEventBudget::STATUS_PENDING,   // resubmit to HQ
                'decision_notes'  => null,
            ]);
        });

        ActivityLog::record(
            $user->branch_id,
            'budget_submitted',
            "Budget request resubmitted for review: " . ($budget->event?->title ?? 'event'),
            $user->id,
            $budget
        );

        return back()->with('success', 'Budget request resubmitted to HQ for review.');
    }
}
