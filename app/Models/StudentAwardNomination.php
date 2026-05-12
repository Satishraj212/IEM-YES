<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentAwardNomination extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'award_nominations';

    protected $fillable = [
        'award_category_id', 'nominated_by', 'nominee_id',
        'nominee_name', 'nominee_email', 'nominee_member_id', 'nominee_branch',
        'is_self_application', 'reason', 'nominator_name', 'nominator_relationship',
        'rating', 'personal_statement', 'achievement_1', 'achievement_2',
        'document_paths', 'status',
    ];

    protected $casts = [
        'is_self_application' => 'boolean',
        'document_paths'      => 'array',
        'rating'              => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(StudentAwardCategory::class, 'award_category_id');
    }

    public function nominator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nominated_by');
    }

    public function nominee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nominee_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(StudentAwardVote::class, 'nomination_id');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getVoteCountAttribute(): int
    {
        return $this->votes()->count();
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->nominee?->name ?? $this->nominee_name ?? 'Unknown';
    }

    public function getDisplayBranchAttribute(): string
    {
        return $this->nominee?->branch?->name ?? $this->nominee_branch ?? '—';
    }
}
