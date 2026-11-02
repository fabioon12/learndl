<!-- Notification Dropdown Wrapper (Alpine.js) -->
<div x-data="{ openNotif: false, unreadCount: 2 }" class="relative">
    
    <!-- Tombol Lonceng Notifikasi -->
    <button @click="openNotif = !openNotif" 
            @click.outside="openNotif = false" 
            class="text-gray-500 dark:text-pink-400 hover:text-gray-700 dark:hover:text-pink-300 relative p-2.5 rounded-2xl hover:bg-gray-100/80 dark:hover:bg-cyberdark-800/80 transition-all duration-200 focus:outline-none cursor-pointer group">
        <i class="fa-solid fa-bell text-lg group-hover:scale-110 transition-transform"></i>
        
        <!-- Indikator Badge Unread -->
        <template x-if="unreadCount > 0">
            <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pink-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-pink-500"></span>
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
        class="fixed inset-x-3 top-16 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-2.5 w-auto sm:w-96 bg-white/95 dark:bg-cyberdark-900/95 backdrop-blur-md border border-gray-100 dark:border-pink-950/40 rounded-2xl shadow-2xl shadow-pink-500/10 py-2 z-50 overflow-hidden"
        style="display: none;">
        
        <!-- Header Notifikasi -->
        <div class="px-3.5 sm:px-4 py-2.5 sm:py-3 border-b border-gray-100 dark:border-pink-950/30 flex items-center justify-between gap-2">
            <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                <h3 class="text-xs font-bold text-gray-900 dark:text-white truncate">Notifikasi</h3>
                <span class="px-2 py-0.5 text-[9px] font-extrabold rounded-full bg-pink-500/10 text-pink-500 border border-pink-500/20 whitespace-nowrap" x-text="`${unreadCount} Baru`"></span>
            </div>
            <button @click="unreadCount = 0" class="text-[10px] font-semibold text-pink-500 hover:text-pink-600 dark:hover:text-pink-400 transition-colors cursor-pointer shrink-0">
                Tandai semua dibaca
            </button>
        </div>

        <!-- Daftar Notifikasi (List) -->
        <div class="max-h-[60vh] sm:max-h-80 overflow-y-auto divide-y divide-gray-50 dark:divide-pink-950/20">
            
            <!-- Item Notifikasi 1: Tugas / Ruang Ujian -->
            <a href="#" class="flex gap-2.5 sm:gap-3 px-3.5 sm:px-4 py-2.5 sm:py-3 bg-pink-50/40 dark:bg-pink-950/10 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 transition-colors group">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-purple-500/10 dark:bg-purple-500/20 text-purple-500 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-file-pen text-[11px] sm:text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1 mb-0.5">
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-100 truncate group-hover:text-pink-500 transition-colors">Tugas Baru Tersedia</p>
                        <span class="text-[9px] text-gray-400 shrink-0">10 mnt lalu</span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 leading-tight">
                        Pak Budi menambahkan kuis baru di <span class="font-semibold text-pink-500">Ruang Ujian Pemrograman Web</span>.
                    </p>
                </div>
            </a>

            <!-- Item Notifikasi 2: Materi / Ruang Belajar -->
            <a href="#" class="flex gap-2.5 sm:gap-3 px-3.5 sm:px-4 py-2.5 sm:py-3 bg-pink-50/40 dark:bg-pink-950/10 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 transition-colors group">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-500 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-book-open text-[11px] sm:text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1 mb-0.5">
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-100 truncate group-hover:text-pink-500 transition-colors">Materi Diperbarui</p>
                        <span class="text-[9px] text-gray-400 shrink-0">1 jam lalu</span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 leading-tight">
                        Modul <span class="font-semibold text-gray-700 dark:text-gray-300">Deep Learning & AI Integration</span> telah diunggah.
                    </p>
                </div>
            </a>

            <!-- Item Notifikasi 3: Achievement / Leaderboard -->
            <a href="#" class="flex gap-2.5 sm:gap-3 px-3.5 sm:px-4 py-2.5 sm:py-3 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 transition-colors group opacity-80">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-500 flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-trophy text-[11px] sm:text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-1 mb-0.5">
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-100 truncate group-hover:text-pink-500 transition-colors">Peringkat Naik!</p>
                        <span class="text-[9px] text-gray-400 shrink-0">Kemarin</span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 leading-tight">
                        Selamat! Kamu naik ke peringkat <span class="font-semibold text-amber-500">Top 3 Leaderboard</span> minggu ini.
                    </p>
                </div>
            </a>

        </div>

        <!-- Footer Dropdown -->
        <div class="p-2 border-t border-gray-100 dark:border-pink-950/30 text-center bg-gray-50/50 dark:bg-cyberdark-950/40">
            <a href="#" class="text-[11px] font-bold text-pink-500 hover:text-pink-600 dark:hover:text-pink-400 transition-colors block py-1">
                Lihat Semua Notifikasi
            </a>
        </div>

    </div>
</div>