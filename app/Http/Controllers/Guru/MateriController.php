<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        $query = Materi::whereHas('guru', function ($q) use ($guru) {
            $q->where('school_name', $guru->school_name);
        });
        $materis = $query->latest()->get();

        $totalmateri = Materi::latest()->count();
        
        return view('guru.materi.index', compact('materis','totalmateri'));
    }
    public function create()
    {
        return view('guru.materi.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);


        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('materi-thumbnails', 'public');
        }

        Materi::create([
            'user_id'   => Auth::id(),
            'judul'     => $request->judul,
            'thumbnail' => $thumbnailPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('guru.materi.index')
                        ->with('success', 'Materi berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $materis = Materi::findOrFail($id);

        return view('guru.materi.edit', compact('materis'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $materi = Materi::findOrFail($id);

        if ($materi->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('guru.materi.index')
                            ->with('error', 'Anda tidak memiliki akses untuk mengubah materi ini!');
        }
        $thumbnailPath = $materi->thumbnail;

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama dari storage jika ada
            if ($materi->thumbnail && Storage::disk('public')->exists($materi->thumbnail)) {
                Storage::disk('public')->delete($materi->thumbnail);
            }

            // Simpan thumbnail baru
            $thumbnailPath = $request->file('thumbnail')->store('materi-thumbnails', 'public');
        }

        $materi->update([
            'judul'     => $request->judul,
            'thumbnail' => $thumbnailPath,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('guru.materi.index')
                        ->with('success', 'Materi berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $materi = Materi::findOrFail($id);

        $materi->delete();

        return redirect()->route('guru.materi.index')
            ->with('success', 'Materi berhasil dihapus!');
    }
}
