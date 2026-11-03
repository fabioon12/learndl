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
    ];

    protected $casts = [
        'benar' => 'boolean',
        'exp_diperoleh' => 'integer',
    ];

    public function hasilUjian()
    {
        return $this->belongsTo(HasilUjian::class, 'hasil_ujian_id');
    }

    public function soal()
    {
        return $this->belongsTo(SoalUjian::class, 'soal_ujian_id');
    }
}
