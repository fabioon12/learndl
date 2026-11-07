<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use App\Models\Submateri;
use Illuminate\Validation\ValidationException;

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

    public function store(Request $request,$materi_id,$submateri_id) 
    {
        $submateri = Submateri::where('materi_id', $materi_id)->findOrFail($submateri_id);

        $sections = $this->validateSections($request);

        $submateri->update([
            'konten_builder' => $sections
        ]);

        return redirect()
            ->route('guru.materi.submateri.index', $materi_id)
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

    public function update( Request $request, $materi_id, $submateri_id) 
    {
        $submateri = Submateri::where( 'materi_id', $materi_id )->findOrFail($submateri_id);

        $sections = $this->validateSections($request);

        $submateri->update([
            'konten_builder' => $sections
        ]);

        return redirect()
            ->route('guru.materi.submateri.index', $materi_id)
            ->with('success', 'Urutan dan isi aktivitas berhasil Diperbarui!');
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
    

private function validateSections(Request $request): array
{
    $validated = $request->validate([
        'sections' => ['required', 'array', 'min:1'],

        // Tipe blok
        'sections.*.tipe' => [
            'required',
            'string',
            'in:teks,video,interaktif,praktik,latihan,pilihan_ganda,simulasi,coding_project'
        ],

        // Konten umum
        'sections.*.isi' => ['nullable', 'string'],
        'sections.*.tips' => ['nullable', 'string'],
        'sections.*.arahan' => ['nullable', 'string'],
        'sections.*.clue' => ['nullable', 'string'],

        // Informasi Coding Project
        'sections.*.project' => ['sometimes', 'array'],
        'sections.*.project.nama' => ['nullable', 'string', 'max:255'],
        'sections.*.project.deskripsi' => ['nullable', 'string'],
        'sections.*.project.bahasa' => ['nullable', 'in:html'],
        'sections.*.project.starter_code' => ['nullable', 'string'],

        // Daftar misi
        'sections.*.project.missions' => ['sometimes', 'array'],

        'sections.*.project.missions.*.id' => [
            'nullable',
            'string',
            'max:100'
        ],

        'sections.*.project.missions.*.judul' => [
            'nullable',
            'string',
            'max:255'
        ],

        'sections.*.project.missions.*.instruksi' => [
            'nullable',
            'string'
        ],

        'sections.*.project.missions.*.petunjuk' => [
            'nullable',
            'string'
        ],

        // Kriteria validasi otomatis
        'sections.*.project.missions.*.criteria' => [
            'sometimes',
            'array'
        ],

        'sections.*.project.missions.*.criteria.*.type' => [
            'required',
            'in:tag_exists,text_contains,attribute_exists'
        ],

        'sections.*.project.missions.*.criteria.*.tag' => [
            'nullable',
            'string',
            'max:50'
        ],

        'sections.*.project.missions.*.criteria.*.text' => [
            'nullable',
            'string'
        ],

        'sections.*.project.missions.*.criteria.*.attribute' => [
            'nullable',
            'string',
            'max:100'
        ],
    ]);

    foreach ($validated['sections'] as $index => &$section) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI PILIHAN GANDA
        |--------------------------------------------------------------------------
        */

        if ($section['tipe'] === 'pilihan_ganda') {

            $data = json_decode(
                $section['clue'] ?? '',
                true
            );

            if (
                !is_array($data) ||
                !isset($data['options']) ||
                !is_array($data['options'])
            ) {
                throw ValidationException::withMessages([
                    "sections.$index.clue" =>
                        'Format pilihan ganda tidak valid.'
                ]);
            }

            $options = $data['options'];

            if (count($options) < 2 || count($options) > 6) {
                throw ValidationException::withMessages([
                    "sections.$index.clue" =>
                        'Pilihan ganda harus memiliki 2 sampai 6 jawaban.'
                ]);
            }

            foreach ($options as $option) {
                if (
                    !is_array($option) ||
                    !isset($option['text']) ||
                    !is_string($option['text']) ||
                    trim($option['text']) === ''
                ) {
                    throw ValidationException::withMessages([
                        "sections.$index.clue" =>
                            'Semua pilihan jawaban harus diisi.'
                    ]);
                }
            }

            $correctIndex = $data['correctIndex'] ?? null;

            if (
                !is_int($correctIndex) ||
                $correctIndex < 0 ||
                $correctIndex >= count($options)
            ) {
                throw ValidationException::withMessages([
                    "sections.$index.arahan" =>
                        'Pilih satu jawaban yang benar.'
                ]);
            }

            if (trim($section['isi'] ?? '') === '') {
                throw ValidationException::withMessages([
                    "sections.$index.isi" =>
                        'Pertanyaan pilihan ganda wajib diisi.'
                ]);
            }

            // Normalisasi pilihan ganda
            $section['arahan'] = (string) $correctIndex;

            $section['clue'] = json_encode([
                'options' => array_map(
                    fn ($option) => [
                        'text' => trim($option['text'])
                    ],
                    $options
                ),
                'correctIndex' => $correctIndex,
                'explanation' => is_string(
                    $data['explanation'] ?? null
                )
                    ? trim($data['explanation'])
                    : ''
            ], JSON_UNESCAPED_UNICODE);
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI CODING PROJECT
        |--------------------------------------------------------------------------
        */

        if ($section['tipe'] === 'coding_project') {

            $project = $section['project'] ?? null;

            if (!is_array($project)) {
                throw ValidationException::withMessages([
                    "sections.$index.project" =>
                        'Konfigurasi Coding Project wajib diisi.'
                ]);
            }

            // Informasi proyek
            if (trim($project['nama'] ?? '') === '') {
                throw ValidationException::withMessages([
                    "sections.$index.project.nama" =>
                        'Nama proyek wajib diisi.'
                ]);
            }

            if (trim($project['deskripsi'] ?? '') === '') {
                throw ValidationException::withMessages([
                    "sections.$index.project.deskripsi" =>
                        'Deskripsi proyek wajib diisi.'
                ]);
            }

            if (($project['bahasa'] ?? '') !== 'html') {
                throw ValidationException::withMessages([
                    "sections.$index.project.bahasa" =>
                        'Bahasa proyek yang didukung saat ini adalah HTML.'
                ]);
            }

            if (trim($project['starter_code'] ?? '') === '') {
                throw ValidationException::withMessages([
                    "sections.$index.project.starter_code" =>
                        'Kode awal HTML wajib diisi.'
                ]);
            }

            // Misi proyek
            $missions = $project['missions'] ?? [];

            if (!is_array($missions) || count($missions) < 1) {
                throw ValidationException::withMessages([
                    "sections.$index.project.missions" =>
                        'Coding Project minimal harus memiliki satu misi.'
                ]);
            }

            foreach ($missions as $mIndex => &$mission) {

                if (trim($mission['judul'] ?? '') === '') {
                    throw ValidationException::withMessages([
                        "sections.$index.project.missions.$mIndex.judul" =>
                            'Judul misi wajib diisi.'
                    ]);
                }

                if (trim($mission['instruksi'] ?? '') === '') {
                    throw ValidationException::withMessages([
                        "sections.$index.project.missions.$mIndex.instruksi" =>
                            'Instruksi misi wajib diisi.'
                    ]);
                }

                // Kriteria validasi
                $criteria = $mission['criteria'] ?? [];

                if (!is_array($criteria) || count($criteria) < 1) {
                    throw ValidationException::withMessages([
                        "sections.$index.project.missions.$mIndex.criteria" =>
                            'Setiap misi minimal memiliki satu kriteria validasi.'
                    ]);
                }

                foreach ($criteria as $cIndex => &$criterion) {

                    $type = $criterion['type'] ?? '';

                    if ($type === 'tag_exists') {

                        if (trim($criterion['tag'] ?? '') === '') {
                            throw ValidationException::withMessages([
                                "sections.$index.project.missions.$mIndex.criteria.$cIndex.tag" =>
                                    'Nama elemen HTML wajib diisi.'
                            ]);
                        }

                    } elseif ($type === 'text_contains') {

                        if (trim($criterion['text'] ?? '') === '') {
                            throw ValidationException::withMessages([
                                "sections.$index.project.missions.$mIndex.criteria.$cIndex.text" =>
                                    'Teks yang harus ditemukan wajib diisi.'
                            ]);
                        }

                    } elseif ($type === 'attribute_exists') {

                        if (
                            trim($criterion['tag'] ?? '') === '' ||
                            trim($criterion['attribute'] ?? '') === ''
                        ) {
                            throw ValidationException::withMessages([
                                "sections.$index.project.missions.$mIndex.criteria.$cIndex.attribute" =>
                                    'Nama tag dan atribut wajib diisi.'
                            ]);
                        }
                    }

                    // Normalisasi kriteria
                    $criterion['tag'] = trim($criterion['tag'] ?? '');
                    $criterion['text'] = trim($criterion['text'] ?? '');
                    $criterion['attribute'] = trim($criterion['attribute'] ?? '');
                }

                unset($criterion);

                $mission['criteria'] = array_values($criteria);
            }

            unset($mission);

            // Normalisasi proyek
            $section['project'] = [
                'nama' => trim($project['nama']),
                'deskripsi' => trim($project['deskripsi']),
                'bahasa' => 'html',
                'starter_code' => $project['starter_code'],
                'missions' => array_values($missions),
            ];
        }
    }

    unset($section);

    return array_values($validated['sections']);
}


}
