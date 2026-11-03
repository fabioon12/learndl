
@extends('siswa.layouts.app')

@section('title', 'Kerjakan - ' . $submateri->judul_sub)

@section('content')

@php
    $totalBlocks = count($blocks);
@endphp

<script src="https://cdn.jsdelivr.net/pyodide/v0.25.0/full/pyodide.js"></script>

<div id="learning-game"
     class="fixed inset-0 z-[999] flex flex-col overflow-y-auto bg-[#292929] text-white">

    {{-- HEADER --}}
    <header class="sticky top-0 z-40 border-b border-white/10 bg-[#292929] px-4 py-3 sm:px-8">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4">

            <a href="{{ route('siswa.ruang-materi.dashboard-belajar') }}"
               class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-2xl font-bold hover:bg-white/10">
                ‹
            </a>

            <div class="flex flex-1 justify-center gap-1.5" id="progress-container">
                @for($i = 0; $i < $totalBlocks; $i++)
                    <div class="progress-segment h-2.5 max-w-12 flex-1 rounded-sm bg-[#555]"
                         data-index="{{ $i }}"></div>
                @endfor
            </div>

            <div class="flex shrink-0 items-center gap-2 rounded-lg bg-[#383838] px-3 py-2">
                <span class="text-lg text-red-400">♥</span>
                <span class="font-extrabold" id="heart-count">3</span>
            </div>

            <a href="{{ route('siswa.ruang-materi.dashboard-belajar') }}"
               class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-xl hover:bg-white/10">
                ✕
            </a>

        </div>
    </header>


    {{-- MAIN --}}
    <main class="mx-auto flex w-full max-w-3xl flex-1 flex-col px-4 pb-10 pt-6 sm:px-8">

        {{-- INFORMASI --}}
        <div class="mb-5 text-center">

            <p class="text-[10px] font-bold uppercase tracking-[3px] text-gray-400">
                {{ $materi->judul }}
            </p>

            <h1 class="mt-2 text-xl font-extrabold sm:text-2xl">
                {{ $submateri->judul_sub }}
            </h1>

        </div>


        {{-- KARAKTER --}}
        <div class="mb-5 flex items-end justify-center">
            <div id="character" class="text-7xl sm:text-8xl">
                🫎
            </div>
        </div>


        {{-- TUGAS --}}
        <div id="task-wrapper" class="space-y-6">

            @forelse($blocks as $index => $block)

                @php
                    $tipe = strtolower($block['tipe'] ?? 'teks');
                    $isi = $block['isi'] ?? '';
                    $arahan = $block['arahan'] ?? '';
                    $tips = $block['tips'] ?? '';
                    $clue = $block['clue'] ?? '';

                    $isText = in_array($tipe, ['teks', 'text']);
                    $isVideo = in_array($tipe, ['video', 'youtube']);
                    $isPractice = in_array($tipe, ['praktik', 'code']);
                    $isExercise = in_array($tipe, ['latihan', 'arahan']);

                    $language = strtolower(trim($tips ?: 'html'));

                    if (!in_array($language, ['python', 'html', 'css'])) {
                        $language = 'html';
                    }

                    // YOUTUBE
                    $youtubeId = null;

                    if ($isVideo) {
                        if (preg_match(
                            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/',
                            $isi,
                            $matches
                        )) {
                            $youtubeId = $matches[1];
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | LATIHAN SUSUN KODE
                    |--------------------------------------------------------------------------
                    | isi     = Pertanyaan
                    | arahan  = Kunci jawaban dipisahkan dengan |
                    | clue    = JSON pilihan blok kode
                    */

                    $latihanOptions = [];
                    $correctOrder = [];
                    $shuffledOptions = [];

                    if ($isExercise) {

                        // Baca pilihan blok dari clue.
                        $decodedOptions = json_decode($clue, true);

                        if (is_array($decodedOptions)) {

                            $latihanOptions = collect($decodedOptions)
                                ->map(function ($item, $i) {

                                    $text = is_array($item)
                                        ? ($item['text'] ?? '')
                                        : (string) $item;

                                    return [
                                        'id' => (string) $i,
                                        'text' => trim((string) $text)
                                    ];
                                })
                                ->filter(fn($item) => $item['text'] !== '')
                                ->values()
                                ->all();
                        }

                        // Baca kunci jawaban dari arahan.
                        $correctOrder = array_values(array_filter(
                            array_map('trim', explode('|', $arahan)),
                            fn($item) => $item !== ''
                        ));

                        // Acak pilihan blok.
                        $shuffledOptions = $latihanOptions;
                        shuffle($shuffledOptions);
                    }

                @endphp


                <section
                    class="task-block {{ $index === 0 ? '' : 'hidden' }}"
                    data-index="{{ $index }}"
                    data-type="{{ $tipe }}"
                    @if($isExercise)
                        data-correct-answer="{{ e(json_encode($correctOrder)) }}"
                    @endif
                >

                    {{-- LABEL TANTANGAN --}}
                    <div class="mb-5 flex items-center justify-between">

                        <span class="rounded-full bg-yellow-400/10 px-4 py-2 text-xs font-bold text-yellow-400">
                            TANTANGAN {{ $index + 1 }}
                        </span>

                        @if($isText)
                            <span class="text-xs text-gray-400">📖 Materi</span>
                        @elseif($isVideo)
                            <span class="text-xs text-gray-400">🎬 Video</span>
                        @elseif($isPractice)
                            <span class="text-xs text-gray-400">💻 Praktik Coding</span>
                        @elseif($isExercise)
                            <span class="text-xs text-gray-400">🧩 Susun Kode</span>
                        @endif

                    </div>


                    {{-- ==================================
                         TIPE TEXT
                    ================================== --}}
                    @if($isText)

                        <div class="rounded-2xl border-2 border-[#A69E95] bg-[#333] p-5 shadow-[5px_5px_0_#111] sm:p-7">

                            <h2 class="mb-5 text-lg font-extrabold">
                                📘 Pelajari Materi Berikut
                            </h2>

                            <div class="prose prose-invert max-w-none break-words text-sm leading-8 text-gray-200">
                                {!! $isi !!}
                            </div>

                        </div>


                    {{-- ==================================
                         TIPE YOUTUBE
                    ================================== --}}
                    @elseif($isVideo)

                        <div class="rounded-2xl border-2 border-[#A69E95] bg-[#333] p-5 shadow-[5px_5px_0_#111] sm:p-7">

                            <h2 class="mb-5 text-lg font-extrabold">
                                🎬 Simak Video Pembelajaran
                            </h2>

                            @if($youtubeId)

                                <div class="aspect-video overflow-hidden rounded-xl bg-black">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                        class="h-full w-full"
                                        allowfullscreen
                                        referrerpolicy="strict-origin-when-cross-origin">
                                    </iframe>
                                </div>

                            @elseif($isi)

                                <video controls class="w-full rounded-xl">
                                    <source src="{{ asset('storage/'.$isi) }}">
                                </video>

                            @else

                                <p class="text-sm text-gray-400">
                                    Video belum tersedia.
                                </p>

                            @endif

                        </div>


                    {{-- ==================================
                         TIPE PRAKTIK CODING
                    ================================== --}}
                    @elseif($isPractice)

                        <div class="space-y-5">

                            <div class="rounded-2xl border-2 border-[#A69E95] bg-[#333] p-5 shadow-[5px_5px_0_#111]">

                                <div class="mb-4 flex items-center justify-between">
                                    <h2 class="font-extrabold">
                                        💻 Tantangan Praktik
                                    </h2>

                                    <span class="rounded-lg bg-emerald-500/10 px-3 py-1 text-xs font-bold uppercase text-emerald-400">
                                        {{ $language }}
                                    </span>
                                </div>

                                @if($arahan)
                                    <div class="mb-4 break-words text-sm leading-7 text-gray-300">
                                        {!! $arahan !!}
                                    </div>
                                @endif

                                <p class="mb-3 text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Contoh Kode
                                </p>

                                <pre class="overflow-x-auto whitespace-pre-wrap break-all rounded-xl border border-gray-700 bg-[#1e1e1e] p-4 text-xs leading-6 text-emerald-400"><code>{{ $isi }}</code></pre>

                            </div>


                            {{-- CODE PLAYGROUND --}}
                            <div class="overflow-hidden rounded-2xl border border-gray-700 bg-[#282c34] shadow-xl">

                                <div class="flex items-center justify-between border-b border-gray-700 px-4 py-4">

                                    <div>
                                        <h3 class="font-bold text-white">
                                            Try it Yourself
                                        </h3>

                                        <p class="mt-1 text-[10px] text-gray-400">
                                            Editor kode interaktif
                                        </p>
                                    </div>

                                    <span class="rounded-lg bg-indigo-500/20 px-3 py-1 text-xs font-bold uppercase text-indigo-300">
                                        {{ $language }}
                                    </span>

                                </div>


                                <div class="space-y-3 p-4">

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold uppercase text-gray-400">
                                            Source Code
                                        </span>

                                        <button
                                            type="button"
                                            onclick="runPlayground({{ $index }})"
                                            class="rounded-lg bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-500">
                                            ▶ Run Code
                                        </button>
                                    </div>


                                    <textarea
                                        id="code-editor-{{ $index }}"
                                        data-language="{{ $language }}"
                                        spellcheck="false"
                                        class="h-64 w-full resize-y rounded-xl border border-gray-700 bg-[#1e1e1e] p-4 font-mono text-xs leading-6 text-emerald-400 outline-none focus:border-indigo-500"
                                    >{{ $isi }}</textarea>


                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold uppercase text-gray-400">
                                            Output / Preview
                                        </span>

                                        <span id="run-status-{{ $index }}"
                                              class="text-[10px] text-gray-500">
                                            Belum dijalankan
                                        </span>
                                    </div>


                                    @if($language === 'python')

                                        <pre id="python-output-{{ $index }}"
                                             class="min-h-48 overflow-auto whitespace-pre-wrap rounded-xl border border-gray-700 bg-black p-4 font-mono text-xs leading-6 text-green-400">Klik Run Code untuk menjalankan program Python.</pre>

                                    @else

                                        <iframe
                                            id="preview-{{ $index }}"
                                            sandbox="allow-scripts"
                                            class="h-64 w-full rounded-xl border border-gray-700 bg-white">
                                        </iframe>

                                    @endif

                                </div>

                            </div>


                            @if($clue)
                                <div class="rounded-xl border border-blue-400/20 bg-blue-500/10 p-4 text-sm text-blue-200">
                                    💡 {{ strip_tags($clue) }}
                                </div>
                            @endif

                        </div>


                    {{-- ==================================
                         TIPE LATIHAN SUSUN KODE
                    ================================== --}}
                    @elseif($isExercise)

                        <div class="space-y-5">

                            {{-- PERTANYAAN --}}
                            <div class="rounded-xl border-2 border-[#A69E95] bg-[#333] p-5 shadow-[5px_5px_0_#111] sm:p-7">

                                <div class="mb-4 flex items-center justify-between">

                                    <span class="rounded-full bg-yellow-400/10 px-3 py-1.5 text-xs font-bold text-yellow-400">
                                        🧩 LATIHAN KODE
                                    </span>

                                    <span class="text-xs text-gray-400">
                                        Susun kode dengan benar
                                    </span>

                                </div>

                                <div class="break-words text-base font-semibold leading-8 text-white sm:text-lg">
                                    {!! $isi !!}
                                </div>

                                @if($tips)
                                    <div class="mt-4 rounded-lg bg-blue-500/10 p-3 text-sm text-blue-200">
                                        💡 {{ strip_tags($tips) }}
                                    </div>
                                @endif

                            </div>


                            {{-- KOTAK JAWABAN --}}
                            <div class="rounded-xl border border-gray-700 bg-[#202020] p-5">

                                <div class="mb-4 flex items-center justify-between gap-3">

                                    <div>
                                        <h3 class="font-bold text-white">
                                            Susun Jawabanmu
                                        </h3>

                                        <p class="mt-1 text-xs text-gray-400">
                                            Klik blok kode untuk memasukkannya.
                                        </p>
                                    </div>

                                    <span class="shrink-0 rounded-lg bg-yellow-400/10 px-3 py-1.5 text-xs font-bold text-yellow-400">
                                        <span id="answer-count-{{ $index }}">0</span>/{{ count($correctOrder) }}
                                    </span>

                                </div>


                                <div
                                    id="answer-slots-{{ $index }}"
                                    class="flex min-h-[100px] flex-wrap items-center gap-2 rounded-xl border border-gray-700 bg-[#191919] p-4"
                                >

                                    @for($i = 0; $i < count($correctOrder); $i++)

                                        <div class="flex h-14 min-w-[55px] items-center justify-center rounded-md border-2 border-dashed border-gray-600 px-3 text-xs text-gray-600">
                                            {{ $i + 1 }}
                                        </div>

                                    @endfor

                                </div>

                                <p class="mt-3 text-xs text-gray-500">
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    Klik kembali blok pada kotak jawaban untuk menghapusnya.
                                </p>

                            </div>


                            {{-- PILIHAN BLOK --}}
                            <div class="rounded-xl border border-gray-700 bg-[#202020] p-5">

                                <div class="mb-4">
                                    <h3 class="font-bold text-white">
                                        Pilihan Blok Kode
                                    </h3>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Pilih potongan kode sesuai urutan yang benar.
                                    </p>
                                </div>


                                <div
                                    id="code-options-{{ $index }}"
                                    class="flex flex-wrap items-center gap-2"
                                >

                                    @foreach($shuffledOptions as $option)

                                        <button
                                            type="button"
                                            class="code-choice max-w-full whitespace-pre-wrap break-all rounded-md border border-gray-800 bg-[#111] px-4 py-3 text-left font-mono text-sm font-semibold text-blue-400 transition hover:-translate-y-1 hover:border-yellow-400 hover:bg-[#292929] disabled:cursor-not-allowed disabled:opacity-25 disabled:hover:translate-y-0"
                                            data-option-id="{{ $option['id'] }}"
                                            data-code="{{ $option['text'] }}"
                                            onclick="selectCodeBlock({{ $index }}, this)"
                                        >
                                            {{ $option['text'] }}
                                        </button>

                                    @endforeach

                                </div>


                                @if(count($shuffledOptions) === 0)

                                    <div class="rounded-lg bg-red-500/10 p-4 text-sm text-red-300">
                                        Pilihan blok kode belum tersedia. Periksa kembali pengaturan latihan pada halaman guru.
                                    </div>

                                @endif

                            </div>


                            {{-- CHECK BUTTON --}}
                            <button
                                type="button"
                                onclick="checkCodeOrder({{ $index }})"
                                class="w-full rounded-lg bg-[#555] py-4 text-base font-extrabold tracking-wider text-white shadow-[0_5px_0_#111] transition hover:bg-[#666] active:translate-y-1 active:shadow-none"
                            >
                                CHECK
                            </button>


                            {{-- FEEDBACK --}}
                            <div
                                id="exercise-feedback-{{ $index }}"
                                class="hidden rounded-xl border p-4 text-sm"
                            ></div>

                        </div>


                    {{-- ==================================
                         TIPE LAINNYA
                    ================================== --}}
                    @else

                        <div class="rounded-xl border border-gray-700 bg-[#333] p-6">
                            <div class="prose prose-invert max-w-none break-words">
                                {!! $isi !!}
                            </div>
                        </div>

                    @endif

                </section>

            @empty

                <div class="rounded-2xl border border-gray-700 bg-[#333] p-8 text-center">

                    <div class="mb-3 text-5xl">📚</div>

                    <h3 class="font-bold">
                        Belum Ada Isi Pengerjaan
                    </h3>

                    <p class="mt-2 text-sm text-gray-400">
                        Guru belum menambahkan konten untuk submateri ini.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- FEEDBACK UMUM --}}
        <div id="feedback-box" class="mt-6 hidden rounded-xl border p-4">

            <h3 id="feedback-title" class="font-bold"></h3>

            <p id="feedback-message" class="mt-1 text-sm"></p>

        </div>


        {{-- NAVIGASI --}}
        @if($totalBlocks > 0 && !$isCompleted)

            <div class="mt-auto pt-8">

                <div class="mb-3 flex justify-between text-xs text-gray-400">

                    <span id="step-label">
                        Tahapan 1 dari {{ $totalBlocks }}
                    </span>

                    <span id="step-percentage">
                        0%
                    </span>

                </div>


                <div class="h-2 overflow-hidden rounded-full bg-[#444]">

                    <div id="bottom-progress"
                         class="h-full rounded-full bg-yellow-400 transition-all duration-300"
                         style="width: 0%">
                    </div>

                </div>


                <div class="mt-5 flex gap-3">

                    <button
                        type="button"
                        id="previous-button"
                        onclick="previousTask()"
                        class="hidden w-1/3 rounded-xl border border-gray-600 bg-[#353535] py-4 text-sm font-bold hover:bg-[#444]">
                        KEMBALI
                    </button>


                    <button
                        type="button"
                        id="next-button"
                        onclick="nextTask()"
                        class="w-full rounded-xl bg-[#F5C400] py-4 text-sm font-extrabold tracking-wider text-[#292929] shadow-[0_5px_0_#B58E00] transition hover:bg-yellow-300 active:translate-y-1 active:shadow-none">
                        LANJUT
                    </button>


                    <form
                        id="complete-form"
                        action="{{ route('siswa.ruang-materi.dashboard-belajar.submateri.complete', ['materi' => $materi->id, 'submateri' => $submateri->id]) }}"
                        method="POST"
                        class="hidden w-full"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="w-full rounded-xl bg-emerald-500 py-4 text-sm font-extrabold tracking-wider text-white shadow-[0_5px_0_#16875B] hover:bg-emerald-400">
                            SELESAIKAN PEMBELAJARAN ✓
                        </button>

                    </form>

                </div>

            </div>


        @elseif($isCompleted)

            <div class="mt-auto rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-6 text-center">

                <div class="text-5xl">🏆</div>

                <h3 class="mt-3 text-lg font-extrabold text-emerald-400">
                    Submateri Telah Diselesaikan!
                </h3>

                <p class="mt-2 text-sm text-gray-400">
                    Kamu sudah menyelesaikan tahapan ini.
                </p>

                <a href="{{ route('siswa.ruang-materi.dashboard-belajar') }}"
                   class="mt-5 inline-block rounded-xl bg-emerald-500 px-6 py-3 text-sm font-bold text-white hover:bg-emerald-400">
                    KEMBALI KE DASHBOARD
                </a>

            </div>

        @endif

    </main>

