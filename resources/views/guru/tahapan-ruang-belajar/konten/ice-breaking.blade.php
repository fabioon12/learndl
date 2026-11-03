
@extends('guru.layouts.app')

@section('title', 'Konfigurasi Ice Breaking')

@section('content')

@php
    $konten = $konten ?? [];

    $isEdit = !empty($tahapan->konten);

    $aktivitas = old(
        'aktivitas',
        data_get($konten, 'aktivitas', [])
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

    if (!is_array($aktivitas)) {
        $aktivitas = [];
    }
@endphp

<style>
    .activity-card {
        transition: all .2s ease;
    }

    .activity-card:hover {
        border-color: #a78bfa;
    }

    .activity-card.dragging {
        opacity: .4;
    }

    .activity-editor {
        display: none;
    }

    .activity-card.expanded .activity-editor {
        display: block;
    }

    .activity-card.expanded .toggle-icon {
        transform: rotate(180deg);
    }

    .activity-editor input,
    .activity-editor textarea,
    .activity-editor select {
        width: 100%;
    }

    .dark .activity-card {
        background: #151d2e;
    }

    /* Potongan kode */
    .code-parts {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .code-part {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    .code-part .code-number {
        width: 32px;
        min-width: 32px;
        text-align: center;
        font-size: 12px;
        color: #9ca3af;
        font-weight: 600;
    }

    .code-part .code-value {
        flex: 1;
        min-width: 0;
        width: auto;
        font-family: monospace;
        font-size: 13px;
    }

    .code-part button {
        width: 32px;
        min-width: 32px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .field-answer {
        width: 100%;
    }

    .activity-editor input:focus,
    .activity-editor textarea:focus,
    .activity-editor select:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, .12);
    }
</style>

<div class="max-w-6xl mx-auto space-y-6 pb-10">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div class="flex items-start gap-3">

            <div class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-950/50 flex items-center justify-center text-purple-600 shrink-0">
                <i class="fa-solid fa-gamepad text-xl"></i>
            </div>

            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">
                    Konfigurasi Ice Breaking
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Buat aktivitas menyenangkan untuk membangun semangat dan kesiapan belajar siswa.
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

                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-300 text-xs font-bold">
                    <i class="fa-solid fa-gamepad"></i>
                    Ice Breaking
                </span>
            </div>

        </div>

    </div>


    {{-- ERROR --}}
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


    <form action="{{ $formAction }}" method="POST" id="iceBreakingForm">

        @csrf

        @if($isEdit)
            @method('PUT')
        @endif


        {{-- PETUNJUK --}}
        <div class="bg-purple-50 dark:bg-purple-950/20 border border-purple-100 dark:border-purple-900/40 rounded-2xl p-5">

            <div class="flex gap-3">

                <div class="w-10 h-10 rounded-xl bg-white dark:bg-purple-900/40 text-purple-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>

                <div>
                    <h4 class="font-bold text-purple-800 dark:text-purple-300 text-sm">
                        Tentang Activity Builder
                    </h4>

                    <p class="text-xs text-purple-700 dark:text-purple-400 mt-1 leading-relaxed">
                        Tambahkan satu atau beberapa aktivitas dalam satu tahapan Ice Breaking. Anda dapat menggabungkan video YouTube dan game susun kode program, kemudian mengatur urutannya sesuai kebutuhan pembelajaran.
                    </p>
                </div>

            </div>

        </div>


        {{-- DAFTAR AKTIVITAS --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden mt-6">

            <div class="p-5 border-b border-gray-100 dark:border-gray-700">

                <div class="flex items-center justify-between gap-3">

                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-white">
                            Komponen Aktivitas
                        </h3>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Atur konten yang akan dikerjakan siswa.
                        </p>
                    </div>

                    <span id="activityCount"
                          class="px-3 py-1.5 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-300 text-xs font-bold">
                        0 Aktivitas
                    </span>

                </div>

            </div>


            {{-- CONTAINER AKTIVITAS --}}
            <div class="p-5">

                <div id="activityContainer" class="space-y-4">

                    @foreach($aktivitas as $index => $item)

                        <div class="activity-card border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden {{ $loop->first ? 'expanded' : '' }}"
                             data-type="{{ $item['tipe'] ?? 'youtube' }}">

                            {{-- HEADER CARD --}}
                            <div class="p-4 flex items-center gap-3">

                                <div class="drag-handle cursor-move text-gray-400 hover:text-purple-500">
                                    <i class="fa-solid fa-grip-vertical"></i>
                                </div>

                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                                    {{ ($item['tipe'] ?? '') === 'youtube'
                                        ? 'bg-red-50 dark:bg-red-950/40 text-red-500'
                                        : 'bg-purple-50 dark:bg-purple-950/40 text-purple-500' }}">

                                    <i class="{{ ($item['tipe'] ?? '') === 'youtube'
                                        ? 'fa-brands fa-youtube'
                                        : 'fa-solid fa-code' }} text-lg activity-icon"></i>

                                </div>

                                <div class="flex-1 min-w-0 cursor-pointer" onclick="toggleCard(this)">

                                    <p class="font-bold text-sm text-gray-800 dark:text-white activity-title">
                                        {{ $item['judul'] ?? 'Aktivitas Baru' }}
                                    </p>

                                    <p class="text-xs text-gray-400 activity-type-label">
                                        {{ ($item['tipe'] ?? '') === 'youtube' ? 'Video YouTube' : 'Game Susun Kode' }}
                                    </p>

                                </div>

                                <button type="button"
                                        onclick="moveActivity(this, -1)"
                                        class="w-8 h-8 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        title="Pindah ke atas">
                                    <i class="fa-solid fa-chevron-up"></i>
                                </button>

                                <button type="button"
                                        onclick="moveActivity(this, 1)"
                                        class="w-8 h-8 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"
                                        title="Pindah ke bawah">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>

                                <button type="button"
                                        onclick="removeActivity(this)"
                                        class="w-8 h-8 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-950/40"
                                        title="Hapus aktivitas">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>

                                <button type="button"
                                        onclick="toggleCard(this)"
                                        class="w-8 h-8 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fa-solid fa-chevron-down toggle-icon transition"></i>
                                </button>

                            </div>


                            {{-- FORM EDITOR --}}
                            <div class="activity-editor border-t border-gray-100 dark:border-gray-700 p-5 space-y-5">

                                <input type="hidden"
                                       class="field-id"
                                       name="aktivitas[{{ $index }}][id]"
                                       value="{{ $item['id'] ?? 'item_' . $index }}">

                                <input type="hidden"
                                       class="field-type"
                                       name="aktivitas[{{ $index }}][tipe]"
                                       value="{{ $item['tipe'] ?? 'youtube' }}">


                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                        Judul Aktivitas
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <input type="text"
                                           class="field-title px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none"
                                           name="aktivitas[{{ $index }}][judul]"
                                           value="{{ $item['judul'] ?? '' }}"
                                           placeholder="Contoh: Tonton Video Pengenalan Algoritma"
                                           required>
                                </div>


                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                        Deskripsi Aktivitas
                                    </label>

                                    <textarea
                                        name="aktivitas[{{ $index }}][deskripsi]"
                                        rows="2"
                                        placeholder="Berikan arahan singkat kepada siswa..."
                                        class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none resize-none">{{ $item['deskripsi'] ?? '' }}</textarea>
                                </div>


                                {{-- FORM YOUTUBE --}}
                                @if(($item['tipe'] ?? '') === 'youtube')

                                    <div class="type-youtube space-y-3">

                                        <div class="flex items-center gap-2 text-red-500 font-bold text-sm">
                                            <i class="fa-brands fa-youtube text-lg"></i>
                                            Konfigurasi Video YouTube
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                                URL Video YouTube
                                                <span class="text-red-500">*</span>
                                            </label>

                                            <input type="url"
                                                   name="aktivitas[{{ $index }}][url]"
                                                   value="{{ $item['url'] ?? '' }}"
                                                   placeholder="https://www.youtube.com/watch?v=..."
                                                   required
                                                   class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none">

                                            <p class="text-xs text-gray-400 mt-2">
                                                Masukkan tautan video YouTube yang dapat diakses siswa.
                                            </p>
                                        </div>

                                    </div>

                                {{-- FORM GAME --}}
                                @else

                                    @php
                                        $config = $item['konfigurasi'] ?? [];

                                        $potongan = $config['potongan_kode'] ?? [
                                            'console.log("Hello World");',
                                            'let pesan = "Hello World";'
                                        ];

                                        $urutan = $config['urutan_benar'] ?? [1, 0];
                                    @endphp

                                    <div class="type-game space-y-4">

                                        <div class="flex items-center gap-2 text-purple-500 font-bold text-sm">
                                            <i class="fa-solid fa-code text-lg"></i>
                                            Konfigurasi Game Susun Kode
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                                Bahasa Pemrograman
                                            </label>

                                            <select name="aktivitas[{{ $index }}][konfigurasi][bahasa]"
                                                    class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none">

                                                <option value="javascript" {{ ($config['bahasa'] ?? 'javascript') === 'javascript' ? 'selected' : '' }}>JavaScript</option>
                                                <option value="php" {{ ($config['bahasa'] ?? '') === 'php' ? 'selected' : '' }}>PHP</option>
                                                <option value="python" {{ ($config['bahasa'] ?? '') === 'python' ? 'selected' : '' }}>Python</option>
                                                <option value="html" {{ ($config['bahasa'] ?? '') === 'html' ? 'selected' : '' }}>HTML</option>
                                                <option value="css" {{ ($config['bahasa'] ?? '') === 'css' ? 'selected' : '' }}>CSS</option>

                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                                Instruksi Permainan
                                            </label>

                                            <textarea
                                                name="aktivitas[{{ $index }}][konfigurasi][instruksi]"
                                                rows="3"
                                                placeholder="Susun potongan kode berikut agar menghasilkan output yang benar..."
                                                class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none resize-none">{{ $config['instruksi'] ?? '' }}</textarea>
                                        </div>

                                        {{-- POTONGAN KODE --}}
                                        <div>

                                            <div class="flex items-center justify-between gap-2 mb-3">

                                                <div>
                                                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                                        Potongan Kode Program
                                                    </label>

                                                    <p class="text-xs text-gray-400 mt-1">
                                                        Setiap baris menjadi satu potongan kode yang harus disusun siswa.
                                                    </p>
                                                </div>

                                                <button type="button"
                                                        onclick="addCodePart(this)"
                                                        class="px-3 py-2 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-300 text-xs font-bold">
                                                    <i class="fa-solid fa-plus mr-1"></i>
                                                    Tambah
                                                </button>

                                            </div>

                                            <div class="code-parts">

                                                @foreach($potongan as $pieceIndex => $piece)

                                                    <div class="code-part">

                                                        <div class="code-number">
                                                            {{ $pieceIndex + 1 }}
                                                        </div>

                                                        <input
                                                            type="text"
                                                            name="aktivitas[{{ $index }}][konfigurasi][potongan_kode][]"
                                                            value="{{ $piece }}"
                                                            placeholder="Masukkan potongan kode..."
                                                            class="code-value px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm font-mono outline-none"
                                                        >

                                                        <button
                                                            type="button"
                                                            onclick="removeCodePart(this)"
                                                            class="text-gray-400 hover:text-red-500 shrink-0"
                                                            title="Hapus potongan kode"
                                                        >
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>


                                        {{-- KUNCI JAWABAN --}}
                                        <div class="p-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/40 rounded-xl">

                                            <div class="flex items-start gap-2 mb-3">

                                                <i class="fa-solid fa-lock text-amber-600 mt-0.5"></i>

                                                <div>
                                                    <p class="text-sm font-bold text-amber-800 dark:text-amber-300">
                                                        Kunci Urutan Kode
                                                    </p>

                                                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                                                        Masukkan nomor potongan berdasarkan urutan yang benar.
                                                    </p>
                                                </div>

                                            </div>

                                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                                Contoh: 2, 1, 3
                                            </label>

                                            <input
                                                type="text"
                                                name="aktivitas[{{ $index }}][konfigurasi][urutan_benar_text]"
                                                value="{{ is_array($urutan) ? implode(', ', $urutan) : $urutan }}"
                                                placeholder="Contoh: 2, 1, 3"
                                                class="field-answer px-4 py-3 rounded-xl border border-amber-200 dark:border-amber-900 bg-white dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none"
                                            >

                                            <p class="text-xs text-amber-700 dark:text-amber-400 mt-2">
                                                Nomor dimulai dari 1 sesuai urutan potongan kode yang tampil di atas.
                                            </p>

                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- EMPTY STATE --}}
                <div id="emptyState"
                     class="{{ count($aktivitas) ? 'hidden' : '' }} py-12 text-center">

                    <div class="w-16 h-16 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="fa-solid fa-puzzle-piece text-2xl"></i>
                    </div>

                    <h4 class="font-bold text-gray-700 dark:text-gray-200">
                        Belum Ada Aktivitas
                    </h4>

                    <p class="text-sm text-gray-400 mt-2">
                        Mulai tambahkan video YouTube atau game susun kode.
                    </p>

                </div>

            </div>

        </div>


        {{-- TAMBAH AKTIVITAS --}}
        <div class="mt-6">

            <div class="mb-3">
                <h3 class="font-bold text-gray-800 dark:text-white">
                    Tambahkan Aktivitas
                </h3>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Pilih jenis aktivitas yang ingin ditambahkan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- YOUTUBE --}}
                <button type="button"
                        onclick="addActivity('youtube')"
                        class="group text-left bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 hover:border-red-400 rounded-2xl p-5 transition">

                    <div class="flex items-center gap-3">

                        <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-950/40 text-red-500 flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fa-brands fa-youtube text-2xl"></i>
                        </div>

                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 dark:text-white text-sm">
                                Video YouTube
                            </h4>

                            <p class="text-xs text-gray-400 mt-1">
                                Tambahkan video pembelajaran.
                            </p>
                        </div>

                        <i class="fa-solid fa-plus text-gray-400 group-hover:text-red-500"></i>

                    </div>

                </button>


                {{-- GAME --}}
                <button type="button"
                        onclick="addActivity('susun_kode')"
                        class="group text-left bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 hover:border-purple-400 rounded-2xl p-5 transition">

                    <div class="flex items-center gap-3">

                        <div class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-950/40 text-purple-500 flex items-center justify-center group-hover:scale-110 transition">
                            <i class="fa-solid fa-code text-xl"></i>
                        </div>

                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800 dark:text-white text-sm">
                                Game Susun Kode
                            </h4>

                            <p class="text-xs text-gray-400 mt-1">
                                Buat permainan logika pemrograman.
                            </p>
                        </div>

                        <i class="fa-solid fa-plus text-gray-400 group-hover:text-purple-500"></i>

                    </div>

                </button>

            </div>

        </div>


        {{-- INFORMASI --}}
        <div class="bg-indigo-50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-900/40 rounded-2xl p-5 mt-6">

            <div class="flex gap-3">

                <div class="w-10 h-10 rounded-xl bg-white dark:bg-indigo-900/40 text-indigo-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>

                <div>
                    <h4 class="font-bold text-indigo-800 dark:text-indigo-300 text-sm">
                        Pemantauan Aktivitas
                    </h4>

                    <p class="text-xs text-indigo-700 dark:text-indigo-400 mt-1 leading-relaxed">
                        Guru nantinya dapat melihat aktivitas yang telah diselesaikan oleh siswa, termasuk progres pengerjaan setiap video dan permainan susun kode.
                    </p>
                </div>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3 mt-6">

            <a href="{{ url()->previous() }}"
               class="w-full sm:w-auto px-5 py-3 rounded-xl text-sm font-semibold text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition text-center">
                Batal
            </a>

            <button type="submit"
                    id="saveButton"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-sm font-bold shadow-lg shadow-purple-500/20 transition">

                <i class="fa-solid fa-floppy-disk"></i>

                {{ $isEdit ? 'Perbarui Ice Breaking' : 'Simpan Ice Breaking' }}

            </button>

        </div>

    </form>

</div>


{{-- TEMPLATE YOUTUBE --}}
<template id="youtubeTemplate">

    <div class="activity-card border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden expanded"
         data-type="youtube">

        <div class="p-4 flex items-center gap-3">

            <div class="drag-handle text-gray-400">
                <i class="fa-solid fa-grip-vertical"></i>
            </div>

            <div class="w-10 h-10 rounded-xl bg-red-50 dark:bg-red-950/40 text-red-500 flex items-center justify-center shrink-0">
                <i class="fa-brands fa-youtube text-lg activity-icon"></i>
            </div>

            <div class="flex-1 min-w-0 cursor-pointer" onclick="toggleCard(this)">
                <p class="font-bold text-sm text-gray-800 dark:text-white activity-title">Video YouTube Baru</p>
                <p class="text-xs text-gray-400 activity-type-label">Video YouTube</p>
            </div>

            <button type="button" onclick="moveActivity(this,-1)" class="w-8 h-8 text-gray-400 hover:text-purple-500">
                <i class="fa-solid fa-chevron-up"></i>
            </button>

            <button type="button" onclick="moveActivity(this,1)" class="w-8 h-8 text-gray-400 hover:text-purple-500">
                <i class="fa-solid fa-chevron-down"></i>
            </button>

            <button type="button" onclick="removeActivity(this)" class="w-8 h-8 text-gray-400 hover:text-red-500">
                <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" onclick="toggleCard(this)" class="w-8 h-8 text-gray-400">
                <i class="fa-solid fa-chevron-down toggle-icon transition"></i>
            </button>

        </div>

        <div class="activity-editor border-t border-gray-100 dark:border-gray-700 p-5 space-y-5">

            <input type="hidden" class="field-id" value="">
            <input type="hidden" class="field-type" value="youtube">

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Judul Aktivitas *</label>
                <input type="text" class="field-title px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none" placeholder="Judul video..." required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Deskripsi Aktivitas</label>
                <textarea rows="2" class="field-description px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none resize-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">URL YouTube *</label>
                <input type="url" class="field-url px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none" placeholder="https://www.youtube.com/watch?v=..." required>
            </div>

        </div>

    </div>

</template>


{{-- TEMPLATE GAME --}}
<template id="gameTemplate">

    <div class="activity-card border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden expanded"
         data-type="susun_kode">

        <div class="p-4 flex items-center gap-3">

            <div class="drag-handle text-gray-400">
                <i class="fa-solid fa-grip-vertical"></i>
            </div>

            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/40 text-purple-500 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-code text-lg activity-icon"></i>
            </div>

            <div class="flex-1 min-w-0 cursor-pointer" onclick="toggleCard(this)">
                <p class="font-bold text-sm text-gray-800 dark:text-white activity-title">Game Susun Kode Baru</p>
                <p class="text-xs text-gray-400 activity-type-label">Game Susun Kode</p>
            </div>

            <button type="button" onclick="moveActivity(this,-1)" class="w-8 h-8 text-gray-400 hover:text-purple-500">
                <i class="fa-solid fa-chevron-up"></i>
            </button>

            <button type="button" onclick="moveActivity(this,1)" class="w-8 h-8 text-gray-400 hover:text-purple-500">
                <i class="fa-solid fa-chevron-down"></i>
            </button>

            <button type="button" onclick="removeActivity(this)" class="w-8 h-8 text-gray-400 hover:text-red-500">
                <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" onclick="toggleCard(this)" class="w-8 h-8 text-gray-400">
                <i class="fa-solid fa-chevron-down toggle-icon transition"></i>
            </button>

        </div>

        <div class="activity-editor border-t border-gray-100 dark:border-gray-700 p-5 space-y-5">

            <input type="hidden" class="field-id" value="">
            <input type="hidden" class="field-type" value="susun_kode">

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Judul Permainan *</label>
                <input type="text" class="field-title px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none" placeholder="Contoh: Susun Kode Hello World" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Deskripsi</label>
                <textarea rows="2" class="field-description px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none resize-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Bahasa Pemrograman</label>
                <select class="field-language px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none">
                    <option value="javascript">JavaScript</option>
                    <option value="php">PHP</option>
                    <option value="python">Python</option>
                    <option value="html">HTML</option>
                    <option value="html">Css</option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Instruksi Permainan</label>
                <textarea class="field-instruction px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none resize-none" rows="3" placeholder="Tuliskan instruksi permainan..."></textarea>
            </div>

            <div>
                <div class="flex justify-between items-center mb-3">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">Potongan Kode</label>
                    <button type="button" onclick="addCodePart(this)" class="text-xs font-bold text-purple-600">
                        <i class="fa-solid fa-plus mr-1"></i> Tambah Baris
                    </button>
                </div>

                <div class="code-parts space-y-2">

                    <div class="code-part">
                        <div class="w-8 text-center text-xs text-gray-400 code-number">1</div>
                        <input type="text" class="code-value px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm font-mono outline-none" placeholder="Potongan kode...">
                        <button type="button" onclick="removeCodePart(this)" class="w-8 text-gray-400 hover:text-red-500"><i class="fa-solid fa-trash"></i></button>
                    </div>

                    <div class="code-part">
                        <div class="w-8 text-center text-xs text-gray-400 code-number">2</div>
                        <input type="text" class="code-value px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm font-mono outline-none" placeholder="Potongan kode...">
                        <button type="button" onclick="removeCodePart(this)" class="w-8 text-gray-400 hover:text-red-500"><i class="fa-solid fa-trash"></i></button>
                    </div>

                </div>
            </div>

            <div class="p-4 bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/40 rounded-xl">

                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-lock text-amber-600"></i>
                    <span class="font-bold text-sm text-amber-800 dark:text-amber-300">Kunci Urutan Kode</span>
                </div>

                <input type="text" class="field-answer px-4 py-3 rounded-xl border border-amber-200 dark:border-amber-900 bg-white dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm outline-none" placeholder="Contoh: 2, 1">

                <p class="text-xs text-amber-700 dark:text-amber-400 mt-2">
                    Nomor urutan berdasarkan posisi potongan kode di atas, dimulai dari 1.
                </p>

            </div>

        </div>

    </div>

</template>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const container = document.getElementById('activityContainer');
    const emptyState = document.getElementById('emptyState');
    const countLabel = document.getElementById('activityCount');
    const form = document.getElementById('iceBreakingForm');

    if (!container || !form) {
        console.error('Activity container atau form Ice Breaking tidak ditemukan.');
        return;
    }

    let counter = 0;

    // =====================================================
    // HELPER: MENGAMBIL ELEMEN
    // =====================================================

    function getAnswerInput(card) {
        return card.querySelector(
            '.field-answer, [name*="[urutan_benar_text]"]'
        );
    }

    function getCodeInputs(card) {
        const inputs = card.querySelectorAll(
            '.code-part input[type="text"], .code-part .code-value'
        );

        inputs.forEach(input => {
            input.classList.add('code-value');
        });

        return inputs;
    }

    function updateCount() {
        const cards = container.querySelectorAll('.activity-card');

        if (countLabel) {
            countLabel.textContent = cards.length + ' Aktivitas';
        }

        if (emptyState) {
            emptyState.classList.toggle('hidden', cards.length > 0);
        }
    }

    // =====================================================
    // MENGATUR NAME INPUT
    // =====================================================

    function updateNames() {

        const cards = container.querySelectorAll('.activity-card');

        cards.forEach((card, index) => {

            prepareCard(card);

            card.querySelectorAll('[data-field]').forEach(element => {
                element.name = `aktivitas[${index}]${element.dataset.field}`;
            });

            // Potongan kode
            getCodeInputs(card).forEach(input => {
                input.name = `aktivitas[${index}][konfigurasi][potongan_kode][]`;
            });

        });

        updateCount();
    }

    // =====================================================
    // MEMPERSIAPKAN FIELD SETIAP AKTIVITAS
    // =====================================================

    function prepareCard(card) {

        const type = card.dataset.type;

        const fields = {
            '.field-id': '[id]',
            '.field-type': '[tipe]',
            '.field-title': '[judul]',
            '.field-description': '[deskripsi]'
        };

        Object.entries(fields).forEach(([selector, suffix]) => {

            const element = card.querySelector(selector);

            if (element) {
                element.dataset.field = suffix;
            }

        });

        if (type === 'youtube') {

            const url = card.querySelector(
                '.field-url, input[type="url"]'
            );

            if (url) {
                url.classList.add('field-url');
                url.dataset.field = '[url]';
            }

        } else if (type === 'susun_kode') {

            const language = card.querySelector(
                '.field-language, select[name*="[bahasa]"]'
            );

            const instruction = card.querySelector(
                '.field-instruction, textarea[name*="[instruksi]"]'
            );

            const answer = getAnswerInput(card);

            if (language) {
                language.classList.add('field-language');
                language.dataset.field = '[konfigurasi][bahasa]';
            }

            if (instruction) {
                instruction.classList.add('field-instruction');
                instruction.dataset.field = '[konfigurasi][instruksi]';
            }

            if (answer) {
                answer.classList.add('field-answer');
                answer.dataset.field = '[konfigurasi][urutan_benar_text]';
            }

            getCodeInputs(card).forEach(input => {
                input.dataset.field = '[konfigurasi][potongan_kode][]';
            });

        }

    }

    // =====================================================
    // NOMOR URUT POTONGAN KODE
    // =====================================================

    function updateCodeNumbers(card) {

        const parts = card.querySelectorAll('.code-part');

        parts.forEach((part, index) => {

            const number = part.querySelector('.code-number');

            if (number) {
                number.textContent = index + 1;
            }

        });

    }

    // =====================================================
    // TAMBAH AKTIVITAS
    // =====================================================

    window.addActivity = function (type) {

        const template = document.getElementById(
            type === 'youtube' ? 'youtubeTemplate' : 'gameTemplate'
        );

        if (!template) {
            alert('Template aktivitas tidak ditemukan.');
            return;
        }

        const clone = template.content.cloneNode(true);
        const card = clone.querySelector('.activity-card');

        const id = 'item_' + Date.now() + '_' + (++counter);

        const idInput = card.querySelector('.field-id');

        if (idInput) {
            idInput.value = id;
        }

        prepareCard(card);

        container.appendChild(card);

        updateNames();
        updateCodeNumbers(card);

        card.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        const input = card.querySelector('.field-title');

        if (input) {
            input.focus();
        }

    };

    // =====================================================
    // BUKA / TUTUP AKTIVITAS
    // =====================================================

    window.toggleCard = function (element) {

        const card = element.closest('.activity-card');

        if (card) {
            card.classList.toggle('expanded');
        }

    };

    // =====================================================
    // HAPUS AKTIVITAS
    // =====================================================

    window.removeActivity = function (button) {

        if (!confirm('Apakah Anda yakin ingin menghapus aktivitas ini?')) {
            return;
        }

        const card = button.closest('.activity-card');

        if (card) {
            card.remove();
        }

        updateNames();

    };

    // =====================================================
    // PINDAH URUTAN AKTIVITAS
    // =====================================================

    window.moveActivity = function (button, direction) {

        const card = button.closest('.activity-card');

        if (!card) return;

        if (direction === -1) {

            const previous = card.previousElementSibling;

            if (previous) {
                container.insertBefore(card, previous);
            }

        } else {

            const next = card.nextElementSibling;

            if (next) {
                container.insertBefore(next, card);
            }

        }

        updateNames();

    };

    // =====================================================
    // TAMBAH POTONGAN KODE
    // =====================================================

    window.addCodePart = function (button) {

        const card = button.closest('.activity-card');
        const parts = card.querySelector('.code-parts');

        if (!parts) return;

        const item = document.createElement('div');

        item.className = 'code-part';

        item.innerHTML = `
            <div class="code-number"></div>

            <input
                type="text"
                class="code-value px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm font-mono outline-none"
                placeholder="Masukkan potongan kode..."
            >

            <button
                type="button"
                onclick="removeCodePart(this)"
                class="w-8 h-8 text-gray-400 hover:text-red-500 shrink-0"
                title="Hapus potongan kode"
            >
                <i class="fa-solid fa-trash-can"></i>
            </button>
        `;

        parts.appendChild(item);

        updateNames();
        updateCodeNumbers(card);

        const input = item.querySelector('.code-value');

        if (input) {
            input.focus();
        }

    };

    // =====================================================
    // HAPUS POTONGAN KODE
    // =====================================================

    window.removeCodePart = function (button) {

        const card = button.closest('.activity-card');
        const parts = card.querySelector('.code-parts');

        if (!parts) return;

        const totalParts = parts.querySelectorAll('.code-part').length;

        if (totalParts <= 2) {
            alert('Minimal harus terdapat dua potongan kode.');
            return;
        }

        button.closest('.code-part').remove();

        updateCodeNumbers(card);
        updateNames();

    };

    // =====================================================
    // UPDATE JUDUL AKTIVITAS
    // =====================================================

    container.addEventListener('input', function (event) {

        if (event.target.classList.contains('field-title')) {

            const card = event.target.closest('.activity-card');
            const title = card.querySelector('.activity-title');

            if (title) {
                title.textContent = event.target.value || 'Aktivitas Baru';
            }

        }

    });

    // =====================================================
    // PERSIAPKAN AKTIVITAS YANG SUDAH TERSIMPAN
    // =====================================================

    container.querySelectorAll('.activity-card').forEach(card => {

        prepareCard(card);
        updateCodeNumbers(card);

    });

    updateNames();

    // =====================================================
    // VALIDASI DAN PENYIMPANAN
    // =====================================================

    form.addEventListener('submit', function (event) {

        const cards = container.querySelectorAll('.activity-card');

        if (cards.length === 0) {

            event.preventDefault();

            alert('Tambahkan minimal satu aktivitas Ice Breaking.');

            return;
        }

        for (const card of cards) {

            const type = card.dataset.type;

            // ---------------------------------------------
            // VALIDASI YOUTUBE
            // ---------------------------------------------

            if (type === 'youtube') {

                const url = card.querySelector('.field-url');

                if (!url || !url.value.trim()) {

                    event.preventDefault();

                    alert('Masukkan URL YouTube pada setiap aktivitas video.');

                    url?.focus();

                    return;
                }

                continue;
            }

            // ---------------------------------------------
            // VALIDASI GAME SUSUN KODE
            // ---------------------------------------------

            if (type === 'susun_kode') {

                const codeInputs = getCodeInputs(card);

                const codes = Array.from(codeInputs).map(input => {
                    return input.value.trim();
                });

                // Minimal dua potongan kode dan wajib terisi
                if (codes.length < 2 || codes.some(code => code === '')) {

                    event.preventDefault();

                    alert('Setiap game harus memiliki minimal dua potongan kode yang terisi.');

                    const emptyInput = Array.from(codeInputs).find(input => {
                        return !input.value.trim();
                    });

                    emptyInput?.focus();

                    return;
                }

                // Ambil kunci jawaban
                const answer = getAnswerInput(card);

                if (!answer || !answer.value.trim()) {

                    event.preventDefault();

                    alert('Masukkan kunci urutan kode.');

                    answer?.focus();

                    return;
                }

                // Menerima format:
                // 1,2,3
                // 1, 2, 3
                // [1,2,3]

                const answerText = answer.value
                    .replace(/[\[\]]/g, '')
                    .trim();

                const rawNumbers = answerText.split(',');

                // Pastikan tidak ada bagian angka yang kosong atau bukan angka
                const allNumeric = rawNumbers.every(value => {
                    return /^\d+$/.test(value.trim());
                });

                if (!allNumeric) {

                    event.preventDefault();

                    alert('Kunci jawaban harus berisi angka yang dipisahkan dengan koma.');

                    answer.focus();

                    return;
                }

                const numbers = rawNumbers.map(value => {
                    return Number(value.trim());
                });

                const totalParts = codes.length;

                // Angka yang wajib tersedia: 1 sampai jumlah potongan
                const expected = Array.from(
                    { length: totalParts },
                    (_, index) => index + 1
                );

                const sortedNumbers = [...numbers].sort((a, b) => a - b);

                const valid =
                    numbers.length === totalParts &&
                    JSON.stringify(sortedNumbers) === JSON.stringify(expected);

                if (!valid) {

                    event.preventDefault();

                    alert(
                        `Kunci urutan harus memuat setiap nomor potongan kode tepat satu kali. Gunakan angka 1 sampai ${totalParts}.`
                    );

                    answer.focus();

                    return;
                }

                // -----------------------------------------
                // BUAT INPUT HIDDEN BERBENTUK ARRAY
                // -----------------------------------------

                card.querySelectorAll('.answer-hidden').forEach(input => {
                    input.remove();
                });

                numbers.forEach(number => {

                    const hidden = document.createElement('input');

                    hidden.type = 'hidden';
                    hidden.className = 'answer-hidden';

                    hidden.name = answer.name.replace(
                        '[urutan_benar_text]',
                        '[urutan_benar][]'
                    );

                    hidden.value = number;

                    card.appendChild(hidden);

                });

                // Nonaktifkan input teks agar tidak terkirim
                answer.disabled = true;

            }

        }

    });

});

</script>

@endsection
