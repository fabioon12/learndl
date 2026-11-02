<!-- Backdrop Overlay Mobile (Efek Blur & Menghalangi Klik saat Sidebar Buka) -->
<div id="sidebarOverlay" 
     class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 hidden transition-opacity duration-300 md:hidden cursor-pointer">
</div>

<!-- Sidebar Main Container -->
<aside id="sidebar" 
       class="w-64 bg-white border-r border-slate-200/80 flex-shrink-0 transition-all duration-300 fixed md:sticky top-0 h-screen overflow-y-auto flex flex-col justify-between p-4 font-sans z-40 -translate-x-full md:translate-x-0">
    
    <div>
        <!-- Logo & Subtitle (Warna Hijau Emerald) -->
        <div class="flex items-center space-x-3 px-2 py-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-tr from-emerald-600 to-teal-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-emerald-200">
                <i class="fa-solid fa-book-open text-lg"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-900 leading-tight">LearnDL</h1>
                <p class="text-xs text-slate-400 font-medium">Portal Administrator</p>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <nav class="space-y-2 text-sm font-medium">
            <!-- Dashboard -->
            <a href="{{ url('admin/dashboard') }}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('admin/dashboard*') ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-emerald-50/60 dark:hover:bg-cyberdark-800/80 hover:text-emerald-600 dark:hover:text-emerald-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('admin/dashboard*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-emerald-500/10 group-hover:text-emerald-600' }}">
                    <i class="fa-solid fa-chart-pie text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Dashboard</span>
            </a>

            <!-- Manajemen Pengguna -->
            <a href="{{ url('admin/manajemen-pengguna') }}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('admin/manajemen-pengguna*') ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-emerald-50/60 dark:hover:bg-cyberdark-800/80 hover:text-emerald-600 dark:hover:text-emerald-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('admin/manajemen-pengguna*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-emerald-500/10 group-hover:text-emerald-600' }}">
                    <i class="fa-solid fa-users text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Manajemen Pengguna</span>
            </a>

            <!-- Ruang Belajar -->
            <a href="{{ route('admin.ruang-belajar.index') }}" 
            class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.ruang-belajar*') ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-emerald-50/60 dark:hover:bg-cyberdark-800/80 hover:text-emerald-600 dark:hover:text-emerald-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->routeIs('admin.ruang-belajar*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-emerald-500/10 group-hover:text-emerald-600' }}">
                    <i class="fa-solid fa-book text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Ruang Belajar</span>
            </a>

            <!-- Materi & Modul -->
            <a href="#" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->is('#') ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-emerald-50/60 dark:hover:bg-cyberdark-800/80 hover:text-emerald-600 dark:hover:text-emerald-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->is('#') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-emerald-500/10 group-hover:text-emerald-600' }}">
                    <i class="fa-solid fa-file-lines text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Materi & Modul</span>
            </a>

            <!-- Laporan & Analitik -->
            <a href="{{ route('admin.laporan-statistik') }}" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.laporan-statistik*') ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-emerald-50/60 dark:hover:bg-cyberdark-800/80 hover:text-emerald-600 dark:hover:text-emerald-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->routeIs('admin.laporan-statistik*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-emerald-500/10 group-hover:text-emerald-600' }}">
                    <i class="fa-solid fa-chart-column text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Laporan & Analitik</span>
            </a>

            <!-- Leaderboard Siswa -->
            <a href="#" 
               class="flex items-center space-x-3 px-3 sm:px-3.5 py-2 sm:py-2.5 rounded-2xl transition-all duration-200 group {{ request()->routeIs('admin.leaderboard*') ? 'bg-gradient-to-r from-emerald-500/10 to-teal-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-bold shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:bg-emerald-50/60 dark:hover:bg-cyberdark-800/80 hover:text-emerald-600 dark:hover:text-emerald-300 font-semibold' }}">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl flex items-center justify-center transition-colors shrink-0 {{ request()->routeIs('admin.leaderboard*') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-500/30' : 'bg-gray-100 dark:bg-cyberdark-800 group-hover:bg-emerald-500/10 group-hover:text-emerald-600' }}">
                    <i class="fa-solid fa-trophy text-xs sm:text-sm"></i>
                </div>
                <span class="sidebar-text text-xs tracking-wide truncate">Leaderboard Siswa</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Administrator Card Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-500 p-4 text-white shadow-md shadow-emerald-500/10 mt-6">
        <div class="relative z-10 space-y-2">
            <div class="flex items-center space-x-2">
                <div class="w-7 h-7 rounded-lg bg-white/20 backdrop-blur-md flex items-center justify-center">
                    <i class="fa-solid fa-shield-halved text-xs text-white"></i>
                </div>
                <span class="text-[11px] font-bold tracking-wider uppercase">ADMINISTRATOR</span>
            </div>
            
            <p class="text-xs font-medium text-emerald-50 leading-snug pt-1">
                Kelola platform pembelajaran secara menyeluruh
            </p>

            <div class="flex justify-end pt-2">
                <a href="{{ route('admin.manajemen-pengguna') }}" class="w-7 h-7 rounded-full bg-white/90 text-emerald-600 flex items-center justify-center shadow hover:bg-white transition">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Decorative background shapes -->
        <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-teal-300/30 rounded-full blur-xl pointer-events-none"></div>
    </div>

</aside>

<!-- Script Interactive Toggle (Smooth Blur Overlay Mobile) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarToggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden', 'md:overflow-auto');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden', 'md:overflow-auto');
        }

        if (sidebarToggleBtn && sidebar && overlay) {
            sidebarToggleBtn.addEventListener('click', function () {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            // Klik area luar/blur overlay untuk menutup sidebar
            overlay.addEventListener('click', function () {
                closeSidebar();
            });
        }
    });
</script>