<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmateriProgress extends Model
{
     protected $table = 'submateri_progress';

    protected $fillable = [
        'user_id',
        'submateri_id',
        'xp_earned',
        'completed_at',
    ];

    protected $casts = [
        'xp_earned' => 'integer',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function submateri(): BelongsTo
    {
        return $this->belongsTo(Submateri::class);
    }
}
