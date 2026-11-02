<header class="bg-white dark:bg-cyberdark-900 border-b border-gray-200 dark:border-pink-950/30 h-16 flex items-center justify-between px-3 md:px-6 sticky top-0 z-30">
    <!-- Sisi Kiri: Toggle Sidebar & Quick Title / Info -->
    <div class="flex items-center space-x-2 md:space-x-4 flex-1 max-w-xl">
        <button id="toggle-sidebar" class="text-gray-500 hover:text-gray-700 dark:text-pink-400 dark:hover:text-pink-300 focus:outline-none p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-cyberdark-800 transition cursor-pointer">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>

        <!-- Badge Status Guru / Portal Info -->
        <div class="hidden sm:flex items-center gap-2 px-3 py-1 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-400">
            <i class="fa-solid fa-chalkboard-user text-xs"></i>
            <span class="text-xs font-bold tracking-wide">Portal Pendidik</span>
        </div>
    </div>

    <!-- Sisi Kanan: Toggle Mode Gelap, Notifikasi, & Profil Guru -->
    <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">

        <!-- Toggle Mode Gelap -->
        <button id="theme-toggle" 
                title="Ubah Mode Tampilan" 
                class="p-2.5 rounded-2xl bg-gray-100 dark:bg-cyberdark-800 hover:bg-gray-200 dark:hover:bg-cyberdark-700/80 text-gray-600 dark:text-pink-400 transition-all duration-200 focus:outline-none cursor-pointer flex items-center justify-center group shrink-0">
            <i id="theme-icon" class="fa-solid fa-moon text-lg group-hover:scale-110 transition-transform"></i>
        </button>

        <!-- Notification Dropdown Wrapper (Alpine.js) -->
        <div x-data="{ openNotif: false, unreadCount: 3 }" class="relative">
            <!-- Tombol Lonceng Notifikasi -->
            <button @click="openNotif = !openNotif" 
                    @click.outside="openNotif = false" 
                    class="text-gray-500 dark:text-pink-400 hover:text-gray-700 dark:hover:text-pink-300 relative p-2.5 rounded-2xl hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 transition-all duration-200 focus:outline-none cursor-pointer group">
                <i class="fa-solid fa-bell text-lg group-hover:scale-110 transition-transform"></i>
                
                <!-- Indikator Badge Unread -->
                <template x-if="unreadCount > 0">
                    <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                    </span>
                </template>
            </button>

            <!-- Menu Dropdown Popover Notifikasi -->
            <div x-show="openNotif" 
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                class="fixed inset-x-3 top-16 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-2.5 w-auto sm:w-96 bg-white/95 dark:bg-cyberdark-900/95 backdrop-blur-md border border-gray-100 dark:border-pink-950/40 rounded-2xl shadow-2xl shadow-indigo-500/10 py-2 z-50 overflow-hidden"
                style="display: none;">
                
                <!-- Header Notifikasi -->
                <div class="px-3.5 sm:px-4 py-2.5 sm:py-3 border-b border-gray-100 dark:border-pink-950/30 flex items-center justify-between gap-2">
                    <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                        <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Notifikasi Guru</h3>
                        <span class="px-2 py-0.5 text-[9px] font-extrabold rounded-full bg-indigo-500/10 text-indigo-500 border border-indigo-500/20 whitespace-nowrap" x-text="`${unreadCount} Baru`"></span>
                    </div>
                    <button @click="unreadCount = 0" class="text-[10px] font-semibold text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors cursor-pointer shrink-0">
                        Tandai semua dibaca
                    </button>
                </div>

                <!-- Daftar Notifikasi Guru -->
                <div class="max-h-[60vh] sm:max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-pink-950/20">
                    <!-- Item Notifikasi 1: Tugas Siswa -->
                    <a href="#" class="flex gap-2.5 sm:gap-3 px-3.5 sm:px-4 py-2.5 sm:py-3 bg-indigo-50/40 dark:bg-indigo-950/10 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 transition-colors group">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-purple-500/10 dark:bg-purple-500/20 text-purple-500 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-file-arrow-up text-[11px] sm:text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <p class="text-xs font-bold text-gray-800 dark:text-gray-100 truncate group-hover:text-indigo-500 transition-colors">Setoran Tugas Baru</p>
                                <span class="text-[9px] text-gray-400 shrink-0">5 mnt lalu</span>
                            </div>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 leading-tight">
                                <span class="font-semibold text-indigo-500">Ahmad Hidayat</span> telah mengumpulkan tugas <span class="font-semibold text-gray-700 dark:text-gray-300">Laravel Blade Component</span>.
                            </p>
                        </div>
                    </a>

                    <!-- Item Notifikasi 2: Ujian / Kuis Selesai -->
                    <a href="#" class="flex gap-2.5 sm:gap-3 px-3.5 sm:px-4 py-2.5 sm:py-3 bg-indigo-50/40 dark:bg-indigo-950/10 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 transition-colors group">
                        <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-500 flex items-center justify-center shrink-0 mt-0.5">
                            <i class="fa-solid fa-square-check text-[11px] sm:text-xs"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-1 mb-0.5">
                                <p class="text-xs font-bold text-gray-800 dark:text-gray-100 truncate group-hover:text-indigo-500 transition-colors">Kuis Berakhir</p>
                                <span class="text-[9px] text-gray-400 shrink-0">1 jam lalu</span>
                            </div>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 leading-tight">
                                Kuis Harian <span class="font-semibold text-gray-700 dark:text-gray-300">XI RPL 1</span> telah selesai, 32 siswa telah berpartisipasi.
                            </p>
                        </div>
                    </a>
                </div>

                <!-- Footer Dropdown -->
                <div class="p-2 border-t border-gray-100 dark:border-pink-950/30 text-center bg-gray-50/50 dark:bg-cyberdark-950/40">
                    <a href="#" class="text-[11px] font-bold text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors block py-1">
                        Lihat Semua Aktivitas
                    </a>
                </div>
            </div>
        </div>

        <!-- Dropdown Profil Guru (Alpine.js) -->
        <div x-data="{ open: false }" class="relative">
            <!-- Trigger Button -->
            <button @click="open = !open" 
                    @click.outside="open = false" 
                    class="flex items-center gap-2 sm:gap-3 p-1.5 rounded-2xl hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 transition-all duration-200 focus:outline-none cursor-pointer group">
                
                <!-- Avatar Wrapper Guru -->
                <div class="relative shrink-0">
                    <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed={{ urlencode(auth()->user()->fullname ?? 'Guru') }}&backgroundColor=c0aede" 
                        alt="Avatar Guru" 
                        class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl border border-indigo-500/30 object-cover shadow-sm group-hover:scale-105 transition-transform duration-200">
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-cyberdark-900 rounded-full"></span>
                </div>
                
                <!-- Nama & Instansi Sekolah -->
                <div class="text-left hidden md:block">
                    <div class="flex items-center gap-2">
                        <p class="font-bold text-xs text-gray-800 dark:text-gray-100 truncate max-w-[130px] leading-tight group-hover:text-indigo-500 transition-colors">
                            {{ auth()->user()->fullname ?? 'Bapak/Ibu Guru' }}
                        </p>
                    </div>
                    <p class="text-[10px] font-medium text-gray-500 dark:text-indigo-400/70 truncate max-w-[130px] mt-0.5">
                        {{ auth()->user()->school_name ?? 'SMK Negeri' }}
                    </p>
                </div>

                <!-- Arrow Icon -->
                <i class="fa-solid fa-chevron-down text-[11px] text-gray-400 dark:text-gray-500 transition-transform duration-200 group-hover:text-indigo-500" 
                   :class="open ? 'rotate-180 text-indigo-500' : ''"></i>
            </button>

            <!-- Menu Dropdown Floating Card -->
            <div x-show="open" 
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                class="absolute right-0 mt-2.5 w-60 bg-white/95 dark:bg-cyberdark-900/95 backdrop-blur-md border border-gray-100 dark:border-pink-950/40 rounded-2xl shadow-2xl shadow-indigo-500/5 py-2 z-50 divide-y divide-gray-100 dark:divide-pink-950/30"
                style="display: none;">
                
                <!-- Header Info User Guru -->
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-xs font-bold text-gray-900 dark:text-white truncate">
                            {{ auth()->user()->fullname ?? 'Pengajar' }}
                        </p>
                        <!-- Badge Role Guru -->
                        <span class="px-2 py-0.5 text-[9px] font-extrabold tracking-wider uppercase rounded-full bg-gradient-to-r from-indigo-500/10 to-purple-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 shrink-0">
                            {{ auth()->user()->role ?? 'Guru' }}
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate mt-0.5">
                        {{ auth()->user()->major_or_subject ?? 'Mata Pelajaran' }}
                    </p>
                </div>

                <!-- Action Links Guru -->
                <div class="py-1.5 space-y-0.5">
                    <a href="{{ route('guru.profil') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all group">
                        <div class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-cyberdark-800 flex items-center justify-center text-gray-500 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-user-gear text-xs"></i>
                        </div>
                        <span>Profil Pengajar</span>
                    </a>
                </div>

                <!-- Logout Action -->
                <div class="pt-1.5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-xs font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition-all group cursor-pointer">
                            <div class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-950/20 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-colors">
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            </div>
                            <span>Keluar Akun</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</header>