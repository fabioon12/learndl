@extends('guru.layouts.app')

@section('title', 'Edit Materi - ' . $materis->judul)

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6 space-y-6" x-data="{ 
    selectedIcon: '{{ old('icon', $materis->icon ?? 'fa-book-open') }}' 
}">

    <!-- Header Banner Card -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 dark:from-cyberdark-900 dark:via-cyberdark-800 dark:to-indigo-950/80 border border-indigo-500/30 dark:border-pink-950/40 p-6 sm:p-8 shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 transition-all duration-300">
        
        <div class="space-y-2 max-w-xl relative z-10">
            <div class="flex items-center gap-2">
                <a href="{{ route('guru.materi.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white/20 dark:bg-cyberdark-800/80 text-[11px] font-extrabold text-white dark:text-gray-200 hover:bg-white/30 dark:hover:bg-cyberdark-700 transition shadow-xs border border-white/20 dark:border-pink-950/40 backdrop-blur-md">
                    <i class="fa-solid fa-arrow-left"></i> Batal & Kembali
                </a>
            </div>

            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white flex items-center gap-2.5">
                Edit Materi Pembelajaran ✏️
            </h1>

            <p class="text-xs sm:text-sm text-purple-100 dark:text-gray-300 leading-relaxed font-medium">
                Perbarui detail informasi materi <span class="font-bold underline text-white">{{ $materis->judul }}</span>.
            </p>
        </div>
    </div>

    <!-- Form Edit Card Utama -->
    <div class="bg-white/90 dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 md:p-8 shadow-sm">
        <form action="{{ route('guru.materi.update', $materis->id) }}" 
            method="POST" 
            enctype="multipart/form-data" 
            class="space-y-6"
            x-data="{ imagePreview: '{{ $materis->thumbnail ? asset('storage/' . $materis->thumbnail) : null }}' }">
            @csrf
            @method('PUT')

            <!-- 1. Judul Materi -->
            <div class="space-y-1.5">
                <label for="judul" class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                    Judul Materi <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <i class="fa-solid fa-heading text-xs"></i>
                    </div>
                    <input type="text" 
                        name="judul" 
                        id="judul" 
                        value="{{ old('judul', $materis->judul) }}"
                        placeholder="Contoh: Pengenalan Tipe Data Primitive" 
                        class="w-full pl-10 pr-4 py-3 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition @error('judul') border-rose-500 @enderror" 
                        required>
                </div>
                @error('judul')
                    <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Edit / Upload Thumbnail Gambar -->
            <div class="space-y-1.5">
                <label for="thumbnail" class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                    Thumbnail Materi <span class="text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span>
                </label>
                
                <div class="flex items-center gap-4">
                    <!-- Box Image Preview -->
                    <div class="w-24 h-24 rounded-2xl bg-gray-100 dark:bg-cyberdark-800 border-2 border-dashed border-gray-200 dark:border-pink-950/30 flex items-center justify-center shrink-0 overflow-hidden relative">
                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!imagePreview">
                            <div class="text-center text-gray-400">
                                <i class="fa-solid fa-image text-xl mb-1"></i>
                                <span class="block text-[9px] font-bold">No Image</span>
                            </div>
                        </template>
                    </div>

                    <!-- Custom File Input -->
                    <div class="flex-1 space-y-2">
                        <input type="file" 
                            name="thumbnail" 
                            id="thumbnail" 
                            accept="image/*"
                            @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }"
                            class="w-full text-xs text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-2xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 dark:file:bg-indigo-950/40 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50 transition cursor-pointer">
                        <p class="text-[10px] text-gray-400">Gunakan file baru untuk mengganti thumbnail saat ini (PNG, JPG, WEBP - Max 2MB).</p>
                    </div>
                </div>
                @error('thumbnail')
                    <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 3. Deskripsi Materi -->
            <div class="space-y-1.5">
                <label for="deskripsi" class="block text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                    Deskripsi Singkat / Catatan
                </label>
                <textarea name="deskripsi" 
                        id="deskripsi" 
                        rows="4" 
                        placeholder="Tuliskan gambaran singkat materi..." 
                        class="w-full p-4 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">{{ old('deskripsi', $materis->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-gray-100 dark:border-pink-950/20 flex items-center justify-end gap-3">
                <a href="{{ route('guru.materi.index') }}" 
                class="px-5 py-3 rounded-2xl border border-gray-200 dark:border-pink-950/30 text-xs font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-cyberdark-800 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black shadow-lg shadow-indigo-500/20 transition active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Update Materi
                </button>
            </div>
        </form>
    </div>

</div>
@endsection