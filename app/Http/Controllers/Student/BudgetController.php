<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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

        $budgets = StudentEventBudget::with(['event', 'items'])
            ->whereHas('event', fn ($q) => $q->where('branch_id', $branch->id))
            ->latest()
            ->get();

        $stats = [
            'total_requested' => $budgets->sum('total_requested'),
            'total_approved'  => $budgets->where('status', 'approved')->sum('total_approved'),
            'pending'         => $budgets->where('status', 'pending')->count(),
            'approved'        => $budgets->where('status', 'approved')->count(),
        ];

        return view('student-section.budget', compact('user', 'branch', 'budgets', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id'      => 'required|exists:events,id',
            'category'      => 'nullable|string|max:100',
            'justification' => 'nullable|string',
            'items'         => 'required|array|min:1',
            'items.*.name'      => 'required|string|max:255',
            'items.*.quantity'  => 'required|integer|min:1',
            'items.*.unit_cost' => 'required|numeric|min:0',
        ]);

        /** @var \App\Models\User $user */
        $user   = Auth::user();
        $branch = $user->branch;

        $event = Event::where('branch_id', $branch->id)->findOrFail($validated['event_id']);

        DB::transaction(function () use ($validated, $event, $user, $branch) {
            $total = collect($validated['items'])
                ->sum(fn ($i) => $i['quantity'] * $i['unit_cost']);

            $budget = StudentEventBudget::create([
                'event_id'        => $event->id,
                'category'        => $validated['category'] ?? null,
                'total_requested' => $total,
                'justification'   => $validated['justification'] ?? null,
                'status'          => 'pending',
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
                'report_submitted',
                "Budget request submitted for {$event->title}",
                $user->id,
                $budget
            );
        });

        return back()->with('success', 'Budget request submitted for review.');
    }
}
