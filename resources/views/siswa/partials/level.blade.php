<div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">

    <!-- Desktop Gamified Badge (Rank & Level) -->
    <div class="hidden lg:flex items-center gap-3 px-3.5 py-1.5 rounded-2xl bg-white/80 dark:bg-cyberdark-800/80 backdrop-blur-md border border-pink-500/20 shadow-lg shadow-pink-500/10 group relative hover:border-pink-500/50 transition-all duration-300">
        
        <!-- Gamified Rank Shield / Hexagon Badge -->
        <div class="relative flex items-center justify-center shrink-0">
            <!-- Animated Glow Aura Behind Icon -->
            <div class="absolute -inset-1 bg-gradient-to-r from-amber-400 via-pink-500 to-purple-600 rounded-xl blur-sm opacity-70 group-hover:opacity-100 group-hover:scale-110 transition duration-300"></div>
            
            <!-- Badge Icon Box -->
            <div class="relative w-8 h-8 bg-gradient-to-br from-pink-500 via-purple-600 to-indigo-600 text-white rounded-xl flex items-center justify-center font-black text-xs shadow-inner border border-white/20">
                <i class="fa-solid fa-trophy text-amber-300 text-xs drop-shadow-md group-hover:scale-110 transition-transform"></i>
            </div>

            <!-- Mini Level Badge Overlap -->
            <span class="absolute -bottom-1 -right-1.5 bg-gradient-to-r from-amber-400 to-orange-500 text-gray-950 font-black text-[8px] px-1 py-0.2 rounded-full border border-white dark:border-cyberdark-900 shadow-sm">
                {{ auth()->user()->level ?? 1 }}
            </span>
        </div>

        <!-- Progress Bar & Title Status -->
        <div class="w-32 space-y-1">
            <div class="flex justify-between items-center text-[9px] font-black tracking-wider uppercase">
                <!-- Status Title Game (e.g., Novice / Adventurer) -->
                <span class="bg-gradient-to-r from-amber-400 via-pink-500 to-purple-400 bg-clip-text text-transparent flex items-center gap-1">
                    <i class="fa-solid fa-bolt text-[8px] text-amber-400"></i>
                    Lv.{{ auth()->user()->level ?? 1 }} Explorer
                </span>
                <span class="text-gray-400 dark:text-gray-400 font-extrabold text-[8px]">
                    {{ auth()->user()->exp ?? 750 }}/1000 <span class="text-pink-500">XP</span>
                </span>
            </div>

            <!-- XP Progress Bar -->
            <div class="w-full bg-gray-100 dark:bg-cyberdark-950 rounded-full h-1.5 p-0.5 border border-gray-200/50 dark:border-pink-950/40 relative overflow-hidden">
                <div class="bg-gradient-to-r from-amber-400 via-pink-500 to-purple-600 h-1 rounded-full transition-all duration-500 shadow-sm shadow-pink-500/50" 
                     style="width: {{ min(100, max(0, ((auth()->user()->exp ?? 750) / 1000) * 100)) }}%"></div>
            </div>
        </div>

        <!-- Gamified Badges Streak/Achievement Mini Bar -->
        <div class="flex items-center gap-1 pl-2 border-l border-gray-200 dark:border-pink-950/40">
            <div class="w-6 h-6 rounded-lg bg-amber-500/10 border border-amber-500/30 text-amber-500 flex items-center justify-center text-[10px]" title="Streak 7 Hari">
                <i class="fa-solid fa-fire animate-pulse"></i>
            </div>
            <div class="w-6 h-6 rounded-lg bg-purple-500/10 border border-purple-500/30 text-purple-400 flex items-center justify-center text-[10px]" title="Badge Pembelajar">
                <i class="fa-solid fa-medal"></i>
            </div>
        </div>
    </div>

    <!-- Mobile/Tablet Badge (Compact Gamified Badge) -->
    <div class="flex lg:hidden items-center gap-1.5 px-2.5 py-1 rounded-2xl bg-gradient-to-r from-pink-500/15 via-purple-500/10 to-amber-500/10 border border-pink-500/30 text-pink-600 dark:text-pink-400 text-xs font-black shrink-0 shadow-sm"
         title="EXP: {{ auth()->user()->exp ?? 750 }}/1000 XP">
        <div class="w-5 h-5 rounded-lg bg-gradient-to-tr from-amber-400 to-pink-500 text-white flex items-center justify-center text-[9px] font-black shadow-sm">
            <i class="fa-solid fa-crown text-[8px]"></i>
        </div>
        <span class="tracking-wide text-[11px]">Lv.{{ auth()->user()->level ?? 1 }}</span>
    </div>

</div>