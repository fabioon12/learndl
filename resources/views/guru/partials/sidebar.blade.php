<aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 w-[270px] xs:w-72 sm:w-64 bg-white/90 dark:bg-cyberdark-900/90 backdrop-blur-xl border-r border-gray-100 dark:border-pink-950/30 flex flex-col justify-between transition-all duration-300 ease-in-out z-50 lg:z-20 shadow-2xl shadow-gray-200/50 dark:shadow-none h-screen overflow-y-auto max-h-screen">
    
    <!-- Bagian Atas: Logo & Navigasi Utama Guru -->
    <div class="flex-1 min-h-0">
        <!-- Brand Logo Header -->
        <div class="p-4 sm:p-5 flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 h-16 shrink-0">
            <div id="sidebar-logo" class="flex items-center space-x-2.5 sm:space-x-3 min-w-0 pr-2">
                <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-tr from-indigo-600 via-purple-600 to-pink-500 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/20 shrink-0">
                    <i class="fa-solid fa-brain text-base sm:text-lg animate-pulse"></i>
                </div>
                <div class="sidebar-text min-w-0 flex-1">
                    <span class="font-extrabold text-base sm:text-lg tracking-tight bg-gradient-to-r from-indigo-600 via-purple-500 to-pink-500 bg-clip-text text-transparent dark:from-indigo-400 dark:via-purple-400 dark:to-pink-400 block leading-none truncate">
                        LearnDL
                    </span>
                    <p class="text-[8px] font-bold tracking-tight text-gray-400 dark:text-pink-400/70 mt-1 leading-tight truncate">
                        Portal Pendidik & Pengajar
                    </p>
                </div>
            </div>

            <!-- Tombol Close Sidebar (Khusus Mobile) -->
            <button id="close-sidebar-btn" onclick="document.getElementById('sidebar').classList.add('-translate-x-full')" class="lg:hidden p-1.5 text-gray-400 hover:text-pink-500 rounded-xl hover:bg-gray-100 dark:hover:bg-cyberdark-800 transition cursor-pointer shrink-0">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Navigation Links Guru -->
        <nav class="p-3 sm:p-3.5 space-y-1 sm:space-y-1.5 overflow-y-auto">
            <!-- Item 1: Dashboard -->
            <a href="{{ url('guru/dashboard') }}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('guru/dashboard*') ? 'bg-gradient-to-r from-indigo-500/10 to-purple-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('guru/dashboard*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-indigo-500/10 group-hover:text-indigo-500' }}">
                    <i class="fa-solid fa-chart-pie text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Dashboard</span>
            </a>

            <!-- Item 2: Ruang Belajar (Dropdown) -->
            <div x-data="{ openRuangBelajar: {{ request()->routeIs('guru.ruang-belajar*') || request()->is('guru/ruang-belajar*') ? 'true' : 'false' }} }" class="space-y-1">
                
                <!-- Main Dropdown Trigger Button -->
                <button @click="openRuangBelajar = !openRuangBelajar" 
                        class="w-full flex items-center justify-between px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group cursor-pointer {{ request()->is('guru/ruang-belajar*') ? 'bg-gradient-to-r from-indigo-500/10 to-purple-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                    <div class="flex items-center space-x-3 min-w-0">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('guru/ruang-belajar*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-indigo-500/10 group-hover:text-indigo-500' }}">
                            <i class="fa-solid fa-graduation-cap text-xs sm:text-sm"></i>
                        </div>
                        <span class="sidebar-text text-xs tracking-wide truncate">Ruang Belajar</span>
                    </div>
                    <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200" 
                    :class="openRuangBelajar ? 'rotate-180 text-indigo-500' : 'text-gray-400'"></i>
                </button>

                <!-- Sub-Menu Dropdown Items -->
                <div x-show="openRuangBelajar" 
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="pl-10 pr-2 space-y-1 pt-1" 
                    style="display: none;">
                    
                    <!-- Sub-item 1: Dashboard Belajar (route: guru.ruang-belajar.index) -->
                    <a href="{{ route('guru.ruang-belajar.index') }}" 
                    class="flex items-center space-x-2.5 px-3 py-1.5 rounded-xl text-[11px] transition-all duration-200 {{ request()->routeIs('guru.ruang-belajar.index') ? 'text-indigo-600 dark:text-indigo-400 font-bold bg-indigo-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-pink-300 font-medium' }}">
                        <i class="fa-solid fa-circle text-[5px] {{ request()->routeIs('guru.ruang-belajar.index') ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600' }}"></i>
                        <span class="truncate">Dashboard Ruang Belajar</span>
                    </a>

                    <!-- Sub-item 2: Eksplorasi Materi Belajar (route: guru.ruang-belajar.eksplorasi) -->
