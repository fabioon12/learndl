
@php
    /*
    |--------------------------------------------------------------------------
    | DATA BACAAN
    |--------------------------------------------------------------------------
    | $block dikirim dari task-renderer.blade.php
    | isi  : HTML dari Trix Editor
    | tips : Catatan tambahan dari guru
    */

    $isi = (string) ($block['isi'] ?? '');
    $tips = (string) ($block['tips'] ?? '');

    /*
    |--------------------------------------------------------------------------
    | MEMISAHKAN TEKS DAN GAMBAR
    |--------------------------------------------------------------------------
    | Mempertahankan urutan:
    | Teks -> Gambar -> Teks -> Gambar
    */

    $items = [];

    if (trim($isi) !== '') {
        $dom = new \DOMDocument('1.0', 'UTF-8');

        $previousErrors = libxml_use_internal_errors(true);

        $dom->loadHTML(
            '<?xml encoding="UTF-8"><div id="trix-root">'
            . $isi
            . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);

        $root = $dom->getElementById('trix-root');

        /*
         * Fallback apabila getElementById tidak menemukan root.
         */
        if (!$root) {
            $root = $dom->documentElement;
        }

        /*
         * Rekursif memecah konten berdasarkan gambar.
         * Format teks tetap dipertahankan.
         */
        $extract = function ($node) use (&$extract, &$items, $dom) {

            if ($node->nodeType === XML_TEXT_NODE) {
                $text = trim($node->textContent);

                if ($text !== '') {
                    $items[] = [
                        'type' => 'text',
                        'html' => htmlspecialchars(
                            $node->textContent,
                            ENT_QUOTES,
                            'UTF-8'
                        ),
                    ];
                }

                return;
            }

            if ($node->nodeType !== XML_ELEMENT_NODE) {
                return;
            }

            $tag = strtolower($node->nodeName);

            /*
             * FIGURE: gambar Trix
             */
            if ($tag === 'figure') {
                $images = $node->getElementsByTagName('img');

                if ($images->length > 0) {
                    $caption = $node->getElementsByTagName('figcaption');
                    $captionText = $caption->length > 0
                        ? trim($caption->item(0)->textContent)
                        : '';

                    foreach ($images as $image) {
                        $items[] = [
                            'type' => 'image',
                            'src' => $image->getAttribute('src'),
                            'alt' => $image->getAttribute('alt'),
                            'caption' => $captionText,
                        ];
                    }

                    return;
                }
            }

            /*
             * IMG: gambar tanpa figure
             */
            if ($tag === 'img') {
                $items[] = [
                    'type' => 'image',
                    'src' => $node->getAttribute('src'),
                    'alt' => $node->getAttribute('alt'),
                    'caption' => '',
                ];

                return;
            }

            /*
             * Jika elemen tidak mengandung gambar,
             * simpan HTML utuh agar formatting tidak hilang.
             */
            $hasImage = false;

            foreach ($node->getElementsByTagName('img') as $image) {
                $hasImage = true;
                break;
            }

            if (!$hasImage) {
                $html = $dom->saveHTML($node);

                if (trim(strip_tags($html)) !== '') {
                    $items[] = [
                        'type' => 'text',
                        'html' => $html,
                    ];
                }

                return;
            }

            /*
             * Jika mengandung gambar di dalamnya,
             * proses setiap anak sesuai urutan.
             */
            foreach ($node->childNodes as $child) {
                $extract($child);
            }
        };

        if ($root) {
            foreach ($root->childNodes as $child) {
                $extract($child);
            }
        }

        /*
         * Gabungkan teks berurutan agar tidak
         * membuat terlalu banyak kotak dialog.
         */
        $groupedItems = [];

        foreach ($items as $item) {
            $lastIndex = count($groupedItems) - 1;

            if (
                $item['type'] === 'text'
                && $lastIndex >= 0
                && $groupedItems[$lastIndex]['type'] === 'text'
            ) {
                $groupedItems[$lastIndex]['html'] .= $item['html'];
            } else {
                $groupedItems[] = $item;
            }
        }

        $items = $groupedItems;
    }
@endphp

