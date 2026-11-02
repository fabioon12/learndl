@extends('guru.layouts.app')

@section('title', 'Ruang Belajar : ' . ($ruangBelajar->judul ?? 'Dasar Pemrograman'))

@section('content')
<div class="space-y-8">
    
    <!-- Top Action & Navigation Header (Hanya Tombol Kembali) -->


    <!-- Main Grid Layout (Left Content 8 Cols, Right Sidebar 4 Cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- LEFT COLUMN (8 COLS) -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Banner Header Materi Futuristic -->
            <div class="relative bg-gradient-to-br from-white via-indigo-50/30 to-purple-50/20 dark:from-cyberdark-900 dark:via-cyberdark-900/90 dark:to-indigo-950/20 backdrop-blur-2xl border border-gray-200/80 dark:border-pink-950/40 rounded-3xl p-6 sm:p-8 shadow-sm overflow-hidden flex flex-col md:flex-row items-start justify-between gap-6 group">
                <!-- Decorative Glow Blur Behind -->
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none group-hover:bg-indigo-500/20 transition-all duration-500"></div>

                <div class="space-y-4 max-w-xl z-10">
                    <!-- Unified Top Action & Badges Row (Tombol Kembali & Badges Menyatu) -->
                    <div class="flex items-center gap-2.5 flex-wrap">
                        <!-- Tombol Kembali -->
                        <a href="{{ route('guru.ruang-belajar.index') }}" 
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white/80 dark:bg-cyberdark-800/80 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 text-[11px] font-extrabold border border-gray-200/80 dark:border-pink-950/40 transition-all duration-300 shadow-xs hover:-translate-x-1">
                            <i class="fa-solid fa-arrow-left text-xs text-indigo-500"></i>
                            <span>Kembali</span>
                        </a>

                        <!-- Badge Kelas -->
                        <span class="px-3.5 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800/40 backdrop-blur-md flex items-center gap-1.5">
                            <i class="fa-solid fa-users"></i> Kelas {{ $ruangBelajar->kelas ?? 'X RPL 1' }}
                        </span>

                        <!-- Badge Mata Pelajaran / Mapel -->
                        <span class="px-3.5 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-xl bg-purple-500/10 dark:bg-purple-500/20 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800/40 backdrop-blur-md flex items-center gap-1.5">
                            <i class="fa-solid fa-book-open"></i> {{ $ruangBelajar->mapel ?? '8 Materi' }}
                        </span>
                    </div>

                    <!-- Judul Ruang Belajar -->
                    <h1 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white tracking-tight leading-tight">
                        Ruang Belajar : <span class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-pink-400 bg-clip-text text-transparent">{{ $ruangBelajar->judul ?? 'Dasar Pemrograman' }}</span>
                    </h1>

                    <!-- Deskripsi -->
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ $ruangBelajar->deskripsi ?? 'Ruang belajar ini berisi materi dasar pemrograman dengan pendekatan deep learning yang interaktif dan menyenangkan.' }}
                    </p>
                </div>

                <!-- Banner Thumbnail Preview -->
                <div class="relative w-full md:w-52 h-36 rounded-2xl overflow-hidden shrink-0 border-2 border-white dark:border-pink-950/40 shadow-md group-hover:scale-105 transition-all duration-500">
                    <img src="{{ isset($ruangBelajar->thumbnail) ? asset('storage/' . $ruangBelajar->thumbnail) : 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=600&auto=format&fit=crop' }}" 
                        alt="Banner Header" 
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                </div>
            </div>

            <!-- Top Summary Stats Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Stat 1: Total Tahapan -->
                <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 p-4 rounded-3xl shadow-sm hover:border-indigo-500/30 transition-all duration-300 flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-gamepad"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Tahapan</p>
                        <h4 class="text-base font-black text-gray-900 dark:text-white mt-0.5">{{ $countAktif ?? 0 }}</h4>
                    </div>
                </div>

                <!-- Stat 2: Tahapan Selesai -->
                <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 p-4 rounded-3xl shadow-sm hover:border-emerald-500/30 transition-all duration-300 flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Selesai</p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <h4 class="text-base font-black text-gray-900 dark:text-white">3</h4>
                            <span class="text-[9px] font-bold text-emerald-500 bg-emerald-500/10 px-1.5 py-0.5 rounded-md">37%</span>
                        </div>
                    </div>
                </div>

                <!-- Stat 3: Tahapan Aktif -->
                <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 p-4 rounded-3xl shadow-sm hover:border-blue-500/30 transition-all duration-300 flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-blue-500/10 text-blue-500 flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Aktif</p>
                        <h4 class="text-base font-black text-gray-900 dark:text-white mt-0.5">1 Tahapan</h4>
                    </div>
                </div>

                <!-- Stat 4: XP Ruang Belajar -->
                <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 p-4 rounded-3xl shadow-sm hover:border-amber-500/30 transition-all duration-300 flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">XP Total</p>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <h4 class="text-base font-black text-gray-900 dark:text-white">{{ $totalXp ??  0 }}</h4>
                            <span class="text-[9px] font-bold text-amber-500 bg-amber-500/10 px-1.5 py-0.5 rounded-md">Lvl 3</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Include Component Peta Tahapan -->
            @include('guru.tahapan-ruang-belajar.peta-tahapan.index')
        </div>

        <!-- RIGHT SIDEBAR (4 COLS) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Card Statistik Tahapan -->
            <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-pink-950/20">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-chart-simple"></i>
                        </div>
                        <h3 class="text-xs font-black text-gray-900 dark:text-white">Statistik Tahapan</h3>
                    </div>
                    <a href="#" class="text-[11px] font-extrabold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Detail →</a>
                </div>

                <!-- Progress Bars List -->
                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="flex items-center gap-2 text-gray-600 dark:text-gray-300 font-bold">
                                <i class="fa-solid fa-circle-check text-indigo-500"></i> Ditambahkan
                            </span>
                            <span class="font-black text-gray-900 dark:text-white">8 Tahapan</span>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="flex items-center gap-2 text-gray-600 dark:text-gray-300 font-bold">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i> Selesai
                            </span>
                            <span class="font-black text-gray-900 dark:text-white">37%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-cyberdark-800 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: 37%"></div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="flex items-center gap-2 text-gray-600 dark:text-gray-300 font-bold">
                                <i class="fa-solid fa-clock text-blue-500"></i> Aktif
                            </span>
                            <span class="font-black text-gray-900 dark:text-white">13%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-cyberdark-800 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full transition-all duration-500" style="width: 13%"></div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="flex items-center gap-2 text-gray-600 dark:text-gray-300 font-bold">
                                <i class="fa-solid fa-hourglass-half text-amber-500"></i> Menunggu
                            </span>
                            <span class="font-black text-gray-900 dark:text-white">50%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-cyberdark-800 overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full transition-all duration-500" style="width: 50%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Tahapan Terbaru -->
            <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-pink-950/20">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h3 class="text-xs font-black text-gray-900 dark:text-white">Tahapan Terbaru</h3>
                    </div>
                    <a href="#tahapan-section" class="text-[11px] font-extrabold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua →</a>
                </div>

                <!-- Recent List -->
                <div class="space-y-2.5">
                    @forelse($tahapanTerbaru ?? [] as $tahapan)
                        @php
                            $icon = $tahapan->icon ?? 'fa-code';

                            // Pemetaan warna background & teks ikon sesuai preset
                            $iconStyles = [
                                'fa-flag'   => 'bg-pink-500/10 text-pink-500',
                                'fa-star'   => 'bg-amber-500/10 text-amber-500',
                                'fa-gift'   => 'bg-purple-500/10 text-purple-500',
                                'fa-trophy' => 'bg-emerald-500/10 text-emerald-500',
                            ];

                            $style = $iconStyles[$icon] ?? 'bg-indigo-500/10 text-indigo-500';
                        @endphp

                        <div class="flex items-center justify-between p-2.5 rounded-2xl hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 transition cursor-pointer group">
                            <div class="flex items-center gap-3 min-w-0">
                                <!-- Icon Preset Container -->
                                <div class="w-10 h-10 rounded-2xl {{ $style }} flex items-center justify-center text-sm font-bold shrink-0 group-hover:scale-110 transition duration-300">
                                    <i class="{{ Str::startsWith($icon, 'fa-') ? 'fa-solid ' . $icon : 'fa-solid fa-code' }}"></i>
                                </div>
                                
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate" title="{{ $tahapan->judul_tahapan }}">
                                        {{ $tahapan->urutan }}. {{ $tahapan->judul_tahapan }}
                                    </h4>
                                    <p class="text-[10px] text-gray-400">
                                        0 Sub Aktivitas
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-1 shrink-0">
                                <span class="text-[9px] font-black text-amber-500 bg-amber-500/10 px-2 py-0.5 rounded-md">
                                    +{{ $tahapan->xp_reward ?? 100 }} XP
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-xs text-gray-400">Belum ada tahapan yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Callout Card Gamification Leaderboard -->
            <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl p-6 text-white space-y-4 shadow-xl shadow-indigo-500/25 overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="flex items-start justify-between relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl text-amber-300 border border-white/20 shadow-inner group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <span class="px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-full bg-amber-400/20 text-amber-300 border border-amber-300/30">
                        Gamification
                    </span>
                </div>

                <div class="space-y-1 relative z-10">
                    <h4 class="text-xs sm:text-sm font-black leading-snug">Ajak siswa untuk menyelesaikan semua tahapan & kumpulkan XP!</h4>
                    <p class="text-[11px] text-indigo-100/80">Pantau peringkat teratas siswa di kelas ini.</p>
                </div>

                <button type="button" 
                        class="w-full py-3 bg-white text-indigo-700 hover:bg-gray-100 rounded-2xl text-xs font-black transition-all duration-300 shadow-lg active:scale-95 cursor-pointer relative z-10 flex items-center justify-center gap-2">
                    <span>Lihat Leaderboard Siswa</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>

        </div>

    </div>

</div>
@endsection