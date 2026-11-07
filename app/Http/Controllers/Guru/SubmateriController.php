<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Submateri;

class SubmateriController extends Controller
{
    public function index($id)
    {
        $materi = Materi::with('subMateris')->findOrFail($id);
        return view('guru.materi.submateri.index', compact('materi'));
    }
    public function create($materi_id)
    {
        $materi = Materi::findOrFail($materi_id);
        return view('guru.materi.submateri.create', compact('materi'));
    }

    public function store(Request $request, $materi_id)
    {
        $request->validate([
            'judul_sub'      => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'tipe'           => 'required|array|min:1|max:6',
            'estimasi_waktu' => 'required|string',
            'xp_reward'      => 'required|integer|min:0',
            'status'         => 'required|in:terbit,draft',
            'urutan'         => 'nullable|integer',
        ]);

        $materi = Materi::findOrFail($materi_id);
        $urutanTerakhir = $materi->submateris()->max('urutan') ?? 0;

        Submateri::create([
            'materi_id'      => $materi->id,
            'judul_sub'      => $request->judul_sub,
            'deskripsi'      => $request->deskripsi,
            'tipe'           => $request->tipe,
            'estimasi_waktu' => $request->estimasi_waktu,
            'xp_reward'      => $request->xp_reward ?? 25,
            'status'         => $request->status,
            'urutan'         => $request->urutan ?? ($urutanTerakhir + 1),
        ]);

        return redirect()->route('guru.materi.submateri.index', $materi->id)
                         ->with('success', 'Sub-materi berhasil ditambahkan!');
    }
    public function edit($materi_id, $id)
    {
        $materi = Materi::findOrFail($materi_id);
        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($id);

        return view('guru.materi.submateri.edit', compact('materi', 'submateri'));
    }

    /**
     * Memperbarui Data Sub-Materi di Database
     */
    public function update(Request $request, $materi_id, $id)
    {
        $request->validate([
            'judul_sub'      => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'tipe'           => 'required|array|min:1|max:6',
            'tipe.*'         => 'in:video,teks,interaktif,praktik,latihan,coding_project',
            'estimasi_waktu' => 'required|string',
            'xp_reward'      => 'required|integer|min:0',
            'status'         => 'required|in:terbit,draft',
            'urutan'         => 'nullable|integer',
        ]);

        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($id);

        $submateri->update([
            'judul_sub'      => $request->judul_sub,
            'deskripsi'      => $request->deskripsi,
            'tipe'           => $request->tipe,
            'estimasi_waktu' => $request->estimasi_waktu,
            'xp_reward'      => $request->xp_reward,
            'status'         => $request->status,
            'urutan'         => $request->urutan ?? $submateri->urutan,
        ]);

        return redirect()->route('guru.materi.submateri.index', $materi_id)
                        ->with('success', 'Sub-materi berhasil diperbarui!');
    }
    public function destroy($materi_id, $id)
    {
        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($id);
        
        $submateri->delete();

        return redirect()->route('guru.materi.submateri.index', $materi_id)
                        ->with('success', 'Sub-materi berhasil dihapus!');
    }
}
