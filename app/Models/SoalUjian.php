<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SoalUjian extends Model
{
    use HasFactory;

    protected $table = 'soal_ujians';

    protected $fillable = [
        'ruang_ujian_id',
        'urutan',
        'pertanyaan',
        'tipe',
        'opsi',
        'jawaban_benar',
        'jawaban_acuan',
        'rubrik_penilaian',
        'skor_maksimal',
        'exp',
        'pembahasan',
    ];

    protected $casts = [
        'opsi' => 'array',
        'rubrik_penilaian' => 'array',
        'urutan' => 'integer',
        'exp' => 'integer',
        'skor_maksimal' => 'integer',
    ];

    public function ruangUjian()
    {
        return $this->belongsTo(RuangUjian::class, 'ruang_ujian_id');
    }

    public function jawabanUjian()
    {
        return $this->hasMany(JawabanUjian::class, 'soal_ujian_id');
    }
}
