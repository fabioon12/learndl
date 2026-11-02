@extends('admin.layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6 font-sans text-slate-800">

    <!-- Header / Welcome Banner -->
    <div class="relative overflow-hidden bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="space-y-1.5 z-10 max-w-xl">
            <div class="flex items-center space-x-2.5">
                <!-- Icon Title Badge (Hijau Emerald) -->
                <div class="p-2.5 bg-emerald-100/70 text-emerald-600 rounded-2xl">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Pengguna</h1>
            </div>
            <p class="text-slate-500 text-sm leading-relaxed pt-1">
                Kelola akun pengguna platform LearnDL, mulai dari verifikasi, pengaturan peran, hingga pengelolaan akses.
            </p>
        </div>

        <!-- Banner Illustration & Tagline (Tema Hijau Emerald) -->
        <div class="hidden lg:flex items-center space-x-3.5 relative z-10 flex-shrink-0">
            <!-- Icon Box dengan Glow Effect Hijau -->
            <div class="relative">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white text-2xl shadow-lg shadow-emerald-200">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <!-- Light Glow Emerald -->
                <div class="absolute -inset-1.5 bg-emerald-500/20 rounded-2xl blur-md -z-10"></div>
            </div>

            <!-- Speech Bubble / Tagline Box Hijau -->
            <div class="relative bg-emerald-50/80 border border-emerald-100 p-2.5 rounded-2xl max-w-[150px] shadow-sm">
                <p class="text-[11px] font-semibold text-emerald-700 italic leading-tight text-right">
                    Pengguna Hebat Membangun Pembelajaran Berkualitas ❤️
                </p>
                <!-- Aksen Panah Bubble Hijau -->
                <div class="absolute top-1/2 -left-2 -translate-y-1/2 w-0 h-0 border-y-4 border-y-transparent border-r-8 border-r-emerald-50"></div>
            </div>
        </div>
    </div>

    <!-- Metric Cards (4 Kolom) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Total Pengguna -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Total Pengguna</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalUsersCount) }}</h3>
                <p class="text-[11px] font-semibold mt-1 {{ $totalGrowth >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fa-solid {{ $totalGrowth > 0 ? 'fa-arrow-up' : ($totalGrowth < 0 ? 'fa-arrow-down' : 'fa-arrow-right') }}"></i> 
                    {{ abs($totalGrowth) }}% 
                    <span class="text-slate-400 font-normal">dari bulan lalu</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Card 2: Guru -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Guru</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($guruCount) }}</h3>
                <p class="text-[11px] font-semibold mt-1 {{ $guruGrowth >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fa-solid {{ $guruGrowth > 0 ? 'fa-arrow-up' : ($guruGrowth < 0 ? 'fa-arrow-down' : 'fa-arrow-right') }}"></i> 
                    {{ abs($guruGrowth) }}% 
                    <span class="text-slate-400 font-normal">dari bulan lalu</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>

        <!-- Card 3: Siswa -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Siswa</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($siswaCount) }}</h3>
                <p class="text-[11px] font-semibold mt-1 {{ $siswaGrowth >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fa-solid {{ $siswaGrowth > 0 ? 'fa-arrow-up' : ($siswaGrowth < 0 ? 'fa-arrow-down' : 'fa-arrow-right') }}"></i> 
                    {{ abs($siswaGrowth) }}% 
                    <span class="text-slate-400 font-normal">dari bulan lalu</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-lg">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
        </div>

        <!-- Card 4: Admin -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Admin</p>
                <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($adminCount) }}</h3>
                <p class="text-[11px] font-semibold mt-1 {{ $adminGrowth >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fa-solid {{ $adminGrowth > 0 ? 'fa-arrow-up' : ($adminGrowth < 0 ? 'fa-arrow-down' : 'fa-arrow-right') }}"></i> 
                    {{ abs($adminGrowth) }}% 
                    <span class="text-slate-400 font-normal">dari bulan lalu</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-gear"></i>
            </div>
        </div>

    </div>

    <!-- Filter Tab & Search Bar Container -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-5">
        
        <!-- Top Toolbar: Tabs, Search & Add Button -->
        <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4">
            
            <!-- Tabs Peran (Terhubung ke Query String ?role=) -->
            <div class="flex items-center space-x-2 overflow-x-auto pb-1 lg:pb-0">
                
                <!-- Tab: Semua Pengguna -->
                @php $isAll = !request()->filled('role'); @endphp
                <a href="{{ route('admin.manajemen-pengguna', request()->except('role', 'page')) }}" 
                class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center space-x-2 transition border {{ $isAll ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-200 font-bold' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border-slate-200/60' }}">
                    <span>Semua Pengguna</span>
                    <span class="px-2 py-0.5 rounded-md text-[10px] {{ $isAll ? 'bg-emerald-800 text-white' : 'bg-slate-200 text-slate-600' }}">
                        {{ number_format($totalUsersCount) }}
                    </span>
                </a>

                <!-- Tab: Siswa -->
                @php $isSiswa = request('role') === 'siswa'; @endphp
                <a href="{{ route('admin.manajemen-pengguna', array_merge(request()->except('page'), ['role' => 'siswa'])) }}" 
                class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center space-x-2 transition border {{ $isSiswa ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-200 font-bold' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border-slate-200/60' }}">
                    <span>Siswa</span>
                    <span class="px-2 py-0.5 rounded-md text-[10px] {{ $isSiswa ? 'bg-emerald-800 text-white' : 'bg-slate-200 text-slate-600' }}">
                        {{ number_format($siswaCount) }}
                    </span>
                </a>

                <!-- Tab: Guru -->
                @php $isGuru = request('role') === 'guru'; @endphp
                <a href="{{ route('admin.manajemen-pengguna', array_merge(request()->except('page'), ['role' => 'guru'])) }}" 
                class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center space-x-2 transition border {{ $isGuru ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-200 font-bold' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border-slate-200/60' }}">
                    <span>Guru</span>
                    <span class="px-2 py-0.5 rounded-md text-[10px] {{ $isGuru ? 'bg-emerald-800 text-white' : 'bg-slate-200 text-slate-600' }}">
                        {{ number_format($guruCount) }}
                    </span>
                </a>

                <!-- Tab: Admin -->
                @php $isAdmin = request('role') === 'admin'; @endphp
                <a href="{{ route('admin.manajemen-pengguna', array_merge(request()->except('page'), ['role' => 'admin'])) }}" 
                class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center space-x-2 transition border {{ $isAdmin ? 'bg-emerald-600 text-white border-emerald-600 shadow-sm shadow-emerald-200 font-bold' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border-slate-200/60' }}">
                    <span>Admin</span>
                    <span class="px-2 py-0.5 rounded-md text-[10px] {{ $isAdmin ? 'bg-emerald-800 text-white' : 'bg-slate-200 text-slate-600' }}">
                        {{ number_format($adminCount) }}
                    </span>
                </a>

            </div>

            <!-- Search Bar & Tombol Tambah Pengguna -->
            <div class="flex items-center space-x-3">
                <!-- Form Search -->
                <form method="GET" action="{{ route('admin.manajemen-pengguna') }}" class="relative flex-1 sm:w-64">
                    @foreach(request()->except('search', 'page') as $key => $value)
                        @if($value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach

                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari nama atau email..." 
                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                </form>

                <!-- Tombol Tambah Pengguna (Emerald Green) -->
                <a href="{{ route('admin.manajemen-pengguna.create') }}" 
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold flex items-center space-x-2 transition shadow-md shadow-emerald-200 whitespace-nowrap cursor-pointer">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Pengguna</span>
                </a>
            </div>

        </div>

        <!-- Filter Dropdowns Row -->
        <form method="GET" action="{{ route('admin.manajemen-pengguna') }}" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3 pt-3 border-t border-slate-100">
            
            <!-- 1. Filter Peran -->
            <div>
                <label class="block text-[11px] font-medium text-slate-400 mb-1">Peran</label>
                <select name="role" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 p-2 focus:outline-none focus:ring-1 focus:ring-purple-500">
                    <option value="">Semua Peran</option>
                    <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <!-- 2. Filter Kelas -->
            <div>
                <label class="block text-[11px] font-medium text-slate-400 mb-1">Kelas</label>
                <select name="grade" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 p-2 focus:outline-none focus:ring-1 focus:ring-purple-500">
                    <option value="">Semua Kelas</option>
                    <option value="10" {{ request('grade') == '10' ? 'selected' : '' }}>Kelas 10</option>
                    <option value="11" {{ request('grade') == '11' ? 'selected' : '' }}>Kelas 11</option>
                    <option value="12" {{ request('grade') == '12' ? 'selected' : '' }}>Kelas 12</option>
                </select>
            </div>

            <!-- 3. Filter Jurusan / Subjek -->
            <div>
                <label class="block text-[11px] font-medium text-slate-400 mb-1">Jurusan / Subjek</label>
                <select name="major_or_subject" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 p-2 focus:outline-none focus:ring-1 focus:ring-purple-500">
                    <option value="">Semua Jurusan</option>
                    <option value="Rekayasa Perangkat Lunak" {{ request('major_or_subject') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>RPL</option>
                    <option value="Teknik Jaringan Komputer dan Telekomunikasi" {{ request('major_or_subject') == 'Teknik Jaringan Komputer dan Telekomunikasi' ? 'selected' : '' }}>TJKT</option>
                    <option value="Teknik Jaringan dan Telekomunikasi" {{ request('major_or_subject') == 'Teknik Jaringan dan Telekomunikasi' ? 'selected' : '' }}>TJT</option>
                </select>
            </div>

            <!-- 4. Filter Offering -->
            <div>
                <label class="block text-[11px] font-medium text-slate-400 mb-1">Offering</label>
                <select name="offering" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 p-2 focus:outline-none focus:ring-1 focus:ring-purple-500">
                    <option value="">Semua Offering</option>
                    @foreach(['A', 'B', 'C', 'D'] as $offering)
                        <option value="{{ $offering }}" {{ request('offering') == $offering ? 'selected' : '' }}>Offering {{ $offering }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 5. Filter Asal Sekolah -->
            <div>
                <label class="block text-[11px] font-medium text-slate-400 mb-1">Asal Sekolah</label>
                <select name="school_name" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 p-2 focus:outline-none focus:ring-1 focus:ring-purple-500">
                    <option value="">Semua Sekolah</option>
                    @foreach([
                        'SMKN 4 MALANG', 'SMKN 5 MALANG', 'SMKN 6 MALANG', 
                        'SMKN 8 MALANG', 'SMKN 9 MALANG', 'SMKN 11 MALANG', 'SMKN 12 MALANG'
                    ] as $school)
                        <option value="{{ $school }}" {{ request('school_name') == $school ? 'selected' : '' }}>{{ $school }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 6. Filter Tanggal Bergabung -->
            <div>
                <label class="block text-[11px] font-medium text-slate-400 mb-1">Tgl Bergabung</label>
                <select name="created_at" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 p-2 focus:outline-none focus:ring-1 focus:ring-purple-500">
                    <option value="">Semua Waktu</option>
                    <option value="today" {{ request('created_at') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="this_week" {{ request('created_at') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="this_month" {{ request('created_at') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="this_year" {{ request('created_at') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>

            <!-- 7. Tombol Reset Filter -->
            <div class="col-span-2 sm:col-span-3 lg:col-span-1 flex items-end justify-end">
                <a href="{{ route('admin.manajemen-pengguna') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold flex items-center space-x-1 py-2 px-3 rounded-xl hover:bg-rose-50 transition">
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Reset</span>
                </a>
            </div>
        </form>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-purple-50/50 text-purple-900 text-[11px] font-bold uppercase tracking-wider border-y border-purple-100">
                        <th class="p-3.5">No.</th>
                        <th class="p-3.5">Nama Pengguna</th>
                        <th class="p-3.5">Kelas</th>                       
                        <th class="p-3.5">Jurusan</th>                       
                        <th class="p-3.5">Offering</th>                       
                        <th class="p-3.5">Peran</th>                        
                        <th class="p-3.5">Instansi/Sekolah</th>
                        <th class="p-3.5">Status</th>
                        <th class="p-3.5">Tanggal Bergabung</th>
                        <th class="p-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 text-slate-400">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="p-3.5">
                                <div class="flex items-center space-x-3">
                                    <!-- Avatar berdasarkan Inisial Fullname & Mood -->
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-purple-500 to-indigo-600 text-white font-bold flex items-center justify-center text-xs relative">
                                        {{ strtoupper(substr($user->fullname, 0, 2)) }}
                                        <span class="absolute -bottom-1 -right-1 text-[10px]">{{ $user->mood ?? '😊' }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $user->fullname }}</p>
                                        <p class="text-[10px] text-slate-400">
                                            {{ $user->email }}
                                    </div>
                                </div>
                            </td>
                            <td class="p-3.5 text-slate-500">{{ $user->grade ?? '-' }}</td>
                            <td class="p-3.5 text-slate-500">{{ $user->major_or_subject ?? '-' }}</td>
                            <td class="p-3.5 text-slate-500">{{ $user->offering ?? '-' }}</td>
                            <td class="p-3.5">
                                <!-- Badge Peran (Siswa / Guru / Admin) -->
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-700">
                                        <i class="fa-solid fa-user-gear text-[10px]"></i> <span>Admin</span>
                                    </span>
                                @elseif($user->role === 'guru')
                                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-purple-100 text-purple-700">
                                        <i class="fa-solid fa-user-graduate text-[10px]"></i> <span>Guru</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-blue-100 text-blue-700">
                                        <i class="fa-solid fa-graduation-cap text-[10px]"></i> <span>Siswa</span>
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-slate-600">
                                {{ $user->school_name ?? 'Pusat / Tidak Ada' }}
                            </td>
                            <td class="p-3.5">
                                <!-- Status berdasarkan email_verified_at -->
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
                                        <i class="fa-solid fa-check text-[10px]"></i> <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-700">
                                        <i class="fa-solid fa-clock text-[10px]"></i> <span>Belum Verifikasi</span>
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-slate-500">
                                {{ $user->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.manajemen-pengguna.edit', $user->id) }}" 
                                    title="Edit Pengguna" 
                                    class="p-1.5 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>

                                    <!-- Form Hapus Pengguna dengan SweetAlert2 -->
                                    <form action="{{ route('admin.manajemen-pengguna.destroy', $user->id) }}" 
                                        method="POST" 
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                title="Hapus Pengguna" 
                                                onclick="confirmDelete(this, '{{ $user->fullname }}')"
                                                class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition cursor-pointer">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-400">
                                <i class="fa-solid fa-users-slash text-2xl mb-2 block"></i>
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="pt-4">
            {{ $users->links() }}
        </div>

    </div>
</div>

@endsection
@push('scripts')
<script>
    function confirmDelete(button, userName) {
        Swal.fire({
            title: 'Hapus Pengguna?',
            text: `Apakah Anda yakin ingin menghapus "${userName}"? Data yang dihapus tidak dapat dikembalikan.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // Tailwind rose-600
            cancelButtonColor: '#64748b',  // Tailwind slate-500
            confirmButtonText: '<i class="fa-solid fa-trash-can mr-1"></i> Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-3xl p-6',
                confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold shadow-lg shadow-rose-500/30',
                cancelButton: 'px-5 py-2.5 rounded-xl text-xs font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('.delete-form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
            customClass: {
                popup: 'rounded-2xl shadow-xl border border-emerald-100'
            }
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#e11d48',
            customClass: {
                popup: 'rounded-3xl'
            }
        });
    @endif
</script>
@endpush