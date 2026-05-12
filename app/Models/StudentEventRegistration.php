<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentEventRegistration extends Model
{
    protected $table = 'event_registrations';

    protected $fillable = [
        'event_id', 'user_id', 'status',
        'registered_at', 'attended_at', 'notes',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'attended_at'   => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(StudentEvent::class, 'event_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
