<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAwardVote extends Model
{
    protected $table = 'award_votes';

    protected $fillable = [
        'award_category_id', 'voter_id', 'nomination_id', 'voted_at',
    ];

    protected $casts = [
        'voted_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(StudentAwardCategory::class, 'award_category_id');
    }

    public function voter(): BelongsTo
    {
        return $this->belongsTo(StudentMember::class, 'voter_id');
    }

    public function nomination(): BelongsTo
    {
        return $this->belongsTo(StudentAwardNomination::class, 'nomination_id');
    }
}
