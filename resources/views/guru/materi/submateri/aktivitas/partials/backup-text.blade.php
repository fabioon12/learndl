<div class="space-y-4" 
     x-data="{ 
         showTipsInput: !!block.tips,
         initTrix() {
             this.$nextTick(() => {
                 const editorEl = this.$refs.trixEditor;
                 if (editorEl) {
                     // 1. Sinkronisasi nilai awal jika dalam mode Edit
                     if (this.block.isi) {
                         if (editorEl.editor) {
                             editorEl.editor.loadHTML(this.block.isi);
                         } else {
                             editorEl.addEventListener('trix-initialize', () => {
                                 editorEl.editor.loadHTML(this.block.isi);
                             }, { once: true });
                         }
                     }
                 }
             });
         }
     }"
     x-init="initTrix()">

    <div class="space-y-1">
        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Isi Konten Teks & Gambar
        </label>
        
        <!-- Input Hidden Native yang dibaca Laravel saat Submit Form -->
        <input type="hidden" 
               :name="`sections[${index}][isi]`" 
               :value="block.isi || ''">
        
        <!-- Trix Editor: Gunakan $event.target.value (BUKAN innerHTML) -->
        <trix-editor x-ref="trixEditor"
                     placeholder="Tuliskan isi konten di sini..."
                     class="trix-content text-xs"
                     @trix-change="block.isi = $event.target.value"></trix-editor>
    </div>

    <!-- Toggle & Input Tips -->
    <div class="pt-2 border-t border-gray-100 dark:border-pink-950/20">
        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
            <input type="checkbox" 
                   x-model="showTipsInput" 
                   @change="if (!showTipsInput) block.tips = ''"
                   class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-pink-950/30">
            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1.5">
                <i class="fa-solid fa-lightbulb"></i> Tambahkan Catatan / Tips Penting pada Teks Ini
            </span>
        </label>
    </div>

    <div x-show="showTipsInput" x-transition class="space-y-1 pl-4 border-l-2 border-indigo-500">
        <label class="block text-xs font-bold text-amber-600 dark:text-amber-400">Isi Tips / Catatan Penting</label>
        <textarea :name="`sections[${index}][tips]`" 
                  x-model="block.tips" 
                  rows="2" 
                  placeholder="Contoh: Tips: Pastikan sintaks..." 
                  class="w-full p-3 text-xs rounded-2xl border border-amber-200 dark:border-amber-950/30 bg-amber-50/20 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:outline-none"></textarea>
    </div>
</div>