@extends('guru.layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="space-y-6">

    <!-- Header Greeting -->
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
            Selamat datang, {{ auth()->user()->fullname ?? 'Bu Siti' }}! 👋
        </h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Pantau perkembangan belajar dan dampingi siswa mencapai potensi terbaiknya.
        </p>
    </div>

    <!-- Layout Grid Utama (Kiri 2 Kolom, Kanan 1 Kolom) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- ================= KANAN / Kiri-2-Kolom (Main Feed) ================= -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Banner Ringkasan Pembelajaran -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-500 p-6 text-white shadow-lg shadow-purple-500/10">
                <div class="flex items-center justify-between relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-extrabold">Ringkasan Pembelajaran</h2>
                            <p class="text-xs text-purple-100 mt-0.5">Belajar bermakna dimulai dari pendampingan yang tepat</p>
                        </div>
                    </div>
                    <select class="bg-white/10 backdrop-blur-md border border-white/20 text-white text-xs font-semibold rounded-xl px-3 py-1.5 focus:outline-none cursor-pointer">
                        <option class="text-gray-800">Minggu ini</option>
                        <option class="text-gray-800">Bulan ini</option>
                    </select>
                </div>
            </div>

            <!-- 4 Metric Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Card 1: Kelas Aktif -->
                <div class="p-4 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-3 hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950/30 text-blue-500 flex items-center justify-center">
                        <i class="fa-solid fa-users-rectangle"></i>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalRuangBelajar }}</span>
                            <i class="fa-solid fa-arrow-right text-xs text-gray-400"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1">Materi Aktif</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">Dari total {{ $totalRuangBelajar }} materi yang Anda buat</p>
                    </div>
                </div>

                <!-- Card 2: Total Siswa -->
                <div class="p-4 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-3 hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 text-emerald-500 flex items-center justify-center">
                        <i class="fa-solid fa-user-group"></i>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-gray-900 dark:text-white">186</span>
                            <i class="fa-solid fa-arrow-right text-xs text-gray-400"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1">Siswa</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">Total siswa di semua kelas</p>
                    </div>
                </div>

                <!-- Card 3: Tugas Perlu Dinilai -->
                <div class="p-4 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-3 hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/30 text-amber-500 flex items-center justify-center">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-gray-900 dark:text-white">24</span>
                            <i class="fa-solid fa-arrow-right text-xs text-gray-400"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1">Tugas Perlu Dinilai</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">Dari 48 tugas yang masuk</p>
                    </div>
                </div>

                <!-- Card 4: Rata-rata Progres -->
                <div class="p-4 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-3 hover:shadow-md transition">
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-950/30 text-purple-500 flex items-center justify-center">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-black text-gray-900 dark:text-white">78%</span>
                            <i class="fa-solid fa-arrow-right text-xs text-gray-400"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-800 dark:text-gray-200 mt-1">Rata-rata Progres</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">Penyelesaian materi oleh siswa</p>
                    </div>
                </div>
            </div>

            <!-- Mid Section Grid: Aktivitas Kelas & Kelas yang Dikelola -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Chart Aktivitas Kelas -->
                <div class="p-5 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-chart-simple text-indigo-500"></i> Aktivitas Kelas
                        </h3>
                        <div class="flex items-center gap-1 bg-gray-100 dark:bg-cyberdark-800 p-1 rounded-xl text-[10px] font-bold">
                            <button class="px-2 py-0.5 bg-indigo-600 text-white rounded-lg">7 Hari</button>
                            <button class="px-2 py-0.5 text-gray-500">30 Hari</button>
                            <button class="px-2 py-0.5 text-gray-500">Semester</button>
                        </div>
                    </div>

                    <!-- Legend Indikator -->
                    <div class="flex items-center gap-3 text-[10px] font-semibold text-gray-500">
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-indigo-500"></span> Materi</span>
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> Tugas</span>
                        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-purple-300"></span> Diskusi</span>
                    </div>

                    <!-- Bar Chart Simplified Visual (CSS Bar Grid) -->
                    <div class="h-40 flex items-end justify-between gap-2 pt-4 border-b border-gray-100 dark:border-pink-950/20 px-2">
                        <!-- Sen -->
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full max-w-[18px] bg-purple-300 h-[20%] rounded-t-sm"></div>
                            <div class="w-full max-w-[18px] bg-emerald-400 h-[30%]"></div>
                            <div class="w-full max-w-[18px] bg-indigo-500 h-[30%] rounded-b-sm"></div>
                            <span class="text-[9px] text-gray-400 mt-2">Sen</span>
                        </div>
                        <!-- Sel -->
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full max-w-[18px] bg-purple-300 h-[25%] rounded-t-sm"></div>
                            <div class="w-full max-w-[18px] bg-emerald-400 h-[35%]"></div>
                            <div class="w-full max-w-[18px] bg-indigo-500 h-[25%] rounded-b-sm"></div>
                            <span class="text-[9px] text-gray-400 mt-2">Sel</span>
                        </div>
                        <!-- Rab -->
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full max-w-[18px] bg-purple-300 h-[20%] rounded-t-sm"></div>
                            <div class="w-full max-w-[18px] bg-emerald-400 h-[25%]"></div>
                            <div class="w-full max-w-[18px] bg-indigo-500 h-[25%] rounded-b-sm"></div>
                            <span class="text-[9px] text-gray-400 mt-2">Rab</span>
                        </div>
                        <!-- Kam -->
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full max-w-[18px] bg-purple-300 h-[25%] rounded-t-sm"></div>
                            <div class="w-full max-w-[18px] bg-emerald-400 h-[30%]"></div>
                            <div class="w-full max-w-[18px] bg-indigo-500 h-[30%] rounded-b-sm"></div>
                            <span class="text-[9px] text-gray-400 mt-2">Kam</span>
                        </div>
                        <!-- Jum -->
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full max-w-[18px] bg-purple-300 h-[35%] rounded-t-sm"></div>
                            <div class="w-full max-w-[18px] bg-emerald-400 h-[40%]"></div>
                            <div class="w-full max-w-[18px] bg-indigo-500 h-[20%] rounded-b-sm"></div>
                            <span class="text-[9px] text-gray-400 mt-2">Jum</span>
                        </div>
                        <!-- Sab -->
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full max-w-[18px] bg-purple-300 h-[15%] rounded-t-sm"></div>
                            <div class="w-full max-w-[18px] bg-emerald-400 h-[25%]"></div>
                            <div class="w-full max-w-[18px] bg-indigo-500 h-[35%] rounded-b-sm"></div>
                            <span class="text-[9px] text-gray-400 mt-2">Sab</span>
                        </div>
                        <!-- Min -->
                        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                            <div class="w-full max-w-[18px] bg-purple-300 h-[20%] rounded-t-sm"></div>
                            <div class="w-full max-w-[18px] bg-emerald-400 h-[30%]"></div>
                            <div class="w-full max-w-[18px] bg-indigo-500 h-[30%] rounded-b-sm"></div>
                            <span class="text-[9px] text-gray-400 mt-2">Min</span>
                        </div>
                    </div>
                </div>

                <!-- Kelas yang Dikelola -->
                <div class="p-5 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap text-blue-500"></i> Kelas yang Dikelola
                        </h3>
                        <a href="#" class="text-[11px] font-bold text-indigo-500 hover:underline">Lihat Semua →</a>
                    </div>

                    <div class="space-y-3">
                        <!-- Item Kelas 1 -->
                        <div class="p-3.5 bg-gray-50/70 dark:bg-cyberdark-800/40 rounded-2xl border border-gray-100 dark:border-pink-950/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-500 text-white flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800 dark:text-white">X RPL 1</h4>
                                        <p class="text-[10px] text-gray-400">32 siswa</p>
                                    </div>
                                </div>
                                <div class="text-right flex items-center gap-3">
                                    <span class="px-2 py-0.5 text-[9px] font-extrabold text-emerald-600 bg-emerald-50 rounded-full">+320 XP</span>
                                    <a href="#" class="text-[10px] font-bold text-indigo-500 hover:underline">Lihat Kelas →</a>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-cyberdark-950 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 82%"></div>
                            </div>
                        </div>

                        <!-- Item Kelas 2 -->
                        <div class="p-3.5 bg-gray-50/70 dark:bg-cyberdark-800/40 rounded-2xl border border-gray-100 dark:border-pink-950/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-purple-500 text-white flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-box-archive"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800 dark:text-white">X RPL 2</h4>
                                        <p class="text-[10px] text-gray-400">31 siswa</p>
                                    </div>
                                </div>
                                <div class="text-right flex items-center gap-3">
                                    <span class="px-2 py-0.5 text-[9px] font-extrabold text-emerald-600 bg-emerald-50 rounded-full">+280 XP</span>
                                    <a href="#" class="text-[10px] font-bold text-indigo-500 hover:underline">Lihat Kelas →</a>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-cyberdark-950 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-purple-500 h-1.5 rounded-full" style="width: 76%"></div>
                            </div>
                        </div>

                        <!-- Item Kelas 3 -->
                        <div class="p-3.5 bg-gray-50/70 dark:bg-cyberdark-800/40 rounded-2xl border border-gray-100 dark:border-pink-950/20 space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-palette"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800 dark:text-white">X DKV 1</h4>
                                        <p class="text-[10px] text-gray-400">28 siswa</p>
                                    </div>
                                </div>
                                <div class="text-right flex items-center gap-3">
                                    <span class="px-2 py-0.5 text-[9px] font-extrabold text-emerald-600 bg-emerald-50 rounded-full">+240 XP</span>
                                    <a href="#" class="text-[10px] font-bold text-indigo-500 hover:underline">Lihat Kelas →</a>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-cyberdark-950 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 65%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tabel Tugas & Penilaian -->
            <div class="p-5 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-list text-indigo-500"></i> Tugas & Penilaian
                    </h3>
                    <select class="bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/40 text-gray-700 dark:text-gray-300 text-[11px] font-semibold rounded-xl px-3 py-1 focus:outline-none">
                        <option>Semua Kelas</option>
                        <option>X RPL 1</option>
                        <option>X DKV 1</option>
                    </select>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[11px]">
                        <thead>
                            <tr class="text-gray-400 uppercase border-b border-gray-100 dark:border-pink-950/20 text-[9px] font-bold">
                                <th class="pb-2">Tugas</th>
                                <th class="pb-2">Kelas</th>
                                <th class="pb-2">Terkumpul</th>
                                <th class="pb-2">Perlu Dinilai</th>
                                <th class="pb-2">Tenggat</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-pink-950/10">
                            <!-- Row 1 -->
                            <tr>
                                <td class="py-3 font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <i class="fa-solid fa-file-code text-blue-500"></i> Logika Pemrograman - Studi Kasus
                                </td>
                                <td class="py-3 text-gray-500">X RPL 1</td>
                                <td class="py-3 text-gray-600 font-bold">28 / 32</td>
                                <td class="py-3"><span class="w-5 h-5 rounded-full bg-red-500 text-white flex items-center justify-center font-bold text-[9px]">4</span></td>
                                <td class="py-3 text-gray-500">27 Okt 2025</td>
                                <td class="py-3"><span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded-md font-bold text-[9px]">Tenggat dekat</span></td>
                                <td class="py-3 text-right"><a href="#" class="text-indigo-500 font-bold hover:underline">Periksa →</a></td>
                            </tr>
                            <!-- Row 2 -->
                            <tr>
                                <td class="py-3 font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <i class="fa-solid fa-pen-nib text-orange-500"></i> Desain UI/UX - Project
                                </td>
                                <td class="py-3 text-gray-500">X DKV 1</td>
                                <td class="py-3 text-gray-600 font-bold">24 / 28</td>
                                <td class="py-3"><span class="w-5 h-5 rounded-full bg-red-500 text-white flex items-center justify-center font-bold text-[9px]">4</span></td>
                                <td class="py-3 text-gray-500">28 Okt 2025</td>
                                <td class="py-3"><span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded-md font-bold text-[9px]">Tenggat dekat</span></td>
                                <td class="py-3 text-right"><a href="#" class="text-indigo-500 font-bold hover:underline">Periksa →</a></td>
                            </tr>
                            <!-- Row 3 -->
                            <tr>
                                <td class="py-3 font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <i class="fa-solid fa-database text-purple-500"></i> Basis Data - Quiz
                                </td>
                                <td class="py-3 text-gray-500">X RPL 2</td>
                                <td class="py-3 text-gray-600 font-bold">30 / 31</td>
                                <td class="py-3"><span class="w-5 h-5 rounded-full bg-red-500 text-white flex items-center justify-center font-bold text-[9px]">1</span></td>
                                <td class="py-3 text-gray-500">30 Okt 2025</td>
                                <td class="py-3"><span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-md font-bold text-[9px]">Normal</span></td>
                                <td class="py-3 text-right"><a href="#" class="text-indigo-500 font-bold hover:underline">Periksa →</a></td>
                            </tr>
                            <!-- Row 4 -->
                            <tr>
                                <td class="py-3 font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <i class="fa-solid fa-laptop-code text-indigo-500"></i> Pemrograman Web - Tugas 2
                                </td>
                                <td class="py-3 text-gray-500">X RPL 1</td>
                                <td class="py-3 text-gray-600 font-bold">26 / 32</td>
                                <td class="py-3"><span class="w-5 h-5 rounded-full bg-red-500 text-white flex items-center justify-center font-bold text-[9px]">6</span></td>
                                <td class="py-3 text-gray-500">31 Okt 2025</td>
                                <td class="py-3"><span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-md font-bold text-[9px]">Normal</span></td>
                                <td class="py-3 text-right"><a href="#" class="text-indigo-500 font-bold hover:underline">Periksa →</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ================= KIRI / Sidebar Kanan (1 Kolom) ================= -->
        <div class="space-y-6">

            <!-- Card 1: Perlu Perhatian -->
            <div class="p-5 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Perlu Perhatian
                    </h3>
                    <a href="#" class="text-[11px] font-bold text-indigo-500 hover:underline">Lihat Semua →</a>
                </div>

                <div class="space-y-3">
                    <!-- Item Perhatian 1 -->
                    <div class="flex items-center justify-between p-2.5 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 rounded-2xl transition">
                        <div class="flex items-center gap-3">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Ahmad" alt="Avatar" class="w-9 h-9 rounded-full bg-gray-100 object-cover">
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-white">Ahmad Fadli</h4>
                                <p class="text-[10px] text-gray-400">X RPL 1</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 bg-rose-50 text-rose-500 rounded-md text-[9px] font-extrabold">★ Belum mengumpulkan tugas</span>
                            <p class="text-[9px] text-gray-400 mt-0.5">Tugas: Logika Pemrograman</p>
                        </div>
                    </div>

                    <!-- Item Perhatian 2 -->
                    <div class="flex items-center justify-between p-2.5 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 rounded-2xl transition">
                        <div class="flex items-center gap-3">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Salsa" alt="Avatar" class="w-9 h-9 rounded-full bg-gray-100 object-cover">
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-white">Salsa Aulia</h4>
                                <p class="text-[10px] text-gray-400">X DKV 1</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded-md text-[9px] font-extrabold">★ Progres belajar menurun</span>
                            <p class="text-[9px] text-gray-400 mt-0.5">Progress: 45%</p>
                        </div>
                    </div>

                    <!-- Item Perhatian 3 -->
                    <div class="flex items-center justify-between p-2.5 hover:bg-gray-50 dark:hover:bg-cyberdark-800/60 rounded-2xl transition">
                        <div class="flex items-center gap-3">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Rizky" alt="Avatar" class="w-9 h-9 rounded-full bg-gray-100 object-cover">
                            <div>
                                <h4 class="text-xs font-bold text-gray-800 dark:text-white">Rizky Maulana</h4>
                                <p class="text-[10px] text-gray-400">X RPL 2</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-500 rounded-md text-[9px] font-extrabold">★ Perlu bimbingan</span>
                            <p class="text-[9px] text-gray-400 mt-0.5">Nilai rata-rata: 68</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Pencapaian Siswa (Badges) -->
            <div class="p-5 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-trophy text-amber-500"></i> Pencapaian Siswa
                        </h3>
                        <p class="text-[10px] text-gray-400 mt-0.5">12 badge diraih minggu ini</p>
                    </div>
                    <a href="#" class="text-[11px] font-bold text-indigo-500 hover:underline">Lihat Semua →</a>
                </div>

                <!-- Badge Items Grid -->
                <div class="grid grid-cols-4 gap-2 text-center pt-2">
                    <div class="flex flex-col items-center gap-1">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-amber-400 to-amber-300 text-white flex items-center justify-center shadow-md shadow-amber-500/20 text-lg">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="text-[9px] font-extrabold text-gray-700 dark:text-gray-300 leading-tight mt-1">Penyelesaian Materi</span>
                        <span class="text-[9px] text-gray-400">5 siswa</span>
                    </div>

                    <div class="flex flex-col items-center gap-1">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-blue-500 to-indigo-500 text-white flex items-center justify-center shadow-md shadow-blue-500/20 text-lg">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <span class="text-[9px] font-extrabold text-gray-700 dark:text-gray-300 leading-tight mt-1">Tugas Tepat Waktu</span>
                        <span class="text-[9px] text-gray-400">4 siswa</span>
                    </div>

                    <div class="flex flex-col items-center gap-1">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-purple-500 to-pink-500 text-white flex items-center justify-center shadow-md shadow-purple-500/20 text-lg">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <span class="text-[9px] font-extrabold text-gray-700 dark:text-gray-300 leading-tight mt-1">Aktif Diskusi</span>
                        <span class="text-[9px] text-gray-400">3 siswa</span>
                    </div>

                    <div class="flex flex-col items-center gap-1">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white flex items-center justify-center shadow-md shadow-emerald-500/20 text-lg">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <span class="text-[9px] font-extrabold text-gray-700 dark:text-gray-300 leading-tight mt-1">Kolaboratif</span>
                        <span class="text-[9px] text-gray-400">2 siswa</span>
                    </div>
                </div>
            </div>

            <!-- Card 3: Agenda Hari Ini -->
            <div class="p-5 bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-purple-500"></i> Agenda Hari Ini
                    </h3>
                    <a href="#" class="text-[11px] font-bold text-indigo-500 hover:underline">Lihat Semua →</a>
                </div>

                <!-- Timeline Items -->
                <div class="space-y-4 pl-2 relative before:absolute before:left-3.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-100 dark:before:bg-cyberdark-800">
                    <!-- Timeline 1 -->
                    <div class="flex items-start gap-4 relative">
                        <div class="w-3 h-3 rounded-full bg-purple-500 ring-4 ring-purple-100 dark:ring-purple-950 mt-1 shrink-0 z-10"></div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400">08:00 - 09:00</span>
                            <h4 class="text-xs font-bold text-gray-800 dark:text-white">Diskusi Kelas X RPL 1</h4>
                            <p class="text-[10px] text-gray-400">Topik: Array dan Perulangan</p>
                        </div>
                    </div>

                    <!-- Timeline 2 -->
                    <div class="flex items-start gap-4 relative">
                        <div class="w-3 h-3 rounded-full bg-blue-500 ring-4 ring-blue-100 dark:ring-blue-950 mt-1 shrink-0 z-10"></div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400">10:00 - 11:30</span>
                            <h4 class="text-xs font-bold text-gray-800 dark:text-white">Penilaian Tugas Logika Pemrograman</h4>
                            <p class="text-[10px] text-gray-400">Kelas X RPL 2</p>
                        </div>
                    </div>

                    <!-- Timeline 3 -->
                    <div class="flex items-start gap-4 relative">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100 dark:ring-emerald-950 mt-1 shrink-0 z-10"></div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400">13:00 - 14:00</span>
                            <h4 class="text-xs font-bold text-gray-800 dark:text-white">Refleksi Pembelajaran</h4>
                            <p class="text-[10px] text-gray-400">Kelas X DKV 1</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection