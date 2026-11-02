<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use Illuminate\Support\Facades\Auth;

class TahapanController extends Controller
{
    public function index($id)
    {
        $userId = Auth::id();

        $ruangBelajar = RuangBelajar::with([
            'tahapans' => function ($query) use ($userId) {
                $query->orderBy('urutan', 'asc')
                      ->with(['userProgress' => function ($q) use ($userId) {
                          $q->where('user_id', $userId);
                      }]);
            }
        ])->findOrFail($id);

        $tahapans = $ruangBelajar->tahapans;

        return view('siswa.ruang-belajar.tahapan.index', compact('ruangBelajar', 'tahapans'));
    }
}
