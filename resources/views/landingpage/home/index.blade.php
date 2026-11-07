
@extends('landingpage.layouts.app')

@section('title', 'LearnDL - Platform Pembelajaran Mendalam')

@section('content')

{{-- =========================================================
    1. METODE PEMBELAJARAN
========================================================= --}}
<section id="metode" class="relative overflow-hidden py-24 bg-purple-50/60 dark:bg-[#0c091f]/50 border-y border-purple-100 dark:border-purple-950/30 theme-transition">

    <div class="absolute -top-20 -left-20 w-80 h-80 bg-purple-500/10 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="max-w-3xl mx-auto text-center mb-16 space-y-4">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-600 dark:text-purple-300 text-xs font-bold">
                <i class="fa-solid fa-sparkles"></i>
                PENDEKATAN DEEP LEARNING
            </span>

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                Belajar Lebih Dalam,
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600">
                    Berpikir Lebih Kritis.
                </span>
            </h2>

            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-2xl mx-auto">
                Pengalaman pembelajaran yang membantu siswa memahami konsep,
                membangun kesadaran berpikir, dan menerapkan pengetahuan
                melalui aktivitas belajar yang bermakna.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Bermakna --}}
            <div class="group relative overflow-hidden bg-white dark:bg-[#120f24] p-8 rounded-3xl border border-purple-100 dark:border-white/5 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-2 transition-all duration-300">

                <div class="absolute -right-12 -top-12 w-36 h-36 rounded-full bg-purple-500/10 blur-2xl group-hover:scale-150 transition duration-500"></div>

                <div class="relative z-10 space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-500/15 text-purple-600 dark:text-purple-400 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <span class="text-[10px] font-bold tracking-widest text-purple-500 bg-purple-500/10 px-3 py-1.5 rounded-full">
                            PILAR 01
                        </span>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">
                            Pembelajaran Bermakna
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-7">
                            Menghubungkan materi pembelajaran dengan permasalahan
                            nyata sehingga siswa memahami konsep, tujuan,
                            dan penerapannya dalam kehidupan sehari-hari.
                        </p>
                    </div>

                    <div class="pt-5 border-t border-slate-100 dark:border-white/5 flex items-center gap-2 text-xs font-bold text-purple-600 dark:text-purple-400">
                        <i class="fa-solid fa-puzzle-piece"></i>
                        <span>Studi Kasus Kontekstual</span>
                    </div>
                </div>
            </div>

            {{-- Berkesadaran --}}
            <div class="group relative overflow-hidden bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 p-8 rounded-3xl text-white shadow-xl shadow-indigo-500/20 hover:-translate-y-2 transition-all duration-300">

                <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/10 blur-3xl"></div>

                <div class="relative z-10 space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur text-white flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-brain"></i>
                        </div>
                        <span class="text-[10px] font-bold tracking-widest text-white bg-white/15 px-3 py-1.5 rounded-full">
                            PILAR 02
                        </span>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xl font-extrabold">
                            Pembelajaran Berkesadaran
                        </h3>
                        <p class="text-xs text-blue-100 leading-7">
                            Mendorong siswa menyadari proses berpikirnya sendiri,
                            menganalisis kesalahan, mengevaluasi strategi,
                            dan menentukan langkah perbaikan.
                        </p>
                    </div>

                    <div class="pt-5 border-t border-white/15 flex items-center gap-2 text-xs font-bold text-blue-100">
                        <i class="fa-solid fa-magnifying-glass-chart"></i>
                        <span>Analisis dan Refleksi</span>
                    </div>
                </div>
            </div>

            {{-- Menggembirakan --}}
            <div class="group relative overflow-hidden bg-white dark:bg-[#120f24] p-8 rounded-3xl border border-purple-100 dark:border-white/5 shadow-sm hover:shadow-xl hover:shadow-pink-500/10 hover:-translate-y-2 transition-all duration-300">

                <div class="absolute -right-12 -top-12 w-36 h-36 rounded-full bg-pink-500/10 blur-2xl group-hover:scale-150 transition duration-500"></div>

                <div class="relative z-10 space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-pink-100 dark:bg-pink-500/15 text-pink-600 dark:text-pink-400 flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-gamepad"></i>
                        </div>
                        <span class="text-[10px] font-bold tracking-widest text-pink-500 bg-pink-500/10 px-3 py-1.5 rounded-full">
                            PILAR 03
                        </span>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white">
                            Pembelajaran Menggembirakan
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-7">
                            Menghadirkan tantangan interaktif, kuis,
                            aktivitas praktik, dan sistem penghargaan
                            untuk meningkatkan keterlibatan siswa.
                        </p>
                    </div>

                    <div class="pt-5 border-t border-slate-100 dark:border-white/5 flex items-center gap-2 text-xs font-bold text-pink-600 dark:text-pink-400">
                        <i class="fa-solid fa-trophy"></i>
                        <span>Gamifikasi dan Tantangan</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
    2. FITUR UNGGULAN
