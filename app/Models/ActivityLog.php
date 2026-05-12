<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'branch_id', 'user_id', 'type', 'title', 'description',
        'subject_type', 'subject_id', 'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    const TYPE_COLOURS = [
        'event_registered'   => '#4caf7d',
        'event_published'    => '#001f45',
        'event_submitted'    => '#d97706',
        'award_submitted'    => '#c8a84b',
        'award_voted'        => '#5b21b6',
        'nomination_sent'    => '#c8a84b',
        'membership_request' => '#c8a84b',
        'pledge_renewed'     => '#5b21b6',
        'report_submitted'   => '#4caf7d',
        'hq_approved'        => '#d97706',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getDotColourAttribute(): string
    {
        return self::TYPE_COLOURS[$this->type] ?? '#6b7280';
    }

    // ── Factory method ────────────────────────────────────────────────────────

    public static function record(
        ?int $branchId,
        string $type,
        string $title,
        ?int $userId = null,
        ?Model $subject = null,
        string $description = '',
        array $metadata = []
    ): self {
        return self::create([
            'branch_id'    => $branchId,
            'user_id'      => $userId,
            'type'         => $type,
            'title'        => $title,
            'description'  => $description,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'metadata'     => $metadata,
        ]);
    }

    public static function log(string $type, string $message, string $dotColor = '', string $dotIcon = ''): self
    {
        return self::record(null, $type, strip_tags($message));
    }
}
