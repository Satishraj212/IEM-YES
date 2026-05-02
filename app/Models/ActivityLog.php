<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'message', 'dot_color', 'dot_icon', 'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public static function log(
        string $type,
        string $message,
        string $dotColor = 'var(--navy)',
        string $dotIcon = '<circle cx="12" cy="12" r="3"/>'
    ): self {
        return static::create(compact('type', 'message', 'dotColor', 'dotIcon'));
    }

    public function getIsUnreadAttribute(): bool
    {
        return is_null($this->read_at);
    }
}