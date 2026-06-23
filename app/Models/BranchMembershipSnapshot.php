<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BranchMembershipSnapshot extends Model
{
    protected $table = 'branch_membership_snapshots';

    protected $fillable = ['branch_id', 'as_of', 'member_count', 'new_members', 'recorded_by'];

    protected $casts = [
        'as_of'        => 'date',
        'member_count' => 'integer',
        'new_members'  => 'integer',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function getLabelAttribute(): string
    {
        return $this->as_of->format('M Y');
    }
}
