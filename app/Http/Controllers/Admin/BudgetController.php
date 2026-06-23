<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\StudentEventBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function index()
    {
        // Drafts (reinstated requests being revised by the chapter) are not yet with HQ.
        $budgets = StudentEventBudget::with(['event.branch', 'items', 'receipts'])
            ->whereIn('status', ['pending', 'approved', 'rejected'])
            ->orderByRaw("CASE status WHEN 'pending' THEN 1 WHEN 'approved' THEN 2 WHEN 'rejected' THEN 3 ELSE 4 END")
            ->latest()
            ->get();

        $approvedBudgets   = $budgets->where('status', 'approved');
        $totalApprovedRm   = (float) $approvedBudgets->sum('total_approved');
        $totalReimbursedRm = (float) $approvedBudgets->sum('total_reimbursed');

        $stats = [
            'pending'           => $budgets->where('status', 'pending')->count(),
            'approved'          => $approvedBudgets->count(),
            'rejected'          => $budgets->where('status', 'rejected')->count(),
            'total_approved_rm' => $totalApprovedRm,
            // Approved funding not yet claimed = approved − reimbursed.
            'unused_rm'         => round($totalApprovedRm - $totalReimbursedRm, 2),
        ];

        return view('admin.budget-requests', compact('budgets', 'stats'));
    }

    public function approve(Request $request, StudentEventBudget $budget)
    {
        $budget->loadMissing('items');

        $request->validate([
            'approved'       => 'array',
            'approved.*'     => 'nullable|numeric|min:0',
            'internal_notes' => 'nullable|string|max:1000',
        ]);

        $approved = $request->input('approved', []);

        DB::transaction(function () use ($budget, $approved, $request) {
            // Approve a figure per category; the total is their sum.
            $total = 0;
            foreach ($budget->items as $item) {
                $amt = isset($approved[$item->id]) && $approved[$item->id] !== ''
                    ? (float) $approved[$item->id]
                    : (float) ($item->quantity * $item->unit_cost);
                $item->update(['approved_amount' => $amt]);
                $total += $amt;
            }

            $budget->update([
                'status'         => 'approved',
                'total_approved' => $total,
                'internal_notes' => $request->input('internal_notes'),   // internal only
                'decided_by'     => Auth::id(),
                'decided_at'     => now(),
            ]);
        });

        ActivityLog::record(
            $budget->event?->branch_id,
            'budget_approved',
            "Budget approved for: " . ($budget->event?->title ?? 'event'),
            Auth::id(),
            $budget
        );

        return back()->with('success', 'Budget request approved.');
    }

    public function reject(Request $request, StudentEventBudget $budget)
    {
        $budget->loadMissing('items');

        // Funds already released — the decision can no longer be reversed.
        if ($budget->reimbursed_at) {
            return back()->with('error', 'A reimbursed budget can no longer be rejected.');
        }

        $request->validate([
            'feedback'       => 'required|string|max:1000',   // chapter-facing reason
            'internal_notes' => 'nullable|string|max:1000',   // internal only
            'approved'       => 'array',
            'approved.*'     => 'nullable|numeric|min:0',
        ]);

        $approved = $request->input('approved', []);

        DB::transaction(function () use ($budget, $approved, $request) {
            // Record the figure HQ is willing to fund per category, even on rejection,
            // so the chapter can see it and revise against it.
            $total = 0;
            foreach ($budget->items as $item) {
                // Use the submitted figure if present, else keep any existing approved
                // amount (e.g. when reversing a previous approval), else the requested.
                $amt = isset($approved[$item->id]) && $approved[$item->id] !== ''
                    ? (float) $approved[$item->id]
                    : (float) ($item->approved_amount ?? ($item->quantity * $item->unit_cost));
                $item->update(['approved_amount' => $amt]);
                $total += $amt;
            }

            $budget->update([
                'status'         => 'rejected',
                'total_approved' => $total,
                'decision_notes' => $request->input('feedback'),
                'internal_notes' => $request->input('internal_notes'),
                'decided_by'     => Auth::id(),
                'decided_at'     => now(),
            ]);
        });

        ActivityLog::record(
            $budget->event?->branch_id,
            'budget_rejected',
            "Budget rejected for: " . ($budget->event?->title ?? 'event'),
            Auth::id(),
            $budget,
            $request->input('feedback', '')
        );

        return back()->with('error', 'Budget request rejected.');
    }

    public function reimburse(Request $request, StudentEventBudget $budget)
    {
        if ($budget->status !== 'approved') {
            return back()->with('error', 'Only an approved budget can be reimbursed.');
        }

        // Reimbursement is based on the receipts provided — there must be at least one.
        if ($budget->receipts()->count() === 0) {
            return back()->with('error', 'Cannot reimburse — the chapter has not submitted any invoices/receipts yet.');
        }

        // Reimburse what the receipts justify, never more than the agreed approved amount.
        $cap = round((float) ($budget->total_approved ?? $budget->total_requested), 2);
        $validated = $request->validate(
            [
                'total_reimbursed' => ['required', 'numeric', 'min:0', "max:{$cap}"],
                'notes'            => ['nullable', 'string', 'max:1000'],
            ],
            [
                'total_reimbursed.max' => 'The reimbursed amount cannot exceed the approved budget of RM ' . number_format($cap, 2) . '.',
            ]
        );

        // Defensive clamp in case the figure slips through (e.g. a tampered request).
        $reimbursed = min((float) $validated['total_reimbursed'], $cap);

        $budget->update([
            'total_reimbursed' => $reimbursed,
            'decision_notes'   => $validated['notes'] ?? $budget->decision_notes,
            'reimbursed_by'    => Auth::id(),
            'reimbursed_at'    => now(),
        ]);

        ActivityLog::record(
            $budget->event?->branch_id,
            'budget_reimbursed',
            "Reimbursed RM " . number_format($reimbursed, 2) . " for: " . ($budget->event?->title ?? 'event'),
            Auth::id(),
            $budget
        );

        return back()->with('success', 'Reimbursement recorded.');
    }
}
