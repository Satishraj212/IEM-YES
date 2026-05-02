<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficialEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'location', 'start_date', 'end_date',
        'status', 'total_seats', 'registered_count', 'branch_id',
        'organiser', 'tags', 'is_published', 'description', 'admin_notes', 'poster_url',
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

    public function getSeatPercentageAttribute(): int
    {
        if (!$this->total_seats || $this->total_seats === 0) return 0;
        return (int) round($this->registered_count / $this->total_seats * 100);
    }

    public function getIsFullAttribute(): bool
    {
        return $this->total_seats && $this->registered_count >= $this->total_seats;
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
