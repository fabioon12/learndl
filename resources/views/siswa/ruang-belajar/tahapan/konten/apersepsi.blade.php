
@extends('siswa.layouts.app')

@section('title', 'Apersepsi Interaktif')

@php
    $materi = $konten['materi'] ?? [];
    $forum = $konten['forum'] ?? [];

    $isiMateri = (string) ($materi['isi'] ?? '');

    $materiTersedia = trim(strip_tags($isiMateri)) !== ''
        || preg_match('/<(img|video|audio|iframe|figure|svg)\b/i', $isiMateri) === 1;

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI URL STORAGE
    |--------------------------------------------------------------------------
    | Mengubah URL localhost yang tersimpan di HTML menjadi URL aplikasi.
    */

    $normalisasiUrlTrix = function ($html) {
        return preg_replace_callback(
            '~https?://learndl\.fun/storage/([A-Za-z0-9/_\-.%]+)~i',
            fn ($match) => asset('public/storage/' . $match[1]),
            (string) $html
        );
    };

    $isiMateri = $normalisasiUrlTrix($isiMateri);

    $forumAktif = filter_var(
        $forum['aktif'] ?? false,
        FILTER_VALIDATE_BOOLEAN
    );

    $judulForum = $forum['judul'] ?? 'Forum Diskusi Apersepsi';

    // Pertanyaan forum berupa HTML dari Trix.
    $pertanyaanForum = $normalisasiUrlTrix(
        $forum['pertanyaan'] ?? ''
    );

    $batasJawaban = $forum['batas_jawaban'] ?? null;

    $jawabanSaya = $jawabanSaya ?? null;

    $sudahMenjawab = $forumAktif && filled($jawabanSaya);

    $jawabanTeman = $jawabanTeman ?? collect();

    $jumlahJawaban = $jumlahJawaban
        ?? ($jawabanTeman->count() + ($sudahMenjawab ? 1 : 0));

    /*
    |--------------------------------------------------------------------------
    | JAWABAN SISWA
    |--------------------------------------------------------------------------
    */

    $jawabanSebelumnya = old(
        'jawaban.forum',
        $jawabanSaya ?? ''
    );

    // Normalisasi URL gambar jawaban sendiri.
    $jawabanSayaHtml = $normalisasiUrlTrix(
        is_string($jawabanSaya) ? $jawabanSaya : ''
    );

    $langkahAwal = $forumAktif && $sudahMenjawab ? 3 : 1;

    $jumlahLangkah = $forumAktif ? 3 : 1;

    $editorId = 'jawaban-forum-editor';
@endphp


{{-- =========================================================
     STYLES
========================================================= --}}

@push('styles')

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.css"
>

<style>

    /*
    |--------------------------------------------------------------------------
    | GENERAL
    |--------------------------------------------------------------------------
    */

    .ap-gradient {
        background: linear-gradient(125deg,#4338ca,#6366f1 55%,#8b5cf6);
    }

    .ap-panel {
        background:#fff;
        border:1px solid #e5e7eb;
        border-radius:1.5rem;
        overflow:hidden;
    }

    .dark .ap-panel {
        background:#111827;
        border-color:#374151;
    }

    .ap-step {
        display:flex;
        align-items:center;
        gap:.65rem;
        padding:.85rem 1rem;
        border-radius:1rem;
        color:#6b7280;
        font-size:.8rem;
        font-weight:800;
    }

    .ap-step-number {
        width:2rem;
        height:2rem;
        flex-shrink:0;
        display:grid;
        place-items:center;
        border-radius:.7rem;
        background:#e5e7eb;
        color:#6b7280;
    }

    .ap-step.is-current {
        background:#eef2ff;
        color:#4338ca;
    }

    .ap-step.is-current .ap-step-number {
        background:#4f46e5;
        color:white;
    }

    .ap-step.is-done {
        color:#059669;
    }

    .ap-step.is-done .ap-step-number {
        background:#d1fae5;
        color:#047857;
    }

    .dark .ap-step.is-current {
        background:rgba(99,102,241,.15);
        color:#a5b4fc;
    }

    .dark .ap-step-number {
        background:#374151;
        color:#d1d5db;
    }

    .dark .ap-step.is-done .ap-step-number {
        background:rgba(16,185,129,.2);
        color:#6ee7b7;
    }

    .ap-btn {
        display:inline-flex;
        justify-content:center;
        align-items:center;
        gap:.6rem;
        border-radius:1rem;
        padding:.95rem 1.4rem;
        font-size:.82rem;
        font-weight:800;
        transition:transform .15s,filter .15s;
    }

    .ap-btn:hover {
        transform:translateY(-2px);
        filter:brightness(1.06);
    }

    .ap-btn-primary {
        color:#fff;
        background:linear-gradient(90deg,#4f46e5,#7c3aed);
    }

    .ap-btn-secondary {
        color:#4338ca;
        background:#eef2ff;
    }

    .dark .ap-btn-secondary {
        background:#312e81;
        color:#c7d2fe;
    }

    .ap-material {
        overflow-wrap:anywhere;
        line-height:1.85;
    }

    .ap-material figure,
    .ap-material .attachment {
        max-width:100%;
        margin:1.2rem auto;
    }

    .ap-material img {
        display:block;
        max-width:100%;
        height:auto;
        border-radius:1rem;
        margin:1rem auto;
    }

    .ap-material figure,
    .ap-material .attachment {
        text-align:center;
    }

    .ap-material figure img,
    .ap-material .attachment img {
        margin-left:auto;
        margin-right:auto;
    }

    .ap-material figure a {
        max-width:100%;
        display:inline-block;
    }

    .ap-material .attachment__caption {
        font-size:.75rem;
        color:#9ca3af;
    }

    .ap-material iframe,
    .ap-material video {
        max-width:100%;
    }

    .ap-material table {
        width:100%;
        border-collapse:collapse;
    }

    .ap-material td,
    .ap-material th {
        border:1px solid #d1d5db;
        padding:.65rem;
    }

    .ap-material h1,
    .ap-material h2,
    .ap-material h3 {
        font-weight:800;
        line-height:1.35;
        margin:1rem 0 .5rem;
    }

    .ap-material h1 {
        font-size:1.6rem;
    }

    .ap-material h2 {
        font-size:1.3rem;
    }

    .ap-material ul {
        list-style:disc;
        padding-left:1.5rem;
    }

    .ap-material ol {
        list-style:decimal;
        padding-left:1.5rem;
    }

    [data-ap-screen][hidden] {
        display:none !important;
    }


    /*
    |--------------------------------------------------------------------------
    | TRIX EDITOR SISWA
    |--------------------------------------------------------------------------
    */

    .ap-editor-wrapper {
        overflow:hidden;
        border:1px solid #e5e7eb;
        border-radius:1.25rem;
        background:#fff;
    }

    .ap-editor-wrapper:focus-within {
        border-color:#818cf8;
        box-shadow:0 0 0 3px rgba(99,102,241,.15);
    }

    .ap-editor-wrapper trix-toolbar {
        padding:.75rem;
        background:#f9fafb;
        border-bottom:1px solid #e5e7eb;
    }

    .ap-editor-wrapper trix-toolbar .trix-button-group {
        margin-bottom:.25rem;
    }

    .ap-editor-wrapper trix-toolbar .trix-button {
        background:#fff;
    }

    .ap-editor-wrapper trix-toolbar .trix-button--icon {
        width:2.2rem;
        height:2.2rem;
    }

    .ap-trix-editor {
        display:block;
        min-height:250px;
        max-height:600px;
        overflow-y:auto;
        padding:1.25rem;
        color:#1f2937;
        background:#fff;
        font-size:14px;
        line-height:1.8;
        outline:none;
        overflow-wrap:anywhere;
    }

    .ap-trix-editor:focus {
        outline:none;
    }

    .ap-trix-editor h1 {
        font-size:1.5rem;
        font-weight:800;
        line-height:1.5;
        margin-bottom:.75rem;
        color:#111827;
    }

    .ap-trix-editor p {
        margin-bottom:.65rem;
    }

    .ap-trix-editor ul {
        list-style:disc;
        padding-left:1.5rem;
    }

    .ap-trix-editor ol {
        list-style:decimal;
        padding-left:1.5rem;
    }

    .ap-trix-editor li {
        margin-bottom:.35rem;
    }

    .ap-trix-editor blockquote {
        margin:1rem 0;
        border-left:4px solid #6366f1;
        padding-left:1rem;
        color:#4b5563;
    }

    .ap-trix-editor a {
        color:#2563eb;
        text-decoration:underline;
    }

    .ap-trix-editor pre {
        overflow-x:auto;
        margin:1rem 0;
        padding:1rem;
        border-radius:.5rem;
        background:#1f2937;
        color:#86efac;
        font-family:monospace;
    }

    .ap-trix-editor img {
        max-width:100%;
        height:auto;
    }

    .ap-trix-editor figure {
        margin:1rem 0;
    }

    .ap-trix-editor > :last-child {
        margin-bottom:0;
    }


    /*
    |--------------------------------------------------------------------------
    | TRIX CONTENT DISPLAY
    |--------------------------------------------------------------------------
    | Digunakan untuk menampilkan HTML Trix dari guru dan siswa.
    */

    .ap-trix-content {
        overflow-wrap:anywhere;
        word-break:break-word;
        line-height:1.85;
        font-size:.9rem;
    }

    .ap-trix-content p {
        margin-bottom:.75rem;
    }

    .ap-trix-content p:last-child {
        margin-bottom:0;
    }

    .ap-trix-content strong {
        font-weight:800;
    }

    .ap-trix-content em {
        font-style:italic;
    }

    .ap-trix-content ul {
        list-style:disc;
        padding-left:1.5rem;
        margin:.75rem 0;
    }

    .ap-trix-content ol {
        list-style:decimal;
        padding-left:1.5rem;
        margin:.75rem 0;
    }

    .ap-trix-content li {
        display:list-item;
        margin-bottom:.35rem;
        padding-left:.25rem;
    }

    .ap-trix-content a {
        color:#6366f1;
        text-decoration:underline;
        overflow-wrap:anywhere;
    }

    .ap-trix-content blockquote {
        border-left:4px solid #818cf8;
        padding-left:1rem;
        margin:1rem 0;
        color:#6b7280;
    }

    .ap-trix-content h1 {
        font-size:1.5rem;
        font-weight:800;
        margin:1rem 0 .75rem;
    }

    .ap-trix-content figure {
        margin:1rem auto;
        max-width:100%;
        text-align:center;
    }

    .ap-trix-content img {
        display:block;
        max-width:100%;
        height:auto;
        border-radius:.85rem;
        margin:.75rem auto;
    }

    .ap-trix-content .attachment {
        max-width:100%;
        margin:1rem auto;
        text-align:center;
    }

    .ap-trix-content .attachment__caption {
        text-align:center;
    }

    .ap-trix-content .attachment__caption {
        font-size:.75rem;
        color:#9ca3af;
    }

    .ap-trix-content pre {
        overflow-x:auto;
        white-space:pre-wrap;
        padding:1rem;
        background:#1f2937;
        color:#86efac;
        border-radius:.75rem;
        margin:1rem 0;
    }

    .ap-trix-content table {
        width:100%;
        border-collapse:collapse;
    }

    .ap-trix-content th,
    .ap-trix-content td {
        border:1px solid #d1d5db;
        padding:.65rem;
    }

    .ap-trix-content iframe,
    .ap-trix-content video {
        max-width:100%;
    }

    .dark .ap-trix-content {
        color:#e5e7eb;
    }

    .dark .ap-trix-content blockquote {
        color:#9ca3af;
    }


    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE
    |--------------------------------------------------------------------------
    */

    @media(max-width:640px) {

        .ap-step {
            flex-direction:column;
            text-align:center;
            padding:.7rem .25rem;
            font-size:.65rem;
        }

        .ap-trix-editor {
            min-height:220px;
        }

        .ap-editor-wrapper trix-toolbar {
            padding:.5rem;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | GAME QUEST UI - APERSEPSI
    |--------------------------------------------------------------------------
    | Lapisan visual baru. Alur Blade, form, route, dan JavaScript tetap dipakai.
    */

    #apersepsiWizard {
        --game-bg: #0b1020;
        --game-panel: #121a2e;
        --game-panel-soft: #17233b;
        --game-line: rgba(148, 163, 184, .18);
        --game-cyan: #38e8ff;
        --game-violet: #9b8cff;
        --game-gold: #ffd166;
        position: relative;
        isolation: isolate;
        padding: .35rem;
    }

    #apersepsiWizard::before,
    #apersepsiWizard::after {
        content: "";
        position: absolute;
        z-index: -1;
        pointer-events: none;
        border-radius: 999px;
        filter: blur(55px);
        opacity: .20;
    }

    #apersepsiWizard::before {
        width: 260px;
        height: 260px;
        top: 100px;
        left: -100px;
        background: #5b5cf6;
    }

    #apersepsiWizard::after {
        width: 240px;
        height: 240px;
        right: -80px;
        top: 520px;
        background: #06b6d4;
    }

    #apersepsiWizard > .flex:first-child {
        padding: .75rem .35rem;
    }

    #apersepsiWizard > .flex:first-child > div:first-child > div:first-child {
        width: 3.4rem;
        height: 3.4rem;
        border-radius: 1.15rem;
        color: #061323;
        background: linear-gradient(145deg, #67f5ff, #9d8cff);
        box-shadow: 0 0 26px rgba(56, 232, 255, .28);
    }

    #apersepsiWizard > .flex:first-child h1 {
        color: #f8fafc;
        letter-spacing: -.04em;
        text-shadow: 0 2px 18px rgba(56, 232, 255, .12);
    }

    #apersepsiWizard > .flex:first-child > span {
        border: 1px solid rgba(56, 232, 255, .28);
        background: rgba(15, 30, 52, .82);
        color: #8ff4ff;
        letter-spacing: .10em;
        box-shadow: inset 0 0 18px rgba(56, 232, 255, .06);
    }

    #apersepsiWizard .ap-material img,
    #apersepsiWizard .ap-trix-content img {
        margin-left: auto;
        margin-right: auto;
    }

    #apersepsiWizard .ap-material figure,
    #apersepsiWizard .ap-trix-content figure,
    #apersepsiWizard .ap-material .attachment,
    #apersepsiWizard .ap-trix-content .attachment {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    #apersepsiWizard .ap-panel {
        position: relative;
        color: #e5edf9;
        background:
            linear-gradient(145deg, rgba(24, 35, 59, .98), rgba(13, 20, 37, .98));
        border: 1px solid var(--game-line);
        border-radius: 1.45rem;
        box-shadow:
            0 18px 45px rgba(2, 6, 23, .22),
            inset 0 1px 0 rgba(255, 255, 255, .045);
    }

    #apersepsiWizard .ap-panel > .border-b {
        border-color: rgba(148, 163, 184, .15);
        background: linear-gradient(90deg, rgba(56, 232, 255, .055), transparent 75%);
    }

    #apersepsiWizard .ap-panel h3,
    #apersepsiWizard .ap-panel h4,
    #apersepsiWizard .ap-panel .text-gray-900,
    #apersepsiWizard .ap-panel .text-gray-800 {
        color: #f3f7ff;
    }

    #apersepsiWizard .ap-panel .text-gray-700 {
        color: #cbd5e1;
    }

    #apersepsiWizard .ap-panel .text-gray-500,
    #apersepsiWizard .ap-panel .text-gray-400 {
        color: #9aaac2;
    }

    #apersepsiWizard .ap-gradient {
        min-height: 220px;
        display: flex;
        align-items: center;
        border: 1px solid rgba(56, 232, 255, .28);
        background:
            radial-gradient(circle at 88% 18%, rgba(56, 232, 255, .25), transparent 26%),
            radial-gradient(circle at 12% 100%, rgba(167, 139, 250, .22), transparent 35%),
            linear-gradient(120deg, #111b36 0%, #25205a 55%, #172c4c 100%);
        box-shadow: 0 20px 50px rgba(30, 41, 100, .25);
    }

    #apersepsiWizard .ap-gradient::after {
        content: "✦";
        position: absolute;
        right: 8%;
        bottom: -32px;
        color: rgba(255, 255, 255, .09);
        font-size: 190px;
        line-height: 1;
        transform: rotate(-12deg);
        pointer-events: none;
    }

    #apersepsiWizard .ap-gradient [class*="bg-white/20"] {
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(255, 255, 255, .22);
        background: rgba(7, 17, 38, .35);
        color: #a5f3fc;
        letter-spacing: .12em;
    }

    #apersepsiWizard .ap-gradient h2 {
        max-width: 760px;
        color: #fff;
        letter-spacing: -.035em;
        text-shadow: 0 3px 22px rgba(0, 0, 0, .25);
    }

    #apersepsiWizard .ap-gradient p {
        color: #c7d8f4;
    }

    #apersepsiWizard .ap-step {
        position: relative;
        min-height: 66px;
        border: 1px solid rgba(148, 163, 184, .13);
        background: rgba(8, 15, 30, .45);
        color: #9aaac2;
        border-radius: 1rem;
        transition: .2s ease;
    }

    #apersepsiWizard .ap-step-number {
        width: 2.25rem;
        height: 2.25rem;
        border: 1px solid rgba(148, 163, 184, .18);
        background: #202d47;
        color: #c5d4ea;
        border-radius: .75rem;
    }

    #apersepsiWizard .ap-step.is-current {
        color: #e8fbff;
        border-color: rgba(56, 232, 255, .55);
        background: linear-gradient(120deg, rgba(8, 145, 178, .20), rgba(99, 102, 241, .16));
        box-shadow: 0 0 22px rgba(56, 232, 255, .09), inset 0 0 18px rgba(56, 232, 255, .04);
    }

    #apersepsiWizard .ap-step.is-current .ap-step-number {
        color: #061323;
        border-color: transparent;
        background: linear-gradient(145deg, #67f5ff, #a78bfa);
        box-shadow: 0 0 16px rgba(56, 232, 255, .25);
    }

    #apersepsiWizard .ap-step.is-done {
        color: #9df3d0;
        border-color: rgba(52, 211, 153, .25);
        background: rgba(16, 185, 129, .08);
    }

    #apersepsiWizard .ap-step.is-done .ap-step-number {
        color: #052e25;
        background: #6ee7b7;
        border-color: transparent;
    }

    #apersepsiWizard #apProgress {
        background: linear-gradient(90deg, #38e8ff, #8b83ff, #d18cff);
        box-shadow: 0 0 16px rgba(56, 232, 255, .38);
    }

    #apersepsiWizard .ap-btn {
        min-height: 46px;
        border-radius: .9rem;
        letter-spacing: .01em;
        box-shadow: 0 8px 20px rgba(2, 6, 23, .18);
    }

    #apersepsiWizard .ap-btn-primary {
        color: #071326;
        background: linear-gradient(105deg, #67f5ff, #a99aff);
        border: 1px solid rgba(255, 255, 255, .3);
        box-shadow: 0 8px 24px rgba(56, 189, 248, .17);
    }

    #apersepsiWizard .ap-btn-primary:hover {
        box-shadow: 0 10px 28px rgba(56, 189, 248, .30);
        filter: brightness(1.08);
    }

    #apersepsiWizard .ap-btn-secondary {
        color: #c8d6ed;
        border: 1px solid rgba(148, 163, 184, .22);
        background: rgba(30, 41, 59, .82);
    }

    #apersepsiWizard .ap-btn-secondary:hover {
        border-color: rgba(56, 232, 255, .4);
        color: #a5f3fc;
    }

    #apersepsiWizard [data-ap-screen="2"] .rounded-2xl.bg-indigo-50,
    #apersepsiWizard [data-ap-screen="3"] .rounded-2xl.bg-indigo-50 {
        color: #e2eaff;
        border-color: rgba(129, 140, 248, .25);
        background: linear-gradient(135deg, rgba(67, 56, 202, .19), rgba(8, 145, 178, .10));
    }

    #apersepsiWizard [data-ap-screen="2"] .text-indigo-950,
    #apersepsiWizard [data-ap-screen="3"] .text-indigo-950 {
        color: #e8f1ff;
    }

    #apersepsiWizard [data-ap-screen="2"] .text-indigo-600,
    #apersepsiWizard [data-ap-screen="3"] .text-indigo-600 {
        color: #8eeeff;
    }

    #apersepsiWizard .ap-trix-content img,
    #apersepsiWizard .ap-material img {
        border: 1px solid rgba(148, 163, 184, .18);
        box-shadow: 0 12px 28px rgba(0, 0, 0, .18);
    }

    #apersepsiWizard .ap-editor-wrapper {
        border: 1px solid rgba(56, 232, 255, .24);
        border-radius: 1rem;
        box-shadow: 0 0 0 4px rgba(56, 232, 255, .035);
    }

    #apersepsiWizard .ap-editor-wrapper trix-toolbar {
        background: #edf4ff;
    }

    #apersepsiWizard .ap-trix-editor {
        color: #172033;
        background: #fff;
    }

    #apersepsiWizard .ap-trix-editor img {
        border: 0;
        box-shadow: none;
    }

    #apersepsiWizard [data-ap-screen="3"] article.ap-panel {
        border-left: 3px solid rgba(56, 232, 255, .55);
    }

    #apersepsiWizard .dark .ap-panel {
        background: linear-gradient(145deg, #18233b, #0e172b);
    }

    #apersepsiWizard [role="alert"],
    #apersepsiWizard [role="status"] {
        border-radius: 1rem;
    }

    @media (max-width: 640px) {
        #apersepsiWizard {
            padding: 0;
        }

        #apersepsiWizard .ap-gradient {
            min-height: 200px;
            padding: 1.35rem;
            border-radius: 1.4rem;
        }

        #apersepsiWizard .ap-gradient::after {
            right: -3%;
            font-size: 130px;
        }

        #apersepsiWizard .ap-step {
            min-height: 78px;
            gap: .4rem;
            padding: .65rem .25rem;
        }

        #apersepsiWizard .ap-btn {
            width: 100%;
        }
    }

</style>

@endpush


{{-- =========================================================
     CONTENT
========================================================= --}}

@section('content')

<div
    class="max-w-5xl mx-auto space-y-6"
    id="apersepsiWizard"
    data-start-step="{{ $langkahAwal }}"
    data-forum-active="{{ $forumAktif ? '1' : '0' }}"
    data-has-answer="{{ $sudahMenjawab ? '1' : '0' }}"
>

    {{-- HEADER --}}

    <div class="flex flex-wrap items-center justify-between gap-3">

        <div class="flex items-center gap-3">

            <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 grid place-items-center">
                <i class="fa-solid fa-lightbulb text-xl text-indigo-600 dark:text-indigo-400"></i>
            </div>

            <div>
                <p class="text-[10px] uppercase tracking-[.2em] font-black text-indigo-500">
                    PLAYER QUEST · MODE BELAJAR
                </p>

                <h1 class="text-2xl font-black text-gray-900 dark:text-white">
                    Misi: Asah Pikiran
                </h1>
            </div>

        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a
                href="{{ route('siswa.ruang-belajar.tahapan.show', [
                    'ruang_belajar_id' => $ruangBelajar->id,
                    'tahapan_id' => $tahapan->id
                ]) }}"
                class="inline-flex items-center gap-2 rounded-xl border border-cyan-300/30 bg-slate-900/80 px-4 py-2.5 text-xs font-extrabold tracking-wide text-cyan-100 shadow-lg shadow-cyan-950/20 transition hover:-translate-y-0.5 hover:border-cyan-200 hover:bg-slate-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-cyan-300"
            >
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Ruang Belajar
            </a>

            <span class="rounded-full px-4 py-2 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-300 text-xs font-bold">
                <i class="fa-solid fa-brain mr-2"></i>
                QUEST AKTIF
            </span>
        </div>

    </div>


    {{-- NOTIFIKASI --}}

    @if (session('success'))

        <div
            role="status"
            class="rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/30 dark:border-emerald-900 p-4 text-sm text-emerald-700 dark:text-emerald-300"
        >
            {{ session('success') }}
        </div>

    @endif

    @if (session('error') || $errors->any())

        <div
            role="alert"
            class="rounded-2xl bg-red-50 border border-red-200 dark:bg-red-950/30 dark:border-red-900 p-4 text-sm text-red-700 dark:text-red-300"
        >
            {{ session('error') ?: $errors->first() }}
        </div>

    @endif


    {{-- BANNER APERSEPSI --}}

    <div class="ap-gradient relative overflow-hidden rounded-[2rem] p-6 sm:p-8 text-white">

        <div class="absolute -top-16 -right-12 w-56 h-56 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>

        <div class="relative z-10">

            <span class="text-[10px] font-black uppercase tracking-widest rounded-full px-3 py-1.5 bg-white/20">
                {{ $ruangBelajar->judul ?? 'Ruang Belajar' }}
            </span>

            <h2 class="text-2xl sm:text-3xl font-black mt-5">
                {{ $tahapan->judul_tahapan ?? 'Mari mulai berpikir!' }}
            </h2>

            <p class="text-sm text-indigo-100 mt-3 max-w-2xl leading-relaxed">
                Baca materinya, sampaikan pendapatmu sendiri,
                lalu temukan perspektif baru dari jawaban teman-temanmu.
            </p>

        </div>

    </div>


    {{-- PROGRESS WIZARD --}}

    <div class="ap-panel p-4 sm:p-5">

        <div
            class="grid {{ $forumAktif ? 'grid-cols-3' : 'grid-cols-1' }} gap-2"
            aria-label="Progres aktivitas"
        >

            <div class="ap-step" data-ap-indicator="1">

                <span class="ap-step-number">
                    <i class="fa-solid fa-book-open"></i>
                </span>

                <span>01 · JELAJAHI MATERI</span>

            </div>

            @if ($forumAktif)

                <div class="ap-step" data-ap-indicator="2">

                    <span class="ap-step-number">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </span>

                    <span>02 · SELESAIKAN TANTANGAN</span>

                </div>

                <div class="ap-step" data-ap-indicator="3">

                    <span class="ap-step-number">
                        <i class="fa-solid fa-comments"></i>
                    </span>

                    <span>03 · GABUNG DISKUSI</span>

                </div>

            @endif

        </div>

        <div class="mt-4 h-2 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden">

            <div
                id="apProgress"
                class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full transition-all duration-300"
                style="width:{{ round($langkahAwal / $jumlahLangkah * 100) }}%"
            ></div>

        </div>

    </div>


    {{-- =====================================================
         LAYAR 1: MATERI
    ====================================================== --}}

    <section data-ap-screen="1" class="ap-panel">

        <div class="border-b border-gray-100 dark:border-gray-700 p-5 sm:p-7 flex items-center gap-3">

            <div class="w-11 h-11 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl grid place-items-center">
                <i class="fa-solid fa-book-open-reader text-indigo-600 dark:text-indigo-400"></i>
            </div>

            <div>

                <p class="text-[10px] font-black tracking-widest text-indigo-500 uppercase">
                    Langkah 01
                </p>

                <h3 class="font-black text-lg text-gray-900 dark:text-white">
                    Kenali Materi
                </h3>

            </div>

        </div>


        <div class="p-5 sm:p-8 space-y-6">

            @if ($materiTersedia)

                <article class="ap-material text-gray-700 dark:text-gray-200 text-sm sm:text-base">

                    {!! $isiMateri !!}

                </article>

            @else

                <div class="rounded-2xl bg-amber-50 dark:bg-amber-900/20 p-6 text-amber-700 dark:text-amber-300 text-sm">

                    <i class="fa-solid fa-circle-info mr-2"></i>

                    Guru belum menambahkan materi apersepsi.

                </div>

            @endif


            @if ($forumAktif)

                <div class="flex flex-wrap items-center justify-between gap-3 pt-5 border-t border-gray-100 dark:border-gray-700">

                    <p class="text-xs text-gray-500 dark:text-gray-400">

                        <i class="fa-solid fa-lightbulb text-amber-500 mr-1"></i>

                        Sudah memahami materi? Lanjutkan ke pertanyaan guru.

                    </p>

                    <button
                        type="button"
                        data-ap-next="2"
                        class="ap-btn ap-btn-primary"
                    >

                        Lanjut ke Pertanyaan

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>

                </div>

            @else

                <form
                    method="POST"
                    action="{{ route('siswa.ruang-belajar.tahapan.selesaikan', [
                        'ruang_belajar_id' => $ruangBelajar->id,
                        'tahapan_id' => $tahapan->id
                    ]) }}"
                    class="pt-5 border-t border-gray-100 dark:border-gray-700"
                >

                    @csrf

                    <button type="submit" class="ap-btn ap-btn-primary">

                        Selesaikan Apersepsi

                        <i class="fa-solid fa-check"></i>

                    </button>

                </form>

            @endif

        </div>

    </section>


    @if ($forumAktif)

        {{-- =================================================
             LAYAR 2: PERTANYAAN PEMANTIK
        ================================================== --}}

        <section data-ap-screen="2" hidden class="ap-panel">

            <div class="border-b border-gray-100 dark:border-gray-700 p-5 sm:p-7 flex items-center gap-3">

                <div class="w-11 h-11 bg-violet-100 dark:bg-violet-900/30 rounded-xl grid place-items-center">
                    <i class="fa-solid fa-pen-to-square text-violet-600 dark:text-violet-400"></i>
                </div>

                <div>

                    <p class="text-[10px] font-black tracking-widest text-violet-500 uppercase">
                        Langkah 02
                    </p>

                    <h3 class="font-black text-lg text-gray-900 dark:text-white">
                        Pertanyaan Pemantik
                    </h3>

                </div>

            </div>


            <div class="p-5 sm:p-8 space-y-6">


                {{-- PERTANYAAN GURU --}}

                <div class="rounded-2xl bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/40 p-5 sm:p-7">

                    <div class="flex items-center gap-2 text-indigo-600 dark:text-indigo-300 text-[11px] uppercase tracking-wider font-black mb-3">

                        <i class="fa-solid fa-circle-question"></i>

                        Pertanyaan dari Guru

                    </div>

                    <div class="ap-trix-content text-indigo-950 dark:text-indigo-100 font-semibold text-base sm:text-lg">

                        @if (
                            trim(strip_tags($pertanyaanForum)) !== ''
                            || preg_match('/<img\b/i', $pertanyaanForum)
                        )

                            {!! $pertanyaanForum !!}

                        @else

                            <p>
                                Bagaimana pendapatmu tentang materi yang baru dipelajari?
                            </p>

                        @endif

                    </div>

                </div>


                @if (!$sudahMenjawab)

                    {{-- FORM JAWABAN SISWA --}}

                    <form
                        id="apersepsiAnswerForm"
                        method="POST"
                        action="{{ route('siswa.ruang-belajar.tahapan.apersepsi.jawab', [
                            'ruang_belajar_id' => $ruangBelajar->id,
                            'tahapan_id' => $tahapan->id
                        ]) }}"
                        class="space-y-4"
                    >

                        @csrf


                        <div>

                            <label
                                for="{{ $editorId }}"
                                class="block font-black text-gray-900 dark:text-white text-sm mb-2"
                            >

                                Apa pendapatmu?

                            </label>

                            <p class="text-xs text-gray-500 dark:text-gray-400">

                                Tulis jawaban dengan bahasamu sendiri.
                                Gunakan editor untuk membuat jawaban lebih rapi.

                            </p>

                        </div>


                        {{-- TRIX EDITOR SISWA --}}

                        <div class="ap-editor-wrapper">

                            <input
                                type="hidden"
                                id="{{ $editorId }}"
                                name="jawaban[forum]"
                                value="{{ $jawabanSebelumnya }}"
                            >

                            <trix-editor
                                input="{{ $editorId }}"
                                class="ap-trix-editor"
                                placeholder="Tuliskan pendapat dan jawabanmu di sini..."
                            ></trix-editor>

                        </div>


                        @error('jawaban.forum')

                            <p class="text-xs text-red-500">
                                {{ $message }}
                            </p>

                        @enderror


                        @if ($batasJawaban)

                            <p class="text-xs text-gray-400">
                                Pengaturan batas jawaban guru: {{ $batasJawaban }}
                            </p>

                        @endif


                        {{-- TOMBOL FORM --}}

                        <div class="flex flex-wrap justify-between items-center gap-3">

                            <button
                                type="button"
                                data-ap-next="1"
                                class="ap-btn ap-btn-secondary"
                            >

                                <i class="fa-solid fa-arrow-left"></i>

                                Kembali ke Materi

                            </button>

                            <button
                                type="submit"
                                id="submitApersepsiAnswer"
                                class="ap-btn ap-btn-primary"
                            >

                                <i class="fa-solid fa-paper-plane"></i>

                                Kirim Jawaban & Buka Diskusi

                            </button>

                        </div>

                    </form>

                @else

                    {{-- JAWABAN YANG SUDAH TERKIRIM --}}

                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 dark:bg-emerald-950/20 dark:border-emerald-900 p-5">

                        <p class="text-sm font-black text-emerald-700 dark:text-emerald-300 mb-3">

                            <i class="fa-solid fa-circle-check mr-2"></i>

                            Jawabanmu sudah tersimpan

                        </p>

                        <div class="ap-trix-content text-gray-700 dark:text-gray-200">

                            {!! $jawabanSayaHtml !!}

                        </div>

                    </div>


                    <div class="flex flex-wrap justify-between gap-3">

                        <button
                            type="button"
                            data-ap-next="1"
                            class="ap-btn ap-btn-secondary"
                        >

                            Kembali ke Materi

                        </button>

                        <button
                            type="button"
                            data-ap-next="3"
                            class="ap-btn ap-btn-primary"
                        >

                            Lihat Forum Diskusi

                            <i class="fa-solid fa-arrow-right"></i>

                        </button>

                    </div>

                @endif

            </div>

        </section>


        {{-- =================================================
             LAYAR 3: FORUM DISKUSI
        ================================================== --}}

        @if ($sudahMenjawab)

            <section data-ap-screen="3" hidden class="space-y-5">


                {{-- HEADER FORUM --}}

                <div class="ap-panel p-5 sm:p-7">

                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <div>

                            <p class="text-[10px] font-black tracking-widest text-amber-500 uppercase">
                                Langkah 03
                            </p>

                            <h3 class="font-black text-xl text-gray-900 dark:text-white mt-1">
                                {{ $judulForum }}
                            </h3>

                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Baca pendapat teman dan temukan sudut pandang baru.
                            </p>

                        </div>

                        <span class="rounded-full px-3 py-2 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 text-xs font-bold">

                            <i class="fa-solid fa-users mr-1"></i>

                            {{ $jumlahJawaban }} jawaban

                        </span>

                    </div>


                    {{-- PERTANYAAN FORUM --}}

                    <div class="mt-6 rounded-2xl bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/40 p-5">

                        <p class="text-xs uppercase font-black tracking-wider text-indigo-600 dark:text-indigo-300 mb-3">

                            Pertanyaan Pemantik

                        </p>

                        <div class="ap-trix-content text-indigo-950 dark:text-indigo-100 font-semibold">

                            {!! $pertanyaanForum !!}

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     JAWABAN SAYA
                ================================================== --}}

                <div class="ap-panel p-5 sm:p-7 border-l-4 !border-l-indigo-500">

                    <div class="flex items-center gap-3 mb-4">

                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white grid place-items-center font-black">

                            {{ strtoupper(mb_substr(auth()->user()->fullname ?? 'S', 0, 1)) }}

                        </div>

                        <div>

                            <p class="font-black text-sm text-gray-900 dark:text-white">

                                Jawaban Saya

                                <span class="text-[10px] text-indigo-500 ml-1">
                                    (Kamu)
                                </span>

                            </p>

                            <p class="text-[11px] text-gray-400">
                                Sudah dikirim
                            </p>

                        </div>

                    </div>


                    <div class="ap-trix-content text-gray-700 dark:text-gray-200">

                        {!! $jawabanSayaHtml !!}

                    </div>

                </div>


                {{-- =================================================
                     JAWABAN TEMAN
                ================================================== --}}

                <div class="flex items-center justify-between">

                    <h4 class="font-black text-gray-900 dark:text-white">
                        Pendapat Teman
                    </h4>

                    <span class="text-xs text-gray-400">
                        {{ $jawabanTeman->count() }} jawaban lainnya
                    </span>

                </div>


                @forelse ($jawabanTeman as $item)

                    @php

                        $namaTeman = $item->user?->fullname ?? 'Siswa';

                        $isiJawabanTeman = data_get(
                            $item->jawaban,
                            'forum',
                            ''
                        );

                        $isiJawabanTeman = $normalisasiUrlTrix(
                            $isiJawabanTeman
                        );

                    @endphp


                    <article class="ap-panel p-5 sm:p-6">

                        <div class="flex items-center gap-3 mb-4">

                            <div class="w-10 h-10 rounded-xl bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 grid place-items-center font-black">

                                {{ strtoupper(mb_substr($namaTeman, 0, 1)) }}

                            </div>

                            <div class="min-w-0">

                                <p class="font-black text-sm text-gray-900 dark:text-white truncate">

                                    {{ $namaTeman }}

                                </p>

                                <p class="text-[11px] text-gray-400">

                                    {{ $item->updated_at?->diffForHumans() ?? 'Telah mengirim jawaban' }}

                                </p>

                            </div>

                        </div>


                        {{-- KONTEN TRIX JAWABAN TEMAN --}}

                        <div class="ap-trix-content text-gray-700 dark:text-gray-200">

                            {!! $isiJawabanTeman !!}

                        </div>

                    </article>


                @empty

                    <div class="ap-panel p-8 text-center">

                        <i class="fa-solid fa-comments text-3xl text-indigo-300 mb-3"></i>

                        <p class="font-bold text-gray-800 dark:text-gray-200">
                            Belum ada jawaban teman
                        </p>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            Kamu sudah menjadi yang pertama!
                            Jawaban teman akan muncul setelah mereka mengirimnya.
                        </p>

                    </div>

                @endforelse


                {{-- =================================================
                     SELESAIKAN APERSEPSI
                ================================================== --}}

                <div class="ap-panel p-5 sm:p-7 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">

                    <div>

                        <p class="font-black text-gray-900 dark:text-white">
                            Siap melanjutkan pembelajaran?
                        </p>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Jawabanmu sudah tersimpan.
                            Selesaikan tahap ini untuk memperoleh XP.
                        </p>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('siswa.ruang-belajar.tahapan.selesaikan', [
                            'ruang_belajar_id' => $ruangBelajar->id,
                            'tahapan_id' => $tahapan->id
                        ]) }}"
                    >

                        @csrf

                        <button type="submit" class="ap-btn ap-btn-primary">

                            Selesaikan

                            <i class="fa-solid fa-trophy"></i>

                        </button>

                    </form>

                </div>


                <button
                    type="button"
                    data-ap-next="2"
                    class="ap-btn ap-btn-secondary"
                >

                    <i class="fa-solid fa-arrow-left"></i>

                    Lihat Jawabanku

                </button>

            </section>

        @endif

    @endif

