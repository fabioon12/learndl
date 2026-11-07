@extends('siswa.layouts.app')

@section('title', 'Pengerjaan Ice Breaking')

@section('content')

@php
    // Ambil konten tahapan
    $dataKonten = $konten ?? $tahapan->konten ?? [];

    if (is_string($dataKonten)) {
        $dataKonten = json_decode($dataKonten, true) ?? [];
    }

    $aktivitasList = data_get($dataKonten, 'aktivitas', []);
    $aktivitasList = is_array($aktivitasList) ? array_values($aktivitasList) : [];
    $totalAktivitas = count($aktivitasList);
@endphp

<style>
.code-game-hero {
    position: relative;
    padding-top: 12px;
}

.code-game-character {
    height: 105px;
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
    padding-left: 20px;
}

.code-game-character span {
    font-size: 76px;
    line-height: 1;
    filter: drop-shadow(3px 4px 0 rgba(0,0,0,.25));
}

.code-game-instruction {
    position: relative;
    background: #292929;
    border: 2px solid #a9a39a;
    padding: 22px 25px;
    box-shadow: 6px 6px 0 #111;
}

.code-game-label {
    color: #facc15;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.code-game-board {
    background: #202020;
    border: 1px solid #333;
    border-radius: 12px;
    padding: 20px;
    box-shadow: inset 0 2px 8px rgba(0,0,0,.2);
}

.code-progress-counter {
    color: #facc15;
    font-size: 12px;
    font-weight: 900;
    white-space: nowrap;
}

.code-answer-slots {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(75px, 1fr));
    gap: 9px;
}

.code-answer-slot {
    min-width: 0;
    min-height: 66px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 7px;
    border: 2px dashed #666;
    border-radius: 9px;
    background: rgba(255,255,255,.035);
    transition: .2s ease;
}

.code-answer-slot.drag-over {
    border-color: #facc15;
    background: rgba(250,204,21,.12);
    transform: scale(1.025);
}

.code-answer-slot.filled {
    border-style: solid;
    border-color: #a78bfa;
    background: rgba(139,92,246,.13);
}

.slot-placeholder {
    color: #777;
    font-size: 12px;
    font-weight: 800;
}

.code-piece-panel {
    margin-top: 18px;
    padding: 20px;
    border: 1px solid #333;
    border-radius: 12px;
    background: #252525;
}

.code-piece-bank {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    gap: 9px;
    min-height: 48px;
}

.student-code-piece {
    min-width: 0;
    max-width: 100%;
    cursor: grab;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
}

.student-code-piece:active {
    cursor: grabbing;
}

.code-piece-inner {
    min-height: 48px;
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 11px 13px;
    border: 1px solid #555;
    border-radius: 7px;
    background: #171717;
    transition: .2s ease;
}

.code-piece-inner:hover {
    border-color: #facc15;
    background: #303030;
}

.code-piece-handle {
    color: #777;
    font-size: 11px;
    flex-shrink: 0;
}

