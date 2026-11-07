
@php
    $totalActivities = count($blocks ?? []);
@endphp

<div
    id="learning-character"
    class="mb-5 rounded-2xl border border-white/10
           bg-[#333] p-3 shadow-[3px_3px_0_#1b1b1b]
           sm:p-4"
>
    <div class="flex items-center gap-3 sm:gap-4">

        {{-- MASKOT --}}
        <div
            id="character-avatar"
            class="relative flex h-[68px] w-[68px]
                   shrink-0 items-center justify-center
                   rounded-xl border-2 border-yellow-400/20
                   bg-yellow-400/10 sm:h-[76px] sm:w-[76px]"
        >
            <span
                id="character-emoji"
                class="select-none text-4xl
                       transition-transform duration-300"
            >
                🫎
            </span>

            {{-- LEVEL BADGE --}}
            <span
                class="absolute -bottom-2 rounded-md
                       border border-yellow-500/30
                       bg-[#252525] px-2 py-0.5
                       text-[9px] font-black text-yellow-400"
            >
                GUIDE
            </span>
        </div>

        {{-- INFORMASI KARAKTER --}}
        <div class="min-w-0 flex-1">

            {{-- BARIS ATAS: NAMA DAN NYAWA --}}
            <div class="mb-3 flex items-start justify-between gap-3">

                {{-- IDENTITAS KARAKTER --}}
                <div class="flex min-w-0 flex-wrap items-center gap-2 pt-1">

                    <span class="text-xs font-extrabold text-yellow-400">
                        MOOSE
                    </span>

                    <span
                        class="rounded-md bg-yellow-400/10
                            px-2 py-0.5 text-[9px]
                            font-bold text-yellow-300"
                    >
                        Teman Belajar
                    </span>

                </div>

                {{-- AREA NYAWA DAN RESET --}}
                <div class="flex shrink-0 flex-col items-center gap-2">

                    {{-- INDIKATOR NYAWA --}}
                    <div
                        id="character-hearts"
                        class="flex flex-col items-center gap-1
                            rounded-xl border border-white/10
                            bg-[#292929] px-3 py-2
                            transition-colors duration-300"
                        aria-label="3 dari 3 nyawa"
                        role="status"
                    >

                        <div class="flex items-center gap-1">

                            <span class="character-heart text-base">❤️</span>
                            <span class="character-heart text-base">❤️</span>
                            <span class="character-heart text-base">❤️</span>

                        </div>

                        <span
                            id="character-hp-label"
                            class="text-[10px] font-extrabold text-gray-300"
                        >
                            3 / 3 HP
                        </span>

                    </div>

                    {{-- TOMBOL RESET: MUNCUL KETIKA HP = 0 --}}
                    <button
                        id="reset-hearts-button"
                        type="button"
                        onclick="window.restoreHearts?.()"
                        class="hidden w-full rounded-lg
                            bg-yellow-400 px-2 py-2
                            text-center text-[10px]
                            font-extrabold text-[#292929]
                            transition hover:bg-yellow-300"
                    >
                        ↻ Ulangi Tantangan
                    </button>

                </div>

            </div>

            {{-- PESAN UTAMA --}}
            <p
                id="character-message"
                class="text-xs font-semibold leading-5
                    text-white sm:text-sm sm:leading-6"
                aria-live="polite"
            >
                Hai, petualang! Siap menyelesaikan tantangan hari ini? 🚀
            </p>

            {{-- PESAN PENDUKUNG --}}
            <p
                id="character-submessage"
                class="mt-1 text-[10px] leading-5
                    text-gray-400 sm:text-xs"
            >
                Selesaikan setiap misi untuk mendapatkan XP!
            </p>

        </div>


    </div>

</div>
