
@php
    $project = $block['project'] ?? [];
    $missions = $project['missions'] ?? [];

    $projectName = $project['nama'] ?? 'Coding Project';
    $projectDescription = $project['deskripsi'] ?? '';
    $starterCode = $project['starter_code'] ?? '<!DOCTYPE html>
<html>
<head>
    <title>Website Saya</title>
</head>
<body>
    <h1>Halo Dunia!</h1>
</body>
</html>';
@endphp

<div
    id="coding-project-{{ $index }}"
    class="space-y-5"
    data-coding-project
>
    {{-- DATA PROJECT --}}
    <script type="application/json" id="coding-project-data-{{ $index }}">
        {!! json_encode([
            'nama' => $projectName,
            'deskripsi' => $projectDescription,
            'starter_code' => $starterCode,
            'missions' => $missions,
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
    </script>

    {{-- HEADER PROJECT --}}
    <div class="overflow-hidden rounded-2xl border-2 border-[#A69E95]
                bg-[#333] shadow-[5px_5px_0_#111]">

        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-5 sm:p-6">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center
                                rounded-xl bg-white/15 text-2xl">
                        💻
                    </div>

                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-indigo-100">
                            Coding Project
                        </p>

                        <h2 class="mt-1 text-lg font-extrabold text-white">
                            {{ $projectName }}
                        </h2>
                    </div>
                </div>

                <span class="rounded-lg border border-white/20
                             bg-white/10 px-3 py-1.5 text-xs
                             font-extrabold text-white">
                    HTML
                </span>
            </div>
        </div>

        <div class="p-5 sm:p-6">
            <p class="text-sm leading-7 text-gray-300">
                {{ $projectDescription ?: 'Selesaikan setiap misi dengan menulis kode HTML.' }}
            </p>

            <div class="mt-5 flex flex-wrap gap-3">
                <div class="rounded-lg bg-[#242424] px-3 py-2">
                    <p class="text-[10px] font-bold uppercase text-gray-500">
                        Bahasa
                    </p>
                    <p class="mt-1 text-sm font-bold text-indigo-300">
                        HTML
                    </p>
                </div>

                <div class="rounded-lg bg-[#242424] px-3 py-2">
                    <p class="text-[10px] font-bold uppercase text-gray-500">
                        Total Misi
                    </p>
                    <p class="mt-1 text-sm font-bold text-white">
                        {{ count($missions) }} Misi
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- PROGRESS MISI --}}
    <div class="rounded-2xl border-2 border-[#A69E95]
                bg-[#333] p-5 shadow-[5px_5px_0_#111]">

        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="font-extrabold text-white">
                    🗺️ Petualangan Misi
                </h3>
                <p class="mt-1 text-xs text-gray-400">
                    Selesaikan tantangan satu per satu.
                </p>
            </div>

            <span id="coding-progress-text-{{ $index }}"
                  class="text-xs font-bold text-indigo-300">
                0/{{ count($missions) }} selesai
            </span>
        </div>

        <div class="mb-5 h-2 overflow-hidden rounded-full bg-[#202020]">
            <div id="coding-progress-bar-{{ $index }}"
                 class="h-full w-0 rounded-full bg-indigo-500 transition-all duration-300">
            </div>
        </div>

        <div id="coding-mission-list-{{ $index }}" class="space-y-3">
            @forelse($missions as $missionIndex => $mission)
                <button
                    type="button"
                    class="coding-mission-button flex w-full items-center gap-3
                           rounded-xl border-2 border-gray-700 bg-[#292929]
                           p-3 text-left transition hover:border-indigo-400"
                    data-mission-index="{{ $missionIndex }}"
                    onclick="selectCodingMission({{ $index }}, {{ $missionIndex }})"
                >
                    <span class="coding-mission-number flex h-10 w-10 shrink-0
                                 items-center justify-center rounded-xl
                                 bg-[#202020] font-extrabold text-gray-300">
                        {{ $missionIndex + 1 }}
                    </span>

                    <span class="min-w-0 flex-1">
                        <span class="coding-mission-title block truncate
                                     text-sm font-bold text-white">
                            {{ $mission['judul'] ?? 'Misi ' . ($missionIndex + 1) }}
                        </span>

                        <span class="coding-mission-status mt-1 block
                                     text-xs text-gray-500">
                            Belum dikerjakan
                        </span>
                    </span>

                    <span class="coding-mission-icon text-lg text-gray-500">
                        ○
                    </span>
                </button>
            @empty
                <p class="rounded-xl bg-[#292929] p-4 text-sm text-gray-400">
                    Belum ada misi yang ditambahkan oleh guru.
                </p>
            @endforelse
        </div>
    </div>

    {{-- DETAIL MISI --}}
    <div class="rounded-2xl border-2 border-[#A69E95]
                bg-[#333] p-5 shadow-[5px_5px_0_#111]">

        <div class="mb-4 flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center
                         rounded-xl bg-yellow-500/15 text-xl">
                🎯
            </span>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-yellow-400">
                    Tantangan Aktif
                </p>

                <h3 id="coding-current-title-{{ $index }}"
                    class="mt-1 font-extrabold text-white">
                    Pilih Misi
                </h3>
            </div>
        </div>

        {{-- INSTRUKSI RICH TEXT --}}
        <div class="rounded-xl border border-white/10 bg-[#292929] p-4">
            <div class="mb-3 flex items-center gap-2">
                <span class="text-lg">📋</span>
                <p class="text-xs font-bold uppercase tracking-wider text-gray-400">
                    Instruksi Pengerjaan
                </p>
            </div>

            <div
                id="coding-current-instruction-{{ $index }}"
                class="coding-rich-content text-sm leading-7 text-gray-300"
            >
                <p>Pilih salah satu misi untuk melihat instruksi pengerjaan.</p>
            </div>
        </div>

        {{-- PETUNJUK RICH TEXT --}}
        <div id="coding-hint-wrapper-{{ $index }}"
             class="mt-3 hidden rounded-xl border border-yellow-500/20
                    bg-yellow-500/5 p-4">

            <div class="mb-3 flex items-center gap-2">
                <span class="text-lg">💡</span>
                <p class="text-xs font-bold uppercase tracking-wider text-yellow-400">
                    Petunjuk
                </p>
            </div>

            <div
                id="coding-current-hint-{{ $index }}"
                class="coding-rich-content text-sm leading-7 text-gray-300"
            ></div>
        </div>
    </div>

    {{-- EDITOR --}}
    <div class="overflow-hidden rounded-2xl border-2 border-[#A69E95]
                bg-[#333] shadow-[5px_5px_0_#111]">

        <div class="flex items-center justify-between gap-3
                    border-b border-white/10 bg-[#242424] px-4 py-4">

            <div class="flex items-center gap-3">
                <span class="text-xl">⌨️</span>

                <div>
                    <h3 class="text-sm font-extrabold text-white">
                        Code Editor
                    </h3>
                    <p class="mt-1 text-[10px] text-gray-500">
                        index.html
                    </p>
                </div>
            </div>

            <span class="rounded-md bg-orange-500/15 px-3 py-1.5
                         text-[10px] font-extrabold text-orange-300">
                HTML
            </span>
        </div>

        <div class="relative bg-[#171923]">
            <div class="flex items-center gap-2 border-b border-white/5 px-4 py-2">
                <span class="h-2.5 w-2.5 rounded-full bg-red-500"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-yellow-500"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>

                <span class="ml-2 text-[10px] text-gray-500">
                    index.html
                </span>
            </div>

            <textarea
                id="coding-editor-{{ $index }}"
                spellcheck="false"
                autocapitalize="off"
                autocomplete="off"
                autocorrect="off"
                class="block min-h-[320px] w-full resize-y
                       border-0 bg-transparent p-5 font-mono
                       text-sm leading-7 text-green-300
                       outline-none focus:ring-0"
                placeholder="Tulis kode HTML kamu di sini..."
            >{{ $starterCode }}</textarea>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3
                    border-t border-white/10 bg-[#242424] p-3">

            <p class="text-[10px] text-gray-500">
                Perubahan kode akan ditampilkan pada preview.
            </p>

            <button
                type="button"
                onclick="resetCodingEditor({{ $index }})"
                class="rounded-lg border border-gray-600 px-3 py-2
                       text-xs font-bold text-gray-300
                       transition hover:bg-white/10">
                ↺ Reset Kode
            </button>
        </div>
    </div>

    {{-- LIVE PREVIEW --}}
    <div class="overflow-hidden rounded-2xl border-2 border-[#A69E95]
                bg-[#333] shadow-[5px_5px_0_#111]">

        <div class="flex items-center justify-between gap-3
                    border-b border-white/10 px-5 py-4">

            <div class="flex items-center gap-3">
                <span class="text-xl">🌐</span>

                <div>
                    <h3 class="text-sm font-extrabold text-white">
                        Live Preview
                    </h3>
                    <p class="mt-1 text-[10px] text-gray-500">
                        Hasil tampilan website kamu
                    </p>
                </div>
            </div>

            <span class="rounded-md bg-green-500/15 px-3 py-1.5
                         text-[10px] font-bold text-green-400">
                LIVE
            </span>
        </div>

        <div class="bg-white p-2">
            <iframe
                id="coding-preview-{{ $index }}"
                title="Preview hasil HTML"
                sandbox=""
                class="h-[300px] w-full rounded-lg border-0 bg-white"
            ></iframe>
        </div>
    </div>

    {{-- HASIL PEMERIKSAAN --}}
    <div
        id="coding-feedback-{{ $index }}"
        class="hidden rounded-xl border p-4"
        role="status"
        aria-live="polite">
    </div>

    {{-- TOMBOL PERIKSA --}}
    <button
        type="button"
        id="coding-check-{{ $index }}"
        onclick="checkCodingMission({{ $index }})"
        class="w-full rounded-xl bg-[#F5C400] py-4
               text-sm font-extrabold tracking-wider
               text-[#292929] shadow-[0_5px_0_#B58E00]
               transition hover:bg-yellow-300 active:translate-y-1
               active:shadow-none">
        🔍 PERIKSA JAWABAN
    </button>

    <p class="text-center text-xs leading-6 text-gray-500">
        Pastikan kode sudah sesuai dengan instruksi misi sebelum
        menekan tombol periksa.
    </p>
</div>
<script src="https://cdn.jsdelivr.net/npm/dompurify@3.2.6/dist/purify.min.js"></script>
<style>
    .coding-rich-content {
        overflow-wrap: anywhere;
    }

    .coding-rich-content > * + * {
        margin-top: 0.75rem;
    }

    .coding-rich-content h1 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.4;
    }

    .coding-rich-content h2 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #fff;
        line-height: 1.5;
    }

    .coding-rich-content h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
    }

    .coding-rich-content p {
        margin-bottom: 0.5rem;
    }

    .coding-rich-content strong,
    .coding-rich-content b {
        color: #fff;
        font-weight: 800;
    }

    .coding-rich-content ul {
        list-style: disc;
        padding-left: 1.5rem;
    }

    .coding-rich-content ol {
        list-style: decimal;
        padding-left: 1.5rem;
    }

    .coding-rich-content li {
        padding-left: 0.25rem;
        margin-top: 0.35rem;
    }

    .coding-rich-content a {
        color: #a5b4fc;
        text-decoration: underline;
    }

    .coding-rich-content blockquote {
        border-left: 3px solid #818cf8;
        padding-left: 1rem;
        color: #cbd5e1;
        font-style: italic;
    }

    .coding-rich-content pre {
        overflow-x: auto;
        border-radius: 0.75rem;
        background: #171923;
        padding: 1rem;
        color: #86efac;
        font-family: monospace;
        font-size: 0.8rem;
    }

    .coding-rich-content code {
        border-radius: 0.25rem;
        background: #171923;
        padding: 0.15rem 0.35rem;
        color: #86efac;
        font-family: monospace;
    }

    .coding-rich-content table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.85rem;
    }

    .coding-rich-content th,
    .coding-rich-content td {
        border: 1px solid #4b5563;
        padding: 0.5rem;
        text-align: left;
    }

    .coding-rich-content th {
        background: #242424;
        color: #fff;
    }

    .coding-rich-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
    }
</style>
