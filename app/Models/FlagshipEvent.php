<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlagshipEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_name', 'full_name', 'year', 'event_date',
        'location', 'host', 'expected_delegates', 'status', 'is_published',
        'theme', 'description', 'content', 'content_blocks', 'registration_url', 'stats',
    ];

    protected $casts = [
        'year'                => 'integer',
        'expected_delegates'  => 'integer',
        'is_published'        => 'boolean',
        'stats'               => 'array',
        'content_blocks'      => 'array',
    ];

    public function scopePublished(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Edition-number base year per category, calibrated so that
     * (year − base) yields the correct edition number
     * (e.g. CAFEO 2025 → 42, NATSUM 2025 → 30).
     * Used only when stats['edition'] is not set explicitly.
     */
    const FOUNDING_YEAR = [
        'NATSUM' => 1995,
        'CAFEO'  => 1983,
    ];

    /**
     * A single per-edition stat value, e.g. stat('universities').
     */
    public function stat(string $key, $default = null)
    {
        $stats = is_array($this->stats) ? $this->stats : [];
        return $stats[$key] ?? $default;
    }

    /**
     * Edition number — explicit stats['edition'] wins, else computed from the
     * category's founding year (e.g. NATSUM 2025 → 31st since 1995).
     */
    public function getEditionNumberAttribute(): ?int
    {
        $explicit = $this->stat('edition');
        if (!empty($explicit) && is_numeric($explicit)) {
            return (int) $explicit;
        }
        $base = self::FOUNDING_YEAR[strtoupper($this->short_name)] ?? null;
        return $base ? ($this->year - $base) : null;
    }

    /**
     * Ordinal suffix for the edition number (1st, 2nd, 3rd, 42nd…).
     */
    public function getEditionOrdinalAttribute(): ?string
    {
        $n = $this->edition_number;
        if ($n === null) return null;
        $mod100 = $n % 100;
        $suffix = ($mod100 >= 11 && $mod100 <= 13) ? 'th'
            : match ($n % 10) { 1 => 'st', 2 => 'nd', 3 => 'rd', default => 'th' };
        return $n . $suffix;
    }

    // ── Scopes ──

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->whereIn('status', ['planning', 'upcoming', 'open']);
    }
}
