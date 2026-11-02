<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'fullname'         => 'Administrator System',
            'email'            => 'admin@learndl.id',
            'phone'            => '081234567890',
            'role'             => 'admin',
            'school_name'      => null,
            'grade'            => null,
            'offering'         => null,
            'major_or_subject' => null,
            'password'         => Hash::make('password123'),
        ]);

        User::create([
            'fullname'         => 'Budi Santoso, S.Kom',
            'email'            => 'guru@smkn4malang.sch.id',
            'phone'            => '081234567891',
            'role'             => 'guru',
            'school_name'      => 'SMKN 4 MALANG',
            'grade'            => null,
            'offering'         => null,
            'major_or_subject' => 'Rekayasa Perangkat Lunak',
            'password'         => Hash::make('password123'),
        ]);

        User::create([
            'fullname'         => 'Siti Aminah',
            'email'            => 'siswa@smkn4malang.sch.id',
            'phone'            => '081234567892',
            'role'             => 'siswa',
            'school_name'      => 'SMKN 4 MALANG',
            'grade'            => '11',
            'offering'         => 'A',
            'major_or_subject' => 'Rekayasa Perangkat Lunak',
            'password'         => Hash::make('password123'),
        ]);
        User::create([
            'fullname'         => 'Ahmad Fuad Zain',
            'email'            => 'siswa@smpn8malang.sch.id',
            'phone'            => '081234567892',
            'role'             => 'siswa',
            'school_name'      => 'SMPN 8 MALANG',
            'grade'            => '11',
            'offering'         => 'A',
            'major_or_subject' => 'Rekayasa Perangkat Lunak',
            'password'         => Hash::make('password123'),
        ]);

        $sekolahList = [
            'SMKN 4 MALANG',
            'SMKN 5 MALANG',
            'SMKN 6 MALANG',
            'SMKN 8 MALANG',
            'SMKN 9 MALANG',
            'SMKN 11 MALANG',
            'SMKN 12 MALANG',
            'SMPN 8 MALANG',
        ];

        foreach ($sekolahList as $sekolah) {
            User::factory()->create([
                'fullname'         => 'Guru ' . $sekolah,
                'email'            => 'guru.' . strtolower(str_replace(' ', '', $sekolah)) . '@example.com',
                'role'             => 'guru',
                'school_name'      => $sekolah,
                'major_or_subject' => 'Rekayasa Perangkat Lunak',
                'password'         => Hash::make('password123'),
            ]);


            User::factory()->create([
                'fullname'         => 'Siswa ' . $sekolah,
                'email'            => 'siswa.' . strtolower(str_replace(' ', '', $sekolah)) . '@example.com',
                'role'             => 'siswa',
                'school_name'      => $sekolah,
                'grade'            => '10',
                'offering'         => 'A',
                'major_or_subject' => 'Rekayasa Perangkat Lunak',
                'password'         => Hash::make('password123'),
            ]);
        }
    }
}
