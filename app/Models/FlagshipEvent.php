<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlagshipEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_name', 'full_name', 'year', 'event_date',
        'location', 'host', 'expected_delegates', 'status',
    ];

    protected $casts = [
        'year'                => 'integer',
        'expected_delegates'  => 'integer',
    ];

    // ── Scopes ──

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['planning', 'upcoming', 'open']);
    }
}