.code-piece-inner code {
    color: #60a5fa;
    font-family: monospace;
    font-size: 13px;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.student-code-piece.selected .code-piece-inner {
    border: 2px dashed #facc15;
    background: #39301b;
    box-shadow: 0 0 0 2px rgba(250,204,21,.12);
}

.student-code-piece.dragging {
    opacity: .35;
    transform: scale(.96);
}

.code-answer-slot .student-code-piece {
    width: 100%;
    max-width: 100%;
}

.code-answer-slot .code-piece-inner {
    width: 100%;
    min-height: 48px;
    justify-content: center;
    padding: 8px;
    border-color: #8b5cf6;
    background: #29213b;
}

.code-answer-slot .code-piece-inner code {
    color: #c4b5fd;
    text-align: center;
}

.code-game-tip {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-top: 16px;
    padding: 15px;
    border: 1px solid rgba(139,92,246,.2);
    border-radius: 12px;
    background: rgba(139,92,246,.08);
    color: #a78bfa;
}

.code-game-tip > i {
    margin-top: 2px;
    color: #a78bfa;
}

@media (max-width: 480px) {
    .code-game-instruction {
        padding: 17px;
    }

    .code-game-character {
        height: 85px;
    }

    .code-game-character span {
        font-size: 62px;
    }

    .code-game-board,
    .code-piece-panel {
        padding: 14px;
    }

    .code-answer-slots {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .code-piece-inner {
        padding: 10px;
    }
}

/* Ice Breaking — mission redesign */
.ice-page { --ice-primary: #7c3aed; }
.ice-mission-tracker { background: linear-gradient(125deg,#312e81 0%,#5b21b6 55%,#7c3aed 100%); box-shadow: 0 18px 40px rgba(76,29,149,.18); }
.ice-eyebrow { color:#ddd6fe; font-size:11px; font-weight:900; letter-spacing:.16em; }
.ice-mission-count { color:white; font-size:28px; font-weight:900; white-space:nowrap; }
.ice-progress-track { height:10px; border-radius:99px; overflow:hidden; background:rgba(255,255,255,.2); }
.ice-progress-fill { height:100%; background:linear-gradient(90deg,#fcd34d,#fb923c); border-radius:99px; transition:width .35s ease; }
.ice-dots { display:flex; flex-wrap:wrap; gap:9px; }
.ice-dot { width:36px; height:36px; border-radius:12px; background:rgba(255,255,255,.13); color:#ddd6fe; font-weight:900; font-size:12px; border:1px solid rgba(255,255,255,.2); transition:.2s; }
.ice-dot.is-active { background:#fbbf24; color:#312e81; border-color:#fbbf24; transform:translateY(-2px); }
.ice-dot.is-unlocked:not(.is-active) { background:rgba(255,255,255,.26); color:white; }
.ice-dot:disabled { opacity:.45; cursor:not-allowed; }
.student-activity[hidden], #iceFinishPanel[hidden], #iceNext[hidden] { display:none !important; }
.student-activity.is-current { animation:iceEnter .3s ease both; box-shadow:0 12px 35px rgba(31,41,55,.05); }
@keyframes iceEnter { from {opacity:.3; transform:translateY(10px)} to {opacity:1; transform:translateY(0)} }
.ice-nav-secondary,.ice-nav-primary { padding:13px 20px; border-radius:14px; font-size:13px; font-weight:800; transition:.2s; }
.ice-nav-secondary { background:#f3f4f6; color:#374151; }
.dark .ice-nav-secondary { background:#374151; color:#f9fafb; }
.ice-nav-secondary:disabled { opacity:.4; cursor:not-allowed; }
.ice-nav-primary { color:white; background:linear-gradient(100deg,#7c3aed,#4f46e5); box-shadow:0 8px 20px rgba(109,40,217,.2); }
.ice-nav-primary:hover:not(:disabled) { transform:translateY(-2px); }
.student-code-piece:focus-visible,.code-answer-slot:focus-visible,.ice-dot:focus-visible { outline:3px solid #fbbf24; outline-offset:3px; }
@media (max-width:640px) { .ice-nav-secondary,.ice-nav-primary { width:100%; } }
@media (prefers-reduced-motion:reduce) { .student-activity.is-current {animation:none} .ice-progress-fill {transition:none} }
</style>

<div class="max-w-5xl mx-auto space-y-6 pb-10 ice-page">

    {{-- HEADER --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6">
        <a href="javascript:history.back()"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-purple-600 mb-5">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke tahapan
        </a>

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-purple-600 text-sm font-semibold mb-2">
                    <i class="fa-solid fa-gamepad"></i>
                    ICE BREAKING
                </div>

                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $tahapan->judul_tahapan }}
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ $ruangBelajar->judul ?? 'Ruang Belajar' }}
                </p>
            </div>

            <div class="flex items-center gap-3 bg-purple-50 dark:bg-purple-950/30 rounded-xl px-4 py-3">
                <i class="fa-solid fa-puzzle-piece text-purple-600 text-xl"></i>
                <div>
                    <p class="text-xs text-purple-600">Total aktivitas</p>
                    <p class="font-bold text-gray-800 dark:text-white">
                        {{ count($aktivitasList) }} Aktivitas
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if(count($aktivitasList) > 0)
        <form id="studentIceBreakingForm"
            method="POST"
            action="{{ route('siswa.ruang-belajar.tahapan.selesaikan', [
                    'ruang_belajar_id' => $ruangBelajar->id,
                    'tahapan_id' => $tahapan->id
                ]) }}">

            @csrf

            {{-- MISSION TRACKER --}}
            <div class="ice-mission-tracker rounded-3xl p-5 sm:p-7 mt-6" aria-label="Progres misi ice breaking">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <span class="ice-eyebrow"><i class="fa-solid fa-bolt mr-1"></i> MISSION MODE</span>
                        <h2 class="text-xl sm:text-2xl font-black text-white mt-2">Selesaikan semua tantangan!</h2>
                        <p class="text-sm text-indigo-100/80 mt-1">Satu aktivitas setiap langkah. Fokus, bermain, lalu lanjutkan.</p>
                    </div>
                    <div class="ice-mission-count"><span id="iceCurrentNumber">1</span><span class="text-white/50 mx-1">/</span>{{ $totalAktivitas }}</div>
                </div>
                <div class="ice-progress-track mt-5"><div id="iceProgressBar" class="ice-progress-fill" style="width: {{ $totalAktivitas ? (100 / $totalAktivitas) : 0 }}%"></div></div>
                <div class="flex justify-between text-xs text-indigo-100/70 mt-2"><span id="iceMissionLabel">Misi 1 sedang dimainkan</span><span id="iceProgressText">{{ $totalAktivitas ? round(100 / $totalAktivitas) : 0 }}% perjalanan</span></div>
                <div class="ice-dots mt-5" id="iceMissionDots" aria-label="Daftar misi">
                    @foreach($aktivitasList as $dotIndex => $dotActivity)
                        <button type="button" class="ice-dot {{ $dotIndex === 0 ? 'is-active' : '' }}" data-go-step="{{ $dotIndex }}" aria-label="Misi {{ $dotIndex + 1 }}" title="Misi {{ $dotIndex + 1 }}">{{ $dotIndex + 1 }}</button>
                    @endforeach
                </div>
            </div>

            {{-- PETUNJUK --}}
            <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-100 dark:border-blue-900 rounded-xl p-4 flex gap-3">
                <i class="fa-solid fa-circle-info text-blue-600 mt-1"></i>

                <div>
                    <p class="font-semibold text-blue-800 dark:text-blue-300 text-sm">
                        Petunjuk pengerjaan
                    </p>

                    <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                        Perhatikan setiap instruksi aktivitas. Untuk permainan susun kode,
                        pindahkan potongan kode ke kotak jawaban hingga membentuk urutan program
                        yang benar.
                    </p>
                </div>
            </div>


            {{-- DAFTAR AKTIVITAS --}}
            <div class="space-y-6 mt-6">

                @foreach($aktivitasList as $index => $aktivitas)

                    @php
                        $tipe = $aktivitas['tipe'] ?? '';
                        $konfigurasi = $aktivitas['konfigurasi'] ?? [];
                        $potonganKode = $konfigurasi['potongan_kode'] ?? [];

                        // ID aktivitas
                        $activityId = $aktivitas['id'] ?? 'aktivitas_' . $index;

                        // Pastikan potongan kode berupa array
                        if (!is_array($potonganKode)) {
                            $potonganKode = [];
                        }

                        // YouTube
                        $youtubeId = null;

                        if ($tipe === 'youtube') {
                            $url = $aktivitas['url'] ?? '';

                            if (preg_match(
                                '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/',
                                $url,
                                $matches
                            )) {
                                $youtubeId = $matches[1];
                            }
                        }
                    @endphp


                    <section
                        class="student-activity bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 overflow-hidden {{ $index === 0 ? 'is-current' : '' }}"
                        data-step-index="{{ $index }}"
                        data-activity-id="{{ $activityId }}"
                        data-type="{{ $tipe }}">

                        {{-- JUDUL AKTIVITAS --}}
                        <div class="p-5 border-b border-gray-100 dark:border-gray-800">

                            <div class="flex items-start gap-3">

                                <div class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-950/50 text-purple-600 flex items-center justify-center shrink-0 font-black text-lg">
                                    {{ $index + 1 }}
                                </div>

                                <div class="flex-1 min-w-0">

                                    <span class="text-xs font-semibold text-purple-600 uppercase">
                                        {{ $tipe === 'youtube' ? 'Video Pembelajaran' : ($tipe === 'susun_kode' ? 'Permainan Susun Kode' : 'Aktivitas Ice Breaking') }}
                                    </span>

                                    <h2 class="font-bold text-lg text-gray-800 dark:text-white mt-1">
                                        {{ $aktivitas['judul'] ?? 'Aktivitas Ice Breaking' }}
                                    </h2>

                                    @if(!empty($aktivitas['deskripsi']))
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                            {{ $aktivitas['deskripsi'] }}
                                        </p>
                                    @endif

                                </div>

                            </div>

                        </div>


                        <div class="p-5">

                            {{-- ================================================= --}}
                            {{-- AKTIVITAS YOUTUBE --}}
                            {{-- ================================================= --}}
                            @if($tipe === 'youtube')

                                @if($youtubeId)

                                    <div class="aspect-video w-full overflow-hidden rounded-xl bg-black">

                                        <iframe
                                            src="https://www.youtube-nocookie.com/embed/{{ $youtubeId }}"
                                            title="{{ $aktivitas['judul'] ?? 'Video Ice Breaking' }}"
                                            class="w-full h-full"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            loading="lazy">
                                        </iframe>

                                    </div>

                                @else

                                    <div class="rounded-xl bg-red-50 dark:bg-red-950/30 p-4 text-sm text-red-600">
                                        URL video tidak valid atau tidak dapat ditampilkan.
                                    </div>

                                @endif


                                <label class="flex items-center gap-3 mt-5 p-4 rounded-xl bg-gray-50 dark:bg-gray-800 cursor-pointer">

                                    <input
                                        type="checkbox"
                                        name="selesai[{{ $activityId }}]"
                                        value="1"
                                        class="w-5 h-5 rounded text-purple-600 focus:ring-purple-500"
                                        required
                                    >

                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Saya sudah menonton dan memahami video ini.
                                    </span>

                                </label>


                            {{-- ================================================= --}}
                            {{-- AKTIVITAS SUSUN KODE --}}
                            {{-- ================================================= --}}
                            @elseif($tipe === 'susun_kode')

                                @if(count($potonganKode) >= 2)

                                    <div class="code-sort-game"
                                        data-activity="{{ $activityId }}"
                                        data-total="{{ count($potonganKode) }}">

                                        {{-- KARAKTER DAN INSTRUKSI --}}
                                        <div class="code-game-hero mb-7">

                                            <div class="code-game-character">
                                                <span>🧩</span>
                                            </div>

                                            <div class="code-game-instruction">

                                                <span class="code-game-label">
                                                    <i class="fa-solid fa-wand-magic-sparkles mr-1"></i>
                                                    Tantangan Susun Kode
                                                </span>

                                                <p class="text-white font-mono text-sm sm:text-base leading-relaxed mt-3">
                                                    {{ $konfigurasi['instruksi'] ?? 'Susun potongan kode berikut menjadi urutan program yang benar!' }}
                                                </p>

                                            </div>

                                        </div>


                                        {{-- BAHASA PEMROGRAMAN --}}
                                        <div class="flex justify-center mb-5">

                                            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-300 text-xs font-bold">

                                                <i class="fa-solid fa-code"></i>

                                                {{ strtoupper($konfigurasi['bahasa'] ?? 'CODE') }}

                                            </span>

                                        </div>


                                        {{-- SLOT JAWABAN --}}
                                        <div class="code-game-board">

                                            <div class="flex items-center justify-between gap-3 mb-5">

                                                <div>
                                                    <h3 class="text-sm font-bold text-white">
                                                        Susun kode di sini
                                                    </h3>

                                                    <p class="text-[10px] text-gray-400 mt-1">
                                                        Tempatkan setiap potongan sesuai urutan.
                                                    </p>
                                                </div>

                                                <div class="code-progress-counter">
                                                    <span class="code-filled-count">0</span>
                                                    /
                                                    {{ count($potonganKode) }}
                                                </div>

                                            </div>


                                            <div class="code-answer-slots">

                                                @foreach($potonganKode as $pieceIndex => $piece)

                                                    <div
                                                        class="code-answer-slot"
                                                        role="button" tabindex="0" aria-label="Slot jawaban {{ $pieceIndex + 1 }}"
                                                        data-slot="{{ $pieceIndex }}">

                                                        <span class="slot-placeholder">
                                                            {{ $pieceIndex + 1 }}
                                                        </span>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>


                                        {{-- BANK POTONGAN KODE --}}
                                        <div class="code-piece-panel">

                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-5">

                                                <div>
                                                    <h3 class="text-sm font-bold text-white">
                                                        Potongan Kode
                                                    </h3>

                                                    <p class="text-[10px] text-gray-400 mt-1">
                                                        Pilih atau seret potongan ke kotak jawaban.
                                                    </p>
                                                </div>

                                                <span class="text-[10px] text-gray-400">
                                                    <i class="fa-solid fa-hand-pointer mr-1"></i>
                                                    Drag & Drop
                                                </span>

                                            </div>


                                            <div class="code-piece-bank">

                                                @foreach($potonganKode as $pieceIndex => $piece)

                                                    <div
                                                        class="student-code-piece"
                                                        role="button" tabindex="0" aria-label="Pilih potongan kode {{ $pieceIndex + 1 }}"
                                                        draggable="true"
                                                        data-piece-index="{{ $pieceIndex + 1 }}">

                                                        <div class="code-piece-inner">

                                                            <span class="code-piece-handle">
                                                                <i class="fa-solid fa-grip-vertical"></i>
                                                            </span>

                                                            <code>{{ $piece }}</code>

                                                        </div>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>


                                        {{-- PETUNJUK PERMAINAN --}}
                                        <div class="code-game-tip">

                                            <i class="fa-solid fa-lightbulb"></i>

                                            <div>
                                                <p class="font-bold text-xs">
                                                    Cara Bermain
                                                </p>

                                                <p class="text-xs mt-1 leading-relaxed">
                                                    Seret potongan kode ke kotak jawaban.
                                                    Kamu juga bisa mengeklik potongan kode kemudian
                                                    mengeklik kotak tujuan. Klik kembali potongan
                                                    yang sudah ditempatkan untuk mengembalikannya.
                                                </p>
                                            </div>

                                        </div>


                                        {{-- INPUT JAWABAN --}}
                                        <div class="answer-inputs"></div>

                                    </div>

                                @else

                                    <div class="p-4 rounded-xl bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-300 text-sm">
                                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                                        Potongan kode untuk aktivitas ini belum lengkap.
                                    </div>

                                @endif

                            @endif

                        </div>

                    </section>

                @endforeach

            </div>


            {{-- NAVIGASI MISI --}}
            <div class="ice-nav mt-6 bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <button type="button" id="icePrevious" class="ice-nav-secondary" disabled><i class="fa-solid fa-arrow-left mr-2"></i>Sebelumnya</button>
                <div class="text-center"><p class="text-sm font-bold text-gray-800 dark:text-white" id="iceNavTitle">Misi 1 dari {{ $totalAktivitas }}</p><p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="iceNavHint">Selesaikan misi untuk melanjutkan</p></div>
                <button type="button" id="iceNext" class="ice-nav-primary">Misi Berikutnya<i class="fa-solid fa-arrow-right ml-2"></i></button>
            </div>

            {{-- TOMBOL KIRIM --}}
            <div id="iceFinishPanel" class="mt-6 bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4" hidden>

                <div>
                    <p class="font-semibold text-gray-800 dark:text-white">
                        Sudah menyelesaikan semua aktivitas?
                    </p>

                    <p class="text-xs text-gray-500 mt-1">
                        Pastikan semua aktivitas telah dikerjakan sebelum mengirim jawaban.
                    </p>
                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold text-sm transition">

                    <i class="fa-solid fa-paper-plane"></i>

                    Kirim Pengerjaan

                </button>

            </div>

        </form>
    @else

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-10 text-center">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-purple-50 dark:bg-purple-950/40 flex items-center justify-center text-purple-600 text-2xl mb-4">
                <i class="fa-solid fa-gamepad"></i>
            </div>

            <h2 class="font-bold text-gray-800 dark:text-white">
                Belum Ada Aktivitas
            </h2>

            <p class="text-sm text-gray-500 mt-2">
                Guru belum menambahkan aktivitas Ice Breaking pada tahapan ini.
            </p>
        </div>

    @endif

</div>

<style>
    .student-code-piece {
        transition: background .2s, border-color .2s, transform .2s;
    }

    .student-code-piece.dragging {
        opacity: .4;
        border-color: #8b5cf6;
    }

    .student-code-piece.drag-over {
        border-color: #8b5cf6;
        background: #f5f3ff;
    }

    .dark .student-code-piece.drag-over {
        background: #2e2450;
    }

    .student-code-piece pre {
        margin: 0;
    }

    @media (max-width: 640px) {
        .student-code-piece {
            gap: 8px;
            padding: 10px;
        }

        .student-code-piece pre {
            font-size: 12px;
        }
    }
</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('studentIceBreakingForm');

    if (!form) return;

    // Inisialisasi setiap permainan susun kode
    form.querySelectorAll('.code-sort-game').forEach(game => {

        const bank = game.querySelector('.code-piece-bank');

        const slots = Array.from(
            game.querySelectorAll('.code-answer-slot')
        );

        const counter = game.querySelector('.code-filled-count');

        let selectedPiece = null;
        let draggedPiece = null;

        const pieces = Array.from(
            game.querySelectorAll('.student-code-piece')
        );


        // Memperbarui jumlah slot yang telah terisi
        function updateSlots() {

            let filled = 0;

            slots.forEach(slot => {

                const piece = slot.querySelector('.student-code-piece');

                const placeholder = slot.querySelector('.slot-placeholder');

                if (piece) {

                    filled++;

                    slot.classList.add('filled');

                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }

                } else {

                    slot.classList.remove('filled');

                    if (placeholder) {
                        placeholder.style.display = 'block';
                    }

                }

            });

            if (counter) {
                counter.textContent = filled;
            }

        }


        // Menghapus status pilihan
        function clearSelection() {

            if (selectedPiece) {
                selectedPiece.classList.remove('selected');
            }

            selectedPiece = null;

        }


        // Mengembalikan potongan ke area pilihan
        function returnToBank(piece) {

            if (!piece) return;

            bank.appendChild(piece);

            piece.classList.remove('selected', 'dragging');

            if (selectedPiece === piece) {
                selectedPiece = null;
            }

            updateSlots();

        }


        // Menempatkan potongan kode ke slot
        function placePiece(piece, targetSlot) {

            if (!piece || !targetSlot) return;

            const sourceSlot = piece.parentElement.closest(
                '.code-answer-slot'
            );

            const existingPiece = targetSlot.querySelector(
                '.student-code-piece'
            );

            // Jika slot tujuan sudah terisi, tukar posisi
            if (existingPiece && existingPiece !== piece) {

                if (sourceSlot) {

                    sourceSlot.appendChild(existingPiece);

                } else {

                    bank.appendChild(existingPiece);

                }

            }

            targetSlot.appendChild(piece);

            piece.classList.remove('selected', 'dragging');

            clearSelection();

            draggedPiece = null;

            updateSlots();

        }


        // Klik potongan kode
        pieces.forEach(piece => {

            piece.addEventListener('keydown', function(event) { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); piece.click(); } });

            piece.addEventListener('click', function (event) {

                event.preventDefault();

                // Potongan yang sudah berada di slot
                const currentSlot = piece.parentElement.closest(
                    '.code-answer-slot'
                );

                if (currentSlot) {

                    // Jika ada potongan lain yang dipilih, tukar posisi
                    if (selectedPiece && selectedPiece !== piece) {

                        placePiece(selectedPiece, currentSlot);

                    } else {

                        returnToBank(piece);

                    }

                    return;

                }

                // Pilih potongan dari bank
                if (selectedPiece === piece) {

                    clearSelection();

                    return;

                }

                clearSelection();

                selectedPiece = piece;

                piece.classList.add('selected');

            });

        });


        // Klik slot untuk menempatkan potongan
        slots.forEach(slot => {

            slot.addEventListener('keydown', function(event) { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); slot.click(); } });

            slot.addEventListener('click', function () {

                if (selectedPiece) {

                    placePiece(selectedPiece, slot);

                    return;

                }

                const piece = slot.querySelector(
                    '.student-code-piece'
                );

                if (piece) {
                    returnToBank(piece);
                }

            });


            // Drag masuk ke slot
            slot.addEventListener('dragover', function (event) {

                event.preventDefault();

                slot.classList.add('drag-over');

            });


            slot.addEventListener('dragleave', function () {

                slot.classList.remove('drag-over');

            });


            // Drop potongan kode
            slot.addEventListener('drop', function (event) {

                event.preventDefault();

                slot.classList.remove('drag-over');

                if (draggedPiece) {

                    placePiece(draggedPiece, slot);

                }

            });

        });


        // Drag potongan kode
        pieces.forEach(piece => {

            piece.addEventListener('dragstart', function (event) {

                draggedPiece = piece;

                clearSelection();

                piece.classList.add('dragging');

                event.dataTransfer.effectAllowed = 'move';

                event.dataTransfer.setData(
                    'text/plain',
                    piece.dataset.pieceIndex
                );

            });


            piece.addEventListener('dragend', function () {

                piece.classList.remove('dragging');

                draggedPiece = null;

                slots.forEach(slot => {
                    slot.classList.remove('drag-over');
                });

            });

        });


        // Drop kembali ke bank potongan kode
        bank.addEventListener('dragover', function (event) {

            event.preventDefault();

        });


        bank.addEventListener('drop', function (event) {

            event.preventDefault();

            if (draggedPiece) {

                returnToBank(draggedPiece);

                draggedPiece = null;

            }

        });


        updateSlots();

    });


    // ==========================================
    // NAVIGASI MISI (tanpa mengubah payload backend)
    // ==========================================
    const activityPanels = Array.from(form.querySelectorAll('.student-activity'));
    const previousButton = document.getElementById('icePrevious');
    const nextButton = document.getElementById('iceNext');
    const finishPanel = document.getElementById('iceFinishPanel');
    const progressBar = document.getElementById('iceProgressBar');
    const currentNumber = document.getElementById('iceCurrentNumber');
    const progressText = document.getElementById('iceProgressText');
    const missionLabel = document.getElementById('iceMissionLabel');
    const navTitle = document.getElementById('iceNavTitle');
    const navHint = document.getElementById('iceNavHint');
    const dots = Array.from(document.querySelectorAll('.ice-dot'));
    let currentStep = 0;
    let highestUnlockedStep = 0;

    function isActivityComplete(panel) {
        if (!panel) return false;
        const type = panel.dataset.type;
        if (type === 'youtube') {
            const check = panel.querySelector('input[type="checkbox"]');
            return Boolean(check && check.checked);
        }
        if (type === 'susun_kode') {
            const game = panel.querySelector('.code-sort-game');
            if (!game) return false;
            const slots = Array.from(game.querySelectorAll('.code-answer-slot'));
            return slots.length > 0 && slots.every(slot => slot.querySelector('.student-code-piece'));
        }
        return true;
    }

    function showStep(index) {
        if (index < 0 || index >= activityPanels.length || index > highestUnlockedStep) return;
        currentStep = index;
        activityPanels.forEach((panel, i) => {
            panel.classList.toggle('is-current', i === index);
            panel.hidden = i !== index;
        });
        previousButton.disabled = index === 0;
        const last = index === activityPanels.length - 1;
        nextButton.hidden = last;
        finishPanel.hidden = !last;
        currentNumber.textContent = String(index + 1);
        const pct = Math.round(((index + 1) / activityPanels.length) * 100);
        progressBar.style.width = pct + '%';
        progressText.textContent = pct + '% perjalanan';
        missionLabel.textContent = last ? 'Misi terakhir — siap selesaikan!' : `Misi ${index + 1} sedang dimainkan`;
        navTitle.textContent = `Misi ${index + 1} dari ${activityPanels.length}`;
        navHint.textContent = last ? 'Pastikan seluruh tantangan sudah selesai' : 'Selesaikan misi untuk melanjutkan';
        dots.forEach((dot, i) => {
            dot.classList.toggle('is-active', i === index);
            dot.classList.toggle('is-unlocked', i <= highestUnlockedStep);
            dot.disabled = i > highestUnlockedStep;
        });
    }

    previousButton.addEventListener('click', () => showStep(currentStep - 1));
    nextButton.addEventListener('click', () => {
        if (!isActivityComplete(activityPanels[currentStep])) {
            const type = activityPanels[currentStep].dataset.type;
            alert(type === 'youtube' ? 'Centang konfirmasi setelah menonton video sebelum melanjutkan.' : 'Isi seluruh slot susun kode sebelum melanjutkan.');
            return;
        }
        highestUnlockedStep = Math.max(highestUnlockedStep, currentStep + 1);
        showStep(currentStep + 1);
        document.querySelector('.ice-mission-tracker')?.scrollIntoView({behavior: 'smooth', block: 'start'});
    });
    dots.forEach(dot => dot.addEventListener('click', () => showStep(Number(dot.dataset.goStep))));
    showStep(0);

    // ==========================================
    // VALIDASI DAN PENGIRIMAN JAWABAN
    // ==========================================

    form.addEventListener('submit', function (event) {

        let valid = activityPanels.every(isActivityComplete);
        if (!valid) {
            event.preventDefault();
            const firstIncomplete = activityPanels.findIndex(panel => !isActivityComplete(panel));
            highestUnlockedStep = Math.max(highestUnlockedStep, firstIncomplete);
            showStep(firstIncomplete);
            alert('Masih ada misi yang belum diselesaikan.');
            return;
        }

        const games = Array.from(
            form.querySelectorAll('.code-sort-game')
        );

        games.forEach(game => {

            const activityId = game.dataset.activity;

            const slots = Array.from(
                game.querySelectorAll('.code-answer-slot')
            );

            const answerContainer = game.querySelector(
                '.answer-inputs'
            );

            answerContainer.innerHTML = '';

            const orderedPieces = slots.map(slot => {

                return slot.querySelector('.student-code-piece');

            });


            // Periksa apakah semua slot sudah terisi
            if (orderedPieces.some(piece => !piece)) {

                valid = false;

                game.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });

                alert(
                    'Masih ada potongan kode yang belum ditempatkan. Lengkapi seluruh kotak jawaban terlebih dahulu.'
                );

                return;

            }


            // Buat input hidden sesuai urutan slot
            orderedPieces.forEach(piece => {

                const hidden = document.createElement('input');

                hidden.type = 'hidden';

                hidden.name = `jawaban[${activityId}][]`;

                hidden.value = piece.dataset.pieceIndex;

                answerContainer.appendChild(hidden);

            });

        });


        // Batalkan submit jika ada permainan belum selesai
        if (!valid) {

            event.preventDefault();

        }

    });

});
</script>

@endsection