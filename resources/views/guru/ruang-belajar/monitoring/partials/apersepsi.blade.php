@php
    /*
    |--------------------------------------------------------------------------
    | DATA APERSEPSI
    |--------------------------------------------------------------------------
    */

    $materiApersepsi = $konten['materi'] ?? [];
    $forumApersepsi = $konten['forum'] ?? [];

    $isiMateri = (string) data_get($materiApersepsi, 'isi', '');

    $judulForum = data_get(
        $forumApersepsi,
        'judul',
        'Forum Diskusi Apersepsi'
    );

    $pertanyaanForum = (string) data_get(
        $forumApersepsi,
        'pertanyaan',
        ''
    );

    $forumAktif = filter_var(
        data_get($forumApersepsi, 'aktif', false),
        FILTER_VALIDATE_BOOLEAN
    );

    $batasJawaban = data_get(
        $forumApersepsi,
        'batas_jawaban'
    );

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI URL STORAGE
    |--------------------------------------------------------------------------
    */

    $normalisasiUrl = function ($html) {
        return preg_replace_callback(
            '~https?://learndl\.fun/storage/([A-Za-z0-9/_\-.%]+)~i',
            fn ($match) => asset('public/storage/' . $match[1]),
            (string) $html
        );
    };

    $isiMateri = $normalisasiUrl($isiMateri);
    $pertanyaanForum = $normalisasiUrl($pertanyaanForum);

    /*
    |--------------------------------------------------------------------------
    | DATA JAWABAN SISWA
    |--------------------------------------------------------------------------
    */

    $jawabanSiswa = $jawabanSiswa ?? collect();
    $aktivitasSiswa = $aktivitasSiswa ?? collect();

    $jumlahMenjawab = $jawabanSiswa->count();

    $totalSiswaApersepsi = $totalSiswa ?? 0;

    $jumlahBelumMenjawab = max(
        0,
        $totalSiswaApersepsi - $jumlahMenjawab
    );

    $persentaseMenjawab = $totalSiswaApersepsi > 0
        ? round(($jumlahMenjawab / $totalSiswaApersepsi) * 100)
        : 0;

    $materiTersedia = trim(strip_tags($isiMateri)) !== ''
        || preg_match('/<(img|video|audio|iframe|figure|svg)\b/i', $isiMateri) === 1;

    $pertanyaanTersedia = trim(strip_tags($pertanyaanForum)) !== ''
        || preg_match('/<(img|video|audio|iframe|figure|svg)\b/i', $pertanyaanForum) === 1;
@endphp


{{-- =========================================================
     MONITORING APERSEPSI
========================================================= --}}

