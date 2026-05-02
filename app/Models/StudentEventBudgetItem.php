<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentEventBudgetItem extends Model
{
    protected $table = 'event_budget_items';

    protected $fillable = ['event_budget_id', 'name', 'quantity', 'unit_cost'];

    protected $casts = [
        'quantity'  => 'integer',
        'unit_cost' => 'decimal:2',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(StudentEventBudget::class, 'event_budget_id');
    }

    public function getLineTotalAttribute(): float
    {
        return $this->quantity * $this->unit_cost;
    }
}
