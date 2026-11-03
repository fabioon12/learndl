
@extends('siswa.layouts.app')

@section('title', 'Tahapan Ruang Belajar Saya')

@push('styles')
<style>
    @media (max-width: 640px) {
        .learning-node {
            transform: translateX(calc(var(--offset-x) * 0.45)) !important;
        }
    }

    .learning-node {
        transition: transform .3s ease;
    }

    .learning-node-button {
        cursor: pointer;
        transition: all .25s ease;
    }

    .learning-node-button:hover {
        transform: scale(1.08);
    }

    .learning-node-button:active {
        transform: translateY(3px);
    }

    .tahapan-action {
        animation: showAction .25s ease;
    }

    @keyframes showAction {
        from {
            opacity: 0;
            transform: translateY(-6px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')

@php
    $user = Auth::user();

    $offsets = [0, 65, 105, 65, 0, -65, -105, -65];

    // ==========================================
    // STATUS DAN PROGRESS TAHAPAN SISWA
    // ==========================================

    $totalTahapan = $tahapans->count();

    $completedTahapan = 0;
    $tahapanStatus = [];
    $menemukanTahapanAktif = false;

    foreach ($tahapans as $tahapanItem) {

        $progressSiswa = $tahapanItem->userProgress->first();

        // Status selesai hanya berdasarkan progres siswa.
        // Tidak menggunakan status global dari tabel tahapans.
        $sudahSelesai = $progressSiswa?->status === 'selesai';

        if ($sudahSelesai) {

            $statusItem = 'selesai';
            $completedTahapan++;

        } elseif (!$menemukanTahapanAktif) {

            // Tahapan pertama yang belum selesai menjadi aktif.
            $statusItem = 'aktif';
            $menemukanTahapanAktif = true;

        } else {

            // Tahapan setelahnya masih terkunci.
            $statusItem = 'terkunci';
        }

        $tahapanStatus[$tahapanItem->id] = $statusItem;
    }

    $progressPersen = $totalTahapan > 0
        ? round(($completedTahapan / $totalTahapan) * 100)
        : 0;

    $tahapanSelesai = $completedTahapan;
    $tahapanTersisa = max(0, $totalTahapan - $completedTahapan);

    $semuaTahapanSelesai = $totalTahapan > 0
        && $completedTahapan === $totalTahapan;

    // ==========================================
    // DATA SISWA
    // ==========================================

    $studentLevel = max(1, (int) ($user->level ?? 1));

    // Total XP dari seluruh sumber EXP.
    $studentXP = (int) $user->totalXp();

    $totalMedals = (int) ($medals ?? 0);

    // ==========================================
    // PROGRESS LEVEL
    // ==========================================

    $xpPerLevel = 1000;
    $xpPerLevel = max(1, (int) $xpPerLevel);

    $currentLevelXP = $studentXP % $xpPerLevel;

    $remainingXP = $xpPerLevel - $currentLevelXP;

    $levelProgress = ($currentLevelXP / $xpPerLevel) * 100;

    $levelProgress = min(100, max(0, $levelProgress));

    // ==========================================
    // EXP RUANG BELAJAR
    // ==========================================

    $totalExp = (int) ($totalExp ?? 0);
    $expDiperoleh = (int) ($expDiperoleh ?? 0);

    // ==========================================
    // WARNA BERDASARKAN ICON DATABASE
    // ==========================================

    $warnaIcon = [

        'fa-spa' => [
            'from' => 'from-purple-400',
            'to' => 'to-purple-600',
            'border' => 'border-purple-800',
            'ring' => 'ring-purple-400/25',
            'shadow' => 'shadow-purple-500/30',
            'badge' => 'bg-purple-100 text-purple-600',
            'button' => 'bg-purple-500 hover:bg-purple-600 border-purple-700',
            'path' => '#C084FC',
        ],

        'fa-lightbulb' => [
            'from' => 'from-yellow-400',
            'to' => 'to-yellow-600',
            'border' => 'border-yellow-800',
            'ring' => 'ring-yellow-400/25',
            'shadow' => 'shadow-yellow-500/30',
            'badge' => 'bg-yellow-100 text-yellow-700',
            'button' => 'bg-yellow-500 hover:bg-yellow-600 border-yellow-700',
            'path' => '#FACC15',
        ],

        'fa-puzzle-piece' => [
            'from' => 'from-orange-400',
            'to' => 'to-orange-600',
            'border' => 'border-orange-800',
            'ring' => 'ring-orange-400/25',
            'shadow' => 'shadow-orange-500/30',
            'badge' => 'bg-orange-100 text-orange-600',
            'button' => 'bg-orange-500 hover:bg-orange-600 border-orange-700',
            'path' => '#FB923C',
        ],

        'fa-compass' => [
            'from' => 'from-cyan-400',
            'to' => 'to-cyan-600',
            'border' => 'border-cyan-800',
            'ring' => 'ring-cyan-400/25',
            'shadow' => 'shadow-cyan-500/30',
            'badge' => 'bg-cyan-100 text-cyan-600',
            'button' => 'bg-cyan-500 hover:bg-cyan-600 border-cyan-700',
            'path' => '#22D3EE',
        ],

        'fa-code' => [
            'from' => 'from-emerald-400',
            'to' => 'to-emerald-600',
            'border' => 'border-emerald-800',
            'ring' => 'ring-emerald-400/25',
            'shadow' => 'shadow-emerald-500/30',
            'badge' => 'bg-emerald-100 text-emerald-600',
            'button' => 'bg-emerald-500 hover:bg-emerald-600 border-emerald-700',
            'path' => '#34D399',
        ],

        'fa-clipboard-check' => [
            'from' => 'from-pink-400',
            'to' => 'to-pink-600',
            'border' => 'border-pink-800',
            'ring' => 'ring-pink-400/25',
            'shadow' => 'shadow-pink-500/30',
            'badge' => 'bg-pink-100 text-pink-600',
            'button' => 'bg-pink-500 hover:bg-pink-600 border-pink-700',
            'path' => '#F472B6',
        ],

        'fa-book-open' => [
            'from' => 'from-indigo-400',
            'to' => 'to-indigo-600',
            'border' => 'border-indigo-800',
            'ring' => 'ring-indigo-400/25',
            'shadow' => 'shadow-indigo-500/30',
            'badge' => 'bg-indigo-100 text-indigo-600',
            'button' => 'bg-indigo-500 hover:bg-indigo-600 border-indigo-700',
            'path' => '#818CF8',
        ],

        'fa-brain' => [
            'from' => 'from-fuchsia-400',
            'to' => 'to-fuchsia-600',
            'border' => 'border-fuchsia-800',
            'ring' => 'ring-fuchsia-400/25',
            'shadow' => 'shadow-fuchsia-500/30',
            'badge' => 'bg-fuchsia-100 text-fuchsia-600',
            'button' => 'bg-fuchsia-500 hover:bg-fuchsia-600 border-fuchsia-700',
            'path' => '#E879F9',
        ],

        'fa-flask' => [
            'from' => 'from-teal-400',
            'to' => 'to-teal-600',
            'border' => 'border-teal-800',
            'ring' => 'ring-teal-400/25',
            'shadow' => 'shadow-teal-500/30',
            'badge' => 'bg-teal-100 text-teal-600',
            'button' => 'bg-teal-500 hover:bg-teal-600 border-teal-700',
            'path' => '#2DD4BF',
        ],

        'fa-flag' => [
            'from' => 'from-pink-400',
            'to' => 'to-pink-600',
            'border' => 'border-pink-800',
            'ring' => 'ring-pink-400/25',
            'shadow' => 'shadow-pink-500/30',
            'badge' => 'bg-pink-100 text-pink-600',
            'button' => 'bg-pink-500 hover:bg-pink-600 border-pink-700',
            'path' => '#EC4899',
        ],

        'fa-star' => [
            'from' => 'from-amber-400',
            'to' => 'to-amber-600',
            'border' => 'border-amber-800',
            'ring' => 'ring-amber-400/25',
            'shadow' => 'shadow-amber-500/30',
            'badge' => 'bg-amber-100 text-amber-700',
            'button' => 'bg-amber-500 hover:bg-amber-600 border-amber-700',
            'path' => '#F59E0B',
        ],

        'fa-gift' => [
            'from' => 'from-purple-400',
            'to' => 'to-purple-600',
            'border' => 'border-purple-800',
            'ring' => 'ring-purple-400/25',
            'shadow' => 'shadow-purple-500/30',
            'badge' => 'bg-purple-100 text-purple-600',
            'button' => 'bg-purple-500 hover:bg-purple-600 border-purple-700',
            'path' => '#A855F7',
        ],

        'fa-trophy' => [
            'from' => 'from-emerald-400',
            'to' => 'to-emerald-600',
            'border' => 'border-emerald-800',
            'ring' => 'ring-emerald-400/25',
            'shadow' => 'shadow-emerald-500/30',
            'badge' => 'bg-emerald-100 text-emerald-600',
            'button' => 'bg-emerald-500 hover:bg-emerald-600 border-emerald-700',
            'path' => '#10B981',
        ],
    ];

    $warnaDefault = [
        'from' => 'from-indigo-400',
        'to' => 'to-indigo-600',
        'border' => 'border-indigo-800',
        'ring' => 'ring-indigo-400/25',
        'shadow' => 'shadow-indigo-500/30',
        'badge' => 'bg-indigo-100 text-indigo-600',
        'button' => 'bg-indigo-500 hover:bg-indigo-600 border-indigo-700',
        'path' => '#818CF8',
    ];
@endphp

@include('siswa.ruang-belajar.tahapan.partials.header')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 xl:gap-8 items-start">

    {{-- ==========================================
         KOLOM KIRI: LEARNING PATH
    =========================================== --}}

    <div class="lg:col-span-8 min-w-0">

        <div class="bg-white/60 dark:bg-cyberdark-900/40 rounded-[2rem] p-4 sm:p-6 lg:p-8 border border-gray-100 dark:border-gray-800">

            <div class="flex items-center justify-between mb-8">

                <div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">
                        Petualangan Belajar
                    </h2>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Selesaikan setiap tahapan untuk melanjutkan perjalananmu!
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-map-location-dot text-emerald-500 text-lg"></i>
                </div>

            </div>

            {{-- PATH CONTAINER --}}
            <div class="relative flex flex-col items-center py-4">

                @foreach ($tahapans as $index => $tahapan)

                    @php
                        $offsetX = $offsets[$index % count($offsets)];

                        $userProg = $tahapan->userProgress->first();

                        // STATUS DINAMIS BERDASARKAN PROGRESS SISWA
                        $status = $tahapanStatus[$tahapan->id] ?? 'terkunci';

                        $isLast = $index === $totalTahapan - 1;

                        $nextOffset = !$isLast
                            ? $offsets[($index + 1) % count($offsets)]
                            : $offsetX;

                        $svgCenter = 160;
                        $startX = $svgCenter + $offsetX;
                        $endX = $svgCenter + $nextOffset;
                        $curve = $nextOffset - $offsetX;
                        $controlX = $curve * 0.55;

                        $iconKey = trim($tahapan->icon ?? 'fa-star');
                        $iconKey = str_replace('fa-solid ', '', $iconKey);
                        $warna = $warnaIcon[$iconKey] ?? $warnaDefault;

                        if ($status === 'selesai') {
                            $pathColor = '#FBBF24';
                        } elseif ($status === 'terkunci') {
                            $pathColor = '#CBD5E1';
                        } else {
                            $pathColor = $warna['path'];
                        }
                    @endphp

                    {{-- NODE --}}
                    <div
                        class="learning-node relative z-10 flex flex-col items-center transition-transform duration-300"
                        style="--offset-x: {{ $offsetX }}px; transform: translateX({{ $offsetX }}px);">

                        {{-- LABEL TAHAPAN AKTIF --}}
                        @if ($status === 'aktif')

                            <div class="relative z-30 mb-3 {{ $warna['badge'] }} text-[11px] font-black px-4 py-2 rounded-2xl uppercase tracking-wider shadow-lg border-b-4 flex items-center gap-2 animate-bounce whitespace-nowrap">

                                <span>SIAP DIMULAI</span>

                                <span class="bg-white/50 px-2 py-1 rounded-lg text-[10px]">
                                    +{{ $tahapan->xp_reward }} XP
                                </span>

                                <span class="absolute top-full left-1/2 -translate-x-1/2 border-[7px] border-transparent border-t-white/70"></span>

                            </div>

                        @else

                            <div class="h-3"></div>

                        @endif

                        {{-- ICON NODE --}}
                        <div class="relative w-24 h-24 flex items-center justify-center">

                            {{-- SELESAI --}}
                            @if ($status === 'selesai')

                                <button
                                    type="button"
                                    onclick="toggleTahapan({{ $tahapan->id }})"
                                    title="{{ $tahapan->judul_tahapan }}"
                                    class="learning-node-button w-20 h-20 rounded-full bg-gradient-to-b from-amber-300 to-amber-500 border-b-[7px] border-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/25">

                                    <i class="fa-solid {{ $tahapan->icon ?? 'fa-check' }} text-3xl text-white drop-shadow-md"></i>

                                </button>

                                <span class="absolute -top-1 -right-1 w-7 h-7 rounded-full bg-amber-500 border-[3px] border-white dark:border-cyberdark-900 flex items-center justify-center shadow-md">
                                    <i class="fa-solid fa-check text-[10px] text-white"></i>
                                </span>

                            {{-- AKTIF --}}
                            @elseif ($status === 'aktif')

                                <button
                                    type="button"
                                    onclick="toggleTahapan({{ $tahapan->id }})"
                                    title="{{ $tahapan->judul_tahapan }}"
                                    class="learning-node-button relative w-24 h-24 rounded-full bg-gradient-to-b {{ $warna['from'] }} {{ $warna['to'] }} border-b-[8px] {{ $warna['border'] }} ring-[6px] {{ $warna['ring'] }} flex items-center justify-center shadow-xl {{ $warna['shadow'] }}">

                                    <span class="absolute inset-2 rounded-full border border-white/30"></span>

                                    <i class="fa-solid {{ $tahapan->icon ?? 'fa-star' }} text-4xl text-white drop-shadow-lg"></i>

                                </button>

                            {{-- TERKUNCI --}}
                            @else

                                <div
                                    title="Selesaikan tahapan sebelumnya terlebih dahulu"
                                    class="relative w-20 h-20 rounded-full bg-gradient-to-b from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 border-b-[7px] border-gray-300 dark:border-gray-900 flex items-center justify-center shadow-inner opacity-80 cursor-not-allowed">

                                    <i class="fa-solid {{ $tahapan->icon ?? 'fa-star' }} text-3xl text-gray-400 dark:text-gray-300"></i>

                                    <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-gray-500 dark:bg-gray-600 border-[3px] border-white dark:border-cyberdark-900 flex items-center justify-center shadow-md">
                                        <i class="fa-solid fa-lock text-[10px] text-white"></i>
                                    </span>

                                </div>

                            @endif

                        </div>

                        {{-- JUDUL DAN STATUS --}}
                        <div class="mt-3 flex flex-col items-center text-center min-h-[85px]">

                            <span class="text-xs font-extrabold text-gray-700 dark:text-gray-200 max-w-[150px] line-clamp-2">
                                {{ $tahapan->judul_tahapan }}
                            </span>

                            @if ($status === 'selesai')

                                <span class="mt-2 px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-[9px] font-black uppercase">
                                    <i class="fa-solid fa-check mr-1"></i>
                                    Selesai
                                </span>

                            @elseif ($status === 'aktif')

                                <span class="mt-2 px-3 py-1 rounded-full {{ $warna['badge'] }} text-[9px] font-black uppercase">
                                    Siap Dipelajari
                                </span>

                            @else

                                <span class="mt-2 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-[9px] font-black uppercase">
                                    <i class="fa-solid fa-lock mr-1"></i>
                                    Terkunci
                                </span>

                            @endif

                            {{-- TOMBOL AKSI --}}
                            @if ($status !== 'terkunci')

                                <div
                                    id="tahapan-action-{{ $tahapan->id }}"
                                    class="tahapan-action hidden mt-3 w-full max-w-[170px]">

                                    <a
                                        href="{{ route('siswa.ruang-belajar.tahapan.show', [
                                            'ruang_belajar_id' => $ruangBelajar->id,
                                            'tahapan_id' => $tahapan->id
                                        ]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl
                                        {{ $status === 'selesai'
                                            ? 'bg-amber-500 hover:bg-amber-600 border-amber-700'
                                            : $warna['button'] }}
                                        text-white text-[10px] font-black uppercase tracking-wide border-b-4 shadow-lg transition-all hover:-translate-y-0.5 active:translate-y-0">

                                        <i class="fa-solid {{ $status === 'selesai' ? 'fa-rotate-right' : 'fa-play' }}"></i>

                                        {{ $status === 'selesai' ? 'Ulangi Tahapan' : 'Mulai Tahapan' }}

                                    </a>

                                </div>

                            @endif

                        </div>

                    </div>

                    {{-- JALUR PENGHUBUNG --}}
                    @if (!$isLast)

                        <div class="relative w-full h-24 shrink-0">

                            <svg
                                class="absolute pointer-events-none"
                                style="left: calc(50% - 160px); top: 0; width: 320px; height: 96px; overflow: visible;"
                                viewBox="0 0 320 96"
                                fill="none">

                                <path
                                    d="M {{ $startX }} 0 C {{ $startX + $controlX }} 32, {{ $endX - $controlX }} 64, {{ $endX }} 96"
                                    stroke="#94A3B8"
                                    stroke-width="9"
                                    stroke-linecap="round"
                                    stroke-dasharray="2 14"
                                    opacity="0.15"
                                />

                                <path
                                    d="M {{ $startX }} 0 C {{ $startX + $controlX }} 32, {{ $endX - $controlX }} 64, {{ $endX }} 96"
                                    stroke="{{ $pathColor }}"
                                    stroke-width="7"
                                    stroke-linecap="round"
                                    stroke-dasharray="2 14"
                                />

                            </svg>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>

    </div>

    {{-- ==========================================
         KOLOM KANAN: PROFIL DAN PROGRESS
    =========================================== --}}

    <div class="lg:col-span-4 min-w-0 space-y-5 lg:sticky lg:top-6">

        {{-- PROFIL SISWA --}}
        <div class="relative overflow-hidden bg-white dark:bg-cyberdark-900 rounded-[2rem] p-5 border border-gray-100 dark:border-pink-950/40 shadow-xl shadow-purple-500/5">

            <div class="absolute -top-16 -right-16 w-40 h-40 rounded-full bg-purple-100/70 dark:bg-purple-900/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10">

                <div class="flex items-center gap-3">

                    <div class="relative shrink-0">

                        <img
                            src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed={{ urlencode($user->fullname ?? 'Siswa') }}&backgroundColor=b6e3f4"
                            alt="Avatar Siswa"
                            class="w-14 h-14 rounded-2xl border-2 border-purple-200 dark:border-purple-800 shadow-sm bg-sky-100">

                        <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-[3px] border-white dark:border-cyberdark-900 rounded-full"></span>

                    </div>

                    <div class="min-w-0 flex-1">

                        <h3 class="text-sm font-black text-gray-900 dark:text-white truncate">
                            {{ $user->fullname }}
                        </h3>

                        <p class="text-[11px] font-semibold text-gray-500 dark:text-gray-400 truncate mt-1">
                            {{ $user->school_name ?? 'Siswa LearnDL' }}
                        </p>

                        <span class="inline-flex items-center gap-1 px-2.5 py-1 mt-1.5 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-600 dark:text-purple-300 text-[9px] font-black uppercase">
                            <i class="fa-solid fa-star text-amber-400"></i>
                            LEVEL {{ $studentLevel }}
                        </span>

                    </div>

                </div>

                <div class="border-t border-gray-100 dark:border-gray-700/50 my-5"></div>

                {{-- LEVEL PROGRESS --}}
                <div class="flex items-center justify-between mb-3">

                    <div class="flex items-center gap-2">

                        <div class="w-9 h-9 rounded-xl bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                            <i class="fa-solid fa-trophy text-purple-500"></i>
                        </div>

                        <div>
                            <p class="text-xs font-black text-gray-800 dark:text-white">
                                Level {{ $studentLevel }}
                            </p>

                            <p class="text-[10px] text-gray-400 font-semibold">
                                Menuju level berikutnya
                            </p>
                        </div>

                    </div>

                    <span class="text-[10px] font-black text-purple-500 whitespace-nowrap">
                        {{ number_format($currentLevelXP) }}/{{ number_format($xpPerLevel) }}
                    </span>

                </div>

                <div class="w-full h-3 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden p-[2px]">

                    <div
                        class="h-full rounded-full bg-gradient-to-r from-purple-500 to-pink-500 transition-all duration-700"
                        style="width: {{ $levelProgress }}%">
                    </div>

                </div>

                <p class="text-[10px] text-gray-400 font-semibold text-right mt-2">
                    {{ number_format($remainingXP) }} XP lagi!
                </p>

            </div>

        </div>

        {{-- PROGRESS BELAJAR --}}
        <div class="bg-white dark:bg-cyberdark-900 rounded-[2rem] p-5 border border-gray-100 dark:border-pink-950/40 shadow-xl shadow-emerald-500/5">

            <div class="flex items-center justify-between mb-5">

                <div>
                    <h3 class="text-sm font-black text-gray-900 dark:text-white">
                        Progress Belajar
                    </h3>

                    <p class="text-[10px] text-gray-400 font-semibold mt-1">
                        Perkembangan ruang belajar
                    </p>
                </div>

                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-chart-line text-emerald-500"></i>
                </div>

            </div>

            {{-- PERSENTASE PROGRESS --}}
            <div class="flex justify-between items-center mb-2">

                <span class="text-xs font-bold text-gray-600 dark:text-gray-300">
                    Penyelesaian Tahapan
                </span>

                <span class="text-sm font-black text-indigo-600 dark:text-indigo-400">
                    {{ $progressPersen }}%
                </span>

            </div>

            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-3 overflow-hidden p-[2px]">

                <div
                    class="bg-gradient-to-r from-emerald-400 to-teal-500 h-full rounded-full transition-all duration-700"
                    style="width: {{ $progressPersen }}%">
                </div>

            </div>

            <div class="flex justify-between items-center mt-3">

                <p class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold">
                    {{ $tahapanSelesai }} dari {{ $totalTahapan }} tahapan
                </p>

                <p class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold">
                    {{ $tahapanTersisa }} tersisa
                </p>

            </div>

            {{-- PESAN PROGRESS --}}
            <div class="mt-5 p-3 rounded-2xl flex items-start gap-2
                {{ $semuaTahapanSelesai
                    ? 'bg-emerald-50 dark:bg-emerald-900/20'
                    : 'bg-indigo-50 dark:bg-indigo-900/20' }}">

                <i class="fa-solid {{ $semuaTahapanSelesai ? 'fa-circle-check text-emerald-500' : 'fa-bullseye text-indigo-500' }} mt-0.5"></i>

                <p class="text-[10px] font-bold {{ $semuaTahapanSelesai ? 'text-emerald-700 dark:text-emerald-400' : 'text-indigo-700 dark:text-indigo-400' }}">

                    @if($semuaTahapanSelesai)

                        Hebat! Kamu telah menyelesaikan seluruh tahapan ruang belajar ini.

                    @elseif($tahapanSelesai > 0)

                        Bagus! Kamu sudah menyelesaikan {{ $tahapanSelesai }} tahapan. Lanjutkan perjalanan belajarmu!

                    @else

                        Yuk, mulai tahapan pertamamu dan kumpulkan EXP!

                    @endif

                </p>

            </div>

            {{-- EXP RUANG BELAJAR --}}
            <div class="mt-4 p-4 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30">

                <div class="flex items-center justify-between mb-3">

                    <div class="flex items-center gap-2">

                        <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                            <i class="fa-solid fa-bolt text-amber-500"></i>
                        </div>

                        <div>
                            <p class="text-xs font-black text-gray-800 dark:text-white">
                                EXP Ruang Belajar
                            </p>

                            <p class="text-[9px] text-gray-500 dark:text-gray-400">
                                EXP dari tahapan ini
                            </p>
                        </div>

                    </div>

                    <span class="text-xs font-black text-amber-600 dark:text-amber-400">
                        {{ number_format($expDiperoleh) }}
                        <span class="text-[9px]">/ {{ number_format($totalExp) }}</span>
                    </span>

                </div>

                <div class="w-full h-2 bg-amber-100 dark:bg-gray-700 rounded-full overflow-hidden">

                    <div
                        class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full transition-all duration-700"
                        style="width: {{ $totalExp > 0 ? min(100, ($expDiperoleh / $totalExp) * 100) : 0 }}%">
                    </div>

                </div>

            </div>

        </div>

        {{-- TOTAL XP DAN MEDALI --}}
        <div class="grid grid-cols-2 gap-3">

            {{-- TOTAL XP --}}
            <div class="relative overflow-hidden rounded-2xl p-4 bg-gradient-to-br from-amber-400 to-orange-500 shadow-lg shadow-amber-500/20">

                <div class="absolute -right-3 -top-3 w-16 h-16 bg-white/15 rounded-full"></div>

                <i class="fa-solid fa-bolt text-2xl text-white mb-3"></i>

                <p class="text-xl font-black text-white">
                    {{ number_format($studentXP) }}
                </p>

                <p class="text-[10px] font-extrabold text-white/80 uppercase tracking-wider">
                    Total XP
                </p>

                <p class="text-[9px] text-white/70 mt-1">
                    Seluruh ruang belajar
                </p>

            </div>

            {{-- MEDALI --}}
            <div class="relative overflow-hidden rounded-2xl p-4 bg-gradient-to-br from-sky-400 to-blue-600 shadow-lg shadow-blue-500/20">

                <div class="absolute -right-3 -top-3 w-16 h-16 bg-white/15 rounded-full"></div>

                <i class="fa-solid fa-medal text-2xl text-white mb-3"></i>

                <p class="text-xl font-black text-white">
                    {{ $totalMedals }}
                </p>

                <p class="text-[10px] font-extrabold text-white/80 uppercase tracking-wider">
                    Medali
                </p>

                <p class="text-[9px] text-white/70 mt-1">
                    Prestasi diperoleh
                </p>

            </div>

        </div>

        {{-- LEADERBOARD --}}
        <a
            href="{{ route('siswa.dashboard') }}"
            class="w-full flex items-center justify-center gap-2 py-4 px-4 rounded-2xl bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white font-black text-xs border-b-4 border-orange-600 shadow-lg shadow-amber-500/20 hover:-translate-y-1 active:translate-y-0 active:border-b-0 transition-all duration-200">

            <i class="fa-solid fa-trophy text-sm"></i>

            <span>LIHAT LEADERBOARD</span>

            <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>

        </a>

    </div>

</div>

@endsection

@push('scripts')
<script>
    function toggleTahapan(id) {

        // Tutup tombol tahapan lainnya.
        document.querySelectorAll('[id^="tahapan-action-"]').forEach(element => {

            if (element.id !== `tahapan-action-${id}`) {
                element.classList.add('hidden');
            }

        });

        // Tampilkan atau sembunyikan tombol tahapan terpilih.
        const selected = document.getElementById(`tahapan-action-${id}`);

        if (selected) {
            selected.classList.toggle('hidden');
        }
    }
</script>
@endpush
