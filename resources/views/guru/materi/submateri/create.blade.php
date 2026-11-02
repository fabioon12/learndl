@extends('guru.layouts.app')

@section('title', 'Tambah Sub Materi - ' . $materi->judul)

@section('content')
<div class="space-y-6 max-w-4xl mx-auto" x-data="{ tipe: 'teks' }">

    <!-- Breadcrumb -->
    <nav class="flex text-xs text-gray-400 gap-2 items-center">
        <a href="{{ route('guru.materi.index') }}" class="hover:text-indigo-600 transition">Ruang Materi</a>
        <span>&rsaquo;</span>
        <a href="{{ route('guru.materi.submateri.index', $materi->id) }}" class="hover:text-indigo-600 transition">{{ $materi->judul }}</a>
        <span>&rsaquo;</span>
        <span class="text-indigo-600 dark:text-indigo-400 font-bold">Tambah Sub Materi</span>
    </nav>

    <!-- Form Container -->
    <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
        
        <!-- Header Section -->
        <div class="border-b border-gray-100 dark:border-pink-950/20 pb-4 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-black text-gray-900 dark:text-white">Tambah Sub Materi Baru</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Lengkapi formulir di bawah ini untuk menambahkan sub-materi pada <strong>{{ $materi->judul }}</strong></p>
            </div>
            <a href="{{ route('guru.materi.submateri.index', $materi->id) }}" class="w-9 h-9 rounded-2xl bg-gray-100 dark:bg-cyberdark-800 flex items-center justify-center text-gray-500 hover:text-indigo-600 transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </a>
        </div>

        <form action="{{ route('guru.materi.submateri.store', $materi->id) }}" method="POST" class="space-y-6">
            @csrf

            <!-- 1. Pilihan Tipe Sub Materi -->
            <div class="space-y-6 max-w-4xl mx-auto" x-data="{ tipes: ['teks'] }">

                <!-- Form Content -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            Pilih Tipe Sub Materi <span class="text-rose-500">*</span>
                        </label>
                        <span class="text-[10px] text-gray-400 font-semibold" x-text="`${tipes.length}/4 Tipe Dipilih`"></span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                        
                        <!-- Option: Teks -->
                        <label :class="tipes.includes('teks') ? 'border-sky-500 bg-sky-500/10 text-sky-600 dark:text-sky-400 ring-2 ring-sky-500/20' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-400 hover:bg-gray-100 dark:hover:bg-cyberdark-700'" 
                            class="p-3.5 rounded-2xl border flex flex-col items-center justify-center gap-2 cursor-pointer transition text-center select-none">
                            <input type="checkbox" name="tipe[]" value="teks" x-model="tipes" class="hidden">
                            <i class="fa-solid fa-file-lines text-lg"></i>
                            <span class="text-xs font-bold">Teks / Bacaan</span>
                        </label>

                        <!-- Option: Video -->
                        <label :class="tipes.includes('video') ? 'border-indigo-600 bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 ring-2 ring-indigo-500/20' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-400 hover:bg-gray-100 dark:hover:bg-cyberdark-700'" 
                            class="p-3.5 rounded-2xl border flex flex-col items-center justify-center gap-2 cursor-pointer transition text-center select-none">
                            <input type="checkbox" name="tipe[]" value="video" x-model="tipes" class="hidden">
                            <i class="fa-solid fa-play-circle text-lg"></i>
                            <span class="text-xs font-bold">Video</span>
                        </label>

                        <!-- Option: Interaktif -->
                        <label :class="tipes.includes('interaktif') ? 'border-purple-600 bg-purple-500/10 text-purple-600 dark:text-purple-400 ring-2 ring-purple-500/20' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-400 hover:bg-gray-100 dark:hover:bg-cyberdark-700'" 
                            class="p-3.5 rounded-2xl border flex flex-col items-center justify-center gap-2 cursor-pointer transition text-center select-none">
                            <input type="checkbox" name="tipe[]" value="interaktif" x-model="tipes" class="hidden">
                            <i class="fa-solid fa-gear text-lg"></i>
                            <span class="text-xs font-bold">Interaktif</span>
                        </label>

                        <!-- Option: Praktik -->
                        <label :class="tipes.includes('praktik') ? 'border-amber-500 bg-amber-500/10 text-amber-600 dark:text-amber-400 ring-2 ring-amber-500/20' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-400 hover:bg-gray-100 dark:hover:bg-cyberdark-700'" 
                            class="p-3.5 rounded-2xl border flex flex-col items-center justify-center gap-2 cursor-pointer transition text-center select-none">
                            <input type="checkbox" name="tipe[]" value="praktik" x-model="tipes" class="hidden">
                            <i class="fa-solid fa-code text-lg"></i>
                            <span class="text-xs font-bold">Praktik Kode</span>
                        </label>

                        <!-- Option: Latihan (Baru) -->
                        <label :class="tipes.includes('latihan') ? 'border-emerald-500 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 ring-2 ring-emerald-500/20' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-400 hover:bg-gray-100 dark:hover:bg-cyberdark-700'" 
                            class="p-3.5 rounded-2xl border flex flex-col items-center justify-center gap-2 cursor-pointer transition text-center select-none">
                            <input type="checkbox" name="tipe[]" value="latihan" x-model="tipes" class="hidden">
                            <i class="fa-solid fa-pen-to-square text-lg"></i>
                            <span class="text-xs font-bold">Latihan Soal</span>
                        </label>

                    </div>

                    <!-- Warning jika tidak ada tipe yang dipilih -->
                    <p x-show="tipes.length === 0" class="text-[11px] text-rose-500 font-semibold mt-1">
                        * Pilih minimal 1 tipe sub materi.
                    </p>
                </div>

            </div>

            <!-- 2. Judul Sub Materi -->
            <div class="space-y-1">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Judul Sub Materi <span class="text-rose-500">*</span></label>
                <input type="text" name="judul_sub" placeholder="Contoh: Pengertian Video Pembelajaran" class="w-full px-4 py-2.5 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
            </div>

            <!-- 3. Deskripsi Singkat -->
            <div class="space-y-1">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Deskripsi Ringkas</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan ringkasan materi atau tujuan pembelajaran dari sub bab ini..." class="w-full p-3 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none"></textarea>
            </div>

            <!-- 4. Estimasi Waktu, Status, XP Reward & Urutan -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                
                <!-- Estimasi Waktu -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Estimasi Waktu <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <i class="fa-regular fa-clock absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-gray-400"></i>
                        <input type="text" name="estimasi_waktu" placeholder="Contoh: 15 menit" value="10 menit" class="w-full pl-9 pr-4 py-2.5 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                    </div>
                </div>

                <!-- XP Reward -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 flex items-center gap-1">
                        <i class="fa-solid fa-bolt text-xs"></i> XP Reward <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-star absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-amber-500"></i>
                        <input type="number" name="xp_reward" min="0" step="5" value="25" placeholder="25" class="w-full pl-9 pr-4 py-2.5 text-xs rounded-2xl border border-amber-200 dark:border-amber-950/40 bg-amber-50/30 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:outline-none font-bold" required>
                    </div>
                </div>

                <!-- Status Publikasi -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Status <span class="text-rose-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2.5 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="terbit">Terbit</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <!-- Urutan Sub Bab -->
                <div class="space-y-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">Urutan Bab</label>
                    <input type="number" name="urutan" min="1" placeholder="Auto / Otomatis" class="w-full px-4 py-2.5 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

            </div>

            <!-- Actions Footer -->
            <div class="pt-4 border-t border-gray-100 dark:border-pink-950/20 flex items-center justify-end gap-3">
                <a href="{{ route('guru.materi.submateri.index', $materi->id) }}" class="px-5 py-2.5 rounded-2xl border border-gray-200 dark:border-pink-950/30 text-xs font-bold text-gray-500 hover:bg-gray-100 dark:hover:bg-cyberdark-800 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md transition active:scale-95 flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Sub Materi
                </button>
            </div>

        </form>

    </div>
</div>
@endsection