
@extends('guru.layouts.app')

@section('title', 'Konfigurasi Apersepsi')

@section('content')

@php
    $konten = $konten ?? [];

    $isEdit = !empty($tahapan->konten);

    $materiIsi = old(
        'materi.isi',
        data_get($konten, 'materi.isi', '')
    );

    $forumAktif = old(
        'forum.aktif',
        data_get($konten, 'forum.aktif', true)
    );

    $forumJudul = old(
        'forum.judul',
        data_get($konten, 'forum.judul', 'Diskusi Pemantik')
    );

    $forumPertanyaan = old(
        'forum.pertanyaan',
        data_get($konten, 'forum.pertanyaan', '')
    );

    $batasJawaban = old(
        'forum.batas_jawaban',
        data_get($konten, 'forum.batas_jawaban', 1)
    );

    $uploadUrl = route('guru.ruang-belajar.tahapan.upload-gambar', [
        $ruangBelajar->id,
        $tahapan->id
    ]);

    $formAction = $isEdit
        ? route('guru.ruang-belajar.tahapan.konten.update', [
            $ruangBelajar->id,
            $tahapan->id
        ])
        : route('guru.ruang-belajar.tahapan.konten.store', [
            $ruangBelajar->id,
            $tahapan->id
        ]);
@endphp

{{-- Trix --}}
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.css">

<script src="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.umd.min.js"></script>

<style>
    trix-toolbar {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px 12px 0 0;
        padding: 10px;
    }

    trix-toolbar .trix-button-group {
        border-color: #e5e7eb !important;
    }

    trix-editor {
        min-height: 320px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-top: none;
        border-radius: 0 0 12px 12px;
        background: #fff;
        color: #374151;
        font-size: 14px;
        line-height: 1.8;
    }

    trix-editor:empty::before {
        color: #9ca3af;
    }

    trix-editor:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 2px rgba(139, 92, 246, .1);
    }

    trix-editor h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 12px;
    }

    trix-editor ul {
        list-style-type: disc;
        padding-left: 28px;
        margin: 12px 0;
    }

    trix-editor ol {
        list-style-type: decimal;
        padding-left: 28px;
        margin: 12px 0;
    }

    trix-editor li {
        display: list-item;
        padding-left: 4px;
        margin-bottom: 6px;
        line-height: 1.8;
    }

    trix-editor img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
    }

    .dark trix-toolbar {
        background: #151d2e;
        border-color: #374151;
    }

    .dark trix-toolbar .trix-button-group {
        border-color: #4b5563 !important;
    }

    .dark trix-toolbar .trix-button {
        background-color: #1f2937;
        border-color: #374151;
    }

    .dark trix-editor {
        background: #111827;
        color: #e5e7eb;
        border-color: #374151;
    }

    .dark trix-editor:empty::before {
        color: #6b7280;
    }

    .dark trix-toolbar .trix-button--icon::before {
        filter: invert(1);
    }

    .dark trix-toolbar .trix-button--active {
        background: #6d28d9;
    }

    /* Preview mendukung gambar yang disisipkan melalui Trix. */
    #previewPertanyaan {
        overflow-wrap: anywhere;
    }

    #previewPertanyaan img {
        display: block;
        max-width: 100%;
        width: auto;
        height: auto;
        max-height: 420px;
        object-fit: contain;
        margin: 12px 0;
        border-radius: 12px;
    }

    #previewPertanyaan figure {
        margin: 12px 0;
    }

    #previewPertanyaan p {
        margin: 0 0 10px;
    }

    #previewPertanyaan ul {
        list-style: disc;
        padding-left: 22px;
    }

    #previewPertanyaan ol {
        list-style: decimal;
        padding-left: 22px;
    }

    #previewPertanyaan a {
        color: #7c3aed;
        text-decoration: underline;
    }
</style>

