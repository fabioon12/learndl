<div x-show="block.tipe === 'interaktif'" class="space-y-1">
    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400">Instruksi / Simulasi Interaktif</label>
    <textarea :name="`sections[${index}][isi]`" rows="3" placeholder="Tuliskan petunjuk simulasi interaktif..." class="w-full p-3 text-xs rounded-2xl border border-gray-200 dark:border-pink-950/30 bg-gray-50/50 dark:bg-cyberdark-800 text-gray-900 dark:text-white focus:outline-none"></textarea>
</div>