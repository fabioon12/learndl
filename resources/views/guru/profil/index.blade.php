@extends('guru.layouts.app')

@section('title', 'Profil Guru - LearnDL')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-10">

    <!-- Breadcrumb & Title -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Profil Saya</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola informasi biodata dan preferensi akun belajar Anda.</p>
        </div>
        <div class="flex items-center space-x-2 text-xs text-gray-400">
            <a href="{{ url('guru/dashboard') }}" class="hover:text-pink-500 transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-pink-500 font-semibold">Profil</span>
        </div>
    </div>

    <!-- Layout Grid Utama (Header Banner & Form Profil) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- SISI KIRI: Card Avatar & Overview (4 Kolom) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Avatar Card -->
            <div class="bg-white dark:bg-cyberdark-900 p-6 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-xl shadow-pink-500/5 text-center relative overflow-hidden">
                <!-- Background Gradient Decoration -->
                <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500"></div>

                <!-- Avatar Container -->
                <div class="relative z-10 pt-6">
                    <div class="relative inline-block group">
                        <img id="avatar-preview" 
                             src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed={{ urlencode(auth()->user()->fullname ?? 'Guru') }}&backgroundColor=b6e3f4" 
                             alt="Avatar" 
                             class="w-24 h-24 rounded-2xl border-4 border-white dark:border-cyberdark-900 object-cover shadow-lg mx-auto bg-slate-100 dark:bg-cyberdark-800">
                        <span class="absolute bottom-1 right-1 w-4 h-4 bg-emerald-500 border-2 border-white dark:border-cyberdark-900 rounded-full"></span>
                    </div>

                    <h2 class="text-base font-extrabold text-gray-900 dark:text-white mt-3 truncate">
                        {{ auth()->user()->fullname ?? 'Nama Guru' }}
                    </h2>
                    
                    <div class="flex flex-wrap items-center justify-center gap-2 mt-1">
                        <!-- Role Badge -->
                        <span class="px-2 py-0.5 text-[9px] font-extrabold tracking-wider uppercase rounded-full bg-pink-500/10 text-pink-500 border border-pink-500/20">
                            {{ auth()->user()->role ?? 'Guru' }}
                        </span>

                        <!-- Badge Jurusan / Major -->
                        @if(auth()->user()->major_or_subject)
                            <span class="text-xs text-gray-400 font-medium">•</span>
                            <span class="px-2 py-0.5 text-[9px] font-bold tracking-tight rounded-full bg-indigo-500/10 text-indigo-500 dark:text-indigo-400 border border-indigo-500/20">
                                {{ auth()->user()->major_or_subject }}
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-gray-500 dark:text-pink-400/70 mt-1 truncate">
                        {{ auth()->user()->school_name ?? 'Asal Sekolah Belum Diisi' }}
                    </p>
                </div>

            </div>

            <!-- Card Filosofi Pembelajaran -->
            <div class="bg-gradient-to-br from-indigo-900/40 via-purple-900/20 to-cyberdark-900 p-5 rounded-3xl border border-indigo-500/20 shadow-lg space-y-3">
                <div class="flex items-center gap-2 text-pink-400 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-brain"></i>
                    <span>LearnDL Philosophy</span>
                </div>
                <p class="text-xs text-gray-300 leading-relaxed">
                    Pembelajaran <span class="text-white font-semibold">Mindful</span>, <span class="text-white font-semibold">Meaningful</span>, dan <span class="text-amber-300 font-semibold">Joyful</span> memandumu meraih potensi akademis terbaik.
                </p>
            </div>

        </div>

        <!-- SISI KANAN: Form Pengaturan Biodata & Keamanan (8 Kolom) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Main Form Card -->
            <div class="bg-white dark:bg-cyberdark-900 p-6 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-xl shadow-pink-500/5 space-y-6">
                
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 pb-4">
                    <h3 class="text-sm font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-user-gear text-pink-500"></i> Information & Biodata
                    </h3>
                    <span class="text-[10px] text-gray-400">Data otomatis terhubung dengan sistem</span>
                </div>

                <form action="{{ route('guru.profil.update-profil') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-signature text-xs"></i>
                            </span>
                        <input type="text" name="fullname" value="{{ old('fullname', auth()->user()->fullname) }}" 
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 rounded-2xl text-xs font-semibold text-gray-800 dark:text-white focus:outline-none focus:border-pink-500 transition">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Alamat Email -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-envelope text-xs"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" readonly
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-100 dark:bg-cyberdark-800/50 border border-gray-200 dark:border-pink-950/20 rounded-2xl text-xs font-semibold text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            </div>
                        </div>
                        <!-- Nomor Telfon -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Nomor Telepon / WA</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </span>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="Contoh: 081234567890"
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 rounded-2xl text-xs font-semibold text-gray-800 dark:text-white focus:outline-none focus:border-pink-500 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Nomor Telepon & Asal Sekolah -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- 1. Jurusan / Fokus Keahlian -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">
                                Jurusan / Fokus Keahlian
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 z-10">
                                    <i class="fa-solid fa-book-bookmark text-xs"></i>
                                </span>
                                
                                <select name="major_or_subject" 
                                        class="w-full pl-10 pr-8 py-2.5 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 rounded-2xl text-xs font-semibold text-gray-800 dark:text-white focus:outline-none focus:border-pink-500 transition appearance-none cursor-pointer">
                                    <option value="" disabled {{ old('major_or_subject', auth()->user()->major_or_subject) ? '' : 'selected' }}>
                                        -- Pilih Jurusan / Fokus Keahlian --
                                    </option>
                                    <option value="Rekayasa Perangkat Lunak" 
                                        {{ old('major_or_subject', auth()->user()->major_or_subject) == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>
                                        Rekayasa Perangkat Lunak
                                    </option>
                                    <option value="Teknik Jaringan Komputer dan Telekomunikasi" 
                                        {{ old('major_or_subject', auth()->user()->major_or_subject) == 'Teknik Jaringan Komputer dan Telekomunikasi' ? 'selected' : '' }}>
                                        Teknik Jaringan Komputer dan Telekomunikasi
                                    </option>
                                </select>

                                <!-- Custom Arrow Icon Dropdown -->
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </span>
                            </div>
                        </div>

                        <!-- 2. Asal Sekolah -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">
                                Asal Sekolah
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 z-10">
                                    <i class="fa-solid fa-school text-xs"></i>
                                </span>

                                <select name="school_name" 
                                        class="w-full pl-10 pr-8 py-2.5 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 rounded-2xl text-xs font-semibold text-gray-800 dark:text-white focus:outline-none focus:border-pink-500 transition appearance-none cursor-pointer">
                                    <option value="" disabled {{ old('school_name', auth()->user()->school_name) ? '' : 'selected' }}>
                                        -- Pilih Sekolah --
                                    </option>
                                    @php
                                        $schools = [
                                            'SMKN 4 MALANG',
                                            'SMKN 5 MALANG',
                                            'SMKN 6 MALANG',
                                            'SMKN 8 MALANG',
                                            'SMKN 9 MALANG',
                                            'SMKN 11 MALANG',
                                            'SMKN 12 MALANG',
                                        ];
                                    @endphp
                                    @foreach($schools as $school)
                                        <option value="{{ $school }}" {{ old('school_name', auth()->user()->school_name) == $school ? 'selected' : '' }}>
                                            {{ $school }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Icon Arrow Down -->
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-pink-500 via-purple-600 to-indigo-600 hover:opacity-90 text-white text-xs font-bold rounded-2xl shadow-lg shadow-pink-500/20 transition active:scale-95 cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Section Card (Password Update) -->
            <div class="bg-white dark:bg-cyberdark-900 p-6 rounded-3xl border border-gray-100 dark:border-pink-950/20 shadow-xl shadow-pink-500/5 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 pb-4">
                    <h3 class="text-sm font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-lock text-purple-500"></i> Keamanan Akun
                    </h3>
                </div>

                <form action="{{ route('guru.profil.update-password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div x-data="{ showPassword: false, showConfirmPassword: false }" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kata Sandi Baru -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Kata Sandi Baru</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-key text-xs"></i>
                                </span>
                                <input :type="showPassword ? 'text' : 'password'" 
                                    name="password" 
                                    placeholder="••••••••" 
                                    class="w-full pl-10 pr-10 py-2.5 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 rounded-2xl text-xs font-semibold text-gray-800 dark:text-white focus:outline-none focus:border-purple-500 transition">
                                
                                <!-- Tombol Toggle Mata -->
                                <button type="button" 
                                        @click="showPassword = !showPassword" 
                                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-purple-500 transition cursor-pointer focus:outline-none">
                                    <i class="fa-solid text-xs" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Kata Sandi -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-shield-halved text-xs"></i>
                                </span>
                                <input :type="showConfirmPassword ? 'text' : 'password'" 
                                    name="password_confirmation" 
                                    placeholder="••••••••" 
                                    class="w-full pl-10 pr-10 py-2.5 bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 rounded-2xl text-xs font-semibold text-gray-800 dark:text-white focus:outline-none focus:border-purple-500 transition">
                                
                                <!-- Tombol Toggle Mata -->
                                <button type="button" 
                                        @click="showConfirmPassword = !showConfirmPassword" 
                                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-purple-500 transition cursor-pointer focus:outline-none">
                                    <i class="fa-solid text-xs" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-gray-900 dark:bg-cyberdark-800 hover:bg-gray-800 text-white text-xs font-bold rounded-2xl shadow-md transition active:scale-95 cursor-pointer">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection