@extends('guru.layouts.app')

@section('title', 'Ruang Belajar - Kelola Materi')

@section('content')
<div class="space-y-6">

    <!-- 1. Modern Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-6 md:p-8 text-white shadow-xl shadow-indigo-500/10 dark:shadow-pink-950/20">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-1/3 -top-12 w-36 h-36 bg-pink-400/20 rounded-full blur-xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold tracking-wide uppercase border border-white/20">
                    <i class="fa-solid fa-graduation-cap"></i> Ruang Belajar Pendidik
                </div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">
                    Kelola Ruang Belajar 📚
                </h1>
                <p class="text-xs md:text-sm text-purple-100 max-w-xl leading-relaxed">
                    Atur kegiatan pembelajaran untuk memberikan0 prinsip pembelajaran yang lebih berkesadaran, bermakna, dan menggembirakan. 
                </p>
            </div>
            
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('guru.ruang-belajar.create') }}" 
                   class="px-5 py-3 bg-white text-indigo-950 hover:bg-pink-50 rounded-2xl text-xs font-extrabold transition-all duration-200 shadow-md active:scale-95 flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-plus text-pink-500"></i>
                    <span>Tambah Ruang Belajar</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar Area -->
    <div class="bg-white dark:bg-cyberdark-900/90 backdrop-blur-xl p-4 rounded-3xl border border-gray-100 dark:border-pink-950/30 shadow-sm">
        <form action="{{ route('guru.ruang-belajar.index') }}" method="GET" class="flex flex-col md:flex-row items-center justify-between gap-3">
            
            <!-- Input Pencarian Judul Materi -->
            <div class="relative w-full md:w-80">
                <input type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari judul materi..." 
                    class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-gray-50/80 dark:bg-cyberdark-800 border border-gray-200/80 dark:border-pink-950/40 text-xs font-semibold text-gray-800 dark:text-gray-200 focus:outline-none focus:border-indigo-500 transition">
                
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <!-- Tombol Clear Search (jika sedang mencari) -->
                @if(request('search'))
                    <a href="{{ route('guru.ruang-belajar.index', ['kelas' => request('kelas')]) }}" 
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 text-xs" 
                    title="Hapus pencarian">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <!-- Group Action Right: Dropdown Kelas & Button -->
            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                
                <!-- Dropdown Filter Kelas -->
                <div class="relative w-full md:w-48">
                    <select name="kelas" 
                            onchange="this.form.submit()" 
                            class="w-full appearance-none px-4 py-2.5 pr-10 rounded-2xl bg-gray-50/80 dark:bg-cyberdark-800 border border-gray-200/80 dark:border-pink-950/40 text-xs font-bold text-gray-800 dark:text-gray-200 focus:outline-none focus:border-indigo-500 transition cursor-pointer">
                        <option value="">Semua Kelas</option>
                        <option value="X" {{ request('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ request('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ request('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                    
                    <div class="absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-xs">
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>

                <!-- Tombol Submit Search -->
                <button type="submit" 
                        class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl text-xs font-bold transition flex items-center gap-2 shadow-sm shrink-0 cursor-pointer">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span class="hidden sm:inline">Cari</span>
                </button>
                
                <!-- Reset Filter (Muncul jika ada pencarian/filter aktif) -->
                @if(request('search') || request('kelas'))
                    <a href="{{ route('guru.ruang-belajar.index') }}" 
                    class="p-2.5 bg-gray-100 dark:bg-cyberdark-800 hover:bg-rose-50 dark:hover:bg-rose-950/30 text-gray-500 hover:text-rose-500 rounded-2xl text-xs font-bold transition shrink-0" 
                    title="Reset Semua Filter">
                        <i class="fa-solid fa-rotate-right"></i>
                    </a>
                @endif

            </div>

        </form>
    </div>
    <!-- 2. Grid Statistik Utama -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <!-- Stat 1: Total Materi Ditambahkan -->
        <div class="p-4 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm flex items-center gap-3.5 hover:shadow-md transition">
            <div class="w-11 h-11 rounded-2xl bg-indigo-500/10 text-indigo-500 dark:text-indigo-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-book-bookmark"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Total Ruang Belajar</p>
                <h3 class="text-base font-black text-gray-800 dark:text-white mt-0.5">{{ $totalRuangBelajar }} Materi</h3>
            </div>
        </div>

        <!-- Stat 2: Peserta Didik Mengambil Materi -->
        <div class="p-4 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm flex items-center gap-3.5 hover:shadow-md transition">
            <div class="w-11 h-11 rounded-2xl bg-blue-500/10 text-blue-500 dark:text-blue-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Siswa Mengambil Ruang Belajar</p>
                <h3 class="text-base font-black text-gray-800 dark:text-white mt-0.5">0 Siswa</h3>
            </div>
        </div>

        <!-- Stat 3: Rata-rata Penyelesaian Materi (Statistik Tambahan 1) -->
        <div class="p-4 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm flex items-center gap-3.5 hover:shadow-md transition">
            <div class="w-11 h-11 rounded-2xl bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-400 uppercase tracking-wider">Rata-rata Selesai</p>
                <h3 class="text-base font-black text-gray-800 dark:text-white mt-0.5">0.0%</h3>
            </div>
        </div>
    </div>

    <!-- 3. Grid Card Daftar Materi Belajar -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($ruangBelajars as $ruangBelajar)
            <div class="group relative bg-white dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 hover:border-indigo-500/40 dark:hover:border-indigo-500/50 rounded-3xl p-4 sm:p-5 shadow-sm hover:shadow-xl hover:shadow-indigo-500/5 hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between space-y-4 overflow-hidden">
                
                <!-- Glow Effect on Hover -->
                <div class="absolute -right-12 -top-12 w-28 h-28 bg-indigo-500/10 rounded-full blur-2xl group-hover:bg-indigo-500/20 transition-all duration-500 pointer-events-none"></div>

                <div class="space-y-3 relative z-10">
                    
                    <!-- Thumbnail Gambar Materi -->
                    <div class="relative w-full h-36 rounded-2xl overflow-hidden bg-gray-100 dark:bg-cyberdark-800">
                        <img src="{{ $ruangBelajar->thumbnail ? asset('storage/' . $ruangBelajar->thumbnail) : 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?q=80&w=600&auto=format&fit=crop' }}" 
                            alt="{{ $ruangBelajar->judul }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        <!-- Overlay Badge Mapel, Target Kelas & Tanggal -->
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none gap-2">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <!-- Badge Mapel -->
                                <span class="px-2.5 py-1 text-[10px] font-extrabold tracking-wide uppercase rounded-xl bg-indigo-950/80 backdrop-blur-md text-indigo-300 border border-indigo-500/30 shadow-xs truncate max-w-[120px]">
                                    {{ $ruangBelajar->mapel }}
                                </span>
                            </div>
                            
                            <!-- Tanggal Buat -->
                            <span class="px-2.5 py-1 text-[10px] font-black rounded-xl bg-purple-950/80 backdrop-blur-md text-pink-300 border border-pink-500/30 shadow-xs">
                                Kelas {{ $ruangBelajar->kelas }}
                            </span>
                        </div>
                    </div>

                    <!-- Judul & Deskripsi -->
                    <div class="space-y-1.5 pt-1">
                        <h3 class="text-sm font-black text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors line-clamp-2 leading-snug">
                            {{ $ruangBelajar->judul }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                            {{ $ruangBelajar->deskripsi ?? 'Belum ada deskripsi singkat untuk ruang belajar ini.' }}
                        </p>
                    </div>

                    <!-- Informasi Guru Pengajar & Detail Siswa -->
                    <div class="space-y-2.5 pt-3 border-t border-gray-100 dark:border-pink-950/20">
                        <!-- Profile Guru & Target Kelas Info -->
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-500 text-white flex items-center justify-center text-[10px] font-bold shadow-xs shrink-0">
                                    <i class="fa-solid fa-chalkboard-user"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pengajar</p>
                                    <p class="text-xs font-bold text-gray-800 dark:text-gray-200 truncate">
                                        {{ $ruangBelajar->guru->fullname ?? $ruangBelajar->user->fullname ?? 'Guru Pengajar' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Target Kelas Tag -->
                            <div class="px-2.5 py-1 rounded-xl bg-gray-100 dark:bg-cyberdark-800 text-gray-600 dark:text-gray-300 text-[10px] font-bold shrink-0 border border-gray-200/50 dark:border-pink-950/20">
                                <i class="fa-solid fa-users text-indigo-500 mr-1"></i> Kelas {{ $ruangBelajar->kelas }}
                            </div>
                        </div>

                        <!-- Metrics Counter Bar -->
                        <div class="flex items-center justify-between p-2 rounded-2xl bg-gray-50/80 dark:bg-cyberdark-800/50 border border-gray-100/80 dark:border-pink-950/10 text-xs">
                            <span class="flex items-center gap-1.5 font-extrabold text-emerald-600 dark:text-emerald-400">
                                <i class="fa-solid fa-user-check text-[11px]"></i> {{ $ruangBelajar->siswa_count }} Siswa Join
                            </span>
                            <span class="text-[10px] font-extrabold text-indigo-500 dark:text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded-lg">
                                {{ $ruangBelajar->tahapans_count ?? 0 }} Tahapan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Area / Tombol Aksi -->
                <div class="space-y-2 pt-2 relative z-10">
                    <!-- Tombol Utama: Kelola Tahapan Isi Materi -->
                    <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}" class="w-full py-2.5 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-2xl text-xs font-extrabold transition-all duration-200 flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20 active:scale-95">
                        <i class="fa-solid fa-layer-group text-xs"></i>
                        <span>Isi Tahapan</span>
                    </a>

                    <!-- Sub Aksi: Lihat Siswa Join, Edit, & Hapus -->
                    <div class="flex items-center gap-2">
                        <!-- Tombol Mata: Lihat Siswa Join -->
                        <a href="#" class="flex-1 py-2 px-3 bg-gray-50 dark:bg-cyberdark-800 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded-xl text-xs font-bold transition-all duration-200 flex items-center justify-center gap-1.5 border border-gray-100 dark:border-pink-950/20" title="Lihat Siswa Join">
                            <i class="fa-solid fa-eye text-xs"></i>
                            <span class="text-[11px]">Siswa</span>
                        </a>

                        <!-- Tombol Edit -->
                        <a href="{{ route('guru.ruang-belajar.edit', $ruangBelajar->id) }}" class="p-2.5 text-gray-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-950/30 border border-transparent hover:border-amber-500/20 rounded-xl transition-all duration-200" title="Edit Ruang Belajar">
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                        </a>

                        <!-- Tombol Hapus -->
                        <form id="delete-form-{{ $ruangBelajar->id }}" 
                            action="{{ route('guru.ruang-belajar.destroy', $ruangBelajar->id) }}" 
                            method="POST" 
                            class="inline">
                            @csrf
                            @method('DELETE')
                            
                            <button type="button" 
                                    onclick="confirmDelete('{{ $ruangBelajar->id }}', '{{ addslashes($ruangBelajar->judul) }}')" 
                                    class="p-2.5 text-gray-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 border border-transparent hover:border-rose-500/20 rounded-xl transition-all duration-200 cursor-pointer" 
                                    title="Hapus Ruang Belajar">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-center space-y-3 bg-white dark:bg-cyberdark-900/50 border border-dashed border-gray-200 dark:border-pink-950/30 rounded-3xl">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum ada materi dibuat</h3>
                    <p class="text-xs text-gray-400 max-w-sm">Mulai tambahkan modul materi pembelajaran baru untuk dibagikan kepada peserta didik.</p>
                </div>
                <a href="{{ route('guru.ruang-belajar.create') }}" class="mt-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition shadow-sm">
                    + Tambah Materi Pertama
                </a>
            </div>
        @endforelse

    </div>
    <!-- Pagination Container -->
    <div class="mt-8 flex justify-end">
        {{ $ruangBelajars->links('pagination::tailwind') }}
    </div>
</div>
@push('scripts')
<script>
    // 1. Konfirmasi Hapus dengan SweetAlert2
    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Hapus Ruang Belajar?',
            text: `Apakah Anda yakin ingin menghapus ruang belajar "${title}"? Data yang dihapus tidak dapat dikembalikan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // Tailwind Rose-600
            cancelButtonColor: '#6b7280',  // Tailwind Gray-500
            confirmButtonText: 'Ya, Hapus Sekarang!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3xl dark:bg-cyberdark-900 dark:text-white dark:border dark:border-pink-950/40',
                confirmButton: 'rounded-xl text-xs font-bold px-4 py-2.5',
                cancelButton: 'rounded-xl text-xs font-bold px-4 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form hapus jika dikonfirmasi
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    // 2. Tampilkan Toast Success jika ada Session Flash 'success' dari Controller
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-3xl dark:bg-cyberdark-900 dark:text-white dark:border dark:border-pink-950/40'
            }
        });
    @endif
</script>
@endpush
@endsection