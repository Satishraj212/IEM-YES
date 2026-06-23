<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentEventBudget extends Model
{
    use HasFactory;

    protected $table = 'event_budgets';

    const STATUS_DRAFT    = 'draft';
    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'event_id', 'category', 'total_requested', 'total_approved', 'total_reimbursed',
        'status', 'justification', 'decision_notes', 'internal_notes', 'decided_by', 'decided_at',
        'reimbursed_by', 'reimbursed_at',
    ];

    protected $casts = [
        'total_requested'  => 'decimal:2',
        'total_approved'   => 'decimal:2',
        'total_reimbursed' => 'decimal:2',
        'decided_at'       => 'datetime',
        'reimbursed_at'    => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(StudentEvent::class, 'event_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(StudentEventBudgetItem::class, 'event_budget_id');
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(BudgetReceipt::class, 'event_budget_id');
    }

    public function decider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'decided_by');
    }

    public function getCalculatedTotalAttribute(): float
    {
        return $this->items->sum(fn ($i) => $i->quantity * $i->unit_cost);
    }

    public function reimburser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reimbursed_by');
    }

    /**
     * Standardised 4-stage pipeline shared by both the chapter and admin views:
     * Submitted → Under Review → Approved → Reimbursed (with Rejected off-track).
     */
    public function getStageAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT    => 'draft',     // reinstated — editable, not yet with HQ
            self::STATUS_APPROVED => $this->reimbursed_at ? 'reimbursed' : 'approved',
            self::STATUS_REJECTED => 'rejected',
            default               => 'review',   // pending == "Under Review"
        };
    }

    /** The figure that matters for display: approved amount once decided, else requested. */
    public function getEffectiveTotalAttribute(): float
    {
        return (float) ($this->status === self::STATUS_APPROVED
            ? ($this->total_approved ?? $this->total_requested)
            : $this->total_requested);
    }
}
