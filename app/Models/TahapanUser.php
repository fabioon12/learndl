<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TahapanUser extends Model
{
    protected $table = 'tahapan_users';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'tahapan_id',
        'status',
        'completed_at',
        'exp_didapat',
        'jawaban',
    ];

    protected $casts = [
        'exp_didapat' => 'integer',
        'jawaban' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function tahapan()
    {
        return $this->belongsTo(
            Tahapan::class,
            'tahapan_id'
        );
    }
}
