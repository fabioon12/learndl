    <nav class="bg-white/95 dark:bg-[#070514]/90 backdrop-blur-xl sticky top-0 z-40 border-b border-purple-100 dark:border-purple-950/40 theme-transition shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center shadow-md shadow-purple-500/20">
                        <i class="fa-solid fa-brain text-xs text-white"></i>
                    </div>
                    <span class="text-lg font-extrabold tracking-tight text-slate-900 dark:text-white">Learn<span class="bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">DL</span></span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8 text-xs font-bold text-slate-600 dark:text-slate-300">
                    <a href="#metode" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1.5"><i class="fa-solid fa-route opacity-70"></i> 3 Pilar DL</a>
                    <a href="#fitur" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1.5"><i class="fa-solid fa-bug-slash opacity-70"></i> Umpan Balik Eror</a>
                    <a href="#silabus" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1.5"><i class="fa-solid fa-book-open opacity-70"></i> Konten Materi</a>
                    <a href="#evaluasi" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors flex items-center gap-1.5"><i class="fa-solid fa-star opacity-70"></i> Kuis & Ranking</a>
                </div>
                
                <div class="hidden md:flex items-center gap-6">
                    <button 
                        @click="darkMode = !darkMode" 
                        class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-white/5 border border-purple-100 dark:border-white/10 text-slate-600 dark:text-amber-400 flex items-center justify-center hover:scale-105 transition duration-300 cursor-pointer shadow-inner"
                        title="Ubah Tema Warna"
                    >
                        <i class="fa-solid" :class="darkMode ? 'fa-sun text-amber-400' : 'fa-moon text-purple-700'"></i>
                    </button>
                    
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 dark:text-slate-200 hover:text-purple-600 transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white text-xs font-bold px-5 py-2.5 rounded-full transition shadow-lg shadow-purple-500/20 transform hover:-translate-y-0.5 duration-300">
                        Daftar Gratis
                    </a>
                </div>

                <div class="flex items-center gap-4 md:hidden">
                    <button @click="darkMode = !darkMode" class="text-sm bg-purple-50 dark:bg-white/5 p-2.5 rounded-xl border border-purple-100 dark:border-white/5">
                        <i class="fa-solid" :class="darkMode ? 'fa-sun text-amber-400' : 'fa-moon text-purple-700'"></i>
                    </button>
                    <button @click="mobileMenu = !mobileMenu" class="text-slate-700 dark:text-slate-300">
                        <i class="fa-solid" :class="mobileMenu ? 'fa-xmark text-lg' : 'fa-bars text-lg'"></i>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenu" x-transition class="md:hidden bg-white dark:bg-[#0f0c24] p-6 space-y-4 font-bold text-xs shadow-xl border-t border-purple-100 dark:border-white/5">
            <a href="#metode" @click="mobileMenu = false" class="block text-slate-600 dark:text-slate-300"><i class="fa-solid fa-route mr-2 text-purple-500"></i> 3 Pilar DL</a>
            <a href="#fitur" @click="mobileMenu = false" class="block text-slate-600 dark:text-slate-300"><i class="fa-solid fa-bug-slash mr-2 text-purple-500"></i> Umpan Balik Eror</a>
            <a href="#silabus" @click="mobileMenu = false" class="block text-slate-600 dark:text-slate-300"><i class="fa-solid fa-book-open mr-2 text-purple-500"></i> Konten Materi</a>
            <a href="#evaluasi" @click="mobileMenu = false" class="block text-slate-600 dark:text-slate-300"><i class="fa-solid fa-star mr-2 text-purple-500"></i> Kuis & Ranking</a>
        </div>
    </nav>

    <header class="relative pt-12 pb-24 lg:pt-20 lg:pb-32 overflow-hidden bg-gradient-to-b from-purple-100/50 via-transparent to-transparent dark:from-purple-950/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
            
            <div class="absolute top-10 right-1/2 text-purple-300/40 dark:text-purple-600/20 text-3xl animate-float pointer-events-none hidden lg:block"><i class="fa-solid fa-code"></i></div>
            <div class="absolute bottom-10 left-10 text-blue-300/40 dark:text-blue-600/20 text-4xl animate-float-fast pointer-events-none hidden lg:block" style="animation-delay: -1s;"><i class="fa-solid fa-terminal"></i></div>
            <div class="absolute top-1/2 left-1/2 text-pink-300/30 dark:text-pink-600/15 text-2xl animate-float pointer-events-none hidden lg:block" style="animation-delay: -2s;"><i class="fa-solid fa-microchip"></i></div>
            
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-6 space-y-6 text-center lg:text-left reveal-view">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-gradient-to-r from-blue-500/10 to-purple-500/10 dark:from-blue-500/20 dark:to-purple-500/20 text-xs font-bold text-purple-800 dark:text-purple-300 border border-purple-300/50 dark:border-purple-500/30 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-gradient-to-r from-pink-500 to-red-500 animate-pulse"></span>
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent flex items-center gap-1">
                            <i class="fa-solid fa-sliders text-[10px]"></i> Navigasi & Step Interaktif Tiap Materi
                        </span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.15]">
                        Pecahkan Logika.<br>Tingkatkan Struktur <br>
                        <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-pink-500 dark:from-cyan-400 dark:via-purple-400 dark:to-pink-400 bg-clip-text text-transparent drop-shadow-sm">
                            Berpikir Kritis Anda.
                        </span>
                    </h1>

                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                        Platform web adaptif yang membimbing Anda menguasai konsep pemrograman pembelajaran yang lebih mendalam.
                    </p>

                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start pt-2">
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white text-xs font-bold px-6 py-3.5 rounded-full shadow-lg shadow-purple-500/30 transform hover:-translate-y-1 transition duration-300 flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap"></i> Mulai Belajar Kelas
                        </a>
                        <a href="#metode" class="bg-white dark:bg-white/5 text-purple-700 dark:text-purple-300 text-xs font-bold px-6 py-3.5 rounded-full border-2 border-purple-200 dark:border-white/10 shadow-sm transform hover:-translate-y-1 transition duration-300 flex items-center gap-2">
                            <i class="fa-solid fa-circle-nodes text-blue-500"></i> 3 Pilar DL
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-6 relative flex justify-center items-center reveal-view" style="transition-delay: 150ms">
                    
                    <div class="absolute w-80 h-80 sm:w-96 sm:h-96 rounded-full bg-gradient-to-tr from-cyan-400 via-pink-400 to-yellow-300 dark:from-purple-800 dark:to-blue-900 opacity-40 dark:opacity-30 blur-3xl animate-pulse"></div>

                    <div class="relative w-80 h-80 sm:w-96 sm:h-96 rounded-full p-2.5 bg-gradient-to-tr from-cyan-400 via-purple-500 to-pink-500 shadow-2xl overflow-hidden z-10 transform hover:scale-102 transition duration-500">
                        <img src="{{ asset('landingpage/student.jpeg') }}" alt="Siswa Belajar Logika Pemrograman" class="w-full h-full object-cover rounded-full">
                    </div>

                    <div class="absolute top-4 left-[-10px] sm:left-2 bg-white/95 dark:bg-[#141126]/95 p-4 rounded-2xl border-2 border-purple-100 dark:border-purple-500/20 text-[11px] font-mono shadow-2xl animate-float z-20 theme-transition">
                        <div class="flex items-center justify-between gap-6 mb-2">
                            <div class="flex gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-red-400"></span>
                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                <span class="w-2 h-2 rounded-full bg-green-400"></span>
                            </div>
                            <i class="fa-solid fa-code text-[10px] text-purple-400 opacity-70"></i>
                        </div>
                        <p class="text-slate-700 dark:text-slate-300"><span class="text-pink-600 dark:text-pink-400 font-bold">if</span> (pola_pikir == <span class="text-cyan-600 dark:text-cyan-400">"kritis"</span>):</p>
                        <p class="pl-4 text-blue-600 dark:text-blue-400">system.optimize_skills()</p>
                    </div>

                    <div class="absolute bottom-4 left-[-10px] sm:left-2 bg-white/95 dark:bg-[#141126]/95 p-4 rounded-2xl border-2 border-emerald-100 dark:border-blue-500/20 text-[11px] font-mono shadow-2xl animate-float z-20 theme-transition" style="animation-delay: -3s;">
                        <div class="flex items-center justify-between gap-6 mb-2">
                            <div class="flex gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                                <span class="w-2 h-2 rounded-full bg-pink-400"></span>
                            </div>
                            <i class="fa-solid fa-terminal text-[10px] text-emerald-400 opacity-70"></i>
                        </div>
                        <p class="text-purple-600 dark:text-purple-400"><span class="text-pink-600 dark:text-pink-400 font-bold">if</span> <span class="text-slate-800 dark:text-slate-200">eror_terdeteksi</span>:</p>
                        <p class="pl-4 text-emerald-600 dark:text-emerald-400 font-bold">sajikan_petunjuk_taktis()</p>
                    </div>

                    <div class="absolute right-[-15px] sm:right-0 top-1/4 flex flex-col gap-3 z-20">
                        <div class="bg-white dark:bg-[#141126] p-2.5 rounded-xl border border-blue-200 dark:border-blue-500/30 shadow-lg flex items-center justify-center text-sm text-blue-500 animate-float-fast hover:scale-110 transition duration-300">
                            <i class="fa-brands fa-python"></i>
                        </div>
                        <div class="bg-white dark:bg-[#141126] p-2.5 rounded-xl border border-amber-200 dark:border-amber-500/30 shadow-lg flex items-center justify-center text-sm text-amber-500 animate-float hover:scale-110 transition duration-300" style="animation-delay: -1.5s;">
                            <i class="fa-brands fa-js"></i>
                        </div>
                        <div class="bg-white dark:bg-[#141126] p-2.5 rounded-xl border border-purple-200 dark:border-purple-500/30 shadow-lg flex items-center justify-center text-sm text-purple-500 animate-float-fast hover:scale-110 transition duration-300" style="animation-delay: -0.7s;">
                            <i class="fa-solid fa-database"></i>
                        </div>
                    </div>

                    <div class="absolute bottom-12 right-[-10px] sm:right-6 bg-gradient-to-r from-pink-500 to-purple-600 p-3 rounded-2xl text-white shadow-xl animate-float z-20 flex items-center gap-2 text-[10px] font-bold tracking-wide" style="animation-delay: -4.5s;">
                        <i class="fa-solid fa-network-wired text-xs animate-pulse"></i>
                        <span class="font-mono uppercase opacity-90">Deep Learning</span>
                    </div>
                </div>

            </div>
        </div>
    </header>