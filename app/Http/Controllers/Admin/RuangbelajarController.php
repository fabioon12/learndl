<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RuangbelajarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedKelas = $request->input('kelas');

        $ruangBelajars = RuangBelajar::with([
                'user',                  
                'guru',                  
                'siswa'                  
            ])
            ->withCount('siswa')         
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

        return view('admin.ruang-belajar.index', compact('ruangBelajars', 'search', 'selectedKelas'));
    }
    public function create()
    {
        $schoolList = [
            'SMKN 4 MALANG',
            'SMKN 5 MALANG',
            'SMKN 6 MALANG',
            'SMKN 8 MALANG',
            'SMKN 9 MALANG',
            'SMKN 11 MALANG',
            'SMKN 12 MALANG',
        ];
        $gurus = User::where('role', 'guru')
            ->select('id', 'fullname', 'school_name', 'major_or_subject') 
            ->orderBy('fullname', 'asc')
            ->get();
        return view('admin.ruang-belajar.create', compact('schoolList', 'gurus'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'guru_id' => 'required|exists:users,id',
            'deskripsi' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'target_schools' => 'required|array', 
        ]);
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('materi-thumbnails', 'public');
        }

        RuangBelajar::create([
            'user_id' => auth()->id(),
            'guru_id' => $request->guru_id,
            'judul' => $request->judul,
            'mapel' => $request->mapel,
            'kelas' => $request->kelas,
            'thumbnail' => $thumbnailPath,
            'deskripsi' => $request->deskripsi,
            'target_schools' => $request->target_schools, 
        ]);

        return redirect()->route('admin.ruang-belajar.index')->with('success', 'Ruang Belajar berhasil diterbitkan!');
    }
    public function destroy($id)
    {
        $ruangBelajar = RuangBelajar::findOrFail($id);

        if ($ruangBelajar->thumbnail && Storage::disk('public')->exists($ruangBelajar->thumbnail)) {
            Storage::disk('public')->delete($ruangBelajar->thumbnail);
        }

        $ruangBelajar->delete();

        return redirect()
            ->route('admin.ruang-belajar.index')
            ->with('success', 'Ruang Belajar berhasil dihapus!');
    }
}
