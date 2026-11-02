<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register.index');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname'    => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'       => ['required', 'string', 'max:20'],
            'role'        => ['required', Rule::in(['siswa', 'guru'])],
            'school_name' => [
                'required',
                Rule::in([
                    'SMKN 4 MALANG',
                    'SMKN 5 MALANG',
                    'SMKN 6 MALANG',
                    'SMKN 8 MALANG',
                    'SMKN 9 MALANG',
                    'SMKN 11 MALANG',
                    'SMKN 12 MALANG',
                ])
            ],
            'grade'       => ['required_if:role,siswa', 'nullable', Rule::in(['10', '11', '12'])],
            'major'       => ['required_if:role,siswa', 'nullable', Rule::in([
                'Rekayasa Perangkat Lunak',
                'Teknik Jaringan Komputer dan Telekomunikasi'
            ])],
            'offering'    => ['required_if:role,siswa', 'nullable', Rule::in(['A', 'B', 'C', 'D'])],
            'subject'     => ['required_if:role,guru', 'nullable', Rule::in([
                'Rekayasa Perangkat Lunak',
                'Teknik Jaringan dan Telekomunikasi'
            ])],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'fullname'         => $request->fullname,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'role'             => $request->role,
            'school_name'      => $request->school_name,
            'grade'            => $request->role === 'siswa' ? $request->grade : null,
            'offering'         => $request->role === 'siswa' ? $request->offering : null,
            'major_or_subject' => $request->role === 'siswa' ? $request->major : $request->subject,
            'password'         => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        if ($user->isGuru()) {
            return redirect()->route('guru.dashboard')->with('success', 'Registrasi berhasil! Selamat datang, Bapak/Ibu Guru.');
        }

        return redirect()->route('siswa.dashboard')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}
