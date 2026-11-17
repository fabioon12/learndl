
@extends('guru.layouts.app')

@section('title', 'Monitoring Tahapan')

@section('content')
@php
    /*
    |--------------------------------------------------------------------------
    | NORMALISASI DATA
    |--------------------------------------------------------------------------
    */

    $tipeTahapan = strtolower(str_replace(
        '_',
        '-',
        $tahapan->tipe ?? ''
    ));

    $konten = $tahapan->konten ?? [];

    $aktivitasSiswa = $aktivitasSiswa ?? collect();
    $jawabanSiswa = $jawabanSiswa ?? collect();

    $totalSiswa = $totalSiswa ?? $ruangBelajar->siswa->count();
    $totalDimulai = $totalDimulai ?? 0;
    $totalSelesai = $totalSelesai ?? 0;
    $totalBelumDimulai = $totalBelumDimulai ?? max(0, $totalSiswa - $totalDimulai);

    $persentaseSelesai = $persentaseSelesai ?? (
        $totalSiswa > 0
            ? round(($totalSelesai / $totalSiswa) * 100)
            : 0
    );

    /*
    |--------------------------------------------------------------------------
    | INFORMASI TIPE TAHAPAN
    |--------------------------------------------------------------------------
    */

    $daftarTipe = [
        'apersepsi' => [
            'label' => 'Apersepsi',
            'deskripsi' => 'Teks, pertanyaan pemantik, dan forum diskusi.',
            'icon' => 'fa-lightbulb',
            'warna' => 'amber',
        ],

        'ice-breaking' => [
            'label' => 'Ice Breaking',
            'deskripsi' => 'Aktivitas pembuka menggunakan video atau gambar.',
            'icon' => 'fa-gamepad',
            'warna' => 'blue',
        ],

        'jeda-hening' => [
            'label' => 'Jeda Hening & Check-in',
            'deskripsi' => 'Aktivitas kesadaran diri dan pernapasan.',
            'icon' => 'fa-spa',
            'warna' => 'purple',
        ],

        'pre-test' => [
            'label' => 'Pre-Test',
            'deskripsi' => 'Pengukuran kemampuan awal siswa.',
            'icon' => 'fa-clipboard-list',
            'warna' => 'indigo',
        ],

        'materi' => [
            'label' => 'Materi',
            'deskripsi' => 'Pemantauan akses dan penyelesaian materi.',
            'icon' => 'fa-book-open',
            'warna' => 'emerald',
        ],

        'lkpd' => [
            'label' => 'LKPD',
            'deskripsi' => 'Lembar kerja individu atau kelompok dan pengumpulan file.',
            'icon' => 'fa-file-upload',
            'warna' => 'orange',
        ],

        'evaluasi' => [
            'label' => 'Evaluasi',
            'deskripsi' => 'Pertanyaan evaluasi dan kendala yang dialami siswa.',
            'icon' => 'fa-circle-question',
            'warna' => 'rose',
        ],

        'kesimpulan' => [
            'label' => 'Kesimpulan',
            'deskripsi' => 'Penyusunan kesimpulan dan forum diskusi.',
            'icon' => 'fa-thumbtack',
            'warna' => 'cyan',
        ],

        'refleksi' => [
            'label' => 'Refleksi',
            'deskripsi' => 'Refleksi pembelajaran dan tingkat kepuasan siswa.',
            'icon' => 'fa-star',
            'warna' => 'yellow',
        ],

        'post-test' => [
            'label' => 'Post-Test',
            'deskripsi' => 'Pengukuran kemampuan siswa setelah pembelajaran.',
            'icon' => 'fa-flag-checkered',
            'warna' => 'teal',
        ],

        'tindak-lanjut' => [
            'label' => 'Tindak Lanjut',
            'deskripsi' => 'Aktivitas lanjutan berupa materi, proyek, dan pengumpulan tugas.',
            'icon' => 'fa-rocket',
            'warna' => 'violet',
        ],
    ];

    $infoTipe = $daftarTipe[$tipeTahapan] ?? [
        'label' => ucfirst(str_replace('-', ' ', $tipeTahapan)),
        'deskripsi' => 'Monitoring aktivitas pembelajaran siswa.',
        'icon' => $tahapan->icon ?? 'fa-book-open',
        'warna' => 'indigo',
    ];

    $icon = $tahapan->icon ?: $infoTipe['icon'];

    /*
    |--------------------------------------------------------------------------
    | WARNA STATUS
    |--------------------------------------------------------------------------
    */

    $statusConfig = [
        'completed' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'icon' => 'fa-check-circle',
        ],
        'selesai' => [
            'label' => 'Selesai',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
            'icon' => 'fa-check-circle',
        ],
        'in_progress' => [
            'label' => 'Sedang Dikerjakan',
            'class' => 'bg-blue-50 text-blue-700 border-blue-100',
            'icon' => 'fa-spinner',
        ],
        'started' => [
            'label' => 'Sedang Dikerjakan',
            'class' => 'bg-blue-50 text-blue-700 border-blue-100',
            'icon' => 'fa-spinner',
        ],
        'belum_dimulai' => [
            'label' => 'Belum Dimulai',
            'class' => 'bg-slate-100 text-slate-600 border-slate-200',
            'icon' => 'fa-clock',
        ],
        'pending' => [
            'label' => 'Menunggu',
            'class' => 'bg-amber-50 text-amber-700 border-amber-100',
            'icon' => 'fa-hourglass-half',
        ],
    ];
