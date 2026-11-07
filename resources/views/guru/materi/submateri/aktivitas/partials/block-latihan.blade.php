
<div
    class="space-y-5"
    x-data="{
        options: [],
        answerIds: [],
        previewIds: [],
        previewMode: false,
        previewResult: null,
        nextId: 1,

        initLatihan() {
            let savedOptions = this.block.clue;

            try {
                if (typeof savedOptions === 'string') {
                    savedOptions = JSON.parse(savedOptions);
                }

                this.options = Array.isArray(savedOptions)
                    ? savedOptions.map(item => ({
                        id: this.nextId++,
                        text: String(item.text ?? '')
                    }))
                    : [];
            } catch (e) {
                this.options = [];
            }

            // Default contoh untuk soal baru
            if (
                this.options.length === 0 &&
                !this.block.arahan
            ) {
                this.options = [
                    { id: this.nextId++, text: '<h1>' },
                    { id: this.nextId++, text: 'My Webpage' },
                    { id: this.nextId++, text: '</h1>' },
                    { id: this.nextId++, text: '<h2>' }
                ];
            }

            // Pulihkan kunci jawaban dari data lama.
            // Pencocokan berdasarkan teks dan urutan kemunculan.
            const parts = String(this.block.arahan || '')
                .split('|')
                .map(s => s.trim())
                .filter(Boolean);

            const used = new Set();

            this.answerIds = [];

            parts.forEach(part => {
                const option = this.options.find(opt =>
                    opt.text.trim() === part &&
                    !used.has(opt.id)
                );

                if (option) {
                    this.answerIds.push(option.id);
                    used.add(option.id);
                }
            });

            this.syncData();
        },

        addOption() {
            this.options.push({
                id: this.nextId++,
                text: ''
            });

            this.previewResult = null;
            this.syncData();
        },

        removeOption(id) {
            this.options = this.options.filter(
                option => option.id !== id
            );

            this.answerIds = this.answerIds.filter(
                answerId => answerId !== id
            );

            this.previewIds = this.previewIds.filter(
                previewId => previewId !== id
            );

            this.previewResult = null;
            this.syncData();
        },

        getOption(id) {
            return this.options.find(
                option => option.id === id
            );
        },

        addToAnswer(id) {
            const option = this.getOption(id);

            if (!option || !option.text.trim()) return;

            if (this.answerIds.includes(id)) return;

            this.answerIds.push(id);
            this.syncData();
        },

        removeFromAnswer(id) {
            this.answerIds = this.answerIds.filter(
                answerId => answerId !== id
            );

            this.syncData();
        },

        moveAnswer(index, direction) {
            const target = index + direction;

            if (
                target < 0 ||
                target >= this.answerIds.length
            ) return;

            const temp = this.answerIds[index];

            this.answerIds[index] = this.answerIds[target];
            this.answerIds[target] = temp;

            this.syncData();
        },

        clearAnswer() {
            this.answerIds = [];
            this.syncData();
        },

        syncData() {
            // Format lama dipertahankan untuk controller.
            this.block.clue = JSON.stringify(
                this.options.map(option => ({
                    text: option.text
                }))
            );

            this.block.arahan = this.answerIds
                .map(id => this.getOption(id)?.text ?? '')
                .join('|');
        },

        shuffle(array) {
            const result = [...array];

            for (let i = result.length - 1; i > 0; i--) {
                const j = Math.floor(
                    Math.random() * (i + 1)
                );

                [result[i], result[j]] = [
                    result[j],
                    result[i]
                ];
            }

            return result;
        },

        startPreview() {
            this.previewIds = [];
            this.previewResult = null;
            this.previewMode = true;
        },

        addPreview(id) {
            if (this.previewIds.includes(id)) return;

            this.previewIds.push(id);
            this.previewResult = null;
        },

        removePreview(id) {
            this.previewIds = this.previewIds.filter(
                previewId => previewId !== id
            );

            this.previewResult = null;
        },

        checkPreview() {
            const correct =
                this.previewIds.length ===
                this.answerIds.length &&
                this.previewIds.every(
                    (id, index) =>
                        id === this.answerIds[index]
                );

            this.previewResult = correct
                ? 'correct'
                : 'wrong';
        },

        get distractorCount() {
            return this.options.filter(
                opt => !this.answerIds.includes(opt.id)
            ).length;
        },

        get availableOptions() {
            return this.options.filter(
                opt => opt.text.trim() !== ''
            );
        }
    }"
    x-init="initLatihan()"
