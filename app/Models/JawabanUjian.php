<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JawabanUjian extends Model
{
        use HasFactory;

    protected $table = 'jawaban_ujians';

    protected $fillable = [
        'hasil_ujian_id',
        'soal_ujian_id',
        'jawaban_siswa',
        'benar',
        'exp_diperoleh',

        // Penilaian esai
        'skor_esai',
        'catatan_guru',
        'dinilai_pada',
    ];

    protected $casts = [
        'benar' => 'boolean',
        'exp_diperoleh' => 'integer',
        'skor_esai' => 'decimal:2',
        'dinilai_pada' => 'datetime',
    ];

    public function hasilUjian()
    {
        return $this->belongsTo(
            HasilUjian::class,
            'hasil_ujian_id'
        );
    }

    public function soal()
    {
        return $this->belongsTo(
            SoalUjian::class,
            'soal_ujian_id'
        );
    }
}
