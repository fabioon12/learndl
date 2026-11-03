<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use Illuminate\Support\Facades\Auth;
use App\Models\UserTahapanProgress;

class RuangbelajarController extends Controller
{
    public function dashboard(Request $request)
    {
        $siswa = Auth::user();

        $classList = $siswa->enrolledRuangBelajars()
            ->with(['guru', 'user', 'tahapans']) // <-- Tambahkan 'user' di sini
            ->withCount('tahapans as materi_count')
            ->latest('ruang_belajar_users.created_at')
            ->get()
            ->map(function ($ruangBelajar) use ($siswa) {
                $completedCount = $ruangBelajar->tahapans->filter(function ($tahapan) use ($siswa) {
                    return $tahapan->userProgress()
                        ->where('user_id', $siswa->id)
                        ->where('status', 'selesai')
                        ->exists();
                })->count();

                $totalTahapan = $ruangBelajar->tahapans->count();
                $progressPercent = $totalTahapan > 0 ? round(($completedCount / $totalTahapan) * 100) : 0;

                $ruangBelajar->completed_materi_count = $completedCount;
                $ruangBelajar->pivot->progress_percent = $progressPercent;

                return $ruangBelajar;
        });

        return view('siswa.ruang-belajar.dashboard.index', compact('classList'));
    }
    public function eksplorasi(Request $request)
    {
        $siswa = Auth::user();

        $query = RuangBelajar::with(['user', 'guru'])
            ->where(function ($q) use ($siswa) {
                $q->whereJsonContains('target_schools', $siswa->school_name)
                ->orWhereHas('guru', function ($guruQuery) use ($siswa) {
                    $guruQuery->where('school_name', $siswa->school_name);
                })
                ->orWhereHas('user', function ($userQuery) use ($siswa) {
                    $userQuery->where('school_name', $siswa->school_name);
                });
            })
            ->whereDoesntHave('siswa', function ($q) use ($siswa) {
                $q->where('ruang_belajar_users.user_id', $siswa->id);
            });

        // Filter Pencarian Judul
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        // Filter Mapel
        if ($request->filled('mapel')) {
            $query->where('mapel', $request->mapel);
        }

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $ruangBelajars = $query->latest()->get();

        // Stats yang relevan sesuai target sekolah siswa
        $stats = [
            'total_ruang' => RuangBelajar::whereJsonContains('target_schools', $siswa->school_name)
                ->orWhereHas('guru', function ($q) use ($siswa) {
                    $q->where('school_name', $siswa->school_name);
                })->count(),
            'ruang_aktif' => $ruangBelajars->count(),
            'total_mapel' => RuangBelajar::whereJsonContains('target_schools', $siswa->school_name)
                ->distinct('mapel')->count('mapel'),
            'guru_aktif'  => RuangBelajar::whereJsonContains('target_schools', $siswa->school_name)
                ->distinct('guru_id')->count('guru_id'),
        ];

        return view('siswa.ruang-belajar.eksplorasi.index', compact('ruangBelajars', 'stats'));
    }
    

    public function enroll($id)
    {
        $siswa = Auth::user();
        $ruangBelajar = RuangBelajar::with('tahapans')->findOrFail($id);

        if ($siswa->enrolledRuangBelajars()->where('ruang_belajar_id', $id)->exists()) {
            return redirect()->back()->with('info', 'Kamu sudah terdaftar di Ruang Belajar ini!');
        }

        $siswa->enrolledRuangBelajars()->attach($id);

        foreach ($ruangBelajar->tahapans as $tahapan) {
            $statusInitial = ($tahapan->urutan == 1) ? 'aktif' : 'terkunci';

            UserTahapanProgress::create([
                'user_id' => $siswa->id,
                'tahapan_id' => $tahapan->id,
                'status' => $statusInitial,
            ]);
        }

        return redirect()->route('siswa.ruang-belajar.dashboard')
            ->with('success', 'Berhasil bergabung dengan Ruang Belajar!');
    }

}
