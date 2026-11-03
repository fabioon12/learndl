<div class="bg-white dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-4 sm:p-6 md:p-8 shadow-sm space-y-6 relative overflow-hidden">
    
    <!-- 1. Header Peta & Action Button Utama (Responsif) -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-gray-100 dark:border-pink-950/20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center text-sm shadow-md shadow-indigo-500/20 shrink-0">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-gray-900 dark:text-white tracking-tight">Peta Petualangan Pembelajaran</h3>
                <p class="text-[11px] text-gray-400">Kelola tahapan materi dan pantau progres siswa</p>
            </div>
        </div>

        <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
            <!-- Legend Indikator Status (Sembunyi di Layar Kecil, Tampil di Tablet/Desktop) -->
            <div class="hidden sm:flex items-center gap-2.5 text-[10px] font-extrabold text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-cyberdark-800/60 px-3 py-2 rounded-2xl border border-gray-100 dark:border-pink-950/20">
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Selesai</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span> Aktif</span>
                <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span> Terkunci</span>
            </div>

            <!-- Tombol Tambah Tahapan Baru -->
            <a href="{{ route('guru.ruang-belajar.tahapan.create', $ruangBelajar->id) }}"
               class="w-full sm:w-auto px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-2xl text-xs font-extrabold transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20 active:scale-95 cursor-pointer shrink-0">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Tambah Tahapan</span>
            </a>
        </div>
    </div>

    <!-- 2. Mobile Legend Indicator (Tampil Hanya di Layar HP) -->
    <div class="flex sm:hidden items-center justify-around gap-2 text-[10px] font-extrabold text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-cyberdark-800/60 px-3 py-2 rounded-2xl border border-gray-100 dark:border-pink-950/20">
        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Selesai</span>
        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-blue-500"></span> Aktif</span>
        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-gray-400"></span> Terkunci</span>
    </div>

    <!-- 3. Container Map Island with Connected Path Grid -->
    <div class="relative py-4 px-1">
        
        <!-- SVG Curved Connector Line (Disembunyikan di Mobile, Tampil di Layar XL) -->
        <svg class="hidden xl:block absolute inset-0 w-full h-full pointer-events-none stroke-indigo-300 dark:stroke-indigo-900/60" 
             fill="none" 
             stroke-width="4" 
             stroke-dasharray="8 8" 
             stroke-linecap="round">
            <!-- Baris 1: Node 1 -> Node 4 -->
            <path d="M 100 130 L 260 130 L 420 130 L 580 130" />
            <!-- Belokan Jalur Kanan -->
            <path d="M 580 130 C 720 130, 720 340, 580 340" />
            <!-- Baris 2: Node 4 -> Node 8 -->
            <path d="M 580 340 L 420 340 L 260 340 L 100 340" />
        </svg>

        <!-- Responsive Adaptive Grid: 1 Col (Mobile), 2 Cols (Tablet), 4 Cols (Desktop/Laptop) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 relative z-10">
            
            @forelse($tahapans as $tahapan)
                <!-- CARD TAHAPAN DINAMIS -->
                <div class="bg-white dark:bg-cyberdark-800/90 border {{ $tahapan->status == 'aktif' ? 'border-2 border-blue-500 dark:border-blue-500/60' : 'border-gray-100 dark:border-pink-950/30' }} rounded-3xl p-4 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-3 group relative {{ $tahapan->status == 'terkunci' ? 'opacity-70' : '' }}">
                    
                    <!-- Header Card Node (Urutan & Badge Status Dinamis) -->
                    <div class="flex items-center justify-between">
                        <span class="w-7 h-7 rounded-xl font-extrabold text-xs flex items-center justify-center
                            {{ $tahapan->status == 'selesai' ? 'bg-emerald-500/10 text-emerald-500' : '' }}
                            {{ $tahapan->status == 'aktif' ? 'bg-blue-500/10 text-blue-500' : '' }}
                            {{ $tahapan->status == 'terkunci' ? 'bg-gray-100 dark:bg-cyberdark-900 text-gray-400' : '' }}">
                            {{ $tahapan->urutan }}
                        </span>

                        <!-- Badge Status Dinamis -->
                        @if($tahapan->status == 'selesai')
                            <span class="text-[9px] font-black text-emerald-500 bg-emerald-500/10 px-2.5 py-1 rounded-full flex items-center gap-1">
                                <i class="fa-solid fa-circle-check"></i> Selesai
                            </span>
                        @elseif($tahapan->status == 'aktif')
                            <span class="text-[9px] font-black text-blue-600 bg-blue-500/10 px-2.5 py-1 rounded-full animate-pulse flex items-center gap-1">
                                <i class="fa-solid fa-spinner animate-spin"></i> Sedang Aktif
                            </span>
                        @else
                            <span class="text-[9px] font-bold text-gray-400 bg-gray-100 dark:bg-cyberdark-900 px-2.5 py-1 rounded-full flex items-center gap-1">
                                <i class="fa-solid fa-lock"></i> Terkunci
                            </span>
                        @endif
                    </div>

                    <!-- Visual Floating Island / Ikon Dinamis -->
                    @php
                        $icon = $tahapan->icon ?? 'fa-code';

                        // Pemetaan warna background soft & teks ikon sesuai preset
                        $iconStyles = [
                            'fa-flag'   => 'bg-pink-500/10 text-pink-500 shadow-pink-500/10 border-pink-500/20',
                            'fa-star'   => 'bg-amber-500/10 text-amber-500 shadow-amber-500/10 border-amber-500/20',
                            'fa-gift'   => 'bg-purple-500/10 text-purple-500 shadow-purple-500/10 border-purple-500/20',
                            'fa-trophy' => 'bg-emerald-500/10 text-emerald-500 shadow-emerald-500/10 border-emerald-500/20',
                        ];

                        // Default warna indigo jika menggunakan ikon kustom lain
                        $style = $iconStyles[$icon] ?? 'bg-indigo-500/10 text-indigo-500 shadow-indigo-500/10 border-indigo-500/20';
                    @endphp

                    <!-- Visual Floating Island / Ikon Dinamis -->
                    <div class="flex flex-col items-center py-2">
                        <!-- Container Utama Ikon dengan Warna Sesuai Preset & Ring Highlight untuk Status Aktif -->
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl border shadow-lg group-hover:scale-110 transition duration-300 {{ $tahapan->status == 'terkunci' ? 'bg-gray-100 dark:bg-cyberdark-900 text-gray-400 border-gray-200 dark:border-pink-950/20' : $style }} {{ $tahapan->status == 'aktif' ? 'ring-4 ring-blue-500/30' : '' }}">
                            <i class="{{ Str::startsWith($icon, 'fa-') ? 'fa-solid ' . $icon : 'fa-solid fa-code' }}"></i>
                        </div>

                        <!-- Judul Tahapan dari DB -->
                        <h4 class="text-xs font-black text-gray-900 dark:text-white mt-3 text-center line-clamp-1" title="{{ $tahapan->judul_tahapan }}">
                            {{ $tahapan->urutan }}. {{ $tahapan->judul_tahapan }}
                        </h4>

                        <!-- Jumlah Sub-Aktivitas & Bonus XP -->
                        <div class="flex items-center gap-2 mt-0.5">
                            <p class="text-[10px] text-gray-400">
                                0 Sub Aktivitas
                            </p>
                            <span class="text-[9px] font-black text-amber-500 bg-amber-500/10 px-1.5 py-0.2 rounded-md">
                                +{{ $tahapan->xp_reward ?? 100 }} XP
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons Guru -->
                    <div class="pt-2 border-t border-gray-100 dark:border-pink-950/20 grid grid-cols-2 gap-1.5">
                        <!-- 1. Edit Tahapan -->
                        <a href="{{ route('guru.ruang-belajar.tahapan.edit', [$ruangBelajar->id, $tahapan->id]) }}" 
                        class="p-2 bg-gray-50 dark:bg-cyberdark-900 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 text-gray-500 hover:text-indigo-600 rounded-xl text-center text-xs transition" 
                        title="Edit Tahapan">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <!-- 2. Lihat Siswa Join & Progress -->
                        <a href="#" 
                        class="p-2 bg-gray-50 dark:bg-cyberdark-900 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 text-gray-500 hover:text-emerald-600 rounded-xl text-center text-xs transition relative cursor-pointer group" 
                        title="Lihat Detail & Progres Siswa">
                            
                            <!-- Icon diubah menjadi mata (show) -->
                            <i class="fa-solid fa-eye"></i>

                            <!-- Total Progress -->
                        </a>

                        <!-- 3. Tambah Sub-Isi / Aktivitas Materi -->
                        <a href="{{ route('guru.ruang-belajar.tahapan.konten.edit', [
                            'ruang_belajar' => $ruangBelajar->id,
                            'tahapan' => $tahapan->id
                        ]) }}"
                        class="p-2 bg-gray-50 dark:bg-cyberdark-900 hover:bg-purple-50 dark:hover:bg-purple-950/50 text-gray-500 hover:text-purple-600 rounded-xl text-center text-xs transition cursor-pointer"
                        title="Tambah / Atur Isi Aktivitas">

                            <i class="fa-solid fa-plus-circle"></i>
                        </a>

                        <!-- 4. Hapus Tahapan -->
                        <form action="{{ route('guru.ruang-belajar.tahapan.destroy', [$ruangBelajar->id ?? $ruang_belajar_id, $tahapan->id]) }}" 
                              method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahapan ini?');" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full p-2 bg-gray-50 dark:bg-cyberdark-900 hover:bg-rose-50 dark:hover:bg-rose-950/50 text-gray-500 hover:text-rose-600 rounded-xl text-center text-xs transition cursor-pointer" 
                                    title="Hapus Tahapan">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <!-- Tampilan Kosong Jika Belum Ada Tahapan -->
                <div class="col-span-full py-12 text-center space-y-3 bg-gray-50/50 dark:bg-cyberdark-800/30 rounded-3xl border border-dashed border-gray-200 dark:border-pink-950/30">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xl mx-auto">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400">Belum ada tahapan pembelajaran yang dibuat.</p>
                    <a href="{{ route('guru.ruang-belajar.tahapan.create', $ruangBelajar->id) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition">
                        <i class="fa-solid fa-plus"></i>
                        <span>Buat Tahapan Pertama</span>
                    </a>
                </div>
            @endforelse
        </div>

    </div>

</div>