<div class="space-y-6">

    {{-- HEADER APERSEPSI --}}

    <div class="bg-white border border-slate-200 rounded-2xl p-5 md:p-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600
                            flex items-center justify-center text-xl">
                    <i class="fas fa-lightbulb"></i>
                </div>

                <div>
                    <span class="text-[10px] uppercase tracking-wider
                                 font-black text-amber-600">
                        Monitoring Aktivitas
                    </span>

                    <h3 class="text-lg font-black text-slate-800 mt-1">
                        Apersepsi
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Pemahaman awal dan partisipasi diskusi siswa.
                    </p>
                </div>

            </div>

            @if($forumAktif)
                <span class="inline-flex items-center gap-2 px-3 py-2
                             rounded-xl bg-emerald-50 text-emerald-700
                             text-[10px] font-black">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Forum Aktif
                </span>
            @else
                <span class="inline-flex items-center gap-2 px-3 py-2
                             rounded-xl bg-slate-100 text-slate-500
                             text-[10px] font-black">
                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                    Forum Tidak Aktif
                </span>
            @endif

        </div>

    </div>


    {{-- =====================================================
         STATISTIK PARTISIPASI FORUM
    ====================================================== --}}

    @if($forumAktif)

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- TOTAL SISWA MENJAWAB --}}

            <div class="bg-white border border-slate-200 rounded-2xl p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-bold text-slate-400">
                            Sudah Menjawab
                        </p>

                        <h3 class="text-3xl font-black text-emerald-600 mt-2 tabular-nums">
                            {{ $jumlahMenjawab }}
                        </h3>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-emerald-50
                                text-emerald-600 flex items-center justify-center">
                        <i class="fas fa-comment-dots text-lg"></i>
                    </div>

                </div>

                <p class="text-[11px] text-slate-400 mt-3">
                    Siswa telah mengirimkan jawaban forum.
                </p>

            </div>


            {{-- BELUM MENJAWAB --}}

            <div class="bg-white border border-slate-200 rounded-2xl p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-bold text-slate-400">
                            Belum Menjawab
                        </p>

                        <h3 class="text-3xl font-black text-amber-600 mt-2 tabular-nums">
                            {{ $jumlahBelumMenjawab }}
                        </h3>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-amber-50
                                text-amber-600 flex items-center justify-center">
                        <i class="fas fa-clock text-lg"></i>
                    </div>

                </div>

                <p class="text-[11px] text-slate-400 mt-3">
                    Siswa belum mengirimkan jawaban forum.
                </p>

            </div>


            {{-- PERSENTASE PARTISIPASI --}}

            <div class="bg-white border border-slate-200 rounded-2xl p-5">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-bold text-slate-400">
                            Partisipasi Forum
                        </p>

                        <h3 class="text-3xl font-black text-indigo-600 mt-2 tabular-nums">
                            {{ $persentaseMenjawab }}%
                        </h3>
                    </div>

                    <div class="w-11 h-11 rounded-xl bg-indigo-50
                                text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-chart-pie text-lg"></i>
                    </div>

                </div>

                <div class="w-full h-2 bg-slate-100 rounded-full mt-4 overflow-hidden">

                    <div class="h-full bg-indigo-500 rounded-full transition-all"
                         style="width: {{ $persentaseMenjawab }}%">
                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- =====================================================
         MATERI APERSEPSI
    ====================================================== --}}

    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

        <div class="p-5 md:p-6 border-b border-slate-100">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-xl bg-indigo-50
                            text-indigo-600 flex items-center justify-center">
                    <i class="fas fa-book-open"></i>
                </div>

                <div>
                    <h3 class="font-black text-slate-800">
                        Materi Apersepsi
                    </h3>

                    <p class="text-xs text-slate-400 mt-1">
                        Materi atau stimulus yang ditampilkan kepada siswa.
                    </p>
                </div>

            </div>

        </div>


        <div class="p-5 md:p-7">

            @if($materiTersedia)

                <div class="ap-monitoring-content text-sm text-slate-700 leading-relaxed">

                    {!! $isiMateri !!}

                </div>

            @else

                <div class="py-10 text-center">

                    <div class="w-14 h-14 rounded-2xl bg-slate-100
                                text-slate-400 flex items-center justify-center
                                mx-auto text-xl">
                        <i class="fas fa-book-open"></i>
                    </div>

                    <h4 class="font-bold text-slate-700 mt-3">
                        Belum Ada Materi
                    </h4>

                    <p class="text-xs text-slate-400 mt-1">
                        Guru belum menambahkan isi materi pada tahapan Apersepsi.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
         PERTANYAAN PEMANTIK
    ====================================================== --}}

    @if($forumAktif)

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

            <div class="p-5 md:p-6 border-b border-slate-100">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-violet-50
                                text-violet-600 flex items-center justify-center">
                        <i class="fas fa-circle-question"></i>
                    </div>

                    <div>
                        <h3 class="font-black text-slate-800">
                            Pertanyaan Pemantik
                        </h3>

                        <p class="text-xs text-slate-400 mt-1">
                            Pertanyaan yang diberikan guru kepada siswa.
                        </p>
                    </div>

                </div>

            </div>


            <div class="p-5 md:p-7">

                <div class="rounded-2xl bg-indigo-50 border border-indigo-100 p-5 md:p-6">

                    <div class="flex items-center gap-2 text-[10px]
                                font-black uppercase tracking-wider
                                text-indigo-600 mb-4">

                        <i class="fas fa-lightbulb"></i>
                        {{ $judulForum }}

                    </div>

                    @if($pertanyaanTersedia)

                        <div class="ap-monitoring-content text-sm md:text-base
                                    text-indigo-950 leading-relaxed font-medium">

                            {!! $pertanyaanForum !!}

                        </div>

                    @else

                        <p class="text-sm text-indigo-700">
                            Guru belum menambahkan pertanyaan pemantik.
                        </p>

                    @endif

                </div>


                @if($batasJawaban)

                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-400">

                        <i class="fas fa-info-circle"></i>

                        Batas jawaban:
                        <span class="font-bold text-slate-600">
                            {{ $batasJawaban }}
                        </span>

                    </div>

                @endif

            </div>

        </div>


        {{-- =====================================================
             DAFTAR JAWABAN SISWA
        ====================================================== --}}

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

            <div class="p-5 md:p-6 border-b border-slate-100">

                <div class="flex flex-col sm:flex-row sm:items-center
                            sm:justify-between gap-3">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-emerald-50
                                    text-emerald-600 flex items-center justify-center">
                            <i class="fas fa-comments"></i>
                        </div>

                        <div>
                            <h3 class="font-black text-slate-800">
                                Jawaban Siswa
                            </h3>

                            <p class="text-xs text-slate-400 mt-1">
                                Respons siswa terhadap pertanyaan pemantik.
                            </p>
                        </div>

                    </div>

                    <span class="px-3 py-2 rounded-lg bg-emerald-50
                                 text-emerald-700 text-xs font-black">
                        {{ $jumlahMenjawab }} Jawaban
                    </span>

                </div>

            </div>


            @if($jawabanSiswa->isNotEmpty())

                <div class="divide-y divide-slate-100">

                    @foreach($jawabanSiswa as $index => $item)

                        @php
                            $namaSiswa = $item->user?->fullname ?? 'Siswa';

                            $inisial = strtoupper(
                                mb_substr($namaSiswa, 0, 1)
                            );

                            $isiJawaban = data_get(
                                $item->jawaban,
                                'forum',
                                ''
                            );

                            $isiJawaban = $normalisasiUrl($isiJawaban);
                        @endphp

                        <article class="p-5 md:p-6">

                            {{-- IDENTITAS SISWA --}}

                            <div class="flex flex-wrap items-center
                                        justify-between gap-3 mb-4">

                                <div class="flex items-center gap-3 min-w-0">

                                    <div class="w-11 h-11 shrink-0 rounded-xl
                                                bg-indigo-50 text-indigo-600
                                                flex items-center justify-center
                                                font-black">
                                        {{ $inisial }}
                                    </div>

                                    <div class="min-w-0">

                                        <h4 class="text-sm font-black text-slate-800 truncate">
                                            {{ $namaSiswa }}
                                        </h4>

                                        <p class="text-[11px] text-slate-400 mt-1">
                                            Siswa
                                        </p>

                                    </div>

                                </div>


                                <div class="flex items-center gap-2">

                                    <span class="inline-flex items-center gap-1.5
                                                 px-2.5 py-1.5 rounded-lg
                                                 bg-emerald-50 text-emerald-700
                                                 text-[10px] font-black">

                                        <i class="fas fa-check-circle"></i>
                                        Terkirim

                                    </span>

                                    @if($item->updated_at)

                                        <span class="text-[10px] text-slate-400">
                                            {{ $item->updated_at->format('d M Y, H:i') }}
                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- ISI JAWABAN --}}

                            <div class="ml-0 md:ml-14 rounded-xl
                                        bg-slate-50 border border-slate-100
                                        p-4 md:p-5">

                                @if(trim(strip_tags($isiJawaban)) !== ''
                                    || preg_match('/<img\b/i', $isiJawaban))

                                    <div class="ap-monitoring-content text-sm text-slate-700 leading-relaxed">

                                        {!! $isiJawaban !!}

                                    </div>

                                @else

                                    <p class="text-xs text-slate-400 italic">
                                        Siswa belum mengisi isi jawaban.
                                    </p>

                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="py-14 px-5 text-center">

                    <div class="w-16 h-16 rounded-2xl bg-slate-100
                                text-slate-400 flex items-center justify-center
                                mx-auto text-2xl">
                        <i class="fas fa-comments"></i>
                    </div>

                    <h4 class="font-black text-slate-700 mt-4">
                        Belum Ada Jawaban
                    </h4>

                    <p class="text-xs text-slate-400 mt-2 max-w-sm mx-auto leading-relaxed">
                        Belum ada siswa yang mengirimkan jawaban pada
                        forum Apersepsi ini.
                    </p>

                </div>

            @endif

        </div>


        {{-- =====================================================
             DAFTAR SISWA BELUM MENJAWAB
        ====================================================== --}}

        @php
            $idSiswaSudahMenjawab = $jawabanSiswa
                ->map(fn ($item) => $item->user?->id)
                ->filter()
                ->values()
                ->all();

            $siswaBelumMenjawab = $aktivitasSiswa->filter(function ($item) use (
                $idSiswaSudahMenjawab
            ) {
                $idSiswa = $item['siswa']->id ?? null;

                return $idSiswa
                    && !in_array($idSiswa, $idSiswaSudahMenjawab);
            });
        @endphp


        @if($siswaBelumMenjawab->isNotEmpty())

            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

                <div class="p-5 md:p-6 border-b border-slate-100">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-amber-50
                                    text-amber-600 flex items-center justify-center">
                            <i class="fas fa-user-clock"></i>
                        </div>

                        <div>
                            <h3 class="font-black text-slate-800">
                                Siswa Belum Menjawab
                            </h3>

                            <p class="text-xs text-slate-400 mt-1">
                                Daftar siswa yang belum mengirimkan jawaban forum.
                            </p>
                        </div>

                    </div>

                </div>


                <div class="divide-y divide-slate-100">

                    @foreach($siswaBelumMenjawab as $aktivitas)

                        @php
                            $siswa = $aktivitas['siswa'] ?? null;
                            $nama = $siswa?->fullname ?? 'Siswa';
                        @endphp

                        <div class="flex items-center justify-between gap-3 p-4 md:px-6">

                            <div class="flex items-center gap-3 min-w-0">

                                <div class="w-9 h-9 rounded-lg bg-amber-50
                                            text-amber-600 flex items-center
                                            justify-center font-black text-xs">
                                    {{ strtoupper(mb_substr($nama, 0, 1)) }}
                                </div>

                                <div class="min-w-0">

                                    <p class="text-sm font-bold text-slate-700 truncate">
                                        {{ $nama }}
                                    </p>

                                    <p class="text-[10px] text-slate-400">
                                        {{ $siswa?->email ?? 'Siswa' }}
                                    </p>

                                </div>

                            </div>

                            <span class="shrink-0 px-2.5 py-1.5 rounded-lg
                                         bg-amber-50 text-amber-700
                                         text-[10px] font-black">
                                Belum Menjawab
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    @else

        {{-- FORUM TIDAK AKTIF --}}

        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center">

            <div class="w-16 h-16 rounded-2xl bg-slate-100
                        text-slate-400 flex items-center justify-center
                        mx-auto text-2xl">
                <i class="fas fa-comments"></i>
            </div>

            <h3 class="font-black text-slate-800 mt-4">
                Forum Diskusi Tidak Diaktifkan
            </h3>

            <p class="text-xs text-slate-400 mt-2 max-w-md mx-auto leading-relaxed">
                Tahapan Apersepsi ini hanya menggunakan materi sebagai
                stimulus pembelajaran. Tidak ada pertanyaan atau forum
                diskusi yang perlu dimonitor.
            </p>

        </div>

    @endif

