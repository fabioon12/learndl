@php
    $userMood = auth()->user()->mood ?? '😊';
    $moodLabels = [
        '😊' => 'Senang',
        '🔥' => 'Semangat',
        '😴' => 'Lelah',
        '🤔' => 'Fokus',
    ];
    $currentLabel = $moodLabels[$userMood] ?? 'Senang';
@endphp

<div x-data="{ 
        openMood: false, 
        currentMood: '{{ $userMood }}', 
        moodLabel: '{{ $currentLabel }}',
        selectMood(emoji, label) {
            this.currentMood = emoji;
            this.moodLabel = label;
            this.openMood = false;

            // Kirim update mood ke server via AJAX
            fetch('{{ route('siswa.profil.update-mood') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ mood: emoji })
            })
            .catch(error => console.error('Gagal memperbarui mood:', error));
        }
     }" 
     @mood-updated.window="currentMood = $event.detail.mood; moodLabel = $event.detail.label"
     class="relative">
    
    <button @click="openMood = !openMood" 
            @click.outside="openMood = false"
            class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-2xl bg-gray-50 dark:bg-cyberdark-800/80 border border-gray-200 dark:border-pink-950/30 hover:border-pink-500/40 transition cursor-pointer group"
            title="Suasana Hati Hari Ini">
        <span class="text-base group-hover:scale-110 transition-transform" x-text="currentMood"></span>
        <span class="text-[10px] font-bold text-gray-600 dark:text-gray-300 hidden sm:inline" x-text="moodLabel"></span>
        <i class="fa-solid fa-chevron-down text-[9px] text-gray-400"></i>
    </button>

    <!-- Dropdown Pilihan Mood -->
    <div x-show="openMood" 
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
         class="absolute left-0 mt-2 w-48 bg-white/95 dark:bg-cyberdark-900/95 backdrop-blur-md border border-gray-100 dark:border-pink-950/40 rounded-2xl shadow-xl p-2 z-50"
         style="display: none;">
        <p class="text-[10px] font-bold text-gray-400 px-2 py-1 uppercase tracking-wider">Perasaanmu Hari Ini?</p>
        <div class="grid grid-cols-4 gap-1 pt-1">
            <button @click="selectMood('😊', 'Senang')" class="p-2 hover:bg-pink-50 dark:hover:bg-cyberdark-800 rounded-xl text-center text-lg transition cursor-pointer" title="Senang">😊</button>
            <button @click="selectMood('🔥', 'Semangat')" class="p-2 hover:bg-pink-50 dark:hover:bg-cyberdark-800 rounded-xl text-center text-lg transition cursor-pointer" title="Semangat">🔥</button>
            <button @click="selectMood('😴', 'Lelah')" class="p-2 hover:bg-pink-50 dark:hover:bg-cyberdark-800 rounded-xl text-center text-lg transition cursor-pointer" title="Lelah">😴</button>
            <button @click="selectMood('🤔', 'Fokus')" class="p-2 hover:bg-pink-50 dark:hover:bg-cyberdark-800 rounded-xl text-center text-lg transition cursor-pointer" title="Fokus">🤔</button>
        </div>
    </div>
</div>