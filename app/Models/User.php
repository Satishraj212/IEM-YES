<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password',
        'branch_id', 'member_id', 'role', 'status',
        'faculty', 'phone', 'student_id',
        'avatar_path', 'joined_date', 'cpd_points', 'volunteer_hours', 'current_role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'joined_date'       => 'date',
            'password'          => 'hashed',
            'cpd_points'        => 'integer',
            'volunteer_hours'   => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────────

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function createdEvents(): HasMany
    {
        return $this->hasMany(StudentEvent::class, 'created_by');
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(StudentEventRegistration::class, 'user_id');
    }

    public function nominations(): HasMany
    {
        return $this->hasMany(StudentAwardNomination::class, 'nominated_by');
    }

    public function receivedNominations(): HasMany
    {
        return $this->hasMany(StudentAwardNomination::class, 'nominee_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(StudentAwardVote::class, 'voter_id');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isBranchAdmin(): bool
    {
        return in_array($this->role, ['admin', 'branch_admin']);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar_path
            ? asset('storage/' . $this->avatar_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=c8a84b&color=001030';
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        return strtoupper(
            (isset($words[0]) ? $words[0][0] : '') .
            (isset($words[1]) ? $words[1][0] : '')
        );
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForBranch($query, int $branchId)
    {
        return $query->where('branch_id', $branchId);
    }
}
