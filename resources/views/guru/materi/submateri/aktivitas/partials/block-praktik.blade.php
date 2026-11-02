<div class="space-y-4" 
     x-data="{
         // Pemetaan Starter Code Default berdasarkan bahasa
         setLanguage(lang) {
             if (!this.block.isi) {
                 if (lang === 'html') {
                     this.block.isi = '<!DOCTYPE html>\n<html>\n<body>\n\n<h1>My First Heading</h1>\n<p>My first paragraph.</p>\n\n</body>\n</html>';
                 } else if (lang === 'python') {
                     this.block.isi = '# Tulis kode Python Anda di sini\nprint("Hello, World!")';
                 } else if (lang === 'css') {
                     this.block.isi = '/* Tulis kode CSS Anda di sini */\nbody {\n    background-color: #f0f0f0;\n}';
                 }
             }
         }
     }">

    <!-- 1. Judul / Instruksi Praktik Kode -->
    <div class="space-y-1">
        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Judul / Instruksi Praktik Kode
        </label>
        <input type="text" 
               :name="`sections[${index}][arahan]`" 
               x-model="block.arahan" 
               placeholder="Contoh: Example 1 - Dasar Pemrograman HTML" 
               class="w-full px-4 py-2.5 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-white dark:bg-cyberdark-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
    </div>

    <!-- 2. Pilihan Bahasa Pemrograman -->
    <div class="space-y-1">
        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Bahasa Pemrograman
        </label>
        <select :name="`sections[${index}][tips]`" 
                x-model="block.tips" 
                @change="setLanguage($event.target.value)"
                class="w-full px-4 py-2.5 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-white dark:bg-cyberdark-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
            <option value="html">HTML / CSS / JS</option>
            <option value="python">Python</option>
            <option value="css">CSS Only</option>
        </select>
    </div>

    <!-- 3. Starter Code (Kode Awal yang Ditampilkan ke Siswa) -->
    <div class="space-y-1">
        <label class="block text-xs font-bold text-amber-600 dark:text-amber-400">
            Starter Code / Contoh Kode awal
        </label>
        <textarea :name="`sections[${index}][isi]`" 
                  x-model="block.isi" 
                  rows="8" 
                  placeholder="Tuliskan kode program dasar di sini..." 
                  class="w-full p-4 text-xs font-mono rounded-2xl border border-gray-800 bg-gray-950 text-emerald-400 focus:outline-none leading-relaxed"></textarea>
    </div>
</div>