
@extends('guru.layouts.app')

@section('title', 'Detail Ruang Ujian')

@section('content')

@php
    $statusConfig = [
        'draft' => [
            'label' => 'Draft',
            'class' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'dot' => 'bg-amber-500',
        ],
        'aktif' => [
            'label' => 'Aktif',
            'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'dot' => 'bg-emerald-500',
        ],
        'nonaktif' => [
            'label' => 'Nonaktif',
            'class' => 'bg-gray-100 text-gray-600 ring-gray-200',
            'dot' => 'bg-gray-400',
        ],
    ];

    $status = $statusConfig[$ruangUjian->status] ?? $statusConfig['draft'];

    $totalSoal = $ruangUjian->soal->count();
    $totalHasil = $ruangUjian->hasilUjian->count();
    $totalBenar = $ruangUjian->hasilUjian->sum('jumlah_benar');
    $totalExp = $totalExp ?? $ruangUjian->soal->sum('exp');

    $totalEsaiBelumDinilai = $ruangUjian->hasilUjian
        ->flatMap(fn($hasil) => $hasil->jawaban ?? collect())
        ->filter(fn($jawaban) =>
            optional($jawaban->soal)->tipe === 'esai'
            && $jawaban->skor_esai === null
        )->count();

    $totalEsaiSudahDinilai = $ruangUjian->hasilUjian
        ->flatMap(fn($hasil) => $hasil->jawaban ?? collect())
        ->filter(fn($jawaban) =>
            optional($jawaban->soal)->tipe === 'esai'
            && $jawaban->skor_esai !== null
        )->count();
@endphp

<div class="w-full space-y-6 pb-10">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('guru.ruang-ujian.index') }}"
                   class="transition hover:text-indigo-600">
                    Ruang Ujian
                </a>

                <i class="fa-solid fa-chevron-right text-[10px]"></i>

                <span class="font-medium text-indigo-600">Detail</span>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-bold tracking-tight text-gray-800">
                    {{ $ruangUjian->judul }}
                </h1>

                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $status['class'] }}">
                    <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                    {{ $status['label'] }}
                </span>
            </div>

            <p class="mt-1 text-sm text-gray-500">
                Kelola informasi, soal, dan penilaian hasil pengerjaan siswa.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('guru.ruang-ujian.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:bg-gray-50">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>

            <a href="{{ route('guru.ruang-ujian.edit', $ruangUjian->id) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit Ruang Ujian
            </a>
        </div>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
            <i class="fa-solid fa-circle-check text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <i class="fa-solid fa-circle-exclamation text-lg"></i>
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <div class="mb-2 flex items-center gap-2 font-bold">
                <i class="fa-solid fa-circle-exclamation"></i>
                Terdapat kesalahan:
            </div>

            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400">Total Soal</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-800">
                        {{ $totalSoal }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">Soal dalam ruang ujian</p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-file-circle-question text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400">Total EXP</p>
                    <h3 class="mt-2 text-3xl font-bold text-amber-500">
                        {{ number_format($totalExp) }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">Akumulasi EXP seluruh soal</p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-500">
                    <i class="fa-solid fa-star text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400">Pengerjaan Siswa</p>
                    <h3 class="mt-2 text-3xl font-bold text-blue-600">
                        {{ $totalHasil }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">Total percobaan tercatat</p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400">Jawaban Benar</p>
                    <h3 class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ $totalBenar }}
                    </h3>
                    <p class="mt-1 text-xs text-gray-400">Akumulasi jawaban benar</p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="fa-solid fa-check-double text-xl"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- INFORMASI DAN PENGATURAN --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm xl:col-span-2">

            <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-5 sm:px-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <div>
                    <h2 class="text-base font-bold text-gray-800">
                        Informasi Ruang Ujian
                    </h2>
                    <p class="mt-0.5 text-xs text-gray-400">
                        Informasi umum ruang ujian ini.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">

                <div>
                    <p class="text-xs font-medium text-gray-400">Judul Ruang Ujian</p>
                    <p class="mt-2 text-sm font-semibold text-gray-800">
                        {{ $ruangUjian->judul }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-gray-400">Status</p>
                    <span class="mt-2 inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $status['class'] }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $status['dot'] }}"></span>
                        {{ $status['label'] }}
                    </span>
                </div>

                <div class="sm:col-span-2">
                    <p class="text-xs font-medium text-gray-400">Deskripsi</p>
                    <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-gray-600">
                        {{ $ruangUjian->deskripsi ?: 'Belum ada deskripsi ruang ujian.' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-gray-400">Durasi Ujian</p>
                    <p class="mt-2 text-sm font-semibold text-gray-800">
                        <i class="fa-regular fa-clock mr-1.5 text-indigo-500"></i>
                        {{ $ruangUjian->durasi_menit }} menit
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-gray-400">Maksimal Percobaan</p>
                    <p class="mt-2 text-sm font-semibold text-gray-800">
                        <i class="fa-solid fa-rotate mr-1.5 text-indigo-500"></i>
                        {{ $ruangUjian->maksimal_percobaan }} kali
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-gray-400">Pengacakan Soal</p>
                    <p class="mt-2 text-sm font-semibold {{ $ruangUjian->acak_soal ? 'text-emerald-600' : 'text-gray-500' }}">
                        {{ $ruangUjian->acak_soal ? 'Aktif' : 'Tidak aktif' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium text-gray-400">Pengacakan Jawaban</p>
                    <p class="mt-2 text-sm font-semibold {{ $ruangUjian->acak_jawaban ? 'text-emerald-600' : 'text-gray-500' }}">
                        {{ $ruangUjian->acak_jawaban ? 'Aktif' : 'Tidak aktif' }}
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-4 sm:col-span-2">
                    <p class="text-xs text-gray-400">
                        Dibuat pada
                        <span class="font-medium text-gray-600">
                            {{ $ruangUjian->created_at?->format('d M Y, H:i') ?? '-' }}
                        </span>
                    </p>
                </div>

            </div>
        </div>

        {{-- INFORMASI EXP --}}
        <div class="rounded-2xl border border-amber-100 bg-gradient-to-br from-amber-50 to-white p-5 shadow-sm">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                <i class="fa-solid fa-trophy text-lg"></i>
            </div>

            <h3 class="mt-4 text-base font-bold text-gray-800">
                Total EXP Ujian
            </h3>

            <p class="mt-1 text-xs leading-relaxed text-gray-500">
                Total EXP yang dapat diperoleh siswa jika menjawab seluruh soal dengan benar.
            </p>

            <div class="mt-5 rounded-xl border border-amber-100 bg-white p-4">
                <p class="text-xs font-medium text-gray-400">Maksimal EXP</p>

                <div class="mt-2 flex items-center gap-2">
                    <span class="text-3xl font-extrabold text-amber-500">
                        {{ number_format($totalExp) }}
                    </span>
                    <i class="fa-solid fa-star text-xl text-amber-400"></i>
                </div>
            </div>

            <div class="mt-4 flex items-start gap-2 text-xs leading-relaxed text-amber-700">
                <i class="fa-solid fa-circle-info mt-0.5"></i>
                <p>
                    EXP hanya diberikan berdasarkan jawaban yang benar sesuai nilai EXP setiap soal.
                </p>
            </div>

        </div>
    </div>

    {{-- DAFTAR SOAL --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-gray-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">

            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i class="fa-solid fa-list-check"></i>
                </div>

                <div>
                    <h2 class="text-base font-bold text-gray-800">
                        Daftar Soal Ujian
                    </h2>
                    <p class="mt-0.5 text-xs text-gray-400">
                        {{ $totalSoal }} soal telah ditambahkan.
                    </p>
                </div>
            </div>

            <a href="{{ route('guru.ruang-ujian.soal.create', $ruangUjian->id) }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <i class="fa-solid fa-plus"></i>
                Tambah Soal
            </a>
        </div>

        @if ($ruangUjian->soal->count() > 0)

            <div class="divide-y divide-gray-100">

                @foreach ($ruangUjian->soal as $index => $soal)

                    <div class="flex flex-col gap-4 px-5 py-5 transition hover:bg-gray-50/70 sm:flex-row sm:items-start sm:px-6">

                        {{-- NOMOR SOAL --}}
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-sm font-bold text-indigo-600">
                            {{ $index + 1 }}
                        </div>

                        {{-- INFORMASI SOAL --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="rounded-md bg-gray-100 px-2 py-1 text-[10px] font-semibold uppercase tracking-wide text-gray-500">
                                    {{ str_replace('_', ' ', $soal->tipe) }}
                                </span>

                                <span class="rounded-md bg-amber-50 px-2 py-1 text-[10px] font-semibold text-amber-600">
                                    <i class="fa-solid fa-star mr-1"></i>
                                    {{ $soal->exp }} EXP
                                </span>

                                @if ($soal->tipe === 'esai')
                                    <span class="rounded-md bg-purple-50 px-2 py-1 text-[10px] font-semibold text-purple-600">
                                        Esai - Maks. {{ $soal->skor_maksimal ?? 100 }} poin
                                    </span>
                                @endif

                            </div>

                            <div class="mt-3 whitespace-pre-line text-sm leading-relaxed text-gray-700">
                                {{ $soal->pertanyaan }}
                            </div>

                            {{-- PILIHAN JAWABAN --}}
                            @if (is_array($soal->opsi) && count($soal->opsi) > 0)

                                <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">

                                    @foreach ($soal->opsi as $opsi)

                                        <div class="flex items-start gap-2 rounded-lg border border-gray-100 bg-gray-50 px-3 py-2 text-xs text-gray-600">

                                            <span class="font-bold text-indigo-500">
                                                {{ $opsi['kode'] ?? '' }}.
                                            </span>

                                            <span>
                                                {{ $opsi['teks'] ?? '' }}
                                            </span>

                                            @if (($opsi['kode'] ?? null) == $soal->jawaban_benar)
                                                <span class="ml-auto text-emerald-600">
                                                    <i class="fa-solid fa-check-circle"></i>
                                                </span>
                                            @endif

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                            {{-- KUNCI JAWABAN ESAI --}}
                            @if ($soal->tipe === 'esai' && $soal->jawaban_acuan)
                                <div class="mt-3 rounded-lg border border-indigo-100 bg-indigo-50/50 p-3">
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wide text-indigo-600">
                                        Jawaban Acuan
                                    </p>

                                    <p class="whitespace-pre-line text-xs leading-relaxed text-gray-600">
                                        {{ $soal->jawaban_acuan }}
                                    </p>
                                </div>
                            @endif

                            {{-- PEMBAHASAN --}}
                            @if ($soal->pembahasan)
                                <div class="mt-3 rounded-lg border border-emerald-100 bg-emerald-50/50 p-3">
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-wide text-emerald-600">
                                        Pembahasan
                                    </p>

                                    <p class="whitespace-pre-line text-xs leading-relaxed text-gray-600">
                                        {{ $soal->pembahasan }}
                                    </p>
                                </div>
                            @endif

                        </div>

                        {{-- TOMBOL AKSI --}}
                        <div class="flex shrink-0 items-center gap-2 sm:justify-end">

                            <a href="{{ route('guru.ruang-ujian.soal.edit', [
                                    $ruangUjian->id,
                                    $soal->id
                                ]) }}"
                               class="inline-flex items-center gap-2 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-600 transition hover:border-amber-300 hover:bg-amber-100">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Edit
                            </a>

                            <form action="{{ route('guru.ruang-ujian.soal.destroy', [
                                        $ruangUjian->id,
                                        $soal->id
                                    ]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal nomor {{ $index + 1 }}?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 transition hover:border-red-300 hover:bg-red-100">
                                    <i class="fa-solid fa-trash-can"></i>
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach
            </div>

            {{-- RINGKASAN SOAL --}}
            <div class="border-t border-gray-100 bg-gray-50/50 px-5 py-4 sm:px-6">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <p class="text-xs text-gray-500">
                        Total {{ $totalSoal }} soal
                    </p>

                    <p class="text-sm font-bold text-amber-600">
                        {{ number_format($totalExp) }} EXP
                    </p>
                </div>
            </div>

        @else

            <div class="px-5 py-14 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-400">
                    <i class="fa-solid fa-file-circle-question text-2xl"></i>
                </div>

                <h3 class="mt-4 text-base font-bold text-gray-800">
                    Belum Ada Soal
                </h3>

                <p class="mx-auto mt-2 max-w-sm text-sm leading-relaxed text-gray-400">
                    Ruang ujian ini belum memiliki soal. Tambahkan soal agar ujian dapat digunakan oleh siswa.
                </p>

                <a href="{{ route('guru.ruang-ujian.soal.create', $ruangUjian->id) }}"
                   class="mt-5 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    <i class="fa-solid fa-plus"></i>
                    Tambahkan Soal Pertama
                </a>

            </div>

        @endif
    </div>

    {{-- HASIL PENGERJAAN SISWA --}}
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

        {{-- HEADER HASIL --}}
        <div class="border-b border-gray-100 px-5 py-5 sm:px-6">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>

                    <div>
                        <h2 class="text-base font-bold text-gray-800">
                            Hasil Pengerjaan Siswa
                        </h2>

                        <p class="mt-0.5 text-xs text-gray-400">
                            Periksa jawaban dan lakukan penilaian esai siswa.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">

                    <div class="rounded-lg bg-emerald-50 px-3 py-2">
                        <p class="text-[10px] font-medium text-emerald-600">
                            Esai Dinilai
                        </p>
                        <p class="text-sm font-bold text-emerald-700">
                            {{ $totalEsaiSudahDinilai }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-amber-50 px-3 py-2">
                        <p class="text-[10px] font-medium text-amber-600">
                            Belum Dinilai
                        </p>
                        <p class="text-sm font-bold text-amber-700">
                            {{ $totalEsaiBelumDinilai }}
                        </p>
                    </div>

                </div>

            </div>
        </div>

        @if ($ruangUjian->hasilUjian->count() > 0)

            <div class="overflow-x-auto">

                <table class="w-full min-w-[950px] text-left">

                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                Siswa
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                Benar
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                Salah
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                Nilai
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                EXP
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                Status
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                Waktu
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-gray-400">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @foreach ($ruangUjian->hasilUjian as $hasil)

                            @php
                                $jawabanSiswa = $hasil->jawaban ?? collect();

                                $jawabanEsai = $jawabanSiswa->filter(function ($item) {
                                    return optional($item->soal)->tipe === 'esai';
                                });

                                $esaiBelumDinilai = $jawabanEsai->filter(function ($item) {
                                    return $item->skor_esai === null;
                                })->count();

                                $esaiSudahDinilai = $jawabanEsai->count() - $esaiBelumDinilai;

                                $semuaEsaiDinilai = $esaiBelumDinilai === 0;
                                $idDetail = 'detail-penilaian-' . $hasil->id;
                            @endphp

                            {{-- BARIS RINGKASAN SISWA --}}
                            <tr class="transition hover:bg-gray-50">

                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600">
                                            {{ strtoupper(substr($hasil->siswa->name ?? 'S', 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-gray-700">
                                                {{ $hasil->siswa->name ?? 'Siswa tidak ditemukan' }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                {{ $hasil->created_at?->format('d M Y') ?? '-' }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-5 py-4 text-sm font-semibold text-emerald-600">
                                    {{ $hasil->jumlah_benar ?? 0 }}
                                </td>

                                <td class="px-5 py-4 text-sm font-semibold text-red-500">
                                    {{ $hasil->jumlah_salah ?? 0 }}
                                </td>

                                <td class="px-5 py-4">
                                    <span class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-600">
                                        {{ number_format((float) $hasil->nilai, 2) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm font-bold text-amber-500">
                                    +{{ $hasil->exp_diperoleh ?? 0 }}
                                </td>

                                <td class="px-5 py-4">

                                    @if ($hasil->status === 'selesai')

                                        @if ($semuaEsaiDinilai)
                                            <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600">
                                                Penilaian Lengkap
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-600">
                                                Menunggu Penilaian
                                            </span>
                                        @endif

                                    @else

                                        <span class="inline-flex rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600">
                                            Berlangsung
                                        </span>

                                    @endif

                                </td>

                                <td class="px-5 py-4 text-xs text-gray-500">
                                    {{ $hasil->finished_at?->format('d M Y H:i') ?? '-' }}
                                </td>

                                <td class="px-5 py-4">

                                    @if ($hasil->status === 'selesai')

                                        <button type="button"
                                                onclick="togglePenilaian('{{ $idDetail }}', this)"
                                                class="inline-flex items-center gap-2 rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-2 text-xs font-semibold text-indigo-600 transition hover:bg-indigo-100">

                                            <i class="fa-solid fa-eye"></i>
                                            Periksa Jawaban

                                        </button>

                                    @else

                                        <span class="text-xs text-gray-400">
                                            Belum selesai
                                        </span>

                                    @endif

                                </td>

                            </tr>

                            {{-- DETAIL JAWABAN SISWA --}}
                            @if ($hasil->status === 'selesai')

                                <tr id="{{ $idDetail }}" class="hidden bg-slate-50/80">

                                    <td colspan="8" class="px-4 py-5 sm:px-6">

                                        <div class="mx-auto max-w-5xl space-y-5">

                                            {{-- INFORMASI DETAIL --}}
                                            <div class="flex flex-col gap-3 rounded-xl border border-indigo-100 bg-white p-4 sm:flex-row sm:items-center sm:justify-between">

                                                <div>
                                                    <h3 class="text-sm font-bold text-gray-800">
                                                        Detail Jawaban:
                                                        {{ $hasil->siswa->name ?? 'Siswa' }}
                                                    </h3>

                                                    <p class="mt-1 text-xs text-gray-400">
                                                        {{ $jawabanSiswa->count() }} jawaban tercatat.
                                                    </p>
                                                </div>

                                                <div class="flex flex-wrap gap-2">

                                                    <span class="rounded-lg bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700">
                                                        {{ $esaiSudahDinilai }} Esai Dinilai
                                                    </span>

                                                    <span class="rounded-lg bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700">
                                                        {{ $esaiBelumDinilai }} Belum Dinilai
                                                    </span>

                                                </div>

                                            </div>

                                            {{-- FORM PENILAIAN --}}
                                            <form action="{{ route('guru.ruang-ujian.penilaian.simpan', [
                                                        'ruangUjian' => $ruangUjian->id,
                                                        'hasilUjian' => $hasil->id
                                                    ]) }}"
                                                  method="POST">

                                                @csrf

                                                <div class="space-y-4">

                                                    @forelse ($jawabanSiswa->sortBy(fn($item) => optional($item->soal)->urutan ?? 0) as $nomor => $jawaban)

                                                        @php
                                                            $soal = $jawaban->soal;
                                                        @endphp

                                                        @if ($soal)

                                                            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">

                                                                {{-- HEADER SOAL --}}
                                                                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 bg-gray-50 px-4 py-3">

                                                                    <div class="flex items-center gap-2">

                                                                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-100 text-xs font-bold text-indigo-600">
                                                                            {{ $nomor + 1 }}
                                                                        </span>

                                                                        <span class="text-xs font-bold text-gray-700">
                                                                            Soal {{ $soal->urutan ?? ($nomor + 1) }}
                                                                        </span>

                                                                        <span class="rounded-md bg-gray-200 px-2 py-1 text-[10px] font-semibold uppercase text-gray-600">
                                                                            {{ str_replace('_', ' ', $soal->tipe) }}
                                                                        </span>

                                                                    </div>

                                                                    @if ($soal->tipe === 'esai')

                                                                        @if ($jawaban->skor_esai !== null)

                                                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold text-emerald-700">
                                                                                <i class="fa-solid fa-check-circle mr-1"></i>
                                                                                Sudah Dinilai
                                                                            </span>

                                                                        @else

                                                                            <span class="rounded-full bg-amber-100 px-3 py-1 text-[10px] font-bold text-amber-700">
                                                                                <i class="fa-solid fa-clock mr-1"></i>
                                                                                Belum Dinilai
                                                                            </span>

                                                                        @endif

                                                                    @else

                                                                        @if ($jawaban->benar)
                                                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold text-emerald-700">
                                                                                <i class="fa-solid fa-check mr-1"></i>
                                                                                Benar
                                                                            </span>
                                                                        @else
                                                                            <span class="rounded-full bg-red-100 px-3 py-1 text-[10px] font-bold text-red-700">
                                                                                <i class="fa-solid fa-xmark mr-1"></i>
                                                                                Salah
                                                                            </span>
                                                                        @endif

                                                                    @endif

                                                                </div>

                                                                <div class="space-y-4 p-4">

                                                                    {{-- PERTANYAAN --}}
                                                                    <div>
                                                                        <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                                                            Pertanyaan
                                                                        </p>

                                                                        <div class="whitespace-pre-line text-sm leading-relaxed text-gray-700">
                                                                            {{ $soal->pertanyaan }}
                                                                        </div>
                                                                    </div>

                                                                    {{-- JAWABAN SISWA --}}
                                                                    <div class="rounded-lg border border-blue-100 bg-blue-50/60 p-3">

                                                                        <p class="mb-2 flex items-center gap-2 text-[10px] font-bold uppercase tracking-wider text-blue-600">
                                                                            <i class="fa-solid fa-user-graduate"></i>
                                                                            Jawaban Siswa
                                                                        </p>

                                                                        <div class="whitespace-pre-line text-sm leading-relaxed text-gray-700">
                                                                            {{ filled($jawaban->jawaban_siswa) ? $jawaban->jawaban_siswa : 'Siswa tidak memberikan jawaban.' }}
                                                                        </div>

                                                                    </div>

                                                                    {{-- JAWABAN PILIHAN GANDA --}}
                                                                    @if ($soal->tipe !== 'esai')

                                                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                                                                            <div class="rounded-lg border border-gray-100 bg-gray-50 p-3">

                                                                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                                                                    Kunci Jawaban
                                                                                </p>

                                                                                <p class="text-sm font-bold text-emerald-600">
                                                                                    {{ $soal->jawaban_benar ?? '-' }}
                                                                                </p>

                                                                            </div>

                                                                            <div class="rounded-lg border border-gray-100 bg-gray-50 p-3">

                                                                                <p class="mb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">
                                                                                    Jawaban Siswa
                                                                                </p>

                                                                                <p class="text-sm font-bold {{ $jawaban->benar ? 'text-emerald-600' : 'text-red-500' }}">
                                                                                    {{ $jawaban->jawaban_siswa ?? '-' }}
                                                                                </p>

                                                                            </div>

                                                                        </div>

                                                                    @endif

                                                                    {{-- PENILAIAN ESAI --}}
                                                                    @if ($soal->tipe === 'esai')

                                                                        {{-- JAWABAN ACUAN --}}
                                                                        @if ($soal->jawaban_acuan)

                                                                            <div class="rounded-lg border border-indigo-100 bg-indigo-50/50 p-3">

                                                                                <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-indigo-600">
                                                                                    <i class="fa-solid fa-book-open mr-1"></i>
                                                                                    Jawaban Acuan
                                                                                </p>

                                                                                <div class="whitespace-pre-line text-xs leading-relaxed text-gray-600">
                                                                                    {{ $soal->jawaban_acuan }}
                                                                                </div>

                                                                            </div>

                                                                        @endif

                                                                        {{-- RUBRIK PENILAIAN --}}
                                                                        @if (is_array($soal->rubrik_penilaian) && count($soal->rubrik_penilaian) > 0)

                                                                            <div class="rounded-lg border border-purple-100 bg-purple-50/50 p-3">

                                                                                <p class="mb-2 text-[10px] font-bold uppercase tracking-wider text-purple-600">
                                                                                    <i class="fa-solid fa-list-check mr-1"></i>
                                                                                    Rubrik Penilaian
                                                                                </p>

                                                                                <div class="space-y-2">

                                                                                    @foreach ($soal->rubrik_penilaian as $rubrik)

                                                                                        <div class="flex items-start gap-2 text-xs text-gray-600">

                                                                                            <i class="fa-solid fa-circle-check mt-0.5 text-purple-500"></i>

                                                                                            <span>
                                                                                                @if (is_array($rubrik))
                                                                                                    {{ $rubrik['indikator'] ?? $rubrik['kriteria'] ?? json_encode($rubrik) }}

                                                                                                    @if (isset($rubrik['skor']))
                                                                                                        <span class="font-semibold text-purple-600">
                                                                                                            ({{ $rubrik['skor'] }} poin)
                                                                                                        </span>
                                                                                                    @endif
                                                                                                @else
                                                                                                    {{ $rubrik }}
                                                                                                @endif
                                                                                            </span>

                                                                                        </div>

                                                                                    @endforeach

                                                                                </div>

                                                                            </div>

                                                                        @endif

                                                                        {{-- INPUT NILAI DAN CATATAN --}}
                                                                        <div class="rounded-xl border border-gray-200 bg-white p-4">

                                                                            <div class="mb-4 flex flex-wrap items-center justify-between gap-2">

                                                                                <div>
                                                                                    <h4 class="text-sm font-bold text-gray-800">
                                                                                        Penilaian Guru
                                                                                    </h4>

                                                                                    <p class="mt-1 text-xs text-gray-400">
                                                                                        Berikan skor berdasarkan jawaban dan rubrik.
                                                                                    </p>
                                                                                </div>

                                                                                <span class="rounded-lg bg-indigo-50 px-3 py-2 text-xs font-bold text-indigo-600">
                                                                                    Maks. {{ $soal->skor_maksimal ?? 100 }} poin
                                                                                </span>

                                                                            </div>

                                                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                                                                <div>

                                                                                    <label for="nilai-{{ $jawaban->id }}"
                                                                                           class="mb-2 block text-xs font-semibold text-gray-600">
                                                                                        Skor Esai
                                                                                    </label>

                                                                                    <div class="relative">

                                                                                        <input type="number"
                                                                                               id="nilai-{{ $jawaban->id }}"
                                                                                               name="nilai[{{ $jawaban->id }}]"
                                                                                               min="0"
                                                                                               max="{{ $soal->skor_maksimal ?? 100 }}"
                                                                                               step="0.01"
                                                                                               value="{{ old('nilai.' . $jawaban->id, $jawaban->skor_esai) }}"
                                                                                               placeholder="Masukkan skor"
                                                                                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-16 text-sm font-semibold text-gray-700 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">

                                                                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-gray-400">
                                                                                            Poin
                                                                                        </span>

                                                                                    </div>

                                                                                    @error('nilai.' . $jawaban->id)
                                                                                        <p class="mt-1 text-xs text-red-500">
                                                                                            {{ $message }}
                                                                                        </p>
                                                                                    @enderror

                                                                                </div>

                                                                                <div>

                                                                                    <label for="catatan-{{ $jawaban->id }}"
                                                                                           class="mb-2 block text-xs font-semibold text-gray-600">
                                                                                        Catatan Guru
                                                                                    </label>

                                                                                    <textarea id="catatan-{{ $jawaban->id }}"
                                                                                              name="catatan[{{ $jawaban->id }}]"
                                                                                              rows="3"
                                                                                              placeholder="Berikan masukan kepada siswa..."
                                                                                              class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-xs text-gray-700 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">{{ old('catatan.' . $jawaban->id, $jawaban->catatan_guru) }}</textarea>

                                                                                </div>

                                                                            </div>

                                                                            @if ($jawaban->dinilai_pada)
                                                                                <p class="mt-3 text-[10px] text-gray-400">
                                                                                    Terakhir dinilai:
                                                                                    {{ $jawaban->dinilai_pada->format('d M Y, H:i') }}
                                                                                </p>
                                                                            @endif

                                                                        </div>

                                                                    @endif

                                                                    {{-- EXP --}}
                                                                    @if ($soal->tipe !== 'esai')
                                                                        <div class="flex items-center justify-between text-xs">

                                                                            <span class="text-gray-400">
                                                                                EXP dari soal ini
                                                                            </span>

                                                                            <span class="font-bold {{ $jawaban->benar ? 'text-amber-500' : 'text-gray-400' }}">
                                                                                {{ $jawaban->benar ? '+' . ($jawaban->exp_diperoleh ?? $soal->exp) : '0' }} EXP
                                                                            </span>

                                                                        </div>
                                                                    @endif

                                                                </div>
                                                            </div>

                                                        @endif

                                                    @empty

                                                        <div class="rounded-xl border border-gray-200 bg-white p-8 text-center">
                                                            <i class="fa-solid fa-inbox text-2xl text-gray-300"></i>

                                                            <p class="mt-3 text-sm font-semibold text-gray-600">
                                                                Belum ada detail jawaban
                                                            </p>

                                                            <p class="mt-1 text-xs text-gray-400">
                                                                Data jawaban siswa belum tersedia.
                                                            </p>
                                                        </div>

                                                    @endforelse

                                                </div>

                                                {{-- TOMBOL SIMPAN PENILAIAN --}}
                                                @if ($jawabanEsai->count() > 0)

                                                    <div class="mt-5 flex flex-col gap-3 rounded-xl border border-indigo-100 bg-white p-4 sm:flex-row sm:items-center sm:justify-between">

                                                        <div>
                                                            <p class="text-sm font-bold text-gray-800">
                                                                Simpan Penilaian Esai
                                                            </p>

                                                            <p class="mt-1 text-xs text-gray-400">
                                                                {{ $esaiSudahDinilai }} dari {{ $jawabanEsai->count() }} jawaban esai sudah dinilai.
                                                            </p>
                                                        </div>

                                                        <button type="submit"
                                                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-700">

                                                            <i class="fa-solid fa-floppy-disk"></i>
                                                            Simpan Penilaian

                                                        </button>

                                                    </div>

                                                @else

                                                    <div class="mt-5 rounded-xl border border-emerald-100 bg-emerald-50 p-4">

                                                        <div class="flex items-start gap-3">
                                                            <i class="fa-solid fa-circle-check mt-0.5 text-emerald-600"></i>

                                                            <div>
                                                                <p class="text-sm font-bold text-emerald-700">
                                                                    Tidak Ada Jawaban Esai
                                                                </p>

                                                                <p class="mt-1 text-xs text-emerald-600">
                                                                    Seluruh soal pada ujian ini dinilai secara otomatis.
                                                                </p>
                                                            </div>
                                                        </div>

                                                    </div>

                                                @endif

                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @endif

                        @endforeach

                    </tbody>
                </table>

            </div>

        @else

            {{-- EMPTY STATE HASIL --}}
            <div class="px-5 py-12 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-50 text-gray-300">
                    <i class="fa-solid fa-chart-simple text-2xl"></i>
                </div>

                <h3 class="mt-4 text-sm font-bold text-gray-700">
                    Belum Ada Hasil Ujian
                </h3>

                <p class="mt-1 text-xs text-gray-400">
                    Hasil pengerjaan siswa akan ditampilkan di sini.
                </p>

            </div>

        @endif

    </div>

</div>

{{-- JAVASCRIPT DETAIL PENILAIAN --}}
<script>
    function togglePenilaian(id, button) {
        const detail = document.getElementById(id);

        if (!detail) return;

        const isHidden = detail.classList.contains('hidden');

        detail.classList.toggle('hidden');

        if (isHidden) {
            button.innerHTML = '<i class="fa-solid fa-eye-slash"></i> Tutup Detail';
            button.classList.remove('bg-indigo-50', 'text-indigo-600');
            button.classList.add('bg-gray-100', 'text-gray-600');
        } else {
            button.innerHTML = '<i class="fa-solid fa-eye"></i> Periksa Jawaban';
            button.classList.remove('bg-gray-100', 'text-gray-600');
            button.classList.add('bg-indigo-50', 'text-indigo-600');
        }
    }
</script>

@endsection
