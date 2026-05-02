<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentEvent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'branch_id', 'created_by', 'title', 'category', 'description',
        'start_date', 'end_date', 'venue', 'max_capacity', 'expected_attendees',
        'status', 'poster_path', 'internal_notes', 'tags', 'is_sdg', 'sdg_goals',
        'track_submitted', 'track_doc_approved', 'track_budget_approved',
        'track_published', 'track_rejected', 'rejection_reason',
        'submitted_at', 'approved_at', 'approved_by',
    ];

    protected $casts = [
        'start_date'            => 'date',
        'end_date'              => 'date',
        'submitted_at'          => 'datetime',
        'approved_at'           => 'datetime',
        'tags'                  => 'array',
        'sdg_goals'             => 'array',
        'is_sdg'                => 'boolean',
        'track_submitted'       => 'boolean',
        'track_doc_approved'    => 'boolean',
        'track_budget_approved' => 'boolean',
        'track_published'       => 'boolean',
        'track_rejected'        => 'boolean',
        'max_capacity'          => 'integer',
        'expected_attendees'    => 'integer',
    ];

    // ── Status constants ──────────────────────────────────────────────────────

    const STATUS_DRAFT     = 'draft';
    const STATUS_UPCOMING  = 'upcoming';
    const STATUS_OPEN      = 'open';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED  = 'approved';
    const STATUS_REJECTED  = 'rejected';
    const STATUS_PAST      = 'past';
    const STATUS_CANCELLED = 'cancelled';

    const CATEGORIES = [
        'Hackathon', 'Career Fair', 'Webinar',
        'Workshop', 'Competition', 'Volunteer',
        'SDG Event', 'Talk', 'Other',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function branch(): BelongsTo
    {
        return $this->belongsTo(StudentBranch::class, 'branch_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(StudentMember::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(StudentMember::class, 'approved_by');
    }

    public function budget(): HasOne
    {
        return $this->hasOne(StudentEventBudget::class, 'event_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(StudentEventRegistration::class, 'event_id');
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(StudentEventRegistration::class, 'event_id')
                    ->where('status', 'attended');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getPosterUrlAttribute(): ?string
    {
        return $this->poster_path
            ? asset('storage/' . $this->poster_path)
            : null;
    }

    public function getDateDisplayAttribute(): string
    {
        if (!$this->start_date) return 'TBC';
        $start = $this->start_date->format('j M Y');
        if ($this->end_date && $this->end_date->ne($this->start_date)) {
            return $this->start_date->format('j') . '–' . $this->end_date->format('j M Y');
        }
        return $start;
    }

    public function getRegistrationCountAttribute(): int
    {
        return $this->registrations()
                    ->whereIn('status', ['registered', 'attended'])
                    ->count();
    }

    public function getRegistrationPercentAttribute(): int
    {
        if (!$this->max_capacity || $this->max_capacity === 0) return 0;
        return (int) round(($this->registration_count / $this->max_capacity) * 100);
    }

    public function getIsFullAttribute(): bool
    {
        return (bool) ($this->max_capacity && $this->registration_count >= $this->max_capacity);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeForBranch($query, int $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', [
                        self::STATUS_OPEN,
                        self::STATUS_UPCOMING,
                        self::STATUS_APPROVED,
                     ])
                     ->where('start_date', '>=', now());
    }

    public function scopeSdg($query)
    {
        return $query->where('is_sdg', true);
    }

    // ── Methods ───────────────────────────────────────────────────────────────

    public function canBeSubmitted(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_UPCOMING]);
    }

    public function submitForReview(): bool
    {
        if (!$this->canBeSubmitted()) return false;

        $this->update([
            'status'          => self::STATUS_SUBMITTED,
            'track_submitted' => true,
            'submitted_at'    => now(),
        ]);

        return true;
    }

    public function approve(int $approverId): void
    {
        $this->update([
            'status'                => self::STATUS_APPROVED,
            'track_doc_approved'    => true,
            'track_budget_approved' => true,
            'track_published'       => true,
            'approved_by'           => $approverId,
            'approved_at'           => now(),
        ]);
    }

    public function reject(string $reason): void
    {
        $this->update([
            'status'           => self::STATUS_REJECTED,
            'track_rejected'   => true,
            'rejection_reason' => $reason,
        ]);
    }
}
