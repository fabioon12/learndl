<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MateriUser extends Model
{
    use HasFactory;

    protected $table = 'materi_users';

    protected $fillable = [
        'user_id',
        'materi_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
}
