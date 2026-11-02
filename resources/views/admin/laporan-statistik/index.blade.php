@extends('admin.layouts.app')

@section('title', 'Laporan & Statistik - LearnDL')

@section('content')
@php
    // DUMMY DATA ARRAY (Tanpa Database)
    $stats = [
        ['label' => 'Total Guru', 'count' => 15, 'growth' => '100%', 'icon' => 'fa-users', 'bg' => 'bg-purple-50', 'text' => 'text-purple-600'],
        ['label' => 'Total Siswa', 'count' => 152, 'growth' => '100%', 'icon' => 'fa-graduation-cap', 'bg' => 'bg-blue-50', 'text' => 'text-blue-500'],
        ['label' => 'Total Ruang Belajar', 'count' => 28, 'growth' => '100%', 'icon' => 'fa-book-open', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-500'],
        ['label' => 'Total Materi', 'count' => 126, 'growth' => '100%', 'icon' => 'fa-file-lines', 'bg' => 'bg-amber-50', 'text' => 'text-amber-500'],
        ['label' => 'Total Enroll Siswa', 'count' => 341, 'growth' => '100%', 'icon' => 'fa-user-plus', 'bg' => 'bg-pink-50', 'text' => 'text-pink-500'],
    ];

    $ruangPopular = [
        ['rank' => 1, 'title' => 'Pemrograman Web Dasar', 'guru' => 'Arief Budiman, S.Kom', 'count' => '48 siswa', 'icon' => 'fa-code', 'bg' => 'bg-purple-600'],
        ['rank' => 2, 'title' => 'Matematika Diskrit', 'guru' => 'Siti Rahmawati, S.Pd', 'count' => '36 siswa', 'icon' => 'fa-square-root-variable', 'bg' => 'bg-indigo-600'],
        ['rank' => 3, 'title' => 'Desain Grafis untuk Pemula', 'guru' => 'Dewi Fitriani, S.Kom', 'count' => '28 siswa', 'icon' => 'fa-palette', 'bg' => 'bg-amber-500'],
        ['rank' => 4, 'title' => 'Jaringan Komputer Dasar', 'guru' => 'Budi Santoso, S.T', 'count' => '22 siswa', 'icon' => 'fa-network-wired', 'bg' => 'bg-emerald-500'],
        ['rank' => 5, 'title' => 'Bahasa Inggris Dasar', 'guru' => 'Linda Mayasari, S.Pd', 'count' => '18 siswa', 'icon' => 'fa-language', 'bg' => 'bg-pink-500'],
    ];

    $aktivitasTerbaru = [
        ['user' => 'Ahmad Fauzi', 'role' => 'Siswa', 'action' => 'enroll ke ruang belajar', 'target' => 'Pemrograman Web Dasar', 'time' => '2 menit yang lalu', 'initial' => 'AF', 'bg' => 'bg-indigo-600'],
        ['user' => 'Siti Nurhaliza', 'role' => 'Siswa', 'action' => 'enroll ke ruang belajar', 'target' => 'Matematika Diskrit', 'time' => '15 menit yang lalu', 'initial' => 'SN', 'bg' => 'bg-purple-600'],
        ['user' => 'Budi Santoso', 'role' => 'Guru', 'action' => 'membuat ruang belajar', 'target' => 'Jaringan Komputer Dasar', 'time' => '1 jam yang lalu', 'initial' => 'BS', 'bg' => 'bg-emerald-600'],
        ['user' => 'Rina Aprilia', 'role' => 'Siswa', 'action' => 'enroll ke ruang belajar', 'target' => 'Desain Grafis untuk Pemula', 'time' => '2 jam yang lalu', 'initial' => 'RA', 'bg' => 'bg-pink-600'],
    ];

    $enrollSiswa = [
        ['siswa' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@example.com', 'initial' => 'AF', 'ruang' => 'Pemrograman Web Dasar', 'guru' => 'Arief Budiman, S.Kom', 'date' => '27 Oct 2026', 'status' => 'Aktif', 'progress' => 75],
        ['siswa' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@example.com', 'initial' => 'SN', 'ruang' => 'Matematika Diskrit', 'guru' => 'Siti Rahmawati, S.Pd', 'date' => '26 Oct 2026', 'status' => 'Aktif', 'progress' => 40],
        ['siswa' => 'Rina Aprilia', 'email' => 'rina.aprilia@example.com', 'initial' => 'RA', 'ruang' => 'Desain Grafis untuk Pemula', 'guru' => 'Dewi Fitriani, S.Kom', 'date' => '26 Oct 2026', 'status' => 'Aktif', 'progress' => 60],
        ['siswa' => 'Dimas Ardiansyah', 'email' => 'dimas.ardiansyah@example.com', 'initial' => 'DA', 'ruang' => 'Jaringan Komputer Dasar', 'guru' => 'Budi Santoso, S.T', 'date' => '25 Oct 2026', 'status' => 'Aktif', 'progress' => 30],
        ['siswa' => 'Mega Fitriani', 'email' => 'mega.fitriani@example.com', 'initial' => 'MF', 'ruang' => 'Bahasa Inggris Dasar', 'guru' => 'Linda Mayasari, S.Pd', 'date' => '25 Oct 2026', 'status' => 'Aktif', 'progress' => 80],
    ];
@endphp

<div class="space-y-6 pb-10">

    <!-- Header Banner -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4 relative overflow-hidden">
        <div class="flex items-center space-x-3.5 relative z-10">
            <!-- Box Ikon Rounded Lembut -->
            <div class="w-12 h-12 rounded-2xl bg-emerald-100/70 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-chart-pie"></i>
            </div>
            
            <!-- Teks Judul & Deskripsi Sub-Header -->
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-tight">
                    Laporan & Statistik
                </h1>
                <p class="text-xs text-slate-400 font-normal mt-0.5">
                    Pantau aktivitas belajar di platform LearnDL secara menyeluruh.
                </p>
            </div>
        </div>
        <!-- Illustrative Badge Decoration (Hijau Emerald) -->
        <div class="flex items-center space-x-2 relative z-10">
            <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fa-solid fa-users-gear text-sm"></i>
            </div>
        </div>
    </div>

    <!-- 5 Stat Cards Baris Atas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
        @foreach($stats as $st)
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">{{ $st['label'] }}</p>
                    <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $st['count'] }}</h3>
                    <p class="text-[10px] text-emerald-600 font-bold mt-1 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-up"></i> {{ $st['growth'] }} <span class="text-slate-400 font-normal">dari bulan lalu</span>
                    </p>
                </div>
                <div class="w-10 h-10 rounded-2xl {{ $st['bg'] }} {{ $st['text'] }} flex items-center justify-center text-base">
                    <i class="fa-solid {{ $st['icon'] }}"></i>
                </div>
            </div>
        @endforeach
    </div>


    <!-- Grid 3 Kolom Middle Section (Ruang Terpopuler, Donut Chart, Aktivitas Terbaru) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">

        <!-- 1. Ruang Belajar Terpopuler (4 Kolom) -->
        <div class="lg:col-span-4 bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-900 tracking-tight">Ruang Belajar Terpopuler</h3>
                <a href="#" class="text-[11px] text-purple-600 font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @foreach($ruangPopular as $rp)
                    <div class="flex items-center justify-between p-2 hover:bg-slate-50 rounded-2xl transition">
                        <div class="flex items-center space-x-3">
                            <span class="text-xs font-bold text-slate-400 w-4 text-center">{{ $rp['rank'] }}</span>
                            <div class="w-8 h-8 rounded-xl {{ $rp['bg'] }} text-white flex items-center justify-center text-xs">
                                <i class="fa-solid {{ $rp['icon'] }}"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-800 leading-tight">{{ $rp['title'] }}</h4>
                                <p class="text-[10px] text-slate-400">oleh {{ $rp['guru'] }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">{{ $rp['count'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- 2. Distribusi Enroll Siswa (4 Kolom) -->
        <div class="lg:col-span-4 bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <h3 class="text-xs font-bold text-slate-900 tracking-tight">Distribusi Enroll Siswa</h3>
            <div class="flex items-center justify-center relative py-2">
                <div class="w-44 h-44">
                    <canvas id="enrollChart"></canvas>
                </div>
            </div>
            <!-- Legend Text List -->
            <div class="grid grid-cols-2 gap-x-2 gap-y-1 text-[11px]">
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-purple-600 inline-block"></span> <span class="text-slate-600 truncate">Pemrograman Web</span></div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-indigo-500 inline-block"></span> <span class="text-slate-600 truncate">Matematika Diskrit</span></div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-emerald-400 inline-block"></span> <span class="text-slate-600 truncate">Desain Grafis</span></div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-amber-400 inline-block"></span> <span class="text-slate-600 truncate">Jaringan Komputer</span></div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-pink-500 inline-block"></span> <span class="text-slate-600 truncate">Bahasa Inggris</span></div>
                <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-sm bg-slate-300 inline-block"></span> <span class="text-slate-600 truncate">Lainnya</span></div>
            </div>
        </div>

        <!-- 3. Aktivitas Terbaru (4 Kolom) -->
        <div class="lg:col-span-4 bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-900 tracking-tight">Aktivitas Terbaru</h3>
                <a href="#" class="text-[11px] text-purple-600 font-semibold hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-3">
                @foreach($aktivitasTerbaru as $act)
                    <div class="flex items-start space-x-3 text-xs">
                        <div class="w-8 h-8 rounded-full {{ $act['bg'] }} text-white font-bold flex items-center justify-center text-[10px] flex-shrink-0">
                            {{ $act['initial'] }}
                        </div>
                        <div>
                            <p class="text-slate-700 text-[11px]">
                                <span class="font-bold text-slate-900">{{ $act['role'] }} {{ $act['user'] }}</span> {{ $act['action'] }} <span class="font-bold text-slate-900">{{ $act['target'] }}</span>
                            </p>
                            <span class="text-[10px] text-slate-400">{{ $act['time'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Data Enroll Siswa Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="text-xs font-bold text-slate-900 tracking-tight">Data Enroll Siswa</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                        <th class="p-3.5 pl-6">NO.</th>
                        <th class="p-3.5">SISWA</th>
                        <th class="p-3.5">RUANG BELAJAR</th>
                        <th class="p-3.5">GURU</th>
                        <th class="p-3.5">TANGGAL ENROLL</th>
                        <th class="p-3.5">STATUS</th>
                        <th class="p-3.5">PROGRESS</th>
                        <th class="p-3.5 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-600">
                    @foreach($enrollSiswa as $idx => $row)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 pl-6 font-semibold text-slate-400">{{ $idx + 1 }}</td>
                            <td class="p-3.5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-[10px]">
                                        {{ $row['initial'] }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 leading-tight">{{ $row['siswa'] }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $row['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3.5 font-semibold text-slate-800">{{ $row['ruang'] }}</td>
                            <td class="p-3.5 text-slate-500">{{ $row['guru'] }}</td>
                            <td class="p-3.5 text-slate-500">{{ $row['date'] }}</td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                            <td class="p-3.5">
                                <div class="flex items-center space-x-2 w-32">
                                    <span class="text-[10px] font-bold text-slate-500">{{ $row['progress'] }}%</span>
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $row['progress'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-600 text-[11px] font-bold rounded-xl transition">
                                        Lihat Detail
                                    </button>
                                    <button class="text-slate-400 hover:text-slate-600 p-1">
                                        <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Table Footer Pagination -->
        <div class="p-4 bg-white border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <div class="flex items-center space-x-1">
                <button class="px-2 py-1 bg-slate-100 rounded-lg text-slate-400"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                <button class="px-3 py-1 bg-purple-600 text-white font-bold rounded-lg">1</button>
                <button class="px-3 py-1 hover:bg-slate-100 rounded-lg">2</button>
                <button class="px-3 py-1 hover:bg-slate-100 rounded-lg">3</button>
                <button class="px-3 py-1 hover:bg-slate-100 rounded-lg">4</button>
                <button class="px-3 py-1 hover:bg-slate-100 rounded-lg">5</button>
                <span>...</span>
                <button class="px-3 py-1 hover:bg-slate-100 rounded-lg">14</button>
                <button class="px-2 py-1 bg-slate-100 rounded-lg text-slate-600"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
            </div>
            <span>10 / halaman</span>
        </div>
    </div>

</div>

<!-- Script Chart.js untuk Donut Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('enrollChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pemrograman Web', 'Matematika Diskrit', 'Desain Grafis', 'Jaringan Komputer', 'Bahasa Inggris', 'Lainnya'],
                datasets: [{
                    data: [48, 36, 28, 22, 18, 189],
                    backgroundColor: ['#9333ea', '#6366f1', '#34d399', '#fbbf24', '#ec4899', '#cbd5e1'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endsection