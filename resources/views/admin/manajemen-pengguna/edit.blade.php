@extends('admin.layouts.app')

@section('title', 'Edit Data Pengguna - LearnDL')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 pb-10">

    <!-- Flash Alert Error Validasi -->
    @if ($errors->any())
        <div class="p-4 text-xs font-semibold text-rose-800 bg-rose-50 rounded-2xl border border-rose-200 shadow-sm">
            <div class="flex items-center space-x-2 mb-1">
                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                <span>Gagal memperbarui pengguna:</span>
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
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Edit Data Pengguna</h1>
            <p class="text-xs text-slate-500 mt-0.5">Ubah informasi biodata, peranan, dan kata sandi pengguna.</p>
        </div>
        <div class="flex items-center space-x-2 text-xs text-slate-400">
            <a href="{{ route('admin.manajemen-pengguna') }}" class="hover:text-purple-600 transition-colors">Manajemen Pengguna</a>
            <span>/</span>
            <span class="text-purple-600 font-semibold">Edit Pengguna</span>
        </div>
    </div>

    <!-- Form Utama Edit Pengguna -->
    <form action="{{ route('admin.manajemen-pengguna.update', $user->id) }}" method="POST" x-data="{ role: '{{ old('role', $user->role) }}' }">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- SISI KIRI: Ringkasan Akun & Avatar (4 Kolom) -->
            <div class="lg:col-span-4 space-y-6">
                
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl shadow-purple-500/5 text-center relative overflow-hidden">
                    <div class="absolute top-0 inset-x-0 h-24 bg-gradient-to-r from-purple-600 via-indigo-600 to-purple-800"></div>

                    <div class="relative z-10 pt-6">
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-purple-500 to-indigo-600 border-4 border-white shadow-lg mx-auto flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->fullname, 0, 2)) }}
                        </div>

                        <h2 class="text-base font-extrabold text-slate-900 mt-3 truncate">
                            {{ $user->fullname }}
                        </h2>
                        
                        <div class="flex flex-wrap items-center justify-center gap-2 mt-1">
                            <span class="px-2.5 py-0.5 text-[10px] font-extrabold tracking-wider uppercase rounded-full bg-purple-100 text-purple-700 border border-purple-200">
                                {{ strtoupper($user->role) }}
                            </span>
                        </div>

                        <p class="text-xs text-slate-500 mt-1 truncate">
                            {{ $user->email }}
                        </p>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-100 grid grid-cols-2 gap-3 text-center">
                        <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Status Email</p>
                            <p class="text-xs font-extrabold {{ $user->email_verified_at ? 'text-emerald-600' : 'text-amber-600' }} mt-0.5">
                                {{ $user->email_verified_at ? 'Terverifikasi' : 'Belum Verifikasi' }}
                            </p>
                        </div>
                        <div class="p-2.5 rounded-2xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Bergabung</p>
                            <p class="text-xs font-extrabold text-slate-700 mt-0.5">
                                {{ $user->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 bg-white rounded-3xl border border-slate-200 shadow-sm">
                    <a href="{{ route('admin.manajemen-pengguna') }}" class="w-full text-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-2xl transition">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Tabel
                    </a>
                </div>

            </div>

            <!-- SISI KANAN: Detail Form Pengaturan Data (8 Kolom) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Card Data Utama -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl shadow-purple-500/5 space-y-6">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-pen text-purple-600"></i> Informasi Biodata & Peran
                        </h3>
                    </div>

                    <div class="space-y-4">

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}" required
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor Telepon / WA</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="081234567890"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                            </div>
                        </div>

                        <!-- Peran Pengguna -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Peran (Role)</label>
                            <select name="role" x-model="role" 
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Asal Sekolah -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Instansi / Asal Sekolah</label>
                            <select name="school_name" 
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                                <option value="">-- Pilih Sekolah / Instansi --</option>
                                @foreach([
                                    'SMKN 4 MALANG', 'SMKN 5 MALANG', 'SMKN 6 MALANG',
                                    'SMKN 8 MALANG', 'SMKN 9 MALANG', 'SMKN 11 MALANG', 'SMKN 12 MALANG'
                                ] as $school)
                                    <option value="{{ $school }}" {{ old('school_name', $user->school_name) == $school ? 'selected' : '' }}>
                                        {{ $school }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Khusus Siswa / Guru -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Jurusan / Subjek -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Jurusan / Fokus Subjek</label>
                                <select name="major_or_subject" 
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                                    <option value="">-- Pilih Jurusan / Subjek --</option>
                                    <option value="Rekayasa Perangkat Lunak" {{ old('major_or_subject', $user->major_or_subject) == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                    <option value="Teknik Jaringan Komputer dan Telekomunikasi" {{ old('major_or_subject', $user->major_or_subject) == 'Teknik Jaringan Komputer dan Telekomunikasi' ? 'selected' : '' }}>Teknik Jaringan Komputer dan Telekomunikasi</option>
                                    <option value="Teknik Jaringan dan Telekomunikasi" {{ old('major_or_subject', $user->major_or_subject) == 'Teknik Jaringan dan Telekomunikasi' ? 'selected' : '' }}>Teknik Jaringan dan Telekomunikasi</option>
                                </select>
                            </div>

                            <!-- Kelas (Hanya tampil untuk Siswa) -->
                            <div x-show="role === 'siswa'">
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Kelas</label>
                                <select name="grade" 
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                                    <option value="">Pilih Kelas</option>
                                    <option value="10" {{ old('grade', $user->grade) == '10' ? 'selected' : '' }}>Kelas 10</option>
                                    <option value="11" {{ old('grade', $user->grade) == '11' ? 'selected' : '' }}>Kelas 11</option>
                                    <option value="12" {{ old('grade', $user->grade) == '12' ? 'selected' : '' }}>Kelas 12</option>
                                </select>
                            </div>

                            <!-- Offering (Hanya tampil untuk Siswa) -->
                            <div x-show="role === 'siswa'">
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Offering / Rombel</label>
                                <select name="offering" 
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition cursor-pointer">
                                    <option value="">Pilih Offering</option>
                                    @foreach(['A', 'B', 'C', 'D'] as $opt)
                                        <option value="{{ $opt }}" {{ old('offering', $user->offering) == $opt ? 'selected' : '' }}>Offering {{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Reset Password Card (Opsional) -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xl shadow-purple-500/5 space-y-4">
                    <div class="border-b border-slate-100 pb-4">
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-key text-amber-500"></i> Reset Kata Sandi Pengguna (Opsional)
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Kosongkan jika tidak ingin mengubah kata sandi pengguna ini.</p>
                    </div>

                    <div x-data="{ showPass: false }" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                            <input :type="showPass ? 'text' : 'password'" name="password" placeholder="••••••••"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input :type="showPass ? 'text' : 'password'" name="password_confirmation" placeholder="••••••••"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-2xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-600 transition">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:opacity-90 text-white text-xs font-bold rounded-2xl shadow-lg shadow-purple-500/20 transition active:scale-95 cursor-pointer">
                        Simpan Perubahan Pengguna
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection