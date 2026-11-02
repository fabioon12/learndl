
@extends('siswa.layouts.app')

@section('title', 'Dashboard Belajar')

@section('content')

<div class="min-h-screen w-full bg-slate-50 px-4 py-6 sm:px-6 lg:px-8 xl:px-10">

    <div class="mx-auto w-full max-w-[1500px]">

        {{-- ==========================================
             HEADER
        =========================================== --}}
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">

            <div>
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-800 sm:text-3xl">
                    Halo, {{ $user->fullname }}! 👋
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Siap melanjutkan perjalanan belajarmu hari ini?
                </p>
            </div>

            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm">
                <span class="text-lg">🔥</span>
                <div>
                    <p class="text-xs font-bold text-slate-700">Terus belajar!</p>
                    <p class="text-[10px] text-slate-400">Bangun kebiasaan positif</p>
                </div>
            </div>

        </div>


        {{-- ==========================================
             PROFILE, XP, LEVEL
        =========================================== --}}
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">

            {{-- PROFILE --}}
            <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-2xl font-extrabold text-emerald-600">
                    {{ strtoupper(substr($user->fullname, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium text-slate-400">
                        Profil Pembelajar
                    </p>

                    <h3 class="mt-1 truncate text-lg font-extrabold text-slate-800">
                        {{ $user->name }}
                    </h3>

                    <div class="mt-2 inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1">
                        <span>⭐</span>
                        <span class="text-xs font-bold text-amber-600">
                            LEVEL {{ $level }}
                        </span>
                    </div>
                </div>

            </div>


            {{-- TOTAL XP --}}
            <div class="flex items-center gap-4 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-3xl">
                    ⚡
                </div>

                <div>
                    <p class="text-xs font-medium text-slate-400">
                        Total Pengalaman
                    </p>

                    <h3 class="mt-1 text-3xl font-extrabold text-slate-800">
                        {{ number_format($totalXp) }}
                        <span class="text-base font-bold text-amber-500">XP</span>
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Kumpulkan XP dari setiap pembelajaran
                    </p>
                </div>

            </div>


            {{-- LEVEL PROGRESS --}}
            <div class="rounded-2xl bg-gradient-to-br from-violet-600 to-indigo-500 p-5 text-white shadow-lg shadow-violet-200 md:col-span-2 xl:col-span-1">

                <div class="mb-4 flex items-center justify-between">

                    <div>
                        <p class="text-xs font-semibold text-violet-200">
                            LEVEL {{ $level }}
                        </p>

                        <h3 class="mt-1 text-lg font-extrabold">
                            Perjalanan Levelmu 🚀
                        </h3>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-2xl">
                        🏆
                    </div>

                </div>

                <div class="mb-2 flex items-center justify-between text-xs font-semibold">
                    <span>{{ $xpInLevel }} XP</span>
                    <span>{{ $xpNeeded }} XP</span>
                </div>

                <div class="h-3 overflow-hidden rounded-full bg-white/20">
                    <div
                        class="h-full rounded-full bg-amber-300 transition-all duration-700"
                        style="width: {{ $xpPercentage }}%"
                    ></div>
                </div>

                <p class="mt-3 text-xs text-violet-100">
                    {{ $xpNeeded - $xpInLevel }} XP lagi menuju level berikutnya!
                </p>

            </div>

        </div>


        {{-- ==========================================
             STATISTIK PEMBELAJARAN
        =========================================== --}}
        <div class="mb-10 grid grid-cols-2 gap-4 lg:grid-cols-3">

            {{-- MATERI --}}
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-xl">
                    📚
                </div>

                <h3 class="text-3xl font-extrabold text-slate-800">
                    {{ $materis->count() }}
                </h3>

                <p class="mt-1 text-xs font-medium text-slate-400 sm:text-sm">
                    Materi Diambil
                </p>

            </div>


            {{-- SUBMATERI --}}
            <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-xl">
                    🎯
                </div>

                <h3 class="text-3xl font-extrabold text-slate-800">
                    {{ $totalCompleted }}
                    <span class="text-lg font-semibold text-slate-400">
                        / {{ $totalSubmateri }}
                    </span>
                </h3>

                <p class="mt-1 text-xs font-medium text-slate-400 sm:text-sm">
                    Submateri Selesai
                </p>

            </div>


            {{-- PROGRESS --}}
            <div class="col-span-2 rounded-2xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md lg:col-span-1">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-rose-50 text-xl">
                    📈
                </div>

                <h3 class="text-3xl font-extrabold text-slate-800">
                    {{ $overallProgress }}%
                </h3>

                <p class="mt-1 text-xs font-medium text-slate-400 sm:text-sm">
                    Keseluruhan Progres Belajar
                </p>

                <div class="mt-3 h-2 overflow-hidden rounded-full bg-slate-100">
                    <div
                        class="h-full rounded-full bg-rose-400 transition-all duration-700"
                        style="width: {{ $overallProgress }}%"
                    ></div>
                </div>

            </div>

        </div>


        {{-- ==========================================
             LEARNING PATH HEADER
        =========================================== --}}
        <div class="mb-6 flex flex-wrap items-end justify-between gap-3">

            <div>
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🗺️</span>

                    <h2 class="text-xl font-extrabold text-slate-800 sm:text-2xl">
                        Perjalanan Belajarmu
                    </h2>
                </div>

                <p class="mt-2 text-sm text-slate-400">
                    Selesaikan setiap tahapan untuk membuka pembelajaran selanjutnya.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3 text-xs font-medium">

                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded-full bg-emerald-400"></span>
                    Selesai
                </div>

                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded-full bg-violet-500"></span>
                    Aktif
                </div>

                <div class="flex items-center gap-1.5">
                    <span class="h-3 w-3 rounded-full bg-slate-300"></span>
                    Terkunci
                </div>

            </div>

        </div>


        {{-- ==========================================
             LEARNING PATH CONTENT
        =========================================== --}}

        @forelse($materis as $materi)

            @php
                $submateris = $materi->submateris;

                $completedCount = $submateris->filter(function ($sub) use ($completedIds) {
                    return in_array($sub->id, $completedIds);
                })->count();

                $total = $submateris->count();

                $percentage = $total > 0
                    ? round(($completedCount / $total) * 100)
                    : 0;

                $previousCompleted = true;
            @endphp


            <div class="mb-7 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

                {{-- MATERI HEADER --}}
                <div class="flex flex-col gap-5 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:p-6">

                    <div class="flex min-w-0 flex-1 items-center gap-4">

                        @if($materi->thumbnail)

                            <img
                                src="{{ asset('storage/'.$materi->thumbnail) }}"
                                alt="{{ $materi->judul }}"
                                class="h-20 w-20 shrink-0 rounded-2xl border border-slate-100 object-cover"
                            >

                        @else

                            <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl bg-indigo-50 text-3xl">
                                📘
                            </div>

                        @endif


                        <div class="min-w-0 flex-1">

                            <div class="mb-1 flex flex-wrap items-center gap-2">

                                <h3 class="text-lg font-extrabold text-slate-800">
                                    {{ $materi->judul }}
                                </h3>

                                @if($percentage == 100 && $total > 0)
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-600">
                                        SELESAI
                                    </span>
                                @endif

                            </div>

                            <p class="mb-3 line-clamp-2 text-xs text-slate-400">
                                {{ $materi->deskripsi ?: 'Mulai perjalanan pembelajaranmu!' }}
                            </p>

                            <div class="flex items-center justify-between gap-3">

                                <span class="text-xs font-medium text-slate-500">
                                    {{ $completedCount }} dari {{ $total }} tahapan selesai
                                </span>

                                <span class="text-xs font-extrabold text-emerald-500">
                                    {{ $percentage }}%
                                </span>

                            </div>

                            <div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100">
                                <div
                                    class="h-full rounded-full bg-emerald-400 transition-all duration-700"
                                    style="width: {{ $percentage }}%"
                                ></div>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- LEARNING PATH --}}
                <div class="px-3 py-8 sm:px-6 sm:py-10">

                    <div class="mb-10 text-center">

                        <span class="rounded-full bg-violet-50 px-4 py-2 text-[10px] font-extrabold tracking-[2px] text-violet-500">
                            LEARNING PATH
                        </span>

                        <p class="mt-3 text-xs text-slate-400">
                            Ikuti perjalanan dan selesaikan setiap tantangan!
                        </p>

                    </div>


                    @if($submateris->count() > 0)

                        <div class="mx-auto flex max-w-2xl flex-col items-center">

                            @foreach($submateris as $index => $submateri)

                                @php
                                    $isCompleted = in_array(
                                        $submateri->id,
                                        $completedIds
                                    );

                                    $isUnlocked = $previousCompleted;

                                    if ($isCompleted) {
                                        $statusClass = 'bg-emerald-400 shadow-[0_7px_0_#22a875]';
                                        $nodeIcon = '✓';
                                        $statusText = 'Sudah diselesaikan';
                                        $labelColor = 'text-emerald-600';
                                    } elseif ($isUnlocked) {
                                        $statusClass = 'bg-violet-600 shadow-[0_7px_0_#4c36b5] hover:bg-violet-700';
                                        $nodeIcon = '▶';
                                        $statusText = 'Mulai pembelajaran';
                                        $labelColor = 'text-violet-600';
                                    } else {
                                        $statusClass = 'bg-slate-200 shadow-[0_7px_0_#cbd2dd]';
                                        $nodeIcon = '🔒';
                                        $statusText = 'Selesaikan tahapan sebelumnya';
                                        $labelColor = 'text-slate-400';
                                    }

                                    $previousCompleted = $isCompleted;
                                @endphp


                                <div class="relative flex w-full flex-col items-center pb-10

                                    @if($index % 4 === 0)
                                        -translate-x-16 sm:-translate-x-24
                                    @elseif($index % 4 === 1)
                                        translate-x-0
                                    @elseif($index % 4 === 2)
                                        translate-x-16 sm:translate-x-24
                                    @else
                                        translate-x-0
                                    @endif
                                ">

                                    {{-- NODE --}}
                                    @if($isUnlocked)

                                        <a
                                            href="{{ route('siswa.ruang-materi.dashboard-belajar.submateri.show', ['materi' => $materi->id, 'submateri' => $submateri->id ]) }}"
                                            class="relative flex h-[72px] w-[72px] items-center justify-center rounded-full text-2xl font-extrabold text-white transition duration-200 hover:scale-110 sm:h-[82px] sm:w-[82px] {{ $statusClass }}"
                                            aria-label="{{ $submateri->judul_sub }}"
                                        >
                                            {{ $nodeIcon }}

                                            <span class="absolute -right-5 -top-2 whitespace-nowrap rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-[10px] font-extrabold text-amber-600 shadow-sm">
                                                +{{ $submateri->xp_reward }} XP
                                            </span>
                                        </a>

                                    @else

                                        <div
                                            class="relative flex h-[72px] w-[72px] cursor-not-allowed items-center justify-center rounded-full text-xl sm:h-[82px] sm:w-[82px] {{ $statusClass }}"
                                            aria-label="Terkunci"
                                        >
                                            {{ $nodeIcon }}
                                        </div>

                                    @endif


                                    {{-- LABEL --}}
                                    <div class="mt-5 max-w-[220px] text-center">

                                        <h4 class="text-sm font-extrabold {{ $labelColor }}">
                                            {{ $submateri->judul_sub }}
                                        </h4>

                                        <p class="mt-1 text-[11px] text-slate-400">
                                            {{ $statusText }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="py-12 text-center">

                            <div class="mb-4 text-5xl">
                                📖
                            </div>

                            <h4 class="font-bold text-slate-700">
                                Belum Ada Submateri
                            </h4>

                            <p class="mt-2 text-sm text-slate-400">
                                Guru belum menerbitkan submateri untuk pembelajaran ini.
                            </p>

                        </div>

                    @endif

                </div>

            </div>


        @empty

            {{-- EMPTY STATE --}}
            <div class="rounded-2xl border border-slate-100 bg-white px-5 py-16 text-center shadow-sm">

                <div class="mb-5 text-6xl">
                    📚
                </div>

                <h3 class="text-xl font-extrabold text-slate-800">
                    Belum Ada Materi Pembelajaran
                </h3>

                <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-slate-400">
                    Kamu belum mengambil materi pembelajaran.
                    Silakan kunjungi halaman Eksplorasi untuk memilih
                    ruang belajar yang tersedia.
                </p>

                <a
                    href="{{ url('/siswa/eksplorasi') }}"
                    class="mt-7 inline-flex items-center gap-2 rounded-xl bg-violet-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-violet-200 transition hover:-translate-y-1 hover:bg-violet-700"
                >
                    Jelajahi Materi
                    <span>→</span>
                </a>

            </div>

        @endforelse

    </div>

</div>

@endsection
