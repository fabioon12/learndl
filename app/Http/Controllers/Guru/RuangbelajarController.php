<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RuangbelajarController extends Controller
{
    public function index(Request $request)
    {
        $selectedKelas = $request->get('kelas');
        $search = $request->get('search');
        $userId = Auth::id();
        
        $totalRuangBelajar = RuangBelajar::where(function ($q) use ($userId) {
            $q->where('user_id', $userId)
            ->orWhere('guru_id', $userId);
        })->count();

        $ruangBelajars = RuangBelajar::with(['user', 'guru', 'siswa']) 
                ->withCount('siswa', 'tahapans') 
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('guru_id', $userId);
                })
                ->when($selectedKelas, function ($query, $kelas) {
                    return $query->where('kelas', $kelas);
                })
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('judul', 'like', '%' . $search . '%')
                        ->orWhere('mapel', 'like', '%' . $search . '%');
                    });
                })
                ->latest()
                ->paginate(6)
                ->withQueryString();

        return view('guru.ruang-belajar.index', compact('ruangBelajars', 'totalRuangBelajar', 'selectedKelas', 'search'));
    }
    public function create()
    {
        return view('guru.ruang-belajar.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'mapel'     => 'required|string|max:255',
            'kelas'     => 'required|string|in:X,XI,XII',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('materi-thumbnails', 'public');
        }

        $ruangBelajar = RuangBelajar::create([
            'user_id'   => Auth::id(),
            'judul'     => $validated['judul'],
            'mapel'     => $validated['mapel'],
            'kelas'     => $validated['kelas'],
            'thumbnail' => $thumbnailPath,
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('guru.ruang-belajar.index')
            ->with('success', 'Ruang Belajar berhasil ditambahkan! Silakan atur tahapan isi .');
    }
    public function edit($id)
    {
        $ruangBelajar = RuangBelajar::where('user_id', Auth::id())->findOrFail($id);

        return view('guru.ruang-belajar.edit', compact('ruangBelajar'));
    }

    public function update(Request $request, $id)
    {
        $ruangBelajar = RuangBelajar::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'mapel'     => 'required|string|max:255',
            'kelas'     => 'required|string|in:X,XI,XII',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($ruangBelajar->thumbnail && Storage::disk('public')->exists($ruangBelajar->thumbnail)) {
                Storage::disk('public')->delete($ruangBelajar->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('ruang-belajar-thumbnails', 'public');
        }

        $ruangBelajar->update($validated);

        return redirect()->route('guru.ruang-belajar.index')
            ->with('success', 'Ruang Belajar berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $ruangBelajar = RuangBelajar::where('user_id', Auth::id())->findOrFail($id);

        if ($ruangBelajar->thumbnail && Storage::disk('public')->exists($ruangBelajar->thumbnail)) {
            Storage::disk('public')->delete($ruangBelajar->thumbnail);
        }

        $ruangBelajar->delete();

        return redirect()->route('guru.ruang-belajar.index')
            ->with('success', 'Ruang Belajar berhasil dihapus!');
    }
}
