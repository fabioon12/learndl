
@php
    /*
    |--------------------------------------------------------------------------
    | DATA VIDEO
    |--------------------------------------------------------------------------
    */
    $videoContent = $block['isi'] ?? '';
    $videoTitle = $block['judul'] ?? 'Video Pembelajaran';
    $videoDescription = $block['arahan'] ?? '';
    $videoTips = $block['tips'] ?? '';

    // Mendukung isi berupa string URL atau array
    if (is_array($videoContent)) {
        $videoUrl = $videoContent['url']
            ?? $videoContent['video_url']
            ?? $videoContent['src']
            ?? '';
    } else {
        $videoUrl = trim((string) $videoContent);
    }

    $embedUrl = null;
    $videoType = 'unknown';

    /*
    |--------------------------------------------------------------------------
    | DETEKSI YOUTUBE
    |--------------------------------------------------------------------------
    */
    if (filter_var($videoUrl, FILTER_VALIDATE_URL)) {
        $host = strtolower(parse_url($videoUrl, PHP_URL_HOST) ?? '');
        $path = trim(parse_url($videoUrl, PHP_URL_PATH) ?? '', '/');

        $youtubeId = null;

        if (in_array($host, [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
            'youtube-nocookie.com',
            'www.youtube-nocookie.com'
        ])) {
            if ($path === 'watch') {
                parse_str(
                    parse_url($videoUrl, PHP_URL_QUERY) ?? '',
                    $query
                );

                $youtubeId = $query['v'] ?? null;
            } elseif (
                str_starts_with($path, 'shorts/') ||
                str_starts_with($path, 'embed/') ||
                str_starts_with($path, 'live/')
            ) {
                $youtubeId = explode('/', $path)[1] ?? null;
            }
        } elseif (
            in_array($host, ['youtu.be', 'www.youtu.be'])
        ) {
            $youtubeId = explode('/', $path)[0] ?? null;
        }

        if (
            $youtubeId &&
            preg_match('/^[a-zA-Z0-9_-]{11}$/', $youtubeId)
        ) {
            $videoType = 'youtube';

            $embedUrl = 'https://www.youtube-nocookie.com/embed/'
                . $youtubeId
                . '?rel=0';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DETEKSI FILE VIDEO
    |--------------------------------------------------------------------------
    */
    if ($videoType === 'unknown' && $videoUrl !== '') {
        $path = parse_url($videoUrl, PHP_URL_PATH) ?? '';

        if (
            preg_match('/\.(mp4|webm|ogg)$/i', $path)
        ) {
            $videoType = 'file';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | LARAVEL STORAGE
    |--------------------------------------------------------------------------
    */
    if (
        $videoType === 'unknown' &&
        $videoUrl !== '' &&
        !filter_var($videoUrl, FILTER_VALIDATE_URL) &&
        !str_starts_with($videoUrl, '//') &&
        !str_starts_with($videoUrl, '/')
    ) {
        $videoType = 'file';

        $videoUrl = asset(
            'storage/' . ltrim(
                preg_replace('#^storage/#', '', $videoUrl),
                '/'
            )
        );
    }

    $videoId = 'learning-video-' . $index;
@endphp

<div class="space-y-5">

    {{-- HEADER VIDEO --}}
    <div class="flex items-start gap-3">

        <div
            class="flex h-11 w-11 shrink-0 items-center
                   justify-center rounded-xl
                   bg-yellow-400/10 text-xl"
        >
            🎬
        </div>

        <div class="min-w-0 flex-1">

            <span
                class="text-[10px] font-black uppercase
                       tracking-widest text-yellow-400"
            >
                MISI MENONTON
            </span>

            <h2 class="mt-1 text-lg font-black text-white">
                {{ $videoTitle }}
            </h2>

            <p class="mt-1 text-xs leading-5 text-gray-400">
                Tonton video berikut untuk memahami
                materi sebelum melanjutkan tantangan.
            </p>

        </div>

    </div>

    {{-- VIDEO PLAYER --}}
    <div
        class="overflow-hidden rounded-2xl
               border border-white/10 bg-[#1b1b1b]"
    >

        <div class="relative aspect-video w-full bg-black">

            @if($videoType === 'youtube')

                <iframe
                    id="{{ $videoId }}"
                    class="absolute inset-0 h-full w-full"
                    src="{{ $embedUrl }}"
                    title="{{ $videoTitle }}"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allow="accelerometer; autoplay;
                           clipboard-write; encrypted-media;
                           gyroscope; picture-in-picture;
                           web-share"
                    allowfullscreen
                ></iframe>

            @elseif($videoType === 'file')

                <video
                    id="{{ $videoId }}"
                    class="absolute inset-0 h-full w-full"
                    controls
                    preload="metadata"
                    playsinline
                    controlsList="nodownload"
                >
                    <source src="{{ $videoUrl }}">

                    Browser kamu tidak mendukung
                    pemutaran video.
                </video>

            @else

                <div
                    class="flex h-full flex-col items-center
                           justify-center gap-3 p-6 text-center"
                >
                    <span class="text-5xl">📹</span>

                    <p class="text-sm font-bold text-white">
                        Video belum tersedia
                    </p>

                    <p class="text-xs text-gray-400">
                        Guru belum menambahkan tautan
                        video yang valid.
                    </p>
                </div>

            @endif

        </div>

        {{-- VIDEO FOOTER --}}
        <div
            class="flex flex-wrap items-center
                   justify-between gap-3 px-4 py-3"
        >

            <div class="flex items-center gap-2">

                <span class="text-sm">▶️</span>

                <span class="text-xs font-bold text-gray-300">
                    Materi Video
                </span>

            </div>

            <span
                class="rounded-lg bg-white/5
                       px-3 py-1.5 text-[10px]
                       font-bold text-gray-400"
            >
                {{ $videoType === 'youtube'
                    ? 'YouTube'
                    : ($videoType === 'file'
                        ? 'Video Player'
                        : 'Belum tersedia') }}
            </span>

        </div>

    </div>

    {{-- ARAHAN PEMBELAJARAN --}}
    @if(!empty($videoDescription))

        <div
            class="rounded-2xl border border-yellow-400/15
                   bg-yellow-400/5 p-4"
        >

            <div class="mb-2 flex items-center gap-2">
                <span>🎯</span>

                <h3 class="text-xs font-black text-yellow-400">
                    MISI KAMU
                </h3>
            </div>

            <p
                class="whitespace-pre-line text-sm
                       leading-6 text-gray-300"
            >{{ $videoDescription }}</p>

        </div>

    @endif

    {{-- TIPS --}}
    @if(!empty($videoTips))

        <div
            class="flex items-start gap-3 rounded-xl
                   border border-white/10 bg-[#333333] p-4"
        >

            <span class="text-xl">💡</span>

            <div>

                <h3 class="text-xs font-extrabold text-white">
                    TIPS BELAJAR
                </h3>

                <p
                    class="mt-1 whitespace-pre-line
                           text-xs leading-5 text-gray-400"
                >{{ $videoTips }}</p>

            </div>

        </div>

    @endif

    {{-- INFO NAVIGASI --}}
    <div
        class="flex items-start gap-3 rounded-xl
               border border-white/10 bg-[#333333] p-4"
    >

        <span class="text-lg">🫎</span>

        <p class="text-xs leading-5 text-gray-300">
            <span class="font-extrabold text-yellow-400">
                MOOSE:
            </span>

            Tonton dan pahami videonya, ya!
            Setelah selesai, tekan tombol
            <span class="font-extrabold text-white">
                LANJUT →
            </span>
            untuk menuju tantangan berikutnya.
        </p>

    </div>

</div>
