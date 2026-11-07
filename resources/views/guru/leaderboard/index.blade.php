
@extends('guru.layouts.app')

@section('title', 'Leaderboard Siswa')

@section('content')

<div class="mx-auto max-w-7xl space-y-6 p-4 sm:p-6">

    {{-- HEADER --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-black uppercase tracking-widest
                      text-purple-600 dark:text-purple-400">
                Monitoring Gamifikasi
            </p>

            <h1 class="mt-1 text-2xl font-black
                       text-gray-900 dark:text-white">
                🏆 Leaderboard Siswa
            </h1>

            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Pantau peringkat, level, dan pencapaian XP siswa.
            </p>
        </div>

        <span class="rounded-xl border border-purple-200
                     bg-purple-50 px-4 py-2 text-xs font-bold
                     text-purple-700 dark:border-purple-500/20
                     dark:bg-purple-500/10 dark:text-purple-300">
            ⚡ 1.000 XP = 1 Level
        </span>
    </div>


    {{-- PODIUM TOP 3 --}}
    <section class="rounded-3xl border border-gray-200
                    bg-white p-5 shadow-sm
                    dark:border-white/10 dark:bg-cyberdark-800">

        <div class="mb-7 text-center">

            <span class="rounded-full bg-amber-500/10
                         px-4 py-2 text-xs font-black
                         text-amber-600 dark:text-amber-400">
                👑 TOP CHAMPIONS
            </span>

            <h2 class="mt-4 text-xl font-black
                       text-gray-900 dark:text-white">
                Tiga Siswa Terbaik
            </h2>

            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Berdasarkan perolehan XP global tertinggi
            </p>
        </div>

        <div class="grid grid-cols-3 items-end gap-2 sm:gap-5">

            @foreach([1, 0, 2] as $position)

                @php
                    $student = $topThree->get($position);
                    $rank = $position + 1;

                    $medal = match($rank) {
                        1 => '🥇',
                        2 => '🥈',
                        default => '🥉'
                    };

                    $height = match($rank) {
                        1 => 'h-40 sm:h-48',
                        2 => 'h-28 sm:h-36',
                        default => 'h-24 sm:h-32'
                    };

                    $gradient = match($rank) {
                        1 => 'from-yellow-400 to-amber-500',
                        2 => 'from-slate-300 to-slate-500',
                        default => 'from-orange-300 to-orange-600'
                    };
                @endphp

                <div class="min-w-0 text-center">

                    @if($student)

                        <div class="mb-4 flex flex-col items-center">

                            <div class="flex h-14 w-14 items-center
                                        justify-center rounded-full
                                        bg-purple-100 text-2xl
                                        dark:bg-purple-500/20">
                                {{ $medal }}
                            </div>

                            <p class="mt-3 w-full truncate text-xs
                                      font-black text-gray-900
                                      dark:text-white sm:text-sm"
                               title="{{ $student->fullname ?? $student->name }}">
                                {{ $student->fullname ?? $student->name }}
                            </p>

                            <p class="mt-1 text-[11px] font-bold
                                      text-purple-500">
                                Level {{ $student->level_game }}
                            </p>

                            <p class="mt-2 text-xs font-black text-amber-500">
                                ⚡ {{ number_format($student->total_xp, 0, ',', '.') }} XP
                            </p>
                        </div>

                    @else

                        <p class="mb-4 text-xs text-gray-400">
                            Belum ada siswa
                        </p>

                    @endif

                    <div class="{{ $height }}
                                flex items-center justify-center
                                rounded-t-2xl bg-gradient-to-b
                                {{ $gradient }} text-white shadow-lg">

                        <span class="text-3xl font-black">
                            #{{ $rank }}
                        </span>
                    </div>
                </div>

            @endforeach
        </div>
    </section>

    {{-- TABEL LEADERBOARD --}}
    <section class="overflow-hidden rounded-3xl
                    border border-gray-200 bg-white shadow-sm
                    dark:border-white/10 dark:bg-cyberdark-800">

        {{-- HEADER TABEL --}}
        <div class="flex flex-col gap-4 border-b
                    border-gray-100 p-5 dark:border-white/10
                    sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-black text-gray-900 dark:text-white">
                    📊 Ranking Seluruh Siswa
                </h2>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Data XP dan progres misi seluruh siswa
                </p>
            </div>

            {{-- PENCARIAN GLOBAL --}}
            <form method="GET"
                  action="{{ url()->current() }}"
                  class="flex w-full gap-2 sm:w-auto">

                <div class="relative min-w-0 flex-1 sm:w-64">

                    <i class="fa-solid fa-magnifying-glass
                              absolute left-3 top-1/2
                              -translate-y-1/2 text-xs text-gray-400"></i>

                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama siswa..."
                        class="w-full rounded-xl border border-gray-200
                               bg-gray-50 py-2.5 pl-9 pr-3
                               text-xs text-gray-900 outline-none
                               focus:border-purple-400
                               focus:ring-2 focus:ring-purple-500/10
                               dark:border-white/10 dark:bg-white/5
                               dark:text-white"
                    >
                </div>

                <button type="submit"
                        class="rounded-xl bg-purple-600 px-4 py-2
                               text-xs font-bold text-white
                               transition hover:bg-purple-700">
                    Cari
                </button>

                @if(request()->filled('search'))
                    <a href="{{ url()->current() }}"
                       class="flex items-center justify-center
                              rounded-xl border border-gray-200
                              px-3 text-gray-500 transition
                              hover:bg-gray-100
                              dark:border-white/10
                              dark:text-gray-300 dark:hover:bg-white/10"
                       title="Hapus pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif

            </form>
        </div>

        {{-- INFO PENCARIAN --}}
        @if(request()->filled('search'))

            <div class="border-b border-purple-100
                        bg-purple-50/50 px-5 py-3
                        dark:border-purple-500/10
                        dark:bg-purple-500/5">

                <p class="text-xs text-purple-700 dark:text-purple-300">
                    Hasil pencarian untuk
                    <strong>"{{ request('search') }}"</strong>

                    <span class="ml-1 font-bold">
                        ({{ $leaderboard->total() }} siswa)
                    </span>
                </p>
            </div>

        @endif

        {{-- TABEL --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[650px] text-left text-sm">

                <thead class="bg-gray-50 text-[11px] uppercase
                              text-gray-500 dark:bg-white/5">
                    <tr>
                        <th class="px-5 py-4">Peringkat</th>
                        <th class="px-5 py-4">Nama Siswa</th>
                        <th class="px-5 py-4">Level</th>
                        <th class="px-5 py-4">Misi Selesai</th>
                        <th class="px-5 py-4 text-right">Total XP</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100
                              dark:divide-white/10">

                    @forelse($leaderboard as $student)

                        @php
                            $studentName = $student->fullname
                                ?? $student->name
                                ?? 'Siswa';

                            $xpInLevel = (int) $student->total_xp % 1000;
                            $xpPercent = ($xpInLevel / 1000) * 100;
                        @endphp

                        <tr class="transition-colors
                                   hover:bg-gray-50 dark:hover:bg-white/5">

                            {{-- RANKING --}}
                            <td class="px-5 py-4 font-black
                                       text-gray-900 dark:text-white">

                                @if($student->peringkat === 1)
                                    🥇
                                @elseif($student->peringkat === 2)
                                    🥈
                                @elseif($student->peringkat === 3)
                                    🥉
                                @else
                                    #{{ $student->peringkat }}
                                @endif
                            </td>

                            {{-- NAMA SISWA --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0
                                                items-center justify-center
                                                rounded-xl bg-purple-100
                                                font-black text-purple-600
                                                dark:bg-purple-500/20">

                                        {{ mb_strtoupper(mb_substr($studentName, 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <p class="font-bold text-gray-900
                                                  dark:text-white">
                                            {{ $studentName }}
                                        </p>

                                        <p class="mt-1 text-[10px] text-gray-400">
                                            Penjelajah Pengetahuan
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- LEVEL --}}
                            <td class="px-5 py-4">

                                <span class="rounded-lg bg-purple-100
                                             px-3 py-1 text-xs font-black
                                             text-purple-700
                                             dark:bg-purple-500/20
                                             dark:text-purple-300">

                                    Lv. {{ $student->level_game }}
                                </span>

                                <div class="mt-2 h-1.5 w-24 overflow-hidden
                                            rounded-full bg-gray-100
                                            dark:bg-gray-700">

                                    <div class="h-full rounded-full
                                                bg-gradient-to-r
                                                from-purple-500 to-pink-500"
                                         style="width: {{ $xpPercent }}%">
                                    </div>
                                </div>

                                <p class="mt-1 text-[10px]
                                          text-gray-400">
                                    {{ number_format($xpInLevel, 0, ',', '.') }}
                                    / 1.000 XP
                                </p>
                            </td>

                            {{-- MISI --}}
                            <td class="px-5 py-4 font-bold
                                       text-gray-600 dark:text-gray-300">

                                {{ number_format($student->total_misi, 0, ',', '.') }}
                            </td>

                            {{-- TOTAL XP --}}
                            <td class="px-5 py-4 text-right
                                       font-black text-amber-500">

                                ⚡ {{ number_format($student->total_xp, 0, ',', '.') }} XP
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5"
                                class="px-5 py-12 text-center">

                                <div class="flex flex-col items-center gap-3">

                                    <div class="flex h-14 w-14
                                                items-center justify-center
                                                rounded-2xl bg-gray-100
                                                text-gray-400
                                                dark:bg-white/5">

                                        <i class="fa-solid fa-users-slash
                                                  text-xl"></i>
                                    </div>

                                    <p class="text-sm font-bold
                                              text-gray-600 dark:text-gray-300">

                                        @if(request()->filled('search'))
                                            Siswa tidak ditemukan.
                                        @else
                                            Belum ada data siswa.
                                        @endif
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        @if(request()->filled('search'))
                                            Coba gunakan kata kunci lain.
                                        @else
                                            Data leaderboard belum tersedia.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="flex flex-col gap-4 border-t
                    border-gray-100 px-5 py-5
                    dark:border-white/10
                    sm:flex-row sm:items-center sm:justify-between">

            {{-- INFORMASI --}}
            <p class="text-xs font-medium
                      text-gray-500 dark:text-gray-400">

                @if($leaderboard->total() > 0)

                    Menampilkan

                    <span class="font-black
                                 text-gray-900 dark:text-white">
                        {{ $leaderboard->firstItem() }}
                    </span>

                    -

                    <span class="font-black
                                 text-gray-900 dark:text-white">
                        {{ $leaderboard->lastItem() }}
                    </span>

                    dari

                    <span class="font-black
                                 text-purple-600 dark:text-purple-400">
                        {{ $leaderboard->total() }}
                    </span>

                    siswa

                @else
                    Tidak ada siswa untuk ditampilkan
                @endif
            </p>

            {{-- TOMBOL PAGINATION --}}
            @if($leaderboard->hasPages())

                <div class="flex flex-wrap items-center gap-2">

                    {{-- PREVIOUS --}}
                    @if($leaderboard->onFirstPage())

                        <span class="flex h-9 w-9 cursor-not-allowed
                                     items-center justify-center rounded-xl
                                     bg-gray-100 text-gray-300
                                     dark:bg-white/5 dark:text-gray-600">

                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </span>

                    @else

                        <a href="{{ $leaderboard->previousPageUrl() }}"
                           class="flex h-9 w-9 items-center justify-center
                                  rounded-xl border border-gray-200
                                  bg-white text-gray-600 transition
                                  hover:border-purple-400
                                  hover:bg-purple-50 hover:text-purple-600
                                  dark:border-white/10 dark:bg-white/5
                                  dark:text-gray-300">

                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </a>

                    @endif

                    {{-- NOMOR HALAMAN --}}
                    @php
                        $startPage = max(
                            1,
                            $leaderboard->currentPage() - 2
                        );

                        $endPage = min(
                            $leaderboard->lastPage(),
                            $leaderboard->currentPage() + 2
                        );
                    @endphp

                    @foreach($leaderboard->getUrlRange($startPage, $endPage) as $pageNumber => $url)

                        @if($pageNumber == $leaderboard->currentPage())

                            <span aria-current="page"
                                  class="flex h-9 min-w-9 items-center
                                         justify-center rounded-xl
                                         bg-gradient-to-r from-purple-600
                                         to-pink-500 px-2 text-xs
                                         font-black text-white shadow-md
                                         shadow-purple-500/20">

                                {{ $pageNumber }}
                            </span>

                        @else

                            <a href="{{ $url }}"
                               class="flex h-9 min-w-9 items-center
                                      justify-center rounded-xl
                                      border border-gray-200 bg-white
                                      px-2 text-xs font-bold text-gray-600
                                      transition hover:border-purple-400
                                      hover:bg-purple-50
                                      hover:text-purple-600
                                      dark:border-white/10 dark:bg-white/5
                                      dark:text-gray-300">

                                {{ $pageNumber }}
                            </a>

                        @endif

                    @endforeach

                    {{-- NEXT --}}
                    @if($leaderboard->hasMorePages())

                        <a href="{{ $leaderboard->nextPageUrl() }}"
                           class="flex h-9 w-9 items-center justify-center
                                  rounded-xl border border-gray-200
                                  bg-white text-gray-600 transition
                                  hover:border-purple-400
                                  hover:bg-purple-50
                                  hover:text-purple-600
                                  dark:border-white/10 dark:bg-white/5
                                  dark:text-gray-300">

                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>

                    @else

                        <span class="flex h-9 w-9 cursor-not-allowed
                                     items-center justify-center rounded-xl
                                     bg-gray-100 text-gray-300
                                     dark:bg-white/5 dark:text-gray-600">

                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </span>

                    @endif
                </div>

            @endif
        </div>
    </section>
</div>

@endsection
