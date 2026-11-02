@extends('guru.layouts.app')

@section('title', 'Aktivitas Materi')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6 space-y-6" x-data="{
    kegiatanAwal: { aktif: true, berkesadaran: true },
    kegiatanInti: { aktif: true, bermakna: true, berkesadaran: true, menggembirakan: true },
    kegiatanPenutup: { aktif: true, berkesadaran: true, bermakna: true, menggembirakan: true }
}">

    <!-- Header & Navigation -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 hover:text-indigo-600 transition mb-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Pengaturan Pembelajaran
            </a>
            <h1 class="text-xl font-black text-gray-900 dark:text-white">Pengaturan Pembelajaran Mendalam</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                Atur penerapan tiga prinsip pembelajaran mendalam dalam setiap tahapan petualangan belajar. Gunakan fitur di bawah ini untuk menyesuaikan aktivitas, konten, dan pengalaman belajar siswa.
            </p>
        </div>
    </div>

    <!-- Layout Utama Grid (Left Content + Right Preview Sidebar) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- ================= LEFT COLUMN: MAIN CONTENT (2 COLUMNS) ================= -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Banner / Hero Card -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-500 via-indigo-500 to-sky-400 p-6 text-white shadow-lg">
                <div class="relative z-10 max-w-md">
                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-bold tracking-wide uppercase mb-2">
                        Prinsip Utama
                    </span>
                    <h2 class="text-lg font-black leading-snug">
                        Belajar bukan sekadar tujuan, tapi petualangan untuk masa depan!
                    </h2>
                </div>
                <div class="absolute -right-4 -bottom-6 opacity-20 md:opacity-40 pointer-events-none">
                    <i class="fa-solid fa-mountain-sun text-9xl"></i>
                </div>
            </div>

            <!-- Tiga Pilar Indikator Quick Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <!-- Berkesadaran -->
                <div class="p-3.5 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-500 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md shadow-purple-500/20">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-purple-900 dark:text-purple-300">Berkesadaran</h4>
                        <p class="text-[10px] text-purple-700/70 dark:text-purple-400">Meningkatkan kesadaran diri dalam belajar</p>
                    </div>
                </div>

                <!-- Bermakna -->
                <div class="p-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md shadow-emerald-500/20">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-emerald-900 dark:text-emerald-300">Bermakna</h4>
                        <p class="text-[10px] text-emerald-700/70 dark:text-emerald-400">Mengaitkan dengan kehidupan nyata</p>
                    </div>
                </div>

                <!-- Menggembirakan -->
                <div class="p-3.5 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md shadow-amber-500/20">
                        <i class="fa-solid fa-face-smile"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-amber-900 dark:text-amber-300">Menggembirakan</h4>
                        <p class="text-[10px] text-amber-700/70 dark:text-amber-400">Menciptakan pengalaman menyenangkan</p>
                    </div>
                </div>
            </div>

            <!-- ================= SECTION 1: KEGIATAN AWAL ================= -->
            <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 md:p-6 shadow-sm space-y-4">
                <!-- Header Card -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-gray-100 dark:border-pink-950/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-brain"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-black text-gray-900 dark:text-white">Kegiatan Awal</h3>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-purple-500/10 text-purple-600">Tahap Persiapan</span>
                            </div>
                            <p class="text-[11px] text-gray-400">Membangun fokus, motivasi, dan kesiapan belajar siswa sebelum memulai petualangan.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-purple-500/10 text-purple-600 border border-purple-500/20">
                            <i class="fa-solid fa-brain text-[8px] mr-1"></i>Berkesadaran
                        </span>
                        <div class="flex items-center gap-2 border-l border-gray-200 dark:border-pink-950/30 pl-3">
                            <span class="text-xs font-extrabold text-emerald-600">Aktif</span>
                            <button type="button" @click="kegiatanAwal.aktif = !kegiatanAwal.aktif" :class="kegiatanAwal.aktif ? 'bg-emerald-500' : 'bg-gray-300'" class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="kegiatanAwal.aktif ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Body Content: Fitur & Contoh Aktivitas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <!-- Fitur Yang Tersedia -->
                    <div class="space-y-2">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-gray-400">Fitur yang Tersedia</h5>
                        <ul class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-purple-500 text-sm"></i> Tujuan pembelajaran & pertanyaan pemantik</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-purple-500 text-sm"></i> Asesmen awal / pre-test</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-purple-500 text-sm"></i> Pengaturan target pribadi</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-purple-500 text-sm"></i> Refleksi awal (jurnal belajar)</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-purple-500 text-sm"></i> Ice breaking / pemanasan</li>
                        </ul>
                    </div>

                    <!-- Contoh Aktivitas -->
                    <div class="space-y-2">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-gray-400">Contoh Aktivitas</h5>
                        <div class="p-3.5 rounded-2xl bg-purple-500/5 border border-purple-500/10 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-purple-500 text-white flex items-center justify-center text-xs shrink-0 mt-0.5">
                                <i class="fa-solid fa-clipboard-question"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h6 class="text-xs font-bold text-gray-900 dark:text-white">Refleksi Diri: Apa yang Sudah Saya Ketahui?</h6>
                                <p class="text-[10px] text-gray-500 leading-relaxed mt-0.5">Siswa menuliskan apa yang sudah mereka ketahui, apa yang ingin mereka pelajari, dan harapan mereka pada akhir pembelajaran.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-md bg-purple-500/10 text-purple-600">Refleksi</span>
                                    <button type="button" class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Detail →</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SECTION 2: KEGIATAN INTI ================= -->
            <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 md:p-6 shadow-sm space-y-4">
                <!-- Header Card -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-gray-100 dark:border-pink-950/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-black text-gray-900 dark:text-white">Kegiatan Inti</h3>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-600">Tahap Eksplorasi & Aksi</span>
                            </div>
                            <p class="text-[11px] text-gray-400">Siswa menggali materi, memecahkan masalah, dan menerapkan pengetahuan.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600"><i class="fa-solid fa-leaf mr-1"></i>Bermakna</span>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-purple-500/10 text-purple-600"><i class="fa-solid fa-brain mr-1"></i>Berkesadaran</span>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-600"><i class="fa-solid fa-face-smile mr-1"></i>Menggembirakan</span>
                        <div class="flex items-center gap-2 border-l border-gray-200 dark:border-pink-950/30 pl-2">
                            <button type="button" @click="kegiatanInti.aktif = !kegiatanInti.aktif" :class="kegiatanInti.aktif ? 'bg-emerald-500' : 'bg-gray-300'" class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="kegiatanInti.aktif ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Body Content -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div class="space-y-2">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-gray-400">Fitur yang Tersedia</h5>
                        <ul class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-emerald-500 text-sm"></i> Studi kasus / masalah kontekstual</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-emerald-500 text-sm"></i> Simulasi / eksperimen interaktif</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-emerald-500 text-sm"></i> Proyek / tugas penerapan</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-emerald-500 text-sm"></i> Koneksi antar bidang ilmu</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-emerald-500 text-sm"></i> Diskusi kolaboratif</li>
                        </ul>
                    </div>

                    <div class="space-y-2">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-gray-400">Contoh Aktivitas</h5>
                        <div class="p-3.5 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs shrink-0 mt-0.5">
                                <i class="fa-solid fa-lightbulb"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h6 class="text-xs font-bold text-gray-900 dark:text-white">Proyek Mini: Solusi untuk Lingkungan Sekolah</h6>
                                <p class="text-[10px] text-gray-500 leading-relaxed mt-0.5">Siswa merancang solusi sederhana berbasis teknologi untuk mengurangi sampah di sekolah. Mereka bekerja berkelompok dan mempresentasikannya.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex gap-1">
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-600">Proyek</span>
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-md bg-indigo-500/10 text-indigo-600">Kolaborasi</span>
                                    </div>
                                    <button type="button" class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Detail →</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SECTION 3: KEGIATAN PENUTUP ================= -->
            <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 md:p-6 shadow-sm space-y-4">
                <!-- Header Card -->
                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-gray-100 dark:border-pink-950/20">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg font-bold">
                            <i class="fa-solid fa-flag-checkered"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-black text-gray-900 dark:text-white">Kegiatan Penutup</h3>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-600">Tahap Refleksi & Evaluasi</span>
                            </div>
                            <p class="text-[11px] text-gray-400">Menguatkan pemahaman, merayakan pencapaian, dan menumbuhkan motivasi belajar lanjut.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-purple-500/10 text-purple-600"><i class="fa-solid fa-brain mr-1"></i>Berkesadaran</span>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600"><i class="fa-solid fa-leaf mr-1"></i>Bermakna</span>
                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-600"><i class="fa-solid fa-face-smile mr-1"></i>Menggembirakan</span>
                        <div class="flex items-center gap-2 border-l border-gray-200 dark:border-pink-950/30 pl-2">
                            <button type="button" @click="kegiatanPenutup.aktif = !kegiatanPenutup.aktif" :class="kegiatanPenutup.aktif ? 'bg-emerald-500' : 'bg-gray-300'" class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span :class="kegiatanPenutup.aktif ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Body Content -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                    <div class="space-y-2">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-gray-400">Fitur yang Tersedia</h5>
                        <ul class="space-y-1.5 text-xs text-gray-600 dark:text-gray-300">
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-amber-500 text-sm"></i> Refleksi pembelajaran</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-amber-500 text-sm"></i> Kuis / evaluasi akhir</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-amber-500 text-sm"></i> Umpan balik dan apresiasi</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-amber-500 text-sm"></i> Pemberian XP, badge, dan sertifikat</li>
                            <li class="flex items-center gap-2"><i class="fa-solid fa-square-check text-amber-500 text-sm"></i> Rencana belajar lanjutan</li>
                        </ul>
                    </div>

                    <div class="space-y-2">
                        <h5 class="text-[10px] font-black uppercase tracking-wider text-gray-400">Contoh Aktivitas</h5>
                        <div class="p-3.5 rounded-2xl bg-amber-500/5 border border-amber-500/10 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs shrink-0 mt-0.5">
                                <i class="fa-solid fa-trophy"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h6 class="text-xs font-bold text-gray-900 dark:text-white">Ayo Refleksi: Apa yang Saya Pelajari?</h6>
                                <p class="text-[10px] text-gray-500 leading-relaxed mt-0.5">Siswa menjawab pertanyaan refleksi dan melihat perkembangan mereka selama menyelesaikan misi.</p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex gap-1">
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-md bg-amber-500/10 text-amber-600">Refleksi</span>
                                        <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-md bg-indigo-500/10 text-indigo-600">Evaluasi</span>
                                    </div>
                                    <button type="button" class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Detail →</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Floating Action Bar -->
            <div class="p-4 rounded-3xl bg-indigo-50 dark:bg-cyberdark-800 border border-indigo-100 dark:border-indigo-900/30 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-indigo-500 text-white flex items-center justify-center text-xs">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-300">
                        <span class="font-bold text-gray-900 dark:text-white">Tips untuk hasil maksimal:</span> Gunakan ketiga prinsip secara seimbang dalam setiap tahapan.
                    </p>
                </div>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-lg shadow-indigo-500/20 transition active:scale-95 flex items-center gap-2 shrink-0">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan
                </button>
            </div>

        </div>

        <!-- ================= RIGHT COLUMN: SIDEBAR PREVIEW & IMPACT ================= -->
        <div class="space-y-6">

            <!-- Card 1: Preview di Peta Petualangan -->
            <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-map"></i>
                        </div>
                        <h4 class="text-xs font-black text-gray-900 dark:text-white">Preview di Peta Petualangan</h4>
                    </div>
                    <a href="#" class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Lihat Semua →</a>
                </div>

                <!-- Preview Map Card Simulation -->
                <div class="p-4 rounded-2xl bg-gradient-to-b from-sky-50 to-indigo-50/50 dark:from-cyberdark-800 dark:to-cyberdark-900 border border-sky-100 dark:border-sky-900/20 text-center space-y-3">
                    <span class="text-[9px] font-bold uppercase tracking-wider text-indigo-600 bg-white dark:bg-cyberdark-800 px-3 py-1 rounded-full shadow-xs inline-block">
                        Contoh Tampilan di Petualangan
                    </span>

                    <!-- Floating Islands Progress Steps Preview -->
                    <div class="flex items-center justify-between px-2 pt-2">
                        <!-- Step 1: Berkesadaran -->
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-9 h-9 rounded-xl bg-purple-500 text-white flex items-center justify-center text-xs shadow-md shadow-purple-500/30 relative">
                                <i class="fa-solid fa-brain"></i>
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-indigo-600 text-[8px] font-bold rounded-full flex items-center justify-center text-white">1</span>
                            </div>
                            <span class="text-[9px] font-extrabold text-gray-700 dark:text-gray-300">Berkesadaran</span>
                            <span class="text-[8px] text-gray-400">Awal</span>
                        </div>

                        <div class="h-0.5 flex-1 bg-dashed border-b-2 border-indigo-300 mx-1"></div>

                        <!-- Step 2: Bermakna -->
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs shadow-md shadow-emerald-500/30 relative">
                                <i class="fa-solid fa-leaf"></i>
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-indigo-600 text-[8px] font-bold rounded-full flex items-center justify-center text-white">2</span>
                            </div>
                            <span class="text-[9px] font-extrabold text-gray-700 dark:text-gray-300">Bermakna</span>
                            <span class="text-[8px] text-gray-400">Inti</span>
                        </div>

                        <div class="h-0.5 flex-1 bg-dashed border-b-2 border-indigo-300 mx-1"></div>

                        <!-- Step 3: Menggembirakan -->
                        <div class="flex flex-col items-center gap-1">
                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs shadow-md shadow-amber-500/30 relative">
                                <i class="fa-solid fa-face-smile"></i>
                                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-indigo-600 text-[8px] font-bold rounded-full flex items-center justify-center text-white">3</span>
                            </div>
                            <span class="text-[9px] font-extrabold text-gray-700 dark:text-gray-300">Menggembirakan</span>
                            <span class="text-[8px] text-gray-400">Penutup</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Dampak yang Diharapkan -->
            <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 shadow-sm space-y-3">
                <div class="flex items-center gap-2 pb-2 border-b border-gray-100 dark:border-pink-950/20">
                    <div class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-gear"></i>
                    </div>
                    <h4 class="text-xs font-black text-gray-900 dark:text-white">Dampak yang Diharapkan</h4>
                </div>

                <div class="space-y-2.5 pt-1">
                    <!-- Impact 1 -->
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-purple-500/5 border border-purple-500/10">
                        <div class="w-8 h-8 rounded-xl bg-purple-500 text-white flex items-center justify-center text-xs shrink-0">
                            <i class="fa-solid fa-brain"></i>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-gray-800 dark:text-gray-200">Siswa Lebih Sadar</h5>
                            <p class="text-[10px] text-gray-400">Memahami tujuan, proses, dan perkembangan belajarnya.</p>
                        </div>
                    </div>

                    <!-- Impact 2 -->
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                        <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-xs shrink-0">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-gray-800 dark:text-gray-200">Siswa Lebih Bermakna</h5>
                            <p class="text-[10px] text-gray-400">Melihat relevansi materi dengan kehidupan nyata.</p>
                        </div>
                    </div>

                    <!-- Impact 3 -->
                    <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-amber-500/5 border border-amber-500/10">
                        <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xs shrink-0">
                            <i class="fa-solid fa-face-smile"></i>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-gray-800 dark:text-gray-200">Siswa Lebih Termotivasi</h5>
                            <p class="text-[10px] text-gray-400">Menikmati proses belajar dan menunjukkan peningkatan keterlibatan.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Banner Motivasi -->
            <div class="p-4 rounded-3xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-lg text-amber-300 shrink-0">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <div>
                    <h5 class="text-xs font-bold">Bersama Kita Ciptakan</h5>
                    <p class="text-[10px] text-indigo-100 leading-tight">Petualangan belajar yang bermakna, berkesadaran, dan menggembirakan!</p>
                </div>
            </div>

            <!-- Card 4: Template Aktivitas -->
            <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-2xl bg-purple-500/10 text-purple-600 flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-shapes"></i>
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-gray-900 dark:text-white">Template Aktivitas</h5>
                        <p class="text-[10px] text-gray-400">Gunakan template siap pakai untuk mempermudah pembuatan aktivitas.</p>
                    </div>
                </div>
                <button type="button" class="px-3 py-1.5 rounded-xl border border-gray-200 dark:border-pink-950/30 text-[10px] font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-cyberdark-800 transition shrink-0">
                    Kelola Template ›
                </button>
            </div>

        </div>

    </div>

</div>
@endsection