<div class="max-w-6xl mx-auto space-y-6 pb-10">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div class="flex items-start gap-3">

            <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950/40 flex items-center justify-center text-amber-600 shrink-0">
                <i class="fa-solid fa-lightbulb text-xl"></i>
            </div>

            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">
                    Konfigurasi Apersepsi
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Buat materi pemantik dan ajak siswa berpikir melalui forum diskusi.
                </p>
            </div>

        </div>

        <a href="{{ url()->previous() }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 text-sm font-semibold transition">

            <i class="fa-solid fa-arrow-left"></i>
            Kembali

        </a>

    </div>


    {{-- INFORMASI TAHAPAN --}}
    <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-5">

        <div class="flex items-center gap-2 mb-4">
            <i class="fa-solid fa-circle-info text-purple-500"></i>

            <h3 class="font-bold text-gray-800 dark:text-white">
                Informasi Tahapan
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <p class="text-xs text-gray-400 mb-1">Ruang Belajar</p>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                    {{ $ruangBelajar->judul }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-400 mb-1">Nama Tahapan</p>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                    {{ $tahapan->judul_tahapan }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-400 mb-1">Jenis Aktivitas</p>

                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-300 text-xs font-bold">
                    <i class="fa-solid fa-lightbulb"></i>
                    Apersepsi
                </span>
            </div>

        </div>

    </div>


    {{-- VALIDATION ERROR --}}
    @if ($errors->any())

        <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900">

            <div class="flex items-center gap-2 text-red-600 dark:text-red-400 font-bold text-sm mb-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                Periksa kembali pengisian Anda
            </div>

            <ul class="list-disc pl-5 text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ $formAction }}"
        method="POST"
        id="apersepsiForm"
        novalidate
    >

        @csrf

        @if($isEdit)
            @method('PUT')
        @endif


        {{-- ========================================= --}}
        {{-- MATERI APERSEPSI --}}
        {{-- ========================================= --}}

        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden mb-6">

            <div class="p-5 border-b border-gray-100 dark:border-gray-700">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-500 flex items-center justify-center">
                        <i class="fa-solid fa-book-open text-lg"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-white">
                            01. Materi Apersepsi
                        </h3>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Buat pengantar pembelajaran untuk membangun pengetahuan awal siswa.
                        </p>
                    </div>

                </div>

            </div>

            <div class="p-5 space-y-4">

                <div class="flex items-start gap-3 p-4 bg-blue-50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900/40 rounded-xl">

                    <i class="fa-solid fa-circle-info text-blue-500 mt-0.5"></i>

                    <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
                        Gunakan editor untuk menyusun teks, memberikan penekanan informasi, menambahkan daftar, tautan, gambar, dan konten pendukung lainnya.
                    </p>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">
                        Isi Materi Apersepsi
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="materiEditor"
                        type="hidden"
                        name="materi[isi]"
                        value="{{ $materiIsi }}"
                    >

                    <trix-editor
                        id="apersepsiTrix"
                        input="materiEditor"
                        data-upload-url="{{ $uploadUrl }}"
                        placeholder="Tuliskan materi apersepsi..."
                    ></trix-editor>

                    <div id="materiUploadStatus"
                         role="status"
                         aria-live="polite"
                         class="hidden mt-3 text-xs font-medium">

                        <i class="fa-solid fa-cloud-arrow-up mr-1"></i>
                        <span class="upload-status-text"></span>

                    </div>

                    <p class="text-xs text-gray-400 mt-3">
                        <i class="fa-solid fa-pen-to-square mr-1"></i>
                        Gunakan toolbar atau tarik gambar ke editor. Format JPG, PNG, GIF, WebP; maksimal 5 MB.
                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- FORUM DISKUSI --}}
        {{-- ========================================= --}}

        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden mb-6">

            <div class="p-5 border-b border-gray-100 dark:border-gray-700">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/40 text-purple-500 flex items-center justify-center">
                            <i class="fa-solid fa-comments text-lg"></i>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white">
                                02. Forum Diskusi
                            </h3>

                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Berikan pertanyaan pemantik untuk mengajak siswa berpikir kritis.
                            </p>
                        </div>

                    </div>

                    <label class="relative inline-flex items-center cursor-pointer">

                        <input
                            type="hidden"
                            name="forum[aktif]"
                            value="0"
                        >

                        <input
                            type="checkbox"
                            name="forum[aktif]"
                            value="1"
                            id="forumToggle"
                            class="sr-only peer"
                            {{ $forumAktif ? 'checked' : '' }}
                        >

                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:bg-purple-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>

                        <span class="ml-3 text-xs font-semibold text-gray-600 dark:text-gray-300">
                            Aktifkan Forum
                        </span>

                    </label>

                </div>

            </div>


            {{-- KONTEN FORUM --}}
            <div id="forumContent" class="p-5 space-y-5">

                <div>

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Judul Diskusi
                    </label>

                    <input
                        type="text"
                        name="forum[judul]"
                        value="{{ $forumJudul }}"
                        placeholder="Contoh: Mari Berpikir Bersama!"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none"
                    >

                </div>


                {{-- PERTANYAAN --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">
                        Pertanyaan Pemantik
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="forumPertanyaanInput"
                        type="hidden"
                        name="forum[pertanyaan]"
                        value="{{ $forumPertanyaan }}"
                    >

                    <trix-editor
                        id="forumPertanyaanTrix"
                        input="forumPertanyaanInput"
                        data-upload-url="{{ $uploadUrl }}"
                        placeholder="Tuliskan pertanyaan yang akan dijawab oleh siswa..."
                    ></trix-editor>

                    <div id="forumUploadStatus"
                         role="status"
                         aria-live="polite"
                         class="hidden mt-3 text-xs font-medium">

                        <i class="fa-solid fa-cloud-arrow-up mr-1"></i>
                        <span class="upload-status-text"></span>

                    </div>

                    <p class="text-xs text-gray-400 mt-3">
                        Buat pertanyaan terbuka yang mendorong siswa menganalisis, memberikan alasan, dan menyampaikan pendapat.
                    </p>

                </div>


                {{-- BATAS JAWABAN --}}
                <div class="max-w-sm">

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Jumlah Jawaban Maksimal per Siswa
                    </label>

                    <input
                        type="number"
                        name="forum[batas_jawaban]"
                        value="{{ $batasJawaban }}"
                        min="1"
                        max="10"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none"
                    >

                    <p class="text-xs text-gray-400 mt-2">
                        Tentukan berapa kali siswa dapat mengirimkan jawaban.
                    </p>

                </div>


                {{-- PREVIEW --}}
                <div class="p-4 bg-purple-50 dark:bg-purple-950/20 border border-purple-100 dark:border-purple-900/40 rounded-xl">

                    <div class="flex items-center gap-2 mb-3">

                        <i class="fa-solid fa-eye text-purple-500"></i>

                        <span class="text-sm font-bold text-purple-700 dark:text-purple-300">
                            Gambaran Forum Diskusi Siswa
                        </span>

                    </div>

                    <div class="bg-white dark:bg-cyberdark-900 rounded-xl p-4 border border-purple-100 dark:border-gray-700">

                        <p id="previewJudul" class="font-bold text-gray-800 dark:text-white text-sm">
                            {{ $forumJudul }}
                        </p>

                        <div id="previewPertanyaan"
                             class="text-sm text-gray-600 dark:text-gray-300 mt-2 leading-relaxed">
                            <span>{{ trim(strip_tags($forumPertanyaan)) ?: 'Pertanyaan pemantik akan ditampilkan di sini.' }}</span>
                        </div>

                        <div class="mt-4">

                            <textarea
                                disabled
                                rows="2"
                                placeholder="Tuliskan jawaban Anda di sini..."
                                class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-800 text-sm resize-none"
                            ></textarea>

                            <div class="flex justify-end mt-2">

                                <span class="px-4 py-2 rounded-lg bg-purple-600 text-white text-xs font-bold opacity-70">
                                    Kirim Jawaban
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORUM NONAKTIF --}}
            <div id="forumDisabled" class="hidden p-6 bg-gray-50 dark:bg-cyberdark-900/50">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                        <i class="fa-solid fa-comments"></i>
                    </div>

                    <div>
                        <p class="text-sm font-bold text-gray-600 dark:text-gray-300">
                            Forum Diskusi Dinonaktifkan
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Siswa hanya akan melihat materi apersepsi tanpa pertanyaan pemantik.
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- INFORMASI --}}
        <div class="bg-indigo-50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-900/40 rounded-2xl p-5 mb-6">

            <div class="flex gap-3">

                <div class="w-10 h-10 rounded-xl bg-white dark:bg-indigo-900/40 text-indigo-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

                <div>
                    <h4 class="font-bold text-indigo-800 dark:text-indigo-300 text-sm">
                        Pemantauan Aktivitas oleh Guru
                    </h4>

                    <p class="text-xs text-indigo-700 dark:text-indigo-400 mt-1 leading-relaxed">
                        Setelah apersepsi diberikan kepada siswa, guru dapat memantau jumlah siswa yang telah mengirimkan jawaban, melihat identitas siswa, membaca isi jawaban, dan memantau waktu pengiriman melalui halaman pemantauan diskusi.
                    </p>
                </div>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3">

            <a href="{{ url()->previous() }}"
               class="w-full sm:w-auto px-5 py-3 rounded-xl text-sm font-semibold text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition text-center">
                Batal
            </a>

            <button
                type="submit"
                id="submitApersepsi"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-sm font-bold shadow-lg shadow-purple-500/20 transition">

                <i class="fa-solid fa-floppy-disk"></i>

                {{ $isEdit ? 'Perbarui Apersepsi' : 'Simpan Apersepsi' }}

                <i class="fa-solid fa-arrow-right ml-1"></i>

            </button>

        </div>

    </form>