</div>


{{-- =========================================================
     STYLE KONTEN T R I X
========================================================= --}}

<style>
    .ap-monitoring-content {
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .ap-monitoring-content p {
        margin-bottom: .75rem;
    }

    .ap-monitoring-content p:last-child {
        margin-bottom: 0;
    }

    .ap-monitoring-content h1,
    .ap-monitoring-content h2,
    .ap-monitoring-content h3 {
        font-weight: 800;
        line-height: 1.4;
        margin: 1rem 0 .6rem;
        color: #1e293b;
    }

    .ap-monitoring-content h1 {
        font-size: 1.5rem;
    }

    .ap-monitoring-content h2 {
        font-size: 1.25rem;
    }

    .ap-monitoring-content h3 {
        font-size: 1.1rem;
    }

    .ap-monitoring-content ul {
        list-style: disc;
        padding-left: 1.5rem;
        margin: .75rem 0;
    }

    .ap-monitoring-content ol {
        list-style: decimal;
        padding-left: 1.5rem;
        margin: .75rem 0;
    }

    .ap-monitoring-content li {
        display: list-item;
        margin-bottom: .35rem;
    }

    .ap-monitoring-content blockquote {
        border-left: 4px solid #818cf8;
        padding-left: 1rem;
        margin: 1rem 0;
        color: #64748b;
    }

    .ap-monitoring-content a {
        color: #4f46e5;
        text-decoration: underline;
        overflow-wrap: anywhere;
    }

    .ap-monitoring-content img {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: .85rem;
        margin: 1rem 0;
    }

    .ap-monitoring-content figure {
        max-width: 100%;
        margin: 1rem 0;
    }

    .ap-monitoring-content iframe,
    .ap-monitoring-content video {
        max-width: 100%;
    }

    .ap-monitoring-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
    }

    .ap-monitoring-content th,
    .ap-monitoring-content td {
        border: 1px solid #e2e8f0;
        padding: .65rem;
        text-align: left;
    }

    .ap-monitoring-content pre {
        white-space: pre-wrap;
        overflow-x: auto;
        background: #1e293b;
        color: #86efac;
        border-radius: .75rem;
        padding: 1rem;
        margin: 1rem 0;
    }
</style>
