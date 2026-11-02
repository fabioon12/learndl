@extends('siswa.layouts.app')

@section('title', 'Tahapan Ruang Belajar Saya')

@section('content')
@push('styles')
<style>
@media (max-width: 640px) {
    .learning-node {
        transform: translateX(
            calc(var(--offset-x) * 0.45)
        ) !important;
    }
}
</style>
@endpush

@php
    // ==========================================
    // DATA LEARNING PATH
    // ==========================================

    $user = Auth::user();
    $offsets = [0, 65, 105, 65, 0, -65, -105, -65];

    $totalTahapan = $tahapans->count();

    $completedTahapan = $tahapans->filter(function ($tahapan) {
        $progress = $tahapan->userProgress->first();

        $status = $progress
            ? $progress->status
            : $tahapan->status;

        return $status === 'selesai';
    })->count();

    $progressPercent = $totalTahapan > 0
        ? round(($completedTahapan / $totalTahapan) * 100)
        : 0;

    $remainingTahapan = max(0, $totalTahapan - $completedTahapan);

    // ==========================================
    // DATA SISWA
    // ==========================================

    $studentLevel = $user->level ?? 1;
    $studentXP = $user->exp ?? 0;
    $totalMedals = $medals ?? 0;

    // Asumsi 1000 XP untuk setiap level
    $xpPerLevel = 1000;
    $currentLevelXP = $studentXP % $xpPerLevel;
    $levelProgress = ($currentLevelXP / $xpPerLevel) * 100;
    $remainingXP = $xpPerLevel - $currentLevelXP;
@endphp


