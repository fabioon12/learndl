@extends('guru.layouts.app')

@section('title', 'Aktivitas Materi - Eksplorasi & Aksi')

@section('content')

<div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6" x-data="{ modalOpen: false }">

    <!-- Header Banner Light/Dark Compatible -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 dark:from-cyberdark-900 dark:via-cyberdark-800 dark:to-indigo-950/80 border border-indigo-500/30 dark:border-pink-950/40 p-6 sm:p-8 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 transition-all duration-300">
        
        <!-- Background Overlay Accent Effects -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white/10 dark:bg-pink-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-48 h-48 bg-purple-400/20 dark:bg-purple-900/20 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Inner Content Area -->
        <div class="space-y-3 max-w-2xl relative z-10">
            <!-- Breadcrumb / Label Pill -->
            <div class="flex items-center gap-2">
                <a href="" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/20 dark:bg-cyberdark-800/80 text-[11px] font-extrabold text-white dark:text-gray-200 hover:bg-white/30 dark:hover:bg-cyberdark-700 transition shadow-xs border border-white/20 dark:border-pink-950/40 backdrop-blur-md">
                    <i class="fa-solid fa-graduation-cap text-amber-300 dark:text-indigo-400"></i> Ruang Materi <i class="fa-solid fa-chevron-right text-[8px] text-purple-200 dark:text-gray-400"></i>
                </a>
            </div>

            <!-- Judul Utama -->
            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white flex items-center gap-2.5 drop-shadow-xs">
                Kelola Ruang Materi <span class="animate-bounce">📖</span>
            </h1>

            <!-- Deskripsi Pendek Pendekatan Deep Learning -->
            <p class="text-xs sm:text-sm text-purple-100 dark:text-gray-300 leading-relaxed font-medium">
                Atur materi pembelajaran untuk mendukung kegiatan belajar yang <span class="text-amber-300 dark:text-purple-400 font-extrabold underline decoration-amber-300/40">berkesadaran</span>, <span class="text-emerald-300 dark:text-indigo-400 font-extrabold underline decoration-emerald-300/40">bermakna</span>, dan <span class="text-pink-200 dark:text-pink-400 font-extrabold underline decoration-pink-200/40">menggembirakan</span>.
            </p>
        </div>

        <!-- Tombol Tambah Materi Baru (Standout Action Button) -->
        <div class="relative z-10 shrink-0 flex items-center gap-4">
            <a href="{{route('guru.materi.create')}}" class="w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-white hover:bg-gray-50 text-indigo-950 dark:bg-indigo-600 dark:hover:bg-indigo-500 dark:text-white text-xs font-black shadow-lg hover:shadow-xl transition-all duration-200 active:scale-95 flex items-center justify-center gap-2.5">
                <i class="fa-solid fa-plus text-pink-500 dark:text-white text-sm"></i> Tambah Materi Baru
            </a>
        </div>

    </div>

    <!-- Stats Bar Horizontal -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Aktivitas -->
        <div class="p-4 rounded-3xl bg-white/90 dark:bg-cyberdark-900 border border-indigo-50 dark:border-pink-950/30 shadow-2xs flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-wider text-gray-400">TOTAL AKTIVITAS</p>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white">{{ $totalmateri ?? 0 }} <span class="text-xs font-normal text-gray-400">Materi</span></h4>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-xs text-indigo-300 dark:text-gray-600"></i>
        </div>

        <!-- Siswa Mengakses -->
        <div class="p-4 rounded-3xl bg-white/90 dark:bg-cyberdark-900 border border-emerald-50 dark:border-pink-950/30 shadow-2xs flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-wider text-gray-400">SISWA MENGAKSES</p>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white">32 <span class="text-xs font-normal text-gray-400">Siswa</span></h4>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-xs text-emerald-300 dark:text-gray-600"></i>
        </div>

        <!-- Reward Tahapan -->
        <div class="p-4 rounded-3xl bg-white/90 dark:bg-cyberdark-900 border border-amber-50 dark:border-pink-950/30 shadow-2xs flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-wider text-gray-400">REWARD TAHAPAN</p>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white">100 xp <span class="text-xs font-normal text-gray-400">XP</span></h4>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-xs text-amber-300 dark:text-gray-600"></i>
        </div>

        <!-- Tingkat Kelulusan -->
        <div class="p-4 rounded-3xl bg-white/90 dark:bg-cyberdark-900 border border-sky-50 dark:border-pink-950/30 shadow-2xs flex items-center justify-between">
            <div class="flex items-center gap-3.5">
                <div class="w-10 h-10 rounded-2xl bg-sky-500/10 text-sky-500 flex items-center justify-center text-sm font-bold shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black uppercase tracking-wider text-gray-400">TINGKAT KELULUSAN</p>
                    <h4 class="text-lg font-black text-gray-900 dark:text-white">85%</h4>
                </div>
            </div>
            <i class="fa-solid fa-chevron-right text-xs text-sky-300 dark:text-gray-600"></i>
        </div>
    </div>

    <!-- Main Section: Cards Aktivitas Belajar -->
    <div class="bg-white/90 dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 md:p-6 shadow-xs space-y-5">
        <!-- Section Header -->
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-pink-950/20">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs font-bold">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h3 class="text-xs font-black text-gray-900 dark:text-white">Cards Aktivitas Belajar</h3>
                    <p class="text-[10px] text-gray-400">Pilihan materi dan aktivitas yang siap dipelajari oleh siswa.</p>
                </div>
            </div>
            <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20">
                <i class="fa-solid fa-list-ul mr-1"></i> {{ $materis->count() }} Materi Tersedia
            </span>
        </div>

        <!-- Grid Cards Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse($materis as $index => $item)
                @php
                    $totalXp = $item->submateris->sum('xp_reward');
                    $totalMenit = $item->submateris->sum(function($sub) {
                        return (int) filter_var($sub->estimasi_waktu ?? 0, FILTER_SANITIZE_NUMBER_INT);
                    });
                @endphp

                <div class="group relative flex flex-col justify-between p-5 rounded-3xl border border-gray-100 dark:border-pink-950/20 bg-gray-50/40 dark:bg-cyberdark-800/40 hover:bg-white dark:hover:bg-cyberdark-800 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    
                    <div class="space-y-4">
                        <!-- Upper Banner / Thumbnail Image -->
                        <div class="w-full h-36 rounded-2xl bg-gray-100 dark:bg-cyberdark-900 relative overflow-hidden border border-gray-100 dark:border-pink-950/20">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" 
                                    alt="{{ $item->judul }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <!-- Fallback jika Thumbnail Kosong -->
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-indigo-500/10 via-purple-500/10 to-pink-500/10 text-indigo-500 dark:text-indigo-400">
                                    <i class="fa-solid fa-image text-2xl mb-1 opacity-50"></i>
                                    <span class="text-[10px] font-bold text-gray-400">No Thumbnail</span>
                                </div>
                            @endif
                        </div>

                        <!-- Card Header, Title & XP Badge -->
                        <div class="space-y-1">
                            <div class="flex items-center justify-between gap-2">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                    {{ $item->judul }}
                                </h4>

                                <!-- Badge XP Reward (Di sebelah Judul) -->
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 font-black text-[10px] shrink-0">
                                    <i class="fa-solid fa-bolt text-[10px]"></i>
                                    +{{ $totalXp }} XP
                                </span>
                            </div>

                            <p class="text-[11px] text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                {{ $item->deskripsi ?? 'Tidak ada deskripsi singkat.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer Details & Actions -->
                    <div class="pt-4 mt-4 border-t border-gray-100 dark:border-pink-950/20 flex items-center justify-between">
                        
                        <!-- Durasi Total Sub Materi -->
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-cyberdark-700/60 px-2.5 py-1 rounded-xl" title="Total Durasi Sub Materi">
                            <i class="fa-regular fa-clock text-xs"></i> {{ $totalMenit > 0 ? $totalMenit . ' Menit' : '0 Menit' }}
                        </span>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-1.5 bg-gray-100/70 dark:bg-cyberdark-900/60 p-1 rounded-xl border border-gray-200/50 dark:border-pink-950/20">
                            <!-- 1. Kelola Sub-Materi -->
                            <a href="{{ route('guru.materi.submateri.index', $item->id) }}" 
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white transition-all duration-200 shadow-2xs" 
                            title="Kelola Isi Materi">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </a>

                            <!-- 2. Lihat Progres Siswa -->
                            <a href="#" 
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-sky-600 dark:text-sky-400 hover:bg-sky-500 hover:text-white dark:hover:bg-sky-600 dark:hover:text-white transition-all duration-200" 
                            title="Lihat Siswa & Progres">
                                <i class="fa-solid fa-users text-xs"></i>
                            </a>

                            <!-- 3. Edit Materi -->
                            <a href="{{ route('guru.materi.edit', $item->id) }}" 
                            class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 dark:text-gray-400 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white transition-all duration-200" 
                            title="Edit Materi">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>

                            <!-- 4. Hapus Materi -->
                            <form action="{{ route('guru.materi.destroy', $item->id) }}" 
                                method="POST" 
                                class="form-delete inline-flex"
                                data-title="{{ $item->judul }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn-delete w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 dark:text-gray-400 hover:bg-rose-500 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white transition-all duration-200" 
                                        title="Hapus Materi">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-12 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-700 dark:text-gray-300">Belum ada materi pembelajaran</h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Klik tombol "Tambah Materi Baru" di atas untuk menambahkan materi.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Script Handler Konfirmasi Hapus Materi
        const deleteButtons = document.querySelectorAll('.btn-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.form-delete');
                const titleName = form.getAttribute('data-title');

                Swal.fire({
                    title: 'Hapus Materi?',
                    text: `Materi "${titleName}" akan dihapus secara permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl dark:bg-cyberdark-900 dark:text-white dark:border dark:border-pink-950/30',
                        title: 'text-sm font-black',
                        htmlContainer: 'text-xs text-gray-500 dark:text-gray-400',
                        confirmButton: 'rounded-2xl text-xs font-bold px-4 py-2.5',
                        cancelButton: 'rounded-2xl text-xs font-bold px-4 py-2.5'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 2. Script Pop-up Notifikasi Berhasil (Flash Session Controller)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl dark:bg-cyberdark-900 dark:text-white dark:border dark:border-pink-950/30',
                    title: 'text-sm font-black',
                    htmlContainer: 'text-xs text-gray-500 dark:text-gray-400'
                }
            });
        @endif

    });
</script>
@endpush