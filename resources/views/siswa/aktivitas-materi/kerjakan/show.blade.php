
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
                    $isExercise = in_array($tipe, ['latihan', 'block_code']);

                    $language = strtolower(trim($tips ?: 'html'));

                    if (!in_array($language, ['python', 'html', 'css'])) {
                        $language = 'html';
                    }

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

                    // Data latihan: isi dapat berupa JSON array atau kode multiline.
                    $latihanItems = json_decode($isi, true);

                    if (!is_array($latihanItems) || empty($latihanItems)) {
                        $latihanItems = preg_split(
                            '/\R/',
                            trim(strip_tags($isi))
                        );
                    }

                    $latihanItems = collect($latihanItems)
                        ->map(function ($item) {
                            if (is_array($item)) {
                                return $item['code'] ?? $item['text'] ?? $item['isi'] ?? '';
                            }

                            return (string) $item;
                        })
                        ->filter(fn($item) => trim($item) !== '')
                        ->values()
                        ->map(function ($item, $i) {
                            return [
                                'code' => $item,
                                'order' => $i
                            ];
                        })
                        ->all();

                    $shuffledLatihan = $latihanItems;
                    shuffle($shuffledLatihan);
                @endphp

                <section
                    class="task-block {{ $index === 0 ? '' : 'hidden' }}"
                    data-index="{{ $index }}"
                    data-type="{{ $tipe }}"
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

                            <div class="prose prose-invert max-w-none text-sm leading-8 text-gray-200">
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
                                    <div class="mb-4 text-sm leading-7 text-gray-300">
                                        {!! $arahan !!}
                                    </div>
                                @endif

                                <p class="mb-3 text-xs font-bold uppercase tracking-wider text-gray-500">
                                    Contoh Kode
                                </p>

                                <pre class="overflow-x-auto rounded-xl border border-gray-700 bg-[#1e1e1e] p-4 text-xs leading-6 text-emerald-400"><code>{{ $isi }}</code></pre>

                                @if($clue)
                                    <div class="mt-4 rounded-lg bg-yellow-400/10 p-3 text-sm text-yellow-300">
                                        🔍 {{ strip_tags($clue) }}
                                    </div>
                                @endif

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
                                        data-code="{{ base64_encode($isi) }}"
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

                            @if($tips)
                                <div class="rounded-xl border border-blue-400/20 bg-blue-500/10 p-4 text-sm text-blue-200">
                                    💡 {{ strip_tags($tips) }}
                                </div>
                            @endif

                        </div>


                    {{-- ==================================
                         TIPE LATIHAN BLOCK CODE
                    ================================== --}}
                    @elseif($isExercise)

                        <div class="space-y-5">

                            <div class="rounded-2xl border-2 border-[#A69E95] bg-[#333] p-5 shadow-[5px_5px_0_#111]">

                                <h2 class="mb-4 text-lg font-extrabold">
                                    🧩 Susun Blok Kode
                                </h2>

                                @if($arahan)
                                    <div class="text-sm leading-7 text-gray-300">
                                        {!! $arahan !!}
                                    </div>
                                @else
                                    <p class="text-sm text-gray-300">
                                        Susun potongan kode berikut menjadi program dengan urutan yang benar.
                                    </p>
                                @endif

                                @if($clue)
                                    <div class="mt-4 rounded-lg bg-yellow-400/10 p-3 text-sm text-yellow-300">
                                        🔍 Petunjuk: {{ strip_tags($clue) }}
                                    </div>
                                @endif

                            </div>

                            @if(count($shuffledLatihan) > 0)

                                <div class="rounded-2xl border border-gray-700 bg-[#202020] p-5">

                                    <div class="mb-4 flex items-center justify-between">
                                        <div>
                                            <h3 class="font-bold">
                                                Susun Urutan Program
                                            </h3>
                                            <p class="mt-1 text-xs text-gray-500">
                                                Gunakan tombol panah untuk memindahkan blok kode.
                                            </p>
                                        </div>

                                        <span class="rounded-lg bg-purple-500/20 px-3 py-1 text-xs font-bold text-purple-300">
                                            {{ count($shuffledLatihan) }} BLOK
                                        </span>
                                    </div>

                                    <div
                                        id="code-blocks-{{ $index }}"
                                        class="space-y-3"
                                        data-task="{{ $index }}"
                                    >

                                        @foreach($shuffledLatihan as $blockIndex => $codeBlock)

                                            <div
                                                class="code-order-item flex items-center gap-3 rounded-xl border border-gray-700 bg-[#303030] p-3"
                                                data-order="{{ $codeBlock['order'] }}"
                                            >

                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-purple-500/20 text-xs font-bold text-purple-300">
                                                    {{ $blockIndex + 1 }}
                                                </span>

                                                <pre class="min-w-0 flex-1 overflow-x-auto whitespace-pre-wrap break-words font-mono text-xs leading-6 text-emerald-300">{{ $codeBlock['code'] }}</pre>

                                                <div class="flex shrink-0 flex-col gap-1">
                                                    <button
                                                        type="button"
                                                        onclick="moveCodeBlock(this, -1)"
                                                        class="rounded-md bg-[#444] px-2 py-1 text-xs hover:bg-purple-600">
                                                        ▲
                                                    </button>

                                                    <button
                                                        type="button"
                                                        onclick="moveCodeBlock(this, 1)"
                                                        class="rounded-md bg-[#444] px-2 py-1 text-xs hover:bg-purple-600">
                                                        ▼
                                                    </button>
                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                    <button
                                        type="button"
                                        onclick="checkCodeOrder({{ $index }})"
                                        class="mt-5 w-full rounded-xl bg-purple-600 py-3 text-sm font-extrabold text-white transition hover:bg-purple-500">
                                        PERIKSA SUSUNAN KODE
                                    </button>

                                    <div
                                        id="exercise-feedback-{{ $index }}"
                                        class="mt-4 hidden rounded-xl p-4 text-sm">
                                    </div>

                                </div>

                            @else

                                <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-5 text-sm text-red-300">
                                    Belum ada blok kode yang dapat disusun. Pastikan guru mengisi konten latihan dalam format array JSON atau kode multiline.
                                </div>

                            @endif

                        </div>


                    @else

                        <div class="rounded-xl border border-gray-700 bg-[#333] p-6">
                            <div class="prose prose-invert max-w-none">
                                {!! $isi !!}
                            </div>
                        </div>

                    @endif

                </section>

            @empty

                <div class="rounded-2xl border border-gray-700 bg-[#333] p-8 text-center">
                    <div class="mb-3 text-5xl">📚</div>
                    <h3 class="font-bold">Belum Ada Isi Pengerjaan</h3>
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

                    <span id="step-percentage">0%</span>
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