@include('siswa.ruang-belajar.tahapan.partials.header')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 xl:gap-8 items-start">

    <div class="lg:col-span-8 min-w-0">
        <div class="bg-white/60 dark:bg-cyberdark-900/40 rounded-[2rem] p-4 sm:p-6 lg:p-8 border border-gray-100 dark:border-gray-800">
            
            {{-- Learning Path Heading --}}
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

                        $status = $userProg
                            ? $userProg->status
                            : $tahapan->status;

                        $isLast = $index === $totalTahapan - 1;

                        $nextOffset = !$isLast
                            ? $offsets[($index + 1) % count($offsets)]
                            : $offsetX;

                        // Data kurva penghubung
                        $svgCenter = 160;
                        $startX = $svgCenter + $offsetX;
                        $endX = $svgCenter + $nextOffset;
                        $curve = $nextOffset - $offsetX;
                        $controlX = $curve * 0.55;

                        $pathColor = $status === 'selesai'
                            ? '#FBBF24'
                            : '#CBD5E1';
                    @endphp

                    {{-- NODE --}}
                    <div class="relative z-10 flex flex-col items-center transition-transform duration-300"
                        style="transform: translateX({{ $offsetX }}px);">

                        {{-- XP TOOLTIP --}}
                        @if ($status === 'aktif')
                            <div class="relative z-30 mb-3 bg-emerald-500 text-white text-[11px] font-black px-4 py-2 rounded-2xl uppercase tracking-wider shadow-lg shadow-emerald-500/30 border-b-4 border-emerald-700 flex items-center gap-2 animate-bounce whitespace-nowrap">
                                <span>MULAI</span>
                                <span class="bg-emerald-700/50 px-2 py-1 rounded-lg text-[10px]">
                                    +{{ $tahapan->xp_reward }} XP
                                </span>
                                <span class="absolute top-full left-1/2 -translate-x-1/2 border-[7px] border-transparent border-t-emerald-500"></span>
                            </div>
                        @else
                            <div class="h-3"></div>
                        @endif

                        {{-- ICON NODE --}}
                        <div class="relative w-24 h-24 flex items-center justify-center">

                            {{-- SELESAI --}}
                            @if ($status === 'selesai')
                                <a href="#"
                                    title="{{ $tahapan->judul_tahapan }}"
                                    class="w-20 h-20 rounded-full bg-gradient-to-b from-amber-300 to-amber-500 border-b-[7px] border-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/25 hover:scale-110 hover:brightness-110 active:translate-y-1 transition-all duration-200">
                                    <i class="fa-solid {{ $tahapan->icon ?? 'fa-check' }} text-3xl text-white drop-shadow-md"></i>
                                </a>

                            {{-- AKTIF --}}
                            @elseif ($status === 'aktif')
                                <a href="#"
                                    title="{{ $tahapan->judul_tahapan }}"
                                    class="relative w-24 h-24 rounded-full bg-gradient-to-b from-emerald-400 to-emerald-600 border-b-[8px] border-emerald-800 ring-[6px] ring-emerald-400/25 flex items-center justify-center shadow-xl shadow-emerald-500/30 hover:scale-110 hover:brightness-110 active:translate-y-1 transition-all duration-200">
                                    <span class="absolute inset-2 rounded-full border border-white/20"></span>
                                    <i class="fa-solid {{ $tahapan->icon ?? 'fa-play' }} text-4xl text-white drop-shadow-lg"></i>
                                </a>

                            {{-- TERKUNCI --}}
                            @else
                                <div title="Tahapan Terkunci"
                                    class="relative w-20 h-20 rounded-full bg-gradient-to-b from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 border-b-[7px] border-gray-300 dark:border-gray-900 flex items-center justify-center shadow-inner opacity-90 cursor-not-allowed">
                                    
                                    {{-- ICON ASLI TAHAPAN --}}
                                    <i class="fa-solid {{ $tahapan->icon ?? 'fa-star' }} text-3xl text-gray-400 dark:text-gray-300"></i>

                                    {{-- LOCK BADGE --}}
                                    <span class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-gray-500 dark:bg-gray-600 border-[3px] border-white dark:border-cyberdark-900 flex items-center justify-center shadow-md">
                                        <i class="fa-solid fa-lock text-[10px] text-white"></i>
                                    </span>
                                </div>
                            @endif

                        </div>

                        {{-- JUDUL DAN STATUS --}}
                        <div class="mt-3 flex flex-col items-center text-center min-h-[65px]">
                            <span class="text-xs font-extrabold text-gray-700 dark:text-gray-200 max-w-[150px] line-clamp-2">
                                {{ $tahapan->judul_tahapan }}
                            </span>

                            @if ($status === 'selesai')
                                <span class="mt-2 px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-[9px] font-black uppercase">
                                    Selesai
                                </span>
                            @elseif ($status === 'aktif')
                                <span class="mt-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[9px] font-black uppercase">
                                    Sedang Dipelajari
                                </span>
                            @else
                                <span class="mt-2 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-[9px] font-black uppercase">
                                    Terkunci
                                </span>
                            @endif
                        </div>

                    </div>

                    {{-- JALUR PENGHUBUNG ZIG-ZAG --}}
                    @if (!$isLast)
                        <div class="relative w-full h-24 shrink-0">
                            <svg class="absolute pointer-events-none"
                                style="left: calc(50% - 160px); top: 0; width: 320px; height: 96px; overflow: visible;"
                                viewBox="0 0 320 96"
                                fill="none">

                                {{-- Shadow Path --}}
                                <path
                                    d="M {{ $startX }} 0 C {{ $startX + $controlX }} 32, {{ $endX - $controlX }} 64, {{ $endX }} 96"
                                    stroke="#94A3B8"
                                    stroke-width="9"
                                    stroke-linecap="round"
                                    stroke-dasharray="2 14"
                                    opacity="0.15"
                                />

                                {{-- Main Path --}}
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

    <div class="lg:col-span-4 min-w-0 space-y-5 lg:sticky lg:top-6">

        <div class="relative overflow-hidden bg-white dark:bg-cyberdark-900 rounded-[2rem] p-5 border border-gray-100 dark:border-pink-950/40 shadow-xl shadow-purple-500/5">
            
            {{-- Decoration --}}
            <div class="absolute -top-16 -right-16 w-40 h-40 rounded-full bg-purple-100/70 dark:bg-purple-900/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="relative shrink-0">
                        <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed={{ urlencode($user->fullname ?? 'Siswa') }}&backgroundColor=b6e3f4"
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

                {{-- XP LEVEL PROGRESS --}}
                <div class="border-t border-gray-100 dark:border-gray-700/50 my-5"></div>

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
                    <div class="h-full rounded-full bg-gradient-to-r from-purple-500 to-pink-500 transition-all duration-700"
                        style="width: {{ $levelProgress }}%">
                    </div>
                </div>

                <p class="text-[10px] text-gray-400 font-semibold text-right mt-2">
                    {{ number_format($remainingXP) }} XP lagi!
                </p>
            </div>
        </div>

        {{-- ================================= --}}
        {{-- LEARNING PROGRESS CARD --}}
        {{-- ================================= --}}
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

            {{-- Circular Progress --}}
            <div class="flex items-center gap-5">
                <div class="relative w-28 h-28 shrink-0">
                    <svg viewBox="0 0 120 120" class="w-full h-full -rotate-90">
                        <circle cx="60" cy="60" r="48"
                            stroke="#E5E7EB"
                            stroke-width="11"
                            fill="none" />
                        <circle cx="60" cy="60" r="48"
                            stroke="#10B981"
                            stroke-width="11"
                            fill="none"
                            stroke-linecap="round"
                            stroke-dasharray="301.59"
                            stroke-dashoffset="{{ 301.59 - (301.59 * $progressPercent / 100) }}"
                            class="transition-all duration-1000" />
                    </svg>

                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-black text-gray-900 dark:text-white">
                            {{ $progressPercent }}%
                        </span>
                        <span class="text-[9px] font-bold text-gray-400 uppercase">
                            Selesai
                        </span>
                    </div>
                </div>

                {{-- Progress Details --}}
                <div class="flex-1 space-y-4">
                    <div>
                        <p class="text-xl font-black text-emerald-500">
                            {{ $completedTahapan }}
                            <span class="text-xs text-gray-400">/ {{ $totalTahapan }}</span>
                        </p>
                        <p class="text-[10px] font-semibold text-gray-500 dark:text-gray-400">
                            Tahapan selesai
                        </p>
                    </div>

                    <div>
                        <p class="text-xl font-black text-gray-700 dark:text-white">
                            {{ $remainingTahapan }}
                        </p>
                        <p class="text-[10px] font-semibold text-gray-500 dark:text-gray-400">
                            Tahapan tersisa
                        </p>
                    </div>
                </div>
            </div>

            {{-- Progress Message --}}
            <div class="mt-5 p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center gap-2">
                <i class="fa-solid fa-bullseye text-emerald-500"></i>
                <p class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400">
                    Terus belajar dan selesaikan semua tahapan!
                </p>
            </div>
        </div>

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
            </div>

            {{-- MEDALS --}}
            <div class="relative overflow-hidden rounded-2xl p-4 bg-gradient-to-br from-sky-400 to-blue-600 shadow-lg shadow-blue-500/20">
                <div class="absolute -right-3 -top-3 w-16 h-16 bg-white/15 rounded-full"></div>
                <i class="fa-solid fa-medal text-2xl text-white mb-3"></i>
                <p class="text-xl font-black text-white">
                    {{ $totalMedals }}
                </p>
                <p class="text-[10px] font-extrabold text-white/80 uppercase tracking-wider">
                    Medali
                </p>
            </div>
        </div>

        <a href="{{ route('siswa.dashboard') }}"
            class="w-full flex items-center justify-center gap-2 py-4 px-4 rounded-2xl bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white font-black text-xs border-b-4 border-orange-600 shadow-lg shadow-amber-500/20 hover:-translate-y-1 active:translate-y-0 active:border-b-0 transition-all duration-200">
            <i class="fa-solid fa-trophy text-sm"></i>
            <span>LIHAT LEADERBOARD</span>
            <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
        </a>

    </div>
</div>

@endsection