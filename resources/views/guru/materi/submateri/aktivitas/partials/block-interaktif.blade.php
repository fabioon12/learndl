
<div
    class="space-y-5"
    x-data="{
        options: [],
        correctId: null,
        nextId: 1,
        explanation: '',
        preview: false,
        selectedId: null,
        checked: false,

        initPilihanGanda() {
            let saved = this.block.clue;

            try {
                if (typeof saved === 'string') {
                    saved = JSON.parse(saved);
                }

                if (saved && !Array.isArray(saved)
                    && Array.isArray(saved.options)) {

                    this.options = saved.options.map(item => ({
                        id: this.nextId++,
                        text: String(item.text ?? '')
                    }));

                    const correctIndex =
                        Number(saved.correctIndex);

                    this.correctId =
                        this.options[correctIndex]?.id ?? null;

                    this.explanation =
                        String(saved.explanation ?? '');
                }
            } catch (e) {
                this.options = [];
            }

            if (this.options.length === 0) {
                this.options = Array.from(
                    { length: 4 },
                    () => ({
                        id: this.nextId++,
                        text: ''
                    })
                );
            }

            this.syncData();
        },

        addOption() {
            if (this.options.length >= 6) return;

            this.options.push({
                id: this.nextId++,
                text: ''
            });

            this.syncData();
        },

        removeOption(id) {
            if (this.options.length <= 2) return;

            this.options = this.options.filter(
                option => option.id !== id
            );

            if (this.correctId === id) {
                this.correctId = null;
            }

            this.syncData();
        },

        syncData() {
            const correctIndex = this.options.findIndex(
                option => option.id === this.correctId
            );

            this.block.arahan = correctIndex >= 0
                ? String(correctIndex)
                : '';

            this.block.clue = JSON.stringify({
                options: this.options.map(option => ({
                    text: option.text
                })),
                correctIndex,
                explanation: this.explanation
            });
        },

        checkAnswer() {
            if (this.selectedId === null) return;
            this.checked = true;
        },

        resetPreview() {
            this.selectedId = null;
            this.checked = false;
        }
    }"
    x-init="initPilihanGanda()"
