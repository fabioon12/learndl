<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login.index');
    }

    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {$request->session()->regenerate();

            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Selamat datang di Panel Admin, ' . $user->fullname . '!');
            }

            if ($user->isGuru()) {
                return redirect()->intended(route('guru.dashboard'))
                    ->with('success', 'Selamat datang kembali, Bapak/Ibu ' . $user->fullname . '!');
            }

            $request->session()->flash('show_mood_modal', true);

            return redirect()->intended(route('siswa.dashboard'))
                ->with('success', 'Selamat datang kembali, ' . $user->fullname . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
