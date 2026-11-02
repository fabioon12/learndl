@extends('guru.layouts.app')

@section('title', 'Indeks Sub Materi - ' . ($materi->judul ?? 'Detail Materi'))

@section('content')
<div class="space-y-6" x-data="{ 
    search: '', 
    statusFilter: 'semua'
}">

    <!-- Navigation Breadcrumbs -->
    <nav class="flex text-xs text-gray-400 gap-2 items-center">
        <a href="{{ route('guru.materi.index') }}" class="hover:text-indigo-600 transition flex items-center gap-1">
            <i class="fa-solid fa-house text-[10px]"></i> Ruang Materi
        </a>
        <span>&rsaquo;</span>
        <span class="text-gray-600 dark:text-gray-300 font-semibold">{{ $materi->judul ?? 'Video Pembelajaran' }}</span>
        <span>&rsaquo;</span>
        <span class="text-indigo-600 dark:text-indigo-400 font-bold">Indeks Sub Materi</span>
    </nav>

    <!-- Header Banner Hero -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-sky-100 via-indigo-100 to-sky-50 dark:from-cyberdark-900 dark:via-indigo-950/40 dark:to-cyberdark-800 p-6 md:p-8 border border-sky-200/50 dark:border-pink-950/20 shadow-xs flex items-center justify-between">
        <div class="space-y-2 max-w-lg z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-600 text-white shadow-xs">
                <i class="fa-solid fa-play text-[10px]"></i> {{ $materi->judul ?? 'Video' }}
            </span>
            <h1 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white">Indeks Sub Materi</h1>
            <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">
                Kelola dan pantau seluruh sub materi yang telah Anda tambahkan untuk mendukung proses pembelajaran.
            </p>
        </div>
        
        <!-- Banner Graphic Right Side -->
        <div class="hidden lg:flex items-center gap-4 z-10">
            <div class="bg-white/80 dark:bg-cyberdark-800/80 backdrop-blur-md px-5 py-3 rounded-2xl border border-white/60 dark:border-pink-950/30 text-right shadow-sm">
                <p class="text-xs font-bold text-gray-800 dark:text-gray-200">Pembelajaran Lebih Bermakna</p>
                <p class="text-[11px] text-indigo-600 dark:text-indigo-400 font-black">Bersama! <i class="fa-regular fa-heart"></i></p>
            </div>
        </div>
        
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-400/10 rounded-full blur-2xl"></div>
    </div>

    <!-- Filter Bar, Search, and Action -->
    <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-3xl border border-gray-100 dark:border-pink-950/30 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <button @click="statusFilter = 'semua'" 
                    :class="statusFilter === 'semua' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-cyberdark-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap">
                Semua Sub Materi <span class="px-1.5 py-0.5 rounded-full text-[10px] bg-white/20 text-current">{{ $materi->subMateris->count() }}</span>
            </button>
            
            <button @click="statusFilter = 'terbit'" 
                    :class="statusFilter === 'terbit' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-gray-100 dark:bg-cyberdark-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Terbit 
                <span class="text-[10px] opacity-75">({{ $materi->subMateris->where('status', 'terbit')->count() }})</span>
            </button>
            
            <button @click="statusFilter = 'draft'" 
                    :class="statusFilter === 'draft' ? 'bg-slate-700 text-white shadow-sm' : 'bg-gray-100 dark:bg-cyberdark-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200'"
                    class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5 whitespace-nowrap">
                <span class="w-2 h-2 rounded-full bg-slate-400"></span> Draft 
                <span class="text-[10px] opacity-75">({{ $materi->subMateris->where('status', 'draft')->count() }})</span>
            </button>
        </div>

        <!-- Search Input & Add Button -->
        <div class="flex items-center gap-3">
            <div class="relative flex-1 md:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-gray-400"></i>
                <input type="text" x-model="search" placeholder="Cari sub materi..." class="w-full pl-9 pr-4 py-2 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <a href="{{ route('guru.materi.submateri.create', $materi->id) }}" 
            class="px-4 py-2 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md transition flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Sub Materi
            </a>
        </div>
    </div>

    <!-- Sub Materi Data Table -->
    <div class="bg-white dark:bg-cyberdark-900 rounded-3xl border border-gray-100 dark:border-pink-950/30 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-pink-950/20 text-[11px] uppercase font-bold text-gray-400 tracking-wider">
                        <th class="py-4 px-6 w-12 text-center">No.</th>
                        <th class="py-4 px-6">Nama Sub Materi</th>
                        <th class="py-4 px-6">Estimasi Waktu</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">XP Reward</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-pink-950/20 text-xs">
                    @forelse($materi->submateris as $index => $sub)
                        @php
                            // Mapping Tipe Icon & Styling Warna Badge
                            $typeBadges = [
                                'video'      => ['bg' => 'bg-indigo-50 dark:bg-indigo-950/40', 'icon' => 'fa-play-circle text-indigo-500', 'label' => 'Video'],
                                'teks'       => ['bg' => 'bg-sky-50 dark:bg-sky-950/40',       'icon' => 'fa-file-lines text-sky-500',   'label' => 'Teks'],
                                'interaktif' => ['bg' => 'bg-purple-50 dark:bg-purple-950/40', 'icon' => 'fa-gear text-purple-500',       'label' => 'Interaktif'],
                                'praktik'    => ['bg' => 'bg-amber-50 dark:bg-amber-500/40',   'icon' => 'fa-code text-amber-500',       'label' => 'Praktik'],
                                'latihan'    => ['bg' => 'bg-emerald-50 dark:bg-emerald-950/40', 'icon' => 'fa-pen-to-square text-emerald-500', 'label' => 'Latihan'],
                            ];

                            $tipes = is_array($sub->tipe) ? $sub->tipe : json_decode($sub->tipe, true) ?? [$sub->tipe];
                        @endphp

                        <tr x-show="(statusFilter === 'semua' || statusFilter === '{{ $sub->status }}') && ('{{ strtolower($sub->judul_sub) }}'.includes(search.toLowerCase()))"
                            class="hover:bg-gray-50/50 dark:hover:bg-cyberdark-800/40 transition">
                            
                            <!-- Nomor -->
                            <td class="py-4 px-6 text-center font-bold text-gray-400">{{ $index + 1 }}</td>
                            
                            <!-- Nama Sub Materi & Multiple Ikon Visual -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    
                                    <!-- Loop Multiple Type Icons -->
                                    <div class="flex items-center gap-1.5 shrink-0">
                                        @foreach($tipes as $t)
                                            @php
                                                $badge = $typeBadges[$t] ?? $typeBadges['teks'];
                                            @endphp
                                            <div class="w-9 h-9 rounded-2xl {{ $badge['bg'] }} flex flex-col items-center justify-center border border-gray-100 dark:border-pink-950/20 shadow-2xs" title="{{ $badge['label'] }}">
                                                <i class="fa-solid {{ $badge['icon'] }} text-xs"></i>
                                                <span class="text-[7px] font-black uppercase text-gray-400 leading-none mt-0.5">{{ $badge['label'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white hover:text-indigo-600 transition cursor-pointer">
                                            {{ $sub->judul_sub }}
                                        </h4>
                                        <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">
                                            {{ $sub->deskripsi ?? 'Memahami konsep dan penerapan sub materi.' }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <!-- Estimasi Waktu -->
                            <td class="py-4 px-6 font-semibold text-gray-500 dark:text-gray-400">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fa-regular fa-clock text-xs text-gray-400"></i> {{ $sub->estimasi_waktu ?? '10 menit' }}
                                </span>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-6">
                                @if(($sub->status ?? 'terbit') === 'terbit')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Terbit
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-400">
                                        <span class="w-2 h-2 rounded-full bg-slate-400"></span> Draft
                                    </span>
                                @endif
                            </td>

                            <!-- XP Reward -->
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-2xl bg-gradient-to-r from-amber-500/10 to-yellow-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 font-black text-xs shadow-2xs">
                                    <i class="fa-solid fa-bolt text-amber-500 text-xs"></i>
                                    +{{ $sub->xp_reward ?? 50 }} XP
                                </span>
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- View Button -->
                                    @if(empty($sub->konten_builder))
                                        <!-- Jika Belum Ada Konten Aktivitas -->
                                        <a href="{{ route('guru.materi.submateri.aktivitas.create', ['materi_id' => $materi->id, 'submateri_id' => $sub->id]) }}" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 text-xs font-bold transition">
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                            <span>Tambah Aktivitas</span>
                                        </a>
                                    @else
                                        <!-- Jika Sudah Ada Konten Aktivitas -->
                                        <div class="inline-flex items-center gap-1">
                                            <!-- Tombol Edit Aktivitas (Builder) -->
                                            <a href="{{ route('guru.materi.submateri.aktivitas.edit', ['materi_id' => $materi->id, 'submateri_id' => $sub->id]) }}" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 hover:bg-amber-100 text-xs font-bold transition"
                                            title="Edit Isi Konten Aktivitas">
                                                <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                                <span>Kelola Aktivitas</span>
                                            </a>

                                            <!-- Tombol Preview / Lihat (Modal atau New Tab) -->
                                            <a href="{{ route('guru.materi.submateri.aktivitas.show', ['materi_id' => $materi->id, 'submateri_id' => $sub->id]) }}" 
                                            target="_blank"
                                            class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-cyberdark-700 transition"
                                            title="Preview Tampilan Siswa">
                                                <i class="fa-solid fa-eye text-xs"></i>
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Edit Button -->
                                    <a href="{{ route('guru.materi.submateri.edit', ['materi_id' => $materi->id, 'id' => $sub->id]) }}" 
                                    class="w-7 h-7 rounded-xl bg-gray-100 text-gray-500 dark:bg-cyberdark-800 dark:text-gray-400 hover:bg-indigo-600 hover:text-white transition flex items-center justify-center" 
                                    title="Edit">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('guru.materi.submateri.destroy', ['materi_id' => $materi->id, 'id' => $sub->id]) }}" 
                                        method="POST" 
                                        class="form-delete inline-flex" 
                                        data-title="{{ $sub->judul_sub }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn-delete w-7 h-7 rounded-xl bg-gray-100 text-gray-500 dark:bg-cyberdark-800 dark:text-gray-400 hover:bg-rose-500 hover:text-white transition flex items-center justify-center" 
                                                title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                <i class="fa-solid fa-folder-open text-2xl mb-2 text-indigo-400"></i>
                                <p class="text-xs font-bold">Belum ada sub materi yang dibuat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="p-4 border-t border-gray-100 dark:border-pink-950/20 flex items-center justify-between text-xs text-gray-400">
            <p>Menampilkan 1-{{ $materi->submateris->count() }} dari {{ $materi->submateris->count() }} sub materi</p>
            
            <div class="flex items-center gap-1">
                <button class="w-7 h-7 rounded-lg border border-gray-200 dark:border-pink-950/30 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-cyberdark-800 disabled:opacity-50" disabled>
                    <i class="fa-solid fa-chevron-left text-[10px]"></i>
                </button>
                <button class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-bold flex items-center justify-center">1</button>
                <button class="w-7 h-7 rounded-lg border border-gray-200 dark:border-pink-950/30 flex items-center justify-center hover:bg-gray-100 dark:hover:bg-cyberdark-800">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('.form-delete');
                const titleName = form.getAttribute('data-title');

                Swal.fire({
                    title: 'Hapus Sub Materi?',
                    text: `Sub materi "${titleName}" akan dihapus permanen.`,
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
    });
</script>
@endpush