
@extends('siswa.layouts.app')

@section('title', 'Aktivitas Apersepsi')

@php
    /*
    |--------------------------------------------------------------------------
    | Mengambil data dari konfigurasi guru
    |--------------------------------------------------------------------------
    */

    $materi = $konten['materi'] ?? [];
    $forum = $konten['forum'] ?? [];

    // Isi materi apersepsi
    $isiMateri = $materi['isi'] ?? '';

    // Konfigurasi forum
    $forumAktif = filter_var(
        $forum['aktif'] ?? false,
        FILTER_VALIDATE_BOOLEAN
    );

    $judulForum = $forum['judul'] ?? 'Forum Diskusi Apersepsi';
    $pertanyaanForum = $forum['pertanyaan'] ?? '';
    $batasJawaban = $forum['batas_jawaban'] ?? null;

    // Jawaban siswa sebelumnya jika validasi gagal
    $jawabanSebelumnya = old('jawaban.forum', '');
@endphp

@push('styles')
<style>
    .apersepsi-card {
        transition: all .25s ease;
    }

    .apersepsi-card:focus-within {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(129,140,248,.10);
    }

    .apersepsi-gradient {
        background: linear-gradient(
            135deg,
            #4f46e5 0%,
            #6366f1 50%,
            #8b5cf6 100%
        );
    }

    .answer-area {
        min-height: 180px;
        resize: vertical;
    }

    .materi-content img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin-top: 12px;
        margin-bottom: 12px;
    }

    .materi-content iframe {
        max-width: 100%;
    }

    .materi-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 16px 0;
    }

    .materi-content table td,
    .materi-content table th {
        border: 1px solid #e5e7eb;
        padding: 10px;
    }
