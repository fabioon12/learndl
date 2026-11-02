@extends('guru.layouts.app')

@section('title', 'Apersepsi')

@section('content')
@php
    // Simulasi data dari array untuk preview
    $ruangBelajar = (object) ['id' => 1];
    
    $tahapan = (object) [
        'id' => 1,
        'judul_tahapan' => 'Pemanasan: Memahami Logika Dasar Sistem Pabrik',
        'icon' => 'fa-lightbulb',
        'xp_reward' => 100,
        'konten' => [
            'teks_apersepsi' => "Halo kawan-kawan! Sebelum kita masuk ke dalam materi inti mengenai pembuatan struktur data dan algoritma lanjutan, mari kita amati bagaimana sebuah sistem cerdas di industri manufaktur mengambil keputusan secara otomatis.\n\nSilakan amati ilustrasi atau video pengantar di bawah ini dan perhatikan bagaimana mesin merespons perintah input dari sensor yang terhubung secara *real-time*.",
            'tipe_media' => 'youtube',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'pertanyaan_pemantik' => 'Menurut kalian, apa yang terjadi jika sensor pada mesin pabrik terlambat mengirimkan data ke pusat kontrol?'
        ]
    ];

    // Simulasi daftar diskusi / feedback siswa dari array
    $diskusis = [
        (object) [
            'user' => (object) ['fullname' => 'Ahmad Fauzi'],
            'pesan' => 'Menurut saya sistem bisa mengalami kesalahan produksi atau delay pada proses perakitan barang di pabrik.',
            'created_at' => now()->subMinutes(5)
        ],
        (object) [
            'user' => (object) ['fullname' => 'Siti Rahma'],
            'pesan' => 'Bisa menyebabkan mesin berhenti mendadak atau terjadi penumpukan produk karena data gagal sinkron dengan database pusat.',
            'created_at' => now()->subMinutes(12)
        ]
    ];
@endphp

<div class="max-w-3xl mx-auto space-y-6 py-6">

    <!-- Header Navigasi Kembali -->
    <div class="flex items-center justify-between">
        <a href="#" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/85 dark:bg-cyberdark-800/85 backdrop-blur-xl border border-gray-200/80 dark:border-pink-950/30 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 text-xs font-bold transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs text-indigo-500"></i>
            <span>Kembali ke Peta Belajar</span>
        </a>

        <!-- Indikator XP Reward -->
        <div class="px-3 py-1.5 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center gap-1.5 text-amber-500 text-xs font-black">
            <i class="fa-solid fa-star"></i>
            <span>+{{ $tahapan->xp_reward }} XP</span>
        </div>
    </div>

    <!-- Card Utama Konten Apersepsi -->
    <div class="bg-white/90 dark:bg-cyberdark-800/90 backdrop-blur-2xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
        
        <!-- Header Tahapan -->
        <div class="flex items-center gap-3.5 pb-4 border-b border-gray-100 dark:border-pink-950/20">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-600 text-white flex items-center justify-center text-xl shadow-md shadow-orange-500/20 shrink-0">
                <i class="fa-solid {{ $tahapan->icon }}"></i>
            </div>
            <div>
                <span class="text-[10px] font-extrabold text-amber-500 uppercase tracking-wider">Tahapan Apersepsi</span>
                <h2 class="text-base sm:text-lg font-black text-gray-900 dark:text-white">{{ $tahapan->judul_tahapan }}</h2>
            </div>
        </div>

        <!-- Teks Pengantar / Cerita Apersepsi -->
        <div class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed space-y-3">
            {!! nl2br(e($tahapan->konten['teks_apersepsi'])) !!}
        </div>

        <!-- Render Media Pendukung (YouTube) -->
        @if($tahapan->konten['tipe_media'] == 'youtube' && !empty($tahapan->konten['youtube_url']))
            @php
                $ytUrl = $tahapan->konten['youtube_url'];
                if (str_contains($ytUrl, 'watch?v=')) {
                    $embedUrl = str_replace('watch?v=', 'embed/', explode('&', $ytUrl)[0]);
                } else {
                    $embedUrl = $ytUrl;
                }
            @endphp
            <div class="space-y-2">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider"><i class="fa-brands fa-youtube text-rose-500 mr-1"></i> Video Pengantar</p>
                <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-lg border border-gray-100 dark:border-pink-950/30">
                    <iframe src="{{ $embedUrl }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        @endif
    </div>

    <!-- Card Forum Diskusi & Feedback Siswa -->
    <div class="bg-white/90 dark:bg-cyberdark-800/90 backdrop-blur-2xl border border-gray-100 dark:border-pink-950/30 rounded-3xl p-6 sm:p-8 shadow-xl space-y-6">
        
        <div class="pb-4 border-b border-gray-100 dark:border-pink-950/20 space-y-1">
            <span class="text-[10px] font-extrabold text-indigo-500 uppercase tracking-wider">Interaksi Kelas</span>
            <h3 class="text-xs sm:text-sm font-black text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-comments text-indigo-500"></i>
                <span>Pertanyaan Pemantik & Forum Diskusi</span>
            </h3>
            <div class="p-4 rounded-2xl bg-indigo-50/60 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/40 text-xs font-semibold text-indigo-900 dark:text-indigo-200 mt-2">
                🗣️ "{{ $tahapan->konten['pertanyaan_pemantik'] }}"
            </div>
        </div>

        <!-- Form Kirim Jawaban / Pendapat / Feedback -->
        <form action="#" method="POST" class="space-y-3" onsubmit="event.preventDefault(); alert('Simulasi kirim pesan berhasil!');">
            @csrf
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 dark:text-gray-300">Tuliskan Pendapat / Feedback Kamu</label>
                <textarea name="pesan" rows="3" placeholder="Ketik jawaban atau tanggapan kamu di sini..." required
                          class="w-full px-4 py-3 rounded-2xl bg-gray-50 dark:bg-cyberdark-900 border border-gray-200 dark:border-pink-950/30 text-xs text-gray-800 dark:text-white focus:outline-none focus:border-indigo-500 transition"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" 
                        class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-extrabold shadow-md shadow-indigo-500/20 transition active:scale-95 cursor-pointer flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Pendapat</span>
                </button>
            </div>
        </form>

        <!-- Daftar Diskusi / Feedback dari Array -->
        <div class="space-y-3 pt-4 border-t border-gray-100 dark:border-pink-950/20">
            <h4 class="text-xs font-black text-gray-400 uppercase tracking-wider">Diskusi Kelas ({{ count($diskusis) }})</h4>
            
            @foreach($diskusis as $diskusi)
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-cyberdark-900/60 border border-gray-100 dark:border-pink-950/20 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr($diskusi->user->fullname, 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">{{ $diskusi->user->fullname }}</span>
                        </div>
                        <span class="text-[10px] text-gray-400">{{ $diskusi->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-300 pl-9 leading-relaxed">{{ $diskusi->pesan }}</p>
                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection