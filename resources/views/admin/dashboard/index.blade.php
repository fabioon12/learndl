@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6 bg-slate-50 p-6 font-sans text-slate-800">

    <!-- Header / Banner Welcome (Hijau Emerald Cyber) -->
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 rounded-3xl p-6 md:p-8 text-white shadow-xl shadow-emerald-100 border border-emerald-100/20 font-sans">
        
        <!-- Pattern Dekoratif Latar Belakang (Glow & Bulatan Hijau) -->
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-cyan-400/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            
            <!-- Sisi Kiri: Teks & Informasi -->
            <div class="space-y-3 max-w-2xl">
                <!-- Badge Hari / Status -->
                <div class="inline-flex items-center space-x-2 bg-white/15 backdrop-blur-md px-3 py-1 rounded-full text-xs font-medium text-emerald-100 border border-white/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-300 animate-pulse"></span>
                    <span>System Online • {{ now()->translatedFormat('l, d F Y') }}</span>
                </div>

                <!-- Judul Ucapan -->
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    Selamat Datang Kembali, <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-200 to-emerald-200">{{ auth()->user()->fullname ?? 'Admin Utama' }}!</span> <span class="animate-wave">👋</span>
                </h1>

                <!-- Deskripsi Singkat -->
                <p class="text-emerald-100/90 text-sm sm:text-base leading-relaxed font-normal">
                    Pantau aktivitas platform, kelola data pengguna, dan pastikan seluruh sistem pembelajaran berjalan optimal hari ini.
                </p>

                <!-- Quick Action Tags / Ringkasan Cepat -->
                <div class="pt-2 flex flex-wrap gap-2 text-xs">
                    <span class="bg-white/10 hover:bg-white/20 transition px-3 py-1.5 rounded-lg font-medium text-white/90 border border-white/10 cursor-pointer">
                        <i class="fa-solid fa-bolt mr-1.5 text-amber-300"></i> Performance: 99.8%
                    </span>
                    <span class="bg-white/10 hover:bg-white/20 transition px-3 py-1.5 rounded-lg font-medium text-white/90 border border-white/10 cursor-pointer">
                        <i class="fa-solid fa-user-check mr-1.5 text-emerald-300"></i> 12 Pendataan Baru
                    </span>
                </div>
            </div>

            <!-- Sisi Kanan: Ilustrasi & Visual Card -->
            <div class="hidden lg:flex items-center justify-center relative flex-shrink-0">
                <!-- Lingkaran Glow di Belakang Ilustrasi -->
                <div class="absolute w-32 h-32 bg-white/20 rounded-full blur-xl"></div>
                
                <!-- Ilustrasi / Floating Banner Card -->
                <div class="relative bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 shadow-lg flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-tr from-teal-400 to-emerald-500 rounded-xl flex items-center justify-center text-white text-2xl shadow-md">
                        <i class="fa-solid fa-rocket"></i>
                    </div>
                    <div class="text-left pr-2">
                        <p class="text-xs text-emerald-100 font-medium">Status Server</p>
                        <p class="text-sm font-bold text-white">Sangat Optimal</p>
                        <span class="text-[10px] text-emerald-300 font-semibold flex items-center mt-0.5">
                            <i class="fa-solid fa-circle-check mr-1"></i> No Issues
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Ringkasan Platform Banner & Stats Card (Hijau Emerald) -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/10">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-white/20 rounded-lg">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <div>
                    <h2 class="font-bold text-lg">Ringkasan Platform</h2>
                    <p class="text-emerald-100 text-xs">Statistik dan aktivitas LearnDL secara keseluruhan</p>
                </div>
            </div>
            <div class="mt-4 sm:mt-0">
                <select class="bg-white/20 border border-white/30 text-white text-sm rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-white">
                    <option value="bulan-ini" class="text-slate-800">Bulan ini</option>
                    <option value="tahun-ini" class="text-slate-800">Tahun ini</option>
                </select>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1: Total Pengguna -->
            <div class="bg-white rounded-xl p-4 text-slate-800 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1">1.248</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs text-emerald-600 font-medium">
                    <i class="fa-solid fa-arrow-up mr-1"></i> 12%
                    <span class="text-slate-400 font-normal ml-1">Dibanding bulan lalu</span>
                </div>
            </div>

            <!-- Card 2: Guru Aktif -->
            <div class="bg-white rounded-xl p-4 text-slate-800 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Guru Aktif</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1">86</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs text-emerald-600 font-medium">
                    <i class="fa-solid fa-arrow-up mr-1"></i> 8%
                    <span class="text-slate-400 font-normal ml-1">Dibanding bulan lalu</span>
                </div>
            </div>

            <!-- Card 3: Materi Terpublikasi -->
            <div class="bg-white rounded-xl p-4 text-slate-800 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Materi Terpublikasi</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1">342</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs text-emerald-600 font-medium">
                    <i class="fa-solid fa-arrow-up mr-1"></i> 15%
                    <span class="text-slate-400 font-normal ml-1">Dibanding bulan lalu</span>
                </div>
            </div>

            <!-- Card 4: Aktivitas Platform -->
            <div class="bg-white rounded-xl p-4 text-slate-800 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Aktivitas Platform</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1">94%</h3>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-center text-xs text-emerald-600 font-medium">
                    <i class="fa-solid fa-arrow-up mr-1"></i> 6%
                    <span class="text-slate-400 font-normal ml-1">Uptime sistem</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Middle: Perlu Perhatian & Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Pertumbuhan Pengguna (Stacked Bar Chart) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm col-span-1">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-chart-simple text-purple-600"></i>
                    <h3 class="font-bold text-slate-800 text-sm">Pertumbuhan Pengguna</h3>
                </div>
                <a href="#" class="text-xs text-purple-600 hover:underline">Lihat Detail &rarr;</a>
            </div>
            <div class="h-48">
                <canvas id="userGrowthChart"></canvas>
            </div>
            <!-- Legend Chart -->
            <div class="flex justify-center items-center space-x-4 mt-4 text-xs text-slate-500">
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-purple-600 mr-1.5"></span> Siswa</span>
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-blue-500 mr-1.5"></span> Guru</span>
                <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-1.5"></span> Admin</span>
            </div>
        </div>

        <!-- Distribusi Pengguna (Doughnut Chart) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm col-span-1">
            <div class="flex items-center space-x-2 mb-4">
                <i class="fa-solid fa-rotate text-purple-600"></i>
                <h3 class="font-bold text-slate-800 text-sm">Distribusi Pengguna</h3>
            </div>
            <div class="flex items-center justify-between h-48">
                <div class="w-1/2 relative h-full flex items-center justify-center">
                    <canvas id="userDistributionChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-xs text-slate-400">Total</span>
                        <span class="text-sm font-bold text-slate-800">1.248</span>
                        <span class="text-[10px] text-slate-400">Pengguna</span>
                    </div>
                </div>
                <div class="w-1/2 pl-4 space-y-3 text-xs">
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                            <span class="font-semibold text-slate-700">Admin</span>
                        </div>
                        <p class="text-slate-400 pl-4">4 (0,3%)</p>
                    </div>
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <span class="font-semibold text-slate-700">Guru</span>
                        </div>
                        <p class="text-slate-400 pl-4">86 (6,9%)</p>
                    </div>
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="font-semibold text-slate-700">Siswa</span>
                        </div>
                        <p class="text-slate-400 pl-4">1.158 (92,8%)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perlu Perhatian -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm col-span-1">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500"></i>
                    <h3 class="font-bold text-slate-800 text-sm">Perlu Perhatian</h3>
                </div>
                <a href="#" class="text-xs text-purple-600 hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="space-y-3">
                <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                            <i class="fa-solid fa-user-gear text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">12 akun menunggu verifikasi</p>
                            <p class="text-[11px] text-slate-400">Pengguna baru perlu diverifikasi oleh admin</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>

                <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                            <i class="fa-solid fa-file-circle-exclamation text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">8 materi belum ditinjau</p>
                            <p class="text-[11px] text-slate-400">Materi menunggu persetujuan publikasi</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>

                <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-rose-100 text-rose-600 rounded-lg">
                            <i class="fa-solid fa-users-slash text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-800">3 kelas belum memiliki guru</p>
                            <p class="text-[11px] text-slate-400">Segera tetapkan guru untuk kelas tersebut</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Section Bottom: Manajemen Konten, Status Sistem, & Aktivitas Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Manajemen Konten & Status Sistem (Left 2 Columns) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Manajemen Konten Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-layer-group text-purple-600"></i>
                        <h3 class="font-bold text-slate-800 text-sm">Manajemen Konten</h3>
                    </div>
                    <a href="#" class="text-xs text-purple-600 hover:underline">Lihat Semua &rarr;</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                    <div class="bg-purple-50/50 p-3 rounded-xl border border-purple-100 flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                            <i class="fa-solid fa-book text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Materi</p>
                            <h4 class="font-bold text-slate-800 text-base">342</h4>
                            <p class="text-[10px] text-slate-400">Total materi terpublikasi</p>
                        </div>
                    </div>

                    <div class="bg-blue-50/50 p-3 rounded-xl border border-blue-100 flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                            <i class="fa-solid fa-file-lines text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Draft</p>
                            <h4 class="font-bold text-slate-800 text-base">18</h4>
                            <p class="text-[10px] text-slate-400">Menunggu publikasi</p>
                        </div>
                    </div>

                    <div class="bg-amber-50/50 p-3 rounded-xl border border-amber-100 flex items-center space-x-3">
                        <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                            <i class="fa-solid fa-clock text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Menunggu Tinjauan</p>
                            <h4 class="font-bold text-slate-800 text-base">8</h4>
                            <p class="text-[10px] text-slate-400">Perlu persetujuan admin</p>
                        </div>
                    </div>
                </div>

                <a href="#" class="w-full py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium text-xs rounded-xl flex items-center justify-center space-x-2 shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Kelola Materi &rarr;</span>
                </a>
            </div>

            <!-- Status Sistem Card -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-shield-halved text-purple-600"></i>
                        <h3 class="font-bold text-slate-800 text-sm">Status Sistem</h3>
                    </div>
                    <a href="#" class="text-xs text-purple-600 hover:underline">Lihat Detail &rarr;</a>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            <div>
                                <p class="text-xs font-semibold text-slate-800">Server berjalan normal</p>
                                <p class="text-[10px] text-slate-400">Semua layanan aktif</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-server text-slate-300"></i>
                    </div>

                    <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl">
                        <div class="flex items-center space-x-3">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            <div>
                                <p class="text-xs font-semibold text-slate-800">Database aktif</p>
                                <p class="text-[10px] text-slate-400">Koneksi stabil</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-database text-slate-300"></i>
                    </div>

                    <div class="p-2.5 bg-slate-50 rounded-xl">
                        <div class="flex items-center justify-between mb-1.5">
                            <div class="flex items-center space-x-3">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                <span class="text-xs font-semibold text-slate-800">Penyimpanan</span>
                            </div>
                            <span class="text-xs font-bold text-slate-600">68%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-1.5">
                            <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 68%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Aktivitas Terbaru (Right Column) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm col-span-1">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-bolt text-purple-600"></i>
                    <h3 class="font-bold text-slate-800 text-sm">Aktivitas Terbaru</h3>
                </div>
                <a href="#" class="text-xs text-purple-600 hover:underline">Lihat Semua &rarr;</a>
            </div>

            <div class="space-y-4">
                <!-- Item 1 -->
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-blue-50 text-blue-500 rounded-lg mt-0.5">
                            <i class="fa-solid fa-video text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Guru menambahkan materi</p>
                            <p class="text-[11px] text-slate-500">Video Pembelajaran Interaktif</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">2 menit yang lalu</span>
                </div>

                <!-- Item 2 -->
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-blue-50 text-blue-500 rounded-lg mt-0.5">
                            <i class="fa-solid fa-user-check text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Akun guru diverifikasi</p>
                            <p class="text-[11px] text-slate-500">Siti Nurhaliza, S.Pd</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">12 menit yang lalu</span>
                </div>

                <!-- Item 3 -->
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-rose-50 text-rose-500 rounded-lg mt-0.5">
                            <i class="fa-solid fa-chalkboard-user text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Kelas baru dibuat</p>
                            <p class="text-[11px] text-slate-500">Kelas 7A - SMP Negeri 01</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">25 menit yang lalu</span>
                </div>

                <!-- Item 4 -->
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-blue-50 text-blue-500 rounded-lg mt-0.5">
                            <i class="fa-solid fa-file-pen text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Materi diperbarui</p>
                            <p class="text-[11px] text-slate-500">Desain Pembelajaran Digital</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">1 jam yang lalu</span>
                </div>

                <!-- Item 5 -->
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="p-2 bg-purple-50 text-purple-500 rounded-lg mt-0.5">
                            <i class="fa-solid fa-user-plus text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Akun siswa terdaftar</p>
                            <p class="text-[11px] text-slate-500">Budi Santoso</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-400 whitespace-nowrap">2 jam yang lalu</span>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Chart Pertumbuhan Pengguna (Stacked Bar Chart)
    const ctxGrowth = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(ctxGrowth, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [
                {
                    label: 'Siswa',
                    data: [300, 350, 400, 450, 500, 550],
                    backgroundColor: '#9333ea',
                },
                {
                    label: 'Guru',
                    data: [200, 250, 220, 270, 300, 320],
                    backgroundColor: '#3b82f6',
                },
                {
                    label: 'Admin',
                    data: [350, 380, 420, 430, 420, 450],
                    backgroundColor: '#10b981',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 300 } }
            }
        }
    });

    // 2. Chart Distribusi Pengguna (Doughnut Chart)
    const ctxDist = document.getElementById('userDistributionChart').getContext('2d');
    new Chart(ctxDist, {
        type: 'doughnut',
        data: {
            labels: ['Admin', 'Guru', 'Siswa'],
            datasets: [{
                data: [4, 86, 1158],
                backgroundColor: ['#9333ea', '#3b82f6', '#10b981'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection