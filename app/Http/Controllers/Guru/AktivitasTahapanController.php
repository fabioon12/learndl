<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AktivitasTahapanController extends Controller
{
    public function index($id)
    {
        $ruangBelajar = RuangBelajar::where('user_id', Auth::id())
            ->findOrFail($id);

        $tahapan = Tahapan::where('ruang_belajar_id', $id)
            ->findOrFail($id);
        return view('guru.aktivitas-materi.index',compact('ruangBelajar', 'tahapan'));
    }
}
