
@extends('siswa.layouts.app')

@section('title', 'Hasil Ujian - ' . $hasilUjian->ruangUjian->judul)

@section('content')

@php
    $nilai = (float) $hasilUjian->nilai;

    // Ambang kelulusan sementara: 75
    $lulus = $nilai >= 75;

    $jumlahBenar = $hasilUjian->jumlah_benar;
    $jumlahSalah = $hasilUjian->jumlah_salah;
    $totalSoal = $hasilUjian->total_soal;
    $totalExp = $hasilUjian->exp_diperoleh;

    $jawaban = $hasilUjian->jawaban ?? collect();

    $jumlahEsai = $jawaban->filter(function ($item) {
        return $item->soalUjian?->tipe === 'esai';
    })->count();

    $durasi = $hasilUjian->started_at && $hasilUjian->finished_at
        ? max(0, $hasilUjian->started_at->diffInMinutes($hasilUjian->finished_at))
        : 0;

    $persentase = $totalSoal > 0
        ? round(($jumlahBenar / $totalSoal) * 100)
        : 0;
@endphp

<div class="pb-10">

    {{-- HEADER --}}
    <div class="mb-6">
        <a href="{{ route('siswa.ujian.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition mb-5">
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

    {{-- HERO NILAI --}}
    <div class="relative overflow-hidden rounded-3xl mb-6
        {{ $lulus
            ? 'bg-gradient-to-br from-emerald-600 via-green-600 to-teal-700'
            : 'bg-gradient-to-br from-orange-500 via-amber-600 to-red-600' }}">

        <div class="absolute -right-10 -top-20 w-72 h-72 rounded-full bg-white/10"></div>
        <div class="absolute -right-10 -bottom-32 w-80 h-80 rounded-full bg-white/10"></div>

        <div class="relative z-10 p-6 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                <div>
                    <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center text-white text-2xl mb-5">
                        <i class="fa-solid {{ $lulus ? 'fa-trophy' : 'fa-medal' }}"></i>
                    </div>

                    <p class="text-white/80 text-sm font-semibold">
                        {{ $lulus ? 'Selamat! Hasil yang bagus.' : 'Ujian telah berhasil diselesaikan.' }}
                    </p>

                    <h2 class="text-2xl md:text-3xl font-black text-white mt-2">
                        {{ $lulus ? 'Pertahankan Prestasimu!' : 'Tetap Semangat Belajar!' }}
                    </h2>

                    <p class="text-white/80 text-sm mt-3 leading-relaxed max-w-lg">
                        {{ $lulus
                            ? 'Kamu berhasil mencapai nilai yang memenuhi kriteria kelulusan. Terus tingkatkan kemampuanmu!'
                            : 'Jangan menyerah. Evaluasi jawabanmu dan pelajari kembali materi yang belum dikuasai.' }}
                    </p>

                    <div class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/20 text-white text-sm font-bold">
                        <i class="fa-solid {{ $lulus ? 'fa-circle-check' : 'fa-book-open' }}"></i>
                        {{ $lulus ? 'Memenuhi Kriteria Kelulusan' : 'Perlu Meningkatkan Hasil Belajar' }}
                    </div>
                </div>

                <div class="flex justify-center md:justify-end">
                    <div class="w-48 h-48 md:w-56 md:h-56 rounded-full border-[10px] border-white/30 flex flex-col items-center justify-center bg-white/10 shadow-2xl">
                        <p class="text-white/80 text-sm font-bold">
                            NILAI AKHIR
                        </p>

                        <h3 class="text-6xl md:text-7xl font-black text-white tabular-nums mt-1">
                            {{ number_format($nilai, 0) }}
                        </h3>

                        <p class="text-white/80 text-sm mt-1">
                            dari 100
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

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

    {{-- RINCIAN DAN INFORMASI --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- RINCIAN JAWABAN --}}
        <div class="lg:col-span-2 bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-cyberdark-700 rounded-2xl shadow-sm overflow-hidden">

            <div class="p-5 border-b border-gray-100 dark:border-cyberdark-700">
                <h3 class="font-bold text-gray-900 dark:text-white">
                    <i class="fa-solid fa-clipboard-list text-blue-500 mr-2"></i>
                    Rincian Jawaban
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Ringkasan jawaban yang telah kamu kerjakan.
                </p>
            </div>

            <div class="p-5 space-y-4">

                @forelse($jawaban as $index => $item)
                    @php
                        $soal = $item->soalUjian;
                        $isEsai = $soal?->tipe === 'esai';
                    @endphp

                    <div class="p-4 rounded-xl border border-gray-100 dark:border-cyberdark-700 bg-gray-50 dark:bg-cyberdark-900/50">

                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3">
                                <span class="w-9 h-9 shrink-0 rounded-lg bg-white dark:bg-cyberdark-700 flex items-center justify-center text-sm font-black text-gray-700 dark:text-gray-200">
                                    {{ $index + 1 }}
                                </span>

                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                                        Soal {{ $index + 1 }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $isEsai ? 'Esai' : 'Pilihan Ganda' }}
                                    </p>
                                </div>
                            </div>

                            @if($isEsai)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                    Menunggu Penilaian
                                </span>
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

                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $item->jawaban_siswa ?: 'Tidak dijawab' }}
                        </p>

                        @if(!$isEsai)
                            <div class="mt-3 flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-bolt text-purple-500"></i>
                                EXP diperoleh:
                                <span class="font-bold text-purple-600 dark:text-purple-400">
                                    +{{ $item->exp_diperoleh }}
                                </span>
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

        {{-- INFORMASI UJIAN --}}
        <div class="space-y-5">

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
                            {{ $hasilUjian->ruangUjian->guru->name ?? 'Guru' }}
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

                </div>
            </div>

            {{-- STATUS ESAI --}}
            @if($jumlahEsai > 0)
                <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200 dark:bg-amber-500/10 dark:border-amber-500/20">
                    <div class="flex gap-3">
                        <i class="fa-solid fa-hourglass-half text-amber-600 dark:text-amber-400 text-lg mt-1"></i>

                        <div>
                            <h4 class="text-sm font-bold text-amber-800 dark:text-amber-300">
                                Penilaian Esai
                            </h4>

                            <p class="text-xs text-amber-700 dark:text-amber-400 mt-2 leading-relaxed">
                                Terdapat {{ $jumlahEsai }} soal esai yang menunggu penilaian guru. Nilai akhir dapat berubah setelah penilaian selesai.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('siswa.ujian.index') }}"
               class="flex items-center justify-center gap-2 w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold transition shadow-lg shadow-blue-500/20">
                <i class="fa-solid fa-list"></i>
                Kembali ke Daftar Ujian
            </a>

        </div>
    </div>
</div>

@endsection