</div>

@endsection


{{-- =========================================================
     SCRIPTS
========================================================= --}}

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.umd.min.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | 1. WIZARD APERSEPSI
    |--------------------------------------------------------------------------
    */

    const wizard = document.getElementById('apersepsiWizard');

    if (!wizard) return;

    const hasAnswer = wizard.dataset.hasAnswer === '1';

    const forumActive = wizard.dataset.forumActive === '1';

    const maxStep = forumActive ? 3 : 1;


    /*
    |--------------------------------------------------------------------------
    | 2. NAVIGASI WIZARD
    |--------------------------------------------------------------------------
    */

    function goTo(step) {

        step = Number(step);

        if (
            step < 1 ||
            step > maxStep ||
            (step === 3 && !hasAnswer)
        ) {
            return;
        }


        // Tampilkan layar sesuai langkah.
        wizard.querySelectorAll('[data-ap-screen]').forEach(function (screen) {

            screen.hidden = Number(screen.dataset.apScreen) !== step;

        });


        // Perbarui indikator langkah.
        wizard.querySelectorAll('[data-ap-indicator]').forEach(function (indicator) {

            const index = Number(indicator.dataset.apIndicator);

            indicator.classList.toggle('is-current', index === step);

            indicator.classList.toggle('is-done', index < step);

            if (index === step) {

                indicator.setAttribute('aria-current', 'step');

            } else {

                indicator.removeAttribute('aria-current');

            }

        });


        // Perbarui progress bar.
        const progress = document.getElementById('apProgress');

        if (progress) {

            progress.style.width = (step / maxStep * 100) + '%';

        }


        wizard.dataset.currentStep = String(step);


        wizard.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

    }


    /*
    |--------------------------------------------------------------------------
    | 3. EVENT NAVIGASI
    |--------------------------------------------------------------------------
    */

    wizard.querySelectorAll('[data-ap-next]').forEach(function (button) {

        button.addEventListener('click', function () {

            goTo(button.dataset.apNext);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | 4. VALIDASI EDITOR JAWABAN SISWA
    |--------------------------------------------------------------------------
    */

    const answerForm = document.getElementById('apersepsiAnswerForm');

    const answerEditor = document.querySelector(
        'trix-editor[input="jawaban-forum-editor"]'
    );

    const answerInput = document.getElementById('jawaban-forum-editor');


    if (answerForm && answerEditor && answerInput) {

        answerForm.addEventListener('submit', function (event) {

            const plainText = answerEditor.editor
                .getDocument()
                .toString()
                .trim();

            const memilikiGambar = /<img\b/i.test(answerInput.value);


            if (!plainText && !memilikiGambar) {

                event.preventDefault();

                answerEditor.focus();

                alert('Silakan tuliskan jawaban terlebih dahulu.');

                return;

            }


            // Sinkronisasi terakhir sebelum form dikirim.
            answerInput.value = answerEditor.value;


            const submitButton = document.getElementById(
                'submitApersepsiAnswer'
            );


            if (submitButton) {

                submitButton.disabled = true;

                submitButton.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    Mengirim Jawaban...
                `;

                submitButton.classList.add(
                    'opacity-70',
                    'cursor-not-allowed'
                );

            }

        });

    }

    /*
    |--------------------------------------------------------------------------
    | 5. TAMPILKAN LAYAR AWAL
    |--------------------------------------------------------------------------
    */

    const validationFailed = @json($errors->any());

    goTo(
        validationFailed && forumActive && !hasAnswer
            ? 2
            : Number(wizard.dataset.startStep || 1)
    );


    /*
    |--------------------------------------------------------------------------
    | 6. LAZY LOAD GAMBAR MATERI
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.ap-material img').forEach(function (img) {

        img.loading = 'lazy';

        img.addEventListener('error', function () {

            if (img.dataset.failed) return;

            img.dataset.failed = '1';

            const note = document.createElement('p');

            note.className =
                'text-sm text-amber-600 dark:text-amber-400 my-3';

            note.textContent =
                'Gambar tidak dapat dimuat. Periksa URL atau akses penyimpanan gambar.';

            img.insertAdjacentElement('afterend', note);

            img.style.display = 'none';

        });

    });


    /*
    |--------------------------------------------------------------------------
    | 7. LAZY LOAD GAMBAR PERTANYAAN DAN JAWABAN
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.ap-trix-content img').forEach(function (img) {

        img.loading = 'lazy';

        img.addEventListener('error', function () {

            if (img.dataset.failed) return;

            img.dataset.failed = '1';

            const note = document.createElement('p');

            note.className =
                'text-xs text-amber-600 dark:text-amber-400 my-2';

            note.textContent =
                'Gambar tidak dapat dimuat.';

            img.insertAdjacentElement('afterend', note);

            img.style.display = 'none';

        });

    });

});

</script>

@endpush
