<div class="space-y-4" 
     x-data="{
         // Array untuk menampung tombol/blok opsi HTML
         options: [],
         initLatihan() {
             this.$nextTick(() => {
                 // Muat opsi dari clue jika sedang mode edit data
                 if (this.block.clue) {
                     try {
                         this.options = typeof this.block.clue === 'string' 
                             ? JSON.parse(this.block.clue) 
                             : this.block.clue;
                     } catch (e) {
                         this.options = [];
                     }
                 }
                 // Jika opsi kosong, berikan 3 input default
                 if (!this.options || this.options.length === 0) {
                     this.options = [
                         { text: '<h1>' },
                         { text: 'My Webpage' },
                         { text: '</h1>' }
                     ];
                     this.syncJSON();
                 }
             });
         },
         addOption() {
             this.options.push({ text: '' });
             this.syncJSON();
         },
         removeOption(idx) {
             this.options.splice(idx, 1);
             this.syncJSON();
         },
         syncJSON() {
             // Simpan array opsi ke bentuk JSON string di block.clue
             this.block.clue = JSON.stringify(this.options);
         }
     }"
     x-init="initLatihan()">

    <!-- 1. Pertanyaan / Instruksi Soal -->
    <div class="space-y-1">
        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Soal / Pertanyaan Latihan Interaktif
        </label>
        <textarea :name="`sections[${index}][isi]`" 
                  x-model="block.isi" 
                  rows="3" 
                  placeholder="Contoh: Create a heading with the text &quot;My Webpage&quot;" 
                  class="w-full p-3 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-white dark:bg-cyberdark-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 leading-relaxed"></textarea>
    </div>

    <!-- 2. Kunci Urutan Jawaban Benar -->
    <div class="space-y-1">
        <label class="block text-xs font-bold text-indigo-600 dark:text-indigo-400">
            Kunci Urutan Jawaban Benar (Pisahkan dengan tanda | )
        </label>
        <input type="text" 
               :name="`sections[${index}][arahan]`" 
               x-model="block.arahan" 
               placeholder="Contoh: <h1> | My Webpage | </h1>" 
               class="w-full px-4 py-2.5 text-xs rounded-2xl border border-indigo-200 dark:border-indigo-950/40 bg-indigo-50/20 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <p class="text-[11px] text-gray-400">
            Tuliskan potongan tag/teks berurutan dari kiri ke kanan yang menjadi kunci jawaban benar.
        </p>
    </div>

    <!-- 3. Kelola Opsi Tombol/Blok HTML (Daftar Opsi yang Ditampilkan ke Siswa) -->
    <div class="space-y-3 pt-2 border-t border-gray-100 dark:border-pink-950/20">
        <div class="flex items-center justify-between">
            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
                Pilihan Tombol / Blok HTML (Termasuk Opsi Pengecoh)
            </label>
            <button type="button" 
                    @click="addOption()" 
                    class="px-3 py-1.5 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-xs font-bold hover:bg-indigo-100 transition flex items-center gap-1">
                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Opsi Blok
            </button>
        </div>

        <!-- Hidden input untuk mengirim JSON string daftar opsi ke database -->
        <input type="hidden" :name="`sections[${index}][clue]`" :value="block.clue">

        <!-- List Input Opsi Blok -->
        <div class="space-y-2">
            <template x-for="(opt, optIdx) in options" :key="optIdx">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-400 w-5 text-right" x-text="optIdx + 1 + '.'"></span>
                    <input type="text" 
                           x-model="opt.text" 
                           @input="syncJSON()" 
                           placeholder="Contoh: <h1> atau <h2>" 
                           class="flex-1 px-3 py-2 text-xs rounded-xl border border-gray-200 dark:border-pink-950/30 bg-white dark:bg-cyberdark-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <button type="button" 
                            @click="removeOption(optIdx)" 
                            class="w-7 h-7 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-600 hover:text-white transition flex items-center justify-center">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>
            </template>
        </div>
    </div>
</div>