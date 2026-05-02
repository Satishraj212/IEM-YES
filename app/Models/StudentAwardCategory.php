<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentAwardCategory extends Model
{
    use HasFactory;

    protected $table = 'award_categories';

    protected $fillable = [
        'slug', 'name', 'icon', 'description', 'criteria', 'ribbon_css',
        'status', 'nominations_open_date', 'nominations_close_date',
        'voting_open_date', 'voting_close_date', 'ceremony_date',
        'cycle_year', 'allow_self_apply', 'allow_nominations',
    ];

    protected $casts = [
        'criteria'               => 'array',
        'nominations_open_date'  => 'date',
        'nominations_close_date' => 'date',
        'voting_open_date'       => 'date',
        'voting_close_date'      => 'date',
        'ceremony_date'          => 'date',
        'allow_self_apply'       => 'boolean',
        'allow_nominations'      => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function nominations(): HasMany
    {
        return $this->hasMany(StudentAwardNomination::class, 'award_category_id');
    }

    public function finalists(): HasMany
    {
        return $this->hasMany(StudentAwardNomination::class, 'award_category_id')
                    ->whereIn('status', ['shortlisted', 'finalist', 'winner']);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(StudentAwardVote::class, 'award_category_id');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getNominationCountAttribute(): int
    {
        return $this->nominations()->count();
    }

    public function getFinalistCountAttribute(): int
    {
        return $this->finalists()->count();
    }

    // ── Status helpers ────────────────────────────────────────────────────────

    public function isNominationsOpen(): bool
    {
        return $this->status === 'nominations_open';
    }

    public function isVotingActive(): bool
    {
        return $this->status === 'voting_active';
    }
}
