
@extends('siswa.layouts.app')

@section('title', 'Leaderboard Siswa')

@section('content')

<div
    x-data="{ search: '' }"
    class="mx-auto max-w-7xl space-y-7 px-4 py-6 sm:px-6 lg:px-8"
>

    {{-- ===================================================== --}}
    {{-- HERO --}}
    {{-- ===================================================== --}}
    <section class="relative overflow-hidden rounded-3xl
                    bg-gradient-to-br from-violet-700
                    via-purple-700 to-fuchsia-600
                    px-6 py-10 text-center text-white
                    shadow-xl shadow-purple-500/10">

        <div class="absolute -left-10 -top-10 h-40 w-40
                    rounded-full bg-white/10 blur-3xl"></div>

        <div class="absolute -bottom-12 -right-8 h-48 w-48
                    rounded-full bg-pink-400/20 blur-3xl"></div>

        <div class="relative z-10">

            <span class="inline-flex items-center gap-2
                         rounded-full border border-white/20
                         bg-white/10 px-4 py-2 text-xs
                         font-black tracking-widest">
                ✨ HALL OF CHAMPIONS
            </span>

            <div class="mt-4 text-5xl">🏆</div>

            <h1 class="mt-3 text-3xl font-black sm:text-4xl">
                Leaderboard Siswa
            </h1>

            <p class="mx-auto mt-3 max-w-lg text-sm
                      leading-relaxed text-purple-100">
                Taklukkan misi pembelajaran, kumpulkan XP,
                naikkan level, dan jadilah petualang terbaik!
            </p>

            <div class="mt-6 flex flex-wrap justify-center gap-3">

                <span class="rounded-xl border border-white/20
                             bg-white/10 px-4 py-2 text-xs font-bold">
                    👥 {{ $leaderboard->total() }} Petualang
                </span>

                <span class="rounded-xl border border-white/20
                             bg-white/10 px-4 py-2 text-xs font-bold">
                    ⚡ Ranking XP Global
                </span>

            </div>

        </div>

    </section>


    {{-- ===================================================== --}}
    {{-- TOP 3 PODIUM --}}
    {{-- ===================================================== --}}
    <section class="rounded-3xl border border-gray-200
                    bg-white p-5 shadow-sm
                    dark:border-white/10
                    dark:bg-cyberdark-800 sm:p-8">

        <div class="mb-8 text-center">

            <h2 class="text-xl font-black text-gray-900
                       dark:text-white">
                👑 Top 3 Champions
            </h2>

            <p class="mt-2 text-xs text-gray-500
                      dark:text-gray-400">
                Tiga petualang dengan XP tertinggi
            </p>

        </div>

        <div class="grid grid-cols-3 items-end gap-2 sm:gap-5">

            @foreach([1, 0, 2] as $position)

                @php
                    $student = $topThree->values()->get($position);
                    $rank = $position + 1;

                    $medal = match ($rank) {
                        1 => '🥇',
                        2 => '🥈',
                        default => '🥉'
                    };

                    $height = match ($rank) {
                        1 => 'h-40 sm:h-48',
                        2 => 'h-28 sm:h-36',
                        default => 'h-24 sm:h-32'
                    };

                    $gradient = match ($rank) {
                        1 => 'from-yellow-400 to-amber-500',
                        2 => 'from-slate-300 to-slate-500',
                        default => 'from-orange-300 to-orange-600'
                    };

                    $studentName = $student
                        ? ($student->fullname ?? $student->name ?? 'Siswa')
                        : null;
                @endphp

                <div class="min-w-0 text-center">

                    @if($student)

                        <div class="mb-4 flex flex-col items-center">

                            {{-- MEDAL --}}
                            <div class="relative">

                                <div class="flex h-12 w-12 items-center
                                            justify-center rounded-full
                                            bg-purple-100 text-xl
                                            ring-4 ring-purple-50
                                            dark:bg-purple-500/20
                                            dark:ring-purple-500/10
                                            sm:h-16 sm:w-16">

                                    {{ $medal }}

                                </div>

                                @if($rank === 1)
                                    <span class="absolute -top-5 left-1/2
                                                 -translate-x-1/2 text-2xl">
                                        👑
                                    </span>
                                @endif

                            </div>

                            {{-- NAMA SISWA --}}
                            <p class="mt-4 max-w-full truncate
                                      text-xs font-black text-gray-900
                                      dark:text-white sm:text-sm"
                               title="{{ $studentName }}">

                                {{ $studentName }}

                            </p>

                            {{-- JURUSAN --}}
                            <p class="mt-1 max-w-full truncate
                                      text-[10px] font-bold
                                      text-violet-600
                                      dark:text-violet-400"
                               title="{{ $student->major_or_subject }}">

                                {{ $student->major_or_subject ?: 'Jurusan belum diisi' }}

                            </p>

                            {{-- OFFERING --}}
                            <p class="mt-1 max-w-full truncate
                                      text-[9px] text-gray-500
                                      dark:text-gray-400">

                                {{ $student->offering ?: 'Offering belum diisi' }}

                            </p>

                            {{-- SEKOLAH --}}
                            <p class="mt-1 max-w-full truncate
                                      text-[9px] text-gray-400
                                      dark:text-gray-500"
                               title="{{ $student->school_name }}">

                                {{ $student->school_name ?: 'Sekolah belum diisi' }}

                            </p>

                            {{-- LEVEL --}}
                            <span class="mt-2 rounded-full
                                         bg-purple-100 px-2 py-1
                                         text-[10px] font-black
                                         text-purple-700
                                         dark:bg-purple-500/20
                                         dark:text-purple-300">

                                Level {{ $student->level_game }}

                            </span>

                            {{-- XP --}}
                            <p class="mt-2 text-xs font-black
                                      text-amber-500 sm:text-sm">

                                ⚡ {{ number_format($student->total_xp, 0, ',', '.') }}

                            </p>

                        </div>

                    @else

                        <div class="mb-4 py-6 text-center
                                    text-xs text-gray-400">
                            Belum ada siswa
                        </div>

                    @endif

                    {{-- PODIUM --}}
                    <div class="{{ $height }}
                                flex flex-col items-center
                                justify-center rounded-t-2xl
                                bg-gradient-to-b {{ $gradient }}
                                text-white shadow-lg">

                        <span class="text-3xl font-black sm:text-4xl">
                            #{{ $rank }}
                        </span>

                        <span class="mt-1 text-[10px] font-bold
                                     uppercase tracking-widest">
                            {{ $rank === 1 ? 'Champion' : 'Top Player' }}
                        </span>

                    </div>

                </div>

            @endforeach

        </div>

    </section>


    {{-- ===================================================== --}}
    {{-- CURRENT STUDENT RANK --}}
    {{-- ===================================================== --}}
    @if($currentStudent)

        <section class="relative overflow-hidden rounded-3xl
                        border border-violet-200
                        bg-gradient-to-r from-violet-50
                        to-purple-50 p-5
                        dark:border-violet-500/20
                        dark:from-violet-500/10
                        dark:to-purple-500/10 sm:p-6">

            <div class="flex flex-wrap items-center
                        justify-between gap-5">

                <div>

                    <p class="text-xs font-black uppercase
                              tracking-widest text-violet-600
                              dark:text-violet-300">
                        🎯 Posisi Kamu Saat Ini
                    </p>

                    <div class="mt-2 flex flex-wrap items-center gap-3">

                        <h2 class="text-4xl font-black
                                   text-gray-900 dark:text-white">
                            #{{ $currentStudent->peringkat }}
                        </h2>

                        <span class="rounded-full bg-violet-100
                                     px-3 py-1 text-xs font-black
                                     text-violet-700
                                     dark:bg-violet-500/20
                                     dark:text-violet-300">
                            Level {{ $currentStudent->level_game }}
                        </span>

                    </div>

                    {{-- IDENTITAS SISWA --}}
                    <p class="mt-3 font-bold text-sm
                              text-gray-900 dark:text-white">

                        {{ $currentStudent->fullname ?? $currentStudent->name }}

                    </p>

                    <div class="mt-2 flex flex-wrap gap-2">

                        <span class="rounded-lg bg-white px-3 py-1.5
                                     text-[10px] font-bold
                                     text-violet-700 shadow-sm
                                     dark:bg-white/5
                                     dark:text-violet-300">

                            <i class="fa-solid fa-graduation-cap mr-1"></i>
                            {{ $currentStudent->major_or_subject ?: 'Jurusan belum diisi' }}

                        </span>

                        <span class="rounded-lg bg-white px-3 py-1.5
                                     text-[10px] font-bold
                                     text-gray-600 shadow-sm
                                     dark:bg-white/5
                                     dark:text-gray-300">

                            <i class="fa-solid fa-users mr-1"></i>
                            {{ $currentStudent->offering ?: 'Offering belum diisi' }}

                        </span>

                        <span class="rounded-lg bg-white px-3 py-1.5
                                     text-[10px] font-bold
                                     text-gray-600 shadow-sm
                                     dark:bg-white/5
                                     dark:text-gray-300">

                            <i class="fa-solid fa-school mr-1"></i>
                            {{ $currentStudent->school_name ?: 'Sekolah belum diisi' }}

                        </span>

                    </div>

                    <p class="mt-3 text-xs text-gray-500
                              dark:text-gray-400">

                        {{ $currentStudent->total_misi }}
                        misi telah diselesaikan

                    </p>

                </div>

                {{-- XP --}}
                <div class="text-left sm:text-right">

                    <p class="text-xs font-bold text-gray-500
                              dark:text-gray-400">
                        Total XP Kamu
                    </p>

                    <p class="mt-1 text-2xl font-black text-amber-500">
                        ⚡ {{ number_format($currentStudent->total_xp, 0, ',', '.') }} XP
                    </p>

                    <p class="mt-1 text-xs text-gray-500
                              dark:text-gray-400">
                        Terus belajar untuk naik peringkat!
                    </p>

                </div>

            </div>

        </section>

    @endif


    {{-- ===================================================== --}}
    {{-- RANKING TABLE --}}
    {{-- ===================================================== --}}
    <section class="overflow-hidden rounded-3xl
                    border border-gray-200 bg-white
                    shadow-sm dark:border-white/10
                    dark:bg-cyberdark-800">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 border-b
                    border-gray-100 p-5
                    dark:border-white/10 sm:flex-row
                    sm:items-center sm:justify-between">

            <div>

                <h2 class="text-lg font-black text-gray-900
                           dark:text-white">
                    📊 Peringkat Petualang
                </h2>

                <p class="mt-1 text-xs text-gray-500
                          dark:text-gray-400">
                    Daftar siswa berdasarkan total XP global
                </p>

            </div>

            {{-- SEARCH --}}
            <div class="relative w-full sm:w-72">

                <i class="fa-solid fa-magnifying-glass
                          absolute left-3 top-1/2
                          -translate-y-1/2 text-xs
                          text-gray-400"></i>

                <input
                    type="text"
                    x-model="search"
                    placeholder="Cari nama, jurusan, sekolah..."
                    class="w-full rounded-xl border
                           border-gray-200 bg-gray-50
                           py-2.5 pl-9 pr-4 text-xs
                           text-gray-900 outline-none
                           focus:border-purple-400
                           focus:ring-2 focus:ring-purple-500/10
                           dark:border-white/10
                           dark:bg-white/5 dark:text-white"
                >

            </div>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[850px] text-left text-sm">

                <thead class="bg-gray-50 text-[11px]
                              uppercase tracking-wider
                              text-gray-500 dark:bg-white/5">

                    <tr>

                        <th class="px-5 py-4">Rank</th>

                        <th class="px-5 py-4">Petualang</th>

                        <th class="px-5 py-4">Jurusan</th>

                        <th class="px-5 py-4">Offering</th>

                        <th class="px-5 py-4">Asal Sekolah</th>

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

                            $isMe = (int) $student->id === (int) auth()->id();

                            $searchText = mb_strtolower(implode(' ', [
                                $studentName,
                                $student->major_or_subject ?? '',
                                $student->offering ?? '',
                                $student->school_name ?? '',
                            ]));
                        @endphp

                        <tr
                            x-show="@js($searchText).includes(search.toLowerCase().trim())"
                            class="transition-colors
                                   {{ $isMe
                                        ? 'bg-violet-50 dark:bg-violet-500/10'
                                        : 'hover:bg-gray-50 dark:hover:bg-white/5' }}"
                        >

                            {{-- RANK --}}
                            <td class="px-5 py-4">

                                <span class="text-sm font-black
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

                                </span>

                            </td>


                            {{-- NAMA SISWA --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    {{-- AVATAR --}}
                                    <div class="flex h-10 w-10 shrink-0
                                                items-center justify-center
                                                rounded-xl bg-gradient-to-br
                                                from-violet-100 to-pink-100
                                                font-black text-violet-700
                                                dark:from-violet-500/20
                                                dark:to-pink-500/20
                                                dark:text-violet-300">

                                        {{ mb_strtoupper(mb_substr($studentName, 0, 1)) }}

                                    </div>

                                    <div class="min-w-0">

                                        <p class="font-black text-gray-900
                                                  dark:text-white">

                                            {{ $studentName }}

                                            @if($isMe)
                                                <span class="ml-1 rounded-md
                                                             bg-violet-100 px-2
                                                             py-0.5 text-[9px]
                                                             font-black text-violet-600
                                                             dark:bg-violet-500/20">
                                                    KAMU
                                                </span>
                                            @endif

                                        </p>

                                        <p class="mt-1 text-[10px]
                                                  text-gray-400">
                                            Penjelajah Pengetahuan
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- JURUSAN --}}
                            <td class="px-5 py-4">

                                <span class="inline-flex items-center
                                             rounded-lg bg-violet-50
                                             px-3 py-1.5 text-[11px]
                                             font-bold text-violet-700
                                             dark:bg-violet-500/10
                                             dark:text-violet-300">

                                    <i class="fa-solid fa-graduation-cap mr-2"></i>

                                    {{ $student->major_or_subject ?: '-' }}

                                </span>

                            </td>


                            {{-- OFFERING --}}
                            <td class="px-5 py-4">

                                <span class="text-xs font-semibold
                                             text-gray-600 dark:text-gray-300">

                                    {{ $student->offering ?: '-' }}

                                </span>

                            </td>


                            {{-- ASAL SEKOLAH --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-2">

                                    <i class="fa-solid fa-school
                                              text-xs text-gray-400"></i>

                                    <span class="max-w-[180px] truncate
                                                 text-xs font-medium
                                                 text-gray-600
                                                 dark:text-gray-300"
                                          title="{{ $student->school_name }}">

                                        {{ $student->school_name ?: '-' }}

                                    </span>

                                </div>

                            </td>


                            {{-- LEVEL --}}
                            <td class="px-5 py-4">

                                <span class="inline-flex rounded-lg
                                             bg-purple-100 px-3 py-1.5
                                             text-xs font-black
                                             text-purple-700
                                             dark:bg-purple-500/20
                                             dark:text-purple-300">

                                    ⭐ Lv. {{ $student->level_game }}

                                </span>

                            </td>


                            {{-- MISSIONS --}}
                            <td class="px-5 py-4">

                                <span class="font-bold text-gray-600
                                             dark:text-gray-300">

                                    {{ $student->total_misi }} Misi

                                </span>

                            </td>


                            {{-- XP --}}
                            <td class="px-5 py-4 text-right">

                                <span class="text-sm font-black
                                             text-amber-500">

                                    ⚡ {{ number_format($student->total_xp, 0, ',', '.') }} XP

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="px-5 py-14 text-center">

                                <div class="text-4xl">🏆</div>

                                <p class="mt-3 font-black
                                          text-gray-900 dark:text-white">
                                    Belum ada peringkat
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    Selesaikan misi untuk mulai mengumpulkan XP!
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    {{-- HASIL PENCARIAN KOSONG --}}
                    @if($leaderboard->isNotEmpty())

                        <tr x-show="
                            !Array.from($el.parentElement.querySelectorAll('tr'))
                                .some(row => row !== $el && row.style.display !== 'none')
                        ">

                            <td colspan="8"
                                class="px-5 py-10 text-center">

                                <div class="text-3xl">🔎</div>

                                <p class="mt-3 text-sm font-bold
                                          text-gray-700 dark:text-gray-300">
                                    Siswa tidak ditemukan
                                </p>

                                <p class="mt-1 text-xs text-gray-400">
                                    Coba gunakan nama, jurusan, offering, atau sekolah lain.
                                </p>

                            </td>

                        </tr>

                    @endif

                </tbody>

            </table>

        </div>


        {{-- ================================================= --}}
        {{-- FOOTER --}}
        {{-- ================================================= --}}
        <div class="border-t border-gray-100 p-4
                    text-center dark:border-white/10">

            <p class="text-xs text-gray-400">
                ⚡ Semakin banyak misi yang diselesaikan,
                semakin tinggi peluangmu menjadi juara!
            </p>

        </div>


        {{-- ================================================= --}}
        {{-- PAGINATION --}}
        {{-- ================================================= --}}
        @if($leaderboard->hasPages())

            <div class="flex flex-col gap-4 border-t border-gray-100
                        px-5 py-5 dark:border-white/10
                        sm:flex-row sm:items-center sm:justify-between">

                {{-- INFORMASI JUMLAH SISWA --}}
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">

                    Menampilkan

                    <span class="font-black text-gray-900 dark:text-white">
                        {{ $leaderboard->firstItem() }}
                    </span>

                    -

                    <span class="font-black text-gray-900 dark:text-white">
                        {{ $leaderboard->lastItem() }}
                    </span>

                    dari

                    <span class="font-black text-purple-600 dark:text-purple-400">
                        {{ $leaderboard->total() }}
                    </span>

                    siswa

                </p>


                {{-- TOMBOL PAGINATION --}}
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
                    @foreach($leaderboard->getUrlRange(
                        max(1, $leaderboard->currentPage() - 2),
                        min($leaderboard->lastPage(), $leaderboard->currentPage() + 2)
                    ) as $pageNumber => $url)

                        @if($pageNumber == $leaderboard->currentPage())

                            <span class="flex h-9 min-w-9 items-center
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
                                      hover:bg-purple-50 hover:text-purple-600
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
                                  hover:bg-purple-50 hover:text-purple-600
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

            </div>

        @endif

    </section>

</div>

@endsection