</div>


{{-- ============================================== --}}
{{-- JAVASCRIPT APERSEPSI DAN TRIX --}}
{{-- ============================================== --}}

<script>
(function () {

    'use strict';

    // Mencegah inisialisasi berulang.
    if (window.apersepsiPageInitialized) {
        return;
    }

    window.apersepsiPageInitialized = true;

    window.apersepsiUploadsPending = 0;

    document.addEventListener('DOMContentLoaded', function () {

        const form = document.getElementById('apersepsiForm');

        if (!form) return;

        const materiEditor = document.getElementById('apersepsiTrix');
        const materiInput = document.getElementById('materiEditor');

        const forumEditor = document.getElementById('forumPertanyaanTrix');
        const forumInput = document.getElementById('forumPertanyaanInput');

        const forumToggle = document.getElementById('forumToggle');
        const forumContent = document.getElementById('forumContent');
        const forumDisabled = document.getElementById('forumDisabled');

        const judulInput = form.querySelector('[name="forum[judul]"]');

        const previewJudul = document.getElementById('previewJudul');
        const previewPertanyaan = document.getElementById('previewPertanyaan');

        const submitButton = document.getElementById('submitApersepsi');

        const editorDiizinkan = [
            'apersepsiTrix',
            'forumPertanyaanTrix'
        ];

        // --------------------------------------------------
        // STATUS UPLOAD
        // --------------------------------------------------

        function setStatus(editor, message, visible, type = 'info') {

            const statusId = editor.id === 'apersepsiTrix'
                ? 'materiUploadStatus'
                : 'forumUploadStatus';

            const statusElement = document.getElementById(statusId);

            if (!statusElement) return;

            const textElement = statusElement.querySelector(
                '.upload-status-text'
            );

            if (textElement) {
                textElement.textContent = message;
            }

            statusElement.classList.toggle('hidden', !visible);

            statusElement.classList.remove(
                'text-red-500',
                'text-green-600',
                'text-purple-600',
                'text-blue-600'
            );

            if (type === 'success') {
                statusElement.classList.add('text-green-600');
            } else if (type === 'error') {
                statusElement.classList.add('text-red-500');
            } else {
                statusElement.classList.add('text-purple-600');
            }
        }


        // --------------------------------------------------
        // TOGGLE FORUM
        // --------------------------------------------------

        function toggleForum() {

            const aktif = forumToggle.checked;

            forumContent.classList.toggle('hidden', !aktif);
            forumDisabled.classList.toggle('hidden', aktif);

            // Nonaktifkan input forum ketika forum dimatikan.
            forumContent.querySelectorAll(
                'input[name^="forum["], textarea[name^="forum["], select[name^="forum["]'
            ).forEach(function (element) {

                element.disabled = !aktif;

            });

            // Gunakan API editor Trix jika sudah tersedia.
            if (forumEditor.editor &&
                typeof forumEditor.editor.setReadOnly === 'function') {

                forumEditor.editor.setReadOnly(!aktif);

            } else {

                forumEditor.setAttribute(
                    'contenteditable',
                    aktif ? 'true' : 'false'
                );

            }
        }

        forumToggle.addEventListener('change', toggleForum);

        forumEditor.addEventListener('trix-initialize', toggleForum);


        // --------------------------------------------------
        // PREVIEW JUDUL
        // --------------------------------------------------

        judulInput.addEventListener('input', function () {

            previewJudul.textContent =
                this.value.trim() || 'Judul Diskusi';

        });


        // --------------------------------------------------
        // PREVIEW PERTANYAAN
        // --------------------------------------------------

        function updatePreviewPertanyaan() {

            // Pastikan nilai hidden input mengikuti konten terbaru dari Trix.
            if (forumEditor.editor) {
                forumInput.value = forumEditor.value;
            }

            const html = (forumInput.value || '').trim();

            if (!html) {
                previewPertanyaan.innerHTML =
                    '<span class="text-gray-400">Pertanyaan pemantik akan ditampilkan di sini.</span>';
                return;
            }

            // Render hanya elemen yang dibutuhkan. Elemen/script berbahaya
            // dan atribut event seperti onclick tidak akan disalin ke preview.
            const parser = new DOMParser();
            const parsed = parser.parseFromString(html, 'text/html');
            const allowedTags = new Set([
                'P', 'BR', 'STRONG', 'B', 'EM', 'I', 'U',
                'UL', 'OL', 'LI', 'H1', 'H2', 'H3',
                'BLOCKQUOTE', 'DIV', 'SPAN', 'FIGURE', 'A', 'IMG'
            ]);

            function copySafeNode(node) {
                if (node.nodeType === Node.TEXT_NODE) {
                    return document.createTextNode(node.textContent || '');
                }

                if (node.nodeType !== Node.ELEMENT_NODE) {
                    return document.createDocumentFragment();
                }

                const tag = node.tagName;

                // Abaikan script, style, iframe, dan elemen yang tidak diizinkan.
                if (!allowedTags.has(tag)) {
                    const fragment = document.createDocumentFragment();
                    node.childNodes.forEach(child => {
                        fragment.appendChild(copySafeNode(child));
                    });
                    return fragment;
                }

                const safeElement = document.createElement(tag.toLowerCase());

                if (tag === 'IMG') {
                    const rawSrc = node.getAttribute('src') || '';
                    try {
                        const imageUrl = new URL(rawSrc, window.location.origin);
                        if (!['http:', 'https:'].includes(imageUrl.protocol)) {
                            return document.createDocumentFragment();
                        }
                        safeElement.src = imageUrl.href;
                    } catch (error) {
                        return document.createDocumentFragment();
                    }

                    safeElement.alt = node.getAttribute('alt') || 'Gambar materi';
                    safeElement.loading = 'lazy';
                    safeElement.referrerPolicy = 'no-referrer';
                }

                if (tag === 'A') {
                    const rawHref = node.getAttribute('href') || '';
                    try {
                        const linkUrl = new URL(rawHref, window.location.origin);
                        if (['http:', 'https:'].includes(linkUrl.protocol)) {
                            safeElement.href = linkUrl.href;
                            safeElement.target = '_blank';
                            safeElement.rel = 'noopener noreferrer';
                        }
                    } catch (error) {
                        // Tautan tidak valid ditampilkan sebagai teks biasa.
                    }
                }

                node.childNodes.forEach(child => {
                    safeElement.appendChild(copySafeNode(child));
                });

                return safeElement;
            }

            previewPertanyaan.innerHTML = '';
            parsed.body.childNodes.forEach(node => {
                previewPertanyaan.appendChild(copySafeNode(node));
            });
        }

        forumEditor.addEventListener(
            'trix-change',
            updatePreviewPertanyaan
        );

        forumEditor.addEventListener(
            'trix-initialize',
            updatePreviewPertanyaan
        );


        // --------------------------------------------------
        // VALIDASI KONTEN TRIX
        // --------------------------------------------------

        function hasTrixContent(editor, hiddenInput) {

            const teks = editor.editor
                ? editor.editor.getDocument().toString().trim()
                : '';

            const memilikiGambar = /<img\b/i.test(hiddenInput.value);

            return teks.length > 0 || memilikiGambar;
        }


        // --------------------------------------------------
        // UPLOAD GAMBAR TRIX
        // --------------------------------------------------

        document.addEventListener(
            'trix-attachment-add',
            function (event) {

                const editor = event.target;
                const attachment = event.attachment;

                // Pastikan hanya dua editor ini yang diproses.
                if (
                    !editor ||
                    !editorDiizinkan.includes(editor.id) ||
                    !attachment ||
                    !attachment.file
                ) {
                    return;
                }

                const file = attachment.file;

                // Cegah proses upload ganda.
                if (attachment.__apersepsiUploading) {
                    return;
                }

                attachment.__apersepsiUploading = true;

                let uploadSelesai = false;

                const selesaiUpload = function () {

                    if (uploadSelesai) return;

                    uploadSelesai = true;

                    window.apersepsiUploadsPending = Math.max(
                        0,
                        window.apersepsiUploadsPending - 1
                    );
                };


                const gagalUpload = function (pesan) {

                    attachment.remove();

                    setStatus(
                        editor,
                        pesan,
                        true,
                        'error'
                    );

                    selesaiUpload();

                    attachment.__apersepsiUploading = false;
                };


                // ------------------------------------------
                // VALIDASI FORMAT
                // ------------------------------------------

                const formatDiizinkan = [
                    'image/jpeg',
                    'image/png',
                    'image/gif',
                    'image/webp'
                ];

                if (!formatDiizinkan.includes(file.type)) {

                    alert(
                        'Format gambar harus JPG, JPEG, PNG, GIF, atau WebP.'
                    );

                    gagalUpload('Format gambar tidak didukung.');

                    return;
                }


                // ------------------------------------------
                // VALIDASI UKURAN
                // ------------------------------------------

                const maksimalUkuran = 5 * 1024 * 1024;

                if (file.size > maksimalUkuran) {

                    alert('Ukuran gambar maksimal 5 MB.');

                    gagalUpload('Ukuran gambar melebihi 5 MB.');

                    return;
                }


                // ------------------------------------------
                // URL UPLOAD
                // ------------------------------------------

                const uploadUrl = editor.dataset.uploadUrl;

                if (!uploadUrl) {

                    alert('URL upload gambar tidak ditemukan.');

                    gagalUpload('URL upload tidak ditemukan.');

                    return;
                }


                // ------------------------------------------
                // CSRF TOKEN
                // ------------------------------------------

                const csrfToken =
                    document.querySelector('meta[name="csrf-token"]')?.content ||
                    document.querySelector('input[name="_token"]')?.value;

                if (!csrfToken) {

                    alert('Token CSRF tidak ditemukan.');

                    gagalUpload('Token keamanan tidak ditemukan.');

                    return;
                }


                // ------------------------------------------
                // PERSIAPAN REQUEST
                // ------------------------------------------

                const formData = new FormData();

                formData.append('gambar', file);

                window.apersepsiUploadsPending++;

                setStatus(
                    editor,
                    'Menyiapkan upload gambar...',
                    true
                );

                const xhr = new XMLHttpRequest();

                xhr.open('POST', uploadUrl, true);

                xhr.responseType = 'text';

                xhr.timeout = 60000;

                xhr.setRequestHeader(
                    'X-CSRF-TOKEN',
                    csrfToken
                );

                xhr.setRequestHeader(
                    'Accept',
                    'application/json'
                );


                // ------------------------------------------
                // PROGRESS
                // ------------------------------------------

                xhr.upload.onprogress = function (progressEvent) {

                    if (!progressEvent.lengthComputable) return;

                    const progress = Math.round(
                        (progressEvent.loaded / progressEvent.total) * 100
                    );

                    attachment.setUploadProgress(progress);

                    setStatus(
                        editor,
                        'Mengunggah gambar... ' + progress + '%',
                        true
                    );
                };


                // ------------------------------------------
                // RESPONSE SERVER
                // ------------------------------------------

                xhr.onload = function () {

                    let response = null;

                    try {

                        response = JSON.parse(xhr.responseText);

                    } catch (error) {

                        console.error(
                            'Respons server bukan JSON:',
                            xhr.responseText
                        );

                    }

                    console.log('Trix editor:', editor.id);
                    console.log('HTTP status:', xhr.status);
                    console.log('Respons upload:', response);


                    // Upload berhasil.
                    const returnedImageUrl = response?.url || response?.path || null;
                    let accessibleImageUrl = null;

                    if (returnedImageUrl) {
                        try {
                            const parsedImageUrl = new URL(
                                returnedImageUrl,
                                window.location.origin
                            );

                            if (['http:', 'https:'].includes(parsedImageUrl.protocol)) {
                                accessibleImageUrl = parsedImageUrl.href;
                            }
                        } catch (error) {
                            accessibleImageUrl = null;
                        }
                    }

                    if (
                        xhr.status >= 200 &&
                        xhr.status < 300 &&
                        response &&
                        response.success === true &&
                        accessibleImageUrl
                    ) {

                        attachment.setAttributes({
                            url: accessibleImageUrl,
                            href: accessibleImageUrl
                        });

                        attachment.setUploadProgress(100);

                        setStatus(
                            editor,
                            'Gambar berhasil diunggah.',
                            true,
                            'success'
                        );

                        selesaiUpload();

                        attachment.__apersepsiUploading = false;

                        setTimeout(function () {

                            setStatus(editor, '', false);

                        }, 2500);

                        return;
                    }


                    // --------------------------------------
                    // PESAN ERROR
                    // --------------------------------------

                    let pesan = response?.message ||
                        'Upload gambar gagal.';

                    if (xhr.status === 401 || xhr.status === 403) {

                        pesan = 'Anda tidak memiliki izin mengunggah gambar.';

                    } else if (xhr.status === 404) {

                        pesan = 'Route upload gambar tidak ditemukan.';

                    } else if (xhr.status === 419) {

                        pesan = 'Sesi telah berakhir. Muat ulang halaman.';

                    } else if (xhr.status === 422) {

                        pesan = response?.message ||
                            'File gambar tidak memenuhi validasi.';

                    } else if (xhr.status >= 500) {

                        pesan = 'Terjadi kesalahan server. Periksa Laravel log.';

                    }

                    alert(pesan);

                    gagalUpload(pesan);
                };


                // ------------------------------------------
                // ERROR KONEKSI
                // ------------------------------------------

                xhr.onerror = function () {

                    alert(
                        'Gagal menghubungi server saat mengunggah gambar.'
                    );

                    gagalUpload('Koneksi ke server gagal.');
                };


                // ------------------------------------------
                // TIMEOUT
                // ------------------------------------------

                xhr.ontimeout = function () {

                    alert(
                        'Upload gambar terlalu lama. Silakan coba kembali.'
                    );

                    gagalUpload('Upload gambar melewati batas waktu.');
                };


                // ------------------------------------------
                // REQUEST DIBATALKAN
                // ------------------------------------------

                xhr.onabort = function () {

                    gagalUpload('Upload gambar dibatalkan.');
                };


                // ------------------------------------------
                // KIRIM REQUEST
                // ------------------------------------------

                try {

                    xhr.send(formData);

                } catch (error) {

                    console.error('Kesalahan mengirim upload:', error);

                    gagalUpload('Gagal mengirim gambar ke server.');
                }

            }
        );


        // --------------------------------------------------
        // SUBMIT FORM
        // --------------------------------------------------

        form.addEventListener('submit', function (event) {

            // Cegah submit ketika upload belum selesai.
            if (window.apersepsiUploadsPending > 0) {

                event.preventDefault();

                alert(
                    'Tunggu sampai semua gambar selesai diunggah.'
                );

                return;
            }


            // Sinkronkan nilai hidden input dari editor.
            // Trix biasanya melakukan sinkronisasi otomatis,
            // tetapi ini memastikan nilainya sudah diperbarui.
            materiInput.value = materiEditor.value;

            forumInput.value = forumEditor.value;


            // Validasi materi.
            if (!hasTrixContent(materiEditor, materiInput)) {

                event.preventDefault();

                alert('Silakan isi materi apersepsi terlebih dahulu.');

                materiEditor.focus();

                return;
            }


            // Validasi pertanyaan ketika forum aktif.
            if (
                forumToggle.checked &&
                !hasTrixContent(forumEditor, forumInput)
            ) {

                event.preventDefault();

                alert(
                    'Silakan isi pertanyaan pemantik forum diskusi.'
                );

                forumEditor.focus();

                return;
            }


            // Validasi jumlah jawaban.
            if (forumToggle.checked) {

                const batasInput = form.querySelector(
                    '[name="forum[batas_jawaban]"]'
                );

                const batas = Number(batasInput.value);

                if (
                    !Number.isInteger(batas) ||
                    batas < 1 ||
                    batas > 10
                ) {

                    event.preventDefault();

                    alert(
                        'Jumlah jawaban maksimal harus antara 1 sampai 10.'
                    );

                    batasInput.focus();

                    return;
                }
            }


            // Cegah submit berulang.
            submitButton.disabled = true;

            submitButton.classList.add(
                'opacity-70',
                'cursor-not-allowed'
            );

            submitButton.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                Menyimpan...
            `;

        });


        // --------------------------------------------------
        // INISIALISASI AWAL
        // --------------------------------------------------

        toggleForum();

        updatePreviewPertanyaan();

    });

})();
</script>

@endsection
