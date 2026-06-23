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

    /**
     * Single source of truth for every activity type.
     *   type => [colour, icon, category, label]
     * `icon` keys map to the SVG set rendered in resources/views/admin/activity.blade.php.
     */
    const TYPE_META = [
        // ── Events ──────────────────────────────────────────────────────────
        'event_created'       => ['#001f45', 'calendar', 'events',  'Event created'],
        'event_submitted'     => ['#d97706', 'calendar', 'events',  'Event submitted'],
        'event_advanced'      => ['#d97706', 'calendar', 'events',  'Event advanced'],
        'event_approved'      => ['#4caf7d', 'check',    'events',  'Event approved'],
        'event_rejected'      => ['#c0392b', 'x',        'events',  'Event rejected'],
        'event_revision'      => ['#d97706', 'file',     'events',  'Revision requested'],
        'event_reinstated'    => ['#001f45', 'calendar', 'events',  'Event reinstated'],
        'event_published'     => ['#4caf7d', 'check',    'events',  'Event published'],
        'event_unpublished'   => ['#d97706', 'calendar', 'events',  'Event unpublished'],
        'event_deleted'       => ['#c0392b', 'trash',    'events',  'Event deleted'],
        'attendance_recorded' => ['#4caf7d', 'users',    'events',  'Attendance recorded'],

        // ── Annual reports ──────────────────────────────────────────────────
        'report_submitted'    => ['#d97706', 'file',     'reports', 'Report submitted'],
        'report_approved'     => ['#4caf7d', 'check',    'reports', 'Report approved'],
        'report_rejected'     => ['#c0392b', 'x',        'reports', 'Report rejected'],

        // ── Branches / chapters / org charts ────────────────────────────────
        'orgchart_submitted'  => ['#d97706', 'chart',    'network', 'Org chart submitted'],
        'orgchart_requested'  => ['#c8a84b', 'upload',   'network', 'Org chart requested'],
        'orgchart_approved'   => ['#4caf7d', 'check',    'network', 'Org chart approved'],
        'orgchart_rejected'   => ['#c0392b', 'x',        'network', 'Org chart rejected'],
        'orgchart_removed'    => ['#c0392b', 'trash',    'network', 'Org chart removed'],
        'chapter_created'     => ['#001f45', 'building', 'network', 'Chapter created'],

        // ── Budgets ─────────────────────────────────────────────────────────
        'budget_submitted'          => ['#d97706', 'dollar', 'budget', 'Budget submitted'],
        'budget_approved'           => ['#4caf7d', 'dollar', 'budget', 'Budget approved'],
        'budget_rejected'           => ['#c0392b', 'x',      'budget', 'Budget rejected'],
        'budget_receipts_submitted' => ['#d97706', 'file',   'budget', 'Invoices submitted'],
        'budget_reimbursed'         => ['#4caf7d', 'dollar', 'budget', 'Budget reimbursed'],

        // ── Awards ──────────────────────────────────────────────────────────
        'nomination_sent'     => ['#c8a84b', 'award',    'awards',  'Nomination sent'],
        'award_submitted'     => ['#c8a84b', 'award',    'awards',  'Award application'],
        'award_voted'         => ['#5b21b6', 'award',    'awards',  'Award vote'],
    ];

    /** Filterable groupings shown in the activity feed dropdown. */
    const CATEGORIES = [
        'events'  => 'Events',
        'reports' => 'Reports',
        'network' => 'Network',
        'budget'  => 'Budget',
        'awards'  => 'Awards',
    ];

    /** All type keys belonging to a category — used for server-side filtering. */
    public static function typesForCategory(string $category): array
    {
        return array_keys(array_filter(
            self::TYPE_META,
            fn ($meta) => $meta[2] === $category
        ));
    }

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
        return self::TYPE_META[$this->type][0] ?? '#6b7280';
    }

    public function getIconAttribute(): string
    {
        return self::TYPE_META[$this->type][1] ?? 'default';
    }

    public function getCategoryAttribute(): string
    {
        return self::TYPE_META[$this->type][2] ?? 'other';
    }

    public function getLabelAttribute(): string
    {
        return self::TYPE_META[$this->type][3] ?? ucfirst(str_replace('_', ' ', $this->type));
    }

    // ── Factory method ────────────────────────────────────────────────────────

    public static function record(
        ?int $branchId,
        string $type,
        string $title,
        ?int $userId = null,
        ?Model $subject = null,
        ?string $description = '',
        array $metadata = []
    ): self {
        return self::create([
            'branch_id'    => $branchId,
            'user_id'      => $userId,
            'type'         => $type,
            'title'        => $title,
            'description'  => $description ?? '',
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->id,
            'metadata'     => $metadata,
        ]);
    }

    public static function log(string $type, string $message, ?int $branchId = null, ?Model $subject = null): self
    {
        return self::record($branchId, $type, strip_tags($message), auth()->id(), $subject);
    }
}
