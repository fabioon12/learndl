<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Submateri;

class AktivitasSubMateriController extends Controller
{
    public function create($materi_id, $submateri_id)
    {
        $materi = Materi::findOrFail($materi_id);
        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($submateri_id);

        $allowedTypes = is_array($submateri->tipe) 
            ? $submateri->tipe 
            : (json_decode($submateri->tipe, true) ?? [$submateri->tipe]);

        return view('guru.materi.submateri.aktivitas.create', compact('materi', 'submateri', 'allowedTypes'));
    }
    public function store(Request $request, $materi_id, $submateri_id)
    {
        $validated = $request->validate([
            'sections' => 'required|array|min:1',
            'sections.*.tipe' => 'required|string',
            'sections.*.isi' => 'nullable|string',
            'sections.*.tips' => 'nullable|string',
            'sections.*.arahan' => 'nullable|string',
            'sections.*.clue' => 'nullable|string',
        ]);

        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($submateri_id);

        $sections = array_values($validated['sections']);

        $submateri->update([
            'konten_builder' => $sections
        ]);

        return redirect()->route('guru.materi.submateri.index', $materi_id)
                        ->with('success', 'Urutan dan isi aktivitas berhasil disimpan!');
    }
    public function edit($materi_id, $submateri_id)
    {
        $materi = Materi::findOrFail($materi_id);
        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($submateri_id);

        $existingBlocks = $submateri->konten_builder ?? [];
        $allowedTypes = $submateri->tipe ?? ['teks', 'video', 'interaktif', 'praktik', 'latihan'];

        return view('guru.materi.submateri.aktivitas.edit', compact(
            'materi', 
            'submateri', 
            'allowedTypes', 
            'existingBlocks'
        ));
    }
    public function update(Request $request, $materi_id, $submateri_id)
    {

        $validated = $request->validate([
            'sections' => 'required|array|min:1',
            'sections.*.tipe' => 'required|string',
            'sections.*.isi' => 'nullable|string',
            'sections.*.tips' => 'nullable|string',
            'sections.*.arahan' => 'nullable|string',
            'sections.*.clue' => 'nullable|string',
        ]);

        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($submateri_id);

        $sections = array_values($validated['sections']);

        $submateri->update([
            'konten_builder' => $sections
        ]);

        return redirect()->route('guru.materi.submateri.index', $materi_id)
                        ->with('success', 'Urutan dan isi aktivitas berhasil diperbarui!');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|file|mimes:jpeg,png,jpg,webp,gif|max:10240', 
        ]);

        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('materi-images', 'public');
            
            $url = asset('storage/' . $path);

            return response()->json([
                'url' => $url
            ], 200);
        }

        return response()->json([
            'error' => ['message' => 'File gambar tidak ditemukan dalam request.']
        ], 400);
    }
    public function show($materi_id, $submateri_id)
    {
        $materi = Materi::findOrFail($materi_id);

        $submateri = Submateri::where('materi_id', $materi_id)
            ->where('status', 'terbit') 
            ->findOrFail($submateri_id);

        return view('guru.materi.submateri.aktivitas.show', compact('materi', 'submateri'));
    }
}