{{-- JAVASCRIPT --}}
<script>
    let currentTask = 0;

    const taskBlocks = document.querySelectorAll('.task-block');
    const totalTasks = taskBlocks.length;

    const nextButton = document.getElementById('next-button');
    const previousButton = document.getElementById('previous-button');
    const completeForm = document.getElementById('complete-form');

    const progressSegments = document.querySelectorAll('.progress-segment');

    // Menyimpan status setiap aktivitas.
    const taskStates = {};

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

    function moveCodeBlock(button, direction) {

        const item = button.closest('.code-order-item');
        const container = item.parentElement;

        if (direction === -1 && item.previousElementSibling) {
            container.insertBefore(item, item.previousElementSibling);
        }

        if (direction === 1 && item.nextElementSibling) {
            container.insertBefore(item.nextElementSibling, item);
        }

        updateBlockNumbers(container);

        const taskIndex = parseInt(container.dataset.task);

        taskStates[taskIndex] = {
            ...taskStates[taskIndex],
            checked: false
        };

        const feedback = document.getElementById(`exercise-feedback-${taskIndex}`);

        if (feedback) feedback.classList.add('hidden');
    }


    function updateBlockNumbers(container) {

        container.querySelectorAll('.code-order-item').forEach((item, index) => {

            const number = item.querySelector('span');

            number.textContent = index + 1;
        });
    }


    function checkCodeOrder(index) {

        const container = document.getElementById(`code-blocks-${index}`);

        const feedback = document.getElementById(`exercise-feedback-${index}`);

        const items = [...container.querySelectorAll('.code-order-item')];

        const isCorrect = items.every((item, position) => {
            return parseInt(item.dataset.order) === position;
        });

        feedback.classList.remove(
            'hidden',
            'bg-emerald-500/10',
            'text-emerald-300',
            'border-emerald-500/30',
            'bg-red-500/10',
            'text-red-300',
            'border-red-500/30'
        );

        feedback.classList.add('border');

        if (isCorrect) {

            feedback.classList.add(
                'bg-emerald-500/10',
                'text-emerald-300',
                'border-emerald-500/30'
            );

            feedback.innerHTML = `
                <div class="font-bold">🎉 Hebat! Susunan kode benar!</div>
                <p class="mt-1">Kamu berhasil menyusun program dengan urutan yang tepat.</p>
            `;

            taskStates[index] = {
                ...taskStates[index],
                checked: true
            };

        } else {

            feedback.classList.add(
                'bg-red-500/10',
                'text-red-300',
                'border-red-500/30'
            );

            feedback.innerHTML = `
                <div class="font-bold">Belum tepat!</div>
                <p class="mt-1">Periksa kembali urutan blok kode programmu.</p>
            `;

            taskStates[index] = {
                ...taskStates[index],
                checked: false
            };
        }
    }


    // =====================================
    // FEEDBACK
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
            success ? 'border-emerald-500/30' : 'border-red-500/30',
            success ? 'bg-emerald-500/10' : 'bg-red-500/10'
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

        previousButton.classList.toggle('hidden', currentTask === 0);

        const type = taskBlocks[currentTask].dataset.type;

        if (currentTask === totalTasks - 1) {

            nextButton.textContent = 'SELESAI MENGERJAKAN ✓';

        } else if (['praktik', 'code'].includes(type)) {

            nextButton.textContent = 'LANJUT KE TAHAPAN BERIKUTNYA →';

        } else if (['latihan', 'block_code'].includes(type)) {

            nextButton.textContent = 'LANJUT KE TAHAPAN BERIKUTNYA →';

        } else {

            nextButton.textContent = 'LANJUT →';
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

        // Latihan harus memiliki susunan benar.
        if (['latihan', 'block_code'].includes(type)) {

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

            // Semua tahapan sudah dilalui.
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
