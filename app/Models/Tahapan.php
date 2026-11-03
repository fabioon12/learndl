<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Tahapan extends Model
{
    use HasFactory;

    protected $table = 'tahapans';

    protected $fillable = [
        'ruang_belajar_id',
        'ruang_materi_id',
        'ruang_ujian_id',
        'judul_tahapan',
        'urutan',
        'status',
        'icon',
        'tipe',
        'xp_reward',
        'konten',
    ];

    protected $casts = [
        'konten' => 'array',
    ];

    /**
     * Relasi ke RuangBelajar (Parent)
     */
    public function ruangBelajar()
    {
        return $this->belongsTo(RuangBelajar::class, 'ruang_belajar_id');
    }
    public function userProgress()
    {
        return $this->hasMany(TahapanUser::class, 'tahapan_id');
    }
    public function ruangUjian()
    {
        return $this->belongsTo(RuangUjian::class, 'ruang_ujian_id');
    }

    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class, 'tahapan_id');
    }
    public function ruangMateri()
    {
        return $this->belongsTo(Materi::class, 'ruang_materi_id');
    }
}
