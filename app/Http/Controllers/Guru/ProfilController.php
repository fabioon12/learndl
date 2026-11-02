<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('guru.profil.index');
    }
    public function updateProfil(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'fullname'         => ['required', 'string', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'school_name' => [
                'nullable',
                'string',
                Rule::in([
                    'SMKN 4 MALANG',
                    'SMKN 5 MALANG',
                    'SMKN 6 MALANG',
                    'SMKN 8 MALANG',
                    'SMKN 9 MALANG',
                    'SMKN 11 MALANG',
                    'SMKN 12 MALANG',
                ]),
            ],
            'major_or_subject' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Biodata profil berhasil diperbarui.');
    }
    public function updatePassword(Request $request)
    {

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

}
