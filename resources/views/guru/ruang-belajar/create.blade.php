@extends('guru.layouts.app')

@section('title', 'Tambah Materi Belajar')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ imagePreview: null }">

    <!-- 1. Header & Tombol Kembali -->
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('guru.ruang-belajar.index') }}" 
               class="w-10 h-10 rounded-2xl bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center justify-center transition shadow-xs active:scale-95">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-tight">
                    Buat Modul Materi Baru 📝
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Lengkapi informasi dasar materi pembelajaran sebelum menambahkan tahapan materi.
                </p>
            </div>
        </div>
    </div>

    <!-- 2. Form Container -->
    <form action="{{ route('guru.ruang-belajar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white dark:bg-cyberdark-900/90 backdrop-blur-xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
            
            <!-- Section Header -->
            <div class="pb-4 border-b border-gray-100 dark:border-pink-950/20">
                <h2 class="text-sm font-extrabold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-indigo-500"></i> Informasi Utama Materi
                </h2>
                <p class="text-[11px] text-gray-400 mt-0.5">Isi detail judul, mata pelajaran, serta akses kelas bagi siswa.</p>
            </div>

            <!-- Input Judul Materi -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Judul Materi Pembelajaran <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       name="judul" 
                       value="{{ old('judul') }}"
                       required 
                       placeholder="Contoh: Konsep Dasar Blade Templating Engine di Laravel" 
                       class="w-full px-4 py-3 rounded-2xl bg-gray-50/80 dark:bg-cyberdark-800 border @error('judul') border-rose-500 @else border-gray-200 dark:border-pink-950/40 @enderror text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-400 transition">
                @error('judul')
                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid: Mapel & Target Kelas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Mata Pelajaran -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Mata Pelajaran <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="mapel" 
                           value="{{ old('mapel') }}"
                           required 
                           placeholder="Contoh: Pemrograman Web & Perangkat Bergerak" 
                           class="w-full px-4 py-3 rounded-2xl bg-gray-50/80 dark:bg-cyberdark-800 border @error('mapel') border-rose-500 @else border-gray-200 dark:border-pink-950/40 @enderror text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:border-indigo-500 transition">
                    @error('mapel')
                        <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Target Kelas -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Target Kelas <span class="text-rose-500">*</span>
                    </label>
                    <select name="kelas" required class="w-full px-4 py-3 rounded-2xl bg-gray-50/80 dark:bg-cyberdark-800 border @error('kelas') border-rose-500 @else border-gray-200 dark:border-pink-950/40 @enderror text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:border-indigo-500 transition cursor-pointer">
                        <option value="">Pilih Kelas Siswa</option>
                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                    @error('kelas')
                        <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Upload Cover / Thumbnail Banner -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Sampul / Banner Materi (Opsional)
                </label>
                <div class="flex items-center justify-center w-full">
                    <label class="relative flex flex-col items-center justify-center w-full h-40 border-2 border-dashed rounded-3xl cursor-pointer bg-gray-50/50 dark:bg-cyberdark-800/40 border-gray-200 dark:border-pink-950/40 hover:bg-indigo-50/30 dark:hover:bg-indigo-950/20 hover:border-indigo-400 transition overflow-hidden">
                        
                        <!-- Image Preview Container -->
                        <template x-if="imagePreview">
                            <div class="absolute inset-0 w-full h-full bg-cyberdark-950">
                                <img :src="imagePreview" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition">
                                    <p class="text-xs font-bold text-white bg-black/60 px-3 py-1.5 rounded-xl backdrop-blur-md">
                                        Ganti Gambar
                                    </p>
                                </div>
                            </div>
                        </template>

                        <!-- Upload Placeholder UI -->
                        <div x-show="!imagePreview" class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-indigo-500 mb-2"></i>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300">
                                Klik untuk unggah gambar <span class="font-normal text-gray-400">atau drag & drop</span>
                            </p>
                            <p class="text-[10px] text-gray-400 mt-1">PNG, JPG, WEBP (Maksimal 2MB)</p>
                        </div>

                        <input type="file" 
                               name="thumbnail" 
                               accept="image/*" 
                               class="hidden" 
                               @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }" />
                    </label>
                </div>
                @error('thumbnail')
                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi / Ringkasan Materi -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Ringkasan Materi
                </label>
                <textarea name="deskripsi" 
                          rows="4" 
                          placeholder="Jelaskan secara singkat topik pembelajaran yang akan dipelajari siswa di materi ini..." 
                          class="w-full px-4 py-3 rounded-2xl bg-gray-50/80 dark:bg-cyberdark-800 border @error('deskripsi') border-rose-500 @else border-gray-200 dark:border-pink-950/40 @enderror text-xs text-gray-800 dark:text-gray-200 focus:outline-none focus:border-indigo-500 transition">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-[11px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <!-- 3. Form Action Footer -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('guru.ruang-belajar.index') }}" 
               class="px-5 py-3 rounded-2xl bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 text-gray-600 dark:text-gray-300 text-xs font-bold hover:bg-gray-50 transition cursor-pointer">
                Batal
            </a>
            
            <button type="submit" 
                    class="px-6 py-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-extrabold shadow-lg shadow-indigo-500/20 active:scale-95 transition cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk text-xs"></i>
                <span>Simpan & Lanjut Tambah Tahapan</span>
            </button>
        </div>

    </form>

</div>
@endsection