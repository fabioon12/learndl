<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RuangUjian extends Model
{
    use HasFactory;

    protected $table = 'ruang_ujians';

    protected $fillable = [
        'guru_id',
        'judul',
        'deskripsi',
        'durasi_menit',
        'maksimal_percobaan',
        'acak_soal',
        'acak_jawaban',
        'status',
    ];

    protected $casts = [
        'durasi_menit' => 'integer',
        'maksimal_percobaan' => 'integer',
        'acak_soal' => 'boolean',
        'acak_jawaban' => 'boolean',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function soal()
    {
        return $this->hasMany(SoalUjian::class, 'ruang_ujian_id')
            ->orderBy('urutan');
    }

    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class, 'ruang_ujian_id');
    }

    public function tahapans()
    {
        return $this->hasMany(Tahapan::class, 'ruang_ujian_id');
    }

    // Total EXP maksimal dari seluruh soal
    public function getTotalExpAttribute()
    {
        return (int) $this->soal()->sum('exp');
    }

    // Total soal
    public function getTotalSoalAttribute()
    {
        return $this->soal()->count();
    }
}
