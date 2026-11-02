<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submateri extends Model
{
    use HasFactory;

    protected $table = 'submateris';

    protected $fillable = [
        'materi_id',
        'judul_sub',
        'deskripsi',
        'tipe',
        'estimasi_waktu',
        'status',
        'konten_builder',
        'xp_reward',
        'urutan',
    ];
    protected $casts = [
        'tipe' => 'array',
        'konten_builder' => 'array',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
    public function progresses()
    {
        return $this->hasMany(
            SubmateriProgress::class,
            'submateri_id'
        );
    }
}
