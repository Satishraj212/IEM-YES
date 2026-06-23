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
        'description', 'logo_path', 'org_chart_path', 'org_chart_requested_at',
        'member_count', 'new_members_this_month',
    ];

    protected $casts = [
        'is_active'              => 'boolean',
        'pledge_active'          => 'boolean',
        'year_founded'           => 'integer',
        'ranking'                => 'integer',
        'member_count'           => 'integer',
        'new_members_this_month' => 'integer',
        'org_chart_requested_at' => 'datetime',
    ];

    /**
     * Real student chapters (have a code + institution),
     * excluding the state-aggregate placeholder rows.
     */
    public function scopeChapters(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->whereNotNull('code')->where('code', '!=', '')
                     ->whereNotNull('institution')->where('institution', '!=', '');
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function adminUser(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'branch_id')->where('role', 'branch_admin');
    }

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

    public function membershipSnapshots(): HasMany
    {
        return $this->hasMany(BranchMembershipSnapshot::class, 'branch_id')->orderBy('as_of');
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

    public function orgCharts(): HasMany
    {
        return $this->hasMany(BranchOrgChart::class, 'branch_id')->orderByDesc('created_at');
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

    /**
     * Canonical chapter identity shown wherever a chapter action is tagged
     * (event review, budget requests, activity feed, dashboard).
     * Primary label — falls back to the code, then a placeholder.
     */
    public function getIdentityNameAttribute(): string
    {
        return $this->name ?: $this->code ?: 'Unknown Chapter';
    }

    /** Secondary identity line — the full institution this chapter belongs to. */
    public function getIdentityInstitutionAttribute(): ?string
    {
        return $this->institution ?: $this->location ?: null;
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query)
    {
        return $query->where('status', 'active');
    }
}