>

    <!-- Hidden field untuk controller Laravel -->
    <input
        type="hidden"
        :name="`sections[${index}][arahan]`"
        :value="block.arahan || ''"
    >

    <input
        type="hidden"
        :name="`sections[${index}][clue]`"
        :value="block.clue || '[]'"
    >

    <!-- HEADER -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                <i class="fa-solid fa-code text-lg"></i>
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    Code Block Puzzle
                </h3>

                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                    Buat tantangan menyusun kode program.
                </p>
            </div>
        </div>

        <span class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-[11px] font-semibold text-indigo-600 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-300">
            <i class="fa-solid fa-puzzle-piece mr-1"></i>
            Latihan Interaktif
        </span>
    </div>

    <!-- INSTRUKSI -->
    <div class="space-y-2">
        <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-200">
            <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-100 text-[11px] text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                1
            </span>
            Instruksi / Soal Latihan
        </label>

        <textarea
            :name="`sections[${index}][isi]`"
            x-model="block.isi"
            rows="3"
            placeholder='Contoh: Buat heading dengan teks "My Webpage"'
            class="w-full resize-y rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm leading-relaxed text-gray-900 outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-white dark:placeholder-gray-500"
        ></textarea>

        <p class="text-[11px] text-gray-400">
            Instruksi ini akan ditampilkan kepada siswa sebelum menyusun kode.
        </p>
    </div>

    <!-- PILIHAN BLOK -->
    <div class="space-y-3 rounded-2xl border border-gray-200 bg-gray-50/60 p-4 dark:border-white/10 dark:bg-white/[0.02]">

        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <h4 class="flex items-center gap-2 text-xs font-bold text-gray-800 dark:text-gray-200">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-100 text-[11px] text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                        2
                    </span>
                    Pilihan Blok Kode
                </h4>

                <p class="mt-1 text-[11px] text-gray-500">
                    Tambahkan semua potongan kode, termasuk pengecoh.
                </p>
            </div>

            <button
                type="button"
                @click="addOption()"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700"
            >
                <i class="fa-solid fa-plus"></i>
                Tambah Blok
            </button>
        </div>

        <div class="space-y-2">
            <template
                x-for="(opt, optIdx) in options"
                :key="opt.id"
            >
                <div class="flex items-center gap-2">

                    <span
                        class="w-6 shrink-0 text-center font-mono text-xs font-semibold text-gray-400"
                        x-text="String(optIdx + 1).padStart(2, '0')"
                    ></span>

                    <div class="relative min-w-0 flex-1">
                        <input
                            type="text"
                            x-model="opt.text"
                            @input="syncData(); previewResult = null"
                            placeholder="Contoh: <h1>"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 pr-24 font-mono text-xs text-gray-900 outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-blue-300"
                        >

                        <span
                            x-show="answerIds.includes(opt.id)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md bg-emerald-50 px-2 py-1 text-[10px] font-semibold text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400"
                        >
                            Jawaban
                        </span>

                        <span
                            x-show="!answerIds.includes(opt.id) && opt.text.trim()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 rounded-md bg-amber-50 px-2 py-1 text-[10px] font-semibold text-amber-600 dark:bg-amber-500/10 dark:text-amber-400"
                        >
                            Pengecoh
                        </span>
                    </div>

                    <button
                        type="button"
                        @click="removeOption(opt.id)"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-rose-100 bg-white text-rose-500 transition hover:border-rose-500 hover:bg-rose-500 hover:text-white dark:border-rose-500/20 dark:bg-rose-500/10"
                        title="Hapus blok"
                        aria-label="Hapus blok"
                    >
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>

                </div>
            </template>
        </div>

        <div
            x-show="options.length === 0"
            class="rounded-xl border border-dashed border-gray-300 px-4 py-8 text-center dark:border-white/10"
        >
            <i class="fa-solid fa-cubes mb-2 text-xl text-gray-300"></i>

            <p class="text-xs text-gray-500">
                Belum ada blok kode. Klik Tambah Blok.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3 border-t border-gray-200 pt-3 text-[11px] dark:border-white/10">
            <span class="text-gray-500">
                Total:
                <strong
                    class="text-gray-800 dark:text-white"
                    x-text="options.length"
                ></strong>
            </span>

            <span class="text-emerald-600 dark:text-emerald-400">
                Jawaban:
                <strong x-text="answerIds.length"></strong>
            </span>

            <span class="text-amber-600 dark:text-amber-400">
                Pengecoh:
                <strong x-text="distractorCount"></strong>
            </span>
        </div>
    </div>

    <!-- KUNCI JAWABAN VISUAL -->
    <div class="space-y-3 rounded-2xl border border-indigo-200 bg-indigo-50/40 p-4 dark:border-indigo-500/20 dark:bg-indigo-500/[0.04]">

        <div class="flex flex-wrap items-start justify-between gap-2">
            <div>
                <h4 class="flex items-center gap-2 text-xs font-bold text-indigo-700 dark:text-indigo-300">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-100 text-[11px] dark:bg-indigo-500/20">
                        3
                    </span>
                    Susun Kunci Jawaban
                </h4>

                <p class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">
                    Klik blok di bawah sesuai urutan jawaban yang benar.
                </p>
            </div>

            <button
                type="button"
                @click="clearAnswer()"
                class="rounded-lg border border-indigo-200 bg-white px-3 py-2 text-[11px] font-semibold text-indigo-600 transition hover:bg-indigo-100 dark:border-indigo-500/20 dark:bg-cyberdark-900 dark:text-indigo-300"
            >
                <i class="fa-solid fa-rotate-left mr-1"></i>
                Reset
            </button>
        </div>

        <!-- Area jawaban -->
        <div class="rounded-xl bg-[#1e1e24] p-4 shadow-inner">
            <div class="mb-3 flex items-center justify-between">
                <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    Correct Sequence
                </span>

                <span
                    class="font-mono text-[10px] text-gray-500"
                    x-text="answerIds.length + ' blok'"
                ></span>
            </div>

            <div class="flex min-h-[64px] flex-wrap items-center gap-2">

                <template
                    x-for="(id, answerIdx) in answerIds"
                    :key="id"
                >
                    <div class="flex items-center gap-1 rounded-lg border border-indigo-500/30 bg-[#30303b] p-1">

                        <span
                            class="px-2 py-2 font-mono text-xs font-semibold text-blue-300"
                            x-text="getOption(id)?.text"
                        ></span>

                        <div class="flex items-center gap-0.5 border-l border-white/10 pl-1">

                            <button
                                type="button"
                                @click="moveAnswer(answerIdx, -1)"
                                :disabled="answerIdx === 0"
                                class="rounded p-1.5 text-gray-400 hover:bg-white/10 hover:text-white disabled:opacity-25"
                                title="Geser ke kiri"
                            >
                                <i class="fa-solid fa-chevron-left text-[9px]"></i>
                            </button>

                            <button
                                type="button"
                                @click="moveAnswer(answerIdx, 1)"
                                :disabled="answerIdx === answerIds.length - 1"
                                class="rounded p-1.5 text-gray-400 hover:bg-white/10 hover:text-white disabled:opacity-25"
                                title="Geser ke kanan"
                            >
                                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                            </button>

                            <button
                                type="button"
                                @click="removeFromAnswer(id)"
                                class="rounded p-1.5 text-rose-400 hover:bg-rose-500/20"
                                title="Keluarkan dari jawaban"
                            >
                                <i class="fa-solid fa-xmark text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                </template>

                <div
                    x-show="answerIds.length === 0"
                    class="flex min-h-[44px] w-full items-center justify-center rounded-lg border-2 border-dashed border-yellow-500/50 px-4 text-center"
                >
                    <span class="text-xs text-gray-400">
                        Pilih blok kode untuk membuat jawaban benar
                    </span>
                </div>
            </div>
        </div>

        <!-- Pilihan blok untuk kunci -->
        <div>
            <p class="mb-2 text-[11px] font-semibold text-gray-600 dark:text-gray-300">
                Klik untuk memasukkan ke kunci jawaban:
            </p>

            <div class="flex flex-wrap gap-2">
                <template
                    x-for="opt in availableOptions"
                    :key="opt.id"
                >
                    <button
                        type="button"
                        @click="addToAnswer(opt.id)"
                        :disabled="answerIds.includes(opt.id)"
                        class="rounded-lg border border-gray-200 bg-white px-3 py-2.5 font-mono text-xs text-indigo-600 transition hover:border-indigo-400 hover:bg-indigo-50 disabled:cursor-not-allowed disabled:opacity-35 dark:border-white/10 dark:bg-cyberdark-900 dark:text-blue-300 dark:hover:bg-indigo-500/10"
                        x-text="opt.text"
                    ></button>
                </template>
            </div>
        </div>

        <div
            x-show="answerIds.length > 0"
            class="rounded-xl border border-emerald-200 bg-emerald-50 p-3 dark:border-emerald-500/20 dark:bg-emerald-500/10"
        >
            <div class="mb-1 flex items-center gap-2 text-[11px] font-bold text-emerald-700 dark:text-emerald-400">
                <i class="fa-solid fa-circle-check"></i>
                Kunci Jawaban Otomatis
            </div>

            <p
                class="break-all font-mono text-xs leading-relaxed text-emerald-800 dark:text-emerald-300"
                x-text="block.arahan"
            ></p>
        </div>
    </div>

    <!-- PREVIEW -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-white/10">

        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/10 dark:bg-white/[0.03]">
            <div>
                <h4 class="flex items-center gap-2 text-xs font-bold text-gray-800 dark:text-gray-200">
                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-100 text-[11px] text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                        4
                    </span>
                    Preview Permainan Siswa
                </h4>

                <p class="mt-1 text-[11px] text-gray-500">
                    Uji coba puzzle sebelum disimpan.
                </p>
            </div>

            <button
                type="button"
                @click="startPreview()"
                :disabled="answerIds.length === 0"
                class="inline-flex items-center gap-2 rounded-xl bg-gray-900 px-3 py-2 text-xs font-semibold text-white transition hover:bg-indigo-600 disabled:cursor-not-allowed disabled:opacity-40 dark:bg-indigo-600 dark:hover:bg-indigo-500"
            >
                <i class="fa-solid fa-play"></i>
                Mulai Preview
            </button>
        </div>

        <div class="space-y-4 bg-[#27272a] p-4 sm:p-5">

            <!-- Instruksi game -->
            <div class="rounded-xl border border-[#888] bg-[#303033] px-4 py-4 shadow-[4px_4px_0_#111]">
                <p
                    class="whitespace-pre-line font-mono text-xs leading-relaxed text-white sm:text-sm"
                    x-text="block.isi || 'Instruksi latihan akan tampil di sini.'"
                ></p>
            </div>

            <!-- Slot jawaban -->
            <div class="rounded-xl border border-black/30 bg-[#1d1d20] p-4">
                <p class="mb-3 font-mono text-[10px] uppercase tracking-widest text-gray-400">
                    Your Answer
                </p>

                <div class="flex min-h-[58px] flex-wrap items-center gap-2">

                    <template
                        x-for="id in previewIds"
                        :key="id"
                    >
                        <button
                            type="button"
                            @click="removePreview(id)"
                            class="rounded-md border border-blue-500/30 bg-[#303035] px-3 py-3 font-mono text-xs text-blue-300 transition hover:border-rose-400 hover:text-rose-300"
                            x-text="getOption(id)?.text"
                        ></button>
                    </template>

                    <template
                        x-for="n in Math.max(0, answerIds.length - previewIds.length)"
                        :key="n"
                    >
                        <div class="flex h-11 w-12 items-center justify-center rounded-md border-2 border-dashed border-yellow-500/70 text-yellow-500">
                            <i class="fa-solid fa-plus text-xs"></i>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Pilihan blok game -->
            <div>
                <p class="mb-3 font-mono text-[10px] uppercase tracking-widest text-gray-400">
                    Available Blocks
                </p>

                <div class="flex flex-wrap justify-center gap-2">
                    <template
                        x-for="opt in availableOptions"
                        :key="opt.id"
                    >
                        <button
                            type="button"
                            @click="addPreview(opt.id)"
                            :disabled="previewIds.includes(opt.id) || !previewMode"
                            class="rounded-md bg-[#18181b] px-4 py-3 font-mono text-xs font-medium text-blue-400 shadow transition hover:bg-[#33333a] disabled:cursor-not-allowed disabled:opacity-30"
                            x-text="opt.text"
                        ></button>
                    </template>
                </div>
            </div>

            <!-- Result -->
            <div
                x-show="previewResult === 'correct'"
                x-transition
                class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-3 text-center text-xs font-semibold text-emerald-300"
            >
                <i class="fa-solid fa-circle-check mr-1"></i>
                Jawaban benar! Puzzle berhasil diselesaikan.
            </div>

            <div
                x-show="previewResult === 'wrong'"
                x-transition
                class="rounded-xl border border-rose-500/30 bg-rose-500/10 p-3 text-center text-xs font-semibold text-rose-300"
            >
                <i class="fa-solid fa-circle-xmark mr-1"></i>
                Urutan belum benar. Coba susun kembali.
            </div>

            <div class="flex justify-end gap-2 border-t border-white/10 pt-4">

                <button
                    type="button"
                    @click="previewIds = []; previewResult = null"
                    :disabled="!previewMode"
                    class="rounded-xl border border-white/10 px-4 py-2.5 text-xs font-semibold text-gray-300 transition hover:bg-white/10 disabled:opacity-30"
                >
                    Reset
                </button>

                <button
                    type="button"
                    @click="checkPreview()"
                    :disabled="!previewMode || previewIds.length === 0"
                    class="rounded-xl bg-yellow-500 px-4 py-2.5 text-xs font-bold text-gray-950 transition hover:bg-yellow-400 disabled:cursor-not-allowed disabled:opacity-40"
                >
                    <i class="fa-solid fa-check mr-1"></i>
                    Periksa Jawaban
                </button>
            </div>
        </div>
    </div>

    <!-- VALIDASI RINGAN -->
    <div
        x-show="answerIds.length === 0"
        class="flex items-start gap-2 rounded-xl border border-amber-200 bg-amber-50 p-3 text-xs text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300"
    >
        <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
        <p>
            Kunci jawaban belum disusun.
            Pilih minimal satu blok kode yang benar sebelum menyimpan aktivitas.
        </p>
    </div>

</div>
