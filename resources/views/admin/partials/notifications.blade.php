<!-- Notification Dropdown Wrapper (Alpine.js - Vibrant & Readable Theme) -->
<div x-data="{ openNotif: false, unreadCount: 2 }" class="relative">
    
    <!-- Tombol Lonceng Notifikasi (Netral Abu-abu dengan Hover Glow Cerah) -->
    <button @click="openNotif = !openNotif" 
            @click.outside="openNotif = false" 
            class="text-slate-600 hover:text-indigo-600 relative p-2.5 rounded-2xl hover:bg-slate-100 transition-all duration-200 focus:outline-none cursor-pointer group">
        <i class="fa-solid fa-bell text-lg group-hover:scale-110 transition-transform"></i>
        
        <!-- Indikator Badge Unread (Rose Pink Energetik) -->
        <template x-if="unreadCount > 0">
            <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-rose-500"></span>
            </span>
        </template>
    </button>

    <!-- Menu Dropdown Popover Notifikasi (Responsif & Berwarna-warni) -->
    <div x-show="openNotif" 
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
        x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
        class="fixed inset-x-3 top-16 sm:absolute sm:inset-auto sm:right-0 sm:top-full sm:mt-2.5 w-auto sm:w-96 bg-white border border-slate-200 rounded-3xl shadow-2xl shadow-slate-300/60 py-2 z-50 overflow-hidden"
        style="display: none;">
        
        <!-- Header Notifikasi (Kombinasi Indigo & Purple Badge) -->
        <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between gap-2 bg-gradient-to-r from-slate-50 via-purple-50/30 to-slate-50">
            <div class="flex items-center gap-2 min-w-0">
                <h3 class="text-xs font-black text-slate-800 tracking-wide truncate">Notifikasi</h3>
                <span class="px-2.5 py-0.5 text-[10px] font-black rounded-full bg-rose-100 text-rose-700 border border-rose-200/60 whitespace-nowrap" x-text="`${unreadCount} Baru`"></span>
            </div>
            <button @click="unreadCount = 0" class="text-[11px] font-bold text-indigo-600 hover:text-indigo-800 transition-colors cursor-pointer shrink-0">
                Tandai semua dibaca
            </button>
        </div>

        <!-- Daftar Notifikasi (Berwarna-warni per Kategori) -->
        <div class="max-h-[65vh] sm:max-h-80 overflow-y-auto divide-y divide-slate-100">
            
            <!-- Item Notifikasi 1: Ruang Ujian / Tugas (Aksen Ungu / Purple & Indigo) -->
            <a href="#" class="flex items-start gap-3 px-4 py-3.5 bg-purple-50/40 hover:bg-purple-50/90 transition-colors group">
                <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-md shadow-purple-500/20">
                    <i class="fa-solid fa-file-pen text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <p class="text-xs font-extrabold text-slate-900 truncate group-hover:text-purple-700 transition-colors">Tugas Baru Tersedia</p>
                        <span class="text-[10px] font-semibold text-purple-400 shrink-0">10 mnt lalu</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">
                        Pak Budi menambahkan kuis baru di <span class="font-bold text-purple-700 bg-purple-100/70 px-1.5 py-0.5 rounded-md">Ruang Ujian Web</span>.
                    </p>
                </div>
            </a>

            <!-- Item Notifikasi 2: Materi / Ruang Belajar (Aksen Biru / Cyan & Blue) -->
            <a href="#" class="flex items-start gap-3 px-4 py-3.5 bg-sky-50/40 hover:bg-sky-50/90 transition-colors group">
                <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-500 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-book-open text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <p class="text-xs font-extrabold text-slate-900 truncate group-hover:text-blue-700 transition-colors">Materi Diperbarui</p>
                        <span class="text-[10px] font-semibold text-blue-400 shrink-0">1 jam lalu</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">
                        Modul <span class="font-bold text-blue-800 bg-sky-100/70 px-1.5 py-0.5 rounded-md">Deep Learning & AI</span> telah diunggah.
                    </p>
                </div>
            </a>

            <!-- Item Notifikasi 3: Achievement / Leaderboard (Aksen Kuning / Amber & Orange) -->
            <a href="#" class="flex items-start gap-3 px-4 py-3.5 bg-amber-50/40 hover:bg-amber-50/90 transition-colors group">
                <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-400 text-white flex items-center justify-center shrink-0 mt-0.5 shadow-md shadow-amber-500/20">
                    <i class="fa-solid fa-trophy text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <p class="text-xs font-extrabold text-slate-900 truncate group-hover:text-amber-700 transition-colors">Peringkat Naik!</p>
                        <span class="text-[10px] font-semibold text-amber-500 shrink-0">Kemarin</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-snug">
                        Selamat! Kamu naik ke peringkat <span class="font-bold text-amber-800 bg-amber-100/70 px-1.5 py-0.5 rounded-md">Top 3 Leaderboard</span> minggu ini.
                    </p>
                </div>
            </a>


        </div>

        <!-- Footer Dropdown (Tombol Aksen Soft Indigo) -->
        <div class="p-2 border-t border-slate-100 text-center bg-slate-50/80">
            <a href="#" class="text-xs font-extrabold text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 transition-colors block py-2 rounded-xl">
                Lihat Semua Notifikasi <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
            </a>
        </div>

    </div>
</div>