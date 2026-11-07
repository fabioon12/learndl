
@php
    $totalActivities = count($blocks ?? []);

    $materiTitle = $materi->judul
        ?? $materi->nama_materi
        ?? 'Ruang Belajar';

    $submateriTitle = $submateri->judul_sub
        ?? $submateri->judul
        ?? 'Aktivitas Pembelajaran';

    $xpReward = $submateri->xp_reward ?? 25;
@endphp

<header class="w-full border-b border-white/10 bg-[#292929]">

    <div class="mx-auto flex min-h-[68px] max-w-6xl
                items-center gap-3 px-4 py-3 sm:gap-5 sm:px-6">

        {{-- KEMBALI --}}
        <a
            href="{{ route(
                'siswa.ruang-materi.dashboard-belajar',
                $materi->id
            ) }}"
            title="Kembali ke Ruang Belajar"
            aria-label="Kembali ke Ruang Belajar"
            class="flex h-10 w-10 shrink-0 items-center
                   justify-center rounded-xl
                   border border-white/10 bg-[#383838]
                   text-white transition
                   hover:border-yellow-400/50 hover:bg-[#444]"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 width="20" height="20"
                 viewBox="0 0 24 24"
                 fill="none" stroke="currentColor"
                 stroke-width="2.5"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
        </a>

        {{-- JUDUL MATERI --}}
        <div class="min-w-0 flex-1">

            <p class="truncate text-[10px] font-semibold
                      text-gray-400">
                {{ $materiTitle }}
            </p>

            <h1 class="truncate text-sm font-extrabold
                       text-white sm:text-base"
                title="{{ $submateriTitle }}">
                {{ $submateriTitle }}
            </h1>

        </div>

        {{-- XP REWARD --}}
        <div class="flex shrink-0 items-center gap-1.5
                    rounded-lg border border-yellow-400/15
                    bg-yellow-400/10 px-2.5 py-2">

            <span class="text-sm">⚡</span>

            <span class="whitespace-nowrap text-xs
                         font-extrabold text-yellow-400">
                {{ $xpReward }} XP
            </span>

        </div>

        {{-- PROGRESS --}}
        @if($totalActivities > 0)

            <div class="hidden w-36 shrink-0 sm:block lg:w-48">

                <div class="mb-1.5 flex items-center
                            justify-between">

                    <span class="text-[10px] text-gray-400">
                        Progres
                    </span>

                    <span id="header-step-label"
                          class="text-[10px] font-extrabold
                                 text-yellow-400">
                        1 / {{ $totalActivities }}
                    </span>

                </div>

                <div id="progress-container"
                     class="flex h-2 items-center gap-1">

                    @for($i = 0; $i < $totalActivities; $i++)

                        <div
                            class="progress-segment h-2 min-w-0
                                   flex-1 rounded-full
                                   transition-colors duration-300
                                   {{ $i === 0
                                        ? 'bg-yellow-400'
                                        : 'bg-gray-700' }}"
                        ></div>

                    @endfor

                </div>

            </div>

        @endif

    </div>

    {{-- MOBILE PROGRESS: BAR TIPIS DI BAWAH HEADER --}}
    @if($totalActivities > 0)

        <div class="border-t border-white/5 px-4
                    pb-2 pt-1.5 sm:hidden">

            <div class="flex items-center gap-3">

                <span class="shrink-0 text-[10px]
                             font-bold text-gray-400">
                    Progres
                </span>

                <div id="mobile-progress-container"
                     class="flex h-1.5 flex-1 gap-1">

                    @for($i = 0; $i < $totalActivities; $i++)

                        <div
                            class="mobile-progress-segment
                                   h-1.5 min-w-0 flex-1 rounded-full
                                   {{ $i === 0
                                        ? 'bg-yellow-400'
                                        : 'bg-gray-700' }}"
                        ></div>

                    @endfor

                </div>

                <span id="mobile-step-label"
                      class="shrink-0 text-[10px]
                             font-bold text-yellow-400">
                    1/{{ $totalActivities }}
                </span>

            </div>

        </div>

    @endif

</header>
