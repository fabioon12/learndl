
@php
    /*
    |--------------------------------------------------------------------------
    | GLOBAL XP & LEVEL
    |--------------------------------------------------------------------------
    | Mengambil total XP dari seluruh submateri yang sudah diselesaikan.
    | 1000 XP = naik 1 level.
    |--------------------------------------------------------------------------
    */

    $navbarUser = auth()->user();

    $navbarTotalXp = $navbarUser
        ? max(0, (int) $navbarUser->totalXp())
        : 0;

    $navbarXpNeeded = 1000;

    $navbarLevel = intdiv(
        $navbarTotalXp,
        $navbarXpNeeded
    ) + 1;

    $navbarXpInLevel = $navbarTotalXp % $navbarXpNeeded;

    $navbarXpPercentage = round(
        ($navbarXpInLevel / $navbarXpNeeded) * 100,
        2
    );

    $navbarXpRemaining = $navbarXpNeeded - $navbarXpInLevel;
@endphp

<div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">

    {{-- DESKTOP LEVEL BADGE --}}
    <div
        class="group relative hidden lg:flex items-center gap-3
               rounded-2xl border border-pink-500/20
               bg-white/80 px-3.5 py-2
               shadow-lg shadow-pink-500/10
               backdrop-blur-md transition-all duration-300
               hover:border-pink-500/50
               dark:bg-cyberdark-800/80"
        title="Total XP: {{ number_format($navbarTotalXp, 0, ',', '.') }} | {{ number_format($navbarXpRemaining, 0, ',', '.') }} XP menuju Level {{ $navbarLevel + 1 }}"
    >

        {{-- TROPHY BADGE --}}
        <div class="relative flex shrink-0 items-center justify-center">

            {{-- GLOW --}}
            <div
                class="absolute -inset-1 rounded-xl
                       bg-gradient-to-r from-amber-400
                       via-pink-500 to-purple-600
                       opacity-60 blur-sm
                       transition-all duration-300
                       group-hover:scale-110
                       group-hover:opacity-100"
            ></div>

            {{-- ICON --}}
            <div
                class="relative flex h-9 w-9 items-center
                       justify-center rounded-xl
                       border border-white/20
                       bg-gradient-to-br from-pink-500
                       via-purple-600 to-indigo-600
                       text-white shadow-inner"
            >
                <i
                    class="fa-solid fa-trophy
                           text-sm text-amber-300"
                ></i>
            </div>

            {{-- LEVEL NUMBER --}}
            <span
                class="absolute -bottom-1.5 -right-2
                       rounded-full border border-white
                       bg-gradient-to-r from-amber-400
                       to-orange-500 px-1.5 py-0.5
                       text-[9px] font-black text-gray-950
                       shadow-sm dark:border-cyberdark-900"
            >
                {{ $navbarLevel }}
            </span>

        </div>

        {{-- LEVEL INFORMATION --}}
        <div class="w-36 space-y-1.5">

            <div class="flex items-center justify-between gap-2">

                <span
                    class="flex items-center gap-1
                           bg-gradient-to-r from-amber-500
                           via-pink-500 to-purple-500
                           bg-clip-text text-[10px]
                           font-black text-transparent"
                >
                    <i class="fa-solid fa-bolt text-amber-500"></i>

                    LV.{{ $navbarLevel }} 
                </span>

                <span class="text-[9px] font-black text-pink-500">
                    {{ round($navbarXpPercentage) }}%
                </span>

            </div>

            {{-- XP PROGRESS BAR --}}
            <div
                class="h-2 w-full overflow-hidden rounded-full
                       border border-gray-200/50 bg-gray-100
                       dark:border-pink-950/40
                       dark:bg-cyberdark-950"
                role="progressbar"
                aria-label="Progress XP menuju level berikutnya"
                aria-valuenow="{{ $navbarXpInLevel }}"
                aria-valuemin="0"
                aria-valuemax="{{ $navbarXpNeeded }}"
            >
                <div
                    class="h-full rounded-full
                           bg-gradient-to-r from-amber-400
                           via-pink-500 to-purple-600
                           shadow-sm shadow-pink-500/50
                           transition-all duration-700"
                    style="width: {{ $navbarXpPercentage }}%"
                ></div>
            </div>

            {{-- XP CURRENT LEVEL --}}
            <div class="flex items-center justify-between">

                <span class="text-[9px] font-bold text-gray-500 dark:text-gray-400">
                    {{ number_format($navbarXpInLevel, 0, ',', '.') }}
                    /
                    {{ number_format($navbarXpNeeded, 0, ',', '.') }} XP
                </span>

                <span class="text-[9px] font-bold text-purple-500">
                    LV.{{ $navbarLevel + 1 }}
                </span>

            </div>

        </div>

        {{-- TOTAL XP GLOBAL --}}
        <div
            class="flex flex-col items-center justify-center
                   border-l border-gray-200 pl-3
                   dark:border-pink-950/40"
        >
            <span class="text-[9px] font-bold uppercase text-gray-400">
                Total XP
            </span>

            <span
                class="mt-1 flex items-center gap-1
                       text-xs font-black text-amber-500"
            >
                <i class="fa-solid fa-bolt text-[10px]"></i>

                {{ number_format($navbarTotalXp, 0, ',', '.') }}
            </span>
        </div>

    </div>

    {{-- MOBILE / TABLET LEVEL BADGE --}}
    <div
        class="flex shrink-0 items-center gap-2
               rounded-2xl border border-pink-500/30
               bg-gradient-to-r from-pink-500/15
               via-purple-500/10 to-amber-500/10
               px-2.5 py-1.5 shadow-sm lg:hidden"
        title="Total XP: {{ number_format($navbarTotalXp, 0, ',', '.') }} | {{ number_format($navbarXpInLevel, 0, ',', '.') }}/1.000 XP"
    >

        {{-- ICON --}}
        <div
            class="flex h-7 w-7 items-center justify-center
                   rounded-lg bg-gradient-to-tr
                   from-amber-400 to-pink-500
                   text-white shadow-sm"
        >
            <i class="fa-solid fa-crown text-xs"></i>
        </div>

        {{-- LEVEL & XP --}}
        <div class="flex flex-col gap-1">

            <span
                class="text-[11px] font-black
                       text-pink-600 dark:text-pink-400"
            >
                Lv.{{ $navbarLevel }}
            </span>

            <div
                class="h-1 w-14 overflow-hidden
                       rounded-full bg-gray-200
                       dark:bg-gray-700"
            >
                <div
                    class="h-full rounded-full
                           bg-gradient-to-r
                           from-amber-400 to-pink-500"
                    style="width: {{ $navbarXpPercentage }}%"
                ></div>
            </div>

        </div>

    </div>

</div>
