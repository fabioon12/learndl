<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $siswa = Auth::user();
        $search = $request->get('search');

        $materis = $siswa->enrolledMateris()
            ->with(['guru']) 
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->latest('materi_users.created_at') 
            ->paginate(6)
            ->withQueryString();

        $totalMateriDiambil = $siswa->enrolledMateris()->count();

        return view('siswa.materi.dashboard.index', compact('materis', 'totalMateriDiambil', 'search'));
    }
    public function eksplorasi(Request $request)
    {
        $siswa = Auth::user();
        $search = $request->get('search');

        $materis = Materi::with(['guru'])
            ->withSum(['subMateris as total_xp' => function ($query) {
                $query->where('status', 'terbit');
            }], 'xp_reward')
            ->whereHas('guru', function ($query) use ($siswa) {
                $query->where('school_name', $siswa->school_name);
            })
            ->whereDoesntHave('siswa', function ($query) use ($siswa) {
                $query->where('materi_users.user_id', $siswa->id);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('siswa.materi.eksplorasi.index', compact('materis', 'search'));
    }

    public function ambilMateri(Request $request, $id)
    {
        $siswa = Auth::user();

        // Pastikan materi berasal dari guru di sekolah yang sama.
        $materi = Materi::whereHas('guru', function ($query) use ($siswa) {
                $query->where('school_name', $siswa->school_name);
            })
            ->findOrFail($id);

        // Daftarkan siswa tanpa membuat data pendaftaran ganda.
        $siswa->enrolledMateris()->syncWithoutDetaching([
            $materi->id
        ]);

        return redirect()
            ->route('siswa.ruang-materi.index')
            ->with('success', 'Berhasil mengambil materi! Silakan mulai belajar.');
    }
}
