@extends('guru.layouts.app')

@section('title', 'Ice Breaking')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 py-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/80 dark:bg-cyberdark-900/80 backdrop-blur-xl border border-gray-200/80 dark:border-pink-950/30 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs font-bold transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs text-indigo-500"></i>
            <span>Kembali ke Peta Tahapan</span>
        </a>
    </div>

    <!-- Card Form Konfigurasi Ice Breaking -->
    <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-2xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
        
        <!-- Header Title -->
        <div class="flex items-center gap-3.5 pb-4 border-b border-gray-100 dark:border-pink-950/20">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-pink-500 to-rose-600 text-white flex items-center justify-center text-xl shadow-md shadow-pink-500/20 shrink-0">
                <i class="fa-solid fa-gamepad"></i>
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-black text-gray-900 dark:text-white">Konfigurasi Ice Breaking</h2>
                <p class="text-xs text-gray-400">Atur media permainan/video santai untuk tahapan: <span class="font-bold text-pink-500">{{ $tahapan->judul_tahapan }}</span></p>
            </div>
        </div>

        <!-- Form Ice Breaking -->
        <form action="{{ route('guru.ruang-belajar.tahapan.update', [$ruangBelajar->id, $tahapan->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-5" x-data="{ mediaType: '{{ $tahapan->konten['tipe_media'] ?? 'youtube' }}' }">
            @csrf

            <!-- Instruksi / Teks Games -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Instruksi / Pesan Ice Breaking <span class="text-rose-500">*</span>
                </label>
                <textarea name="konten[instruksi]" rows="4" placeholder="Tuliskan instruksi game singkat, teka-teki, atau ajakan relaksasi untuk siswa..." required
                          class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-pink-500 transition">{{ old('konten.instruksi', $tahapan->konten['instruksi'] ?? '') }}</textarea>
            </div>

            <!-- Pilihan Tipe Media Pendukung -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Pilih Tipe Media Ice Breaking</label>
                <select x-model="mediaType" name="konten[tipe_media]" 
                        class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-pink-500 transition font-semibold">
                    <option value="youtube">🎮 Video YouTube / Game Interaktif</option>
                    <option value="gambar">🖼️ Upload Gambar / GIF Animasi Lucu</option>
                </select>
            </div>

            <!-- Input URL YouTube -->
            <div x-show="mediaType === 'youtube'" class="space-y-1.5" x-cloak>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">URL Video YouTube (Game/Musik Relaksasi)</label>
                <input type="url" name="konten[youtube_url]" value="{{ old('konten.youtube_url', $tahapan->konten['youtube_url'] ?? '') }}"
                       placeholder="https://www.youtube.com/watch?v=..."
                       class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-pink-500 transition">
            </div>

            <!-- Upload Gambar / GIF -->
            <div x-show="mediaType === 'gambar'" class="space-y-1.5" x-cloak>
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Upload Gambar / GIF Ice Breaking</label>
                @if(!empty($tahapan->konten['gambar_path']))
                    <div class="mb-2 p-2 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 inline-block border border-gray-200 dark:border-pink-950/30">
                        <img src="{{ asset('storage/' . $tahapan->konten['gambar_path']) }}" alt="Preview" class="w-40 h-24 object-cover rounded-xl">
                        <p class="text-[10px] text-gray-400 mt-1 text-center">Media saat ini</p>
                    </div>
                @endif
                <input type="file" name="gambar_ice_breaking" accept="image/*"
                       class="w-full px-3 py-2 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-[11px] text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-pink-50 file:text-pink-600">
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-pink-950/20">
                <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}" 
                   class="px-5 py-2.5 rounded-2xl bg-gray-100 dark:bg-cyberdark-800 text-gray-600 dark:text-gray-300 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-pink-500 to-rose-600 hover:from-pink-400 hover:to-rose-500 text-white text-xs font-extrabold shadow-md shadow-pink-500/20 transition active:scale-95 cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Konfigurasi Ice Breaking</span>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection