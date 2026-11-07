<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuangBelajarUser extends Model
{
    protected $table = 'ruang_belajar_users';

    protected $fillable = [
        'user_id',
        'ruang_belajar_id',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ruangBelajar()
    {
        return $this->belongsTo(RuangBelajar::class, 'ruang_belajar_id');
    }
}
