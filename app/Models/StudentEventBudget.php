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

    protected $fillable = [
        'event_id', 'category', 'total_requested',
        'total_approved', 'status', 'justification', 'rejection_notes',
    ];

    protected $casts = [
        'total_requested' => 'decimal:2',
        'total_approved'  => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(StudentEvent::class, 'event_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(StudentEventBudgetItem::class, 'event_budget_id');
    }

    public function getCalculatedTotalAttribute(): float
    {
        return $this->items->sum(fn ($i) => $i->quantity * $i->unit_cost);
    }
}
