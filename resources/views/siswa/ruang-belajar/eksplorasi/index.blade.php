
@extends('siswa.layouts.app')

@section('title', 'Eksplorasi Ruang Belajar')

@section('content')
<div class="max-w-7xl mx-auto space-y-7">

    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-pink-500 via-fuchsia-600 to-purple-700 p-6 md:p-9 shadow-xl shadow-pink-500/10">

        <div class="absolute -right-16 -top-20 w-72 h-72 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute right-36 -bottom-24 w-60 h-60 rounded-full bg-purple-950/20 blur-2xl"></div>
        <div class="absolute right-8 top-8 text-white/10 text-8xl rotate-12">
            <i class="fa-solid fa-compass"></i>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-7">

            <div class="max-w-xl">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-white text-[10px] font-extrabold uppercase tracking-widest">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                    Discover & Learn
                </span>

                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight mt-4">
                    Jelajahi Dunia Belajar!
                    <span>🚀</span>
                </h1>

                <p class="text-xs md:text-sm text-white/85 leading-relaxed mt-3 max-w-md">
                    Temukan ruang belajar dari para guru, pilih materi yang menarik, dan mulai petualangan belajarmu hari ini.
                </p>

                <div class="flex items-center gap-3 mt-6">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-yellow-300 border-2 border-pink-500 flex items-center justify-center text-yellow-900 text-xs">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-blue-300 border-2 border-pink-500 flex items-center justify-center text-blue-900 text-xs">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-green-300 border-2 border-pink-500 flex items-center justify-center text-green-900 text-xs">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                    </div>
                    <span class="text-[10px] text-white/90 font-semibold">
                        Temukan ruang belajar favoritmu
                    </span>
                </div>
            </div>

            {{-- Ilustrasi --}}
            <div class="hidden md:flex justify-center items-center shrink-0 pr-8">
                <div class="relative w-36 h-36 rounded-[2rem] bg-white/15 border border-white/25 backdrop-blur-md flex items-center justify-center rotate-3">
                    <div class="w-24 h-24 rounded-3xl bg-white flex items-center justify-center shadow-xl -rotate-6">
                        <i class="fa-solid fa-binoculars text-5xl text-pink-500"></i>
                    </div>
                    <div class="absolute -top-4 -right-4 w-11 h-11 rounded-2xl bg-yellow-300 text-yellow-800 flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-star text-lg"></i>
                    </div>
                    <div class="absolute -bottom-3 -left-4 w-10 h-10 rounded-xl bg-purple-300 text-purple-800 flex items-center justify-center shadow-lg">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- STATISTIK --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white dark:bg-cyberdark-900 rounded-3xl border border-gray-100 dark:border-pink-950/30 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-pink-100 dark:bg-pink-950/40 text-pink-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-school"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Ruang</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white">
                    {{ $stats['total_ruang'] ?? 0 }}
                </h3>
                <p class="text-[10px] text-gray-400">Ruang belajar tersedia</p>
            </div>
        </div>

        <div class="bg-white dark:bg-cyberdark-900 rounded-3xl border border-gray-100 dark:border-pink-950/30 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-door-open"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Ruang Aktif</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white">
                    {{ $stats['ruang_aktif'] ?? 0 }}
                </h3>
                <p class="text-[10px] text-emerald-500 font-semibold">Siap diikuti</p>
            </div>
        </div>

        <div class="bg-white dark:bg-cyberdark-900 rounded-3xl border border-gray-100 dark:border-pink-950/30 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950/40 text-amber-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-list-check"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Tahapan</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white">
                    0
                </h3>
                <p class="text-[10px] text-gray-400">Tahapan pembelajaran</p>
            </div>
        </div>

        <div class="bg-white dark:bg-cyberdark-900 rounded-3xl border border-gray-100 dark:border-pink-950/30 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-950/40 text-blue-500 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Guru Aktif</p>
                <h3 class="text-2xl font-black text-gray-900 dark:text-white">
                    {{ $stats['guru_aktif'] ?? 0 }}
                </h3>
                <p class="text-[10px] text-gray-400">Pengajar terdaftar</p>
            </div>
        </div>

    </section>


    {{-- SEARCH & FILTER --}}
    <section class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-4 md:p-5 shadow-sm">

        <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-3">

            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari ruang belajar, guru, atau mata pelajaran..."
                       class="w-full pl-11 pr-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-pink-500/40 transition">
            </div>

            <div class="flex gap-2">
                <select name="kelas"
                        class="flex-1 md:w-40 px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs font-semibold text-gray-600 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-pink-500/40">
                    <option value="">Semua Kelas</option>
                    <option value="X" {{ request('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                    <option value="XI" {{ request('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                    <option value="XII" {{ request('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                </select>

                <button type="submit"
                        class="px-5 py-3 rounded-2xl bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white text-xs font-extrabold shadow-md shadow-pink-500/20 transition active:scale-95">
                    <i class="fa-solid fa-filter mr-1"></i>
                    Filter
                </button>
            </div>

        </form>
    </section>


    {{-- JUDUL SECTION --}}
    <section class="flex flex-col sm:flex-row sm:items-end justify-between gap-3">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-6 rounded-full bg-pink-500"></span>
                <h2 class="text-lg font-black text-gray-900 dark:text-white">
                    Temukan Ruang Belajar
                </h2>
            </div>
            <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 ml-3.5">
                Pilih ruang yang ingin kamu ikuti dan mulai belajar.
            </p>
        </div>

        <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-cyberdark-800 rounded-xl px-3 py-2">
            <i class="fa-solid fa-layer-group text-pink-500 mr-1"></i>
            {{ $ruangBelajars->count() }} Ruang Ditampilkan
        </span>
    </section>


    {{-- GRID RUANG BELAJAR --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

        @forelse($ruangBelajars as $item)

            @php
                $theme = match(strtolower($item->mapel ?? '')) {
                    'informatika' => [
                        'bg' => 'from-indigo-600 to-violet-800',
                        'badge' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300',
                        'icon' => 'fa-code'
                    ],
                    'matematika' => [
                        'bg' => 'from-blue-500 to-indigo-700',
                        'badge' => 'bg-blue-100 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300',
                        'icon' => 'fa-calculator'
                    ],
                    'seni & desain', 'seni' => [
                        'bg' => 'from-amber-500 to-red-600',
                        'badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300',
                        'icon' => 'fa-palette'
                    ],
                    'ipa' => [
                        'bg' => 'from-emerald-500 to-teal-700',
                        'badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300',
                        'icon' => 'fa-atom'
                    ],
                    'bahasa' => [
                        'bg' => 'from-rose-500 to-purple-700',
                        'badge' => 'bg-rose-100 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300',
                        'icon' => 'fa-language'
                    ],
                    'ekonomi' => [
                        'bg' => 'from-cyan-500 to-blue-800',
                        'badge' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950/50 dark:text-cyan-300',
                        'icon' => 'fa-chart-line'
                    ],
                    default => [
                        'bg' => 'from-purple-600 to-indigo-800',
                        'badge' => 'bg-purple-100 text-purple-700 dark:bg-purple-950/50 dark:text-purple-300',
                        'icon' => 'fa-shapes'
                    ]
                };
            @endphp

            <article class="group bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-[1.7rem] overflow-hidden shadow-sm hover:shadow-xl hover:shadow-pink-500/5 hover:-translate-y-1 transition-all duration-300 flex flex-col">

                {{-- THUMBNAIL --}}
                <div class="relative h-40 overflow-hidden bg-gradient-to-br {{ $theme['bg'] }}">

                    @if($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                             alt="{{ $item->judul }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="absolute -top-8 -right-8 w-32 h-32 rounded-full bg-white/10"></div>
                            <div class="absolute -bottom-12 -left-8 w-36 h-36 rounded-full bg-black/10"></div>
                            <div class="relative w-20 h-20 rounded-3xl bg-white/15 border border-white/25 backdrop-blur-md flex items-center justify-center text-white text-3xl shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all">
                                <i class="fa-solid {{ $theme['icon'] }}"></i>
                            </div>
                        </div>
                    @endif

                    {{-- KELAS --}}
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1.5 rounded-full bg-black/35 backdrop-blur-md text-white border border-white/20 text-[10px] font-extrabold">
                            <i class="fa-solid fa-graduation-cap text-yellow-300 mr-1"></i>
                            Kelas {{ $item->kelas }}
                        </span>
                    </div>

                    {{-- MAPEL --}}
                    <div class="absolute bottom-3 left-3 right-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/90 text-gray-800 text-[10px] font-extrabold shadow-sm">
                            <i class="fa-solid fa-book text-pink-500"></i>
                            {{ $item->mapel }}
                        </span>
                    </div>
                </div>


                {{-- CARD CONTENT --}}
                <div class="p-5 flex-1 flex flex-col">

                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="text-[9px] text-gray-400 font-semibold uppercase tracking-wider">
                            <i class="fa-solid fa-clock mr-1"></i>
                            {{ $item->created_at ? $item->created_at->diffForHumans() : 'Baru' }}
                        </span>
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                    </div>

                    <h3 class="text-sm font-black text-gray-900 dark:text-white leading-snug line-clamp-2 min-h-[2.5rem] group-hover:text-pink-500 transition-colors"
                        title="{{ $item->judul }}">
                        {{ $item->judul }}
                    </h3>

                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-2 leading-relaxed line-clamp-2 min-h-[2rem]">
                        {{ $item->deskripsi ?: 'Belum ada deskripsi untuk ruang belajar ini.' }}
                    </p>

                    {{-- GURU --}}
                    <div class="flex items-center gap-2.5 mt-4 pt-3 border-t border-gray-100 dark:border-pink-950/20">
                        <div class="w-8 h-8 rounded-xl bg-pink-100 dark:bg-pink-950/40 text-pink-500 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-user-tie text-xs"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[9px] text-gray-400 uppercase font-bold tracking-wider">Pengajar</p>
                            <p class="text-[11px] font-bold text-gray-800 dark:text-gray-200 truncate">
                                {{ $item->guru->fullname ?? $item->user->fullname ?? 'Guru Pengajar' }}
                            </p>
                        </div>
                    </div>

                    {{-- INFORMASI --}}
                    <div class="grid grid-cols-2 gap-2 mt-4">
                        <div class="rounded-xl bg-gray-50 dark:bg-cyberdark-800/70 p-2.5 text-center">
                            <p class="text-xs font-black text-gray-900 dark:text-white">
                                <i class="fa-solid fa-users text-pink-500 mr-1"></i>
                                {{ $item->siswa_count ?? 0 }}
                            </p>
                            <p class="text-[9px] text-gray-400 font-bold mt-1">Siswa</p>
                        </div>
                        <div class="rounded-xl bg-gray-50 dark:bg-cyberdark-800/70 p-2.5 text-center">
                            <p class="text-xs font-black text-gray-900 dark:text-white">
                                <i class="fa-solid fa-list-check text-purple-500 mr-1"></i>
                                {{ $item->materi_count ?? 0 }}
                            </p>
                            <p class="text-[9px] text-gray-400 font-bold mt-1">Tahapan Modul</p>
                        </div>
                    </div>

                    {{-- ACTION --}}
                    <div class="grid grid-cols-2 gap-2 mt-5 pt-4 border-t border-gray-100 dark:border-pink-950/20">

                        <a href="{{ route('siswa.ruang-belajar.show', $item->id) }}"
                           class="py-2.5 rounded-xl border border-gray-200 dark:border-pink-950/40 text-gray-700 dark:text-gray-200 text-[10px] font-extrabold text-center hover:bg-gray-50 dark:hover:bg-cyberdark-800 transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-circle-info text-pink-500"></i>
                            Detail
                        </a>

                        <form action="{{ route('siswa.ruang-belajar.enroll', $item->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white text-[10px] font-extrabold transition shadow-md shadow-pink-500/15 active:scale-95 flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-plus"></i>
                                Ikuti Ruang
                            </button>
                        </form>

                    </div>

                </div>
            </article>

        @empty

            <div class="col-span-full text-center py-16 px-5 bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-dashed border-pink-200 dark:border-pink-950/40">

                <div class="w-20 h-20 mx-auto rounded-3xl bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-950/40 dark:to-purple-950/40 text-pink-500 flex items-center justify-center text-3xl mb-5">
                    <i class="fa-solid fa-compass"></i>
                </div>

                <h3 class="text-base font-black text-gray-900 dark:text-white">
                    Belum Ada Ruang Belajar
                </h3>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 max-w-sm mx-auto leading-relaxed">
                    Saat ini belum ada ruang belajar yang tersedia untuk diikuti. Silakan kembali lagi nanti untuk menemukan ruang belajar baru.
                </p>

            </div>

        @endforelse

    </section>

</div>
@endsection
