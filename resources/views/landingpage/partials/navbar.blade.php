
<nav class="sticky top-0 z-50 bg-white/90 dark:bg-[#090619]/90 backdrop-blur-xl border-b border-purple-100 dark:border-purple-950/40 shadow-sm theme-transition"
     x-data="{ mobileMenu: false }">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <!-- Logo -->
            <a href="#" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/20">
                    <i class="fa-solid fa-brain text-white text-lg"></i>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Learn<span class="bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">DL</span>
                    </span>
                    <p class="text-[9px] font-semibold tracking-[0.18em] uppercase text-slate-400">
                        Deep Learning Platform
                    </p>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-8 text-xs font-bold text-slate-600 dark:text-slate-300">
                <a href="#metode" class="hover:text-purple-600 transition">3 Pilar DL</a>
                <a href="#fitur" class="hover:text-purple-600 transition">Fitur Unggulan</a>
                <a href="#silabus" class="hover:text-purple-600 transition">Konten Materi</a>
                <a href="#evaluasi" class="hover:text-purple-600 transition">Evaluasi</a>
            </div>

            <!-- Desktop Actions -->
            <div class="hidden md:flex items-center gap-4">
                <button
                    @click="darkMode = !darkMode"
                    class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-white/5 border border-purple-100 dark:border-white/10 text-slate-600 dark:text-amber-400 flex items-center justify-center hover:scale-105 transition"
                    title="Ubah tema">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <a href="{{ route('login') }}"
                   class="text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-purple-600 transition">
                    Masuk
                </a>

                <a href="{{ route('register') }}"
                   class="px-5 py-3 rounded-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white text-xs font-bold shadow-lg shadow-purple-500/20 hover:-translate-y-0.5 transition">
                    Daftar Gratis <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Mobile Actions -->
            <div class="flex md:hidden items-center gap-3">
                <button @click="darkMode = !darkMode"
                        class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-white/5 flex items-center justify-center text-purple-600 dark:text-amber-400">
                    <i class="fa-solid" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <button @click="mobileMenu = !mobileMenu"
                        class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-white/5 flex items-center justify-center text-slate-700 dark:text-white">
                    <i class="fa-solid" :class="mobileMenu ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu"
         x-transition
         x-cloak
         class="lg:hidden bg-white dark:bg-[#100c25] border-t border-purple-100 dark:border-white/5 p-6 space-y-4">
        <a href="#metode" @click="mobileMenu = false" class="block text-xs font-bold text-slate-600 dark:text-slate-300">3 Pilar DL</a>
        <a href="#fitur" @click="mobileMenu = false" class="block text-xs font-bold text-slate-600 dark:text-slate-300">Fitur Unggulan</a>
        <a href="#silabus" @click="mobileMenu = false" class="block text-xs font-bold text-slate-600 dark:text-slate-300">Konten Materi</a>
        <a href="#evaluasi" @click="mobileMenu = false" class="block text-xs font-bold text-slate-600 dark:text-slate-300">Evaluasi</a>

        <div class="grid grid-cols-2 gap-3 pt-3">
            <a href="{{ route('login') }}" class="text-center py-3 rounded-xl border border-purple-200 dark:border-white/10 text-xs font-bold text-purple-600 dark:text-purple-300">
                Masuk
            </a>
            <a href="{{ route('register') }}" class="text-center py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs font-bold">
                Daftar
            </a>
        </div>
    </div>
</nav>


