
@php
    $tipe = strtolower(trim($block['tipe'] ?? 'teks'));

    $activityViews = [
        // Bacaan
        'teks' => 'teks',
        'text' => 'teks',

        // Video
        'video' => 'video',
        'youtube' => 'video',

        // Praktik coding
        'praktik' => 'praktik',
        'code' => 'praktik',

        // Latihan susun kode
        'latihan' => 'latihan',
        'arahan' => 'latihan',

        // Pilihan ganda
        'pilihan_ganda' => 'pilihan-ganda',
        'interaktif' => 'pilihan-ganda',
        
        'coding_project' => 'coding-project',
    ];

    $activity = $activityViews[$tipe] ?? 'teks';
@endphp

<section
    class="task-block {{ $index === 0 ? '' : 'hidden' }}"
    data-index="{{ $index }}"
    data-type="{{ $tipe }}"
>
    <div class="mb-5 flex items-center justify-between">

        <span class="rounded-full bg-yellow-400/10
                     px-4 py-2 text-xs font-bold text-yellow-400">
            TANTANGAN {{ $index + 1 }}
        </span>

    </div>

    @include(
        'siswa.aktivitas-materi.kerjakan.activities.' . $activity,
        [
            'block' => $block,
            'index' => $index
        ]
    )

</section>
