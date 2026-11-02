@extends('guru.layouts.app')

@section('title', 'Tambah Aktivitas - ' . $submateri->judul_sub)

@push('scripts')
<!-- CDN Trix Editor -->
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

<style>
    /* Custom Styling Trix Editor */
    trix-toolbar {
        background-color: #f8fafc;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        padding: 0.5rem;
    }
    trix-editor {
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
        min-height: 180px;
        background-color: #ffffff;
    }
    .trix-content h1 {
        font-size: 1.5rem !important;
        line-height: 2rem !important;
        font-weight: 800 !important;
        margin-top: 0.75rem !important;
        margin-bottom: 0.5rem !important;
    }
    .trix-content ul {
        list-style-type: disc !important;
        padding-left: 1.5rem !important;
    }
    .trix-content ol {
        list-style-type: decimal !important;
        padding-left: 1.5rem !important;
    }
    .trix-content li {
        display: list-item !important;
    }
        /* Style Toolbar & Box Editor */
    trix-toolbar {
        background-color: #f8fafc;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        padding: 0.5rem;
    }
    trix-editor {
        border-bottom-left-radius: 1rem;
        border-bottom-right-radius: 1rem;
        min-height: 180px;
        background-color: #ffffff;
    }

    /* Fix Heading & List untuk Tailwind CSS Reset */
    .trix-content h1 {
        font-size: 1.5rem !important;
        line-height: 2rem !important;
        font-weight: 800 !important;
        margin-top: 0.75rem !important;
        margin-bottom: 0.5rem !important;
    }
    .trix-content ul {
        list-style-type: disc !important;
        padding-left: 1.5rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    .trix-content ol {
        list-style-type: decimal !important;
        padding-left: 1.5rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    .trix-content li {
        display: list-item !important;
        margin-bottom: 0.25rem !important;
    }
</style>

@endpush

@section('content')
<div class="space-y-6 max-w-5xl mx-auto" x-data="aktivitasBuilder({{ json_encode($allowedTypes) }}, {{ json_encode($existingBlocks ?? []) }})">

    <!-- Header & Breadcrumb -->
    <div class="flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 pb-4">
        <div>
            <nav class="flex text-xs text-gray-400 gap-2 items-center mb-1">
                <a href="{{ route('guru.materi.index') }}" class="hover:text-indigo-600 transition">Ruang Materi</a>
                <span>&rsaquo;</span>
                <a href="{{ route('guru.materi.submateri.index', $materi->id) }}" class="hover:text-indigo-600 transition">{{ $materi->judul }}</a>
                <span>&rsaquo;</span>
                <span class="text-indigo-600 dark:text-indigo-400 font-bold">Builder Aktivitas</span>
            </nav>
            <h2 class="text-lg font-black text-gray-900 dark:text-white">Susun Aktivitas Sub Materi</h2>
            <p class="text-xs text-gray-500">Sub Materi: <strong>{{ $submateri->judul_sub }}</strong></p>
        </div>
    </div>

    <form action="{{ route('guru.materi.submateri.aktivitas.store', ['materi_id' => $materi->id, 'submateri_id' => $submateri->id]) }}" 
        method="POST" 
        class="space-y-6">
        @csrf

        <!-- Control Bar: Tambah Blok Konten -->
        <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-5 shadow-xs space-y-3">
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                + Tambah Blok Konten Ke Urutan
            </label>
            <div class="flex flex-wrap gap-2">
                <template x-for="tipe in allowedTypes" :key="tipe">
                    <button type="button" 
                            @click="addBlock(tipe)"
                            class="px-4 py-2 rounded-2xl border border-gray-200 dark:border-pink-950/30 text-xs font-bold hover:bg-indigo-50 dark:hover:bg-indigo-950/40 hover:border-indigo-500 hover:text-indigo-600 transition flex items-center gap-2">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span x-text="getLabel(tipe)"></span>
                    </button>
                </template>
            </div>
            <p class="text-[11px] text-gray-400">Klik tombol di atas untuk menambah urutan materi.</p>
        </div>

        <!-- Dynamic Blocks Container -->
        <div class="space-y-4">
            <template x-for="(block, index) in blocks" :key="block.id">
                <div class="bg-white dark:bg-cyberdark-900 border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 shadow-xs space-y-4 relative">
                    
                    <!-- Header Block -->
                    <div class="flex items-center justify-between border-b border-gray-100 dark:border-pink-950/20 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-indigo-600 text-white font-black text-xs flex items-center justify-center" x-text="index + 1"></span>
                            <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400" x-text="'Blok Konten: ' + getLabel(block.tipe)"></span>
                        </div>

                        <div class="flex items-center gap-1">
                            <button type="button" @click="moveUp(index)" :disabled="index === 0" class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-cyberdark-800 text-gray-500 disabled:opacity-30 hover:bg-indigo-600 hover:text-white transition flex items-center justify-center">
                                <i class="fa-solid fa-arrow-up text-xs"></i>
                            </button>
                            <button type="button" @click="moveDown(index)" :disabled="index === blocks.length - 1" class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-cyberdark-800 text-gray-500 disabled:opacity-30 hover:bg-indigo-600 hover:text-white transition flex items-center justify-center">
                                <i class="fa-solid fa-arrow-down text-xs"></i>
                            </button>
                            <button type="button" @click="removeBlock(index)" class="w-7 h-7 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-600 hover:text-white transition flex items-center justify-center ml-2">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Hidden Input Tipe Section -->
                    <input type="hidden" :name="`sections[${index}][tipe]`" :value="block.tipe">

                    <!-- ISOLASI PARTIAL MENGGUNAKAN x-if (Hanya render 1 partial aktif per blok) -->
                    <template x-if="block.tipe === 'teks'">
                        <div>
                            @include('guru.materi.submateri.aktivitas.partials.block-teks')
                        </div>
                    </template>

                    <template x-if="block.tipe === 'video'">
                        <div>
                            @include('guru.materi.submateri.aktivitas.partials.block-video')
                        </div>
                    </template>

                    <template x-if="block.tipe === 'interaktif'">
                        <div>
                            @include('guru.materi.submateri.aktivitas.partials.block-interaktif')
                        </div>
                    </template>

                    <template x-if="block.tipe === 'praktik'">
                        <div>
                            @include('guru.materi.submateri.aktivitas.partials.block-praktik')
                        </div>
                    </template>

                    <template x-if="block.tipe === 'latihan'">
                        <div>
                            @include('guru.materi.submateri.aktivitas.partials.block-latihan')
                        </div>
                    </template>

                </div>
            </template>
        </div>

        <!-- Submit Button -->
        <div class="pt-4 border-t border-gray-100 dark:border-pink-950/20 flex items-center justify-end gap-3">
            <a href="{{ route('guru.materi.submateri.index', $materi->id) }}" class="px-5 py-2.5 rounded-2xl border border-gray-200 dark:border-pink-950/30 text-xs font-bold text-gray-500 hover:bg-gray-100 transition">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md transition active:scale-95 flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Urutan Aktivitas
            </button>
        </div>

    </form>
</div>

@include('guru.materi.submateri.aktivitas.partials.script-builder')
@endsection