@endphp

<div class="min-h-screen bg-slate-50 pb-12">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-5 lg:px-8 py-6">

            {{-- BREADCRUMB --}}
            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400 mb-5">

                <a href="{{ route('guru.ruang-belajar.monitoring', $ruangBelajar->id) }}"
                   class="hover:text-indigo-600 transition">
                    Monitoring
                </a>

                <i class="fas fa-chevron-right text-[9px]"></i>

                <span class="text-indigo-600 font-bold">
                    Detail Tahapan
                </span>

            </div>

            {{-- HEADER CONTENT --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 shrink-0 rounded-2xl
                                bg-indigo-50 text-indigo-600
                                flex items-center justify-center text-2xl">
                        <i class="fas {{ $icon }}"></i>
                    </div>

                    <div class="min-w-0">

                        <div class="flex flex-wrap items-center gap-2 mb-1">

                            <span class="text-[10px] uppercase tracking-wider
                                         font-black text-indigo-500">
                                Monitoring Tahapan Pembelajaran
                            </span>

                            <span class="px-2 py-1 rounded-md bg-indigo-50
                                         text-indigo-600 text-[9px] font-black uppercase">
                                Tahapan {{ $tahapan->urutan ?? '-' }}
                            </span>

                        </div>

                        <h1 class="text-xl md:text-2xl font-black text-slate-800">
                            {{ $tahapan->judul_tahapan }}
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            {{ $ruangBelajar->judul }}
                        </p>

                    </div>

                </div>

                <a href="{{ route('guru.ruang-belajar.monitoring', $ruangBelajar->id) }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-3
                          rounded-xl border border-slate-200 bg-white
                          text-xs font-bold text-slate-600
                          hover:bg-slate-50 hover:border-slate-300 transition">

                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Monitoring

                </a>

            </div>

        </div>
    </div>


    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-7">

        {{-- ========================================================= --}}
        {{-- RINGKASAN STATISTIK --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-7">

            {{-- TOTAL SISWA --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5
                        hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                            Total Siswa
                        </p>

                        <h3 class="text-3xl font-black text-slate-800 mt-2 tabular-nums">
                            {{ $totalSiswa }}
                        </h3>

                        <p class="text-[11px] text-slate-400 mt-1">
                            Terdaftar di ruang belajar
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600
                                flex items-center justify-center">
                        <i class="fas fa-users text-xl"></i>
                    </div>

                </div>

            </div>


            {{-- SUDAH MEMULAI --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5
                        hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                            Sudah Memulai
                        </p>

                        <h3 class="text-3xl font-black text-blue-600 mt-2 tabular-nums">
                            {{ $totalDimulai }}
                        </h3>

                        <p class="text-[11px] text-slate-400 mt-1">
                            Memiliki aktivitas tahapan
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600
                                flex items-center justify-center">
                        <i class="fas fa-play-circle text-xl"></i>
                    </div>

                </div>

            </div>


            {{-- SELESAI --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5
                        hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                            Sudah Selesai
                        </p>

                        <h3 class="text-3xl font-black text-emerald-600 mt-2 tabular-nums">
                            {{ $totalSelesai }}
                        </h3>

                        <p class="text-[11px] text-slate-400 mt-1">
                            Menyelesaikan tahapan
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600
                                flex items-center justify-center">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>

                </div>

            </div>


            {{-- BELUM MEMULAI --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-5
                        hover:shadow-md transition">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                            Belum Memulai
                        </p>

                        <h3 class="text-3xl font-black text-amber-600 mt-2 tabular-nums">
                            {{ $totalBelumDimulai }}
                        </h3>

                        <p class="text-[11px] text-slate-400 mt-1">
                            Belum memiliki aktivitas
                        </p>
                    </div>

                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600
                                flex items-center justify-center">
                        <i class="fas fa-clock text-xl"></i>
                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- PROGRES PENYELESAIAN --}}
        {{-- ========================================================= --}}

        <div class="bg-white border border-slate-200 rounded-2xl p-5 md:p-6 mb-7">

            <div class="flex flex-col sm:flex-row sm:items-center
                        sm:justify-between gap-3 mb-4">

                <div>
                    <h2 class="font-black text-slate-800">
                        Progres Penyelesaian Tahapan
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Persentase siswa yang telah menyelesaikan tahapan ini.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-2xl font-black text-indigo-600 tabular-nums">
                        {{ $persentaseSelesai }}%
                    </span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">
                        Selesai
                    </span>
                </div>

            </div>

            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">

                <div class="h-full bg-gradient-to-r from-indigo-500 to-blue-500
                            rounded-full transition-all duration-700"
                     style="width: {{ min(100, max(0, $persentaseSelesai)) }}%">
                </div>

            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 mt-3">

                <p class="text-[11px] text-slate-400">
                    {{ $totalSelesai }} dari {{ $totalSiswa }} siswa telah menyelesaikan tahapan.
                </p>

                <p class="text-[11px] font-bold text-indigo-600">
                    {{ max(0, $totalSiswa - $totalSelesai) }} siswa belum selesai
                </p>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- INFORMASI TAHAPAN --}}
        {{-- ========================================================= --}}

        <div class="bg-white border border-slate-200 rounded-2xl p-5 md:p-6 mb-7">

            <div class="flex items-center gap-3 mb-5">

                <div class="w-10 h-10 rounded-xl bg-indigo-50
                            text-indigo-600 flex items-center justify-center">
                    <i class="fas fa-info-circle text-lg"></i>
                </div>

                <div>
                    <h2 class="font-black text-slate-800">
                        Informasi Tahapan
                    </h2>

                    <p class="text-xs text-slate-400 mt-1">
                        Informasi aktivitas pembelajaran yang sedang dimonitor.
                    </p>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Nama Tahapan
                    </p>

                    <p class="text-sm font-bold text-slate-700">
                        {{ $tahapan->judul_tahapan }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Jenis Tahapan
                    </p>

                    <div class="flex items-center gap-2">
                        <i class="fas {{ $infoTipe['icon'] }} text-indigo-500"></i>

                        <p class="text-sm font-bold text-slate-700">
                            {{ $infoTipe['label'] }}
                        </p>
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                        Penghargaan XP
                    </p>

                    <p class="text-sm font-bold text-amber-600">
                        <i class="fas fa-bolt mr-1"></i>
                        {{ $tahapan->xp_reward ?? 0 }} XP
                    </p>
                </div>

            </div>

            <div class="mt-5 pt-5 border-t border-slate-100">

                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                    Deskripsi Aktivitas
                </p>

                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $infoTipe['deskripsi'] }}
                </p>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- MONITORING SPESIFIK BERDASARKAN TIPE --}}
        {{-- ========================================================= --}}

        <div class="mb-7">

            @switch($tipeTahapan)

                @case('apersepsi')

                    @include('guru.ruang-belajar.monitoring.partials.apersepsi')

                    @break


                @case('ice-breaking')

                    @include('guru.ruang-belajar.monitoring.partials.ice-breaking')

                    @break


                @case('jeda-hening')

                    @include('guru.ruang-belajar.monitoring.partials.jeda-hening')

                    @break


                @case('pre-test')

                    @include('guru.ruang-belajar.monitoring.partials.pre-test')

                    @break


                @case('materi')

                    @include('guru.ruang-belajar.monitoring.partials.materi')

                    @break


                @case('lkpd')

                    @include('guru.ruang-belajar.monitoring.partials.lkpd')

                    @break


                @case('evaluasi')

                    @include('guru.ruang-belajar.monitoring.partials.evaluasi')

                    @break


                @case('kesimpulan')

                    @include('guru.ruang-belajar.monitoring.partials.kesimpulan')

                    @break


                @case('refleksi')

                    @include('guru.ruang-belajar.monitoring.partials.refleksi')

                    @break


                @case('post-test')

                    @include('guru.ruang-belajar.monitoring.partials.post-test')

                    @break


                @case('tindak-lanjut')

                    @include('guru.ruang-belajar.monitoring.partials.tindak-lanjut')

                    @break


                @default

                    @include('guru.ruang-belajar.monitoring.partials.belum-tersedia')

            @endswitch

        </div>


        {{-- ========================================================= --}}
        {{-- DAFTAR AKTIVITAS SISWA --}}
        {{-- ========================================================= --}}

        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

            {{-- HEADER --}}
            <div class="p-5 md:p-6 border-b border-slate-100">

                <div class="flex flex-col md:flex-row md:items-center
                            md:justify-between gap-3">

                    <div>
                        <h2 class="font-black text-slate-800">
                            Daftar Aktivitas Siswa
                        </h2>

                        <p class="text-xs text-slate-400 mt-1">
                            Pantau status partisipasi seluruh siswa pada tahapan ini.
                        </p>
                    </div>

                    <span class="inline-flex items-center gap-2 px-3 py-2
                                 rounded-lg bg-indigo-50 text-indigo-600
                                 text-xs font-black">
                        <i class="fas fa-users"></i>
                        {{ $totalSiswa }} Siswa
                    </span>

                </div>

            </div>


            {{-- DAFTAR SISWA --}}
            @if($aktivitasSiswa->isNotEmpty())

                <div class="divide-y divide-slate-100">

                    @foreach($aktivitasSiswa as $index => $aktivitas)

                        @php
                            $siswa = $aktivitas['siswa'] ?? null;
                            $status = strtolower($aktivitas['status'] ?? 'belum_dimulai');

                            $statusInfo = $statusConfig[$status] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $status)),
                                'class' => 'bg-slate-100 text-slate-600 border-slate-200',
                                'icon' => 'fa-circle',
                            ];

                            $namaSiswa = $siswa?->fullname ?? 'Siswa';
                            $inisial = strtoupper(substr($namaSiswa, 0, 1));
                            $waktuAktivitas = $aktivitas['updated_at'] ?? null;
                            $xpDidapat = $aktivitas['exp_didapat'] ?? 0;
                        @endphp

                        <div class="p-5 hover:bg-slate-50/70 transition">

                            <div class="flex flex-col md:flex-row
                                        md:items-center md:justify-between gap-4">

                                {{-- IDENTITAS SISWA --}}
                                <div class="flex items-center gap-3 min-w-0">

                                    <div class="w-10 h-10 shrink-0 rounded-xl
                                                bg-indigo-50 text-indigo-600
                                                flex items-center justify-center
                                                font-black text-sm">
                                        {{ $inisial }}
                                    </div>

                                    <div class="min-w-0">

                                        <h3 class="text-sm font-black text-slate-800 truncate">
                                            {{ $namaSiswa }}
                                        </h3>

                                        <p class="text-xs text-slate-400 mt-1 truncate">
                                            {{ $siswa?->email ?? 'Tidak ada email' }}
                                        </p>

                                    </div>

                                </div>


                                {{-- STATUS DAN INFORMASI --}}
                                <div class="flex flex-wrap items-center gap-2 md:justify-end">

                                    <span class="inline-flex items-center gap-1.5
                                                 px-3 py-2 rounded-lg border
                                                 text-[10px] font-black
                                                 {{ $statusInfo['class'] }}">

                                        <i class="fas {{ $statusInfo['icon'] }}"></i>

                                        {{ $statusInfo['label'] }}

                                    </span>

                                    @if($xpDidapat > 0)

                                        <span class="inline-flex items-center gap-1.5
                                                     px-3 py-2 rounded-lg
                                                     bg-amber-50 text-amber-700
                                                     text-[10px] font-black">

                                            <i class="fas fa-bolt"></i>
                                            {{ $xpDidapat }} XP

                                        </span>

                                    @endif

                                </div>

                            </div>


                            {{-- WAKTU AKTIVITAS --}}
                            <div class="mt-3 ml-0 md:ml-[52px]">

                                <p class="text-[11px] text-slate-400">

                                    <i class="far fa-clock mr-1"></i>

                                    Aktivitas terakhir:

                                    @if($waktuAktivitas)
                                        {{ \Carbon\Carbon::parse($waktuAktivitas)->format('d M Y, H:i') }}
                                    @else
                                        Belum ada aktivitas
                                    @endif

                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="py-16 px-5 text-center">

                    <div class="w-16 h-16 rounded-2xl bg-slate-100
                                text-slate-400 flex items-center justify-center
                                text-2xl mx-auto">
                        <i class="fas fa-users"></i>
                    </div>

                    <h3 class="text-sm font-black text-slate-700 mt-4">
                        Belum Ada Data Aktivitas
                    </h3>

                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto leading-relaxed">
                        Data aktivitas siswa akan ditampilkan setelah siswa
                        mulai mengakses atau mengerjakan tahapan pembelajaran ini.
                    </p>

                </div>

            @endif

        </div>


        {{-- ========================================================= --}}
        {{-- CATATAN MONITORING --}}
        {{-- ========================================================= --}}

        <div class="mt-6 bg-blue-50 border border-blue-100
                    rounded-2xl p-5 flex gap-3">

            <div class="w-9 h-9 shrink-0 rounded-xl bg-blue-100
                        text-blue-600 flex items-center justify-center">
                <i class="fas fa-lightbulb"></i>
            </div>

            <div>

                <p class="text-sm font-black text-blue-900">
                    Catatan Monitoring
                </p>

                <p class="text-xs text-blue-700 mt-1 leading-relaxed">
                    Halaman ini digunakan untuk memantau keterlibatan,
                    aktivitas, dan penyelesaian siswa pada tahapan
                    <strong>{{ $infoTipe['label'] }}</strong>.
                    Data yang ditampilkan mengikuti aktivitas yang telah
                    tersimpan oleh sistem.
                </p>

            </div>

        </div>

    </div>

</div>
@endsection
