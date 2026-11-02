@extends('siswa.layouts.app')

@section('title', 'Pusat Evaluasi & Ujian Siswa')

@section('content')
<div class="flex items-center space-x-2 text-xs text-gray-400 dark:text-pink-400/40 mb-6">
    <a href="/ruang-belajar" class="hover:text-pink-500 transition-colors">Ruang Belajar</a>
    <span><i class="fa-solid fa-angle-right text-[10px]"></i></span>
    <span class="text-pink-500 font-medium">Daftar Ujian Tersedia</span>
</div>

<div class="mb-6 space-y-1">
    <h1 class="text-lg font-black text-gray-800 dark:text-white uppercase tracking-tight flex items-center gap-2">
        <i class="fa-solid fa-folder-open text-purple-500"></i> Pusat Evaluasi Kompetensi
    </h1>
    <p class="text-xs text-gray-400">Silakan pilih kartu ujian di bawah ini sesuai dengan jadwal dan instruksi pengawas.</p>
</div>

<div class="space-y-4 mb-8">
    <div class="flex items-center space-x-2 pb-2 border-b border-gray-100 dark:border-pink-950/10">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <h2 class="text-xs font-bold font-mono text-gray-400 uppercase tracking-wider">Ujian Aktif & Belum Diikuti</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        
        <div class="bg-white dark:bg-cyberdark-900 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-all">
            <div class="h-24 bg-gradient-to-r from-purple-600 to-indigo-700 p-4 relative flex items-end">
                <div class="absolute top-3 right-3 px-2 py-0.5 bg-black/30 backdrop-blur-md rounded font-mono text-[9px] text-white font-bold uppercase tracking-wider border border-white/10">
                    Pilihan Ganda
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 text-white text-lg">
                    <i class="fa-solid fa-list-check"></i>
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                <div>
                    <h3 class="text-xs font-black text-gray-800 dark:text-white line-clamp-2 uppercase leading-tight group-hover:text-purple-500 transition-colors">
                        Ujian Teori Akhir Modul 02: Hyperparameter CNN
                    </h3>
                    <p class="text-[11px] text-gray-400 mt-1 line-clamp-2 font-sans">
                        Menguji pemahaman filter spasial, padding, stride, dan pooling layer.
                    </p>
                </div>
                <div class="pt-2 border-t border-gray-50 dark:border-pink-950/10 grid grid-cols-2 gap-2 font-mono text-[10px] text-gray-400">
                    <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-purple-400"></i> 90 Menit</div>
                    <div class="flex items-center gap-1.5"><i class="fa-regular fa-file-lines text-pink-400"></i> 20 Soal</div>
                </div>
                <a href="/ruang-belajar/ujian/dashboard" class="w-full py-2 bg-gray-50 hover:bg-purple-600 dark:bg-cyberdark-950 dark:hover:bg-purple-600 text-gray-700 dark:text-pink-200 hover:text-white font-bold text-center text-[11px] rounded-xl border border-gray-100 dark:border-pink-950/10 hover:border-transparent transition-all uppercase tracking-wider">
                    Masuk Ruang Tes
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-cyberdark-900 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-all">
            <div class="h-24 bg-gradient-to-r from-amber-600 to-orange-700 p-4 relative flex items-end">
                <div class="absolute top-3 right-3 px-2 py-0.5 bg-black/30 backdrop-blur-md rounded font-mono text-[9px] text-white font-bold uppercase tracking-wider border border-white/10">
                    Essay / Uraian
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 text-white text-lg">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                <div>
                    <h3 class="text-xs font-black text-gray-800 dark:text-white line-clamp-2 uppercase leading-tight group-hover:text-amber-500 transition-colors">
                        Ujian Analisis & Coding: Arsitektur Jaringan CNN
                    </h3>
                    <p class="text-[11px] text-gray-400 mt-1 line-clamp-2 font-sans">
                        Studi kasus penyelesaian masalah overfitting dan pembuatan arsitektur mini.
                    </p>
                </div>
                <div class="pt-2 border-t border-gray-50 dark:border-pink-950/10 grid grid-cols-2 gap-2 font-mono text-[10px] text-gray-400">
                    <div class="flex items-center gap-1.5"><i class="fa-regular fa-clock text-amber-500"></i> 75 Menit</div>
                    <div class="flex items-center gap-1.5"><i class="fa-regular fa-file-code text-pink-400"></i> 5 Soal</div>
                </div>
                <a href="/ruang-belajar/ujian/dashboard-essay" class="w-full py-2 bg-gray-50 hover:bg-amber-600 dark:bg-cyberdark-950 dark:hover:bg-amber-600 text-gray-700 dark:text-pink-200 hover:text-white font-bold text-center text-[11px] rounded-xl border border-gray-100 dark:border-pink-950/10 hover:border-transparent transition-all uppercase tracking-wider">
                    Masuk Ruang Tes
                </a>
            </div>
        </div>

        <div class="bg-gray-50/50 dark:bg-cyberdark-950/20 rounded-2xl border border-dashed border-gray-200 dark:border-pink-950/10 overflow-hidden flex flex-col opacity-60 relative select-none">
            <div class="absolute inset-0 bg-gray-900/5 dark:bg-black/20 flex flex-col items-center justify-center z-10 text-gray-400 dark:text-gray-600">
                <i class="fa-solid fa-lock text-xl mb-1"></i>
                <p class="font-mono text-[9px] uppercase tracking-wider">Akses Terkunci</p>
            </div>
            
            <div class="h-24 bg-gray-300 dark:bg-cyberdark-800 p-4 flex items-end">
                <div class="w-10 h-10 rounded-xl bg-gray-400/20 flex items-center justify-center text-gray-400 text-lg">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                <div>
                    <h3 class="text-xs font-black text-gray-400 dark:text-gray-600 uppercase tracking-tight">
                        Ujian Akhir Semester (UAS): Deep Learning Capstone
                    </h3>
                    <p class="text-[10px] text-gray-400 mt-1">Selesaikan seluruh modul materi belajar untuk membuka kunci ujian komprehensif semester.</p>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="space-y-4">
    <div class="flex items-center space-x-2 pb-2 border-b border-gray-100 dark:border-pink-950/10">
        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
        <h2 class="text-xs font-bold font-mono text-gray-400 uppercase tracking-wider">Riwayat Riwayat Evaluasi Lampau</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        
        <div class="bg-white dark:bg-cyberdark-900 rounded-2xl border border-gray-200 dark:border-pink-950/10 shadow-sm p-4 relative overflow-hidden flex flex-col justify-between h-36">
            <span class="absolute top-3 right-3 px-1.5 py-0.5 bg-emerald-500/10 text-emerald-500 font-mono font-bold text-[9px] uppercase rounded">
                LULUS
            </span>
            
            <div class="space-y-1 pr-12">
                <p class="text-[9px] font-mono text-gray-400 uppercase tracking-wider">Modul 01: Pengenalan AI</p>
                <h4 class="text-xs font-bold text-gray-800 dark:text-white line-clamp-2 uppercase leading-tight">
                    Kuis Dasar Pemrograman Jaringan Saraf Tiruan (ANN)
                </h4>
            </div>

            <div class="pt-3 border-t border-gray-50 dark:border-pink-950/10 flex items-center justify-between font-mono">
                <div class="text-[10px] text-gray-400">
                    Nilai: <span class="text-sm font-black text-emerald-500">95</span> <span class="text-[9px]">/100</span>
                </div>
                <span class="text-[9px] text-gray-400"><i class="fa-solid fa-calendar-day mr-1"></i> Selesai: 12 Mei 2026</span>
            </div>
        </div>

    </div>
</div>
@endsection