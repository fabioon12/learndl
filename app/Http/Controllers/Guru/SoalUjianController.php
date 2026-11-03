<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use App\Models\SoalUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SoalUjianController extends Controller
{
    public function create($ruang_ujian_id)
    {
        // Pastikan ruang ujian milik guru yang sedang login
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->withCount('soal')
            ->findOrFail($ruang_ujian_id);

        // Menentukan urutan soal berikutnya
        $urutanBerikutnya = $ruangUjian->soal()->max('urutan') + 1;

        return view('guru.ruang-ujian.soal.create', compact(
            'ruangUjian',
            'urutanBerikutnya'
        ));
    }

    /**
     * Menyimpan soal baru.
     */
    public function store(Request $request, $ruang_ujian_id)
    {
        // Pastikan ruang ujian milik guru yang sedang login
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);

        // Validasi data soal
        $validated = $request->validate([
            'pertanyaan' => [
                'required',
                'string',
            ],

            'tipe' => [
                'required',
                Rule::in(['pilihan_ganda', 'esai']),
            ],

            'opsi' => [
                'nullable',
                'array',
            ],

            'opsi.*.kode' => [
                'required_if:tipe,pilihan_ganda',
                'nullable',
                'string',
                'max:5',
            ],

            'opsi.*.teks' => [
                'required_if:tipe,pilihan_ganda',
                'nullable',
                'string',
            ],

            'jawaban_benar' => [
                'required_if:tipe,pilihan_ganda',
                'nullable',
                'string',
            ],

            'exp' => [
                'required',
                'integer',
                'min:0',
                'max:1000',
            ],

            'pembahasan' => [
                'nullable',
                'string',
            ],
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi.',
            'tipe.required' => 'Tipe soal wajib dipilih.',
            'opsi.*.kode.required_if' => 'Kode pilihan jawaban wajib diisi.',
            'opsi.*.teks.required_if' => 'Isi pilihan jawaban wajib diisi.',
            'jawaban_benar.required_if' => 'Kunci jawaban wajib dipilih.',
            'exp.required' => 'EXP soal wajib diisi.',
            'exp.min' => 'EXP tidak boleh kurang dari 0.',
        ]);

        // Validasi khusus pilihan ganda
        if ($validated['tipe'] === 'pilihan_ganda') {
            $opsi = $validated['opsi'] ?? [];

            if (count($opsi) < 2) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'opsi' => 'Soal pilihan ganda minimal memiliki 2 pilihan jawaban.',
                    ]);
            }

            $kodeOpsi = collect($opsi)
                ->pluck('kode')
                ->toArray();

            if (!in_array($validated['jawaban_benar'], $kodeOpsi)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'jawaban_benar' => 'Kunci jawaban harus sesuai dengan kode pilihan yang tersedia.',
                    ]);
            }
        }

        DB::transaction(function () use ($validated, $ruangUjian) {

            // Menentukan urutan soal secara otomatis
            $urutan = ($ruangUjian->soal()->max('urutan') ?? 0) + 1;

            // Simpan soal
            SoalUjian::create([
                'ruang_ujian_id' => $ruangUjian->id,
                'urutan' => $urutan,
                'pertanyaan' => $validated['pertanyaan'],
                'tipe' => $validated['tipe'],

                // Pilihan jawaban hanya disimpan untuk pilihan ganda
                'opsi' => $validated['tipe'] === 'pilihan_ganda'
                    ? $validated['opsi']
                    : null,

                // Jawaban benar hanya digunakan untuk pilihan ganda
                'jawaban_benar' => $validated['tipe'] === 'pilihan_ganda'
                    ? $validated['jawaban_benar']
                    : null,

                'exp' => $validated['exp'],
                'pembahasan' => $validated['pembahasan'] ?? null,
            ]);
        });

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit($ruang_ujian_id, $soal_id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);

        $soal = SoalUjian::where('ruang_ujian_id', $ruangUjian->id)
            ->findOrFail($soal_id);

        return view('guru.ruang-ujian.soal.edit', compact(
            'ruangUjian',
            'soal'
        ));
    }
    public function update(Request $request, $ruang_ujian_id, $soal_id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);

        $soal = SoalUjian::where('ruang_ujian_id', $ruangUjian->id)
            ->findOrFail($soal_id);

        $validated = $request->validate([
            'pertanyaan' => ['required', 'string'],
            'tipe' => ['required', Rule::in(['pilihan_ganda', 'esai'])],
            'opsi' => ['nullable', 'array'],
            'opsi.*.kode' => ['required_if:tipe,pilihan_ganda', 'nullable', 'string', 'max:5'],
            'opsi.*.teks' => ['required_if:tipe,pilihan_ganda', 'nullable', 'string'],
            'jawaban_benar' => ['required_if:tipe,pilihan_ganda', 'nullable', 'string'],
            'exp' => ['required', 'integer', 'min:0', 'max:1000'],
            'pembahasan' => ['nullable', 'string'],
        ]);

        if ($validated['tipe'] === 'pilihan_ganda') {
            $opsi = $validated['opsi'] ?? [];

            if (count($opsi) < 2) {
                return back()->withInput()->withErrors([
                    'opsi' => 'Minimal harus tersedia 2 pilihan jawaban.',
                ]);
            }

            $kodeOpsi = collect($opsi)->pluck('kode')->toArray();

            if (!in_array($validated['jawaban_benar'], $kodeOpsi)) {
                return back()->withInput()->withErrors([
                    'jawaban_benar' => 'Kunci jawaban tidak sesuai dengan pilihan yang tersedia.',
                ]);
            }
        }

        $soal->update([
            'pertanyaan' => $validated['pertanyaan'],
            'tipe' => $validated['tipe'],
            'opsi' => $validated['tipe'] === 'pilihan_ganda'
                ? $validated['opsi']
                : null,
            'jawaban_benar' => $validated['tipe'] === 'pilihan_ganda'
                ? $validated['jawaban_benar']
                : null,
            'exp' => $validated['exp'],
            'pembahasan' => $validated['pembahasan'] ?? null,
        ]);

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Soal berhasil diperbarui.');
    }
    public function destroy($ruang_ujian_id, $soal_id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($ruang_ujian_id);

        $soal = SoalUjian::where('ruang_ujian_id', $ruangUjian->id)
            ->findOrFail($soal_id);

        // Cegah penghapusan jika soal sudah pernah dijawab siswa.
        if ($soal->jawabanUjian()->exists()) {
            return redirect()
                ->route('guru.ruang-ujian.show', $ruangUjian->id)
                ->with('error', 'Soal tidak dapat dihapus karena sudah pernah dikerjakan siswa.');
        }

        $soal->delete();

        // Susun ulang nomor urut soal setelah penghapusan.
        $ruangUjian->soal()
            ->orderBy('urutan')
            ->get()
            ->values()
            ->each(function ($item, $index) {
                $item->update([
                    'urutan' => $index + 1,
                ]);
            });

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Soal berhasil dihapus.');
    }
}
