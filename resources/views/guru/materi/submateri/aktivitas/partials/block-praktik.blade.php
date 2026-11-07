
<div
    class="space-y-6"
    x-data="praktikCodeBuilder(block)"
>
    <!-- ========================================= -->
    <!-- INPUT DATA UNTUK CONTROLLER LARAVEL -->
    <!-- ========================================= -->

    <input
        type="hidden"
        :name="`sections[${index}][clue]`"
        :value="block.clue || ''"
    >

    <!-- ========================================= -->
    <!-- HEADER -->
    <!-- ========================================= -->

    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="flex items-center gap-3">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                <i class="fa-solid fa-code text-lg"></i>
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    Praktik Pemrograman
                </h3>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Buat aktivitas coding interaktif untuk siswa.
                </p>
            </div>

        </div>

        <span
            class="rounded-full border px-3 py-1.5 text-[11px] font-bold"
            :class="mode === 'debugging'
                ? 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400'
                : 'border-indigo-200 bg-indigo-50 text-indigo-700 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-400'"
            x-text="mode === 'debugging'
                ? 'Debugging Challenge'
                : 'Code Playground'"
        ></span>

    </div>

    <!-- ========================================= -->
    <!-- PILIH MODE -->
    <!-- ========================================= -->

    <div class="space-y-3">

        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Mode Aktivitas
        </label>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

            <!-- COBA KODE -->
            <button
                type="button"
                x-on:click.stop="setMode('playground')"
                :aria-pressed="mode === 'playground'"
                :class="mode === 'playground'
                    ? 'border-indigo-500 bg-indigo-50 ring-2 ring-indigo-500/10 dark:bg-indigo-500/10'
                    : 'border-gray-200 bg-white hover:border-indigo-300 dark:border-white/10 dark:bg-cyberdark-900'"
                class="cursor-pointer rounded-2xl border-2 p-4 text-left transition-all"
            >

                <div class="mb-3 flex items-center justify-between">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400">
                        <i class="fa-solid fa-play"></i>
                    </div>

                    <i
                        x-show="mode === 'playground'"
                        class="fa-solid fa-circle-check text-lg text-indigo-600"
                    ></i>

                </div>

                <h4 class="text-sm font-bold text-gray-900 dark:text-white">
                    Coba Kode Program
                </h4>

                <p class="mt-1 text-xs leading-relaxed text-gray-500 dark:text-gray-400">
                    Siswa mencoba dan menjalankan kode program.
                </p>

            </button>

            <!-- DEBUGGING -->
            <button
                type="button"
                x-on:click.stop="setMode('debugging')"
                :aria-pressed="mode === 'debugging'"
                :class="mode === 'debugging'
                    ? 'border-amber-500 bg-amber-50 ring-2 ring-amber-500/10 dark:bg-amber-500/10'
                    : 'border-gray-200 bg-white hover:border-amber-300 dark:border-white/10 dark:bg-cyberdark-900'"
                class="cursor-pointer rounded-2xl border-2 p-4 text-left transition-all"
            >

                <div class="mb-3 flex items-center justify-between">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400">
                        <i class="fa-solid fa-bug"></i>
                    </div>

                    <i
                        x-show="mode === 'debugging'"
                        class="fa-solid fa-circle-check text-lg text-amber-600"
                    ></i>

                </div>

                <h4 class="text-sm font-bold text-gray-900 dark:text-white">
                    Perbaiki Kode
                </h4>

                <p class="mt-1 text-xs leading-relaxed text-gray-500 dark:text-gray-400">
                    Siswa menemukan dan memperbaiki kesalahan program.
                </p>

            </button>

        </div>

        <div
            class="rounded-xl border px-4 py-3"
            :class="mode === 'debugging'
                ? 'border-amber-200 bg-amber-50 dark:border-amber-500/20 dark:bg-amber-500/5'
                : 'border-indigo-200 bg-indigo-50 dark:border-indigo-500/20 dark:bg-indigo-500/5'"
        >

            <p
                class="text-xs leading-relaxed text-gray-700 dark:text-gray-300"
                x-text="mode === 'debugging'
                    ? 'Mode Debugging aktif. Berikan kode yang salah dan kode referensi yang benar.'
                    : 'Mode Playground aktif. Siswa dapat mencoba dan mengubah kode secara bebas.'"
            ></p>

        </div>

    </div>

    <!-- ========================================= -->
    <!-- JUDUL -->
    <!-- ========================================= -->

    <div class="space-y-2">

        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Judul Praktik
        </label>

        <input
            type="text"
            :name="`sections[${index}][arahan]`"
            x-model="block.arahan"
            placeholder="Contoh: Membuat Halaman HTML Pertama"
            class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-white"
        >

    </div>

    <!-- ========================================= -->
    <!-- BAHASA PEMROGRAMAN -->
    <!-- ========================================= -->

    <div class="space-y-2">

        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">
            Bahasa Pemrograman
        </label>

        <select
            :name="`sections[${index}][tips]`"
            x-model="language"
            x-on:change="changeLanguage($event.target.value)"
            class="w-full cursor-pointer rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-white"
        >
            <option value="html">HTML / CSS / JavaScript</option>
            <option value="css">CSS Only</option>
            <option value="python">Python</option>
        </select>

        <p class="text-[11px] text-gray-400">
            Mengganti bahasa tidak menghapus kode yang sudah ditulis.
        </p>

    </div>

    <!-- ========================================= -->
    <!-- INSTRUKSI -->
    <!-- ========================================= -->

    <div class="space-y-2">

        <label
            class="block text-xs font-bold text-gray-700 dark:text-gray-300"
            x-text="mode === 'debugging'
                ? 'Instruksi Perbaikan Kode'
                : 'Instruksi Praktik Kode'"
        ></label>

        <textarea
            x-model="instruction"
            x-on:input="syncData()"
            rows="3"
            placeholder="Tuliskan instruksi yang harus dikerjakan siswa..."
            class="w-full resize-y rounded-2xl border border-gray-200 bg-white p-4 text-sm leading-relaxed text-gray-900 outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/10 dark:border-white/10 dark:bg-cyberdark-900 dark:text-white"
        ></textarea>

    </div>

    <!-- ========================================= -->
    <!-- STARTER CODE -->
    <!-- ========================================= -->

    <div class="overflow-hidden rounded-2xl border border-gray-800">

        <div class="flex flex-wrap items-center justify-between gap-2 bg-[#25252c] px-4 py-3">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-file-code text-amber-400"></i>

                <span
                    class="font-mono text-xs font-bold text-white"
                    x-text="mode === 'debugging'
                        ? 'Buggy Code'
                        : 'Starter Code'"
                ></span>

            </div>

            <button
                type="button"
                x-on:click.stop="useTemplate()"
                class="rounded-lg bg-white/10 px-3 py-2 text-[11px] font-semibold text-gray-200 hover:bg-white/20"
            >
                <i class="fa-solid fa-rotate-left mr-1"></i>
                Template Default
            </button>

        </div>

        <textarea
            :name="`sections[${index}][isi]`"
            x-model="block.isi"
            rows="13"
            spellcheck="false"
            autocomplete="off"
            autocapitalize="off"
            placeholder="Tuliskan kode program di sini..."
            class="block w-full resize-y border-0 bg-[#17171d] p-5 font-mono text-xs leading-6 text-emerald-300 outline-none focus:ring-0"
        ></textarea>

        <div class="flex items-center justify-between bg-[#25252c] px-4 py-2.5">

            <span
                class="font-mono text-[11px] text-gray-400"
                x-text="language.toUpperCase()"
            ></span>

            <span class="text-[11px] text-gray-400">
                <span x-text="String(block.isi || '').split('\n').length"></span>
                baris
            </span>

        </div>

    </div>

    <!-- ========================================= -->
    <!-- KODE REFERENSI DEBUGGING -->
    <!-- ========================================= -->

    <div
        x-show="mode === 'debugging'"
        x-transition.opacity
        x-cloak
        class="space-y-3 rounded-2xl border border-amber-200 bg-amber-50/50 p-4 dark:border-amber-500/20 dark:bg-amber-500/5"
    >

        <div class="flex items-center gap-2">

            <i class="fa-solid fa-shield-halved text-amber-600"></i>

            <h4 class="text-xs font-bold text-amber-700 dark:text-amber-400">
                Kode Referensi yang Benar
            </h4>

        </div>

        <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-400">
            Tuliskan kode yang sudah diperbaiki sebagai referensi guru.
            Kode ini tidak ditampilkan kepada siswa pada preview.
        </p>

        <textarea
            x-model="solution"
            x-on:input="syncData()"
            rows="10"
            spellcheck="false"
            placeholder="Masukkan kode program yang benar..."
            class="block w-full resize-y rounded-xl border border-gray-800 bg-[#17171d] p-4 font-mono text-xs leading-6 text-emerald-300 outline-none focus:ring-2 focus:ring-amber-500/20"
        ></textarea>

    </div>

    <!-- ========================================= -->
    <!-- TOMBOL PREVIEW -->
    <!-- ========================================= -->

    <button
        type="button"
        x-on:click.stop="togglePreview()"
        class="flex w-full cursor-pointer items-center justify-center gap-2 rounded-2xl border border-indigo-200 bg-indigo-50 px-5 py-3.5 text-xs font-bold text-indigo-700 transition hover:bg-indigo-100 dark:border-indigo-500/20 dark:bg-indigo-500/10 dark:text-indigo-300"
    >
        <i class="fa-solid fa-eye"></i>

        <span
            x-text="showPreview
                ? 'Tutup Preview Siswa'
                : 'Preview Tampilan Siswa'"
        ></span>
    </button>

    <!-- ========================================= -->
    <!-- PREVIEW SISWA -->
    <!-- ========================================= -->

    <div
        x-show="showPreview"
        x-transition.opacity
        x-cloak
        class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-white/10 dark:bg-cyberdark-900"
    >

        <!-- HEADER PREVIEW -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 px-4 py-3 dark:border-white/10">

            <div class="flex items-center gap-2">

                <i class="fa-solid fa-desktop text-indigo-500"></i>

                <span class="text-xs font-bold text-gray-900 dark:text-white">
                    Preview Tampilan Siswa
                </span>

            </div>

            <span
                class="rounded-full bg-indigo-50 px-3 py-1 text-[10px] font-bold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-300"
                x-text="mode === 'debugging'
                    ? 'Debugging Challenge'
                    : 'Code Playground'"
            ></span>

        </div>

        <div class="space-y-4 p-4">

            <!-- MISI -->
            <div class="rounded-xl bg-indigo-50 p-4 dark:bg-indigo-500/10">

                <div class="mb-2 flex items-center gap-2">

                    <i class="fa-solid fa-bullseye text-indigo-500"></i>

                    <h4
                        class="text-xs font-bold text-gray-900 dark:text-white"
                        x-text="block.arahan || 'Praktik Pemrograman'"
                    ></h4>

                </div>

                <p
                    class="whitespace-pre-wrap text-xs leading-relaxed text-gray-600 dark:text-gray-300"
                    x-text="instruction || 'Coba jalankan dan modifikasi kode program.'"
                ></p>

            </div>

            <!-- EDITOR SISWA -->
            <div class="overflow-hidden rounded-xl border border-gray-800">

                <div class="flex items-center justify-between bg-[#25252c] px-4 py-3">

                    <div class="flex items-center gap-2">

                        <i class="fa-solid fa-file-code text-amber-400"></i>

                        <span
                            class="font-mono text-xs font-bold text-white"
                            x-text="fileName()"
                        ></span>

                    </div>

                    <span
                        class="text-[10px] font-bold text-gray-400"
                        x-text="language.toUpperCase()"
                    ></span>

                </div>

                <textarea
                    x-model="previewCode"
                    rows="12"
                    spellcheck="false"
                    autocomplete="off"
                    autocapitalize="off"
                    class="block w-full resize-y border-0 bg-[#17171d] p-4 font-mono text-xs leading-6 text-emerald-300 outline-none focus:ring-0"
                ></textarea>

                <div class="flex flex-wrap justify-end gap-2 bg-[#25252c] p-3">

                    <button
                        type="button"
                        x-on:click.stop="resetPreview()"
                        class="rounded-lg bg-white/10 px-4 py-2 text-xs font-bold text-gray-200 hover:bg-white/20"
                    >
                        <i class="fa-solid fa-rotate-left mr-1"></i>
                        Reset
                    </button>

                    <button
                        type="button"
                        x-on:click.stop="runPreview()"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-700"
                    >
                        <i class="fa-solid fa-play mr-1"></i>
                        Jalankan Kode
                    </button>

                </div>

            </div>

            <!-- HASIL PROGRAM -->
            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">

                <div class="flex items-center gap-2 border-b border-gray-200 bg-gray-50 px-4 py-3 dark:border-white/10 dark:bg-white/5">

                    <i class="fa-solid fa-display text-emerald-500"></i>

                    <span class="text-xs font-bold text-gray-900 dark:text-white">
                        Hasil Program
                    </span>

                </div>

                <div
                    x-show="previewMessage"
                    x-text="previewMessage"
                    class="p-4 text-xs leading-relaxed text-amber-600 dark:text-amber-400"
                ></div>

                <iframe
                    x-ref="previewFrame"
                    x-show="language !== 'python'"
                    sandbox="allow-scripts"
                    referrerpolicy="no-referrer"
                    title="Preview hasil kode siswa"
                    class="h-72 w-full bg-white"
                ></iframe>

            </div>

            <p class="text-center text-[11px] leading-relaxed text-gray-400">
                Perubahan kode pada preview tidak mengubah starter code guru.
            </p>

        </div>

    </div>

