<div class="space-y-4" 
     x-data="{
         showDeskripsi: !!block.arahan,
         // Helper untuk mengonversi berbagai format URL YouTube menjadi URL Embed valid
         getEmbedUrl(url) {
             if (!url) return '';
             let videoId = '';
             
             if (url.includes('youtube.com/watch?v=')) {
                 videoId = url.split('v=')[1]?.split('&')[0];
                 return `https://www.youtube.com/embed/${videoId}`;
             } else if (url.includes('youtu.be/')) {
                 videoId = url.split('youtu.be/')[1]?.split('?')[0];
                 return `https://www.youtube.com/embed/${videoId}`;
             }
             return url;
         }
     }">

    <!-- Input URL Video Pembelajaran -->
    <div class="space-y-1">
        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            URL Video Pembelajaran (YouTube / Google Drive)
        </label>
        
        <input type="url" 
               :name="`sections[${index}][isi]`" 
               x-model="block.isi" 
               placeholder="Contoh: https://www.youtube.com/watch?v=... atau https://youtu.be/..." 
               class="w-full px-4 py-2.5 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-white dark:bg-cyberdark-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
        
        <p class="text-[11px] text-gray-400">
            Dukung link YouTube biasa, link pendek (youtu.be), atau embed link Google Drive.
        </p>
    </div>

    <!-- Toggle & Input Deskripsi / Arahan Tambahan Video -->
    <div class="pt-2 border-t border-gray-100 dark:border-pink-950/20">
        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
            <input type="checkbox" 
                   x-model="showDeskripsi" 
                   @change="if (!showDeskripsi) block.arahan = ''"
                   class="w-4 h-4 rounded text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-pink-950/30">
            <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1.5">
                <i class="fa-solid fa-align-left"></i> Tambahkan Teks Deskripsi / Instruksi Video
            </span>
        </label>
    </div>

    <div x-show="showDeskripsi" x-transition class="space-y-1 pl-4 border-l-2 border-indigo-500">
        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Deskripsi / Catatan Instruksi Video
        </label>
        <textarea :name="`sections[${index}][arahan]`" 
                  x-model="block.arahan" 
                  rows="3" 
                  placeholder="Tuliskan petunjuk tontonan, poin penting, atau deskripsi ringkas video di sini..." 
                  class="w-full p-3 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-white dark:bg-cyberdark-900 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 leading-relaxed"></textarea>
    </div>

    <!-- Live Preview Video & Deskripsi -->
    <template x-if="block.isi">
        <div class="space-y-2 pt-2">
            <span class="block text-[11px] font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                <i class="fa-solid fa-circle-play mr-1"></i> Preview Tampilan Video
            </span>
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden border border-gray-200 dark:border-pink-950/30 bg-black/5 dark:bg-cyberdark-800">
                <iframe :src="getEmbedUrl(block.isi)" 
                        class="w-full h-full border-0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
            </div>

        </div>
    </template>
</div>