</style>
@endpush

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-3">

            <div class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                <i class="fa-solid fa-lightbulb text-indigo-600 dark:text-indigo-400 text-xl"></i>
            </div>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-[.2em] text-indigo-600 dark:text-indigo-400">
                    Aktivitas Pembelajaran
                </p>

                <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">
                    Apersepsi
                </h1>
            </div>

        </div>

        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300 text-xs font-bold">
            <i class="fa-solid fa-brain"></i>
            Aktifkan Pengetahuan Awal
        </span>

    </div>


    {{-- INFORMASI RUANG BELAJAR --}}
    <div class="bg-white dark:bg-cyberdark-900 rounded-3xl border border-gray-100 dark:border-gray-800 p-5 sm:p-6">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <i class="fa-solid fa-book-open text-blue-600 dark:text-blue-400"></i>
            </div>

            <div class="min-w-0">

                <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400">
                    Ruang Belajar
                </p>

                <h2 class="font-black text-gray-900 dark:text-white mt-1 truncate">
                    {{ $ruangBelajar->judul ?? 'Ruang Belajar' }}
                </h2>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $tahapan->judul_tahapan }}
                </p>

            </div>

        </div>

    </div>


    {{-- HERO APERSEPSI --}}
    <div class="relative overflow-hidden rounded-[2rem] apersepsi-gradient p-6 sm:p-9">

        <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-white/10 blur-2xl"></div>

        <div class="absolute -left-12 -bottom-20 w-56 h-56 rounded-full bg-purple-300/20 blur-2xl"></div>

        <div class="relative z-10 max-w-3xl">

            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-white text-[10px] font-black uppercase tracking-widest">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
                Persiapkan Dirimu
            </span>

            <h2 class="text-2xl sm:text-3xl font-black text-white mt-5 leading-tight">
                Mari Hubungkan Pengetahuan Awalmu!
            </h2>

            <p class="text-sm sm:text-base text-indigo-50 leading-relaxed mt-4">
                Sebelum memulai pembelajaran, bacalah materi apersepsi berikut.
                Hubungkan informasi yang kamu peroleh dengan pengetahuan dan
                pengalaman yang sudah kamu miliki.
            </p>

            <div class="flex items-center gap-3 mt-7 text-white/90">

                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center">
                    <i class="fa-solid fa-compass"></i>
                </div>

                <p class="text-xs font-semibold">
                    Bacalah dengan cermat, pikirkan jawabannya, dan sampaikan pendapatmu.
                </p>

            </div>

        </div>

    </div>


    {{-- MATERI APERSEPSI --}}
    <div class="bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 overflow-hidden">

        <div class="p-5 sm:p-7 border-b border-gray-100 dark:border-gray-800">

            <div class="flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-book-open-reader text-indigo-600 dark:text-indigo-400 text-lg"></i>
                </div>

                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-500">
                        Materi Pembelajaran
                    </p>

                    <h3 class="text-base sm:text-lg font-black text-gray-900 dark:text-white mt-1">
                        Bacalah dan Pahami Materi Berikut
                    </h3>
                </div>

            </div>

        </div>

        <div class="p-5 sm:p-8">

            @if (trim(strip_tags($isiMateri)) !== '')

                <article class="materi-content text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-8 break-words">

                    {!! $isiMateri !!}

                </article>

            @else

                <div class="p-6 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-900/30 text-center">

                    <i class="fa-solid fa-circle-exclamation text-amber-500 text-2xl mb-3"></i>

                    <p class="text-sm font-bold text-amber-700 dark:text-amber-300">
                        Materi Apersepsi Belum Tersedia
                    </p>

                    <p class="text-xs text-amber-600 dark:text-amber-400 mt-2">
                        Guru belum menambahkan isi materi untuk aktivitas ini.
                    </p>

                </div>

            @endif

        </div>

    </div>


    {{-- FORM JAWABAN DAN FORUM --}}
    <form
        id="form-apersepsi"
        action="{{ route('siswa.ruang-belajar.tahapan.selesaikan', [
            'ruang_belajar_id' => $ruangBelajar->id,
            'tahapan_id' => $tahapan->id
        ]) }}"
        method="POST">

        @csrf

        @if ($forumAktif)

            {{-- FORUM DISKUSI --}}
            <div class="bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 overflow-hidden">

                <div class="p-5 sm:p-7 border-b border-gray-100 dark:border-gray-800">

                    <div class="flex items-start gap-4">

                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                            <i class="fa-solid fa-comments text-amber-600 dark:text-amber-400 text-xl"></i>
                        </div>

                        <div class="min-w-0">

                            <span class="text-[10px] font-black uppercase tracking-widest text-amber-600 dark:text-amber-400">
                                Forum Diskusi
                            </span>

                            <h3 class="text-lg font-black text-gray-900 dark:text-white mt-1">
                                {{ $judulForum }}
                            </h3>

                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                                Sampaikan pendapatmu berdasarkan materi yang telah kamu baca.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="p-5 sm:p-8">

                    {{-- PERTANYAAN GURU --}}
                    <div class="rounded-2xl bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/40 p-5 sm:p-6">

                        <div class="flex items-center gap-2 mb-3">

                            <span class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                                <i class="fa-solid fa-circle-question text-indigo-600 dark:text-indigo-400"></i>
                            </span>

                            <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
                                Pertanyaan Pemantik dari Guru
                            </span>

                        </div>

                        <p class="text-sm sm:text-base font-semibold text-indigo-950 dark:text-indigo-100 leading-relaxed">

                            {{ $pertanyaanForum }}

                        </p>

                    </div>


                    {{-- JAWABAN SISWA --}}
                    <div class="mt-6">

                        <label for="jawaban-forum" class="block text-sm font-black text-gray-900 dark:text-white mb-2">
                            Tuliskan Pendapatmu
                        </label>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                            Jelaskan pemikiranmu menggunakan bahasamu sendiri.
                            Kamu dapat menghubungkan jawaban dengan materi maupun pengalaman yang pernah kamu temui.
                        </p>

                        <textarea
                            id="jawaban-forum"
                            name="jawaban[forum]"
                            class="answer-area w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-4 text-sm text-gray-800 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                            placeholder="Tuliskan jawaban atau pendapatmu di sini..."
                            required>{{ $jawabanSebelumnya }}</textarea>

                        @error('jawaban.forum')
                            <p class="text-xs text-red-500 mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                        @error('jawaban')
                            <p class="text-xs text-red-500 mt-2">
                                {{ $message }}
                            </p>
                        @enderror

                        @if ($batasJawaban)
                            <p class="text-xs text-gray-400 mt-3">
                                <i class="fa-solid fa-circle-info mr-1"></i>
                                Batas jawaban sesuai pengaturan guru:
                                {{ $batasJawaban }}
                            </p>
                        @endif

                    </div>


                    {{-- CATATAN --}}
                    <div class="mt-6 p-4 rounded-2xl bg-gray-50 dark:bg-gray-800 flex items-start gap-3">

                        <i class="fa-solid fa-lightbulb text-amber-500 mt-0.5"></i>

                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Tidak perlu khawatir jika jawabanmu belum sempurna.
                            Hal terpenting adalah kamu berusaha berpikir,
                            menganalisis, dan menyampaikan pendapatmu sendiri.
                        </p>

                    </div>

                </div>

            </div>

        @else

            {{-- FORUM TIDAK DIAKTIFKAN --}}
            <div class="bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 p-6 sm:p-8">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12 shrink-0 rounded-2xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <i class="fa-solid fa-bookmark text-green-600 dark:text-green-400 text-xl"></i>
                    </div>

                    <div>
                        <h3 class="font-black text-gray-900 dark:text-white">
                            Materi Apersepsi Selesai Dibaca?
                        </h3>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">
                            Forum diskusi tidak diaktifkan oleh guru.
                            Jika sudah memahami materi, kamu dapat melanjutkan aktivitas.
                        </p>
                    </div>

                </div>

            </div>

        @endif


        {{-- TOMBOL SELESAIKAN --}}
        <div class="bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 p-5 sm:p-7 mt-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>

                    <p class="text-sm font-black text-gray-900 dark:text-white">
                        Sudah selesai dengan Apersepsi?
                    </p>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Pastikan kamu sudah membaca materi dan mengisi forum jika tersedia.
                    </p>

                </div>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 px-7 py-4 rounded-2xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-indigo-500/20 border-b-4 border-indigo-800 transition-all hover:-translate-y-0.5">

                    <i class="fa-solid fa-paper-plane"></i>
                    Selesaikan Apersepsi

                </button>

            </div>

        </div>

    </form>

</div>

@endsection
