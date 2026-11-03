
<div
    class="space-y-4"
    x-data="{
        options: [],

        initLatihan() {
            this.$nextTick(() => {
                let savedOptions = this.block.clue;

                try {
                    if (typeof savedOptions === 'string') {
                        savedOptions = JSON.parse(savedOptions);
                    }

                    this.options = Array.isArray(savedOptions)
                        ? savedOptions.map(item => ({
                            text: String(item.text ?? '')
                        }))
                        : [];

                } catch (error) {
                    this.options = [];
                }

                if (this.options.length === 0) {
                    this.options = [
                        { text: '<h1>' },
                        { text: 'Hello World' },
                        { text: '</h1>' },
                        { text: '<h2>' }
                    ];
                }

                this.syncJSON();
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
            this.block.clue = JSON.stringify(
                this.options.map(option => ({
                    text: option.text
                }))
            );
        }
    }"
    x-init="initLatihan()"
>

    {{-- PERTANYAAN --}}
    <div class="space-y-1">
        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Soal / Instruksi Latihan
        </label>

        <textarea
            :name="`sections[${index}][isi]`"
            x-model="block.isi"
            rows="3"
            placeholder="Contoh: Buat heading dengan teks Hello World"
            class="w-full rounded-2xl border border-gray-200 bg-white p-3 text-xs text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-pink-950/30 dark:bg-cyberdark-900 dark:text-white"
        ></textarea>
    </div>

    {{-- KUNCI JAWABAN --}}
    <div class="space-y-2 rounded-2xl border border-indigo-200 bg-indigo-50/30 p-4 dark:border-indigo-950/40 dark:bg-indigo-950/10">

        <label class="block text-xs font-bold text-indigo-600 dark:text-indigo-400">
            Kunci Urutan Jawaban Benar
        </label>

        <input
            type="text"
            :name="`sections[${index}][arahan]`"
            x-model="block.arahan"
            placeholder="<h1> | Hello World | </h1>"
            class="w-full rounded-xl border border-indigo-200 bg-white px-4 py-3 text-xs text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-indigo-950/40 dark:bg-cyberdark-800 dark:text-white"
        >

        <p class="text-[11px] leading-relaxed text-gray-500">
            Masukkan urutan blok yang benar dari kiri ke kanan. Pisahkan setiap blok menggunakan tanda |.
        </p>

        <div class="rounded-lg bg-white p-3 dark:bg-cyberdark-900">
            <p class="mb-2 text-[10px] font-bold uppercase text-gray-400">
                Contoh jawaban benar
            </p>

            <div class="flex flex-wrap items-center gap-2">
                <template
                    x-for="(part, i) in (block.arahan || '').split('|')"
                    :key="i"
                >
                    <span
                        class="rounded-md bg-gray-800 px-3 py-2 font-mono text-xs text-blue-300"
                        x-text="part.trim()"
                    ></span>
                </template>
            </div>
        </div>
    </div>

    {{-- PILIHAN BLOK --}}
    <div class="space-y-3 border-t border-gray-100 pt-4 dark:border-pink-950/20">

        <div class="flex items-center justify-between gap-2">
            <label class="text-xs font-bold text-gray-700 dark:text-gray-300">
                Pilihan Blok Kode
            </label>

            <button
                type="button"
                @click="addOption()"
                class="flex items-center gap-1 rounded-xl bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-600 hover:bg-indigo-100 dark:bg-indigo-950/40 dark:text-indigo-400"
            >
                <i class="fa-solid fa-plus"></i>
                Tambah Blok
            </button>
        </div>

        {{-- JSON CLUE --}}
        <input
            type="hidden"
            :name="`sections[${index}][clue]`"
            :value="block.clue"
        >

        <div class="space-y-2">

            <template x-for="(opt, optIdx) in options" :key="optIdx">

                <div class="flex items-center gap-2">

                    <span
                        class="w-6 text-right text-xs font-bold text-gray-400"
                        x-text="(optIdx + 1) + '.'"
                    ></span>

                    <input
                        type="text"
                        x-model="opt.text"
                        @input="syncJSON()"
                        placeholder="Contoh: <h1>"
                        class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-white px-3 py-3 font-mono text-xs text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-pink-950/30 dark:bg-cyberdark-900 dark:text-white"
                    >

                    <button
                        type="button"
                        @click="removeOption(optIdx)"
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-600 hover:text-white"
                    >
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>

                </div>

            </template>

        </div>

        <p class="text-[11px] text-gray-400">
            Blok-blok ini akan ditampilkan secara acak kepada siswa, termasuk blok pengecoh.
        </p>

    </div>

</div>
