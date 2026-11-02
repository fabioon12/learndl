<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahapanUser extends Model
{
    use HasFactory;

    protected $table = 'tahapan_users';

    protected $fillable = [
        'user_id',
        'tahapan_id',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class);
    }
}
