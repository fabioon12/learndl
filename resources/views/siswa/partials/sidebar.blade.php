<aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 w-64 bg-white/90 dark:bg-cyberdark-900/90 backdrop-blur-xl border-r border-gray-100 dark:border-pink-950/30 flex flex-col justify-between transition-all duration-300 ease-in-out z-50 lg:z-20 shadow-2xl shadow-gray-200/50 dark:shadow-none h-screen max-h-screen overflow-hidden">
    
    <!-- Bagian Atas: Logo & Navigasi Utama -->
    <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
        
        <!-- Brand Logo Header -->
        <div class="p-4 sm:p-5 flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 h-16 shrink-0">
            <div id="sidebar-logo" class="flex items-center space-x-2.5 sm:space-x-3 min-w-0 pr-2">
                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-tr from-blue-600 via-indigo-600 to-pink-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-pink-500/20 shrink-0">
                    <i class="fa-solid fa-brain text-base sm:text-lg animate-pulse"></i>
                </div>
                <div class="sidebar-text min-w-0 flex-1">
                    <span class="font-extrabold text-base sm:text-lg tracking-tight bg-gradient-to-r from-blue-600 via-indigo-500 to-pink-500 bg-clip-text text-transparent dark:from-blue-400 dark:via-purple-400 dark:to-pink-400 block leading-none truncate">
                        LearnDL
                    </span>
                    <p class="text-[8px] font-bold tracking-tight text-gray-400 dark:text-pink-400/70 mt-1 leading-tight truncate">
                        Bermakna, Menyenangkan, Berkesadaran
                    </p>
                </div>
            </div>

            <!-- Tombol Close Sidebar (Mobile Only) -->
            <button id="close-sidebar-btn" class="lg:hidden p-1.5 text-gray-400 hover:text-pink-500 rounded-xl hover:bg-gray-100 dark:hover:bg-cyberdark-800 transition cursor-pointer shrink-0">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 p-3 sm:p-3.5 space-y-1 sm:space-y-1.5 overflow-y-auto custom-scrollbar">
            
            <!-- Item 1: Dashboard Utama -->
            <a href="{{ route('siswa.dashboard') }}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->routeIs('siswa.dashboard') ? 'bg-gradient-to-r from-pink-500/10 to-purple-500/10 text-pink-600 dark:text-pink-400 border border-pink-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->routeIs('siswa.dashboard') ? 'bg-pink-500 text-white shadow-md shadow-pink-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-pink-500/10 group-hover:text-pink-500' }}">
                    <i class="fa-solid fa-chart-pie text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Dashboard</span>
            </a>

            <!-- Item 2: Ruang Belajar (Dropdown Accordion) -->
            <div x-data="{ open: {{ request()->routeIs('siswa.ruang-belajar.*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        type="button"
                        class="w-full flex items-center justify-between px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group cursor-pointer {{ request()->routeIs('siswa.ruang-belajar.*') ? 'bg-gradient-to-r from-pink-500/10 to-purple-500/10 text-pink-600 dark:text-pink-400 border border-pink-500/20 font-bold shadow-xs' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->routeIs('siswa.ruang-belajar.*') ? 'bg-pink-500 text-white shadow-md shadow-pink-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-pink-500/10 group-hover:text-pink-500' }}">
                            <i class="fa-solid fa-graduation-cap text-xs sm:text-sm"></i>
                        </div>
                        <span class="sidebar-text text-xs tracking-wide truncate">Ruang Belajar</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200"
                       :class="open ? 'rotate-180 text-pink-500' : 'text-gray-400'"></i>
                </button>

                <div x-show="open" 
                     x-collapse 
                     x-cloak
                     class="pl-11 pr-2 space-y-1 pt-1">
                    <a href="{{ route('siswa.ruang-belajar.dashboard') }}" 
                       class="flex items-center space-x-2 py-2 px-3 rounded-xl text-xs transition-colors {{ request()->routeIs('siswa.ruang-belajar.dashboard*') ? 'text-pink-600 dark:text-pink-400 font-bold bg-pink-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-pink-300 hover:bg-gray-100/50 dark:hover:bg-cyberdark-800/50 font-medium' }}">
                        <i class="fa-solid fa-shapes text-[10px]"></i>
                        <span class="truncate">Dashboard Saya</span>
                    </a>
                    <a href="{{ route('siswa.ruang-belajar.eksplorasi') }}" 
                       class="flex items-center space-x-2 py-2 px-3 rounded-xl text-xs transition-colors {{ request()->routeIs('siswa.ruang-belajar.eksplorasi*') ? 'text-pink-600 dark:text-pink-400 font-bold bg-pink-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-pink-300 hover:bg-gray-100/50 dark:hover:bg-cyberdark-800/50 font-medium' }}">
                        <i class="fa-solid fa-compass text-[10px]"></i>
                        <span class="truncate">Eksplorasi Ruang</span>
                    </a>
                </div>
            </div>

            <!-- Item 3: Ruang Materi (Dropdown Accordion) -->
            <div x-data="{ open: {{ request()->routeIs('siswa.ruang-materi.*') ? 'true' : 'false' }} }" class="space-y-1">
                <button @click="open = !open" 
                        type="button"
                        class="w-full flex items-center justify-between px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group cursor-pointer {{ request()->routeIs('siswa.ruang-materi.*') ? 'bg-gradient-to-r from-pink-500/10 to-purple-500/10 text-pink-600 dark:text-pink-400 border border-pink-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                    <div class="flex items-center space-x-3 truncate">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->routeIs('siswa.ruang-materi.*') ? 'bg-pink-500 text-white shadow-md shadow-pink-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-pink-500/10 group-hover:text-pink-500' }}">
                            <i class="fa-solid fa-book-bookmark text-xs sm:text-sm"></i>
                        </div>
                        <span class="sidebar-text text-xs tracking-wide truncate">Ruang Materi</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" 
                       :class="open ? 'rotate-180 text-pink-500' : 'text-gray-400'"></i>
                </button>

                <div x-show="open" 
                     x-collapse
                     x-cloak
                     class="pl-11 pr-2 space-y-1 pt-1">
                    <a href="{{ route('siswa.ruang-materi.index') }}" 
                       class="flex items-center space-x-2.5 px-3 py-1.5 rounded-xl text-xs transition-all duration-200 {{ request()->routeIs('siswa.ruang-materi.index*') ? 'text-pink-600 dark:text-pink-400 font-bold bg-pink-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-pink-300 font-semibold hover:bg-gray-100/50 dark:hover:bg-cyberdark-800/50' }}">
                        <i class="fa-solid fa-house-user text-[11px] opacity-70"></i>
                        <span class="truncate">Dashboard Saya</span>
                    </a>
                    <a href="{{ route('siswa.ruang-materi.eksplorasi') }}" 
                       class="flex items-center space-x-2.5 px-3 py-1.5 rounded-xl text-xs transition-all duration-200 {{ request()->routeIs('siswa.ruang-materi.eksplorasi*') ? 'text-pink-600 dark:text-pink-400 font-bold bg-pink-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-pink-300 font-semibold hover:bg-gray-100/50 dark:hover:bg-cyberdark-800/50' }}">
                        <i class="fa-solid fa-compass text-[11px] opacity-70"></i>
                        <span class="truncate">Eksplorasi Kelas</span>
                    </a>
                </div>
            </div>

            <!-- Item 4: Ruang Ujian -->
            <a href="{{ url('siswa/ruang-ujian') }}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('siswa/ruang-ujian*') ? 'bg-gradient-to-r from-pink-500/10 to-purple-500/10 text-pink-600 dark:text-pink-400 border border-pink-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('siswa/ruang-ujian*') ? 'bg-pink-500 text-white shadow-md shadow-pink-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-pink-500/10 group-hover:text-pink-500' }}">
                    <i class="fa-solid fa-file-pen text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Ruang Ujian</span>
            </a>

            <!-- Item 5: Leaderboard -->
            <a href="{{ url('siswa/leaderboard') }}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('siswa/leaderboard*') ? 'bg-gradient-to-r from-pink-500/10 to-purple-500/10 text-pink-600 dark:text-pink-400 border border-pink-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('siswa/leaderboard*') ? 'bg-pink-500 text-white shadow-md shadow-pink-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-pink-500/10 group-hover:text-pink-500' }}">
                    <i class="fa-solid fa-trophy text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Leaderboard</span>
            </a>
        </nav>
    </div>

    <!-- Bagian Bawah: Card Banner Modern -->
    <div class="p-3 sm:p-3.5 border-t border-gray-100 dark:border-pink-950/20 shrink-0 bg-white/80 dark:bg-cyberdark-900/80 backdrop-blur-sm">
        <div class="sidebar-text relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-2xl p-3.5 sm:p-4 text-white shadow-lg shadow-indigo-500/15 group">
            
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-16 h-16 bg-pink-400/20 rounded-full blur-lg pointer-events-none"></div>
            
            <div class="relative z-10 space-y-2.5 sm:space-y-3">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 bg-white/20 backdrop-blur-md rounded-full text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wider text-purple-100 border border-white/10">
                        Deep Learning
                    </span>
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-amber-300 text-[10px] sm:text-xs shadow-inner shrink-0">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                </div>

                <div>
                    <h4 class="text-[11px] sm:text-xs font-black tracking-tight leading-snug">
                        Belajar Lebih Dalam & Bermakna ✨
                    </h4>
                    <p class="text-[9px] sm:text-[10px] text-purple-100/85 leading-relaxed mt-1 line-clamp-3 sm:line-clamp-none">
                        Pengalaman belajar yang <span class="font-bold text-white">berkesadaran</span>, <span class="font-bold text-white">bermakna</span>, dan <span class="font-bold text-amber-200">menggembirakan</span> bersama LearnDL.
                    </p>
                </div>

                <div class="flex items-center gap-1 pt-0.5">
                    <span class="flex-1 text-center py-0.5 bg-black/20 rounded text-[7px] sm:text-[8px] font-medium text-pink-200 truncate">Mindful</span>
                    <span class="flex-1 text-center py-0.5 bg-black/20 rounded text-[7px] sm:text-[8px] font-medium text-purple-200 truncate">Meaningful</span>
                    <span class="flex-1 text-center py-0.5 bg-black/20 rounded text-[7px] sm:text-[8px] font-medium text-amber-200 truncate">Joyful</span>
                </div>

                <a href="{{ route('siswa.ruang-belajar.eksplorasi') }}" class="w-full flex items-center justify-center space-x-1.5 py-1.5 sm:py-2 bg-white hover:bg-pink-50 text-indigo-950 rounded-xl text-[9px] sm:text-[10px] font-extrabold tracking-wider uppercase shadow-md transition-all active:scale-95 group/btn cursor-pointer">
                    <span>Mulai Petualangan</span>
                    <i class="fa-solid fa-arrow-right text-[8px] sm:text-[9px] group-hover/btn:translate-x-0.5 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

</aside>