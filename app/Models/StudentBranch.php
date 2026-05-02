<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentBranch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'branches';

    protected $fillable = [
        'code', 'name', 'chapter', 'institution', 'location',
        'year_founded', 'academic_year', 'status', 'pledge_active',
        'ranking', 'chapter_name', 'description', 'logo_path', 'org_chart_path',
    ];

    protected $casts = [
        'pledge_active' => 'boolean',
        'year_founded'  => 'integer',
        'ranking'       => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function members(): HasMany
    {
        return $this->hasMany(StudentMember::class, 'branch_id');
    }

    public function activeMembers(): HasMany
    {
        return $this->hasMany(StudentMember::class, 'branch_id')->where('status', 'active');
    }

    public function events(): HasMany
    {
        return $this->hasMany(StudentEvent::class, 'branch_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(StudentActivityLog::class, 'branch_id');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getTotalMembersAttribute(): int
    {
        return $this->members()->count();
    }

    public function getActiveMembersCountAttribute(): int
    {
        return $this->activeMembers()->count();
    }

    public function getTotalEventsAttribute(): int
    {
        return $this->events()->count();
    }

    public function getSdgEventsCountAttribute(): int
    {
        return $this->events()->where('is_sdg', true)->count();
    }

    public function getOrgChartUrlAttribute(): ?string
    {
        return $this->org_chart_path
            ? asset('storage/' . $this->org_chart_path)
            : null;
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
