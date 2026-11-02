@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna Baru - LearnDL')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 pb-10">

    <!-- Flash Alert Error Validasi -->
    @if ($errors->any())
        <div class="p-4 text-xs font-semibold text-rose-800 bg-rose-50 rounded-2xl border border-rose-200 shadow-sm">
            <div class="flex items-center space-x-2 mb-1">
                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                <span>Gagal menambahkan pengguna baru:</span>
            </div>
            <ul class="list-disc list-inside pl-4 font-normal">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Breadcrumb & Title -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Tambah Pengguna Baru</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftarkan akun Siswa, Guru, atau Admin baru ke dalam sistem LearnDL.</p>
        </div>
        <div class="flex items-center space-x-2 text-xs text-slate-400">
            <a href="{{ route('admin.manajemen-pengguna') }}" class="hover:text-purple-600 transition-colors">Manajemen Pengguna</a>
            <span>/</span>
            <span class="text-purple-600 font-semibold">Tambah Pengguna</span>
        </div>
    </div>

    <!-- Form Utama Tambah Pengguna -->
    <form action="{{ route('admin.manajemen-pengguna.store') }}" method="POST" x-data="{ role: '{{ old('role', 'siswa') }}', showPass: false }">
        @csrf

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl shadow-purple-500/5 space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-purple-600"></i> Form Data Registrasi Pengguna
                </h3>
            </div>

            <div class="space-y-4">

                <!-- 1. Peran Pengguna (Role Selection) -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Peran Akun <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="flex items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-xs font-bold"
                               :class="role === 'siswa' ? 'bg-purple-50 border-purple-600 text-purple-700' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100'">
                            <input type="radio" name="role" value="siswa" x-model="role" class="hidden">
                            <i class="fa-solid fa-graduation-cap mr-2"></i> Siswa
                        </label>
                        <label class="flex items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-xs font-bold"
                               :class="role === 'guru' ? 'bg-purple-50 border-purple-600 text-purple-700' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100'">
                            <input type="radio" name="role" value="guru" x-model="role" class="hidden">
                            <i class="fa-solid fa-user-graduate mr-2"></i> Guru
                        </label>
                        <label class="flex items-center justify-center p-3 rounded-2xl border cursor-pointer transition text-xs font-bold"
                               :class="role === 'admin' ? 'bg-purple-50 border-purple-600 text-purple-700' : 'bg-slate-50 border-slate-200 text-slate-600 hover:bg-slate-100'">
                            <input type="radio" name="role" value="admin" x-model="role" class="hidden">
                            <i class="fa-solid fa-user-gear mr-2"></i> Admin
                        </label>
                    </div>
                </div>

                <!-- 2. Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="fullname" value="{{ old('fullname') }}" placeholder="Masukkan nama lengkap" required
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                </div>

                <!-- 3. Email & Nomor Telepon -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@domain.com" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Telepon / WA</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="081234567890"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                    </div>
                </div>

                <!-- 4. Kata Sandi & Konfirmasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" name="password" placeholder="Minimal 8 karakter" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-purple-600">
                                <i class="fa-solid" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi <span class="text-rose-500">*</span></label>
                        <input :type="showPass ? 'text' : 'password'" name="password_confirmation" placeholder="Ulangi kata sandi" required
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                    </div>
                </div>

                <!-- 5. Asal Sekolah / Instansi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Instansi / Asal Sekolah</label>
                    <select name="school_name" 
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                        <option value="">-- Pilih Sekolah / Instansi --</option>
                        @foreach([
                            'SMKN 4 MALANG', 'SMKN 5 MALANG', 'SMKN 6 MALANG',
                            'SMKN 8 MALANG', 'SMKN 9 MALANG', 'SMKN 11 MALANG', 'SMKN 12 MALANG'
                        ] as $school)
                            <option value="{{ $school }}" {{ old('school_name') == $school ? 'selected' : '' }}>
                                {{ $school }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 6. Input Khusus Siswa & Guru -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Jurusan / Mata Pelajaran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5" x-text="role === 'guru' ? 'Mata Pelajaran Utama' : 'Jurusan / Peminatan'"></label>
                        <select name="major_or_subject" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                            <option value="">-- Pilih Jurusan / Mata Pelajaran --</option>
                            <option value="Rekayasa Perangkat Lunak" {{ old('major_or_subject') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                            <option value="Teknik Jaringan Komputer dan Telekomunikasi" {{ old('major_or_subject') == 'Teknik Jaringan Komputer dan Telekomunikasi' ? 'selected' : '' }}>Teknik Jaringan Komputer dan Telekomunikasi</option>
                            <option value="Teknik Jaringan dan Telekomunikasi" {{ old('major_or_subject') == 'Teknik Jaringan dan Telekomunikasi' ? 'selected' : '' }}>Teknik Jaringan dan Telekomunikasi</option>
                        </select>
                    </div>

                    <!-- Kelas (Hanya Tampil Jika Role Siswa) -->
                    <div x-show="role === 'siswa'">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kelas</label>
                        <select name="grade" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                            <option value="">Pilih Kelas</option>
                            <option value="10" {{ old('grade') == '10' ? 'selected' : '' }}>Kelas 10</option>
                            <option value="11" {{ old('grade') == '11' ? 'selected' : '' }}>Kelas 11</option>
                            <option value="12" {{ old('grade') == '12' ? 'selected' : '' }}>Kelas 12</option>
                        </select>
                    </div>

                    <!-- Offering (Hanya Tampil Jika Role Siswa) -->
                    <div x-show="role === 'siswa'" class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Offering / Rombel</label>
                        <select name="offering" 
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                            <option value="">Pilih Offering</option>
                            @foreach(['A', 'B', 'C', 'D'] as $opt)
                                <option value="{{ $opt }}" {{ old('offering') == $opt ? 'selected' : '' }}>Offering {{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-slate-100">
                <a href="{{ route('admin.manajemen-pengguna') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-2xl transition">
                    Batal
                </a>
                <button type="submit" class="px-7 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 hover:opacity-90 text-white text-xs font-bold rounded-2xl shadow-lg shadow-purple-500/20 transition active:scale-95 cursor-pointer">
                    Simpan Pengguna Baru
                </button>
            </div>

        </div>
    </form>
</div>
@endsection