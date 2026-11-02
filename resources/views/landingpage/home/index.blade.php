@extends('landingpage.layouts.app')

@section('title', 'Landingpage - Learn DL')

@section('content')
    <section id="metode" class="py-24 bg-purple-50/50 dark:bg-[#0c091f]/40 border-y border-purple-100 dark:border-purple-950/30 theme-transition relative overflow-hidden">
        {{-- Hiasan Glow Latar Belakang --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-gradient-to-r from-purple-500/10 via-indigo-500/10 to-blue-500/10 blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 reveal-view relative z-10">
            {{-- Header Section --}}
            <div class="max-w-3xl mx-auto text-center mb-16 space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-purple-500/10 border border-purple-500/20 text-purple-600 dark:text-purple-300 text-xs font-semibold">
                    <i class="fa-solid fa-sparkles text-purple-500"></i>
                    <span>Pendekatan Deep Learning</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    3 Pilar Pengalaman Belajar
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    Dirancang khusus untuk membangun fondasi logika koding yang kuat, holistik, dan berkesan.
                </p>
            </div>

            {{-- Grid 3 Pilar --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- 1. Pembelajaran Bermakna --}}
                <div class="group bg-white dark:bg-[#120f24] p-8 rounded-3xl border border-purple-100 dark:border-white/5 flex flex-col justify-between min-h-[300px] shadow-sm hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-2 hover:border-purple-500/40 transition-all duration-300 theme-transition relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl group-hover:scale-150 transition duration-500"></div>
                    
                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                                <i class="fa-solid fa-lightbulb"></i>
                            </div>
                            <span class="text-[10px] font-mono font-bold text-purple-600 dark:text-purple-300 bg-purple-500/10 px-3 py-1 rounded-full uppercase tracking-wider">Pilar 01</span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition duration-300">
                            Pembelajaran Bermakna
                        </h3>
                        
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Menghubungkan konsep logika percabangan dengan studi kasus dunia nyata, sehingga siswa memahami fungsi konkret dan alasan di balik setiap baris kode.
                        </p>
                    </div>

                    <div class="pt-6 border-t border-slate-100 dark:border-white/5 flex items-center gap-2 text-xs font-semibold text-purple-600 dark:text-purple-400 relative z-10">
                        <span>Studi Kasus Kontekstual</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition duration-300"></i>
                    </div>
                </div>

                {{-- 2. Pembelajaran Berkesadaran --}}
                <div class="group bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 p-8 rounded-3xl text-white flex flex-col justify-between min-h-[300px] shadow-xl shadow-blue-500/20 hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                    <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-125 transition duration-500"></div>

                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-xl text-white backdrop-blur-md group-hover:scale-110 group-hover:bg-white group-hover:text-indigo-600 transition duration-300">
                                <i class="fa-solid fa-brain"></i>
                            </div>
                            <span class="text-[10px] font-mono font-bold text-blue-200 bg-white/10 px-3 py-1 rounded-full uppercase tracking-wider border border-white/10">Pilar 02</span>
                        </div>

                        <h3 class="text-xl font-bold text-white">
                            Pembelajaran Berkesadaran
                        </h3>
                        
                        <p class="text-xs text-blue-100/90 leading-relaxed">
                            Mendorong pemahaman metakognitif yang reflektif. Siswa diajak menyadari proses berpikirnya sendiri saat menganalisis alur logika dan menelusuri pesan error.
                        </p>
                    </div>

                    <div class="pt-6 border-t border-white/10 flex items-center gap-2 text-xs font-semibold text-blue-100 relative z-10">
                        <span>Analisis & Refleksi Logika</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition duration-300"></i>
                    </div>
                </div>

                {{-- 3. Pembelajaran Menggembirakan --}}
                <div class="group bg-white dark:bg-[#120f24] p-8 rounded-3xl border border-purple-100 dark:border-white/5 flex flex-col justify-between min-h-[300px] shadow-sm hover:shadow-xl hover:shadow-pink-500/10 hover:-translate-y-2 hover:border-pink-500/40 transition-all duration-300 theme-transition relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-pink-500/10 rounded-full blur-2xl group-hover:scale-150 transition duration-500"></div>

                    <div class="space-y-4 relative z-10">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-pink-500/10 text-pink-600 dark:text-pink-400 flex items-center justify-center text-xl shadow-inner group-hover:scale-110 group-hover:bg-pink-600 group-hover:text-white transition duration-300">
                                <i class="fa-solid fa-gamepad"></i>
                            </div>
                            <span class="text-[10px] font-mono font-bold text-pink-600 dark:text-pink-300 bg-pink-500/10 px-3 py-1 rounded-full uppercase tracking-wider">Pilar 03</span>
                        </div>

                        <h3 class="text-xl font-bold text-slate-900 dark:text-white group-hover:text-pink-600 dark:group-hover:text-pink-400 transition duration-300">
                            Pembelajaran Menggembirakan
                        </h3>
                        
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Menghadirkan pengalaman koding yang seru melalui tantangan interaktif, kuis adaptif, dan poin pencapaian saat siswa berhasil memecahkan tantangan program.
                        </p>
                    </div>

                    <div class="pt-6 border-t border-slate-100 dark:border-white/5 flex items-center gap-2 text-xs font-semibold text-pink-600 dark:text-pink-400 relative z-10">
                        <span>Gamifikasi & Kuis Adaptif</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition duration-300"></i>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 relative overflow-hidden">
        {{-- Hiasan Glow Latar Belakang --}}
        <div class="absolute top-1/2 right-10 -translate-y-1/2 w-[500px] h-[300px] bg-blue-500/10 blur-[130px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 reveal-view relative z-10">
            
            {{-- Judul Utama Section (Section Header) --}}
            <div class="max-w-3xl mx-auto text-center mb-16 space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 text-xs font-semibold">
                    <i class="fa-solid fa-microchip text-blue-500"></i>
                    <span>Fitur Unggulan Platform</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Umpan Balik Cerdas & Deteksi Eror
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    Fitur umpan balik untuk membantu siswa memahami dan memperbaiki eror logika secara mandiri.
                </p>
            </div>

            <div class="grid lg:grid-cols-12 gap-12 items-center">
                
                {{-- Penjelasan Fitur --}}
                <div class="lg:col-span-5 space-y-6">
                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase font-mono tracking-widest">Sistem Proteksi Logika</span>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                        Umpan Balik Pintar Saat Terjadi Logika Eror
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Saat kode program Anda mengalami eror logika, asisten cerdas berbasis *Deep Learning* kami menyajikan petunjuk taktis eksplisit (*error clues*) guna memacu kemandirian berpikir siswa.
                    </p>
                    
                    {{-- Box Alert Clue --}}
                    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex gap-3 items-start shadow-sm hover:border-red-500/40 transition theme-transition">
                        <div class="w-7 h-7 rounded-lg bg-red-500 text-white flex items-center justify-center text-xs mt-0.5 shrink-0">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="space-y-1">
                            <h4 class="text-xs font-bold text-red-600 dark:text-red-400">Logical Error Detected</h4>
                            <p class="text-[11px] text-slate-600 dark:text-slate-400 font-mono leading-relaxed">
                                Clue: Cek keselarasan operator perbandingan percabangan pada blok Nested If baris ke-4 Anda.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Terminal / Online Compiler Preview --}}
                <div class="lg:col-span-7">
                    <div class="bg-white dark:bg-[#120f24] rounded-2xl p-5 border border-purple-100 dark:border-white/5 shadow-xl neon-card-purple theme-transition">
                        <div class="flex items-center justify-between mb-3 border-b border-purple-50 dark:border-white/5 pb-3">
                            <div class="flex space-x-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                            </div>
                            <span class="text-[10px] font-mono text-slate-400 flex items-center gap-1">
                                <i class="fa-brands fa-python text-blue-500"></i> online_compiler_v2.py
                            </span>
                        </div>
                        
                        <div class="aspect-[16/10] bg-slate-950 rounded-xl p-5 flex flex-col justify-between font-mono text-xs shadow-inner">
                            <div class="space-y-1 text-purple-400">
                                <p class="text-slate-500"># Evaluasi Nilai Kritis</p>
                                <p><span class="text-pink-500">if</span> skor_siswa &gt;= <span class="text-amber-400">80</span>:</p>
                                <p class="pl-4 text-slate-300">status = <span class="text-emerald-400">"Problem Solved!"</span></p>
                            </div>
                            
                            <div class="border-t border-white/5 pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-slate-400 text-[11px]">
                                <span class="text-slate-500">Status: Menghitung Akurasi Percabangan...</span>
                                <div class="flex items-center gap-2.5 bg-white/5 px-3 py-1.5 rounded-lg text-purple-300">
                                    <div class="w-3.5 h-3.5 border-2 border-purple-500/30 border-t-purple-400 rounded-full animate-spin"></div>
                                    <span class="text-[10px] tracking-wide uppercase">Initializing Compiler...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="silabus" class="py-24 bg-purple-50/50 dark:bg-[#0c091f]/40 border-t border-purple-100 dark:border-purple-950/30 theme-transition">
        <div class="max-w-4xl mx-auto px-6 lg:px-8 reveal-view">
            <div class="text-center mb-16 space-y-2">
                <span class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase font-mono tracking-widest">Silabus Kurikulum</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">4 Pilar Pembelajaran Konten Materi</h2>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div class="bg-white dark:bg-[#120f24] p-5 rounded-2xl border border-purple-100 dark:border-white/5 flex gap-4 items-center shadow-sm hover:translate-x-1 transition duration-300 theme-transition">
                    <div class="bg-blue-600 text-white font-mono text-xs font-bold px-3 py-1 rounded-lg">Materi 1</div>
                    <span class="font-bold text-slate-900 dark:text-white text-sm">Pengenalan Percabangan</span>
                </div>
                <div class="bg-white dark:bg-[#120f24] p-5 rounded-2xl border border-purple-100 dark:border-white/5 flex gap-4 items-center shadow-sm hover:translate-x-1 transition duration-300 theme-transition">
                    <div class="bg-purple-600 text-white font-mono text-xs font-bold px-3 py-1 rounded-lg">Materi 2</div>
                    <span class="font-bold text-slate-900 dark:text-white text-sm">Fungsi dan Tujuan Percabangan</span>
                </div>
                <div class="bg-white dark:bg-[#120f24] p-5 rounded-2xl border border-purple-100 dark:border-white/5 flex gap-4 items-center shadow-sm hover:translate-x-1 transition duration-300 theme-transition">
                    <div class="bg-pink-600 text-white font-mono text-xs font-bold px-3 py-1 rounded-lg">Materi 3</div>
                    <span class="font-bold text-slate-900 dark:text-white text-sm">Jenis-Jenis Percabangan</span>
                </div>
                <div class="bg-white dark:bg-[#120f24] p-5 rounded-2xl border border-purple-100 dark:border-white/5 flex gap-4 items-center shadow-sm hover:translate-x-1 transition duration-300 theme-transition">
                    <div class="bg-emerald-600 text-white font-mono text-xs font-bold px-3 py-1 rounded-lg">Materi 4</div>
                    <span class="font-bold text-slate-900 dark:text-white text-sm">Aturan Penulisan (Sintaks) Percabangan</span>
                </div>
            </div>
        </div>
    </section>

    <section id="evaluasi" class="py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-16 reveal-view">
            
            <div class="max-w-4xl mx-auto bg-gradient-to-r from-purple-500/10 via-indigo-500/5 to-blue-500/10 dark:from-purple-900/30 dark:to-blue-900/30 border-2 border-purple-400/30 dark:border-purple-500/30 rounded-3xl p-6 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-md theme-transition">
                <div class="space-y-1 text-center sm:text-left">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white flex items-center justify-center sm:justify-start gap-2">
                        <i class="fa-solid fa-gamepad text-purple-600 dark:text-purple-400 text-base"></i> Kuis Interaktif & Adaptif
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-300">Sistem mengevaluasi pemahaman berkala Anda melalui tantangan berhadiah poin bintang.</p>
                </div>
                <button class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white text-xs font-bold px-5 py-3 rounded-xl whitespace-nowrap cursor-pointer shadow-md shadow-purple-500/20 hover:scale-102 transition duration-300">Mulai Kuis</button>
            </div>

            <div class="grid lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-7 bg-white dark:bg-[#120f24] p-6 rounded-3xl border border-purple-100 dark:border-white/5 shadow-xl neon-card-blue theme-transition">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2"><i class="fa-solid fa-chart-line text-blue-500"></i> Laporan Statistik Penggunaan Media</h3>
                        <span class="text-[9px] font-mono font-bold px-2 py-0.5 rounded bg-blue-500/10 text-blue-600 dark:text-blue-400">Dashboard View</span>
                    </div>
                    <div class="aspect-[16/10] rounded-2xl overflow-hidden bg-slate-900 border border-slate-200 dark:border-white/5 shadow-inner">
                        <img src="{{ asset('images/dashboard-preview.jpg') }}" alt="Dashboard Analytics Preview" class="w-full h-full object-cover opacity-90">
                    </div>
                </div>

                <div class="lg:col-span-5 bg-white dark:bg-[#120f24] p-6 rounded-3xl border border-purple-100 dark:border-white/5 shadow-sm space-y-4 theme-transition">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2"><i class="fa-solid fa-trophy text-amber-500"></i> Ranking Keterlibatan Siswa</h3>
                    
                    <div class="space-y-2">
                        <div class="flex items-center justify-between p-3.5 bg-purple-50/50 dark:bg-white/5 rounded-xl text-xs theme-transition border border-purple-100/50 dark:border-transparent">
                            <span class="font-bold text-slate-800 dark:text-slate-200">#1 Ahmad Fauzi</span>
                            <span class="font-mono text-purple-600 dark:text-purple-400 font-extrabold">3,120 Pts</span>
                        </div>
                        <div class="flex items-center justify-between p-3.5 bg-purple-50/50 dark:bg-white/5 rounded-xl text-xs theme-transition border border-purple-100/50 dark:border-transparent">
                            <span class="font-bold text-slate-800 dark:text-slate-200">#2 Risa Amalia</span>
                            <span class="font-mono text-purple-600 dark:text-purple-400 font-extrabold">2,985 Pts</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection