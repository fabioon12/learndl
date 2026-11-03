
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

{{-- TRIX EDITOR --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.css">

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

    trix-editor img {
        max-width: 100%;
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

    .forum-disabled {
        opacity: .45;
        pointer-events: none;
    }

    .choice-preview {
        transition: all .2s ease;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.umd.min.js"></script>

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

        <a href="{{ route('guru.ruang-belajar.tahapan.konten.edit', [
            $ruangBelajar->id,
            $tahapan->id
        ]) }}"
           class="hidden">
        </a>

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

    <form action="{{ $formAction }}" method="POST" id="apersepsiForm">

        @csrf

        @if($isEdit)
            @method('PUT')
        @endif

        {{-- ========================================= --}}
        {{-- BAGIAN 1: MATERI APERSEPSI --}}
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
                        Gunakan editor di bawah ini untuk membuat materi apersepsi. Guru dapat menyusun teks, memberikan penekanan informasi, menambahkan daftar, tautan, dan konten pendukung lainnya.
                    </p>

                </div>

                <div>

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">
                        Isi Materi Apersepsi
                        <span class="text-red-500">*</span>
                    </label>

                    {{-- Hidden input untuk Trix --}}
                    <input
                        id="materiEditor"
                        type="hidden"
                        name="materi[isi]"
                        value="{{ $materiIsi }}">

                    {{-- Trix Editor --}}
                    <trix-editor
                        input="materiEditor"
                        placeholder="Mulai tuliskan materi apersepsi di sini...">

                    </trix-editor>

                    <div class="flex items-center justify-between gap-2 mt-3">

                        <p class="text-xs text-gray-400">
                            <i class="fa-solid fa-pen-to-square mr-1"></i>
                            Gunakan toolbar untuk mengatur tampilan materi.
                        </p>

                        <span class="text-xs text-gray-400">
                            Editor Trix
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================= --}}
        {{-- BAGIAN 2: FORUM DISKUSI --}}
        {{-- ========================================= --}}

        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden mb-6">

            {{-- HEADER FORUM --}}
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

                    {{-- TOGGLE FORUM --}}
                    <label class="relative inline-flex items-center cursor-pointer">

                        <input
                            type="hidden"
                            name="forum[aktif]"
                            value="0">

                        <input
                            type="checkbox"
                            name="forum[aktif]"
                            value="1"
                            id="forumToggle"
                            class="sr-only peer"
                            {{ $forumAktif ? 'checked' : '' }}>

                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:bg-purple-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>

                        <span class="ml-3 text-xs font-semibold text-gray-600 dark:text-gray-300">
                            Aktifkan Forum
                        </span>

                    </label>

                </div>

            </div>

            {{-- KONTEN FORUM --}}
            <div id="forumContent" class="p-5 space-y-5">

                {{-- JUDUL FORUM --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Judul Diskusi
                    </label>

                    <input
                        type="text"
                        name="forum[judul]"
                        value="{{ $forumJudul }}"
                        placeholder="Contoh: Mari Berpikir Bersama!"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none">

                </div>

                {{-- PERTANYAAN PEMANTIK --}}
                <div>

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Pertanyaan Pemantik
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        name="forum[pertanyaan]"
                        rows="4"
                        placeholder="Tuliskan pertanyaan yang akan dijawab oleh siswa..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none resize-none">{{ $forumPertanyaan }}</textarea>

                    <p class="text-xs text-gray-400 mt-2">
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
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none">

                    <p class="text-xs text-gray-400 mt-2">
                        Tentukan berapa kali siswa dapat mengirimkan jawaban.
                    </p>

                </div>

                {{-- PREVIEW PERTANYAAN --}}
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

                        <p id="previewPertanyaan" class="text-sm text-gray-600 dark:text-gray-300 mt-2 leading-relaxed whitespace-pre-line">
                            {{ $forumPertanyaan ?: 'Pertanyaan pemantik akan ditampilkan di sini.' }}
                        </p>

                        <div class="mt-4">

                            <textarea
                                disabled
                                rows="2"
                                placeholder="Tuliskan jawaban Anda di sini..."
                                class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-800 text-sm resize-none">

                            </textarea>

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


        {{-- ACTION BUTTON --}}
        <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3">

            <a href="{{ url()->previous() }}"
               class="w-full sm:w-auto px-5 py-3 rounded-xl text-sm font-semibold text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition text-center">

                Batal

            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-sm font-bold shadow-lg shadow-purple-500/20 transition">

                <i class="fa-solid fa-floppy-disk"></i>

                {{ $isEdit ? 'Perbarui Apersepsi' : 'Simpan Apersepsi' }}

                <i class="fa-solid fa-arrow-right ml-1"></i>

            </button>

        </div>

    </form>

</div>


{{-- JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forumToggle = document.getElementById('forumToggle');
    const forumContent = document.getElementById('forumContent');
    const forumDisabled = document.getElementById('forumDisabled');

    function toggleForum() {

        const aktif = forumToggle.checked;

        forumContent.classList.toggle('hidden', !aktif);
        forumDisabled.classList.toggle('hidden', aktif);

        forumContent.querySelectorAll('input, textarea').forEach(element => {
            element.disabled = !aktif;
        });
    }

    forumToggle.addEventListener('change', toggleForum);

    toggleForum();

    const judulInput = document.querySelector('[name="forum[judul]"]');
    const pertanyaanInput = document.querySelector('[name="forum[pertanyaan]"]');

    const previewJudul = document.getElementById('previewJudul');
    const previewPertanyaan = document.getElementById('previewPertanyaan');

    judulInput.addEventListener('input', function () {
        previewJudul.textContent = this.value || 'Judul Diskusi';
    });

    pertanyaanInput.addEventListener('input', function () {
        previewPertanyaan.textContent = this.value || 'Pertanyaan pemantik akan ditampilkan di sini.';
    });


    const form = document.getElementById('apersepsiForm');
    const editor = document.querySelector('trix-editor');

    form.addEventListener('submit', function (e) {

        const isi = editor.editor.getDocument().toString().trim();

        if (!isi) {
            e.preventDefault();
            alert('Silakan isi materi apersepsi terlebih dahulu.');
            editor.focus();
            return;
        }

        if (forumToggle.checked && !pertanyaanInput.value.trim()) {
            e.preventDefault();

            alert('Silakan isi pertanyaan pemantik forum diskusi.');
            pertanyaanInput.focus();
        }

    });

});
</script>

@endsection
