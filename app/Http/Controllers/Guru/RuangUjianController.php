<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RuangUjianController extends Controller
{
     public function index(Request $request)
    {
        $guruId = Auth::id();

        $query = RuangUjian::where('guru_id', $guruId)
            ->withCount('soal')
            ->withSum('soal', 'exp')
            ->withCount('hasilUjian')
            ->latest();

        // Pencarian berdasarkan judul ruang ujian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('judul', 'like', "%{$search}%");
        }

        // Filter status
        if ($request->filled('status') &&
            in_array($request->status, ['draft', 'aktif', 'nonaktif'])) {

            $query->where('status', $request->status);
        }

        $ruangUjians = $query->paginate(10)->withQueryString();

        // Statistik ruang ujian milik guru
        $statistik = [
            'total' => RuangUjian::where('guru_id', $guruId)->count(),

            'aktif' => RuangUjian::where('guru_id', $guruId)
                ->where('status', 'aktif')
                ->count(),

            'draft' => RuangUjian::where('guru_id', $guruId)
                ->where('status', 'draft')
                ->count(),

            'nonaktif' => RuangUjian::where('guru_id', $guruId)
                ->where('status', 'nonaktif')
                ->count(),
        ];

        return view('guru.ruang-ujian.index', compact(
            'ruangUjians',
            'statistik'
        ));
    }

    /**
     * Menampilkan halaman form pembuatan ruang ujian.
     */
    public function create()
    {
        return view('guru.ruang-ujian.create');
    }

    /**
     * Menyimpan ruang ujian baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'durasi_menit' => [
                'required',
                'integer',
                'min:1',
                'max:600',
            ],

            'maksimal_percobaan' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],

            'acak_soal' => [
                'nullable',
                'boolean',
            ],

            'acak_jawaban' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'aktif', 'nonaktif']),
            ],
        ]);

        $validated['guru_id'] = Auth::id();

        // Checkbox yang tidak dicentang akan bernilai false
        $validated['acak_soal'] = $request->boolean('acak_soal');
        $validated['acak_jawaban'] = $request->boolean('acak_jawaban');

        $ruangUjian = RuangUjian::create($validated);

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Ruang ujian berhasil dibuat. Silakan tambahkan soal ujian.');
    }

    /**
     * Menampilkan detail ruang ujian beserta soal-soalnya.
     */
    public function show($id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->with([
                'soal',
                'hasilUjian.siswa',
            ])
            ->withCount('soal')
            ->withSum('soal', 'exp')
            ->findOrFail($id);

        $totalExp = (int) ($ruangUjian->soal_sum_exp ?? 0);

        return view('guru.ruang-ujian.show', compact(
            'ruangUjian',
            'totalExp'
        ));
    }

    /**
     * Menampilkan form edit ruang ujian.
     */
    public function edit($id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($id);

        return view('guru.ruang-ujian.edit', compact('ruangUjian'));
    }

    /**
     * Memperbarui informasi ruang ujian.
     */
    public function update(Request $request, $id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'durasi_menit' => [
                'required',
                'integer',
                'min:1',
                'max:600',
            ],

            'maksimal_percobaan' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],

            'acak_soal' => [
                'nullable',
                'boolean',
            ],

            'acak_jawaban' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'required',
                Rule::in(['draft', 'aktif', 'nonaktif']),
            ],
        ]);

        $validated['acak_soal'] = $request->boolean('acak_soal');
        $validated['acak_jawaban'] = $request->boolean('acak_jawaban');

        $ruangUjian->update($validated);

        return redirect()
            ->route('guru.ruang-ujian.show', $ruangUjian->id)
            ->with('success', 'Ruang ujian berhasil diperbarui.');
    }

    /**
     * Menghapus ruang ujian.
     */
    public function destroy($id)
    {
        $ruangUjian = RuangUjian::where('guru_id', Auth::id())
            ->findOrFail($id);

        // Ruang ujian tidak boleh dihapus jika sudah digunakan tahapan
        if ($ruangUjian->tahapans()->exists()) {
            return back()->with(
                'error',
                'Ruang ujian tidak dapat dihapus karena sudah digunakan pada tahapan pembelajaran.'
            );
        }

        // Ruang ujian tidak boleh dihapus jika sudah memiliki hasil pengerjaan
        if ($ruangUjian->hasilUjian()->exists()) {
            return back()->with(
                'error',
                'Ruang ujian tidak dapat dihapus karena sudah memiliki riwayat pengerjaan siswa.'
            );
        }

        $ruangUjian->delete();

        return redirect()
            ->route('guru.ruang-ujian.index')
            ->with('success', 'Ruang ujian berhasil dihapus.');
    }
}