<div class="space-y-5">

    {{-- ==========================================
         LABEL AKTIVITAS
    ========================================== --}}
    <div class="flex items-center justify-between gap-3">

        <div class="flex items-center gap-2">

            <div
                class="flex h-10 w-10 items-center justify-center
                       rounded-xl bg-indigo-500/15 text-indigo-300"
            >
                <i class="fa-solid fa-book-open"></i>
            </div>

            <div>
                <h2 class="text-sm font-extrabold text-white">
                    Materi Bacaan
                </h2>

                <p class="mt-0.5 text-[11px] text-gray-400">
                    Pelajari materi berikut dengan saksama.
                </p>
            </div>

        </div>

        <span
            class="rounded-full border border-indigo-400/20
                   bg-indigo-500/10 px-3 py-1.5
                   text-[10px] font-bold text-indigo-300"
        >
            📖 BELAJAR
        </span>

    </div>

    {{-- ==========================================
         KONTEN BACAAN
    ========================================== --}}
    @forelse($items as $itemIndex => $item)

        @if($item['type'] === 'text')

            {{-- KOTAK DIALOG TEKS --}}
            <div
                class="relative border-2 border-[#A69E95]
                       bg-[#333333] p-5
                       shadow-[5px_5px_0_#111]
                       sm:p-7"
            >

                {{-- Dekorasi sudut --}}
                <span
                    class="absolute -left-[2px] -top-[2px]
                           h-3 w-3 border-l-4 border-t-4
                           border-yellow-400"
                ></span>

                <span
                    class="absolute -bottom-[2px] -right-[2px]
                           h-3 w-3 border-b-4 border-r-4
                           border-yellow-400"
                ></span>

                <div
                    class="bacaan-student-content
                           break-words text-sm leading-8
                           text-gray-100"
                >
                    {{-- HTML harus disanitasi sebelum dirender --}}
                    {!! $item['html'] !!}
                </div>

            </div>

        @elseif($item['type'] === 'image')

            {{-- KARTU GAMBAR --}}
            <figure
                class="overflow-hidden rounded-2xl
                       border border-white/10 bg-white
                       p-3 shadow-xl sm:p-4"
            >

                <div
                    class="flex min-h-[120px] items-center
                           justify-center rounded-xl bg-gray-50"
                >
                    <img
                        src="{{ $item['src'] }}"
                        alt="{{ $item['alt'] ?: 'Gambar materi pembelajaran' }}"
                        loading="lazy"
                        class="mx-auto h-auto max-h-[520px]
                               max-w-full object-contain"
                    >
                </div>

                @if(!empty($item['caption']))
                    <figcaption
                        class="mt-3 border-t border-gray-100 pt-3
                               text-center text-xs leading-5
                               text-gray-500"
                    >
                        {{ $item['caption'] }}
                    </figcaption>
                @endif

            </figure>

        @endif

    @empty

        <div
            class="rounded-2xl border border-dashed
                   border-gray-600 bg-[#333] p-8 text-center"
        >

            <div class="mb-3 text-4xl">📚</div>

            <h3 class="text-sm font-bold text-white">
                Materi Belum Tersedia
            </h3>

            <p class="mt-2 text-xs text-gray-400">
                Guru belum menambahkan konten bacaan.
            </p>

        </div>

    @endforelse

    {{-- ==========================================
         CATATAN / TIPS GURU
    ========================================== --}}
    @if(trim($tips) !== '')

        <div
            class="rounded-xl border border-amber-400/20
                   bg-amber-400/10 p-4 sm:p-5"
        >

            <div class="mb-3 flex items-center gap-2">

                <span class="text-xl">💡</span>

                <h3
                    class="text-xs font-extrabold
                           uppercase tracking-wider
                           text-amber-300"
                >
                    Tips Penting
                </h3>

            </div>

            <p
                class="whitespace-pre-line text-sm
                       leading-7 text-amber-50"
            >{{ $tips }}</p>

        </div>

    @endif

    {{-- ==========================================
         PETUNJUK
    ========================================== --}}
    <div
        class="flex items-center gap-3
               rounded-xl border border-white/5
               bg-white/[0.03] px-4 py-3"
    >

        <span class="text-lg">✨</span>

        <p class="text-xs leading-5 text-gray-400">
            Setelah memahami materi, tekan
            <strong class="text-yellow-400">LANJUT</strong>
            untuk menuju aktivitas berikutnya.
        </p>

    </div>

</div>

{{-- ==========================================
     CSS KONTEN TRIX
========================================== --}}
@once
<style>
    .bacaan-student-content {
        overflow-wrap: anywhere;
    }

    .bacaan-student-content h1 {
        margin-bottom: 1rem;
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1.8;
    }

    .bacaan-student-content h2 {
        margin-bottom: 0.75rem;
        color: #ffffff;
        font-size: 1.25rem;
        font-weight: 800;
        line-height: 1.7;
    }

    .bacaan-student-content h3 {
        margin-bottom: 0.75rem;
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .bacaan-student-content p {
        margin-bottom: 0.85rem;
    }

    .bacaan-student-content strong,
    .bacaan-student-content b {
        color: #ffffff;
        font-weight: 800;
    }

    .bacaan-student-content em,
    .bacaan-student-content i {
        font-style: italic;
    }

    .bacaan-student-content a {
        color: #93c5fd;
        text-decoration: underline;
    }

    .bacaan-student-content ul {
        margin: 0.75rem 0;
        padding-left: 1.5rem;
        list-style-type: disc;
    }

    .bacaan-student-content ol {
        margin: 0.75rem 0;
        padding-left: 1.5rem;
        list-style-type: decimal;
    }

    .bacaan-student-content li {
        margin-bottom: 0.4rem;
    }

    .bacaan-student-content blockquote {
        margin: 1rem 0;
        border-left: 4px solid #facc15;
        padding-left: 1rem;
        color: #fde68a;
        font-style: italic;
    }

    .bacaan-student-content pre {
        margin: 1rem 0;
        overflow-x: auto;
        border: 1px solid #444;
        border-radius: 0.75rem;
        background: #171717;
        padding: 1rem;
        color: #86efac;
        font-family: monospace;
        font-size: 0.8rem;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .bacaan-student-content code {
        border-radius: 0.3rem;
        background: #202020;
        padding: 0.15rem 0.35rem;
        color: #86efac;
        font-family: monospace;
    }

    .bacaan-student-content hr {
        margin: 1.5rem 0;
        border-color: #555;
    }

    .bacaan-student-content img {
        max-width: 100%;
        height: auto;
    }

    .bacaan-student-content > :last-child {
        margin-bottom: 0;
    }
</style>
@endonce
