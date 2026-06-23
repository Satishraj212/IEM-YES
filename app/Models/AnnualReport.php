<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnualReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id', 'submitted_by', 'year', 'title', 'report_data', 'submitted_at',
        'file_path', 'file_name', 'file_size',
        'status', 'notes', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'year'         => 'integer',
        'file_size'    => 'integer',
        'report_data'  => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at'  => 'datetime',
    ];

    /** Standardised pipeline: Submitted → Under Review → Approved / Returned. */
    public function getStageAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'approved',
            'rejected' => 'returned',
            default    => 'review',   // pending == "Under Review"
        };
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
