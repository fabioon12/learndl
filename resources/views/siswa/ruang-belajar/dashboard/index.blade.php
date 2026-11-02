@extends('siswa.layouts.app')

@section('title', 'Dashboard Ruang Belajar Saya')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto px-4 sm:px-6 py-4">

    <!-- HERO BANNER HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-700 dark:from-cyberdark-900 dark:via-purple-950/80 dark:to-cyberdark-800 p-6 md:p-8 border border-pink-400/30 dark:border-pink-950/40 shadow-lg text-white flex flex-col md:flex-row items-center justify-between gap-6">
        
        <!-- Ambient Glow Background -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-pink-400/20 dark:bg-pink-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute left-1/3 -top-10 w-32 h-32 bg-purple-300/20 dark:bg-indigo-500/10 rounded-full blur-xl pointer-events-none"></div>

        <div class="space-y-2 max-w-xl relative z-10">
            <!-- Badge Icon -->
            <div class="w-10 h-10 rounded-2xl bg-white/20 dark:bg-pink-950/50 backdrop-blur-md text-white flex items-center justify-center shadow-md mb-3 border border-white/30 dark:border-pink-500/30">
                <i class="fa-solid fa-shapes text-lg text-pink-100 dark:text-pink-300"></i>
            </div>

            <h1 class="text-2xl font-black tracking-tight text-white dark:text-transparent dark:bg-clip-text dark:bg-gradient-to-r dark:from-white dark:to-pink-200">
                Ruang Belajar Saya 📚
            </h1>

            <p class="text-xs text-pink-100 dark:text-gray-300 leading-relaxed">
                Pantau progres pembelajaranmu dan lanjutkan aktivitas modul pada kelas yang sudah kamu ikuti.
            </p>
        </div>

        <!-- Floating CTA Button -->
        <div class="relative z-10 shrink-0 flex items-center">
            <a href="{{ route('siswa.ruang-belajar.eksplorasi') }}" 
               class="px-5 py-3 rounded-2xl bg-white text-pink-600 dark:bg-pink-500 dark:text-white font-extrabold text-xs shadow-lg hover:shadow-xl hover:scale-105 active:scale-95 transition-all duration-200 flex items-center gap-2">
                <i class="fa-solid fa-compass"></i> Cari Ruang Baru
            </a>
        </div>
    </div>

    <!-- RINGKASAN STATISTIK BELAJAR -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Ruang Belajar Diikuti -->
        <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-2xl p-4 flex items-center gap-4 shadow-xs">
            <div class="w-12 h-12 rounded-2xl bg-pink-50 dark:bg-pink-950/40 text-pink-600 dark:text-pink-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Ruang Diikuti</span>
                <span class="text-xl font-black text-gray-900 dark:text-white">0</span>
                <span class="block text-[10px] text-gray-400 font-medium mt-0.5">Kelas aktif kamu</span>
            </div>
        </div>

        <!-- Modul Tuntas -->
        <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-2xl p-4 flex items-center gap-4 shadow-xs">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Kelas Tuntas</span>
                <span class="text-xl font-black text-gray-900 dark:text-white">0</span>
                <span class="block text-[10px] text-emerald-500 font-bold mt-0.5">Tingkatkan terus!</span>
            </div>
        </div>

        <!-- Rata-rata Progres -->
        <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-2xl p-4 flex items-center gap-4 shadow-xs">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <span class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">Rata-rata Progres</span>
                <span class="text-xl font-black text-gray-900 dark:text-white">0 %</span>
                <span class="block text-[10px] text-gray-400 font-medium mt-0.5">Keseluruhan kelas</span>
            </div>
        </div>
    </div>

    <!-- SECTION TITLE -->
    <div class="pt-2">
        <h2 class="text-base font-black text-gray-900 dark:text-white">Daftar Kelas Aktif</h2>
        <p class="text-xs text-gray-400">Lanjutkan pembelajaran dari modul yang terakhir kamu akses.</p>
    </div>

    <!-- GRID CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($classList as $item)
            @php
                $id = is_array($item) ? $item['id'] : $item->id;
                $judul = is_array($item) ? $item['judul'] : $item->judul;
                $deskripsi = is_array($item) ? ($item['deskripsi'] ?? null) : ($item->deskripsi ?? null);
                $mapel = is_array($item) ? $item['mapel'] : $item->mapel;
                $kelas = is_array($item) ? $item['kelas'] : $item->kelas;
                $pengajar = is_array($item) 
                    ? ($item['pengajar'] ?? ($item['guru']['fullname'] ?? ($item['user']['fullname'] ?? 'Pengajar'))) 
                    : ($item->guru->fullname ?? ($item->user->fullname ?? 'Pengajar'));
                $thumbnail = is_array($item) ? $item['thumbnail'] : $item->thumbnail;
                $progress = is_array($item) ? $item['progress'] : ($item->pivot->progress_percent ?? 0);
                
                // Tambahan data statistik modul
                $completedModul = is_array($item) ? ($item['completed_modul'] ?? 0) : ($item->completed_materi_count ?? 0);
                $totalModul = is_array($item) ? ($item['total_modul'] ?? 0) : ($item->materi_count ?? 0);

                // Theme dinamis berdasarkan Mata Pelajaran
                $theme = match(strtolower($mapel)) {
                    'informatika' => [
                        'bg' => 'from-indigo-600 via-indigo-700 to-purple-800',
                        'badge' => 'bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 border-indigo-500/30',
                        'icon' => 'fa-code',
                        'accent' => 'bg-indigo-500'
                    ],
                    'matematika' => [
                        'bg' => 'from-blue-600 via-sky-600 to-indigo-700',
                        'badge' => 'bg-blue-500/20 text-blue-600 dark:text-blue-400 border-blue-500/30',
                        'icon' => 'fa-calculator',
                        'accent' => 'bg-blue-500'
                    ],
                    'seni & desain', 'seni' => [
                        'bg' => 'from-amber-500 via-orange-600 to-red-600',
                        'badge' => 'bg-amber-500/20 text-amber-600 dark:text-amber-400 border-amber-500/30',
                        'icon' => 'fa-palette',
                        'accent' => 'bg-amber-500'
                    ],
                    'ipa' => [
                        'bg' => 'from-emerald-600 via-teal-600 to-cyan-700',
                        'badge' => 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 border-emerald-500/30',
                        'icon' => 'fa-flask',
                        'accent' => 'bg-emerald-500'
                    ],
                    'bahasa' => [
                        'bg' => 'from-rose-500 via-pink-600 to-purple-700',
                        'badge' => 'bg-rose-500/20 text-rose-600 dark:text-rose-400 border-rose-500/30',
                        'icon' => 'fa-language',
                        'accent' => 'bg-rose-500'
                    ],
                    default => [
                        'bg' => 'from-purple-600 via-pink-600 to-indigo-800',
                        'badge' => 'bg-pink-500/20 text-pink-600 dark:text-pink-400 border-pink-500/30',
                        'icon' => 'fa-shapes',
                        'accent' => 'bg-pink-500'
                    ]
                };
            @endphp

            <!-- MODERN DASHBOARD CARD CONTAINER -->
            <div class="group relative bg-white dark:bg-cyberdark-900/90 border border-gray-100 dark:border-pink-950/30 rounded-3xl overflow-hidden shadow-xs hover:shadow-xl hover:border-pink-500/40 transition-all duration-300 flex flex-col justify-between transform hover:-translate-y-1">
                
                <!-- Top Line Color Accent -->
                <div class="h-1.5 w-full {{ $theme['accent'] }}"></div>

                <div>
                    <!-- BANNER VISUAL HEADER -->
                    <div class="relative h-36 bg-gradient-to-br {{ $theme['bg'] }} p-4 flex items-center justify-center text-white overflow-hidden">
                        
                        <!-- Ambient Glow Circles -->
                        <div class="absolute -top-10 -right-10 w-28 h-28 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                        <div class="absolute -bottom-10 -left-10 w-28 h-28 bg-black/20 rounded-full blur-xl pointer-events-none"></div>

                        @if($thumbnail)
                            <img src="{{ asset('storage/' . $thumbnail) }}" alt="{{ $judul }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                        @else
                            <!-- Dynamic Icon Pattern -->
                            <div class="relative z-10 text-white flex flex-col items-center justify-center">
                                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-2xl shadow-lg transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                    <i class="fa-solid {{ $theme['icon'] }}"></i>
                                </div>
                            </div>
                        @endif

                        <!-- Floating Badge Kelas Top Left -->
                        <div class="absolute top-3 left-3 z-10">
                            <span class="px-2.5 py-1 rounded-xl bg-black/40 backdrop-blur-md text-white border border-white/20 text-[10px] font-black tracking-wide flex items-center gap-1.5">
                                <i class="fa-solid fa-graduation-cap text-amber-300 text-[10px]"></i> Kelas {{ $kelas }}
                            </span>
                        </div>

                        <!-- Progress Status Badge Top Right -->
                        <div class="absolute top-3 right-3 z-10">
                            <span class="px-2.5 py-1 rounded-xl {{ $progress == 100 ? 'bg-emerald-500/90 text-white border-emerald-400/40' : 'bg-black/40 text-pink-300 border-white/20' }} backdrop-blur-md border text-[10px] font-black flex items-center gap-1">
                                @if($progress == 100)
                                    <i class="fa-solid fa-circle-check text-white"></i> Selesai
                                @else
                                    <i class="fa-solid fa-spinner fa-spin text-[9px]"></i> {{ $progress }}%
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- DETAILS CONTENT -->
                    <div class="p-5 space-y-4">
                        
                        <!-- Subject Badge & Last Access Info -->
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-lg border text-[10px] font-extrabold uppercase tracking-wider flex items-center gap-1.5 {{ $theme['badge'] }}">
                                <i class="fa-solid fa-layer-group text-[9px]"></i> {{ $mapel }}
                            </span>

                            <span class="text-[10px] text-gray-400 font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-fire text-amber-500 text-[10px]"></i> Aktif
                            </span>
                        </div>

                        <!-- Title & Teacher Info -->
                        <div class="space-y-1">
                            <h3 class="text-sm font-black text-gray-900 dark:text-white line-clamp-1 group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors cursor-pointer" title="{{ $judul }}">
                                {{ $judul }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                {{ $deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                            </p>
                            
                            <div class="flex items-center gap-2 pt-1">
                                <div class="w-6 h-6 rounded-full bg-pink-100 dark:bg-pink-950/50 border border-pink-200 dark:border-pink-800/40 text-pink-600 dark:text-pink-300 flex items-center justify-center text-[10px] font-bold shrink-0">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">
                                    <span class="text-gray-900 dark:text-gray-200 font-bold">{{ $pengajar }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- PROGRESS BAR BELAJAR & STATS MODUL -->
                        <div class="space-y-2 pt-2 border-t border-gray-100 dark:border-pink-950/20">
                            <div class="flex items-center justify-between text-[11px] font-extrabold">
                                <span class="text-gray-500 dark:text-gray-400 flex items-center gap-1.5">
                                    <i class="fa-solid fa-list-check text-pink-500"></i> Modul Tuntas
                                </span>
                                <span class="text-gray-900 dark:text-white">
                                    <strong class="text-pink-600 dark:text-pink-400">{{ $completedModul }}</strong> / {{ $totalModul }} Modul
                                </span>
                            </div>

                            <!-- Progress Bar Container -->
                            <div class="relative w-full h-2.5 bg-gray-100 dark:bg-cyberdark-800 rounded-full overflow-hidden p-0.5 border border-gray-200/60 dark:border-pink-950/30">
                                <div class="h-full bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-600 rounded-full transition-all duration-500 shadow-sm" style="width: {{ $progress }}%"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- FOOTER ACTION BUTTON -->
                <div class="p-5 pt-0">
                    <a href="{{ route('siswa.ruang-belajar.tahapan', $id) }}" 
                    class="w-full py-2.5 rounded-2xl bg-gradient-to-r from-pink-500 via-purple-600 to-indigo-600 hover:from-pink-600 hover:to-indigo-700 text-white text-[11px] font-extrabold text-center flex items-center justify-center gap-2 transition-all duration-200 shadow-md hover:shadow-pink-500/20 active:scale-95">
                        <span>{{ $progress == 100 ? 'Ulas Kembali Modul' : 'Lanjutkan Belajar' }}</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <!-- EMPTY STATE -->
            <div class="col-span-full py-16 text-center bg-white dark:bg-cyberdark-900/90 border border-gray-100 dark:border-pink-950/30 rounded-3xl space-y-4 shadow-xs">
                <div class="w-16 h-16 rounded-3xl bg-pink-500/10 text-pink-500 flex items-center justify-center text-2xl mx-auto border border-pink-500/20">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <div class="space-y-1 max-w-sm mx-auto">
                    <h3 class="text-sm font-black text-gray-900 dark:text-white">Kamu belum mengikuti Ruang Belajar apapun</h3>
                    <p class="text-xs text-gray-400">Jelajahi kumpulan ruang belajar yang disediakan guru dan mulailah belajar hari ini.</p>
                </div>
                <a href="{{ route('siswa.ruang-belajar.eksplorasi') }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-pink-500 to-purple-600 text-white text-xs font-bold shadow-md hover:shadow-lg transition-all active:scale-95">
                    <i class="fa-solid fa-compass"></i> Eksplorasi Ruang Belajar Sekarang
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection