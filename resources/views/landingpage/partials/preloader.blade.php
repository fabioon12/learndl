    <div 
        x-show="isPreloading" 
        x-transition:leave="transition ease-in duration-400"
        class="fixed inset-0 bg-slate-950 z-[9999] flex flex-col items-center justify-center gap-4"
    >
        <div class="relative flex items-center justify-center">
            <div class="absolute w-16 h-16 rounded-2xl bg-purple-600/20 border border-purple-500 animate-ping"></div>
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 text-white flex items-center justify-center text-xl shadow-lg relative z-10">
                <i class="fa-solid fa-brain"></i>
            </div>
        </div>
        <p class="text-white font-bold tracking-widest text-[10px] font-mono uppercase opacity-70">Loading...</p>
    </div>