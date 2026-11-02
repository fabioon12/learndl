<header class="bg-white dark:bg-cyberdark-900 border-b border-gray-200 dark:border-pink-950/30 h-16 flex items-center justify-between px-3 md:px-6 sticky top-0 z-30">
    <!-- Sisi Kiri: Toggle Sidebar & Greeting / Search -->
    <div class="flex items-center space-x-2 md:space-x-4 flex-1 max-w-xl">
        <button id="toggle-sidebar" class="text-gray-500 hover:text-gray-700 dark:text-pink-400 dark:hover:text-pink-300 focus:outline-none p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-cyberdark-800 transition">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>

        <!-- Widget Mood/Suasana Hati (Interactive Alpine.js) -->
         @include('siswa.partials.suasana-hati')
    </div>

    <!-- Sisi Kanan: Status AI, Level & EXP, Notifikasi, & Profil -->
    <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">

        <!-- Badge Level & Progress Bar EXP -->
        @include('siswa.partials.level')

        <!-- Toggle Mode Gelap -->
        <button id="theme-toggle" 
                title="Ubah Mode Tampilan" 
                class="p-2.5 rounded-2xl bg-gray-100 dark:bg-cyberdark-800 hover:bg-gray-200 dark:hover:bg-cyberdark-700/80 text-gray-600 dark:text-pink-400 transition-all duration-200 focus:outline-none cursor-pointer flex items-center justify-center group shrink-0">
            <i id="theme-icon" class="fa-solid fa-moon text-lg group-hover:scale-110 transition-transform"></i>
        </button>

        <!-- Tombol Lonceng Notifikasi -->
        @include('siswa.partials.notification')

        <!-- Dropdown Profil Siswa (Alpine.js) -->
        <div x-data="{ open: false }" class="relative">
            <!-- Trigger Button -->
            <button @click="open = !open" 
                    @click.outside="open = false" 
                    class="flex items-center gap-2 sm:gap-3 p-1.5 rounded-2xl hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 transition-all duration-200 focus:outline-none cursor-pointer group">
                
                <!-- Avatar Wrapper -->
                <div class="relative shrink-0">
                    <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed={{ urlencode(auth()->user()->fullname ?? 'Siswa') }}&backgroundColor=b6e3f4" 
                        alt="Avatar" 
                        class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl border border-pink-500/30 object-cover shadow-sm group-hover:scale-105 transition-transform duration-200">
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-cyberdark-900 rounded-full"></span>
                </div>
                
                <!-- Nama & Sekolah -->
                <div class="text-left hidden md:block">
                    <div class="flex items-center gap-2">
                        <p class="font-bold text-xs text-gray-800 dark:text-gray-100 truncate max-w-[120px] leading-tight group-hover:text-pink-500 transition-colors">
                            {{ auth()->user()->fullname ?? 'Nama Siswa' }}
                        </p>
                    </div>
                    <p class="text-[10px] font-medium text-gray-500 dark:text-pink-400/70 truncate max-w-[130px] mt-0.5">
                        {{ auth()->user()->school_name ?? 'Siswa' }}
                    </p>
                </div>

                <!-- Arrow Icon -->
                <i class="fa-solid fa-chevron-down text-[11px] text-gray-400 dark:text-gray-500 transition-transform duration-200 group-hover:text-pink-500" 
                   :class="open ? 'rotate-180 text-pink-500' : ''"></i>
            </button>

            <!-- Menu Dropdown Floating Card -->
            <div x-show="open" 
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                class="absolute right-0 mt-2.5 w-60 bg-white/95 dark:bg-cyberdark-900/95 backdrop-blur-md border border-gray-100 dark:border-pink-950/40 rounded-2xl shadow-2xl shadow-pink-500/5 py-2 z-50 divide-y divide-gray-100 dark:divide-pink-950/30"
                style="display: none;">
                
                <!-- Header Info User -->
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-xs font-bold text-gray-900 dark:text-white truncate">
                            {{ auth()->user()->fullname }}
                        </p>
                        <!-- Badge Role Capsule -->
                        <span class="px-2 py-0.5 text-[9px] font-extrabold tracking-wider uppercase rounded-full bg-gradient-to-r from-pink-500/10 to-purple-500/10 dark:from-pink-500/20 dark:to-purple-500/20 text-pink-600 dark:text-pink-400 border border-pink-500/20 shrink-0">
                            {{ auth()->user()->role ?? 'Siswa' }}
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate mt-0.5">
                        {{ auth()->user()->school_name ?? 'Siswa' }}
                    </p>
                </div>

                <!-- Action Links -->
                <div class="py-1.5 space-y-0.5">
                    <a href="{{ route('siswa.profil') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-pink-50 dark:hover:bg-pink-950/30 hover:text-pink-600 dark:hover:text-pink-400 transition-all group">
                        <div class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-cyberdark-800 flex items-center justify-center text-gray-500 group-hover:bg-pink-500 group-hover:text-white transition-colors">
                            <i class="fa-solid fa-user-gear text-xs"></i>
                        </div>
                        <span>Profil Saya</span>
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