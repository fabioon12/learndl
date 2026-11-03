<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'thumbnail',
    ];

    /**
     * Relasi ke Guru / User pembuat materi
     */
    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subMateris()
    {
        return $this->hasMany(Submateri::class, 'materi_id')->orderBy('urutan', 'asc');
    }
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'materi_users',
            'materi_id',
            'user_id'
        )->withTimestamps();
    }

    // Alias relasi siswa
    public function siswa()
    {
        return $this->users();
    }

}
