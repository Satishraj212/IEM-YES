<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'name', 'chapter', 'chapter_name', 'institution',
        'location', 'state', 'color',
        'year_founded', 'academic_year',
        'status', 'is_active', 'pledge_active', 'ranking',
        'description', 'logo_path', 'org_chart_path',
        'member_count', 'new_members_this_month',
    ];

    protected $casts = [
        'is_active'              => 'boolean',
        'pledge_active'          => 'boolean',
        'year_founded'           => 'integer',
        'ranking'                => 'integer',
        'member_count'           => 'integer',
        'new_members_this_month' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    public function activeMembers(): HasMany
    {
        return $this->hasMany(User::class, 'branch_id')->where('status', 'active');
    }

    public function events(): HasMany
    {
        return $this->hasMany(StudentEvent::class, 'branch_id');
    }

    public function officialEvents(): HasMany
    {
        return $this->hasMany(OfficialEvent::class, 'branch_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'branch_id');
    }

    public function annualReports(): HasMany
    {
        return $this->hasMany(AnnualReport::class, 'branch_id');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getOrgChartUrlAttribute(): ?string
    {
        return $this->org_chart_path
            ? asset('storage/' . $this->org_chart_path)
            : null;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path
            ? asset('storage/' . $this->logo_path)
            : null;
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
