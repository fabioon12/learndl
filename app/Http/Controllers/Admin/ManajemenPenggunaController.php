<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ManajemenPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $totalUsersCount = User::count();
        $siswaCount      = User::where('role', 'siswa')->count();
        $guruCount       = User::where('role', 'guru')->count();
        $adminCount      = User::where('role', 'admin')->count();

        $startOfLastMonth = now()->subMonth()->startOfMonth();
        $endOfLastMonth   = now()->subMonth()->endOfMonth();

        $lastMonthTotal = User::where('created_at', '<=', $endOfLastMonth)->count();
        $lastMonthGuru  = User::where('role', 'guru')->where('created_at', '<=', $endOfLastMonth)->count();
        $lastMonthSiswa = User::where('role', 'siswa')->where('created_at', '<=', $endOfLastMonth)->count();
        $lastMonthAdmin = User::where('role', 'admin')->where('created_at', '<=', $endOfLastMonth)->count();

        $calcGrowth = function ($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }
            return round((($current - $previous) / $previous) * 100);
        };

        $totalGrowth = $calcGrowth($totalUsersCount, $lastMonthTotal);
        $guruGrowth  = $calcGrowth($guruCount, $lastMonthGuru);
        $siswaGrowth = $calcGrowth($siswaCount, $lastMonthSiswa);
        $adminGrowth = $calcGrowth($adminCount, $lastMonthAdmin);
        $users = User::query()
        ->when($request->filled('search'), function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        })
            ->when($request->role, fn($q, $v) => $q->where('role', $v))
            ->when($request->grade, fn($q, $v) => $q->where('grade', $v))
            ->when($request->major_or_subject, fn($q, $v) => $q->where('major_or_subject', $v))
            ->when($request->offering, fn($q, $v) => $q->where('offering', $v))
            ->when($request->school_name, fn($q, $v) => $q->where('school_name', $v))
            ->when($request->created_at, function ($q, $v) {
                match ($v) {
                    'today' => $q->whereDate('created_at', now()->today()),
                    'this_week' => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                    'this_month' => $q->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                    'this_year' => $q->whereYear('created_at', now()->year),
                    default => null,
                };
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

            return view('admin.manajemen-pengguna.index', compact(  
                'users', 
                'totalUsersCount', 'siswaCount', 'guruCount', 'adminCount',
                'totalGrowth', 'guruGrowth', 'siswaGrowth', 'adminGrowth'
            ));
    }
    public function create()
    {
        return view('admin.manajemen-pengguna.create');
    }
    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'fullname'         => ['required', 'string', 'max:255'],
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'            => ['nullable', 'string', 'max:20'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
            'role'             => ['required', Rule::in(['siswa', 'guru', 'admin'])],
            'school_name'      => [
                'nullable',
                Rule::in([
                    'SMKN 4 MALANG', 'SMKN 5 MALANG', 'SMKN 6 MALANG',
                    'SMKN 8 MALANG', 'SMKN 9 MALANG', 'SMKN 11 MALANG', 'SMKN 12 MALANG'
                ])
            ],
            'grade'            => ['nullable', Rule::in(['10', '11', '12'])],
            'offering'         => ['nullable', Rule::in(['A', 'B', 'C', 'D'])],
            'major_or_subject' => [
                'nullable',
                Rule::in([
                    'Rekayasa Perangkat Lunak',
                    'Teknik Jaringan Komputer dan Telekomunikasi',
                    'Teknik Jaringan dan Telekomunikasi'
                ])
            ],
        ]);

        // 2. Simpan Data Pengguna Baru
        User::create([
            'fullname'          => $request->fullname,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'password'          => Hash::make($request->password),
            'role'              => $request->role,
            'school_name'       => $request->school_name,
            'grade'             => $request->role === 'siswa' ? $request->grade : null,
            'offering'          => $request->role === 'siswa' ? $request->offering : null,
            'major_or_subject'  => $request->major_or_subject,
            'email_verified_at' => now(), // Otomatis verifikasi akun jika dibuat oleh Admin
        ]);

        return redirect()->route('admin.manajemen-pengguna')
            ->with('success', "Pengguna {$request->fullname} ({$request->role}) berhasil ditambahkan!");
    }
    public function edit(User $user)
    {
        return view('admin.manajemen-pengguna.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullname'    => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'       => ['nullable', 'string', 'max:20'],
            'role'        => ['required', Rule::in(['siswa', 'guru', 'admin'])],
            'school_name' => [
                'nullable',
                Rule::in([
                    'SMKN 4 MALANG', 'SMKN 5 MALANG', 'SMKN 6 MALANG',
                    'SMKN 8 MALANG', 'SMKN 9 MALANG', 'SMKN 11 MALANG', 'SMKN 12 MALANG'
                ])
            ],
            'grade'            => ['nullable', Rule::in(['10', '11', '12'])],
            'offering'         => ['nullable', Rule::in(['A', 'B', 'C', 'D'])],
            'major_or_subject' => [
                'nullable',
                Rule::in([
                    'Rekayasa Perangkat Lunak',
                    'Teknik Jaringan Komputer dan Telekomunikasi',
                    'Teknik Jaringan dan Telekomunikasi'
                ])
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], 
        ]);

        $data = [
            'fullname'         => $request->fullname,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'role'             => $request->role,
            'school_name'      => $request->school_name,
            'grade'            => $request->role === 'siswa' ? $request->grade : null,
            'offering'         => $request->role === 'siswa' ? $request->offering : null,
            'major_or_subject' => $request->major_or_subject,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.manajemen-pengguna')->with('success', "Data pengguna {$user->fullname} berhasil diperbarui!");
    }
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $userName = $user->fullname;
        $user->delete();

        return redirect()->route('admin.manajemen-pengguna')->with('success', "Pengguna {$userName} berhasil dihapus.");
    }
}
