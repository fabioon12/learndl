@extends('siswa.layouts.app')

@section('title', 'Dashboard Siswa - LearnDL')

@section('content')
<div class="space-y-6">

    <!-- 1. Header Greeting -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                Halo, {{ auth()->user()->fullname ?? 'Siswa' }}! <span class="animate-bounce">👋</span>
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                Terus semangat belajar dan raih level berikutnya!
            </p>
        </div>
    </div>

    <!-- Layout Grid Utama (Kiri & Kanan) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- SISI KIRI (8 Kolom) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Banner Level Progress -->
            <div class="relative bg-gradient-to-r from-indigo-500 via-purple-600 to-indigo-600 rounded-3xl p-6 text-white shadow-xl shadow-indigo-500/10 overflow-hidden">
                <div class="absolute -right-6 -bottom-8 opacity-20 pointer-events-none">
                    <i class="fa-solid fa-graduation-cap text-9xl"></i>
                </div>
                
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <!-- Medali Badge Level -->
                        <div class="w-16 h-16 rounded-2xl bg-amber-400 text-amber-900 flex items-center justify-center text-3xl shadow-lg shrink-0">
                            <i class="fa-solid fa-medal"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="text-xl font-bold tracking-tight">Level 3</h2>
                                <span class="px-2 py-0.5 bg-white/20 rounded-full text-[10px] font-semibold">Pelajar Aktif</span>
                            </div>
                            <p class="text-xs text-purple-100 mt-1">Kamu sudah hampir naik level!</p>
                        </div>
                    </div>

                    <!-- Progress Bar XP -->
                    <div class="w-full sm:w-64 space-y-1.5">
                        <div class="flex justify-between text-xs font-semibold text-purple-100">
                            <span>320 / 500 XP</span>
                            <span>64%</span>
                        </div>
                        <div class="w-full h-3 bg-black/20 rounded-full overflow-hidden p-0.5">
                            <div class="h-full bg-amber-400 rounded-full transition-all duration-500" style="width: 64%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mini Stat Cards Grid (4 Cards) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                
                <!-- Stat 1 -->
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-book"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">5</h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">Mata Pelajaran</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500">yang sedang kamu ambil</p>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">120</h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">XP Hari Ini</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500">dari aktivitas belajar</p>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/40 text-purple-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">3</h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">Badge</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500">yang sudah kamu dapatkan</p>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/40 text-rose-500 flex items-center justify-center text-base">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900 dark:text-white">2</h3>
                        <p class="text-[11px] font-semibold text-gray-700 dark:text-gray-300">Tugas Menunggu</p>
                        <p class="text-[10px] text-gray-400 dark:text-gray-500">untuk diselesaikan</p>
                    </div>
                </div>

            </div>

            <!-- Bagian Grid Mata Pelajaran -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-500"></i> Mata Pelajaran
                    </h2>
                    <a href="#" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    
                    <!-- Mapel 1 -->
                    <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-4 hover:border-indigo-500/40 transition">
                        <div class="flex items-start justify-between">
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-base font-bold">
                                <i class="fa-solid fa-code"></i>
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-200 dark:border-emerald-900/30">Aktif</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-extrabold text-gray-800 dark:text-white line-clamp-1">Dasar-Dasar Pemrograman</h3>
                            <div class="mt-3 space-y-1">
                                <div class="flex justify-between text-[10px] font-semibold text-gray-500 dark:text-gray-400">
                                    <span>3/5 Materi</span>
                                    <span>60%</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 dark:bg-cyberdark-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 rounded-full" style="width: 60%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapel 2 -->
                    <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-4 hover:border-purple-500/40 transition">
                        <div class="flex items-start justify-between">
                            <div class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center text-base font-bold">
                                <i class="fa-solid fa-shirt"></i>
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-200 dark:border-emerald-900/30">Aktif</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-extrabold text-gray-800 dark:text-white line-clamp-1">Tata Busana</h3>
                            <div class="mt-3 space-y-1">
                                <div class="flex justify-between text-[10px] font-semibold text-gray-500 dark:text-gray-400">
                                    <span>2/4 Materi</span>
                                    <span>50%</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 dark:bg-cyberdark-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-purple-500 rounded-full" style="width: 50%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapel 3 -->
                    <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-4 hover:border-blue-500/40 transition">
                        <div class="flex items-start justify-between">
                            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-base font-bold">
                                <i class="fa-solid fa-chart-pie"></i>
                            </div>
                            <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold rounded-full border border-emerald-200 dark:border-emerald-900/30">Aktif</span>
                        </div>
                        <div>
                            <h3 class="text-xs font-extrabold text-gray-800 dark:text-white line-clamp-1">Desain Grafis</h3>
                            <div class="mt-3 space-y-1">
                                <div class="flex justify-between text-[10px] font-semibold text-gray-500 dark:text-gray-400">
                                    <span>1/4 Materi</span>
                                    <span>25%</span>
                                </div>
                                <div class="w-full h-1.5 bg-gray-100 dark:bg-cyberdark-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Banner Motivasi / CTA -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-cyberdark-900 dark:to-indigo-950/30 p-5 rounded-3xl border border-blue-100 dark:border-pink-950/20 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shrink-0 text-lg">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900 dark:text-white">Jangan Lupa!</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400">Kamu sedang dalam perjalanan menjadi versi terbaik dari dirimu.</p>
                    </div>
                </div>
                <a href="#" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-2xl shadow-md shadow-indigo-500/20 shrink-0 transition">
                    Lanjut Belajar →
                </a>
            </div>

        </div>

        <!-- SISI KANAN (4 Kolom) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- 1. Peringkat Kelas Card -->
            <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 pb-3">
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-amber-500"></i> Peringkat Kelas
                    </h3>
                    <a href="#" class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua →</a>
                </div>

                <div class="space-y-3 text-xs">
                    
                    <!-- Juara 1 -->
                    <div class="flex items-center justify-between p-2 rounded-2xl hover:bg-gray-50 dark:hover:bg-cyberdark-800 transition">
                        <div class="flex items-center gap-3">
                            <span class="font-extrabold text-amber-500 w-3">1</span>
                            <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Siti&backgroundColor=b6e3f4" class="w-8 h-8 rounded-full border border-pink-500/30">
                            <div>
                                <p class="font-bold text-gray-800 dark:text-gray-100">Siti Nurhaliza</p>
                                <p class="text-[10px] text-gray-400">X RPL 1</p>
                            </div>
                        </div>
                        <span class="font-black text-amber-500 text-[11px]">980 XP</span>
                    </div>

                    <!-- Juara 2 -->
                    <div class="flex items-center justify-between p-2 rounded-2xl hover:bg-gray-50 dark:hover:bg-cyberdark-800 transition">
                        <div class="flex items-center gap-3">
                            <span class="font-extrabold text-slate-400 w-3">2</span>
                            <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Budi&backgroundColor=b6e3f4" class="w-8 h-8 rounded-full border border-pink-500/30">
                            <div>
                                <p class="font-bold text-gray-800 dark:text-gray-100">Budi Santoso</p>
                                <p class="text-[10px] text-gray-400">X RPL 1</p>
                            </div>
                        </div>
                        <span class="font-black text-slate-400 text-[11px]">860 XP</span>
                    </div>

                    <!-- Juara 3 (Siswa Aktif) -->
                    <div class="flex items-center justify-between p-2.5 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-900/40">
                        <div class="flex items-center gap-3">
                            <span class="font-extrabold text-indigo-600 dark:text-indigo-400 w-3">3</span>
                            <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed={{ urlencode(auth()->user()->fullname ?? 'Siswa') }}&backgroundColor=b6e3f4" class="w-8 h-8 rounded-full border-2 border-indigo-500">
                            <div>
                                <p class="font-extrabold text-indigo-950 dark:text-white">{{ auth()->user()->fullname ?? 'Kamu' }}</p>
                                <p class="text-[10px] text-indigo-500 dark:text-indigo-300">X RPL 1</p>
                            </div>
                        </div>
                        <span class="font-black text-indigo-600 dark:text-indigo-400 text-[11px]">720 XP</span>
                    </div>

                </div>
            </div>

            <!-- 2. Badge Terbaru -->
            <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 pb-3">
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-certificate text-indigo-500"></i> Badge Terbaru
                    </h3>
                    <a href="#" class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-3 gap-2 text-center">
                    
                    <!-- Badge Pemula -->
                    <div class="p-2.5 rounded-2xl bg-orange-50/50 dark:bg-orange-950/20 border border-orange-100 dark:border-orange-900/30 space-y-1">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-orange-500 text-white flex items-center justify-center text-lg shadow-sm">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <p class="text-[11px] font-bold text-gray-800 dark:text-white mt-1">Pemula</p>
                        <p class="text-[9px] text-gray-400">Selesaikan 1 materi</p>
                    </div>

                    <!-- Badge Aktif -->
                    <div class="p-2.5 rounded-2xl bg-blue-50/50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900/30 space-y-1">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-blue-500 text-white flex items-center justify-center text-lg shadow-sm">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <p class="text-[11px] font-bold text-gray-800 dark:text-white mt-1">Aktif</p>
                        <p class="text-[9px] text-gray-400">Login 7 hari</p>
                    </div>

                    <!-- Badge Kolaboratif -->
                    <div class="p-2.5 rounded-2xl bg-purple-50/50 dark:bg-purple-950/20 border border-purple-100 dark:border-purple-900/30 space-y-1">
                        <div class="w-10 h-10 mx-auto rounded-xl bg-purple-500 text-white flex items-center justify-center text-lg shadow-sm">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <p class="text-[11px] font-bold text-gray-800 dark:text-white mt-1">Kolaboratif</p>
                        <p class="text-[9px] text-gray-400">Ikut forum diskusi</p>
                    </div>

                </div>
            </div>

            <!-- 3. Agenda Hari Ini -->
            <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 pb-3">
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-calendar-day text-indigo-500"></i> Agenda Hari Ini
                    </h3>
                    <a href="#" class="text-[11px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua →</a>
                </div>

                <div class="space-y-3">
                    
                    <!-- Agenda 1 -->
                    <div class="flex items-start gap-3 p-2.5 rounded-2xl bg-gray-50 dark:bg-cyberdark-800/60">
                        <div class="w-2.5 h-2.5 rounded-full bg-purple-500 mt-1 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1">
                                <p class="text-xs font-bold text-gray-800 dark:text-white truncate">Tugas: Logika Pemrograman</p>
                                <span class="text-[10px] font-semibold text-gray-400 shrink-0">08:00 - 23:59</span>
                            </div>
                            <p class="text-[10px] text-gray-400 truncate">Dasar-Dasar Pemrograman</p>
                        </div>
                    </div>

                    <!-- Agenda 2 -->
                    <div class="flex items-start gap-3 p-2.5 rounded-2xl bg-gray-50 dark:bg-cyberdark-800/60">
                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 mt-1 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1">
                                <p class="text-xs font-bold text-gray-800 dark:text-white truncate">Ujian Harian</p>
                                <span class="text-[10px] font-semibold text-gray-400 shrink-0">10:00 - 11:00</span>
                            </div>
                            <p class="text-[10px] text-gray-400 truncate">Pemrograman Dasar</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection