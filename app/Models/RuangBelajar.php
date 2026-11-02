<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RuangBelajar extends Model
{
    use HasFactory;

    protected $table = 'ruang_belajars';

    protected $fillable = [
        'user_id',
        'guru_id',
        'judul',
        'mapel',
        'kelas',
        'thumbnail',
        'deskripsi',
        'target_schools',
    ];
    protected $casts = [
        'target_schools' => 'array',
    ];

    /**
     * Relasi balik ke model User (Guru Pengajar)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    public function siswa()
    {
        return $this->belongsToMany(User::class, 'ruang_belajar_users', 'ruang_belajar_id', 'user_id')
                    ->withTimestamps();
    }
    public function tahapans()
    {
        return $this->hasMany(Tahapan::class)->orderBy('urutan', 'asc');
    }
    /* End */
}
