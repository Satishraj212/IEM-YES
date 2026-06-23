<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchOrgChart extends Model
{
    protected $fillable = [
        'branch_id', 'academic_year', 'file_path', 'is_current', 'uploaded_by',
        'status', 'review_comment', 'reviewed_at', 'reviewed_by',
    ];

    protected $casts = [
        'is_current'  => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    /** Standardised pipeline: Submitted → Under Review → Approved / Returned. */
    public function getStageAttribute(): string
    {
        return match ($this->status) {
            'approved' => 'approved',
            'rejected' => 'returned',
            default    => 'review',   // pending == "Under Review"
        };
    }

    public function getIsPdfAttribute(): bool
    {
        return str_ends_with(strtolower($this->file_path ?? ''), '.pdf');
    }
}
