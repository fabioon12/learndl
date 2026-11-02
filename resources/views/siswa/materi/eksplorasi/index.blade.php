@extends('siswa.layouts.app')

@section('title', 'Eksplorasi Ruang Materi')

@section('content')

@php
    $totalMateri = $materis->total();
    $kataKunci = request('search');
@endphp

<div class="space-y-7">

    {{-- ================================================= --}}
    {{-- HERO SECTION --}}
    {{-- ================================================= --}}
    <div class="relative overflow-hidden rounded-[2rem] md:rounded-[2.5rem] bg-gradient-to-r from-[#db2777] via-[#9333ea] to-[#5b4bd8] p-6 md:p-9 text-white shadow-xl shadow-purple-500/15">

        {{-- Background Decoration --}}
        <div class="absolute -right-20 -top-24 w-80 h-80 bg-pink-300/20 rounded-full blur-3xl"></div>
        <div class="absolute right-1/4 -bottom-24 w-64 h-64 bg-indigo-300/20 rounded-full blur-3xl"></div>
        <div class="absolute left-1/2 top-0 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-7">

            {{-- Kiri: Teks & Statistik --}}
            <div class="max-w-xl space-y-5">
                <div class="inline-flex items-center gap-2 bg-white/15 border border-white/20 backdrop-blur-md px-4 py-2 rounded-full">
                    <i class="fa-solid fa-compass text-amber-300"></i>
                    <span class="text-[10px] font-black uppercase tracking-[0.15em]">
                        EXPLORE YOUR KNOWLEDGE
                    </span>
                </div>

                <div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                        Temukan Petualangan <span class="text-amber-300">Barumu!</span>
                    </h1>
                    <p class="text-sm text-white/80 mt-3 leading-relaxed max-w-lg">
                        Jelajahi berbagai ruang materi, pelajari hal baru, kumpulkan XP, dan tingkatkan kemampuanmu bersama guru-guru terbaik di sekolahmu!
                    </p>
                </div>

                {{-- Statistik --}}
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2 bg-white/15 border border-white/20 backdrop-blur-md px-4 py-2.5 rounded-2xl">
                        <div class="w-8 h-8 rounded-xl bg-amber-400 flex items-center justify-center">
                            <i class="fa-solid fa-book-open text-white"></i>
                        </div>
                        <div>
                            <p class="text-lg font-black leading-none">
                                {{ number_format($totalMateri) }}
                            </p>
                            <p class="text-[9px] font-bold text-white/70 uppercase mt-1">
                                Materi tersedia
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 bg-white/15 border border-white/20 backdrop-blur-md px-4 py-2.5 rounded-2xl">
                        <div class="w-8 h-8 rounded-xl bg-emerald-400 flex items-center justify-center">
                            <i class="fa-solid fa-rocket text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm font-black leading-none">
                                Mulai Belajar
                            </p>
                            <p class="text-[9px] font-bold text-white/70 uppercase mt-1">
                                Raih XP Baru
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Ilustrasi Dekoratif --}}
            <div class="relative flex justify-center md:justify-end items-center shrink-0">
                <div class="relative w-48 h-44 md:w-60 md:h-52 flex items-center justify-center">
                    
                    {{-- Lingkaran --}}
                    <div class="absolute w-40 h-40 md:w-48 md:h-48 rounded-full bg-white/10 border border-white/20"></div>
                    <div class="absolute w-32 h-32 md:w-40 md:h-40 rounded-full bg-white/10 border border-white/20"></div>

                    {{-- Buku --}}
                    <div class="relative z-10 w-28 h-28 md:w-36 md:h-36 rounded-[2rem] bg-gradient-to-br from-amber-300 to-orange-500 shadow-2xl shadow-orange-900/20 flex items-center justify-center rotate-[-8deg] hover:rotate-0 hover:scale-110 transition-all duration-500">
                        <i class="fa-solid fa-book-open text-5xl md:text-6xl text-white drop-shadow-lg"></i>
                    </div>

                    {{-- Floating Star --}}
                    <div class="absolute top-2 right-3 w-12 h-12 rounded-2xl bg-emerald-400 flex items-center justify-center shadow-lg rotate-12">
                        <i class="fa-solid fa-star text-white text-xl"></i>
                    </div>

                    {{-- Floating Bolt --}}
                    <div class="absolute bottom-2 left-1 w-11 h-11 rounded-2xl bg-pink-400 flex items-center justify-center shadow-lg -rotate-12">
                        <i class="fa-solid fa-bolt text-white text-lg"></i>
                    </div>

                    {{-- Floating Code --}}
                    <div class="absolute top-10 left-0 w-9 h-9 rounded-xl bg-sky-400 flex items-center justify-center shadow-lg rotate-12">
                        <i class="fa-solid fa-code text-white"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- ================================================= --}}
    {{-- SEARCH DAN INFORMASI --}}
    {{-- ================================================= --}}
    <div class="space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                        <i class="fa-solid fa-compass text-pink-500"></i>
                    </div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white">
                        Jelajahi Materi
                    </h2>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    Pilih ruang materi yang ingin kamu pelajari.
                </p>
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('siswa.ruang-materi.eksplorasi') }}" class="relative w-full md:w-80">
                <input type="text"
                    name="search"
                    value="{{ $kataKunci }}"
                    placeholder="Cari materi yang kamu inginkan..."
                    class="w-full pl-11 pr-12 py-3.5 bg-white dark:bg-cyberdark-900 border border-gray-200 dark:border-gray-700 rounded-2xl text-xs font-semibold text-gray-800 dark:text-gray-200 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-500/40 focus:border-pink-400 shadow-sm transition-all">

                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 text-white flex items-center justify-center hover:scale-105 transition-all">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>

        {{-- Informasi Hasil Pencarian --}}
        <div class="flex items-center justify-between bg-gray-50 dark:bg-cyberdark-900/70 border border-gray-100 dark:border-gray-800 px-4 py-3 rounded-2xl">
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-bold text-gray-600 dark:text-gray-300">
                    @if($kataKunci)
                        Hasil pencarian: "{{ $kataKunci }}"
                    @else
                        Semua materi tersedia
                    @endif
                </span>
            </div>

            <span class="text-[10px] font-black text-pink-500 bg-pink-100 dark:bg-pink-900/35 px-3 py-1.5 rounded-full">
                {{ $materis->count() }} MATERI
            </span>
        </div>
    </div>


    {{-- ================================================= --}}
    {{-- GRID MATERI --}}
    {{-- ================================================= --}}
    @if($materis->count() > 0)

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-6">
            @foreach($materis as $materi)
                <div class="group relative flex flex-col bg-white dark:bg-cyberdark-900 rounded-[1.8rem] border border-gray-100 dark:border-gray-800 overflow-hidden shadow-sm hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-1 transition-all duration-300">

                    {{-- THUMBNAIL --}}
                    <div class="relative h-48 overflow-hidden bg-gradient-to-br from-pink-100 via-purple-100 to-indigo-100 dark:from-gray-800 dark:to-gray-900">
                        @if($materi->thumbnail)
                            <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                alt="{{ $materi->judul }}"
                                loading="lazy"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full flex items-center justify-center relative">
                                <div class="absolute w-32 h-32 rounded-full bg-pink-400/10 blur-2xl"></div>
                                <div class="relative w-20 h-20 rounded-[1.5rem] bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center shadow-xl shadow-purple-500/20 group-hover:rotate-6 group-hover:scale-110 transition-all duration-500">
                                    <i class="fa-solid fa-book-open text-3xl text-white"></i>
                                </div>
                            </div>
                        @endif

                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent pointer-events-none"></div>

                        {{-- XP Badge --}}
                        <div class="absolute top-3 right-3 inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-amber-400 text-amber-950 border border-amber-300 shadow-lg shadow-amber-900/10">
                            <i class="fa-solid fa-bolt text-xs animate-pulse"></i>
                            <span class="text-[10px] font-black">+{{ $materi->total_xp ?? 0 }} XP</span>
                        </div>

                        {{-- Badge Materi --}}
                        <div class="absolute bottom-3 left-3 px-3 py-1.5 rounded-lg bg-white/90 backdrop-blur-md text-gray-800 text-[9px] font-black uppercase tracking-wider">
                            <i class="fa-solid fa-bookmark text-pink-500 mr-1"></i>
                            RUANG MATERI
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-5 flex flex-col flex-1">
                        {{-- Judul --}}
                        <div class="mb-3">
                            <h3 title="{{ $materi->judul }}"
                                class="text-base font-black text-gray-900 dark:text-white line-clamp-2 leading-snug group-hover:text-pink-500 transition-colors">
                                {{ $materi->judul }}
                            </h3>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="min-h-[52px]">
                            @if(!empty($materi->deskripsi))
                                <p class="text-xs leading-relaxed text-gray-500 dark:text-gray-400 line-clamp-3">
                                    {{ $materi->deskripsi }}
                                </p>
                            @else
                                <p class="text-xs italic text-gray-400">
                                    Belum ada deskripsi materi.
                                </p>
                            @endif
                        </div>

                        {{-- Informasi Pengajar --}}
                        <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <div class="w-10 h-10 rounded-xl shrink-0 bg-gradient-to-br from-pink-100 to-purple-100 dark:from-pink-900/30 dark:to-purple-900/30 border border-pink-200 dark:border-pink-900/40 flex items-center justify-center">
                                        <i class="fa-solid fa-user-tie text-pink-500"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[9px] font-bold uppercase tracking-wider text-gray-400">
                                            Pengajar
                                        </p>
                                        <p class="text-xs font-extrabold text-gray-800 dark:text-gray-200 truncate mt-0.5">
                                            {{ $materi->guru->fullname ?? ($materi->guru->name ?? 'Guru Pengajar') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="w-8 h-8 shrink-0 rounded-full bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                                </div>
                            </div>

                            {{-- Tombol Ambil Materi --}}
                            <form action="{{ route('siswa.ruang-materi.ambil', $materi->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white text-xs font-black shadow-md shadow-pink-500/20 hover:shadow-lg hover:shadow-purple-500/25 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>AMBIL MATERI</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] ml-1 group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- ================================================= --}}
        {{-- PAGINATION --}}
        {{-- ================================================= --}}
        @if($materis->hasPages())
            <div class="pt-5 flex justify-center">
                <div class="bg-white dark:bg-cyberdark-900 rounded-2xl border border-gray-100 dark:border-gray-800 px-4 py-3 shadow-sm">
                    {{ $materis->appends(request()->query())->links() }}
                </div>
            </div>
        @endif

    @else

        {{-- ================================================= --}}
        {{-- EMPTY STATE --}}
        {{-- ================================================= --}}
        <div class="relative overflow-hidden bg-white dark:bg-cyberdark-900 rounded-[2rem] border-2 border-dashed border-pink-200 dark:border-gray-700 py-16 px-6 text-center">
            
            <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-pink-100/50 dark:bg-pink-900/10 blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-purple-100/50 dark:bg-purple-900/10 blur-3xl"></div>

            <div class="relative z-10">
                <div class="relative w-24 h-24 mx-auto mb-5">
                    <div class="absolute inset-0 rounded-[2rem] bg-pink-100 dark:bg-pink-900/20 rotate-12"></div>
                    <div class="absolute inset-0 rounded-[2rem] bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center shadow-xl">
                        <i class="fa-solid {{ $kataKunci ? 'fa-magnifying-glass' : 'fa-book-open' }} text-4xl text-white"></i>
                    </div>
                </div>

                @if($kataKunci)
                    <h3 class="text-lg font-black text-gray-900 dark:text-white">
                        Materi Tidak Ditemukan
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 max-w-sm mx-auto leading-relaxed">
                        Kami belum menemukan materi dengan kata kunci "{{ $kataKunci }}". Coba gunakan kata kunci lainnya.
                    </p>
                    <a href="{{ route('siswa.ruang-materi.eksplorasi') }}"
                        class="inline-flex items-center gap-2 mt-6 px-5 py-3 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 text-white text-xs font-black hover:shadow-lg transition-all">
                        <i class="fa-solid fa-rotate-left"></i>
                        LIHAT SEMUA MATERI
                    </a>
                @else
                    <h3 class="text-lg font-black text-gray-900 dark:text-white">
                        Belum Ada Materi Baru!
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 max-w-sm mx-auto leading-relaxed">
                        Saat ini belum ada ruang materi yang tersedia. Silakan kembali lagi nanti dan temukan petualangan belajar yang baru!
                    </p>
                    <div class="inline-flex items-center gap-2 mt-6 px-5 py-3 rounded-xl bg-pink-50 dark:bg-pink-900/20 text-pink-600 dark:text-pink-400 text-xs font-black">
                        <i class="fa-solid fa-heart"></i>
                        SEMANGAT BELAJAR!
                    </div>
                @endif
            </div>
        </div>

    @endif

</div>

@endsection