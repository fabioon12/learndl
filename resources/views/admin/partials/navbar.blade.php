<header class="w-full bg-white border-b border-slate-200/80 px-6 py-3.5 flex items-center justify-between font-sans sticky top-0 z-20">
    
    <!-- Sisi Kiri: Tombol Hamburger & Badge (Hijau Emerald) -->
    <div class="flex items-center space-x-5">
        <button id="sidebarToggle" class="text-slate-500 hover:text-emerald-600 transition focus:outline-none p-1 rounded-lg hover:bg-emerald-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="flex items-center space-x-2 bg-emerald-50 border border-emerald-200/60 text-emerald-700 font-medium text-xs px-3.5 py-1.5 rounded-full">
            <i class="fa-solid fa-house text-emerald-600 text-xs"></i>
            <span>Portal Admin</span>
        </div>
    </div>

    <!-- Sisi Kanan: Notifikasi & User -->
    <div class="flex items-center space-x-6" x-data="{ openProfile: false, openNotif: false }">
        @include('admin.partials.notifications')

        <!-- Dropdown Profil User (Inisial Nama Dynamic / Auth User) -->
        <div class="relative">
            <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center space-x-3 text-slate-800 hover:text-emerald-600 transition focus:outline-none group cursor-pointer">
                
                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-bold text-xs flex items-center justify-center shadow-md shadow-emerald-200 group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(auth()->user()->fullname ?? 'Admin Utama', 0, 2)) }}
                </div>

                <div class="hidden sm:flex flex-col text-left">
                    <span class="text-xs font-bold text-slate-800 leading-tight">
                        {{ auth()->user()->fullname ?? 'Admin Utama' }}
                    </span>
                    <span class="text-[10px] font-extrabold text-emerald-600 uppercase tracking-wider mt-0.5">
                        {{ auth()->user()->role ?? 'Administrator' }}
                    </span>
                </div>

                <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': openProfile }"></i>
            </button>

            <!-- Panel Menu Dropdown Profil -->
            <div x-show="openProfile" 
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 p-1.5 z-50" 
                style="display: none;">
                
                <!-- Info Pengguna di dalam Dropdown -->
                <div class="px-3 py-2.5 bg-emerald-50/50 rounded-xl mb-1 border border-emerald-100/60">
                    <p class="text-xs font-bold text-slate-900">{{ auth()->user()->fullname ?? 'Admin Utama' }}</p>
                    <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@learndl.id' }}</p>
                </div>

                <div class="my-1 border-t border-slate-100"></div>

                <!-- Form Logout (Laravel CSRF) -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-2.5 px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50 text-xs font-semibold transition cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket w-4"></i>
                        <span>Keluar / Logout</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</header>