<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'state', 'color', 'member_count',
        'new_members_this_month', 'is_active',
    ];

    protected $casts = [
        'member_count'           => 'integer',
        'new_members_this_month' => 'integer',
        'is_active'              => 'boolean',
    ];

    // ── Relationships ──

    public function officialEvents()
    {
        return $this->hasMany(OfficialEvent::class);
    }

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