>
    <!-- Data untuk controller Laravel -->
    <input
        type="hidden"
        :name="`sections[${index}][arahan]`"
        :value="block.arahan || ''"
    >

    <input
        type="hidden"
        :name="`sections[${index}][clue]`"
        :value="block.clue || ''"
    >

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                <i class="fa-solid fa-list-check"></i>
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    Latihan Pilihan Ganda
                </h3>
                <p class="text-xs text-gray-500">
                    Buat pertanyaan dan tentukan jawaban benar.
                </p>
            </div>
        </div>

        <div class="flex rounded-xl bg-gray-100 p-1 dark:bg-white/5">
            <button
                type="button"
                @click="preview = false"
                :class="!preview
                    ? 'bg-white text-indigo-600 shadow-sm dark:bg-indigo-600 dark:text-white'
                    : 'text-gray-500'"
                class="rounded-lg px-3 py-2 text-xs font-semibold"
            >
                Editor
            </button>

            <button
                type="button"
                @click="preview = true; resetPreview()"
                :class="preview
                    ? 'bg-white text-indigo-600 shadow-sm dark:bg-indigo-600 dark:text-white'
                    : 'text-gray-500'"
                class="rounded-lg px-3 py-2 text-xs font-semibold"
            >
                Preview
            </button>
        </div>
    </div>

    <!-- Editor Guru -->
    <div x-show="!preview" class="space-y-5">

        <!-- Pertanyaan -->
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-700 dark:text-gray-300">
                Pertanyaan / Soal
            </label>

            <textarea
                :name="`sections[${index}][isi]`"
                x-model="block.isi"
                rows="3"
                placeholder="Contoh: Tag HTML manakah yang digunakan untuk membuat paragraf?"
                class="w-full rounded-2xl border border-gray-200 bg-white p-4 text-sm text-gray-900 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-white"
            ></textarea>
        </div>

        <!-- Pilihan jawaban -->
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <label class="text-xs font-bold text-gray-700 dark:text-gray-300">
                    Pilihan Jawaban
                </label>

                <span class="text-[11px] text-gray-400">
                    Pilih lingkaran jawaban benar
                </span>
            </div>

            <template
                x-for="(option, optionIndex) in options"
                :key="option.id"
            >
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        @click="correctId = option.id; syncData()"
                        :class="correctId === option.id
                            ? 'border-emerald-500 bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10'
                            : 'border-gray-200 bg-white text-gray-400 dark:border-white/10 dark:bg-cyberdark-900'"
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border transition"
                        title="Tandai sebagai jawaban benar"
                    >
                        <i
                            class="fa-solid"
                            :class="correctId === option.id
                                ? 'fa-circle-check'
                                : 'fa-circle'"
                        ></i>
                    </button>

                    <input
                        type="text"
                        x-model="option.text"
                        @input="syncData()"
                        :placeholder="'Pilihan ' + String.fromCharCode(65 + optionIndex)"
                        class="min-w-0 flex-1 rounded-xl border border-gray-200 bg-white px-4 py-3 font-mono text-xs text-gray-900 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-white"
                    >

                    <button
                        type="button"
                        @click="removeOption(option.id)"
                        :disabled="options.length <= 2"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-500 hover:bg-rose-100 disabled:opacity-30 dark:bg-rose-500/10"
                        title="Hapus pilihan"
                    >
                        <i class="fa-solid fa-trash-can text-xs"></i>
                    </button>
                </div>
            </template>

            <button
                type="button"
                @click="addOption()"
                :disabled="options.length >= 6"
                class="flex w-full items-center justify-center gap-2 rounded-xl border border-dashed border-indigo-300 bg-indigo-50/40 px-4 py-3 text-xs font-bold text-indigo-600 transition hover:bg-indigo-100 disabled:opacity-40 dark:border-indigo-500/30 dark:bg-indigo-500/5 dark:text-indigo-400"
            >
                <i class="fa-solid fa-plus"></i>
                Tambah Pilihan Jawaban
            </button>
        </div>

        <!-- Pembahasan -->
        <div class="space-y-2">
            <label class="text-xs font-bold text-gray-700 dark:text-gray-300">
                Pembahasan Jawaban
                <span class="font-normal text-gray-400">
                    (Opsional)
                </span>
            </label>

            <textarea
                x-model="explanation"
                @input="syncData()"
                rows="3"
                placeholder="Jelaskan mengapa jawaban tersebut benar..."
                class="w-full rounded-2xl border border-gray-200 bg-white p-4 text-sm text-gray-900 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-white"
            ></textarea>
        </div>

        <div
            x-show="correctId === null"
            class="rounded-xl border border-amber-200 bg-amber-50 p-3 text-xs text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300"
        >
            <i class="fa-solid fa-triangle-exclamation mr-1"></i>
            Tentukan satu jawaban benar sebelum menyimpan.
        </div>
    </div>

    <!-- Preview Siswa -->
    <div x-show="preview" x-cloak>
        <div class="space-y-3 rounded-2xl bg-[#292929] p-4 sm:p-6">

            <div class="rounded-lg border border-[#aaa] bg-[#e8e0d4] p-5">
                <p
                    class="whitespace-pre-line font-mono text-sm leading-relaxed text-gray-900"
                    x-text="block.isi || 'Pertanyaan belum diisi.'"
                ></p>
            </div>

            <template
                x-for="(option, optionIndex) in options"
                :key="option.id"
            >
                <button
                    type="button"
                    @click="selectedId = option.id; checked = false"
                    :class="checked && selectedId === option.id
                        ? (correctId === option.id
                            ? 'border-emerald-500 bg-emerald-900/20'
                            : 'border-rose-500 bg-rose-900/20')
                        : (selectedId === option.id
                            ? 'border-yellow-400 bg-white/10'
                            : 'border-[#666] bg-transparent')"
                    class="flex min-h-[65px] w-full items-center justify-between rounded-sm border px-5 py-4 text-left transition hover:border-yellow-400"
                >
                    <span
                        class="font-mono text-sm text-white"
                        x-text="option.text || 'Pilihan kosong'"
                    ></span>

                    <i
                        x-show="checked && selectedId === option.id"
                        class="fa-solid"
                        :class="correctId === option.id
                            ? 'fa-circle-check text-emerald-400'
                            : 'fa-circle-xmark text-rose-400'"
                    ></i>
                </button>
            </template>

            <div
                x-show="checked"
                class="rounded-xl border border-white/10 bg-white/5 p-4"
            >
                <p
                    class="text-sm font-bold"
                    :class="selectedId === correctId
                        ? 'text-emerald-400'
                        : 'text-rose-400'"
                    x-text="selectedId === correctId
                        ? 'Jawaban benar!'
                        : 'Jawaban belum tepat.'"
                ></p>

                <p
                    x-show="explanation.trim()"
                    class="mt-2 whitespace-pre-line text-xs leading-relaxed text-gray-300"
                    x-text="explanation"
                ></p>
            </div>

            <button
                type="button"
                @click="checkAnswer()"
                :disabled="selectedId === null"
                class="w-full rounded-xl bg-[#e8e0d4] px-4 py-4 text-sm font-black uppercase tracking-wide text-gray-900 transition hover:bg-white disabled:cursor-not-allowed disabled:opacity-40"
            >
                Periksa Jawaban
            </button>
        </div>
    </div>
</div>
