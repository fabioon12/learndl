
@extends('siswa.layouts.app')

@section('title', 'Dashboard Siswa - LearnDL')

@section('content')

<div class="space-y-6">

    {{-- HEADER GREETING --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                Halo, {{ $user->fullname ?? 'Siswa' }}!
                <span class="animate-bounce">👋</span>
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Terus semangat belajar dan raih level berikutnya!
            </p>
        </div>

        <div class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400">
            <i class="fa-solid fa-calendar-day"></i>
            <span class="text-xs font-bold">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>


    {{-- GRID UTAMA --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- SISI KIRI --}}
        <div class="lg:col-span-8 space-y-6">

            {{-- BANNER LEVEL --}}
            <div class="relative bg-gradient-to-r from-indigo-500 via-purple-600 to-indigo-600 rounded-3xl p-6 text-white shadow-xl shadow-indigo-500/10 overflow-hidden">

                <div class="absolute -right-6 -bottom-8 opacity-20 pointer-events-none">
                    <i class="fa-solid fa-graduation-cap text-9xl"></i>
                </div>

                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">

                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-amber-400 text-amber-900 flex items-center justify-center text-3xl shadow-lg shrink-0">
                            <i class="fa-solid fa-medal"></i>
                        </div>

                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="text-xl font-bold tracking-tight">
                                    Level {{ $level }}
                                </h2>

                                <span class="px-2 py-0.5 bg-white/20 rounded-full text-[10px] font-semibold">
                                    Pelajar Aktif
                                </span>
                            </div>

                            <p class="text-xs text-purple-100 mt-1">
                                Kamu sudah mengumpulkan {{ number_format($totalXp) }} XP.
                            </p>
                        </div>
                    </div>

                    {{-- PROGRESS LEVEL --}}
                    <div class="w-full sm:w-64 space-y-1.5">
                        <div class="flex justify-between text-xs font-semibold text-purple-100">
                            <span>
                                {{ number_format($xpLevelSaatIni, 0, ',', '.') }}
                                /
                                {{ number_format($xpPerLevel, 0, ',', '.') }} XP
                            </span>

                            <span>{{ min(100, $progressLevel) }}%</span>
                        </div>

                        <div class="w-full h-3 bg-black/20 rounded-full overflow-hidden p-0.5">
                            <div
                                class="h-full bg-amber-400 rounded-full transition-all duration-500"
                                style="width: {{ min(100, $progressLevel) }}%">
                            </div>
                        </div>

                        <p class="text-[10px] text-purple-100">
                            {{ number_format(max(0, $xpPerLevel - $xpLevelSaatIni), 0, ',', '.') }}
                            XP lagi menuju level berikutnya.
                        </p>
                    </div>

                </div>
            </div>


            {{-- MINI STATISTICS --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                {{-- RUANG MATERI --}}
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-book"></i>
                    </div>

                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">
                            {{ $jumlahMateri }}
                        </h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">
                            Ruang Materi
                        </p>
                        <p class="text-[10px] text-gray-400">
                            Materi yang diikuti
                        </p>
                    </div>
                </div>

                {{-- XP HARI INI --}}
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-bolt"></i>
                    </div>

                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">
                            {{ number_format($xpHariIni) }}
                        </h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">
                            XP Hari Ini
                        </p>
                        <p class="text-[10px] text-gray-400">
                            Dari aktivitas belajar
                        </p>
                    </div>
                </div>

                {{-- RUANG BELAJAR --}}
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/40 text-purple-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>

                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">
                            {{ $jumlahRuangBelajar }}
                        </h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">
                            Ruang Belajar
                        </p>
                        <p class="text-[10px] text-gray-400">
                            Yang sedang diikuti
                        </p>
                    </div>
                </div>

                {{-- SUBMATERI SELESAI --}}
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>

                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">
                            {{ $jumlahSubmateriSelesai }}
                        </h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">
                            Submateri Selesai
                        </p>
                        <p class="text-[10px] text-gray-400">
                            Yang telah dipelajari
                        </p>
                    </div>
                </div>

            </div>


            {{-- RINGKASAN PROGRES BELAJAR --}}
            <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-sm">

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-sm font-extrabold text-gray-900 dark:text-white">
                            Progres Pembelajaran
                        </h2>
                        <p class="text-[11px] text-gray-400 mt-1">
                            Ringkasan penyelesaian seluruh submateri
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-extrabold text-sm">
                        {{ $progressKeseluruhan }}%
                    </div>
                </div>

                <div class="w-full h-3 bg-gray-100 dark:bg-cyberdark-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-500"
                         style="width: {{ $progressKeseluruhan }}%">
                    </div>
                </div>

                <div class="flex justify-between mt-2 text-[10px] text-gray-400">
                    <span>{{ $selesaiSubmateri }} submateri selesai</span>
                    <span>{{ $totalSubmateri }} total submateri</span>
                </div>
            </div>


            {{-- DAFTAR RUANG MATERI --}}
            <div class="space-y-4">

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-list-check text-indigo-500"></i>
                            Ruang Materi Saya
                        </h2>
                        <p class="text-[11px] text-gray-400 mt-1">
                            Lanjutkan pembelajaran yang sedang kamu ikuti
                        </p>
                    </div>

                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">
                        {{ $jumlahMateri }} Materi
                    </span>
                </div>

                @if($materis->isNotEmpty())

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">

                        @foreach($materis as $materi)

                            <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-4 hover:border-indigo-500/40 transition">

                                {{-- THUMBNAIL --}}
                                <div class="relative h-32 rounded-xl overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600">

                                    @if($materi->thumbnail)
                                        <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                             alt="{{ $materi->judul }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-white">
                                            <i class="fa-solid fa-book-open text-4xl opacity-70"></i>
                                        </div>
                                    @endif

                                    @if($materi->progress_persen >= 100 && $materi->total_submateri > 0)
                                        <span class="absolute top-2 right-2 px-2 py-1 bg-emerald-500 text-white text-[9px] font-bold rounded-full">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="absolute top-2 right-2 px-2 py-1 bg-white/90 text-indigo-600 text-[9px] font-bold rounded-full">
                                            Berlangsung
                                        </span>
                                    @endif

                                </div>

                                {{-- INFORMASI MATERI --}}
                                <div>
                                    <h3 class="text-xs font-extrabold text-gray-800 dark:text-white line-clamp-2">
                                        {{ $materi->judul }}
                                    </h3>

                                    <p class="text-[10px] text-gray-400 mt-1 line-clamp-2">
                                        {{ $materi->deskripsi ?: 'Pelajari materi dan selesaikan setiap aktivitas pembelajaran.' }}
                                    </p>

                                    <div class="mt-3 space-y-1.5">

                                        <div class="flex justify-between text-[10px] font-semibold text-gray-500 dark:text-gray-400">
                                            <span>
                                                {{ $materi->selesai_submateri }}/{{ $materi->total_submateri }} Submateri
                                            </span>
                                            <span>{{ $materi->progress_persen }}%</span>
                                        </div>

                                        <div class="w-full h-1.5 bg-gray-100 dark:bg-cyberdark-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-indigo-500 rounded-full transition-all"
                                                 style="width: {{ $materi->progress_persen }}%">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                {{-- TOMBOL LANJUT BELAJAR --}}
                                <div class="pt-2 border-t border-gray-100 dark:border-pink-950/20">
                                    <p class="text-[10px] text-gray-400">
                                        <i class="fa-solid fa-layer-group mr-1"></i>
                                        {{ $materi->total_submateri }} submateri tersedia
                                    </p>
                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="bg-white dark:bg-cyberdark-900 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700 p-8 text-center">

                        <div class="w-14 h-14 mx-auto rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-500 flex items-center justify-center text-2xl mb-3">
                            <i class="fa-solid fa-book-open"></i>
                        </div>

                        <h3 class="text-sm font-bold text-gray-700 dark:text-white">
                            Belum Ada Ruang Materi
                        </h3>

                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">
                            Kamu belum mengikuti ruang materi. Silakan eksplorasi ruang belajar yang tersedia.
                        </p>

                    </div>

                @endif

            </div>


            {{-- BANNER MOTIVASI --}}
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-cyberdark-900 dark:to-indigo-950/30 p-5 rounded-3xl border border-blue-100 dark:border-pink-950/20 flex flex-col sm:flex-row items-center justify-between gap-4">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shrink-0 text-lg">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-900 dark:text-white">
                            Terus Tingkatkan Kemampuanmu!
                        </h4>

                        <p class="text-[11px] text-gray-500 dark:text-gray-400">
                            Setiap langkah kecil dalam belajar membawamu lebih dekat pada tujuan.
                        </p>
                    </div>
                </div>

                <div class="px-5 py-2.5 bg-indigo-600 text-white text-xs font-bold rounded-2xl shadow-md shadow-indigo-500/20 shrink-0">
                    {{ number_format($totalXp) }} Total XP
                </div>

            </div>

        </div>


        {{-- SISI KANAN --}}
        <div class="lg:col-span-4 space-y-6">

            {{-- PROFIL RINGKAS --}}
            <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-sm">

                <div class="flex items-center gap-3">

                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-xl font-extrabold">
                        {{ strtoupper(substr($user->fullname ?? 'S', 0, 1)) }}
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-sm font-extrabold text-gray-900 dark:text-white truncate">
                            {{ $user->fullname ?? 'Siswa' }}
                        </h3>

                        <p class="text-[10px] text-gray-400 mt-1">
                            {{ $user->email ?? '-' }}
                        </p>

                        <span class="inline-flex mt-1 px-2 py-0.5 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded-full text-[9px] font-bold">
                            Level {{ $level }}
                        </span>
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-3 mt-5">

                    <div class="p-3 rounded-xl bg-gray-50 dark:bg-cyberdark-800">
                        <p class="text-[10px] text-gray-400">Total XP</p>
                        <p class="text-lg font-extrabold text-indigo-600 dark:text-indigo-400">
                            {{ number_format($totalXp) }}
                        </p>
                    </div>

                    <div class="p-3 rounded-xl bg-gray-50 dark:bg-cyberdark-800">
                        <p class="text-[10px] text-gray-400">Level</p>
                        <p class="text-lg font-extrabold text-purple-600 dark:text-purple-400">
                            {{ $level }}
                        </p>
                    </div>

                </div>
            </div>


            {{-- PERINGKAT KELAS --}}

{{-- ===================================================== --}}
{{-- LEADERBOARD CHALLENGE --}}
{{-- ===================================================== --}}
<div class="relative overflow-hidden rounded-3xl
            bg-gradient-to-br from-violet-700
            via-purple-700 to-fuchsia-600
            p-5 text-white shadow-xl
            shadow-purple-500/10">

    {{-- DEKORASI --}}
    <div class="absolute -right-8 -top-8 h-32 w-32
                rounded-full bg-white/10 blur-2xl">
    </div>

    <div class="absolute -bottom-10 -left-8 h-32 w-32
                rounded-full bg-pink-400/20 blur-2xl">
    </div>

    <div class="relative z-10 space-y-5">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <div>
                <span class="inline-flex items-center gap-1.5
                             rounded-full border border-white/20
                             bg-white/10 px-2.5 py-1
                             text-[9px] font-black
                             tracking-widest text-purple-100">

                    <i class="fa-solid fa-fire"></i>
                    COMPETITION

                </span>

                <h3 class="mt-3 text-base font-black">
                    Hall of Champions
                </h3>

                <p class="mt-1 text-[10px] leading-relaxed
                          text-purple-100">
                    Siapa petualang terbaik hari ini?
                </p>
            </div>

            <div class="flex h-14 w-14 shrink-0
                        items-center justify-center
                        rounded-2xl bg-white/15
                        text-3xl shadow-lg">
                🏆
            </div>

        </div>


        {{-- MINI PODIUM --}}
        <div class="grid grid-cols-3 items-end gap-2">

            {{-- JUARA 2 --}}
            <div class="text-center">

                <div class="mx-auto flex h-9 w-9 items-center
                            justify-center rounded-full
                            bg-white/15 text-lg">
                    🥈
                </div>

                <div class="mt-2 flex h-12 items-center
                            justify-center rounded-t-xl
                            bg-white/20">

                    <span class="text-lg font-black">#2</span>

                </div>

            </div>


            {{-- JUARA 1 --}}
            <div class="text-center">

                <div class="mx-auto flex h-11 w-11 items-center
                            justify-center rounded-full
                            bg-amber-300 text-2xl
                            shadow-lg shadow-amber-300/20">
                    🥇
                </div>

                <div class="mt-2 flex h-16 items-center
                            justify-center rounded-t-xl
                            bg-amber-400 text-amber-950">

                    <span class="text-2xl font-black">#1</span>

                </div>

            </div>


            {{-- JUARA 3 --}}
            <div class="text-center">

                <div class="mx-auto flex h-9 w-9 items-center
                            justify-center rounded-full
                            bg-white/15 text-lg">
                    🥉
                </div>

                <div class="mt-2 flex h-10 items-center
                            justify-center rounded-t-xl
                            bg-white/20">

                    <span class="text-lg font-black">#3</span>

                </div>

            </div>

        </div>


        {{-- MOTIVASI --}}
        <div class="rounded-2xl border border-white/15
                    bg-white/10 p-3">

            <div class="flex items-center gap-2">

                <div class="flex h-9 w-9 shrink-0
                            items-center justify-center
                            rounded-xl bg-amber-400/20
                            text-amber-300">

                    <i class="fa-solid fa-bolt"></i>

                </div>

                <div class="min-w-0">

                    <p class="text-[10px] font-bold text-purple-100">
                        XP yang sudah kamu kumpulkan
                    </p>

                    <p class="text-lg font-black">
                        {{ number_format($totalXp, 0, ',', '.') }} XP
                    </p>

                </div>

            </div>

        </div>


        {{-- CTA LEADERBOARD --}}
        <a href="{{ route('siswa.leaderboard.index') }}"
           class="flex w-full items-center
                  justify-between rounded-xl
                  bg-white px-4 py-3
                  text-xs font-black text-purple-700
                  shadow-lg transition-all
                  hover:-translate-y-0.5
                  hover:bg-purple-50
                  active:scale-[0.98]">

            <span>
                LIHAT LEADERBOARD
            </span>

            <i class="fa-solid fa-arrow-right"></i>

        </a>

        <p class="text-center text-[9px] text-purple-100">
            Terus kumpulkan XP dan raih posisi juara! 🚀
        </p>

    </div>

</div>



            {{-- INFORMASI XP --}}
            <div class="bg-gradient-to-br from-amber-400 to-orange-500 p-5 rounded-3xl text-white shadow-lg shadow-orange-500/10">

                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-white/20 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-bolt"></i>
                    </div>

                    <div>
                        <h3 class="text-sm font-extrabold">
                            Kumpulkan Lebih Banyak XP!
                        </h3>
                        <p class="text-[10px] text-white/80 mt-1">
                            Selesaikan materi dan tahapan pembelajaran.
                        </p>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-white/20">
                    <p class="text-[10px] text-white/80">
                        XP yang sudah kamu kumpulkan
                    </p>
                    <p class="text-2xl font-black mt-1">
                        {{ number_format($totalXp) }} XP
                    </p>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
