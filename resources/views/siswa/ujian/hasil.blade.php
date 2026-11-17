
@extends('siswa.layouts.app')

@section('title', 'Hasil Ujian - ' . $hasilUjian->ruangUjian->judul)

@section('content')

@php
    $lulus = $semuaEsaiDinilai && $nilaiTampil >= 75;

    $jumlahPG = $jawabanPilihanGanda->count();
    $jumlahBenarPG = $jawabanPilihanGanda->where('benar', true)->count();
    $jumlahSalahPG = $jumlahPG - $jumlahBenarPG;

    $jumlahEsaiSelesai = $jumlahEsai - $jumlahEsaiBelumDinilai;

    $persentaseEsai = $jumlahEsai > 0
        ? ($jumlahEsaiSelesai / $jumlahEsai) * 100
        : 100;

    $namaGuru = $hasilUjian->ruangUjian->guru->name
        ?? $hasilUjian->ruangUjian->guru->fullname
        ?? 'Guru';

    $statusNilai = $semuaEsaiDinilai
        ? 'Nilai Akhir'
        : 'Nilai Sementara';
@endphp


<div class="min-h-screen pb-10">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="mb-6">

        <a
            href="{{ route('siswa.ujian.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition mb-5"
        >
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Ujian
        </a>


        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>

                <div class="flex items-center gap-2 mb-2">

                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <i class="fa-solid fa-circle-check mr-1"></i>
                        Ujian Selesai
                    </span>

                    @if(!$semuaEsaiDinilai)
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                            Menunggu Koreksi
                        </span>
                    @endif

                </div>


                <h1 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white">
                    Hasil Ujian
                </h1>


                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ $hasilUjian->ruangUjian->judul }}
                </p>

            </div>


            <div class="text-sm text-gray-500 dark:text-gray-400">

                <i class="fa-regular fa-calendar mr-1"></i>

                {{ $hasilUjian->finished_at?->translatedFormat('d F Y, H:i') ?? '-' }}

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- HERO NILAI --}}
    {{-- ===================================================== --}}
    <div class="relative overflow-hidden rounded-3xl mb-6
        @if(!$semuaEsaiDinilai)
            bg-gradient-to-br from-blue-600 via-indigo-600 to-violet-700
        @elseif($lulus)
            bg-gradient-to-br from-emerald-600 via-green-600 to-teal-700
        @else
            bg-gradient-to-br from-orange-500 via-amber-600 to-red-600
        @endif
    ">

        <div class="absolute -right-10 -top-20 w-72 h-72 rounded-full bg-white/10"></div>

        <div class="absolute -right-10 -bottom-32 w-80 h-80 rounded-full bg-white/10"></div>


        <div class="relative z-10 p-6 md:p-10">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                {{-- INFORMASI NILAI --}}
                <div>

                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white text-2xl mb-5">

                        @if(!$semuaEsaiDinilai)
                            <i class="fa-solid fa-hourglass-half"></i>
                        @elseif($lulus)
                            <i class="fa-solid fa-trophy"></i>
                        @else
                            <i class="fa-solid fa-medal"></i>
                        @endif

                    </div>


                    <p class="text-white/80 text-sm font-semibold">
                        @if(!$semuaEsaiDinilai)
                            Hasil pilihan ganda sudah tersedia.
                        @elseif($lulus)
                            Selamat! Kamu berhasil mencapai kriteria kelulusan.
                        @else
                            Ujian telah selesai. Terus tingkatkan kemampuanmu.
                        @endif
                    </p>


                    <h2 class="text-2xl md:text-3xl font-black text-white mt-2">

                        @if(!$semuaEsaiDinilai)
                            Menunggu Penilaian Esai
                        @elseif($lulus)
                            Pertahankan Prestasimu!
                        @else
                            Tetap Semangat Belajar!
                        @endif

                    </h2>


                    <p class="text-white/80 text-sm mt-3 leading-relaxed max-w-lg">

                        @if(!$semuaEsaiDinilai)

                            Jawaban pilihan ganda sudah dikoreksi otomatis.
                            Guru masih perlu memeriksa {{ $jumlahEsaiBelumDinilai }} jawaban esai.
                            Nilai akan diperbarui setelah seluruh esai dinilai.

                        @elseif($lulus)

                            Kamu berhasil mencapai nilai minimal 75.
                            Terus tingkatkan kemampuan dan pertahankan prestasimu!

                        @else

                            Hasil ujianmu belum mencapai nilai minimal 75.
                            Pelajari kembali materi dan evaluasi jawabanmu.

                        @endif

                    </p>


                    <div class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 text-white text-sm font-bold">

                        @if(!$semuaEsaiDinilai)

                            <i class="fa-solid fa-hourglass-half"></i>
                            Nilai Belum Final

                        @elseif($lulus)

                            <i class="fa-solid fa-circle-check"></i>
                            Memenuhi Kriteria Kelulusan

                        @else

                            <i class="fa-solid fa-book-open"></i>
                            Perlu Meningkatkan Hasil Belajar

                        @endif

                    </div>

                </div>


                {{-- ANGKA NILAI --}}
                <div class="flex justify-center md:justify-end">

                    <div class="w-48 h-48 md:w-56 md:h-56 rounded-full border-[10px] border-white/30 flex flex-col items-center justify-center bg-white/10 shadow-2xl">

                        <p class="text-white/80 text-sm font-bold">
                            {{ $statusNilai }}
                        </p>


                        <h3 class="text-6xl md:text-7xl font-black text-white tabular-nums mt-1">
                            {{ number_format($nilaiTampil, 0) }}
                        </h3>


                        <p class="text-white/80 text-sm mt-1">
                            dari 100
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- NOTIFIKASI PENILAIAN ESAI --}}
    {{-- ===================================================== --}}
    @if($jumlahEsai > 0)

        <div class="mb-6 p-5 rounded-2xl border
            {{ $semuaEsaiDinilai
                ? 'bg-emerald-50 border-emerald-200 dark:bg-emerald-500/10 dark:border-emerald-500/20'
                : 'bg-amber-50 border-amber-200 dark:bg-amber-500/10 dark:border-amber-500/20' }}
        ">

            <div class="flex items-start gap-4">

                <div class="w-11 h-11 shrink-0 rounded-xl flex items-center justify-center
                    {{ $semuaEsaiDinilai
                        ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400'
                        : 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400' }}
                ">

                    <i class="fa-solid {{ $semuaEsaiDinilai ? 'fa-circle-check' : 'fa-hourglass-half' }} text-lg"></i>

                </div>


                <div class="flex-1">

                    <h3 class="font-bold text-sm
                        {{ $semuaEsaiDinilai
                            ? 'text-emerald-800 dark:text-emerald-300'
                            : 'text-amber-800 dark:text-amber-300' }}
                    ">

                        {{ $semuaEsaiDinilai
                            ? 'Penilaian Esai Selesai'
                            : 'Penilaian Esai Sedang Berlangsung' }}

                    </h3>


                    <p class="text-xs mt-1 leading-relaxed
                        {{ $semuaEsaiDinilai
                            ? 'text-emerald-700 dark:text-emerald-400'
                            : 'text-amber-700 dark:text-amber-400' }}
                    ">

                        @if($semuaEsaiDinilai)

                            Seluruh jawaban esai telah diperiksa oleh guru.
                            Nilai akhir sudah tersedia.

                        @else

                            Terdapat {{ $jumlahEsaiBelumDinilai }} dari {{ $jumlahEsai }}
                            soal esai yang masih menunggu penilaian guru.

                        @endif

                    </p>


                    <div class="mt-3">

                        <div class="flex justify-between text-xs mb-2">

                            <span class="font-semibold
                                {{ $semuaEsaiDinilai
                                    ? 'text-emerald-700 dark:text-emerald-400'
                                    : 'text-amber-700 dark:text-amber-400' }}
                            ">
                                Progres penilaian esai
                            </span>

                            <span class="font-bold
                                {{ $semuaEsaiDinilai
                                    ? 'text-emerald-700 dark:text-emerald-400'
                                    : 'text-amber-700 dark:text-amber-400' }}
                            ">
                                {{ $jumlahEsaiSelesai }}/{{ $jumlahEsai }}
                            </span>

                        </div>


                        <div class="w-full h-2 rounded-full bg-white/70 dark:bg-black/20 overflow-hidden">

                            <div
                                class="h-full rounded-full transition-all duration-500
                                    {{ $semuaEsaiDinilai ? 'bg-emerald-500' : 'bg-amber-500' }}"
                                style="width: {{ $persentaseEsai }}%"
                            ></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- STATISTIK --}}
    {{-- ===================================================== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">


        {{-- TOTAL SOAL --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl p-5 shadow-sm">

            <div class="w-11 h-11 rounded-xl bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-4">

                <i class="fa-solid fa-list-check text-lg"></i>

            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                Total Soal
            </p>

            <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">
                {{ $totalSoal }}
            </h3>

        </div>


        {{-- BENAR --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl p-5 shadow-sm">

            <div class="w-11 h-11 rounded-xl bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-4">

                <i class="fa-solid fa-check text-lg"></i>

            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                Jawaban Benar
            </p>

            <h3 class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">
                {{ $jumlahBenar }}
            </h3>

        </div>


        {{-- SALAH --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl p-5 shadow-sm">

            <div class="w-11 h-11 rounded-xl bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center mb-4">

                <i class="fa-solid fa-xmark text-lg"></i>

            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                Jawaban Salah
            </p>

            <h3 class="text-2xl font-black text-red-600 dark:text-red-400 mt-1">
                {{ $jumlahSalah }}
            </h3>

        </div>


        {{-- EXP --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl p-5 shadow-sm">

            <div class="w-11 h-11 rounded-xl bg-purple-100 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-4">

                <i class="fa-solid fa-bolt text-lg"></i>

            </div>

            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                EXP Diperoleh
            </p>

            <h3 class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">
                +{{ $totalExp }}
            </h3>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- RINGKASAN PENILAIAN --}}
    {{-- ===================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">


        {{-- PILIHAN GANDA --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Hasil Pilihan Ganda
                    </p>

                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">
                        {{ $jumlahBenarPG }}/{{ $jumlahPG }}
                    </h3>

                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center">

                    <i class="fa-solid fa-list-check text-lg"></i>

                </div>

            </div>


            <div class="mt-4 flex items-center justify-between text-xs">

                <span class="text-gray-500 dark:text-gray-400">
                    Nilai pilihan ganda
                </span>

                <span class="font-black text-blue-600 dark:text-blue-400">
                    {{ number_format($nilaiPilihanGanda, 2) }}
                </span>

            </div>

        </div>


        {{-- ESAI --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Hasil Penilaian Esai
                    </p>

                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mt-1">
                        {{ $jumlahEsaiSelesai }}/{{ $jumlahEsai }}
                    </h3>

                </div>

                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">

                    <i class="fa-solid fa-pen-to-square text-lg"></i>

                </div>

            </div>


            <div class="mt-4 flex items-center justify-between text-xs">

                <span class="text-gray-500 dark:text-gray-400">
                    Status koreksi
                </span>

                <span class="font-bold
                    {{ $semuaEsaiDinilai
                        ? 'text-emerald-600 dark:text-emerald-400'
                        : 'text-amber-600 dark:text-amber-400' }}
                ">

                    {{ $semuaEsaiDinilai ? 'Selesai' : 'Menunggu Guru' }}

                </span>

            </div>

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- RINCIAN JAWABAN DAN INFORMASI --}}
    {{-- ===================================================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">


        {{-- ================================================= --}}
        {{-- RINCIAN JAWABAN --}}
        {{-- ================================================= --}}
        <div class="lg:col-span-2 bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl shadow-sm overflow-hidden">


            <div class="p-5 border-b border-gray-100 dark:border-cyberdark-700">

                <h3 class="font-bold text-gray-900 dark:text-white">

                    <i class="fa-solid fa-clipboard-list text-blue-500 mr-2"></i>

                    Rincian Jawaban

                </h3>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Ringkasan seluruh jawaban yang telah kamu kerjakan.
                </p>

            </div>


            <div class="p-5 space-y-4">

                @forelse($jawaban as $index => $item)

                    @php
                        $soal = $item->soal;

                        $isEsai = $soal?->tipe === 'esai';

                        $pertanyaan = $soal?->pertanyaan ?? 'Pertanyaan tidak tersedia';

                        $jawabanSiswa = $item->jawaban_siswa;

                        $esaiSudahDinilai = $isEsai
                            && $item->skor_esai !== null;
                    @endphp


                    <div class="p-4 rounded-xl border border-gray-100 dark:border-cyberdark-700 bg-gray-50 dark:bg-cyberdark-900/50">

                        {{-- HEADER SOAL --}}
                        <div class="flex items-start justify-between gap-3 mb-4">

                            <div class="flex items-center gap-3">

                                <span class="w-9 h-9 shrink-0 rounded-lg bg-white dark:bg-cyberdark-700 flex items-center justify-center text-sm font-black text-gray-700 dark:text-gray-200">
                                    {{ $index + 1 }}
                                </span>

                                <div>

                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        Soal {{ $index + 1 }}
                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $isEsai ? 'Soal Esai' : 'Pilihan Ganda' }}
                                    </p>

                                </div>

                            </div>


                            {{-- STATUS JAWABAN --}}
                            @if($isEsai)

                                @if($esaiSudahDinilai)

                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        <i class="fa-solid fa-check mr-1"></i>
                                        Sudah Dinilai
                                    </span>

                                @else

                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                        <i class="fa-solid fa-hourglass-half mr-1"></i>
                                        Menunggu Penilaian
                                    </span>

                                @endif

                            @elseif($item->benar)

                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    <i class="fa-solid fa-check mr-1"></i>
                                    Benar
                                </span>

                            @else

                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                    <i class="fa-solid fa-xmark mr-1"></i>
                                    Salah
                                </span>

                            @endif

                        </div>


                        {{-- PERTANYAAN --}}
                        <div class="mb-4">

                            <p class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-2">
                                Pertanyaan
                            </p>

                            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-line">
                                {{ $pertanyaan }}
                            </p>

                        </div>


                        {{-- JAWABAN SISWA --}}
                        <div class="p-3 rounded-xl bg-white dark:bg-cyberdark-800 border border-gray-100 dark:border-cyberdark-700">

                            <p class="text-xs font-bold uppercase tracking-wide text-gray-400 mb-2">
                                Jawaban Anda
                            </p>

                            @if($jawabanSiswa !== null && trim((string) $jawabanSiswa) !== '')

                                <p class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed whitespace-pre-line break-words">
                                    {{ $jawabanSiswa }}
                                </p>

                            @else

                                <p class="text-sm italic text-gray-400">
                                    Tidak dijawab
                                </p>

                            @endif

                        </div>


                        {{-- HASIL PILIHAN GANDA --}}
                        @if(!$isEsai)

                            <div class="mt-3 flex items-center justify-between gap-3">

                                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">

                                    <i class="fa-solid fa-bolt text-purple-500"></i>

                                    EXP diperoleh

                                </div>

                                <span class="font-bold text-purple-600 dark:text-purple-400 text-sm">
                                    +{{ $item->exp_diperoleh ?? 0 }} EXP
                                </span>

                            </div>


                        {{-- HASIL ESAI --}}
                        @else

                            <div class="mt-4 p-4 rounded-xl
                                {{ $esaiSudahDinilai
                                    ? 'bg-emerald-50 dark:bg-emerald-500/10'
                                    : 'bg-amber-50 dark:bg-amber-500/10' }}
                            ">

                                @if($esaiSudahDinilai)

                                    <div class="flex items-center justify-between gap-3">

                                        <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400">
                                            Skor Esai
                                        </p>

                                        <p class="text-lg font-black text-emerald-700 dark:text-emerald-400">
                                            {{ number_format((float) $item->skor_esai, 2) }}
                                            /
                                            {{ number_format((float) ($soal?->skor_maksimal ?? 100), 2) }}
                                        </p>

                                    </div>


                                    @if($item->catatan_guru)

                                        <div class="mt-3 pt-3 border-t border-emerald-200 dark:border-emerald-500/20">

                                            <p class="text-xs font-bold text-emerald-700 dark:text-emerald-400 mb-2">
                                                <i class="fa-solid fa-comment-dots mr-1"></i>
                                                Catatan Guru
                                            </p>

                                            <p class="text-sm text-emerald-800 dark:text-emerald-300 leading-relaxed whitespace-pre-line">
                                                {{ $item->catatan_guru }}
                                            </p>

                                        </div>

                                    @endif

                                @else

                                    <div class="flex items-center gap-2">

                                        <i class="fa-solid fa-hourglass-half text-amber-600 dark:text-amber-400"></i>

                                        <p class="text-xs font-semibold text-amber-700 dark:text-amber-400">
                                            Jawaban sedang menunggu penilaian guru.
                                        </p>

                                    </div>

                                @endif

                            </div>

                        @endif

                    </div>

                @empty

                    <div class="text-center py-10">

                        <i class="fa-solid fa-clipboard-question text-4xl text-gray-300 dark:text-gray-600"></i>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">
                            Belum ada rincian jawaban.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- INFORMASI UJIAN --}}
        {{-- ================================================= --}}
        <div class="space-y-5">


            {{-- INFORMASI --}}
            <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl shadow-sm p-5">

                <h3 class="font-bold text-gray-900 dark:text-white mb-5">
                    Informasi Ujian
                </h3>


                <div class="space-y-4">


                    <div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Nama Ujian
                        </p>

                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $hasilUjian->ruangUjian->judul }}
                        </p>

                    </div>


                    <div class="border-t border-gray-100 dark:border-cyberdark-700"></div>


                    <div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Guru Pengampu
                        </p>

                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $namaGuru }}
                        </p>

                    </div>


                    <div class="border-t border-gray-100 dark:border-cyberdark-700"></div>


                    <div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Waktu Mulai
                        </p>

                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $hasilUjian->started_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                        </p>

                    </div>


                    <div class="border-t border-gray-100 dark:border-cyberdark-700"></div>


                    <div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Waktu Selesai
                        </p>

                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $hasilUjian->finished_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                        </p>

                    </div>


                    <div class="border-t border-gray-100 dark:border-cyberdark-700"></div>


                    <div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Durasi Pengerjaan
                        </p>

                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $durasi }} menit
                        </p>

                    </div>


                    <div class="border-t border-gray-100 dark:border-cyberdark-700"></div>


                    <div>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
                            Status Penilaian
                        </p>

                        <p class="text-sm font-bold
                            {{ $semuaEsaiDinilai
                                ? 'text-emerald-600 dark:text-emerald-400'
                                : 'text-amber-600 dark:text-amber-400' }}
                        ">

                            {{ $semuaEsaiDinilai
                                ? 'Penilaian Selesai'
                                : 'Menunggu Koreksi Esai' }}

                        </p>

                    </div>

                </div>

            </div>


            {{-- INFORMASI NILAI --}}
            <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl shadow-sm p-5">

                <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                    Rincian Nilai
                </h3>


                <div class="space-y-3">


                    <div class="flex items-center justify-between">

                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Nilai pilihan ganda
                        </span>

                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($nilaiPilihanGanda, 2) }}
                        </span>

                    </div>


                    <div class="flex items-center justify-between">

                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            Skor esai
                        </span>

                        @if($semuaEsaiDinilai)

                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                {{ number_format($totalSkorEsai, 2) }}
                                /
                                {{ number_format($totalMaksimalEsai, 2) }}
                            </span>

                        @else

                            <span class="text-xs font-bold text-amber-600 dark:text-amber-400">
                                Menunggu
                            </span>

                        @endif

                    </div>


                    <div class="border-t border-gray-100 dark:border-cyberdark-700 pt-3">

                        <div class="flex items-center justify-between">

                            <span class="text-sm font-bold text-gray-800 dark:text-white">
                                {{ $statusNilai }}
                            </span>

                            <span class="text-xl font-black text-gray-900 dark:text-white">
                                {{ number_format($nilaiTampil, 2) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TOMBOL KEMBALI --}}
            <a
                href="{{ route('siswa.ujian.index') }}"
                class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold transition shadow-lg shadow-blue-500/20"
            >
                <i class="fa-solid fa-list"></i>
                Kembali ke Daftar Ujian
            </a>

        </div>

    </div>

</div>

@endsection