<!--                     <a href="{{ route('guru.ruang-belajar.eksplorasi') }}" 
                    class="flex items-center space-x-2.5 px-3 py-1.5 rounded-xl text-[11px] transition-all duration-200 {{ request()->routeIs('guru.ruang-belajar.eksplorasi') ? 'text-indigo-600 dark:text-indigo-400 font-bold bg-indigo-500/10' : 'text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-pink-300 font-medium' }}">
                        <i class="fa-solid fa-circle text-[5px] {{ request()->routeIs('guru.ruang-belajar.eksplorasi') ? 'text-indigo-500' : 'text-gray-300 dark:text-gray-600' }}"></i>
                        <span class="truncate">Eksplorasi Materi Belajar</span>
                    </a> -->
                </div>

            </div>

            <!-- Item 3: Bank Materi / Modul -->
            <a href="{{route('guru.materi.index')}}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('guru/materi*') ? 'bg-gradient-to-r from-indigo-500/10 to-purple-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('guru/materi*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-indigo-500/10 group-hover:text-indigo-500' }}">
                    <i class="fa-solid fa-book-bookmark text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Materi & Modul</span>
            </a>

            <!-- Item 4: Bank Soal & Kuis -->
            <a href="{{ route('guru.ruang-ujian.index') }}"
            class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('guru/ruang-ujian*') ? 'bg-gradient-to-r from-indigo-500/10 to-purple-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-pink-300 font-semibold' }}">

                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('guru/ruang-ujian*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-indigo-500/10 group-hover:text-indigo-500' }}">
                    <i class="fa-solid fa-file-signature text-xs sm:text-sm"></i>
                </div>

                <span class="sidebar-text text-xs tracking-wide truncate">Ruang Ujian</span>
            </a>
            <!-- Item 5: Penilaian & Tugas -->

            <a href="{{ route('guru.leaderboard.index') }}"
            class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group
            {{ request()->routeIs('guru.leaderboard.*')
                ? 'bg-gradient-to-r from-amber-500/10 to-purple-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 font-bold shadow-sm'
                : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 hover:text-gray-900 dark:hover:text-amber-300 font-semibold' }}">

                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0
                    {{ request()->routeIs('guru.leaderboard.*')
                        ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-md shadow-amber-500/30'
                        : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-amber-500/10 group-hover:text-amber-500' }}">

                    <i class="fa-solid fa-trophy text-xs sm:text-sm"></i>

                </div>

                <span class="sidebar-text text-xs tracking-wide truncate">
                    Leaderboard
                </span>

            </a>

        </nav>
    </div>

    <!-- Bagian Bawah: Card Info / Pengingat Pendidik -->
    <div class="p-3 sm:p-3.5 border-t border-gray-100 dark:border-pink-950/20 shrink-0">
        <div class="sidebar-text relative overflow-hidden bg-gradient-to-br from-indigo-700 via-purple-700 to-pink-600 rounded-2xl p-3.5 sm:p-4 text-white shadow-lg shadow-indigo-500/15 group">
            
            <!-- Ornamen Glow Background -->
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-16 h-16 bg-pink-400/20 rounded-full blur-lg pointer-events-none"></div>
            
            <div class="relative z-10 space-y-2.5 sm:space-y-3">
                <div class="flex items-center justify-between">
                    <span class="px-2 py-0.5 bg-white/20 backdrop-blur-md rounded-full text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wider text-indigo-100 border border-white/10">
                        Pendidik DL
                    </span>
                    <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-amber-300 text-[10px] sm:text-xs shadow-inner shrink-0">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                </div>

                <div>
                    <h4 class="text-[11px] sm:text-xs font-black tracking-tight leading-snug">
                        Ruang Mengajar Interaktif 💡
                    </h4>
                    <p class="text-[9px] sm:text-[10px] text-indigo-100/90 leading-relaxed mt-1 line-clamp-3 sm:line-clamp-none">
                        Kelola pembelajaran berkesadaran dan pantau perkembangan siswa secara real-time.
                    </p>
                </div>

                <a href="#" class="w-full flex items-center justify-center space-x-1.5 py-1.5 sm:py-2 bg-white hover:bg-pink-50 text-indigo-950 rounded-xl text-[9px] sm:text-[10px] font-extrabold tracking-wider uppercase shadow-md transition-all active:scale-95 group/btn cursor-pointer">
                    <i class="fa-solid fa-plus text-[8px] sm:text-[9px] text-indigo-600"></i>
                    <span>Tambah Materi</span>
                </a>
            </div>
        </div>
    </div>

</aside>