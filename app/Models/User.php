<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'role',
        'offering',
        'level', 
        'exp',   
        'mood',
        'school_name',
        'grade',
        'major_or_subject',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }
    public function enrolledRuangBelajars()
    {
        return $this->belongsToMany(RuangBelajar::class, 'ruang_belajar_users')
                    ->withPivot('enrolled_at')
                    ->withTimestamps();
    }
    public function enrolledMateris()
    {
        return $this->belongsToMany(Materi::class, 'materi_users', 'user_id', 'materi_id')
                    ->withTimestamps();
    }
    public function submateriProgress()
    {
        return $this->hasMany(SubmateriProgress::class);
    }
    public function tahapanProgress()
    {
        return $this->hasMany(TahapanUser::class, 'user_id');
    }
    public function ruangUjianDibuat()
    {
        return $this->hasMany(RuangUjian::class, 'guru_id');
    }

    // Riwayat pengerjaan ujian siswa
    public function hasilUjian()
    {
        return $this->hasMany(HasilUjian::class, 'user_id');
    }

    // Jawaban ujian siswa
    public function jawabanUjian()
    {
        return $this->hasManyThrough(
            JawabanUjian::class,
            HasilUjian::class,
            'user_id',
            'hasil_ujian_id',
            'id',
            'id'
        );
    }
    public function ruangBelajarDibuat()
    {
        return $this->hasMany(
            RuangBelajar::class,
            'user_id'
        );
    }

    public function ruangBelajarDiajar()
    {
        return $this->hasMany(
            RuangBelajar::class,
            'guru_id'
        );
    }

/**
 * Menghitung total EXP global siswa.
 */
public function totalXp(): int
{
    // 1. EXP Ruang Materi
    $xpMateri = $this->submateriProgress()
        ->whereNotNull('completed_at')
        ->sum('xp_earned');

    // 2. EXP Ruang Belajar biasa
    // Pre-Test dan Post-Test tidak ikut dijumlahkan.
    $xpRuangBelajar = $this->tahapanProgress()
        ->where('status', 'selesai')
        ->whereHas('tahapan', function ($query) {
            $query->whereNotIn('tipe', [
                'pre_test',
                'post_test',
            ]);
        })
        ->sum('exp_didapat');

    // 3. EXP seluruh ujian yang sudah selesai
    $xpUjian = $this->hasilUjian()
        ->where('status', 'selesai')
        ->sum('exp_diperoleh');

    return (int) (
        $xpMateri +
        $xpRuangBelajar +
        $xpUjian
    );
}

}