</div>

<!-- ========================================= -->
<!-- SCRIPT ALPINE.JS -->
<!-- LETAKKAN DI LUAR X-DATA HTML -->
<!-- ========================================= -->

@once
<script>
(function () {
    function registerPraktikBuilder() {
        if (!window.Alpine) return;

        Alpine.data('praktikCodeBuilder', (block) => ({
            block: block,

            mode: 'playground',
            language: 'html',
            instruction: '',
            solution: '',

            showPreview: false,
            previewCode: '',
            previewMessage: '',

            init() {
                let saved = {};

                try {
                    const raw = this.block.clue;

                    if (typeof raw === 'string' && raw.trim()) {
                        const parsed = JSON.parse(raw);

                        if (
                            parsed &&
                            typeof parsed === 'object' &&
                            !Array.isArray(parsed)
                        ) {
                            saved = parsed;
                        }
                    } else if (
                        raw &&
                        typeof raw === 'object' &&
                        !Array.isArray(raw)
                    ) {
                        saved = raw;
                    }
                } catch (error) {
                    console.warn('Konfigurasi praktik tidak valid:', error);
                }

                this.mode = saved.mode === 'debugging'
                    ? 'debugging'
                    : 'playground';

                this.instruction = String(saved.instruction ?? '');
                this.solution = String(saved.solution ?? '');

                this.language = ['html', 'css', 'python'].includes(this.block.tips)
                    ? this.block.tips
                    : 'html';

                if (!this.block.isi) {
                    this.block.isi = this.getStarterCode(this.language);
                }

                this.previewCode = String(this.block.isi || '');

                this.syncData();
            },

            getStarterCode(lang) {
                if (lang === 'html') {
                    return [
                        '<!DOCTYPE html>',
                        '<html>',
                        '<head>',
                        '    <title>Belajar HTML</title>',
                        '</head>',
                        '<body>',
                        '    <h1>Hello World!</h1>',
                        '    <p>Paragraf pertama saya.</p>',
                        '</body>',
                        '</html>'
                    ].join('\n');
                }

                if (lang === 'css') {
                    return [
                        'body {',
                        '    background-color: lightblue;',
                        '    font-family: Arial, sans-serif;',
                        '}',
                        '',
                        'h1 {',
                        '    color: navy;',
                        '}'
                    ].join('\n');
                }

                if (lang === 'python') {
                    return [
                        '# Program Python pertama',
                        'print("Hello World!")'
                    ].join('\n');
                }

                return '';
            },

            setMode(value) {
                this.mode = value === 'debugging'
                    ? 'debugging'
                    : 'playground';

                this.syncData();

                if (this.showPreview) {
                    this.resetPreview();
                }
            },

            changeLanguage(value) {
                if (!['html', 'css', 'python'].includes(value)) {
                    return;
                }

                this.language = value;
                this.syncData();

                if (this.showPreview) {
                    this.resetPreview();
                }
            },

            useTemplate() {
                const confirmed = window.confirm(
                    'Ganti kode saat ini dengan template default?'
                );

                if (!confirmed) return;

                this.block.isi = this.getStarterCode(this.language);

                if (this.showPreview) {
                    this.resetPreview();
                }
            },

            syncData() {
                this.block.tips = this.language;

                this.block.clue = JSON.stringify({
                    mode: this.mode,
                    instruction: this.instruction,
                    solution: this.solution
                });
            },

            togglePreview() {
                if (this.showPreview) {
                    this.showPreview = false;
                    return;
                }

                this.openPreview();
            },

            openPreview() {
                this.showPreview = true;

                this.previewCode = String(this.block.isi || '');
                this.previewMessage = '';

                this.$nextTick(() => {
                    this.runPreview();
                });
            },

            resetPreview() {
                this.previewCode = String(this.block.isi || '');
                this.previewMessage = '';

                this.$nextTick(() => {
                    this.runPreview();
                });
            },

            buildPreviewDocument() {
                if (this.language === 'css') {
                    return [
                        '<!DOCTYPE html>',
                        '<html>',
                        '<head>',
                        '<meta charset="UTF-8">',
                        '<style>',
                        this.previewCode,
                        '</style>',
                        '</head>',
                        '<body>',
                        '<h1>Preview CSS</h1>',
                        '<p>Contoh paragraf untuk melihat hasil CSS.</p>',
                        '<button>Contoh Tombol</button>',
                        '</body>',
                        '</html>'
                    ].join('\n');
                }

                return this.previewCode;
            },

            runPreview() {
                this.previewMessage = '';

                if (this.language === 'python') {
                    this.previewMessage =
                        'Eksekusi Python belum tersedia. Gunakan Pyodide atau runtime Python terisolasi untuk menjalankan kode Python.';

                    return;
                }

                this.$nextTick(() => {
                    const frame = this.$refs.previewFrame;

                    if (frame) {
                        frame.srcdoc = this.buildPreviewDocument();
                    }
                });
            },

            fileName() {
                if (this.language === 'python') return 'main.py';
                if (this.language === 'css') return 'style.css';
                return 'index.html';
            }
        }));
    }

    if (window.Alpine) {
        registerPraktikBuilder();
    } else {
        document.addEventListener(
            'alpine:init',
            registerPraktikBuilder,
            { once: true }
        );
    }
})();
</script>
@endonce
