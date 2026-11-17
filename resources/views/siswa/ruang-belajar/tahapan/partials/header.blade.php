<div class="relative overflow-hidden rounded-[2rem] md:rounded-[2.5rem] bg-gradient-to-r from-[#2b4cbe] via-[#3a44c8] to-[#7042ce] p-6 md:p-8 lg:p-10 text-white shadow-2xl shadow-indigo-500/15 border border-white/10 mb-7">
    
    {{-- BACKGROUND ORNAMENTS --}}
    <div class="absolute -right-16 -top-20 w-80 h-80 bg-purple-400/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute right-1/4 -bottom-24 w-72 h-72 bg-indigo-400/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute left-1/3 top-0 w-40 h-40 bg-blue-300/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
        
        <!-- Sisi Kiri: Informasi Ruang Belajar -->
        <div class="flex flex-col items-start space-y-5 max-w-2xl">
            <a href="{{ route('siswa.dashboard') }}"
                class="inline-flex items-center gap-2 text-[10px] md:text-[11px] font-black uppercase tracking-wider text-white/90 hover:text-white bg-white/10 hover:bg-white/20 px-4 py-2.5 rounded-full border border-white/30 backdrop-blur-md transition-all active:scale-95 shadow-sm">
                <i class="fa-solid fa-arrow-left"></i>
                <span>KEMBALI KE DASHBOARD</span>
            </a>

            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] md:text-xs font-extrabold uppercase tracking-[0.2em] text-white/70">
                        RUANG PETUALANGAN BELAJAR
                    </span>
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black tracking-tight text-white drop-shadow-md leading-tight">
                    {{ $ruangBelajar->judul }}
                </h1>
                <p class="text-xs md:text-sm text-white/75 font-medium max-w-lg leading-relaxed">
                    Jelajahi setiap tahapan pembelajaran, kumpulkan XP, dan tingkatkan kemampuanmu melalui pengalaman belajar yang menyenangkan!
                </p>
            </div>

            <!-- Badges Informasi -->
            <div class="flex flex-wrap items-center gap-2.5">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/25 backdrop-blur-md text-[11px] font-extrabold text-white">
                    <i class="fa-solid fa-book-bookmark text-emerald-300"></i>
                    <span>{{ $ruangBelajar->mapel }}</span>
                </div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/25 backdrop-blur-md text-[11px] font-extrabold text-white">
                    <i class="fa-solid fa-graduation-cap text-amber-300"></i>
                    <span>Kelas {{ $ruangBelajar->kelas }}</span>
                </div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/25 backdrop-blur-md text-[11px] font-extrabold text-white">
                    <i class="fa-solid fa-map text-pink-300"></i>
                    <span>{{ $totalTahapan }} Tahapan</span>
                </div>
            </div>
        </div>

        <!-- Sisi Kanan: Elemen Visual 3D & Tombol Aksi -->
        <div class="relative flex flex-col items-center md:items-end justify-center shrink-0 gap-5">
            <div class="relative w-44 h-40 md:w-56 md:h-48 flex items-center justify-center">
                <div class="absolute w-36 h-36 md:w-44 md:h-44 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm"></div>
                <div class="absolute w-28 h-28 md:w-36 md:h-36 rounded-full bg-white/10 border border-white/20"></div>
                
                <div class="relative z-10 flex flex-col items-center justify-center transform hover:-translate-y-2 transition-transform duration-500">
                    <div class="w-24 h-20 md:w-32 md:h-24 rounded-2xl bg-gradient-to-br from-sky-200 to-white border-4 border-white/80 shadow-2xl flex items-center justify-center transform -rotate-6">
                        <div class="w-full h-full m-2 rounded-lg bg-gradient-to-br from-[#172554] to-[#312e81] flex flex-col items-center justify-center gap-2">
                            <i class="fa-solid fa-code text-3xl md:text-4xl text-emerald-300"></i>
                            <div class="flex gap-1">
                                <span class="w-2 h-1 rounded-full bg-pink-400"></span>
                                <span class="w-5 h-1 rounded-full bg-sky-300"></span>
                                <span class="w-3 h-1 rounded-full bg-amber-300"></span>
                            </div>
                        </div>
                    </div>
                    <div class="w-32 md:w-40 h-3 bg-gradient-to-b from-gray-200 to-gray-400 rounded-b-xl shadow-lg -mt-1 transform -rotate-6"></div>
                </div>

                <!-- Floating Ornaments -->
                <div class="absolute top-0 right-3 w-11 h-11 rounded-2xl bg-amber-400 flex items-center justify-center shadow-lg shadow-amber-500/30 rotate-12">
                    <i class="fa-solid fa-bolt text-white text-lg"></i>
                </div>
                <div class="absolute bottom-3 left-2 w-10 h-10 rounded-xl bg-emerald-400 flex items-center justify-center shadow-lg -rotate-12">
                    <i class="fa-solid fa-star text-white"></i>
                </div>
            </div>

            <!-- Tombol Panduan -->
            <button
                type="button"
                onclick="openPanduanBelajar()"
                class="inline-flex items-center gap-2 px-4 py-2.5
                    rounded-xl bg-white/15 hover:bg-white/25
                    border border-white/20 text-white
                    font-semibold text-sm transition-all duration-200"
            >
                <i class="fas fa-book-reader"></i>
                Panduan Belajar
            </button>
        </div>

    </div>
</div>