<!-- HERO HEADER -->
<header class="relative overflow-hidden bg-gradient-to-b from-purple-50 via-white to-blue-50/40 dark:from-[#100b29] dark:via-[#090619] dark:to-[#0c1028] theme-transition">

    <!-- Background Decorations -->
    <div class="absolute -top-40 -right-32 w-[550px] h-[550px] rounded-full bg-purple-500/10 blur-[120px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-32 w-[500px] h-[500px] rounded-full bg-blue-500/10 blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 lg:py-28 relative z-10">
        <div class="grid lg:grid-cols-12 gap-14 items-center">

            <!-- LEFT CONTENT -->
            <div class="lg:col-span-6 text-center lg:text-left space-y-7">

                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100/70 dark:bg-purple-500/10 border border-purple-200 dark:border-purple-500/20 text-purple-700 dark:text-purple-300 text-[10px] sm:text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Platform Pembelajaran Mendalam
                </div>

                <div class="space-y-4">
                    <h1 class="text-4xl sm:text-5xl lg:text-[58px] font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.12]">
                        Bangun Logika.
                        <br>
                        Pecahkan Masalah.
                        <br>
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                            Berpikir Lebih Kritis.
                        </span>
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Jelajahi pengalaman belajar pemrograman yang interaktif melalui pendekatan pembelajaran mendalam. Pahami konsep, analisis permasalahan, dan bangun solusi dengan pola pikir kritis.
                    </p>
                </div>

                <!-- CTA -->
                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start pt-2">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center gap-3 px-7 py-4 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white text-xs font-bold shadow-xl shadow-purple-500/25 hover:-translate-y-1 transition">
                        <i class="fa-solid fa-rocket"></i>
                        Mulai Pengalaman Belajar
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>

                    <a href="#metode"
                       class="inline-flex items-center justify-center gap-2 px-7 py-4 rounded-2xl bg-white dark:bg-white/5 border border-purple-200 dark:border-white/10 text-purple-700 dark:text-purple-300 text-xs font-bold hover:-translate-y-1 transition">
                        <i class="fa-solid fa-circle-play"></i>
                        Jelajahi Platform
                    </a>
                </div>

                <!-- Mini Features -->
                <div class="flex flex-wrap justify-center lg:justify-start gap-x-6 gap-y-3 pt-4">
                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        Pembelajaran Interaktif
                    </div>
                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        Tantangan Pemrograman
                    </div>
                    <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-500 dark:text-slate-400">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        Sistem Poin XP
                    </div>
                </div>
            </div>


            <!-- RIGHT VISUAL: LEARNING INTERFACE -->
            <div class="lg:col-span-6 relative">

                <!-- Glow -->
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/20 via-purple-500/20 to-pink-500/20 blur-[80px] rounded-full"></div>

                <!-- Main Interface -->
                <div class="relative z-10 rounded-[28px] bg-white dark:bg-[#15112b] border border-purple-100 dark:border-white/10 shadow-2xl shadow-purple-900/10 overflow-hidden transform hover:-translate-y-1 transition duration-500">

                    <!-- Window Header -->
                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 dark:border-white/10">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 tracking-wider">LEARNDL / LEARNING SPACE</span>
                        <i class="fa-solid fa-ellipsis text-slate-400"></i>
                    </div>

                    <div class="p-5 sm:p-7 space-y-6">

                        <!-- Welcome -->
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-[10px] font-semibold text-purple-500 uppercase tracking-widest">Learning Dashboard</p>
                                <h3 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white mt-1">
                                    Ruang Belajar
                                </h3>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">
                                    Tingkatkan kemampuan pemrogramanmu.
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xl shadow-lg">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                        </div>

                        <!-- Progress -->
                        <div class="p-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                            <div class="flex justify-between items-center gap-3">
                                <div>
                                    <p class="text-[10px] text-purple-100">Perjalanan Belajarmu</p>
                                    <p class="text-lg font-extrabold mt-1">Level 03</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-purple-100">Total Pengalaman</p>
                                    <p class="text-lg font-extrabold mt-1">320 XP</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between text-[9px] font-semibold text-purple-100 mb-2">
                                    <span>Progress Level</span>
                                    <span>64%</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-white/20 overflow-hidden">
                                    <div class="w-[64%] h-full bg-amber-300 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Learning Steps -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-extrabold text-slate-800 dark:text-white">Alur Pembelajaran</h4>
                                <span class="text-[9px] font-bold text-purple-500">4 TAHAP</span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">

                                <div class="p-3 rounded-2xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20">
                                    <div class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center text-xs mb-2">
                                        <i class="fa-solid fa-lightbulb"></i>
                                    </div>
                                    <p class="text-[10px] font-extrabold text-slate-800 dark:text-white">Stimulus</p>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1">Pahami permasalahan</p>
                                </div>

                                <div class="p-3 rounded-2xl bg-purple-50 dark:bg-purple-500/10 border border-purple-100 dark:border-purple-500/20">
                                    <div class="w-8 h-8 rounded-xl bg-purple-600 text-white flex items-center justify-center text-xs mb-2">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </div>
                                    <p class="text-[10px] font-extrabold text-slate-800 dark:text-white">Eksplorasi</p>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1">Analisis dan temukan</p>
                                </div>

                                <div class="p-3 rounded-2xl bg-pink-50 dark:bg-pink-500/10 border border-pink-100 dark:border-pink-500/20">
                                    <div class="w-8 h-8 rounded-xl bg-pink-600 text-white flex items-center justify-center text-xs mb-2">
                                        <i class="fa-solid fa-code"></i>
                                    </div>
                                    <p class="text-[10px] font-extrabold text-slate-800 dark:text-white">Pengaplikasian</p>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1">Bangun solusi kode</p>
                                </div>

                                <div class="p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xs mb-2">
                                        <i class="fa-solid fa-clipboard-check"></i>
                                    </div>
                                    <p class="text-[10px] font-extrabold text-slate-800 dark:text-white">Evaluasi</p>
                                    <p class="text-[9px] text-slate-500 dark:text-slate-400 mt-1">Refleksi hasil belajar</p>
                                </div>

                            </div>
                        </div>

                        <!-- Code Preview -->
                        <div class="rounded-2xl bg-slate-950 p-4 text-[10px] font-mono shadow-inner">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-slate-400">latihan_percabangan.py</span>
                                <span class="text-emerald-400 flex items-center gap-1">
                                    <i class="fa-solid fa-circle text-[6px]"></i> Practice
                                </span>
                            </div>
                            <p class="text-slate-500"># Analisis kondisi nilai</p>
                            <p class="text-purple-300 mt-1">
                                <span class="text-pink-400">if</span> nilai >=
                                <span class="text-amber-300">80</span>:
                            </p>
                            <p class="pl-4 text-emerald-300">status = "Lulus"</p>
                            <p class="text-purple-300 mt-1">
                                <span class="text-pink-400">else</span>:
                            </p>
                            <p class="pl-4 text-emerald-300">status = "Belajar Lagi"</p>
                        </div>

                    </div>
                </div>

                <!-- Floating XP Card -->
                <div class="absolute -left-5 top-1/4 z-20 hidden sm:block p-4 rounded-2xl bg-white dark:bg-[#17122d] border border-purple-100 dark:border-white/10 shadow-xl animate-float">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-500/10 text-amber-500 flex items-center justify-center">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 font-semibold">Pencapaian</p>
                            <p class="text-xs font-extrabold text-slate-800 dark:text-white">+25 XP</p>
                        </div>
                    </div>
                </div>

                <!-- Floating Success Card -->
                <div class="absolute -right-4 bottom-12 z-20 hidden sm:block p-4 rounded-2xl bg-white dark:bg-[#17122d] border border-emerald-100 dark:border-emerald-500/20 shadow-xl animate-float-fast">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-500/10 text-emerald-500 flex items-center justify-center">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 font-semibold">Aktivitas</p>
                            <p class="text-xs font-extrabold text-slate-800 dark:text-white">Berhasil diselesaikan</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
