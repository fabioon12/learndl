
<div
    class="space-y-5"
    x-data="bacaanGameBuilder(block)"
>
    <!-- ===================================== -->
    <!-- INPUT UNTUK LARAVEL -->
    <!-- ===================================== -->

    <input
        type="hidden"
        :name="`sections[${index}][isi]`"
        :value="block.isi || ''"
    >

    <input
        type="hidden"
        :name="`sections[${index}][tips]`"
        :value="block.tips || ''"
    >

    <!-- ===================================== -->
    <!-- HEADER -->
    <!-- ===================================== -->

    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="flex items-center gap-3">

            <div
                class="flex h-12 w-12 items-center justify-center rounded-2xl
                       bg-indigo-100 text-indigo-600
                       dark:bg-indigo-500/10 dark:text-indigo-400"
            >
                <i class="fa-solid fa-book-open text-lg"></i>
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                    Materi Bacaan
                </h3>

                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Buat materi teks dan gambar dengan tampilan game.
                </p>
            </div>

        </div>

        <span
            class="rounded-full bg-indigo-50 px-3 py-1.5
                   text-[10px] font-bold text-indigo-600
                   dark:bg-indigo-500/10 dark:text-indigo-400"
        >
            Trix Editor
        </span>

    </div>

    <!-- ===================================== -->
    <!-- TRIX EDITOR -->
    <!-- ===================================== -->

    <div class="space-y-2">

        <label
            class="block text-xs font-bold
                   text-gray-700 dark:text-gray-300"
        >
            Isi Konten Teks & Gambar
        </label>

        <div
            class="overflow-hidden rounded-2xl border
                   border-gray-200 bg-white
                   dark:border-white/10 dark:bg-cyberdark-900"
        >
            <trix-editor
                x-ref="trixEditor"
                placeholder="Tuliskan materi, tambahkan gambar, dan atur urutannya..."
                class="trix-content min-h-[220px] p-4 text-sm text-gray-900 dark:text-white"
                x-on:trix-change="updateContent($event)"
            ></trix-editor>
        </div>

        <p class="text-[11px] leading-relaxed text-gray-400">
            Urutan teks dan gambar di Trix Editor akan
            dipertahankan pada preview siswa.
        </p>

    </div>

    <!-- ===================================== -->
    <!-- TIPS / CATATAN -->
    <!-- ===================================== -->

    <div
        class="space-y-3 border-t border-gray-100 pt-4
               dark:border-white/10"
    >

        <label class="inline-flex cursor-pointer items-center gap-2">

            <input
                type="checkbox"
                x-model="showTipsInput"
                x-on:change="toggleTips()"
                class="h-4 w-4 rounded border-gray-300
                       text-indigo-600 focus:ring-indigo-500"
            >

            <span
                class="text-xs font-bold
                       text-indigo-600 dark:text-indigo-400"
            >
                <i class="fa-solid fa-lightbulb mr-1"></i>
                Tambahkan Catatan / Tips Penting
            </span>

        </label>

        <div
            x-show="showTipsInput"
            x-transition
            x-cloak
            class="space-y-2 border-l-2 border-indigo-500 pl-4"
        >

            <label
                class="block text-xs font-bold
                       text-amber-600 dark:text-amber-400"
            >
                Isi Tips / Catatan Penting
            </label>

            <textarea
                x-model="block.tips"
                rows="3"
                placeholder="Contoh: Gunakan tag h1 untuk membuat judul utama."
                class="w-full rounded-2xl border
                       border-amber-200 bg-amber-50/20
                       p-3 text-xs text-gray-900 outline-none
                       focus:border-amber-400
                       dark:border-amber-950/30
                       dark:bg-cyberdark-800 dark:text-white"
            ></textarea>

        </div>

    </div>

    <!-- ===================================== -->
    <!-- TOMBOL PREVIEW -->
    <!-- ===================================== -->

    <button
        type="button"
        x-on:click.stop="togglePreview()"
        class="flex w-full cursor-pointer items-center
               justify-center gap-2 rounded-2xl
               border border-indigo-200 bg-indigo-50
               px-5 py-3.5 text-xs font-bold
               text-indigo-700 transition hover:bg-indigo-100
               dark:border-indigo-500/20
               dark:bg-indigo-500/10 dark:text-indigo-300"
    >
        <i class="fa-solid fa-eye"></i>

        <span
            x-text="showPreview
                ? 'Tutup Preview Siswa'
                : 'Preview Tampilan Siswa'"
        ></span>
    </button>

    <!-- ===================================== -->
    <!-- PREVIEW GAME -->
    <!-- ===================================== -->

    <div
        x-show="showPreview"
        x-transition.opacity
        x-cloak
        class="overflow-hidden rounded-2xl bg-[#292929]
               p-4 sm:p-6"
    >

        <!-- HEADER GAME -->
        <div class="mb-5 flex items-end gap-3">

            <!-- Placeholder karakter -->
            <div
                class="flex h-20 w-20 shrink-0 items-center
                       justify-center rounded-xl border
                       border-[#57504b] bg-[#39332f]
                       text-4xl sm:h-24 sm:w-24"
            >
                🫎
            </div>

            <div class="space-y-1 pb-2">

                <p class="font-mono text-xs font-bold text-amber-300">
                    CODE GUIDE
                </p>

                <p class="font-mono text-[11px] text-gray-400">
                    Pelajari materi berikut dengan saksama!
                </p>

            </div>

        </div>

        <!-- KONTEN DINAMIS -->
        <div class="space-y-5">

            <template
                x-for="(item, itemIndex) in previewItems"
                :key="itemIndex"
            >

                <div>

                    <!-- KOTAK DIALOG TEKS -->
                    <div
                        x-show="item.type === 'text'"
                        class="border-2 border-[#a9a29b]
                               bg-[#292929] p-4
                               shadow-[5px_5px_0_#111]
                               sm:p-6"
                    >

                        <div
                            class="bacaan-game-content
                                   font-mono text-sm leading-7
                                   text-white"
                            x-html="item.html"
                        ></div>

                    </div>

                    <!-- KARTU GAMBAR -->
                    <div
                        x-show="item.type === 'image'"
                        class="overflow-hidden rounded-xl
                               border border-[#444]
                               bg-white p-3"
                    >

                        <img
                            :src="item.src"
                            :alt="item.alt || 'Gambar materi'"
                            class="mx-auto h-auto max-h-[480px]
                                   max-w-full object-contain"
                        >

                        <p
                            x-show="item.caption"
                            x-text="item.caption"
                            class="mt-3 text-center
                                   font-mono text-xs text-gray-500"
                        ></p>

                    </div>

                </div>

            </template>

            <!-- KONDISI KOSONG -->
            <div
                x-show="previewItems.length === 0"
                class="border-2 border-dashed border-[#777]
                       p-6 text-center"
            >

                <i class="fa-solid fa-book-open mb-2 text-2xl text-gray-500"></i>

                <p class="font-mono text-xs text-gray-400">
                    Konten materi belum tersedia.
                </p>

            </div>

        </div>

        <!-- ===================================== -->
        <!-- PREVIEW TIPS -->
        <!-- ===================================== -->

        <div
            x-show="showTipsInput && block.tips"
            x-cloak
            class="mt-5 border-l-4 border-amber-400
                   bg-amber-400/10 p-4"
        >

            <p class="mb-2 font-mono text-xs font-bold text-amber-300">
                💡 TIPS PENTING
            </p>

            <p
                class="whitespace-pre-wrap font-mono
                       text-xs leading-6 text-gray-200"
                x-text="block.tips"
            ></p>

        </div>

        <!-- FOOTER -->
        <div class="mt-6 border-t border-white/10 pt-4">

            <div class="flex items-center justify-between gap-3">

                <span class="font-mono text-[10px] text-gray-500">
                    LEARNING CONTENT
                </span>

                <span class="font-mono text-[10px] text-gray-500">
                    PREVIEW MODE
                </span>

            </div>

        </div>

    </div>

</div>

<!-- ===================================== -->
<!-- STYLE PREVIEW -->
<!-- ===================================== -->

@once
<style>
    [x-cloak] {
        display: none !important;
    }

    .bacaan-game-content {
        overflow-wrap: anywhere;
    }

    .bacaan-game-content h1 {
        font-size: 1.4rem;
        line-height: 1.8rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.75rem;
    }

    .bacaan-game-content h2 {
        font-size: 1.15rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.65rem;
    }

    .bacaan-game-content h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .bacaan-game-content p,
    .bacaan-game-content div {
        margin-bottom: 0.6rem;
    }

    .bacaan-game-content strong {
        font-weight: 800;
        color: #ffffff;
    }

    .bacaan-game-content em {
        font-style: italic;
    }

    .bacaan-game-content a {
        color: #93c5fd;
        text-decoration: underline;
    }

    .bacaan-game-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin: 0.75rem 0;
    }

    .bacaan-game-content ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin: 0.75rem 0;
    }

    .bacaan-game-content li {
        margin-bottom: 0.35rem;
    }

    .bacaan-game-content blockquote {
        border-left: 3px solid #fbbf24;
        padding-left: 1rem;
        color: #fde68a;
        margin: 0.75rem 0;
    }

    .bacaan-game-content pre {
        overflow-x: auto;
        background: #171717;
        border: 1px solid #444;
        padding: 1rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        white-space: pre-wrap;
    }

    .bacaan-game-content code {
        border-radius: 0.25rem;
        background: #555;
        padding: 0.1rem 0.35rem;
        font-family: monospace;
        color: #ffffff;
    }

    .bacaan-game-content img {
        max-width: 100%;
        height: auto;
    }
</style>

<!-- ===================================== -->
<!-- ALPINE COMPONENT -->
<!-- ===================================== -->

<script>
(function () {

    function registerBacaanGameBuilder() {

        if (!window.Alpine) return;

        Alpine.data('bacaanGameBuilder', (block) => ({

            block: block,

            showTipsInput: false,
            showPreview: false,

            previewItems: [],

            init() {
                this.showTipsInput = !!this.block.tips;

                this.$nextTick(() => {
                    this.initializeTrix();
                });
            },

            initializeTrix() {
                const editor = this.$refs.trixEditor;

                if (!editor) return;

                const loadContent = () => {
                    if (
                        this.block.isi &&
                        editor.editor
                    ) {
                        editor.editor.loadHTML(
                            this.block.isi
                        );
                    }
                };

                if (editor.editor) {
                    loadContent();
                } else {
                    editor.addEventListener(
                        'trix-initialize',
                        loadContent,
                        { once: true }
                    );
                }
            },

            updateContent(event) {
                this.block.isi = event.target.value;

                if (this.showPreview) {
                    this.generatePreview();
                }
            },

            toggleTips() {
                if (!this.showTipsInput) {
                    this.block.tips = '';
                }
            },

            togglePreview() {
                this.showPreview = !this.showPreview;

                if (this.showPreview) {
                    this.generatePreview();
                }
            },

            generatePreview() {
                const html = this.block.isi || '';

                const parser = new DOMParser();

                const doc = parser.parseFromString(
                    html,
                    'text/html'
                );

                const result = [];
                let textBuffer = [];

                const flushText = () => {
                    if (textBuffer.length === 0) return;

                    const textHTML = textBuffer.join('');

                    if (textHTML.trim()) {
                        result.push({
                            type: 'text',
                            html: textHTML
                        });
                    }

                    textBuffer = [];
                };

                const pushImage = (img) => {
                    const figure = img.closest('figure');

                    const caption = figure
                        ? figure.querySelector('figcaption')
                        : null;

                    result.push({
                        type: 'image',
                        src: img.getAttribute('src') || '',
                        alt: img.getAttribute('alt') || '',
                        caption: caption
                            ? caption.textContent.trim()
                            : ''
                    });
                };

                const processNode = (node) => {

                    // NODE TEKS
                    if (node.nodeType === Node.TEXT_NODE) {
                        if (node.textContent.trim()) {
                            textBuffer.push(
                                node.textContent
                            );
                        }

                        return;
                    }

                    if (node.nodeType !== Node.ELEMENT_NODE) {
                        return;
                    }

                    const tag = node.tagName.toLowerCase();

                    // GAMBAR DARI TRIX
                    if (tag === 'figure') {
                        const images = node.querySelectorAll('img');

                        if (images.length > 0) {
                            flushText();

                            images.forEach(pushImage);

                            return;
                        }
                    }

                    // GAMBAR BIASA
                    if (tag === 'img') {
                        flushText();
                        pushImage(node);
                        return;
                    }

                    // ELEMEN PEMBUNGKUS
                    if (tag === 'div' && node.querySelector('img')) {
                        Array.from(node.childNodes).forEach(processNode);
                        return;
                    }

                    // ELEMEN TEKS / FORMAT TRIX
                    textBuffer.push(node.outerHTML);
                };

                Array.from(doc.body.childNodes).forEach(processNode);

                flushText();

                this.previewItems = result;
            }
        }));
    }

    if (window.Alpine) {
        registerBacaanGameBuilder();
    } else {
        document.addEventListener(
            'alpine:init',
            registerBacaanGameBuilder,
            { once: true }
        );
    }

})();
</script>
@endonce
