@extends('guru.layouts.app')

@section('title', 'Edit tahapan ruang belajar')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/80 dark:bg-cyberdark-900/80 backdrop-blur-xl border border-gray-200/80 dark:border-pink-950/30 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs font-bold transition-all duration-300 shadow-sm hover:shadow-indigo-500/10 hover:-translate-x-1">
            <i class="fa-solid fa-arrow-left text-xs text-indigo-500"></i>
            <span>Kembali ke Peta Tahapan</span>
        </a>
    </div>

    <!-- Card Form Tambah Tahapan -->
    <div class="bg-white/80 dark:bg-cyberdark-900/90 backdrop-blur-2xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
        
        <!-- Header Title -->
        <div class="flex items-center gap-3.5 pb-4 border-b border-gray-100 dark:border-pink-950/20">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-600 text-white flex items-center justify-center text-xl shadow-md shadow-indigo-500/20 shrink-0">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-black text-gray-900 dark:text-white">Edit Tahapan Pembelajaran</h2>
                <p class="text-xs text-gray-400">Edit stage untuk ruang belajar: <span class="font-bold text-indigo-500">{{ $ruangBelajar->judul }}</span></p>
            </div>
        </div>

        <!-- Form Input -->
        <form action="{{ route('guru.ruang-belajar.tahapan.update', [$ruangBelajar->id, $tahapan->id]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Pilihan Tipe Tahapan -->
            <div class="space-y-1.5 p-4 rounded-2xl bg-indigo-50/50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-900/30">
                <label for="tipe" class="block text-xs font-bold text-indigo-900 dark:text-indigo-300">
                    Pilih Tipe Aktivitas Tahapan <span class="text-rose-500">*</span>
                </label>
                <select name="tipe" 
                        id="tipe" 
                        required
                        class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-indigo-500 font-semibold transition">
                    <option value="" disabled {{ old('tipe', $tahapan->tipe ?? '') ? '' : 'selected' }}>-- Pilih Tipe Aktivitas --</option>
                    <option value="apersepsi" {{ old('tipe', $tahapan->tipe ?? '') == 'apersepsi' ? 'selected' : '' }}>💡 Apersepsi (Teks & Pertanyaan Pemantik + Forum Diskusi)</option>
                    <option value="ice_breaking" {{ old('tipe', $tahapan->tipe ?? '') == 'ice_breaking' ? 'selected' : '' }}>🎮 Ice Breaking (Input Video / Gambar)</option>
                    <option value="jeda_hening" {{ old('tipe', $tahapan->tipe ?? '') == 'jeda_hening' ? 'selected' : '' }}>🧘 Jeda Hening & Check-in (Kesadaran Diri & Pernapasan)</option>
                    <option value="pre_test" {{ old('tipe', $tahapan->tipe ?? '') == 'pre_test' ? 'selected' : '' }}>📝 Pre-Test (Pilih dari Ruang Ujian)</option>
                    <option value="materi" {{ old('tipe', $tahapan->tipe ?? '') == 'materi' ? 'selected' : '' }}>📚 Materi (Ambil dari Ruang Materi)</option>
                    <option value="lkpd" {{ old('tipe', $tahapan->tipe ?? '') == 'lkpd' ? 'selected' : '' }}>👥 LKPD (Tugas Individu/Kelompok & Upload File)</option>
                    <option value="evaluasi" {{ old('tipe', $tahapan->tipe ?? '') == 'evaluasi' ? 'selected' : '' }}>❓ Evaluasi (Input Pertanyaan & Kendala Kebingungan)</option>
                    <option value="kesimpulan" {{ old('tipe', $tahapan->tipe ?? '') == 'kesimpulan' ? 'selected' : '' }}>📌 Kesimpulan (Teks/Gambar & Forum Diskusi)</option>
                    <option value="refleksi" {{ old('tipe', $tahapan->tipe ?? '') == 'refleksi' ? 'selected' : '' }}>⭐ Refleksi (Pertanyaan & Bintang Kepuasan)</option>
                    <option value="post_test" {{ old('tipe', $tahapan->tipe ?? '') == 'post_test' ? 'selected' : '' }}>🏁 Post-Test (Pilih dari Ruang Ujian)</option>
                    <option value="tindak_lanjut" {{ old('tipe', $tahapan->tipe ?? '') == 'tindak_lanjut' ? 'selected' : '' }}>🚀 Tindak Lanjut (Materi / Proyek & Pengumpulan Tugas)</option>
                </select>
                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">Ubah tipe aktivitas tahapan jika diperlukan.</p>
                @error('tipe')
                    <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>
            <!-- Judul Tahapan -->
            <div class="space-y-1.5">
                <label for="judul_tahapan" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                    Nama / Judul Tahapan <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                    name="judul_tahapan" 
                    id="judul_tahapan" 
                    value="{{ old('judul_tahapan', $tahapan->judul_tahapan) }}"
                    placeholder="Contoh: Pengenalan Pemrograman atau Array & Data" 
                    required
                    class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                @error('judul_tahapan')
                    <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Grid Urutan & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Urutan Stage -->
                <div class="space-y-1.5">
                    <label for="urutan" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Urutan Stage <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                        name="urutan" 
                        id="urutan" 
                        value="{{ old('urutan', $tahapan->urutan) }}"
                        min="1"
                        required
                        class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                    @error('urutan')
                        <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Tahapan -->
                <div class="space-y-1.5">
                    <label for="status" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Status Tahapan <span class="text-rose-500">*</span>
                    </label>
                    <select name="status" 
                            id="status" 
                            required
                            class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="terkunci" {{ old('status', $tahapan->status) == 'terkunci' ? 'selected' : '' }}>Terkunci (Default)</option>
                        <option value="aktif" {{ old('status', $tahapan->status) == 'aktif' ? 'selected' : '' }}>Aktif (Sedang Dipelajari)</option>
                        <option value="selesai" {{ old('status', $tahapan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Grid Icon Picker & XP Reward -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5" 
                x-data="{ selectedIcon: '{{ old('icon', $tahapan->icon ?? 'fa-flag') }}' }">
                
                <!-- Icon Picker FontAwesome dengan Category Presets -->
                <div class="space-y-2 sm:col-span-1">
                    <label for="icon" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Ikon Stage Pembelajaran <span class="text-rose-500">*</span>
                    </label>
                    
                    <!-- Input Text & Live Icon Preview (PENTING: x-model terhubung ke name="icon") -->
                    <div class="relative">
                        <input type="text" 
                            name="icon" 
                            id="icon" 
                            x-model="selectedIcon"
                            placeholder="fa-flag, fa-star, fa-gift..." 
                            required
                            class="w-full pl-4 pr-10 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-indigo-500 transition">
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 w-7 h-7 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-sm shadow-xs">
                            <i class="fa-solid" :class="selectedIcon"></i>
                        </div>
                    </div>
                    @error('icon')
                        <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Quick Preset Icon Picker Buttons -->
                    <div class="space-y-2 pt-1">
                        <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Pilih Preset Ikon Tahapan:</p>
                        
                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                            <!-- 1. START ICON -->
                            <button type="button" 
                                    @click="selectedIcon = 'fa-flag'" 
                                    :class="selectedIcon === 'fa-flag' ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 font-bold' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-cyberdark-800'"
                                    class="p-2 rounded-xl border flex items-center gap-2 transition active:scale-95 text-left cursor-pointer">
                                <div class="w-6 h-6 rounded-lg bg-pink-500/10 text-pink-500 flex items-center justify-center text-xs shrink-0">
                                    <i class="fa-solid fa-flag"></i>
                                </div>
                                <div>
                                    <span class="block text-[10px] leading-none">Start</span>
                                    <span class="text-[9px] text-gray-400 font-normal">fa-flag</span>
                                </div>
                            </button>

                            <!-- 2. STAR / LANGKAH ICON -->
                            <button type="button" 
                                    @click="selectedIcon = 'fa-star'" 
                                    :class="selectedIcon === 'fa-star' ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 font-bold' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-cyberdark-800'"
                                    class="p-2 rounded-xl border flex items-center gap-2 transition active:scale-95 text-left cursor-pointer">
                                <div class="w-6 h-6 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center text-xs shrink-0">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div>
                                    <span class="block text-[10px] leading-none">Proses (Star)</span>
                                    <span class="text-[9px] text-gray-400 font-normal">fa-star</span>
                                </div>
                            </button>

                            <!-- 3. HADIAH ICON -->
                            <button type="button" 
                                    @click="selectedIcon = 'fa-gift'" 
                                    :class="selectedIcon === 'fa-gift' ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 font-bold' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-cyberdark-800'"
                                    class="p-2 rounded-xl border flex items-center gap-2 transition active:scale-95 text-left cursor-pointer">
                                <div class="w-6 h-6 rounded-lg bg-purple-500/10 text-purple-500 flex items-center justify-center text-xs shrink-0">
                                    <i class="fa-solid fa-gift"></i>
                                </div>
                                <div>
                                    <span class="block text-[10px] leading-none">Hadiah</span>
                                    <span class="text-[9px] text-gray-400 font-normal">fa-gift</span>
                                </div>
                            </button>

                            <!-- 4. END / FINISH ICON -->
                            <button type="button" 
                                    @click="selectedIcon = 'fa-trophy'" 
                                    :class="selectedIcon === 'fa-trophy' ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 font-bold' : 'border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-cyberdark-800'"
                                    class="p-2 rounded-xl border flex items-center gap-2 transition active:scale-95 text-left cursor-pointer">
                                <div class="w-6 h-6 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xs shrink-0">
                                    <i class="fa-solid fa-trophy"></i>
                                </div>
                                <div>
                                    <span class="block text-[10px] leading-none">End / Finish</span>
                                    <span class="text-[9px] text-gray-400 font-normal">fa-trophy</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- XP Reward -->
                <div id="xpRewardWrapper" class="space-y-1.5 sm:col-span-1">
                    <label for="xp_reward" class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                        Bonus XP (Reward Stage) <span class="text-rose-500">*</span>
                    </label>

                    <div class="relative">
                        <input type="number"
                            name="xp_reward"
                            id="xp_reward"
                            value="{{ old('xp_reward', $tahapan->xp_reward) }}"
                            step="50"
                            min="0"
                            class="w-full pl-4 pr-12 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-800 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-indigo-500 transition">

                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-amber-500 bg-amber-500/10 px-2 py-0.5 rounded-md">
                            XP
                        </span>
                    </div>

                    <p class="text-[10px] text-gray-500 dark:text-gray-400">
                        Untuk Pre-Test dan Post-Test, EXP dihitung otomatis berdasarkan total EXP dari seluruh soal pada Ruang Ujian yang dipilih.
                    </p>

                    @error('xp_reward')
                        <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 dark:border-pink-950/20">
                <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}" 
                class="px-5 py-2.5 rounded-2xl bg-gray-100 dark:bg-cyberdark-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-cyberdark-700 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-extrabold shadow-md shadow-indigo-500/20 transition active:scale-95 cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipeSelect = document.getElementById('tipe');
    const xpRewardWrapper = document.getElementById('xpRewardWrapper');
    const xpRewardInput = document.getElementById('xp_reward');

    function toggleXpReward() {
        if (!tipeSelect || !xpRewardWrapper || !xpRewardInput) return;

        const tipeUjian = ['pre_test', 'post_test'].includes(tipeSelect.value);

        if (tipeUjian) {
            xpRewardWrapper.classList.add('hidden');
            xpRewardInput.disabled = true;
            xpRewardInput.required = false;
        } else {
            xpRewardWrapper.classList.remove('hidden');
            xpRewardInput.disabled = false;
            xpRewardInput.required = true;
        }
    }

    tipeSelect.addEventListener('change', toggleXpReward);

    // Menyesuaikan tampilan berdasarkan tipe tahapan saat edit dibuka
    toggleXpReward();
});
</script>
@endsection