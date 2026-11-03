
@extends('siswa.layouts.app')

@section('title', 'Detail Ujian')

@section('content')

@php
    $hasilSaya = $hasilSaya ?? null;

    $statusSiswa = $hasilSaya
        ? $hasilSaya->status
        : 'tersedia';

    $totalSoal = $ruangUjian->soal_count
        ?? $ruangUjian->soal->count();

    $totalExp = $ruangUjian->soal_sum_exp
        ?? $ruangUjian->soal->sum('exp');
@endphp

<div class="min-h-screen bg-slate-50 px-4 py-6 transition-colors duration-300 dark:bg-cyberdark-900 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-6xl space-y-6">

        {{-- BREADCRUMB --}}
        <div class="flex flex-wrap items-center gap-2 text-sm">

            <a href="{{ route('siswa.ujian.index') }}"
               class="font-medium text-slate-500 transition hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400">
                Ruang Ujian
            </a>

            <i class="fa-solid fa-chevron-right text-xs text-slate-400"></i>

            <span class="font-semibold text-indigo-600 dark:text-indigo-400">
                Detail Ujian
            </span>

        </div>


        {{-- HEADER --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-blue-600 to-blue-500 p-6 shadow-lg shadow-blue-500/10 sm:p-8">

            <div class="relative z-10 max-w-3xl">

                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                    <i class="fa-solid fa-clipboard-check"></i>
                    Informasi Ruang Ujian
                </span>

                <h1 class="mt-5 text-2xl font-bold leading-tight text-white sm:text-3xl lg:text-4xl">
                    {{ $ruangUjian->judul }}
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-7 text-blue-100 sm:text-base">
                    {{ $ruangUjian->deskripsi ?: 'Persiapkan dirimu dan kerjakan ujian ini dengan teliti untuk mengukur pemahamanmu.' }}
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3">

                    @if($statusSiswa === 'selesai')

                        <span class="inline-flex items-center gap-2 rounded-xl bg-green-400/20 px-4 py-2 text-sm font-semibold text-white">
                            <i class="fa-solid fa-circle-check"></i>
                            Ujian Selesai
                        </span>

                    @elseif($statusSiswa === 'berlangsung')

                        <span class="inline-flex items-center gap-2 rounded-xl bg-amber-400/20 px-4 py-2 text-sm font-semibold text-white">
                            <i class="fa-solid fa-clock"></i>
                            Sedang Berlangsung
                        </span>

                    @else

                        <span class="inline-flex items-center gap-2 rounded-xl bg-white/15 px-4 py-2 text-sm font-semibold text-white">
                            <i class="fa-solid fa-circle-play"></i>
                            Tersedia untuk Dikerjakan
                        </span>

                    @endif

                </div>

            </div>

            {{-- DEKORASI --}}
            <div class="pointer-events-none absolute -right-12 -top-20 h-72 w-72 rounded-full border-[35px] border-white/10"></div>

            <div class="pointer-events-none absolute -bottom-32 right-32 h-64 w-64 rounded-full border-[30px] border-white/10"></div>

            <div class="pointer-events-none absolute bottom-6 right-10 hidden lg:block">
                <div class="flex h-36 w-36 items-center justify-center rounded-3xl bg-white/10 backdrop-blur-sm">
                    <i class="fa-solid fa-file-circle-question text-7xl text-white/90"></i>
                </div>
            </div>

        </div>


        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            {{-- JUMLAH SOAL --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-cyberdark-700 dark:bg-cyberdark-800">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                        <i class="fa-solid fa-list-ol text-xl"></i>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-gray-400">
                            Jumlah Soal
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-white">
                            {{ $totalSoal }}
                            <span class="text-sm font-medium text-slate-400">Soal</span>
                        </p>
                    </div>

                </div>

            </div>


            {{-- DURASI --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-cyberdark-700 dark:bg-cyberdark-800">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        <i class="fa-solid fa-clock text-xl"></i>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-gray-400">
                            Waktu Pengerjaan
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-white">
                            {{ $ruangUjian->durasi_menit }}
                            <span class="text-sm font-medium text-slate-400">Menit</span>
                        </p>
                    </div>

                </div>

            </div>


            {{-- EXP --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-colors dark:border-cyberdark-700 dark:bg-cyberdark-800">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 dark:bg-yellow-500/10 dark:text-yellow-400">
                        <i class="fa-solid fa-star text-xl"></i>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-gray-400">
                            Total EXP
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-white">
                            {{ $totalExp }}
                            <span class="text-sm font-medium text-slate-400">EXP</span>
                        </p>
                    </div>

                </div>

            </div>

        </div>


        {{-- KONTEN UTAMA --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            {{-- INFORMASI DAN PETUNJUK --}}
            <div class="space-y-6 lg:col-span-2">

                {{-- INFORMASI UJIAN --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-cyberdark-700 dark:bg-cyberdark-800 sm:p-6">

                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4 dark:border-cyberdark-700">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <i class="fa-solid fa-circle-info text-lg"></i>
                        </div>

                        <div>
                            <h2 class="font-bold text-slate-800 dark:text-white">
                                Informasi Ujian
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-gray-400">
                                Detail pelaksanaan evaluasi
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 space-y-4">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500 dark:text-gray-400">
                                Nama Ujian
                            </span>

                            <span class="text-right text-sm font-semibold text-slate-800 dark:text-gray-200">
                                {{ $ruangUjian->judul }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500 dark:text-gray-400">
                                Pengajar
                            </span>

                            <span class="text-right text-sm font-semibold text-slate-800 dark:text-gray-200">
                                {{ $ruangUjian->guru->name ?? 'Guru' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500 dark:text-gray-400">
                                Jumlah Pertanyaan
                            </span>

                            <span class="text-sm font-semibold text-slate-800 dark:text-gray-200">
                                {{ $totalSoal }} Soal
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500 dark:text-gray-400">
                                Durasi
                            </span>

                            <span class="text-sm font-semibold text-slate-800 dark:text-gray-200">
                                {{ $ruangUjian->durasi_menit }} Menit
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500 dark:text-gray-400">
                                Pengacakan Soal
                            </span>

                            <span class="text-sm font-semibold text-slate-800 dark:text-gray-200">
                                {{ $ruangUjian->acak_soal ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-sm text-slate-500 dark:text-gray-400">
                                Pengacakan Jawaban
                            </span>

                            <span class="text-sm font-semibold text-slate-800 dark:text-gray-200">
                                {{ $ruangUjian->acak_jawaban ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>

                    </div>

                </div>


                {{-- PETUNJUK PENGERJAAN --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-cyberdark-700 dark:bg-cyberdark-800 sm:p-6">

                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4 dark:border-cyberdark-700">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <i class="fa-solid fa-book-open text-lg"></i>
                        </div>

                        <div>
                            <h2 class="font-bold text-slate-800 dark:text-white">
                                Petunjuk Pengerjaan
                            </h2>

                            <p class="text-xs text-slate-500 dark:text-gray-400">
                                Perhatikan sebelum memulai ujian
                            </p>
                        </div>

                    </div>

                    <div class="mt-5 space-y-4">

                        <div class="flex items-start gap-3">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                1
                            </div>

                            <p class="text-sm leading-6 text-slate-600 dark:text-gray-300">
                                Pastikan koneksi internet stabil sebelum memulai pengerjaan ujian.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                2
                            </div>

                            <p class="text-sm leading-6 text-slate-600 dark:text-gray-300">
                                Bacalah setiap pertanyaan dengan teliti sebelum menentukan jawaban.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                3
                            </div>

                            <p class="text-sm leading-6 text-slate-600 dark:text-gray-300">
                                Kerjakan seluruh pertanyaan sesuai dengan kemampuan dan pemahamanmu.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                4
                            </div>

                            <p class="text-sm leading-6 text-slate-600 dark:text-gray-300">
                                Perhatikan batas waktu pengerjaan. Ujian memiliki durasi
                                {{ $ruangUjian->durasi_menit }} menit.
                            </p>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-xs font-bold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                5
                            </div>

                            <p class="text-sm leading-6 text-slate-600 dark:text-gray-300">
                                Setelah selesai, pastikan kamu menekan tombol
                                <strong class="text-slate-800 dark:text-white">Selesaikan Ujian</strong>
                                untuk mengirimkan jawaban.
                            </p>
                        </div>

                    </div>

                </div>

            </div>


            {{-- PANEL MULAI UJIAN --}}
            <div class="space-y-6">

                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-cyberdark-700 dark:bg-cyberdark-800">

                    <div class="bg-gradient-to-br from-indigo-600 to-blue-500 p-5">

                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-white">
                            <i class="fa-solid fa-graduation-cap text-2xl"></i>
                        </div>

                        <h2 class="mt-4 text-lg font-bold text-white">
                            Siap Mengikuti Ujian?
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-blue-100">
                            Persiapkan dirimu dan berikan hasil terbaik dalam ujian ini.
                        </p>

                    </div>


                    <div class="p-5">

                        @if($statusSiswa === 'selesai')

                            <div class="rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-500/20 dark:bg-green-500/10">

                                <div class="flex items-center gap-2 text-green-700 dark:text-green-400">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span class="text-sm font-bold">
                                        Ujian Telah Diselesaikan
                                    </span>
                                </div>

                                <p class="mt-2 text-sm text-green-700 dark:text-green-300">
                                    Kamu sudah menyelesaikan ujian ini.
                                </p>

                                <div class="mt-4 border-t border-green-200 pt-4 dark:border-green-500/20">

                                    <p class="text-xs text-green-700 dark:text-green-400">
                                        Nilai yang diperoleh
                                    </p>

                                    <p class="mt-1 text-3xl font-bold text-green-800 dark:text-green-300">
                                        {{ number_format($hasilSaya->nilai, 2, ',', '.') }}
                                    </p>

                                </div>

                            </div>

                            <a href="{{ route('siswa.ujian.hasil', $hasilSaya->id) }}"
                               class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-green-700">

                                <i class="fa-solid fa-chart-column"></i>
                                Lihat Hasil Ujian

                            </a>

                        @elseif($statusSiswa === 'berlangsung')

                            <div class="rounded-xl border border-indigo-200 bg-indigo-50 p-4 dark:border-indigo-500/20 dark:bg-indigo-500/10">

                                <div class="flex items-center gap-2 text-indigo-700 dark:text-indigo-400">
                                    <i class="fa-solid fa-clock"></i>
                                    <span class="text-sm font-bold">
                                        Ujian Sedang Berlangsung
                                    </span>
                                </div>

                                <p class="mt-2 text-sm leading-6 text-indigo-700 dark:text-indigo-300">
                                    Kamu memiliki sesi ujian yang belum selesai. Lanjutkan untuk menyelesaikannya.
                                </p>

                            </div>

                            <a href="{{ route('siswa.ujian.kerjakan', $hasilSaya->id) }}"
                               class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-indigo-700">

                                <i class="fa-solid fa-play"></i>
                                Lanjutkan Ujian

                            </a>

                        @else

                            @if($totalSoal > 0)

                                <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-500/20 dark:bg-amber-500/10">

                                    <div class="flex items-center gap-2 text-amber-700 dark:text-amber-400">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span class="text-sm font-bold">
                                            Perhatikan Sebelum Memulai
                                        </span>
                                    </div>

                                    <p class="mt-2 text-sm leading-6 text-amber-700 dark:text-amber-300">
                                        Waktu pengerjaan dimulai ketika kamu menekan tombol Mulai Ujian.
                                    </p>

                                </div>

                                <form action="{{ route('siswa.ujian.mulai-mandiri', $ruangUjian->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Apakah kamu sudah siap untuk memulai ujian ini?');">

                                    @csrf

                                    <button type="submit"
                                            class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/20 transition hover:bg-indigo-700 active:scale-[0.98]">

                                        <i class="fa-solid fa-play"></i>
                                        Mulai Ujian

                                    </button>

                                </form>

                            @else

                                <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-500/20 dark:bg-red-500/10">

                                    <div class="flex items-center gap-2 text-red-700 dark:text-red-400">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span class="text-sm font-bold">
                                            Soal Belum Tersedia
                                        </span>
                                    </div>

                                    <p class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        Ujian ini belum memiliki soal sehingga belum dapat dikerjakan.
                                    </p>

                                </div>

                                <button type="button"
                                        disabled
                                        class="mt-5 flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-slate-300 px-4 py-3 text-sm font-bold text-slate-500 dark:bg-cyberdark-700 dark:text-gray-500">

                                    <i class="fa-solid fa-lock"></i>
                                    Belum Bisa Dimulai

                                </button>

                            @endif

                        @endif


                        <a href="{{ route('siswa.ujian.index') }}"
                           class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50 dark:border-cyberdark-700 dark:bg-cyberdark-800 dark:text-gray-300 dark:hover:bg-cyberdark-700">

                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali ke Daftar Ujian

                        </a>

                    </div>

                </div>


                {{-- TIPS --}}
                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 dark:border-blue-500/20 dark:bg-blue-500/10">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400">
                            <i class="fa-solid fa-lightbulb text-lg"></i>
                        </div>

                        <div>
                            <h3 class="font-bold text-blue-800 dark:text-blue-300">
                                Tips Belajar
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-blue-700 dark:text-blue-300">
                                Bacalah soal secara menyeluruh, pahami maksud pertanyaan,
                                dan analisis pilihan jawaban sebelum menentukan keputusan.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
