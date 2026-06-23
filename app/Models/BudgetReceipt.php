<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetReceipt extends Model
{
    protected $table = 'budget_receipts';

    protected $fillable = ['event_budget_id', 'path', 'filename', 'uploaded_by'];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(StudentEventBudget::class, 'event_budget_id');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
