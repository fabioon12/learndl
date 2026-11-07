
@php
    $isi = $block['isi'] ?? '';
    $arahan = $block['arahan'] ?? '';
    $tips = $block['tips'] ?? '';
    $clue = $block['clue'] ?? '';

    // Kunci jawaban dipisahkan menggunakan |
    $correctOrder = array_values(array_filter(
        array_map('trim', explode('|', (string) $arahan)),
        fn ($value) => $value !== ''
    ));

    // Pilihan kode disimpan dalam JSON
    $decodedOptions = json_decode((string) $clue, true);
    $options = [];

    if (is_array($decodedOptions)) {
        foreach ($decodedOptions as $i => $option) {
            $text = is_array($option)
                ? ($option['text'] ?? '')
                : $option;

            if (trim((string) $text) !== '') {
                $options[] = [
                    'id' => (string) $i,
                    'text' => (string) $text,
                ];
            }
        }
    }

    shuffle($options);
@endphp

<div class="space-y-5">

    {{-- PERTANYAAN --}}
    <div class="rounded-2xl border-2 border-[#A69E95]
                bg-[#333] p-5 shadow-[5px_5px_0_#111]">

        <div class="mb-4 flex items-center gap-2">
            <span class="text-xl">🧩</span>
            <h2 class="font-extrabold text-white">
                Tantangan Susun Kode
            </h2>
        </div>

        <div class="text-sm leading-7 text-gray-200">
            {{ strip_tags($isi) }}
        </div>

        @if($tips)
            <div class="mt-4 rounded-xl border border-blue-400/20
                        bg-blue-500/10 p-4 text-sm text-blue-200">
                💡 {{ strip_tags($tips) }}
            </div>
        @endif
    </div>

    {{-- AREA JAWABAN --}}
    <div class="rounded-2xl border border-gray-700 bg-[#202020] p-5">

        <div class="mb-4 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-white">Susun Jawabanmu</h3>
                <p class="mt-1 text-xs text-gray-400">
                    Klik blok kode untuk menyusunnya.
                </p>
            </div>

            <span class="rounded-lg bg-yellow-400/10 px-3 py-2
                         text-xs font-bold text-yellow-400">
                <span id="answer-count-{{ $index }}">0</span>
                /{{ count($correctOrder) }}
            </span>
        </div>

        <div id="answer-slots-{{ $index }}"
             data-slot-count="{{ count($correctOrder) }}"
             class="flex min-h-28 flex-wrap gap-2 rounded-xl
                    border border-gray-700 bg-[#171717] p-4">

            @foreach($correctOrder as $position => $answer)
                <div class="flex h-12 min-w-14 items-center justify-center
                            rounded-lg border-2 border-dashed
                            border-gray-600 text-xs text-gray-500">
                    {{ $position + 1 }}
                </div>
            @endforeach
        </div>

        <p class="mt-3 text-xs text-gray-500">
            Klik blok yang sudah dipilih untuk menghapusnya.
        </p>
    </div>

    {{-- PILIHAN KODE --}}
    <div class="rounded-2xl border border-gray-700 bg-[#202020] p-5">

        <h3 class="mb-1 font-bold text-white">
            Pilihan Blok Kode
        </h3>

        <p class="mb-4 text-xs text-gray-400">
            Pilih potongan kode sesuai urutan yang benar.
        </p>

        <div id="code-options-{{ $index }}"
             class="flex flex-wrap gap-2">

            @foreach($options as $option)
                <button
                    type="button"
                    class="code-choice max-w-full rounded-lg
                           border border-gray-700 bg-[#111]
                           px-4 py-3 text-left font-mono
                           text-sm text-blue-400 transition
                           hover:border-yellow-400
                           disabled:opacity-30"
                    data-option-id="{{ $option['id'] }}"
                    data-code="{{ $option['text'] }}"
                    onclick="selectCodeBlock({{ $index }}, this)"
                >
                    {{ $option['text'] }}
                </button>
            @endforeach
        </div>

        @if(empty($options))
            <p class="mt-4 text-sm text-red-400">
                Pilihan kode belum tersedia.
            </p>
        @endif
    </div>

    {{-- KUNCI JAWABAN UNTUK PEMERIKSAAN --}}
    <script type="application/json"
            id="exercise-answer-{{ $index }}">
        @json($correctOrder)
    </script>

    {{-- TOMBOL CHECK --}}
    <button
        type="button"
        onclick="checkCodeOrder({{ $index }})"
        class="w-full rounded-xl bg-yellow-400 py-4
               font-extrabold text-[#292929]
               shadow-[0_5px_0_#B58E00]
               transition hover:bg-yellow-300"
    >
        CHECK JAWABAN
    </button>

    {{-- FEEDBACK --}}
    <div id="exercise-feedback-{{ $index }}"
         class="hidden rounded-xl border p-4 text-sm">
    </div>

</div>
