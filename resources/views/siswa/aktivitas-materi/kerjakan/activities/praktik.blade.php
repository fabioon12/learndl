
@php
    /*
    |--------------------------------------------------------------------------
    | DATA PRAKTIK
    |--------------------------------------------------------------------------
    | isi    : Starter code
    | arahan : Judul/instruksi singkat
    | tips   : Bahasa pemrograman
    | clue   : JSON konfigurasi praktik
    */

    $isi = (string) ($block['isi'] ?? '');
    $arahan = (string) ($block['arahan'] ?? '');
    $tips = (string) ($block['tips'] ?? '');
    $clue = $block['clue'] ?? '';

    $language = strtolower(trim($tips ?: 'html'));

    if (!in_array($language, ['html', 'css', 'python'])) {
        $language = 'html';
    }

    $config = is_array($clue)
        ? $clue
        : json_decode((string) $clue, true);

    $config = is_array($config) ? $config : [];

    $mode = strtolower((string) ($config['mode'] ?? 'playground'));

    if (!in_array($mode, ['playground', 'debugging'])) {
        $mode = 'playground';
    }

    $instruction = (string) ($config['instruction'] ?? '');

    // Hilangkan TAB dan spasi di awal setiap baris
    $instruction = preg_replace('/^[\t ]+/m', '', $instruction);

    /*
     * Solusi guru tidak dikirim ke halaman siswa.
     * Jangan memasukkan config['solution'] ke HTML/JS.
     */
@endphp

<div class="space-y-5">

    {{-- INFORMASI TANTANGAN --}}
    <div class="rounded-2xl border-2 border-[#A69E95]
                bg-[#333] p-5 shadow-[5px_5px_0_#111] sm:p-6">

        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">

            <div class="flex items-center gap-2">
                <span class="text-2xl">💻</span>

                <div>
                    <h2 class="font-extrabold text-white">
                        {{ $mode === 'debugging'
                            ? 'Misi Perbaiki Kode'
                            : 'Praktik Coding' }}
                    </h2>

                    <p class="mt-1 text-xs text-gray-400">
                        {{ $mode === 'debugging'
                            ? 'Temukan dan perbaiki kesalahan kode.'
                            : 'Eksplorasi dan jalankan kode.' }}
                    </p>
                </div>
            </div>

            <span class="rounded-lg bg-indigo-500/15
                         px-3 py-1.5 text-xs font-bold
                         uppercase text-indigo-300">
                {{ $language }}
            </span>

        </div>

        @if(trim($arahan) !== '')
            <h3 class="mb-3 text-base font-bold text-white">
                {{ $arahan }}
            </h3>
        @endif

        @if(trim($instruction) !== '')
            <div class="rounded-xl border border-white/10
                        bg-[#262626] p-4 text-sm
                        leading-7 text-gray-200
                        whitespace-pre-wrap break-words">{{ $instruction }}</div>
        @endif

        @if($mode === 'debugging')
            <div class="mt-4 rounded-xl border border-amber-400/20
                        bg-amber-400/10 p-4 text-xs
                        leading-6 text-amber-200">
                🐛 Kode berikut memiliki kesalahan.
                Perbaiki kode pada editor, lalu jalankan
                untuk melihat hasilnya.
            </div>
        @endif

    </div>

    {{-- EDITOR KODE --}}
    <div class="overflow-hidden rounded-2xl border
                border-gray-700 bg-[#202329] shadow-xl">

        {{-- HEADER EDITOR --}}
        <div class="flex flex-wrap items-center justify-between
                    gap-3 border-b border-gray-700 px-4 py-3">

            <div class="flex items-center gap-3">

                <div class="flex gap-1.5">
                    <span class="h-3 w-3 rounded-full bg-red-400"></span>
                    <span class="h-3 w-3 rounded-full bg-yellow-400"></span>
                    <span class="h-3 w-3 rounded-full bg-green-400"></span>
                </div>

                <span class="font-mono text-xs text-gray-300">
                    {{ $language === 'python'
                        ? 'main.py'
                        : ($language === 'css'
                            ? 'style.css'
                            : 'index.html') }}
                </span>

            </div>

            <span class="text-[10px] font-bold uppercase
                         tracking-wider text-gray-500">
                CODE EDITOR
            </span>

        </div>

        {{-- TEXTAREA --}}
        <div class="p-4">

            <textarea
                id="code-editor-{{ $index }}"
                data-language="{{ $language }}"
                data-mode="{{ $mode }}"
                spellcheck="false"
                autocapitalize="off"
                autocomplete="off"
                autocorrect="off"
                class="h-64 w-full resize-y rounded-xl
                       border border-gray-700 bg-[#14161b]
                       p-4 font-mono text-sm leading-7
                       text-emerald-300 outline-none
                       transition focus:border-indigo-500"
            >{{ $isi }}</textarea>

            {{-- TOMBOL AKSI --}}
            <div class="mt-4 flex flex-wrap items-center
                        justify-between gap-3">

                <button
                    type="button"
                    onclick="resetPlayground({{ $index }})"
                    class="rounded-xl border border-gray-600
                           bg-[#30343b] px-5 py-3
                           text-xs font-bold text-gray-200
                           hover:bg-[#414650]"
                >
                    ↺ RESET
                </button>

                <button
                    type="button"
                    id="run-button-{{ $index }}"
                    onclick="runPlayground({{ $index }})"
                    class="rounded-xl bg-indigo-600
                           px-6 py-3 text-xs font-extrabold
                           text-white transition
                           hover:bg-indigo-500"
                >
                    ▶ RUN CODE
                </button>

            </div>

        </div>

    </div>

    {{-- OUTPUT --}}
    <div class="overflow-hidden rounded-2xl
                border border-gray-700 bg-[#202020]">

        <div class="flex items-center justify-between
                    gap-3 border-b border-gray-700
                    px-4 py-3">

            <div class="flex items-center gap-2">
                <span class="text-lg">🖥️</span>
                <h3 class="text-sm font-bold text-white">
                    Output Program
                </h3>
            </div>

            <span
                id="run-status-{{ $index }}"
                class="text-[11px] text-gray-400"
            >
                Belum dijalankan
            </span>

        </div>

        <div class="p-4">

            @if($language === 'python')

                <pre
                    id="python-output-{{ $index }}"
                    class="min-h-48 overflow-auto
                           whitespace-pre-wrap break-words
                           rounded-xl border border-gray-700
                           bg-[#101010] p-4 font-mono
                           text-xs leading-6 text-green-400"
                >Klik Run Code untuk menjalankan program Python.</pre>

            @else

                <iframe
                    id="preview-{{ $index }}"
                    title="Preview kode siswa"
                    sandbox="allow-scripts"
                    referrerpolicy="no-referrer"
                    class="h-72 w-full rounded-xl
                           border border-gray-700 bg-white"
                ></iframe>

            @endif

        </div>

    </div>

    {{-- FEEDBACK --}}
    <div
        id="practice-feedback-{{ $index }}"
        class="hidden rounded-xl border p-4 text-sm"
        role="status"
        aria-live="polite"
    ></div>

    {{-- PETUNJUK --}}
    <div class="flex items-start gap-3 rounded-xl
                border border-white/10 bg-white/[0.03]
                px-4 py-3">

        <span class="text-lg">💡</span>

        <p class="text-xs leading-6 text-gray-400">
            {{ $mode === 'debugging'
                ? 'Perbaiki kode dan jalankan program untuk memeriksa hasilnya.'
                : 'Ubah kode sesuai keinginanmu, kemudian tekan Run Code untuk melihat hasilnya.' }}
        </p>

    </div>

</div>
