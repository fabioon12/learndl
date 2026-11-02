<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tahapan;
use App\Models\RuangBelajar;
use Illuminate\Support\Facades\Storage;

class TahapanKontenController extends Controller
{
    public function edit($ruang_belajar_id, $tahapan_id)
    {
        $ruangBelajar = RuangBelajar::findOrFail($ruang_belajar_id);

        $tahapan = Tahapan::where('ruang_belajar_id', $ruang_belajar_id)
            ->where('id', $tahapan_id)
            ->firstOrFail();

        $viewName = 'guru.tahapan-ruang-belajar.konten.' . $tahapan->tipe;

        if (!view()->exists($viewName)) {
            abort(404, 'Halaman konfigurasi untuk tipe aktivitas ini belum dibuat.');
        }

        // Form konfigurasi dimulai dalam keadaan kosong
        $konten = [
            'teks_apersepsi' => '',
            'tipe_media' => 'teks',
            'youtube_url' => '',
            'gambar_path' => null,
            'aktif_forum' => 0,
            'pertanyaan_pemantik' => '',
        ];

        return view($viewName, compact(
            'ruangBelajar',
            'tahapan',
            'konten'
        ));
    }

    public function update(Request $request, $ruang_belajar_id, $tahapan_id)
    {
        $tahapan = Tahapan::where('ruang_belajar_id', $ruang_belajar_id)
            ->where('id', $tahapan_id)
            ->firstOrFail();

        $konten = $request->konten ?? [];


        switch ($tahapan->tipe) {
            
            case 'apersepsi':
                $request->validate([
                    'konten.teks_apersepsi'    => 'nullable|string',
                    'konten.tipe_media'        => 'required|in:teks,youtube,gambar',
                    'konten.youtube_url'       => 'nullable|url',
                    'gambar_apersepsi'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'konten.pertanyaan_pemantik' => 'nullable|string',
                ]);

                // Proses upload file gambar apersepsi jika ada
                if ($request->hasFile('gambar_apersepsi')) {
                    // Hapus gambar lama jika ada untuk menghemat storage
                    if (!empty($tahapan->konten['gambar_path'])) {
                        Storage::disk('public')->delete($tahapan->konten['gambar_path']);
                    }
                    $konten['gambar_path'] = $request->file('gambar_apersepsi')->store('apersepsi-media', 'public');
                } else {
                    // Pertahankan gambar lama jika tidak mengupload baru
                    $konten['gambar_path'] = $tahapan->konten['gambar_path'] ?? null;
                }
                break;

            case 'ice_breaking':
                $request->validate([
                    'konten.instruksi'     => 'nullable|string',
                    'konten.tipe_media'    => 'required|in:youtube,gambar',
                    'konten.youtube_url'   => 'nullable|url',
                    'gambar_ice_breaking'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                // Proses upload file gambar/GIF ice breaking jika ada
                if ($request->hasFile('gambar_ice_breaking')) {
                    if (!empty($tahapan->konten['gambar_path'])) {
                        Storage::disk('public')->delete($tahapan->konten['gambar_path']);
                    }
                    $konten['gambar_path'] = $request->file('gambar_ice_breaking')->store('ice-breaking-media', 'public');
                } else {
                    $konten['gambar_path'] = $tahapan->konten['gambar_path'] ?? null;
                }
                break;

            // ==========================================
            // 3. JIKA ADA TIPE LAIN DI KEMUDIAN HARI (Misal: Materi)
            // ==========================================
            // case 'materi':
            //     ...
            //     break;

            default:
                // Tangani jika tipe tidak dikenali
                break;
        }

        // Simpan array data ke dalam kolom JSON 'konten' di database
        $tahapan->update([
            'konten' => $konten
        ]);

        return redirect()
            ->route('guru.ruang-belajar.tahapan.index', $ruang_belajar_id)
            ->with('success', 'Konten ' . ucwords(str_replace('_', ' ', $tahapan->tipe)) . ' berhasil disimpan!');
    }
}
