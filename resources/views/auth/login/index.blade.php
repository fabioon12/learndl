@extends('auth.layouts.app')

@section('title', 'Masuk ke Akun Anda')

@section('content')
    <div class="w-full max-w-5xl bg-white dark:bg-[#120f22] sm:rounded-3xl shadow-2xl border-0 sm:border border-slate-100 dark:border-purple-500/10 overflow-hidden grid lg:grid-cols-12 min-h-screen sm:min-h-[650px]">
        
        <!-- Left Column (Form) -->
        <div class="lg:col-span-6 p-8 sm:p-12 flex flex-col justify-between relative">
            
            <div class="flex items-center gap-2.5 mb-8">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-purple-600 flex items-center justify-center text-white shadow-md shadow-purple-500/20">
                    <i class="fa-solid fa-brain text-sm"></i>
                </div>
                <span class="font-extrabold text-base tracking-tight bg-gradient-to-r from-slate-900 to-slate-700 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
                    Learn<span class="text-purple-500">DL</span>
                </span>
            </div>

            <div class="my-auto space-y-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        Selamat Datang Kembali
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1.5 font-medium">
                        Masukkan akun Anda untuk melanjutkan siklus pembelajaran yang lebih mendalam.
                    </p>
                </div>

                <form id="login-form" class="space-y-4" action="{{ route('login.store') }}" method="POST">
                    @csrf

                    <!-- 1. Alamat Email -->
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" 
                                class="w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('email') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200 placeholder:text-slate-400 dark:placeholder:text-slate-600">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. Kata Sandi -->
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <label for="password" class="text-xs font-bold text-slate-700 dark:text-slate-300 tracking-wide block">Kata Sandi</label>
                            <a href="#" class="text-[11px] font-bold text-purple-600 dark:text-purple-400 hover:underline">Lupa Sandi?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 dark:text-slate-500 text-xs">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" required placeholder="••••••••" 
                                class="w-full pl-11 pr-11 py-3 bg-slate-50 dark:bg-[#1a1632] border @error('password') border-red-500 @else border-slate-200 dark:border-purple-500/20 @enderror rounded-xl text-xs sm:text-sm font-medium focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/10 text-slate-900 dark:text-white transition duration-200 placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            <button type="button" onclick="togglePasswordVisibility('password', 'password-toggle-icon')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 dark:text-slate-500 hover:text-purple-500 transition cursor-pointer text-xs">
                                <i id="password-toggle-icon" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 3. Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300 dark:border-purple-500/30 text-purple-600 focus:ring-purple-500/20 bg-slate-50 dark:bg-[#1a1632] w-4 h-4 transition">
                            <span class="text-xs text-slate-600 dark:text-slate-400 font-medium group-hover:text-slate-800 dark:group-hover:text-slate-200">Ingat perangkat ini</span>
                        </label>
                    </div>

                    <!-- 4. Tombol Submit -->
                    <button type="submit" class="w-full mt-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white text-xs sm:text-sm font-bold py-3.5 rounded-xl shadow-lg shadow-purple-500/20 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-200 flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-right-to-bracket"></i> Otentikasi & Masuk
                    </button>
                </form>

            </div>

            <p class="text-center text-xs text-slate-500 dark:text-slate-400 mt-8">
                Belum punya akun kelas? <a href="{{ route('register') }}" class="text-purple-600 dark:text-purple-400 font-bold hover:underline">Buat Akun</a>
            </p>
        </div>

        <!-- Right Column (Banner Info) -->
        <div class="lg:col-span-6 bg-gradient-to-tr from-[#16122c] via-[#241a4a] to-[#120f22] p-12 hidden lg:flex flex-col justify-between relative overflow-hidden border-l border-purple-500/10">
            <div class="absolute top-[-20%] right-[-20%] w-80 h-80 rounded-full bg-cyan-500/20 blur-3xl animate-pulse"></div>
            <div class="absolute bottom-[-10%] left-[-10%] w-80 h-80 rounded-full bg-pink-500/10 blur-3xl animate-pulse" style="animation-delay: -2s"></div>
            
            <div class="absolute top-12 left-12 text-slate-500/20 text-xl animate-float"><i class="fa-solid fa-terminal"></i></div>
            <div class="absolute bottom-24 right-16 text-slate-500/20 text-2xl animate-float" style="animation-delay: -1.5s"><i class="fa-solid fa-microchip"></i></div>

            <div class="text-right">
                <span class="text-[10px] font-mono tracking-widest text-cyan-400 uppercase bg-cyan-500/10 px-3 py-1 rounded-full border border-cyan-500/20">
                    Pembelajaran Logika Pemrograman yang Lebih Mendalam
                </span>
            </div>

            <div class="my-auto space-y-6 relative z-10 max-w-sm mx-auto w-full">
                <div class="bg-[#141126]/90 p-5 rounded-2xl border border-purple-500/20 font-mono text-xs shadow-2xl space-y-2 transform -rotate-1 hover:rotate-0 transition duration-300">
                    <div class="flex items-center justify-between mb-3 border-b border-purple-500/10 pb-2">
                        <div class="flex gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500/70"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500/70"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500/70"></span>
                        </div>
                        <span class="text-[10px] text-slate-500">auth_gate.py</span>
                    </div>
                    <p class="text-slate-400"><span class="text-pink-400 font-bold">def</span> <span class="text-blue-400">validasi_akses</span>(user):</p>
                    <p class="pl-4 text-slate-400"><span class="text-pink-400 font-bold">if</span> user.is_authenticated:</p>
                    <p class="pl-8 text-emerald-400 font-bold">return "Buka_Kunci_Materi"</p>
                    <p class="pl-4 text-slate-400"><span class="text-pink-400 font-bold">else</span>:</p>
                    <p class="pl-8 text-rose-400 font-bold">throw Error("Akses_Ditolak")</p>
                </div>

                <div class="bg-white/5 backdrop-blur-sm p-4 rounded-xl border border-white/10 flex items-start gap-3.5">
                    <div class="w-8 h-8 rounded-lg bg-purple-500/20 flex items-center justify-center text-purple-400 text-sm shrink-0">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white tracking-wide">Navigasi Interaktif Instan</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5 leading-relaxed">Sistem melacak error penulisan kode percabangan Anda secara langsung sewaktu simulasi berjalan.</p>
                    </div>
                </div>
            </div>

            <div class="text-xs text-slate-500 flex items-center justify-between">
                <span>© 2026 LearnDL Platform.</span>
                <span class="flex items-center gap-1"><i class="fa-solid fa-shield-halved text-cyan-500/70 text-[10px]"></i> Secure Gateway</span>
            </div>
        </div>

    </div>

@endsection