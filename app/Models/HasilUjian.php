<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilUjian extends Model
{
     use HasFactory;

    protected $table = 'hasil_ujians';

    protected $fillable = [
        'ruang_ujian_id',
        'user_id',
        'tahapan_id',
        'total_soal',
        'jumlah_benar',
        'jumlah_salah',
        'nilai',
        'exp_diperoleh',
        'status',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'total_soal' => 'integer',
        'jumlah_benar' => 'integer',
        'jumlah_salah' => 'integer',
        'nilai' => 'decimal:2',
        'exp_diperoleh' => 'integer',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function ruangUjian()
    {
        return $this->belongsTo(RuangUjian::class, 'ruang_ujian_id');
    }
    

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class, 'tahapan_id');
    }

    public function jawaban()
    {
        return $this->hasMany(JawabanUjian::class, 'hasil_ujian_id');
    }
}
