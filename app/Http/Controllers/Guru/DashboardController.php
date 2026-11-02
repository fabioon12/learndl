<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RuangBelajar;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRuangBelajar = RuangBelajar::where('user_id', Auth::id())->count();

        return view('guru.dashboard.index', compact('totalRuangBelajar'));
    }
}
