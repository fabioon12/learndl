
@if(count($blocks) > 0)

    <div class="mt-8 space-y-4">

        {{-- STATUS SELESAI --}}
        @if($isCompleted)
            <div class="rounded-xl border border-emerald-500/30
                        bg-emerald-500/10 p-4">

                <div class="flex items-start gap-3">
                    <div class="text-2xl">🏆</div>

                    <div>
                        <h3 class="text-sm font-extrabold text-emerald-300">
                            Misi Sudah Diselesaikan!
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-gray-300">
                            Kamu sudah menyelesaikan materi ini.
                            Kamu tetap bisa mengulang setiap tahapan untuk memperdalam pemahamanmu.
                        </p>
                    </div>
                </div>

            </div>
        @endif

        {{-- FEEDBACK GLOBAL --}}
        <div
            id="feedback-box"
            class="hidden rounded-xl border border-red-400
                   bg-red-500/10 p-4"
        >
            <h3
                id="feedback-title"
                class="text-sm font-extrabold text-white"
            ></h3>

            <p
                id="feedback-message"
                class="mt-2 text-xs leading-6 text-gray-300"
            ></p>
        </div>

        {{-- PROGRESS --}}
        <div class="rounded-2xl border border-gray-700
                    bg-[#292929] p-5">

            <div class="mb-3 flex items-center justify-between">

                <span
                    id="step-label"
                    class="text-xs font-bold text-gray-300"
                >
                    Tahap 1 dari {{ count($blocks) }}
                </span>

                <span
                    id="step-percentage"
                    class="text-xs font-extrabold text-yellow-400"
                >
                    0%
                </span>

            </div>

            <div class="h-2 overflow-hidden rounded-full bg-gray-700">

                <div
                    id="bottom-progress"
                    class="h-full rounded-full bg-yellow-400
                           transition-all duration-500"
                    style="width: 0%"
                ></div>

            </div>

        </div>

        {{-- TOMBOL NAVIGASI --}}
        <div class="flex items-center gap-3">

            <button
                type="button"
                id="previous-button"
                onclick="previousTask()"
                class="rounded-xl border-2 border-gray-600
                       bg-[#333] px-6 py-4 text-xs
                       font-extrabold text-white
                       transition hover:bg-[#444]"
            >
                ← KEMBALI
            </button>

            <button
                type="button"
                id="next-button"
                onclick="nextTask()"
                class="flex-1 rounded-xl bg-yellow-400
                       px-6 py-4 text-sm font-extrabold
                       text-[#292929]
                       shadow-[0_5px_0_#B58E00]
                       transition hover:bg-yellow-300"
            >
                LANJUT →
            </button>

        </div>

        {{-- FORM COMPLETE SUBMATERI --}}
        <form
            id="complete-form"
            method="POST"
            action="{{ route(
                'siswa.ruang-materi.dashboard-belajar.submateri.complete',
                [
                    'materi' => $materi->id,
                    'submateri' => $submateri->id
                ]
            ) }}"
            class="hidden"
        >
            @csrf
        </form>

    </div>

@endif
