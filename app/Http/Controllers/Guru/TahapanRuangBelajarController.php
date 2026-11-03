<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use App\Models\RuangUjian;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TahapanRuangBelajarController extends Controller
{
    private function authorizeGuruAccess($ruang_belajar_id)
    {
        $guruId = Auth::id();

        return RuangBelajar::where('id', $ruang_belajar_id)
            ->where(function ($query) use ($guruId) {
                $query->where('guru_id', $guruId)
                      ->orWhere('user_id', $guruId);
            })
            ->firstOrFail();
    }
    public function index($id)
    {
        $ruangBelajar = $this->authorizeGuruAccess($id);
        $tahapans = Tahapan::where('ruang_belajar_id', $id)
            ->orderBy('urutan', 'asc')
            ->get();
        $countAktif = Tahapan::where('ruang_belajar_id', $id)
            ->where('status', 'aktif')
            ->count();
        $totalXp = Tahapan::where('ruang_belajar_id', $id)->sum('xp_reward');
        $tahapanTerbaru = Tahapan::where('ruang_belajar_id', $id)
            ->latest() 
            ->take(3)   
            ->get();

        return view('guru.tahapan-ruang-belajar.index', compact('ruangBelajar', 'tahapans', 'countAktif', 'totalXp', 'tahapanTerbaru'));
    }
    public function create($ruang_belajar_id)
    {
        $ruangBelajar = $this->authorizeGuruAccess($ruang_belajar_id);
        $ruangBelajar = RuangBelajar::findOrFail($ruang_belajar_id);
        
        $nextUrutan = Tahapan::where('ruang_belajar_id', $ruang_belajar_id)->max('urutan') + 1;

        return view('guru.tahapan-ruang-belajar.create', compact('ruangBelajar', 'nextUrutan'));
    }


    public function store(Request $request, $ruang_belajar_id)
    {
        $ruangBelajar = $this->authorizeGuruAccess($ruang_belajar_id);

        $validated = $request->validate([
            'judul_tahapan' => 'required|string|max:255',

            'tipe' => [
                'required',
                'in:apersepsi,ice_breaking,jeda_hening,pre_test,materi,lkpd,evaluasi,kesimpulan,refleksi,post_test,tindak_lanjut'
            ],

            'urutan' => 'required|integer|min:1',

            'status' => 'required|in:selesai,aktif,terkunci',

            'icon' => 'required|string|max:50',

            'xp_reward' => 'nullable|required_unless:tipe,pre_test,post_test|integer|min:0',
        ]);

        $tipeUjian = in_array($validated['tipe'], [
            'pre_test',
            'post_test'
        ]);

        DB::transaction(function () use ($validated, $ruangBelajar, $tipeUjian) {

            Tahapan::create([
                'ruang_belajar_id' => $ruangBelajar->id,
                'judul_tahapan' => $validated['judul_tahapan'],
                'tipe' => $validated['tipe'],
                'urutan' => $validated['urutan'],
                'status' => $validated['status'],
                'icon' => $validated['icon'],

                // EXP ujian dihitung dari hasil pengerjaan siswa.
                'xp_reward' => $tipeUjian
                    ? 0
                    : ($validated['xp_reward'] ?? 0),

                // Ruang ujian dipilih pada halaman konfigurasi konten.
                'ruang_ujian_id' => null,
            ]);
        });

        return redirect()
            ->route('guru.ruang-belajar.tahapan.index', $ruang_belajar_id)
            ->with('success', 'Tahapan berhasil dibuat! Silakan atur konten aktivitasnya.');
    }
    public function edit($ruang_belajar_id, $tahapan_id)
    {
        $ruangBelajar = $this->authorizeGuruAccess($ruang_belajar_id);

        $tahapan = Tahapan::where('ruang_belajar_id', $ruangBelajar->id)
            ->with('ruangUjian')
            ->findOrFail($tahapan_id);

        return view(
            'guru.tahapan-ruang-belajar.edit',
            compact('ruangBelajar', 'tahapan')
        );
    }
    public function update(Request $request, $ruang_belajar_id, $id)
    {
        $ruangBelajar = $this->authorizeGuruAccess($ruang_belajar_id);

        $tahapan = Tahapan::where('ruang_belajar_id', $ruangBelajar->id)
            ->findOrFail($id);

        $validated = $request->validate([
            'judul_tahapan' => 'required|string|max:255',

            'tipe' => [
                'required',
                'in:apersepsi,ice_breaking,jeda_hening,pre_test,materi,lkpd,evaluasi,kesimpulan,refleksi,post_test,tindak_lanjut'
            ],

            'urutan' => 'required|integer|min:1',

            'status' => 'required|in:selesai,aktif,terkunci',

            'icon' => 'required|string|max:50',

            'xp_reward' => 'nullable|required_unless:tipe,pre_test,post_test|integer|min:0',
        ]);

        $tipeUjian = in_array($validated['tipe'], [
            'pre_test',
            'post_test'
        ]);

        // Pertahankan Ruang Ujian hanya jika tipe tetap berupa ujian.
        $ruangUjianId = $tipeUjian
            ? $tahapan->ruang_ujian_id
            : null;

        // Jika tipe ujian berubah dari aktivitas biasa,
        // guru perlu memasang Ruang Ujian kembali.
        DB::transaction(function () use (
            $tahapan,
            $validated,
            $tipeUjian,
            $ruangUjianId
        ) {
            $tahapan->update([
                'judul_tahapan' => $validated['judul_tahapan'],
                'tipe' => $validated['tipe'],
                'urutan' => $validated['urutan'],
                'status' => $validated['status'],
                'icon' => $validated['icon'],

                'xp_reward' => $tipeUjian
                    ? 0
                    : ($validated['xp_reward'] ?? 0),

                'ruang_ujian_id' => $ruangUjianId,
            ]);
        });

        return redirect()
            ->route('guru.ruang-belajar.tahapan.index', $ruang_belajar_id)
            ->with('success', 'Tahapan pembelajaran berhasil diperbarui!');
    }
    public function destroy($ruangBelajarId, $tahapanId)
    {
        $this->authorizeGuruAccess($ruangBelajarId);
        $tahapan = Tahapan::where('ruang_belajar_id', $ruangBelajarId)
                    ->where('id', $tahapanId)
                    ->firstOrFail();

        $tahapan->delete();

        $tahapansSisa = Tahapan::where('ruang_belajar_id', $ruangBelajarId)
                            ->orderBy('urutan', 'asc')
                            ->get();

        foreach ($tahapansSisa as $index => $item) {
            $item->update(['urutan' => $index + 1]);
        }

        return redirect()->back()->with('success', 'Tahapan pembelajaran berhasil dihapus!');
    }
    public function showKonten($ruang_belajar_id, $tahapan_id)
    {
        $ruangBelajar = RuangBelajar::findOrFail($ruang_belajar_id);
        
        $tahapan = Tahapan::where('ruang_belajar_id', $ruang_belajar_id)
            ->where('id', $tahapan_id)
            ->firstOrFail();
        $viewName = 'guru.tahapan-ruang-belajar.show-' . $tahapan->tipe;

        if (!view()->exists($viewName)) {
            abort(404, 'Halaman detail / rekap untuk tipe aktivitas ini belum tersedia.');
        }

        return view($viewName, compact('ruangBelajar', 'tahapan'));
    }




}
