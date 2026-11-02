<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTahapanProgress extends Model
{
    use HasFactory;

    protected $table = 'user_tahapan_progress';

    protected $fillable = [
        'user_id',
        'tahapan_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class, 'tahapan_id');
    }
}