========================================================= --}}
<section id="fitur" class="relative overflow-hidden py-24">

    <div class="absolute top-1/3 right-0 w-96 h-96 bg-blue-500/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="max-w-3xl mx-auto text-center mb-16 space-y-4">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 text-xs font-bold">
                <i class="fa-solid fa-microchip"></i>
                FITUR UNGGULAN PLATFORM
            </span>

            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">
                Belajar Coding dengan
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                    Pengalaman Interaktif
                </span>
            </h2>

            <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">
                Setiap aktivitas dirancang untuk membantu siswa
                memahami materi, mencoba solusi, dan mengevaluasi hasil belajar.
            </p>
        </div>

        <div class="grid lg:grid-cols-12 gap-12 items-center">

            {{-- Penjelasan --}}
            <div class="lg:col-span-5 space-y-7">

                <div class="space-y-3">
                    <span class="text-[10px] font-extrabold text-blue-600 dark:text-blue-400 tracking-[0.2em] uppercase">
                        Interactive Learning Experience
                    </span>

                    <h3 class="text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                        Pahami Kesalahan,
                        Temukan Solusi,
                        <span class="text-indigo-600 dark:text-indigo-400">Bangun Logika.</span>
                    </h3>

                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-7">
                        Siswa tidak hanya memperoleh materi, tetapi juga
                        menghadapi tantangan yang mendorong mereka untuk
                        menganalisis masalah dan menemukan solusi secara mandiri.
                    </p>
                </div>

                {{-- Fitur 1 --}}
                <div class="flex gap-4 items-start">
                    <div class="w-11 h-11 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-code text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">
                            Latihan Pemrograman Interaktif
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-6">
                            Siswa menyusun kode dan menyelesaikan tantangan
                            sesuai instruksi yang diberikan.
                        </p>
                    </div>
                </div>

                {{-- Fitur 2 --}}
                <div class="flex gap-4 items-start">
                    <div class="w-11 h-11 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-lightbulb text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">
                            Petunjuk dan Umpan Balik
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-6">
                            Mendapatkan petunjuk saat jawaban belum tepat
                            sehingga siswa dapat memperbaiki pemahamannya.
                        </p>
                    </div>
                </div>

                {{-- Fitur 3 --}}
                <div class="flex gap-4 items-start">
                    <div class="w-11 h-11 rounded-xl bg-pink-500/10 text-pink-600 dark:text-pink-400 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">
                            Progres dan Pengalaman Belajar
                        </h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-6">
                            Memantau perkembangan aktivitas dan pencapaian
                            belajar melalui sistem XP dan level.
                        </p>
                    </div>
                </div>

            </div>

            {{-- Preview Editor Kode Tanpa Gambar --}}
            <div class="lg:col-span-7">

                <div class="relative">
                    <div class="absolute -inset-3 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 blur-2xl rounded-[2rem]"></div>

                    <div class="relative rounded-3xl overflow-hidden bg-[#111827] border border-slate-700 shadow-2xl">

                        {{-- Header Editor --}}
                        <div class="flex items-center justify-between px-5 py-4 bg-[#1e293b] border-b border-white/5">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-red-400"></span>
                                <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                                <span class="w-3 h-3 rounded-full bg-green-400"></span>
                            </div>

                            <div class="flex items-center gap-2 text-[10px] text-slate-400 font-mono">
                                <i class="fa-solid fa-code text-blue-400"></i>
                                latihan-percabangan.html
                            </div>

                            <span class="text-[10px] text-emerald-400 font-semibold">
                                <i class="fa-solid fa-circle text-[6px]"></i> Active
                            </span>
                        </div>

                        {{-- Editor --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2">

                            <div class="p-5 sm:p-6 border-b sm:border-b-0 sm:border-r border-white/5">
                                <div class="flex items-center justify-between mb-5">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                        Code Editor
                                    </span>
                                    <span class="text-[9px] text-slate-500">HTML</span>
                                </div>

                                <div class="font-mono text-xs leading-8 space-y-1">
                                    <div class="flex gap-4">
                                        <span class="text-slate-600">01</span>
                                        <span class="text-pink-400">&lt;!DOCTYPE html&gt;</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-slate-600">02</span>
                                        <span class="text-blue-300">&lt;html&gt;</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-slate-600">03</span>
                                        <span class="text-blue-300">&nbsp;&nbsp;&lt;body&gt;</span>
                                    </div>
                                    <div class="flex gap-4 bg-indigo-500/10 -mx-5 px-5 border-l-2 border-indigo-400">
                                        <span class="text-slate-600">04</span>
                                        <span class="text-purple-300">&nbsp;&nbsp;&nbsp;&nbsp;&lt;h1&gt;</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-slate-600">05</span>
                                        <span class="text-emerald-400">&nbsp;&nbsp;&nbsp;&nbsp;Hello World</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-slate-600">06</span>
                                        <span class="text-purple-300">&nbsp;&nbsp;&nbsp;&nbsp;&lt;/h1&gt;</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-slate-600">07</span>
                                        <span class="text-blue-300">&nbsp;&nbsp;&lt;/body&gt;</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <span class="text-slate-600">08</span>
                                        <span class="text-blue-300">&lt;/html&gt;</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Preview --}}
                            <div class="p-5 sm:p-6 bg-[#0b1120]">
                                <div class="flex items-center justify-between mb-5">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                        Live Preview
                                    </span>
                                    <i class="fa-solid fa-eye text-slate-500 text-xs"></i>
                                </div>

                                <div class="min-h-[220px] rounded-2xl bg-white flex flex-col items-center justify-center p-5 text-center">
                                    <div class="text-3xl font-extrabold text-slate-900">
                                        Hello World
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-3">
                                        Hasil tampilan kode HTML
                                    </p>
                                </div>

                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-2 text-[10px] text-emerald-400">
                                        <i class="fa-solid fa-circle-check"></i>
                                        Kode berhasil dijalankan
                                    </div>
                                    <span class="text-[9px] text-slate-500 font-mono">HTML OUTPUT</span>
                                </div>
                            </div>

                        </div>

                        {{-- Footer Editor --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 bg-[#1e293b] border-t border-white/5">
                            <span class="text-[10px] text-slate-400">
                                <i class="fa-solid fa-terminal mr-1"></i>
                                Output berhasil ditampilkan
                            </span>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 text-[10px] font-bold">
                                    <i class="fa-solid fa-check mr-1"></i> Success
                                </span>
                                <span class="px-3 py-1.5 rounded-lg bg-indigo-500 text-white text-[10px] font-bold">
                                    +25 XP
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
    3. SILABUS
========================================================= --}}
<section id="silabus" class="relative overflow-hidden py-24 bg-purple-50/60 dark:bg-[#0c091f]/50 border-y border-purple-100 dark:border-purple-950/30">

    <div class="max-w-5xl mx-auto px-6 lg:px-8 relative z-10">

        <div class="text-center mb-16 space-y-4">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-600 dark:text-purple-400 text-xs font-bold">
                <i class="fa-solid fa-book-open"></i>
                SILABUS PEMBELAJARAN
            </span>

            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">
                Materi Pembelajaran
            </h2>

            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
                Pelajari konsep pemrograman secara bertahap,
                mulai dari pengenalan hingga penerapan dalam menyelesaikan masalah.
            </p>
        </div>

        <div class="relative space-y-5">

            <div class="absolute left-7 top-8 bottom-8 w-px bg-gradient-to-b from-blue-500 via-purple-500 to-emerald-500 hidden sm:block"></div>

            {{-- Materi 1 --}}
            <div class="group relative flex items-center gap-5 bg-white dark:bg-[#120f24] p-5 sm:p-6 rounded-2xl border border-purple-100 dark:border-white/5 shadow-sm hover:shadow-lg hover:border-blue-400/50 transition">
                <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl shrink-0 relative z-10 shadow-lg shadow-blue-500/20">
                    <i class="fa-solid fa-code"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-[10px] font-bold text-blue-500 uppercase tracking-wider">Materi 01</span>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white mt-1">
                        Pengenalan Percabangan
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                        Memahami konsep dasar pengambilan keputusan dalam program.
                    </p>
                </div>
                <i class="fa-solid fa-arrow-right text-slate-300 group-hover:text-blue-500 group-hover:translate-x-1 transition"></i>
            </div>

            {{-- Materi 2 --}}
            <div class="group relative flex items-center gap-5 bg-white dark:bg-[#120f24] p-5 sm:p-6 rounded-2xl border border-purple-100 dark:border-white/5 shadow-sm hover:shadow-lg hover:border-purple-400/50 transition">
                <div class="w-14 h-14 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-xl shrink-0 relative z-10 shadow-lg shadow-purple-500/20">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-[10px] font-bold text-purple-500 uppercase tracking-wider">Materi 02</span>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white mt-1">
                        Fungsi dan Tujuan Percabangan
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                        Mengenali kegunaan percabangan dalam menyelesaikan permasalahan.
                    </p>
                </div>
                <i class="fa-solid fa-arrow-right text-slate-300 group-hover:text-purple-500 group-hover:translate-x-1 transition"></i>
            </div>

            {{-- Materi 3 --}}
            <div class="group relative flex items-center gap-5 bg-white dark:bg-[#120f24] p-5 sm:p-6 rounded-2xl border border-purple-100 dark:border-white/5 shadow-sm hover:shadow-lg hover:border-pink-400/50 transition">
                <div class="w-14 h-14 rounded-2xl bg-pink-600 text-white flex items-center justify-center text-xl shrink-0 relative z-10 shadow-lg shadow-pink-500/20">
                    <i class="fa-solid fa-diagram-project"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-[10px] font-bold text-pink-500 uppercase tracking-wider">Materi 03</span>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white mt-1">
                        Jenis-Jenis Percabangan
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                        Mempelajari bentuk percabangan tunggal, ganda, dan bersarang.
                    </p>
                </div>
                <i class="fa-solid fa-arrow-right text-slate-300 group-hover:text-pink-500 group-hover:translate-x-1 transition"></i>
            </div>

            {{-- Materi 4 --}}
            <div class="group relative flex items-center gap-5 bg-white dark:bg-[#120f24] p-5 sm:p-6 rounded-2xl border border-purple-100 dark:border-white/5 shadow-sm hover:shadow-lg hover:border-emerald-400/50 transition">
                <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl shrink-0 relative z-10 shadow-lg shadow-emerald-500/20">
                    <i class="fa-solid fa-terminal"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-wider">Materi 04</span>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white mt-1">
                        Aturan Penulisan Sintaks Percabangan
                    </h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                        Menerapkan sintaks percabangan dengan struktur kode yang benar.
                    </p>
                </div>
                <i class="fa-solid fa-arrow-right text-slate-300 group-hover:text-emerald-500 group-hover:translate-x-1 transition"></i>
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
    4. EVALUASI DAN DASHBOARD PREVIEW
========================================================= --}}
<section id="evaluasi" class="py-24 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-500/10 blur-[130px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 space-y-16">

        {{-- CTA Kuis --}}
        <div class="max-w-5xl mx-auto relative overflow-hidden bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 rounded-3xl p-8 sm:p-10 shadow-xl shadow-indigo-500/20">

            <div class="absolute -right-10 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-20 w-64 h-64 bg-pink-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">

                <div class="text-center sm:text-left space-y-3">
                    <span class="text-[10px] font-bold tracking-widest text-blue-100 uppercase">
                        Uji Pemahamanmu
                    </span>

                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white">
                        Siap Menghadapi Tantangan?
                    </h3>

                    <p class="text-xs text-blue-100 leading-relaxed max-w-lg">
                        Uji kemampuanmu melalui latihan dan evaluasi interaktif.
                        Temukan seberapa jauh pemahamanmu berkembang.
                    </p>
                </div>

                <div class="w-20 h-20 rounded-3xl bg-white/15 border border-white/20 flex items-center justify-center text-white text-4xl shrink-0 rotate-6">
                    <i class="fa-solid fa-gamepad"></i>
                </div>

            </div>
        </div>


        {{-- Dashboard dan Ranking --}}
        <div class="grid lg:grid-cols-12 gap-8 items-start">

            {{-- Dashboard Preview tanpa gambar --}}
            <div class="lg:col-span-7">

                <div class="bg-white dark:bg-[#120f24] p-5 sm:p-7 rounded-3xl border border-purple-100 dark:border-white/5 shadow-xl">

                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <div>
                            <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest">
                                Student Overview
                            </span>
                            <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mt-1">
                                Dashboard Pembelajaran
                            </h3>
                        </div>

                        <span class="px-3 py-1.5 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold">
                            <i class="fa-solid fa-circle text-[6px] mr-1"></i>
                            Live Preview
                        </span>
                    </div>

                    {{-- Welcome Card --}}
                    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 p-5 text-white mb-5">
                        <div class="absolute -right-5 -bottom-10 text-white/10 text-8xl">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>

                        <div class="relative z-10">
                            <p class="text-[10px] text-indigo-100 font-medium">SELAMAT DATANG KEMBALI</p>
                            <h4 class="text-xl font-extrabold mt-1">Halo, Pelajar Hebat! 👋</h4>
                            <p class="text-[10px] text-indigo-100 mt-2">
                                Terus belajar dan tingkatkan pencapaianmu.
                            </p>

                            <div class="mt-5 max-w-xs">
                                <div class="flex justify-between text-[10px] mb-2">
                                    <span>Progress Level 3</span>
                                    <span>64%</span>
                                </div>
                                <div class="h-2 bg-black/20 rounded-full overflow-hidden">
                                    <div class="h-full w-[64%] bg-amber-400 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Statistik --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">

                        <div class="p-3 rounded-xl bg-blue-50 dark:bg-blue-500/10">
                            <i class="fa-solid fa-book text-blue-500 text-sm"></i>
                            <p class="text-lg font-extrabold text-slate-900 dark:text-white mt-2">05</p>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400">Materi</p>
                        </div>

                        <div class="p-3 rounded-xl bg-purple-50 dark:bg-purple-500/10">
                            <i class="fa-solid fa-bolt text-purple-500 text-sm"></i>
                            <p class="text-lg font-extrabold text-slate-900 dark:text-white mt-2">320</p>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400">Total XP</p>
                        </div>

                        <div class="p-3 rounded-xl bg-pink-50 dark:bg-pink-500/10">
                            <i class="fa-solid fa-award text-pink-500 text-sm"></i>
                            <p class="text-lg font-extrabold text-slate-900 dark:text-white mt-2">03</p>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400">Badge</p>
                        </div>

                        <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10">
                            <i class="fa-solid fa-check-circle text-emerald-500 text-sm"></i>
                            <p class="text-lg font-extrabold text-slate-900 dark:text-white mt-2">08</p>
                            <p class="text-[9px] text-slate-500 dark:text-slate-400">Selesai</p>
                        </div>

                    </div>

                    {{-- Aktivitas --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-xs font-extrabold text-slate-900 dark:text-white">
                                Aktivitas Belajar
                            </h4>
                            <span class="text-[9px] text-indigo-500 font-bold">Lihat Semua</span>
                        </div>

                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-white/5">
                            <div class="w-9 h-9 rounded-lg bg-blue-500/10 text-blue-500 flex items-center justify-center">
                                <i class="fa-solid fa-code text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 dark:text-white">
                                    Pengenalan Percabangan
                                </p>
                                <p class="text-[9px] text-slate-400">Materi pembelajaran</p>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-500">Selesai</span>
                        </div>

                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-white/5">
                            <div class="w-9 h-9 rounded-lg bg-purple-500/10 text-purple-500 flex items-center justify-center">
                                <i class="fa-solid fa-puzzle-piece text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] font-bold text-slate-800 dark:text-white">
                                    Latihan Logika Program
                                </p>
                                <p class="text-[9px] text-slate-400">Tantangan interaktif</p>
                            </div>
                            <span class="text-[10px] font-bold text-indigo-500">Berjalan</span>
                        </div>

                    </div>
                </div>
            </div>


            {{-- Ranking --}}
            <div class="lg:col-span-5 bg-white dark:bg-[#120f24] p-6 rounded-3xl border border-purple-100 dark:border-white/5 shadow-sm">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-[10px] font-bold text-amber-500 uppercase tracking-widest">
                            Achievement
                        </span>
                        <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mt-1">
                            Ranking Siswa
                        </h3>
                    </div>

                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-500 flex items-center justify-center">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                </div>

                <div class="space-y-3">

                    {{-- Peringkat 1 --}}
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200/70 dark:border-amber-500/20">
                        <div class="w-9 h-9 rounded-xl bg-amber-400 text-white flex items-center justify-center font-extrabold">
                            1
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white">Ahmad Fauzi</p>
                            <p class="text-[9px] text-slate-500">X RPL 1</p>
                        </div>
                        <span class="text-xs font-extrabold text-amber-600 dark:text-amber-400">3.120 XP</span>
                    </div>

                    {{-- Peringkat 2 --}}
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50 dark:bg-white/5">
                        <div class="w-9 h-9 rounded-xl bg-slate-300 text-white flex items-center justify-center font-extrabold">
                            2
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white">Risa Amalia</p>
                            <p class="text-[9px] text-slate-500">X RPL 1</p>
                        </div>
                        <span class="text-xs font-extrabold text-slate-500">2.985 XP</span>
                    </div>

                    {{-- Peringkat 3 --}}
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-slate-50 dark:bg-white/5">
                        <div class="w-9 h-9 rounded-xl bg-orange-400 text-white flex items-center justify-center font-extrabold">
                            3
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white">Dimas Pratama</p>
                            <p class="text-[9px] text-slate-500">X RPL 1</p>
                        </div>
                        <span class="text-xs font-extrabold text-slate-500">2.750 XP</span>
                    </div>

                </div>

                <div class="mt-6 p-4 rounded-2xl bg-gradient-to-r from-indigo-500/10 to-purple-500/10 border border-indigo-500/10">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-medal text-2xl text-indigo-500"></i>
                        <div>
                            <p class="text-xs font-extrabold text-slate-900 dark:text-white">
                                Setiap usaha berarti!
                            </p>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">
                                Selesaikan aktivitas untuk mengumpulkan XP dan meningkatkan level.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
