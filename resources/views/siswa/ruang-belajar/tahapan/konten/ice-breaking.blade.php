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
</style>

<div class="max-w-5xl mx-auto space-y-6 pb-10">

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
                        class="student-activity bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 overflow-hidden"
                        data-activity-id="{{ $activityId }}"
                        data-type="{{ $tipe }}">

                        {{-- JUDUL AKTIVITAS --}}
                        <div class="p-5 border-b border-gray-100 dark:border-gray-800">

                            <div class="flex items-start gap-3">

                                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-950/50 text-purple-600 flex items-center justify-center shrink-0 font-bold">
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
                                                <span>🫎</span>
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


            {{-- TOMBOL KIRIM --}}
            <div class="mt-6 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

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
    // VALIDASI DAN PENGIRIMAN JAWABAN
    // ==========================================

    form.addEventListener('submit', function (event) {

        let valid = true;

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