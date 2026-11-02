@extends('guru.layouts.app')

@section('title', 'show halaman')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 space-y-6">

    @foreach($submateri->konten_builder ?? [] as $index => $block)
        @if(($block['tipe'] ?? '') === 'latihan')
            @php
                // 1. Ambil pertanyaan / instruksi
                $instruksi = $block['isi'] ?? 'Susun blok HTML berikut dengan benar:';
                
                // 2. Parse kunci jawaban benar (dipisahkan pemisah '|')
                $kunciJawaban = array_map('trim', explode('|', $block['arahan'] ?? ''));
                
                // 3. Parse opsi tombol dari clue (JSON String)
                $rawClue = $block['clue'] ?? '[]';
                $parsedOptions = is_string($rawClue) ? json_decode($rawClue, true) : $rawClue;
                
                // Extract teks saja dari array objek
                $optionsList = [];
                if (is_array($parsedOptions)) {
                    foreach ($parsedOptions as $opt) {
                        if (isset($opt['text']) && $opt['text'] !== '') {
                            $optionsList[] = $opt['text'];
                        }
                    }
                }
            @endphp

            <!-- Card Soal Latihan Interaktif -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 shadow-2xl text-white space-y-6 font-mono"
                 x-data="{
                     // Slot jawaban kosong berdasarkan jumlah kunci jawaban
                     slots: new Array({{ count($kunciJawaban) }}).fill(null),
                     
                     // Daftar opsi tombol
                     availableOptions: {{ json_encode($optionsList) }},
                     
                     // Array Kunci Jawaban Benar
                     correctAnswer: {{ json_encode($kunciJawaban) }},
                     
                     // State Feedback
                     isCorrect: null,
                     message: '',

                     // Memasukkan blok yang diklik ke slot kosong pertama
                     selectOption(text) {
                         let emptyIndex = this.slots.findIndex(s => s === null);
                         if (emptyIndex !== -1) {
                             this.slots[emptyIndex] = text;
                             this.resetFeedback();
                         }
                     },

                     // Menghapus isi slot jika diklik
                     removeSlot(index) {
                         this.slots[index] = null;
                         this.resetFeedback();
                     },

                     // Reset semua slot ke kondisi awal
                     resetSlots() {
                         this.slots = new Array({{ count($kunciJawaban) }}).fill(null);
                         this.resetFeedback();
                     },

                     resetFeedback() {
                         this.isCorrect = null;
                         this.message = '';
                     },

                     // Periksa Jawaban
                     checkAnswer() {
                         // Cek apakah semua slot sudah diisi
                         if (this.slots.includes(null)) {
                             this.isCorrect = false;
                             this.message = 'Lengkapi semua slot terlebih dahulu!';
                             return;
                         }

                         // Validasi kesamaan array
                         let match = JSON.stringify(this.slots) === JSON.stringify(this.correctAnswer);
                         this.isCorrect = match;
                         this.message = match 
                             ? '🎉 Luar biasa! Urutan kode Anda Benar!' 
                             : '❌ Urutan kode masih belum tepat, coba susun kembali!';
                     }
                 }">

                <!-- Header / Instruksi Soal -->
                <div class="space-y-2 border-b border-gray-800 pb-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-400 flex items-center gap-1.5">
                            <i class="fa-solid fa-puzzle-piece"></i> Latihan Interaktif #{{ $index + 1 }}
                        </span>
                        <button type="button" 
                                @click="resetSlots()" 
                                class="text-[11px] text-gray-400 hover:text-white transition flex items-center gap-1">
                            <i class="fa-solid fa-rotate-left"></i> Reset Slot
                        </button>
                    </div>

                    <!-- Box Pertanyaan Pixel / Retro Style -->
                    <div class="p-4 bg-gray-800/90 border border-gray-700 rounded-2xl text-sm leading-relaxed text-gray-100 shadow-inner">
                        {{ $instruksi }}
                    </div>
                </div>

                <!-- Interactive Slot Container (Area Target Jawaban Siswa) -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">
                        Area Jawaban (Klik slot untuk menghapus):
                    </label>
                    <div class="p-4 bg-gray-950 rounded-2xl border border-gray-800 flex flex-wrap items-center justify-center gap-3 min-h-[72px]">
                        <template x-for="(slot, sIdx) in slots" :key="sIdx">
                            <button type="button" 
                                    @click="removeSlot(sIdx)"
                                    :class="{
                                        'border-dashed border-gray-600 bg-gray-900/50 text-gray-600': !slot,
                                        'border-amber-400 text-sky-300 bg-gray-900 shadow-md active:scale-95': slot
                                    }"
                                    class="px-4 py-2.5 rounded-xl border-2 text-xs font-bold transition flex items-center justify-center min-w-[60px] min-h-[42px]">
                                <span x-text="slot || (sIdx + 1)"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Pilihan Tombol Blok HTML -->
                <div class="space-y-2 pt-2">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-400">
                        Klik Blok untuk Memilih Jawaban:
                    </label>
                    <div class="flex flex-wrap justify-center gap-2.5">
                        <template x-for="(optText, oIdx) in availableOptions" :key="oIdx">
                            <button type="button" 
                                    @click="selectOption(optText)" 
                                    class="px-4 py-2.5 bg-gray-800 hover:bg-gray-700 active:bg-gray-600 border border-gray-700 rounded-xl text-xs font-bold text-sky-400 hover:text-sky-300 shadow-xs transition active:scale-95">
                                <span x-text="optText"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Banner Feedback / Alert Hasil -->
                <template x-if="message">
                    <div :class="isCorrect ? 'bg-emerald-950/80 border-emerald-500 text-emerald-300' : 'bg-rose-950/80 border-rose-500 text-rose-300'"
                         class="p-4 rounded-2xl border text-xs font-bold text-center transition animate-fade-in">
                        <span x-text="message"></span>
                    </div>
                </template>

                <!-- Action Button -->
                <div class="pt-2 flex justify-end">
                    <button type="button" 
                            @click="checkAnswer()" 
                            class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl text-xs font-bold tracking-wider uppercase shadow-lg transition active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Periksa Jawaban
                    </button>
                </div>

            </div>
        @endif
    @endforeach

</div>
@endsection