</div>


{{-- ==========================================
     JAVASCRIPT
========================================== --}}
<script>

    let currentTask = 0;

    const taskBlocks = document.querySelectorAll('.task-block');

    const totalTasks = taskBlocks.length;

    const nextButton = document.getElementById('next-button');

    const previousButton = document.getElementById('previous-button');

    const completeForm = document.getElementById('complete-form');

    const progressSegments = document.querySelectorAll('.progress-segment');


    // Status aktivitas.
    const taskStates = {};

    // Jawaban latihan susun kode.
    const codeAnswers = {};


    let pyodideInstance = null;

    let pyodideLoading = false;


    // =====================================
    // PYODIDE ENGINE
    // =====================================

    async function loadPythonEngine() {

        if (pyodideInstance) {
            return pyodideInstance;
        }

        if (pyodideLoading) {

            while (pyodideLoading) {
                await new Promise(resolve => setTimeout(resolve, 200));
            }

            if (pyodideInstance) return pyodideInstance;

            throw new Error('Engine Python gagal dimuat.');
        }

        pyodideLoading = true;

        try {

            if (typeof loadPyodide !== 'function') {
                throw new Error('Library Pyodide tidak berhasil dimuat.');
            }

            pyodideInstance = await loadPyodide();

            return pyodideInstance;

        } finally {

            pyodideLoading = false;

        }
    }


    // =====================================
    // CODE PLAYGROUND
    // =====================================

    async function runPlayground(index) {

        const editor = document.getElementById(`code-editor-${index}`);

        const language = editor.dataset.language;

        const code = editor.value;

        const status = document.getElementById(`run-status-${index}`);

        status.textContent = 'Menjalankan...';

        status.className = 'text-[10px] text-yellow-400';


        try {

            if (language === 'html') {

                const iframe = document.getElementById(`preview-${index}`);

                iframe.srcdoc = code;

                taskStates[index] = {
                    ...taskStates[index],
                    ran: true
                };

            } else if (language === 'css') {

                const iframe = document.getElementById(`preview-${index}`);

                iframe.srcdoc = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                padding: 25px;
                            }
                            ${code}
                        </style>
                    </head>
                    <body>
                        <h1 class="demo-title">Hello World!</h1>
                        <p class="demo-text">Ini adalah area preview CSS.</p>
                        <button class="demo-button">Klik Saya</button>
                    </body>
                    </html>
                `;

                taskStates[index] = {
                    ...taskStates[index],
                    ran: true
                };

            } else if (language === 'python') {

                const output = document.getElementById(`python-output-${index}`);

                output.textContent = 'Memuat Python Engine...';

                const pyodide = await loadPythonEngine();

                output.textContent = 'Menjalankan program...\n';

                pyodide.globals.set('student_code', code);

                const result = await pyodide.runPythonAsync(`
import sys
import io
import traceback

_stdout = io.StringIO()
_stderr = io.StringIO()

_old_stdout = sys.stdout
_old_stderr = sys.stderr

sys.stdout = _stdout
sys.stderr = _stderr

try:
    exec(student_code, {})
except Exception:
    traceback.print_exc(file=_stderr)
finally:
    sys.stdout = _old_stdout
    sys.stderr = _old_stderr

_result = _stdout.getvalue()

if _stderr.getvalue():
    _result += _stderr.getvalue()

_result if _result else "(Program selesai tanpa output)"
                `);

                output.textContent = result;

                taskStates[index] = {
                    ...taskStates[index],
                    ran: true
                };

            }

            status.textContent = '✓ Program berhasil dijalankan';

            status.className = 'text-[10px] text-emerald-400';

        } catch (error) {

            status.textContent = 'Terjadi kesalahan';

            status.className = 'text-[10px] text-red-400';

            if (language === 'python') {

                document.getElementById(`python-output-${index}`).textContent =
                    error.message;

            } else {

                alert(error.message);

            }

        }
    }


    // =====================================
    // BLOCK CODE EXERCISE
    // =====================================

    /**
     * Normalisasi kode.
     * Spasi berlebih tidak memengaruhi pemeriksaan.
     * Huruf besar/kecil dan simbol tetap diperhitungkan.
     */
    function normalizeCode(value) {

        return String(value ?? '')
            .trim()
            .replace(/\s+/g, ' ');

    }


    /**
     * Memilih blok kode.
     */
    function selectCodeBlock(taskIndex, button) {

        const optionId = button.dataset.optionId;

        const code = button.dataset.code;

        const container = document.getElementById(
            `answer-slots-${taskIndex}`
        );

        const totalSlots = container.children.length;


        if (!codeAnswers[taskIndex]) {
            codeAnswers[taskIndex] = [];
        }


        const answers = codeAnswers[taskIndex];


        // Hindari memilih blok yang sama dua kali.
        const alreadySelected = answers.some(
            item => item.id === optionId
        );

        if (alreadySelected) return;


        // Batasi jumlah pilihan.
        if (answers.length >= totalSlots) return;


        answers.push({
            id: optionId,
            code: code
        });


        taskStates[taskIndex] = {
            ...taskStates[taskIndex],
            checked: false
        };


        renderCodeAnswer(taskIndex);

        hideExerciseFeedback(taskIndex);

    }


    /**
     * Menggambar kotak jawaban.
     */
    function renderCodeAnswer(taskIndex) {

        const container = document.getElementById(
            `answer-slots-${taskIndex}`
        );

        const optionsContainer = document.getElementById(
            `code-options-${taskIndex}`
        );

        const answers = codeAnswers[taskIndex] || [];

        const totalSlots = container.children.length;


        container.innerHTML = '';


        for (let i = 0; i < totalSlots; i++) {

            const answer = answers[i];


            if (answer) {

                const button = document.createElement('button');

                button.type = 'button';

                button.className =
                    'flex min-h-[50px] max-w-full items-center justify-center ' +
                    'rounded-md border-2 border-yellow-400 bg-[#292929] ' +
                    'px-4 py-2 text-center font-mono text-sm font-semibold ' +
                    'text-blue-400 transition hover:border-red-400 ' +
                    'hover:bg-red-500/10 whitespace-pre-wrap break-all';


                // Gunakan textContent agar teks kode aman.
                button.textContent = answer.code;

                button.title = 'Klik untuk menghapus blok ini';


                button.addEventListener('click', function () {

                    removeCodeBlock(taskIndex, i);

                });


                container.appendChild(button);

            } else {

                const placeholder = document.createElement('div');

                placeholder.className =
                    'flex h-14 min-w-[55px] items-center justify-center ' +
                    'rounded-md border-2 border-dashed border-gray-600 ' +
                    'px-3 text-xs text-gray-600';

                placeholder.textContent = i + 1;

                container.appendChild(placeholder);

            }

        }


        // Update jumlah jawaban.
        const answerCount = document.getElementById(
            `answer-count-${taskIndex}`
        );

        answerCount.textContent = answers.length;


        // Aktif/nonaktifkan blok pilihan.
        optionsContainer.querySelectorAll('.code-choice').forEach(button => {

            const selected = answers.some(
                item => item.id === button.dataset.optionId
            );

            button.disabled = selected;

        });

    }


    /**
     * Menghapus blok jawaban.
     */
    function removeCodeBlock(taskIndex, position) {

        if (!codeAnswers[taskIndex]) return;


        codeAnswers[taskIndex].splice(position, 1);


        taskStates[taskIndex] = {
            ...taskStates[taskIndex],
            checked: false
        };


        renderCodeAnswer(taskIndex);

        hideExerciseFeedback(taskIndex);

    }


    /**
     * Memeriksa susunan jawaban.
     */
    function checkCodeOrder(taskIndex) {

        const currentBlock = taskBlocks[taskIndex];

        const answers = codeAnswers[taskIndex] || [];

        const container = document.getElementById(
            `answer-slots-${taskIndex}`
        );

        const totalSlots = container.children.length;


        // Baca kunci jawaban dari data server.
        let correctAnswer = [];

        try {

            correctAnswer = JSON.parse(
                currentBlock.dataset.correctAnswer || '[]'
            );

        } catch (error) {

            showExerciseFeedback(
                taskIndex,
                'Kunci jawaban tidak valid.',
                'Terjadi kesalahan saat membaca kunci jawaban latihan.',
                false
            );

            return;

        }


        // Validasi kunci.
        if (!Array.isArray(correctAnswer) || correctAnswer.length === 0) {

            showExerciseFeedback(
                taskIndex,
                'Kunci jawaban belum tersedia.',
                'Guru perlu mengisi urutan jawaban benar pada pengaturan latihan.',
                false
            );

            return;

        }


        // Pastikan jumlah pilihan lengkap.
        if (answers.length !== totalSlots) {

            showExerciseFeedback(
                taskIndex,
                'Jawaban belum lengkap!',
                `Kamu baru mengisi ${answers.length} dari ${totalSlots} kotak jawaban.`,
                false
            );

            return;

        }


        // Pastikan jumlah kunci sesuai.
        if (correctAnswer.length !== totalSlots) {

            showExerciseFeedback(
                taskIndex,
                'Konfigurasi latihan tidak sesuai.',
                'Jumlah kunci jawaban tidak sama dengan jumlah kotak jawaban.',
                false
            );

            return;

        }


        // Bandingkan satu per satu.
        const isCorrect = answers.every((answer, index) => {

            return normalizeCode(answer.code) ===
                normalizeCode(correctAnswer[index]);

        });


        if (isCorrect) {

            taskStates[taskIndex] = {
                ...taskStates[taskIndex],
                checked: true
            };


            // Tandai semua blok sebagai benar.
            container.querySelectorAll('button').forEach(button => {

                button.classList.remove(
                    'border-yellow-400',
                    'text-blue-400'
                );

                button.classList.add(
                    'border-emerald-400',
                    'bg-emerald-500/10',
                    'text-emerald-300'
                );

                button.disabled = true;

            });


            showExerciseFeedback(
                taskIndex,
                '🎉 Jawaban benar!',
                'Hebat! Kamu berhasil menyusun kode dengan urutan yang tepat. Silakan lanjut ke tantangan berikutnya.',
                true
            );


        } else {

            taskStates[taskIndex] = {
                ...taskStates[taskIndex],
                checked: false
            };


            showExerciseFeedback(
                taskIndex,
                'Belum tepat!',
                'Urutan kode yang kamu susun masih belum sesuai. Periksa kembali setiap potongan kode, lalu coba lagi.',
                false
            );

        }

    }


    /**
     * Feedback latihan.
     */
    function showExerciseFeedback(taskIndex, title, message, success) {

        const feedback = document.getElementById(
            `exercise-feedback-${taskIndex}`
        );


        feedback.className =
            'rounded-xl border p-4 text-sm ' +
            (
                success
                    ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300'
                    : 'border-red-500/30 bg-red-500/10 text-red-300'
            );


        const titleElement = document.createElement('div');

        titleElement.className = 'font-extrabold';

        titleElement.textContent = title;


        const messageElement = document.createElement('p');

        messageElement.className = 'mt-1';

        messageElement.textContent = message;


        feedback.replaceChildren(titleElement, messageElement);

    }


    /**
     * Sembunyikan feedback ketika jawaban diubah.
     */
    function hideExerciseFeedback(taskIndex) {

        const feedback = document.getElementById(
            `exercise-feedback-${taskIndex}`
        );

        if (feedback) {

            feedback.classList.add('hidden');

            feedback.innerHTML = '';

        }

    }


    // =====================================
    // FEEDBACK UMUM
    // =====================================

    function showFeedback(title, message, success) {

        const box = document.getElementById('feedback-box');


        box.classList.remove(
            'hidden',
            'border-emerald-500/30',
            'bg-emerald-500/10',
            'border-red-500/30',
            'bg-red-500/10'
        );


        box.classList.add(
            success
                ? 'border-emerald-500/30'
                : 'border-red-500/30',

            success
                ? 'bg-emerald-500/10'
                : 'bg-red-500/10'
        );


        const titleElement = document.getElementById('feedback-title');

        titleElement.textContent = title;

        titleElement.className = success
            ? 'font-bold text-emerald-400'
            : 'font-bold text-red-400';


        document.getElementById('feedback-message').textContent = message;

    }


    // =====================================
    // NAVIGASI TUGAS
    // =====================================

    function updateTask() {

        taskBlocks.forEach((block, index) => {

            block.classList.toggle('hidden', index !== currentTask);

        });


        progressSegments.forEach((segment, index) => {

            segment.classList.toggle(
                'bg-yellow-400',
                index < currentTask
            );

            segment.classList.toggle(
                'bg-[#555]',
                index >= currentTask
            );

        });


        const percentage = Math.round(
            (currentTask / totalTasks) * 100
        );


        document.getElementById('step-label').textContent =
            `Tahapan ${currentTask + 1} dari ${totalTasks}`;


        document.getElementById('step-percentage').textContent =
            percentage + '%';


        document.getElementById('bottom-progress').style.width =
            percentage + '%';


        previousButton.classList.toggle(
            'hidden',
            currentTask === 0
        );


        const type = taskBlocks[currentTask].dataset.type;


        if (currentTask === totalTasks - 1) {

            nextButton.textContent = 'SELESAI MENGERJAKAN ✓';

        } else {

            nextButton.textContent = 'LANJUT KE TAHAPAN BERIKUTNYA →';

        }


        document.getElementById('feedback-box').classList.add('hidden');


        document.getElementById('learning-game').scrollTo({
            top: 0,
            behavior: 'smooth'
        });

    }


    function nextTask() {

        const currentBlock = taskBlocks[currentTask];

        const type = currentBlock.dataset.type;


        // Praktik harus dijalankan minimal satu kali.
        if (['praktik', 'code'].includes(type)) {

            if (!taskStates[currentTask]?.ran) {

                showFeedback(
                    'Jalankan program terlebih dahulu!',
                    'Klik tombol Run Code untuk mencoba program yang telah kamu tulis.',
                    false
                );

                return;

            }

        }


        // Latihan harus dijawab dengan benar.
        if (['latihan', 'arahan'].includes(type)) {

            if (!taskStates[currentTask]?.checked) {

                showFeedback(
                    'Susunan kode belum benar!',
                    'Periksa dan susun kembali blok kode hingga urutannya benar.',
                    false
                );

                return;

            }

        }


        if (currentTask < totalTasks - 1) {

            currentTask++;

            updateTask();


            showFeedback(
                'Bagus! 🎉',
                'Kamu berhasil melewati tahapan ini. Lanjutkan perjalanan belajarmu!',
                true
            );

        } else {

            // Semua tahapan telah dilalui.
            nextButton.classList.add('hidden');

            previousButton.classList.add('hidden');

            completeForm.classList.remove('hidden');


            document.getElementById('step-percentage').textContent = '100%';

            document.getElementById('bottom-progress').style.width = '100%';


            progressSegments.forEach(segment => {

                segment.classList.add('bg-yellow-400');

            });


            showFeedback(
                'Semua tantangan selesai! 🏆',
                'Sekarang kamu dapat menyelesaikan pembelajaran dan mendapatkan XP.',
                true
            );

        }

    }


    function previousTask() {

        if (currentTask > 0) {

            currentTask--;

            updateTask();

        }

    }


    // =====================================
    // INITIALIZATION
    // =====================================

    if (totalTasks > 0) {

        updateTask();

    }

</script>

@endsection
