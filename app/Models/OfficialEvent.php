<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficialEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'location', 'start_date', 'end_date', 'start_time',
        'status', 'total_seats', 'registered_count', 'branch_id',
        'organiser', 'organiser_phone', 'tags', 'is_published', 'description', 'admin_notes', 'poster_url',
    ];

    protected $casts = [
        'start_date'       => 'date',
        'end_date'         => 'date',
        'tags'             => 'array',
        'is_published'     => 'boolean',
        'total_seats'      => 'integer',
        'registered_count' => 'integer',
    ];

    // ── Relationships ──

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    // ── Accessors ──

    public function getBranchNameAttribute(): string
    {
        return $this->branch?->name ?? 'National';
    }

    public function getEffectiveStatusAttribute(): string
    {
        $cutoff = $this->end_date ?? $this->start_date;
        if ($cutoff && $cutoff->lt(today())) {
            return 'past';
        }
        return $this->is_published ? 'open' : 'upcoming';
    }

    public function getPosterSrcAttribute(): ?string
    {
        return $this->poster_url
            ? asset('storage/' . $this->poster_url)
            : null;
    }

    public function getSeatPercentageAttribute(): int
    {
        if (!$this->total_seats || $this->total_seats === 0) return 0;
        return (int) round($this->registered_count / $this->total_seats * 100);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->total_seats && $this->registered_count >= $this->total_seats;
    }

    // ── Static helpers ──

    public static function syncStatus(): int
    {
        $notPast = fn ($q) => $q
            ->where(fn ($i) => $i->whereNotNull('end_date')->whereDate('end_date', '>=', today()))
            ->orWhere(fn ($i) => $i->whereNull('end_date')->whereDate('start_date', '>=', today()));

        $isPast = fn ($q) => $q
            ->where(fn ($i) => $i->whereNotNull('end_date')->whereDate('end_date', '<', today()))
            ->orWhere(fn ($i) => $i->whereNull('end_date')->whereDate('start_date', '<', today()));

        // Date passed → past (regardless of published state)
        $a = static::whereIn('status', ['open', 'upcoming'])->where($isPast)->update(['status' => 'past']);
        // Live + date not passed → open
        $b = static::where('is_published', true)->where('status', '!=', 'past')->where($notPast)->update(['status' => 'open']);
        // Draft + date not passed → upcoming
        $c = static::where('is_published', false)->where('status', '!=', 'past')->where($notPast)->update(['status' => 'upcoming']);

        return $a + $b + $c;
    }

    // ── Scopes ──

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear('start_date', now()->year);
    }
}
