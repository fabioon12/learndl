@extends('admin.layouts.app')

@section('title', 'Manajemen Ruang Belajar - LearnDL')

@section('content')
@php
    // DUMMY DATA ARRAY (Tanpa Database)
    $stats = [
        ['label' => 'Total Ruang Belajar', 'count' => 28, 'growth' => '3 dari bulan lalu', 'icon' => 'fa-book-open', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
        ['label' => 'Total Siswa di Semua Ruang', 'count' => 341, 'growth' => '18 dari bulan lalu', 'icon' => 'fa-users', 'bg' => 'bg-amber-50', 'text' => 'text-amber-500'],
        ['label' => 'Total Materi di Semua Ruang', 'count' => 126, 'growth' => '9 dari bulan lalu', 'icon' => 'fa-file-lines', 'bg' => 'bg-blue-50', 'text' => 'text-blue-500'],
    ];

@endphp

<div class="space-y-6 pb-10 font-sans">

    <!-- Header / Banner Welcome -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100/70 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Ruang Belajar</h1>
                <p class="text-xs text-slate-400 mt-0.5">Pantau dan kelola semua ruang belajar di platform LearnDL secara menyeluruh.</p>
            </div>
        </div>

        <a href="{{route('admin.ruang-belajar.create')}}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-xs font-bold flex items-center space-x-2 transition shadow-md shadow-emerald-200 whitespace-nowrap cursor-pointer">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Ruang Belajar</span>
        </a>
    </div>

    <!-- 3 Stat Cards (Disederhanakan) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($stats as $st)
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">{{ $st['label'] }}</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $st['count'] }}</h3>
                    <p class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up text-[9px]"></i> {{ $st['growth'] }}
                    </p>
                </div>
                <div class="w-11 h-11 rounded-2xl {{ $st['bg'] }} {{ $st['text'] }} flex items-center justify-center text-lg">
                    <i class="fa-solid {{ $st['icon'] }}"></i>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        
        <div class="flex flex-col sm:flex-row items-center gap-3 flex-1 max-w-xl">
            <!-- Search Input -->
            <div class="relative w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" placeholder="Cari nama ruang atau guru..." class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
            </div>
        </div>

        <div class="flex items-center space-x-2 justify-end">
            <button class="px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                <i class="fa-solid fa-download text-slate-400"></i> Export
            </button>
        </div>
    </div>

    <!-- Data Ruang Belajar Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden font-sans">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                        <th class="p-4 pl-6 w-16">NO.</th>
                        <th class="p-4">RUANG BELAJAR</th>
                        <th class="p-4">GURU PENGAJAR</th>
                        <th class="p-4">TARGET SEKOLAH</th>
                        <th class="p-4 text-center">KELAS</th>
                        <th class="p-4 text-center">SISWA TERDAFTAR</th>
                        <th class="p-4">TANGGAL DIBUAT</th>
                        <th class="p-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @forelse($ruangBelajars as $index => $row)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Nomor Urut / Pagination -->
                            <td class="p-4 pl-6 font-semibold text-slate-400">
                                {{ $ruangBelajars->firstItem() + $index }}
                            </td>

                            <!-- Judul & Mapel Ruang Belajar -->
                            <td class="p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 overflow-hidden shrink-0 shadow-sm flex items-center justify-center border border-slate-200/60">
                                        @if($row->thumbnail)
                                            <img src="{{ asset('storage/' . $row->thumbnail) }}" 
                                                alt="{{ $row->judul }}" 
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-emerald-600 text-white flex items-center justify-center text-xs">
                                                <i class="fa-solid fa-book-open"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 text-xs block leading-snug">
                                            {{ $row->judul }}
                                        </span>
                                        <span class="text-[10px] text-slate-400">
                                            {{ $row->mapel }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Guru Pengajar (Relasi guru) -->
                            <td class="p-4">
                                <!-- Guru Pengajar (guru_id) -->
                                <div class="font-bold text-slate-800">
                                    {{ $row->guru->fullname ?? $row->guru->name ?? 'Belum Ditunjuk' }}
                                </div>
                                
                                <!-- Informasi Tambahan Guru Pengajar -->
                                <div class="text-[10px] text-slate-400">
                                    {{ $row->guru->major_or_subject ?? $row->guru->email ?? '-' }}
                                </div>

                                <!-- Info Pembuat (Jika Pembuat beda dengan Pengajar) -->
                                @if($row->user && $row->user_id !== $row->guru_id)
                                    <div class="mt-1 text-[10px] text-indigo-500 font-medium">
                                        <i class="fa-solid fa-user-pen text-[9px]"></i> Pembuat: {{ $row->user->fullname ?? $row->user->name }}
                                    </div>
                                @endif
                            </td>

                            <!-- Target Sekolah (Badges JSON Array) -->
                            <td class="p-4">
                                <div class="flex flex-wrap gap-1 max-w-xs">
                                    @if(!empty($row->target_schools) && is_array($row->target_schools))
                                        @foreach($row->target_schools as $school)
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] font-bold rounded-md">
                                                {{ $school }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-slate-400 text-[10px] italic">Semua Sekolah</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Kelas Target -->
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold rounded-lg">
                                    Kelas {{ $row->kelas }}
                                </span>
                            </td>

                            <!-- Siswa Terdaftar (Placeholder Data Dinamis) -->
                            <td class="p-4 text-center">
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 border border-slate-200/60 rounded-xl">
                                    <i class="fa-solid fa-users text-[11px] text-slate-400"></i>
                                    <span class="font-bold text-slate-700 text-xs">
                                        {{ $row->siswa_count ?? 0 }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 font-medium">Siswa</span>
                                </div>
                            </td>

                            <!-- Tanggal Dibuat -->
                            <td class="p-4 text-slate-500 font-medium whitespace-nowrap">
                                {{ $row->created_at ? $row->created_at->translatedFormat('d M Y') : '-' }}
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <!-- Detail -->
                                    <a href="#" 
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-500 transition flex items-center justify-center text-xs cursor-pointer" 
                                    title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="#" 
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-amber-50 hover:text-amber-600 text-slate-500 transition flex items-center justify-center text-xs cursor-pointer" 
                                    title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Hapus (Modal / Form Delete) -->
                                    <form action="{{ route('admin.ruang-belajar.destroy', $row->id) }}" 
                                        method="POST" 
                                        class="inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                data-title="{{ $row->judul }}"
                                                class="btn-delete w-8 h-8 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 transition flex items-center justify-center text-xs cursor-pointer" 
                                                title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-folder-open text-3xl text-slate-300"></i>
                                    <p>Belum ada Ruang Belajar yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Dynamic Laravel Pagination Bar -->
        <div class="p-4 bg-white border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <div>
                Menampilkan {{ $ruangBelajars->firstItem() ?? 0 }} - {{ $ruangBelajars->lastItem() ?? 0 }} dari {{ $ruangBelajars->total() }} data
            </div>
            <div>
                {{ $ruangBelajars->links() }}
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event Listener untuk Tombol Hapus
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                
                const form = this.closest('.form-delete');
                const title = this.getAttribute('data-title') || 'ruang belajar ini';

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: `Ruang belajar "${title}" akan dihapus secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#059669', // Warna Emerald 600
                    cancelButtonColor: '#94a3b8',  // Warna Slate 400
                    confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'px-4 py-2 text-xs font-bold rounded-xl shadow-md',
                        cancelButton: 'px-4 py-2 text-xs font-bold rounded-xl'
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