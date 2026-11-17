
@php
    /*
    |--------------------------------------------------------------------------
    | DATA PILIHAN GANDA
    |--------------------------------------------------------------------------
    | isi    : Pertanyaan
    | arahan : Index jawaban benar (0, 1, 2, 3, ...)
    | clue   : JSON pilihan dan pembahasan
    */

    $question = (string) ($block['isi'] ?? '');
    $correctIndex = (int) ($block['arahan'] ?? 0);
    $clue = $block['clue'] ?? [];

    $config = is_array($clue)
        ? $clue
        : json_decode((string) $clue, true);

    $config = is_array($config) ? $config : [];

    /*
     * Mendukung:
     * {"options":["A","B"],"explanation":"..."}
     * serta pilihan dalam bentuk object.
     */
    $rawOptions = $config['options'] ?? [];
    $explanation = (string) ($config['explanation'] ?? '');

    $options = [];

    if (is_array($rawOptions)) {
        foreach ($rawOptions as $option) {
            $text = is_array($option)
                ? ($option['text'] ?? '')
                : $option;

            $options[] = (string) $text;
        }
    }

    $labels = range('A', 'Z');
@endphp

<div class="space-y-5">

    {{-- HEADER KUIS --}}
    <div class="rounded-2xl border-2 border-[#A69E95]
                bg-[#333] p-5 shadow-[5px_5px_0_#111] sm:p-7">

        <div class="mb-5 flex items-center justify-between gap-3">

            <div class="flex items-center gap-2">
                <span class="text-2xl">🧠</span>

                <div>
                    <h2 class="font-extrabold text-white">
                        Tantangan Pilihan Ganda
                    </h2>

                    <p class="mt-1 text-xs text-gray-400">
                        Pilih jawaban yang paling tepat.
                    </p>
                </div>
            </div>

            <span class="rounded-lg bg-purple-500/15
                         px-3 py-1.5 text-xs font-bold
                         text-purple-300">
                QUIZ
            </span>

        </div>

        {{-- PERTANYAAN --}}
        <div class="text-base font-semibold leading-8 text-white">
            {{ $question }}
        </div>

    </div>

    {{-- PILIHAN JAWABAN --}}
    <div
        id="quiz-options-{{ $index }}"
        class="space-y-3"
        role="radiogroup"
        aria-label="Pilihan jawaban"
    >

        @foreach($options as $optionIndex => $option)

            <button
                type="button"
                class="quiz-option flex w-full items-center gap-4
                       rounded-xl border-2 border-gray-700
                       bg-[#292929] p-4 text-left
                       transition hover:border-indigo-400
                       hover:bg-[#333]"
                data-option-index="{{ $optionIndex }}"
                aria-pressed="false"
                onclick="selectQuizOption({{ $index }}, {{ $optionIndex }})"
            >

                <span
                    class="quiz-letter flex h-11 w-11 shrink-0
                           items-center justify-center
                           rounded-xl border border-gray-600
                           bg-[#202020] text-sm
                           font-extrabold text-gray-300"
                >
                    {{ $labels[$optionIndex] ?? ($optionIndex + 1) }}
                </span>

                <span class="flex-1 break-words text-sm
                             font-semibold leading-6 text-gray-200">
                    {{ $option }}
                </span>

                <span class="quiz-indicator text-xl text-gray-600">
                    ○
                </span>

            </button>

        @endforeach

    </div>

    {{-- STATUS PILIHAN --}}
    <div class="flex items-center justify-between text-xs text-gray-400">

        <span id="quiz-selection-status-{{ $index }}">
            Belum memilih jawaban
        </span>

        <span class="font-bold text-indigo-300">
            {{ count($options) }} pilihan
        </span>

    </div>

    {{-- DATA JAWABAN UNTUK CHECK CLIENT --}}
    <script type="application/json"
            id="quiz-data-{{ $index }}">
        @json([
            'correctIndex' => $correctIndex,
            'explanation' => $explanation,
        ])
    </script>

    {{-- TOMBOL CHECK --}}
    <button
        type="button"
        id="quiz-check-button-{{ $index }}"
        onclick="checkQuizAnswer({{ $index }})"
        class="w-full rounded-xl bg-[#F5C400]
               py-4 text-sm font-extrabold
               tracking-wider text-[#292929]
               shadow-[0_5px_0_#B58E00]
               transition hover:bg-yellow-300"
    >
        CHECK JAWABAN
    </button>

    {{-- FEEDBACK --}}
    <div
        id="quiz-feedback-{{ $index }}"
        class="hidden rounded-xl border p-5"
        role="status"
        aria-live="polite"
    ></div>

    {{-- PETUNJUK --}}
    <div class="flex items-start gap-3 rounded-xl
                border border-white/10 bg-white/[0.03]
                px-4 py-3">

        <span class="text-lg">💡</span>

        <p class="text-xs leading-6 text-gray-400">
            Baca pertanyaan dengan teliti, pilih satu jawaban,
            kemudian tekan CHECK untuk memeriksanya.
        </p>

    </div>

</div>
