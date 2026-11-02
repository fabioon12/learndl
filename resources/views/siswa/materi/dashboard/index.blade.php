
@extends('siswa.layouts.app')

@section('title', 'Ruang Materi Saya')

@section('content')
<div class="space-y-7">

    {{-- HERO HEADER --}}
    <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-pink-500 via-fuchsia-500 to-purple-600 p-6 md:p-8 shadow-xl shadow-pink-500/10">

        {{-- Dekorasi --}}
        <div class="absolute -right-10 -top-16 w-64 h-64 rounded-full bg-white/10"></div>
        <div class="absolute right-32 -bottom-24 w-52 h-52 rounded-full bg-purple-900/10"></div>
        <div class="absolute right-8 bottom-5 text-white/10 text-8xl rotate-12">
            <i class="fa-solid fa-book-open"></i>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">

            <div class="max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-white text-[10px] font-bold uppercase tracking-wider mb-4">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Learning Space
                </div>

                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight leading-tight">
                    Ruang Materi Saya
                    <span class="inline-block">📚</span>
                </h1>

                <p class="text-xs md:text-sm text-white/85 mt-2 leading-relaxed max-w-md">
                    Lanjutkan petualangan belajarmu! Semua ruang materi yang telah kamu ambil tersedia di sini.
                </p>

                <a href="{{ route('siswa.ruang-materi.eksplorasi') }}"
                   class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 rounded-xl bg-white text-pink-600 hover:bg-pink-50 font-extrabold text-xs shadow-lg transition-all hover:-translate-y-0.5 active:scale-95">
                    <i class="fa-solid fa-compass"></i>
                    Jelajahi Materi
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            {{-- Ilustrasi --}}
            <div class="hidden md:flex items-center justify-center shrink-0">
                <div class="relative w-36 h-36 rounded-[2rem] bg-white/15 border border-white/25 backdrop-blur-sm flex items-center justify-center rotate-3">
                    <div class="w-24 h-24 rounded-3xl bg-white flex items-center justify-center shadow-xl -rotate-6">
                        <i class="fa-solid fa-book-open-reader text-5xl text-pink-500"></i>
                    </div>
                    <div class="absolute -top-3 -right-3 w-11 h-11 rounded-2xl bg-yellow-300 text-yellow-800 flex items-center justify-center shadow-lg rotate-12">
                        <i class="fa-solid fa-star text-lg"></i>
                    </div>
                    <div class="absolute -bottom-3 -left-3 w-10 h-10 rounded-xl bg-purple-200 text-purple-700 flex items-center justify-center shadow-lg -rotate-12">
                        <i class="fa-solid fa-gamepad"></i>
                    </div>
                </div>
            </div>

        </div>
    </section>


    {{-- STATISTIK DAN PENCARIAN --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Total Materi --}}
        <div class="relative overflow-hidden bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        Materi Saya
                    </p>
                    <h2 class="text-3xl font-black text-gray-900 dark:text-white mt-1">
                        {{ $totalMateriDiambil }}
                    </h2>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">
                        Ruang materi yang diikuti
                    </p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-pink-100 dark:bg-pink-950/40 text-pink-500 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
            </div>
            <div class="absolute -right-5 -bottom-8 w-24 h-24 rounded-full bg-pink-500/5"></div>
        </div>

        {{-- Eksplorasi --}}
        <a href="{{ route('siswa.ruang-materi.eksplorasi') }}"
           class="group bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-purple-950/30 rounded-3xl p-5 shadow-sm hover:shadow-lg hover:shadow-purple-500/5 transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        Temukan Materi
                    </p>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white mt-2">
                        Eksplorasi
                    </h2>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">
                        Temukan ruang belajar baru
                    </p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-950/40 text-purple-500 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-compass"></i>
                </div>
            </div>
        </a>

        {{-- Pencarian --}}
        <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 shadow-sm flex flex-col justify-center">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">
                Cari Materi
            </label>

            <form method="GET" action="{{ route('siswa.ruang-materi.index') }}" class="relative">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari ruang materi..."
                       class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 rounded-xl text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500/40 transition">

                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-xs text-gray-400"></i>

                <button type="submit"
                        class="absolute right-2 top-1.5 px-3 py-1.5 bg-pink-500 hover:bg-pink-600 text-white rounded-lg text-[10px] font-bold transition">
                    Cari
                </button>
            </form>
        </div>

    </section>


    {{-- DAFTAR MATERI --}}
    <section class="space-y-4">

        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-pink-500"></span>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">
                        {{ request('search') ? 'Hasil Pencarian' : 'Perjalanan Belajarmu' }}
                    </h2>
                </div>
                <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 ml-3.5">
                    Materi yang sudah kamu ambil dan siap dipelajari.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 text-[10px] font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-cyberdark-800 px-3 py-2 rounded-xl">
                <i class="fa-solid fa-layer-group text-pink-500"></i>
                {{ $materis->total() }} Materi Tersimpan
            </div>
        </div>


        @if($materis->count() > 0)

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">

                @foreach($materis as $materi)

                    <article class="group relative bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-[1.7rem] overflow-hidden shadow-sm hover:shadow-xl hover:shadow-pink-500/5 hover:-translate-y-1 transition-all duration-300">

                        {{-- Thumbnail --}}
                        <div class="relative h-44 overflow-hidden bg-gradient-to-br from-pink-100 via-purple-100 to-indigo-100 dark:from-pink-950/40 dark:via-purple-950/30 dark:to-cyberdark-800">

                            @if($materi->thumbnail)
                                <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                     alt="{{ $materi->judul }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-pink-500">
                                    <i class="fa-solid fa-book-open text-5xl opacity-80"></i>
                                    <span class="text-[10px] font-bold mt-2 opacity-70">RUANG MATERI</span>
                                </div>
                            @endif

                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>

                            {{-- Label --}}
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/90 dark:bg-cyberdark-900/90 text-pink-600 dark:text-pink-400 text-[9px] font-black shadow-sm backdrop-blur-sm">
                                    <i class="fa-solid fa-bookmark"></i>
                                    MATERI SAYA
                                </span>
                            </div>

                            <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between">
                                <span class="text-white text-[10px] font-bold drop-shadow">
                                    <i class="fa-solid fa-graduation-cap mr-1"></i>
                                    Ruang Belajar
                                </span>
                                <span class="w-8 h-8 rounded-xl bg-white/20 backdrop-blur-md border border-white/30 text-white flex items-center justify-center">
                                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                </span>
                            </div>
                        </div>


                        {{-- Konten --}}
                        <div class="p-5">

                            <div class="min-h-[105px]">
                                <h3 class="text-base font-black text-gray-900 dark:text-white line-clamp-2 leading-snug group-hover:text-pink-500 transition-colors"
                                    title="{{ $materi->judul }}">
                                    {{ $materi->judul }}
                                </h3>

                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 leading-relaxed line-clamp-2">
                                    {{ $materi->deskripsi ?: 'Belum ada deskripsi untuk ruang materi ini.' }}
                                </p>
                            </div>

                            {{-- Pengajar --}}
                            <div class="flex items-center gap-2.5 py-3 border-t border-gray-100 dark:border-pink-950/20">

                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-950/50 dark:to-purple-950/50 text-pink-600 dark:text-pink-300 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-user-tie text-sm"></i>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="text-[9px] text-gray-400 font-semibold uppercase tracking-wider">
                                        Pengajar
                                    </p>
                                    <p class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate mt-0.5">
                                        {{ $materi->guru->fullname ?? ($materi->guru->name ?? 'Guru Pengajar') }}
                                    </p>
                                </div>

                                <div class="text-[10px] text-green-500 font-bold flex items-center gap-1 shrink-0">
                                    <i class="fa-solid fa-circle-check"></i>
                                    Diikuti
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <a href="{{ route('siswa.ruang-materi.dashboard-belajar') }}"
                               class="w-full inline-flex items-center justify-center gap-2 py-3 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-extrabold text-xs shadow-md shadow-pink-500/20 transition-all active:scale-[0.98]">
                                <i class="fa-solid fa-play text-[10px]"></i>
                                Lanjutkan Belajar
                                <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i>
                            </a>

                        </div>
                    </article>

                @endforeach

            </div>

            {{-- PAGINATION --}}
            @if($materis->hasPages())
                <div class="pt-4">
                    {{ $materis->appends(request()->query())->links() }}
                </div>
            @endif

        @else

            {{-- EMPTY STATE --}}
            <div class="relative overflow-hidden text-center py-14 px-5 bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-dashed border-pink-200 dark:border-pink-950/40">

                <div class="absolute -top-10 -right-10 w-36 h-36 rounded-full bg-pink-500/5"></div>
                <div class="absolute -bottom-12 -left-10 w-36 h-36 rounded-full bg-purple-500/5"></div>

                <div class="relative z-10">

                    <div class="w-20 h-20 mx-auto rounded-[1.7rem] bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-950/40 dark:to-purple-950/40 text-pink-500 flex items-center justify-center text-3xl mb-5">
                        <i class="fa-solid {{ request('search') ? 'fa-magnifying-glass' : 'fa-book-open-reader' }}"></i>
                    </div>

                    @if(request('search'))
                        <h3 class="text-base font-black text-gray-900 dark:text-white">
                            Materi Tidak Ditemukan
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 max-w-sm mx-auto leading-relaxed">
                            Kami tidak menemukan materi dengan kata kunci
                            <strong class="text-pink-500">"{{ request('search') }}"</strong>.
                            Coba gunakan kata kunci lainnya.
                        </p>

                        <a href="{{ route('siswa.ruang-materi.index') }}"
                           class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 bg-pink-500 hover:bg-pink-600 text-white rounded-xl text-xs font-bold transition">
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset Pencarian
                        </a>
                    @else
                        <h3 class="text-base font-black text-gray-900 dark:text-white">
                            Perjalanan Belajarmu Belum Dimulai!
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 max-w-sm mx-auto leading-relaxed">
                            Kamu belum mengambil ruang materi. Yuk, temukan materi menarik dan mulai petualangan belajarmu!
                        </p>

                        <a href="{{ route('siswa.ruang-materi.eksplorasi') }}"
                           class="inline-flex items-center gap-2 mt-5 px-5 py-2.5 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white rounded-xl text-xs font-bold shadow-lg shadow-pink-500/20 transition">
                            <i class="fa-solid fa-compass"></i>
                            Jelajahi Ruang Materi
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    @endif

                </div>
            </div>

        @endif

    </section>

</div>
@endsection
