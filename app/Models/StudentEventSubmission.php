<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentEventSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'university', 'university_full', 'category',
        'event_date', 'submitted_by', 'stage', 'stage_history',
        'budget', 'description', 'admin_notes',
        'ppw_path', 'ppw_filename', 'ppw_size',
        'poster_path', 'poster_filename',
    ];

    protected $casts = [
        'budget'        => 'array',
        'stage_history' => 'array',
    ];

    // ── Relationships ──

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // ── Accessors ──

    public function getBudgetTotalAttribute(): float
    {
        return collect($this->budget ?? [])->sum();
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->stage === 'approved';
    }

    public function getIsRejectedAttribute(): bool
    {
        return $this->stage === 'rejected';
    }

    // ── Scopes ──

    public function scopeAtStage($query, string $stage)
    {
        return $query->where('stage', $stage);
    }

    public function scopePending($query)
    {
        return $query->where('stage', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('stage', 'approved');
    }
}
