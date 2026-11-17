
@extends('guru.layouts.app')

@section('title', 'Buat Soal Ujian')

@section('content')

@php
    $opsiLama = old('opsi', [
        ['kode' => 'A', 'teks' => ''],
        ['kode' => 'B', 'teks' => ''],
        ['kode' => 'C', 'teks' => ''],
        ['kode' => 'D', 'teks' => ''],
    ]);

    $rubrikDefault = [
        [
            'nama' => 'Ketepatan Konsep',
            'bobot' => 40,
            'deskripsi' => 'Ketepatan konsep dan pemahaman materi.'
        ],
        [
            'nama' => 'Kelengkapan Jawaban',
            'bobot' => 30,
            'deskripsi' => 'Kelengkapan unsur jawaban yang diminta.'
        ],
        [
            'nama' => 'Analisis dan Penalaran',
            'bobot' => 20,
            'deskripsi' => 'Kemampuan menjelaskan alasan dan proses berpikir.'
        ],
        [
            'nama' => 'Sistematika Jawaban',
            'bobot' => 10,
            'deskripsi' => 'Kejelasan dan keteraturan penyampaian.'
        ],
    ];

    $rubrikLama = old('rubrik_penilaian', $rubrikDefault);

    $tipeLama = old('tipe', 'pilihan_ganda');
@endphp

<div class="min-h-screen bg-slate-50/70 px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-5xl">

        {{-- BREADCRUMB --}}
        <div class="mb-6 flex flex-wrap items-center gap-2 text-sm text-slate-500">

            <a href="{{ route('guru.ruang-ujian.index') }}"
               class="transition hover:text-indigo-600">
                Ruang Ujian
            </a>

            <i class="fas fa-chevron-right text-xs"></i>

            <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
               class="transition hover:text-indigo-600">
                {{ $ruangUjian->judul }}
            </a>

            <i class="fas fa-chevron-right text-xs"></i>

            <span class="font-semibold text-indigo-600">
                Tambah Soal
            </span>

        </div>


        {{-- HEADER --}}
        <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <div class="mb-2 inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                    <i class="fas fa-file-circle-plus"></i>
                    Manajemen Soal
                </div>

                <h1 class="text-2xl font-bold tracking-tight text-slate-800 sm:text-3xl">
                    Tambahkan Soal Ujian
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Buat pertanyaan, tentukan tipe soal, dan atur sistem penilaiannya.
                </p>

            </div>

            <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-100">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>


        {{-- INFORMASI RUANG UJIAN --}}
        <div class="mb-6 overflow-hidden rounded-2xl border border-indigo-100 bg-white shadow-sm">

            <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex items-center gap-4">

                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-xl text-indigo-600">
                        <i class="fas fa-clipboard-list"></i>
                    </div>

                    <div>

                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                            Ruang Ujian
                        </p>

                        <h3 class="mt-1 font-bold text-slate-800">
                            {{ $ruangUjian->judul }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ $ruangUjian->soal()->count() }} soal telah dibuat
                        </p>

                    </div>

                </div>

                <div class="rounded-xl bg-indigo-50 px-4 py-3">

                    <p class="text-xs font-medium text-indigo-500">
                        Nomor Soal Berikutnya
                    </p>

                    <p class="mt-1 text-xl font-bold text-indigo-700">
                        #{{ $urutanBerikutnya }}
                    </p>

                </div>

            </div>

        </div>


        {{-- ERROR VALIDASI --}}
        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <div class="flex items-start gap-3">

                    <i class="fas fa-circle-exclamation mt-0.5 text-red-500"></i>

                    <div>

                        <p class="font-semibold text-red-700">
                            Terdapat kesalahan pada pengisian formulir.
                        </p>

                        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- FORM UTAMA --}}
        <form action="{{ route('guru.ruang-ujian.soal.store', $ruangUjian->id) }}"
              method="POST"
              id="formSoal">

            @csrf

            <div class="space-y-6">


                {{-- =========================================
                     1. PERTANYAAN
                ========================================== --}}

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="fas fa-pen-to-square"></i>
                        </div>

                        <div>

                            <h2 class="font-bold text-slate-800">
                                Pertanyaan Soal
                            </h2>

                            <p class="text-xs text-slate-500">
                                Tuliskan pertanyaan yang akan dikerjakan siswa.
                            </p>

                        </div>

                    </div>

                    <label for="pertanyaan"
                           class="mb-2 block text-sm font-semibold text-slate-700">

                        Isi Pertanyaan
                        <span class="text-red-500">*</span>

                    </label>

                    <textarea id="pertanyaan"
                              name="pertanyaan"
                              rows="5"
                              required
                              placeholder="Tuliskan pertanyaan ujian di sini..."
                              class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">{{ old('pertanyaan') }}</textarea>

                    @error('pertanyaan')
                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                </div>


                {{-- =========================================
                     2. TIPE SOAL
                ========================================== --}}

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">

                    <div class="mb-5 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                            <i class="fas fa-list-check"></i>
                        </div>

                        <div>

                            <h2 class="font-bold text-slate-800">
                                Tipe Soal
                            </h2>

                            <p class="text-xs text-slate-500">
                                Pilih bentuk pertanyaan yang ingin digunakan.
                            </p>

                        </div>

                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">

                        {{-- PILIHAN GANDA --}}
                        <label class="cursor-pointer">

                            <input type="radio"
                                   name="tipe"
                                   value="pilihan_ganda"
                                   class="peer sr-only"
                                   {{ $tipeLama === 'pilihan_ganda' ? 'checked' : '' }}>

                            <div class="rounded-xl border-2 border-slate-200 p-4 transition hover:border-indigo-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50/60">

                                <div class="flex items-center justify-between">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                        <i class="fas fa-list-ol"></i>
                                    </div>

                                    <i class="fas fa-circle-check text-xl text-indigo-500 opacity-0 peer-checked:opacity-100"></i>

                                </div>

                                <h3 class="mt-3 font-bold text-slate-800">
                                    Pilihan Ganda
                                </h3>

                                <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                    Siswa memilih satu jawaban yang paling tepat dari beberapa opsi.
                                </p>

                            </div>

                        </label>


                        {{-- ESAI --}}
                        <label class="cursor-pointer">

                            <input type="radio"
                                   name="tipe"
                                   value="esai"
                                   class="peer sr-only"
                                   {{ $tipeLama === 'esai' ? 'checked' : '' }}>

                            <div class="rounded-xl border-2 border-slate-200 p-4 transition hover:border-emerald-300 peer-checked:border-emerald-500 peer-checked:bg-emerald-50/60">

                                <div class="flex items-center justify-between">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                        <i class="fas fa-align-left"></i>
                                    </div>

                                    <i class="fas fa-circle-check text-xl text-emerald-500 opacity-0 peer-checked:opacity-100"></i>

                                </div>

                                <h3 class="mt-3 font-bold text-slate-800">
                                    Esai
                                </h3>

                                <p class="mt-1 text-xs leading-relaxed text-slate-500">
                                    Siswa memberikan jawaban dalam bentuk uraian atau penjelasan.
                                </p>

                            </div>

                        </label>

                    </div>

                </div>


                {{-- =========================================
                     3. PILIHAN JAWABAN
                ========================================== --}}

                <div id="bagianPilihan"
                     class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">

                    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                                <i class="fas fa-list-ul"></i>
                            </div>

                            <div>

                                <h2 class="font-bold text-slate-800">
                                    Pilihan Jawaban
                                </h2>

                                <p class="text-xs text-slate-500">
                                    Tambahkan opsi dan tentukan jawaban yang benar.
                                </p>

                            </div>

                        </div>

                        <button type="button"
                                id="tambahOpsi"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">

                            <i class="fas fa-plus"></i>
                            Tambah Opsi

                        </button>

                    </div>


                    <div id="daftarOpsi" class="space-y-3">

                        @foreach ($opsiLama as $index => $opsi)

                            <div class="opsi-item rounded-xl border border-slate-200 bg-slate-50/70 p-4"
                                 data-index="{{ $index }}">

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white font-bold text-indigo-600 shadow-sm kode-label">
                                        {{ $opsi['kode'] ?? chr(65 + $index) }}
                                    </div>

                                    <input type="hidden"
                                           class="kode-opsi"
                                           name="opsi[{{ $index }}][kode]"
                                           value="{{ $opsi['kode'] ?? chr(65 + $index) }}">

                                    <div class="min-w-0 flex-1">

                                        <label class="mb-2 block text-xs font-semibold text-slate-600 label-opsi">
                                            Pilihan {{ $opsi['kode'] ?? chr(65 + $index) }}
                                        </label>

                                        <input type="text"
                                               name="opsi[{{ $index }}][teks]"
                                               value="{{ $opsi['teks'] ?? '' }}"
                                               placeholder="Masukkan pilihan jawaban..."
                                               class="input-teks-opsi w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">

                                    </div>

                                    <button type="button"
                                            class="hapus-opsi flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-500"
                                            title="Hapus pilihan">

                                        <i class="fas fa-trash-alt"></i>

                                    </button>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @error('opsi')
                        <p class="mt-3 text-sm text-red-500">{{ $message }}</p>
                    @enderror


                    {{-- KUNCI JAWABAN --}}
                    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50/60 p-5">

                        <div class="mb-3 flex items-center gap-2">

                            <i class="fas fa-check-circle text-emerald-600"></i>

                            <label for="jawaban_benar"
                                   class="text-sm font-bold text-slate-800">
                                Kunci Jawaban
                            </label>

                        </div>

                        <select name="jawaban_benar"
                                id="jawaban_benar"
                                class="w-full rounded-xl border border-emerald-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                        </select>

                        <p class="mt-2 text-xs text-slate-500">
                            Pilih opsi yang merupakan jawaban benar.
                        </p>

                        @error('jawaban_benar')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                    </div>

                </div>


                {{-- =========================================
                     4. PENGATURAN ESAI
                ========================================== --}}

                <div id="bagianEsai"
                     class="hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <i class="fas fa-clipboard-check"></i>
                        </div>

                        <div>

                            <h2 class="font-bold text-slate-800">
                                Pedoman Penilaian Esai
                            </h2>

                            <p class="text-xs text-slate-500">
                                Tentukan jawaban acuan dan kriteria penilaian siswa.
                            </p>

                        </div>

                    </div>


                    {{-- JAWABAN ACUAN --}}
                    <div class="mb-6">

                        <label for="jawaban_acuan"
                               class="mb-2 block text-sm font-semibold text-slate-700">

                            Jawaban Acuan
                            <span class="text-red-500">*</span>

                        </label>

                        <textarea id="jawaban_acuan"
                                  name="jawaban_acuan"
                                  rows="5"
                                  placeholder="Tuliskan contoh jawaban ideal atau konsep yang diharapkan dari siswa..."
                                  class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10">{{ old('jawaban_acuan') }}</textarea>

                        <p class="mt-2 text-xs text-slate-500">
                            Jawaban acuan digunakan sebagai pedoman pemeriksaan, bukan sebagai satu-satunya bentuk jawaban yang diterima.
                        </p>

                        @error('jawaban_acuan')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                    </div>


                    {{-- SKOR MAKSIMAL --}}
                    <div class="mb-8">

                        <label for="skor_maksimal"
                               class="mb-2 block text-sm font-semibold text-slate-700">

                            Skor Maksimal
                            <span class="text-red-500">*</span>

                        </label>

                        <div class="relative">

                            <input type="number"
                                   id="skor_maksimal"
                                   name="skor_maksimal"
                                   min="1"
                                   max="100"
                                   value="{{ old('skor_maksimal', 100) }}"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-20 text-sm font-semibold outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10">

                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-emerald-600">
                                Poin
                            </span>

                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            Skor maksimal menjadi dasar perhitungan nilai esai.
                        </p>

                    </div>


                    {{-- RUBRIK PENILAIAN --}}
                    <div>

                        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <div>

                                <h3 class="font-bold text-slate-800">
                                    Kriteria Penilaian
                                </h3>

                                <p class="mt-1 text-xs text-slate-500">
                                    Tambahkan aspek yang digunakan untuk menilai jawaban siswa.
                                </p>

                            </div>

                            <button type="button"
                                    id="tambahRubrik"
                                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">

                                <i class="fas fa-plus"></i>
                                Tambah Kriteria

                            </button>

                        </div>


                        <div id="daftarRubrik" class="space-y-4">

                            @foreach ($rubrikLama as $index => $item)

                                <div class="rubrik-item rounded-xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5"
                                     data-index="{{ $index }}">

                                    <div class="mb-4 flex items-center justify-between">

                                        <span class="nomor-rubrik rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700">
                                            KRITERIA {{ $index + 1 }}
                                        </span>

                                        <button type="button"
                                                class="hapus-rubrik flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-500">

                                            <i class="fas fa-trash-alt"></i>

                                        </button>

                                    </div>


                                    <div class="grid gap-4 sm:grid-cols-3">

                                        <div class="sm:col-span-2">

                                            <label class="mb-2 block text-xs font-semibold text-slate-600">
                                                Nama Kriteria
                                            </label>

                                            <input type="text"
                                                   name="rubrik_penilaian[{{ $index }}][nama]"
                                                   value="{{ $item['nama'] ?? '' }}"
                                                   placeholder="Contoh: Ketepatan Konsep"
                                                   class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-500">

                                        </div>


                                        <div>

                                            <label class="mb-2 block text-xs font-semibold text-slate-600">
                                                Bobot (%)
                                            </label>

                                            <input type="number"
                                                   name="rubrik_penilaian[{{ $index }}][bobot]"
                                                   value="{{ $item['bobot'] ?? 0 }}"
                                                   min="0"
                                                   max="100"
                                                   class="input-bobot w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-500">

                                        </div>

                                    </div>


                                    <div class="mt-4">

                                        <label class="mb-2 block text-xs font-semibold text-slate-600">
                                            Deskripsi Kriteria
                                        </label>

                                        <textarea name="rubrik_penilaian[{{ $index }}][deskripsi]"
                                                  rows="2"
                                                  placeholder="Jelaskan aspek yang dinilai..."
                                                  class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-500">{{ $item['deskripsi'] ?? '' }}</textarea>

                                    </div>

                                </div>

                            @endforeach

                        </div>


                        {{-- TOTAL BOBOT --}}
                        <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-5">

                            <div class="mb-3 flex items-center justify-between">

                                <span class="text-sm font-bold text-slate-700">
                                    Total Bobot Penilaian
                                </span>

                                <span id="totalBobot"
                                      class="text-xl font-bold text-emerald-600">
                                    100%
                                </span>

                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-slate-200">

                                <div id="progressBobot"
                                     class="h-full rounded-full bg-emerald-500 transition-all duration-300"
                                     style="width: 100%">
                                </div>

                            </div>

                            <p id="pesanBobot"
                               class="mt-3 text-xs text-emerald-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                Total bobot sudah sesuai.
                            </p>

                        </div>

                        @error('rubrik_penilaian')
                            <p class="mt-3 text-sm text-red-500">{{ $message }}</p>
                        @enderror

                    </div>

                </div>


                {{-- =========================================
                     5. EXP DAN PEMBAHASAN
                ========================================== --}}

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">

                    <div class="mb-6 flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <i class="fas fa-star"></i>
                        </div>

                        <div>

                            <h2 class="font-bold text-slate-800">
                                EXP dan Pembahasan
                            </h2>

                            <p class="text-xs text-slate-500">
                                Tentukan pengalaman yang diperoleh dan penjelasan jawaban.
                            </p>

                        </div>

                    </div>


                    {{-- EXP --}}
                    <div class="mb-6">

                        <label for="exp"
                               class="mb-2 block text-sm font-semibold text-slate-700">

                            EXP Soal
                            <span class="text-red-500">*</span>

                        </label>

                        <div class="relative">

                            <input type="number"
                                   id="exp"
                                   name="exp"
                                   min="0"
                                   max="1000"
                                   value="{{ old('exp', 10) }}"
                                   required
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-20 text-sm font-semibold outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">

                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-amber-500">
                                EXP
                            </span>

                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            EXP diberikan setelah jawaban siswa memperoleh nilai sesuai ketentuan sistem.
                        </p>

                    </div>


                    {{-- PEMBAHASAN --}}
                    <div>

                        <label for="pembahasan"
                               class="mb-2 block text-sm font-semibold text-slate-700">

                            Pembahasan Soal
                            <span class="font-normal text-slate-400">(Opsional)</span>

                        </label>

                        <textarea id="pembahasan"
                                  name="pembahasan"
                                  rows="4"
                                  placeholder="Tuliskan penjelasan atau pembahasan dari soal ini..."
                                  class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">{{ old('pembahasan') }}</textarea>

                    </div>

                </div>


                {{-- =========================================
                     6. TOMBOL AKSI
                ========================================== --}}

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">

                    <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">

                        <i class="fas fa-times"></i>
                        Batal

                    </a>

                    <button type="submit"
                            id="tombolSimpan"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-600/20 transition hover:-translate-y-0.5 hover:bg-indigo-700">

                        <i class="fas fa-save"></i>
                        Simpan Soal

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ================================================
    // ELEMEN DOM
    // ================================================

    const formSoal = document.getElementById('formSoal');

    const bagianPilihan = document.getElementById('bagianPilihan');
    const bagianEsai = document.getElementById('bagianEsai');

    const daftarOpsi = document.getElementById('daftarOpsi');
    const daftarRubrik = document.getElementById('daftarRubrik');

    const selectJawaban = document.getElementById('jawaban_benar');

    const totalBobot = document.getElementById('totalBobot');
    const progressBobot = document.getElementById('progressBobot');
    const pesanBobot = document.getElementById('pesanBobot');


    // ================================================
    // INDEX DINAMIS
    // ================================================

    let indexOpsi = Math.max(
        -1,
        ...Array.from(
            daftarOpsi.querySelectorAll('.opsi-item')
        ).map(item => Number(item.dataset.index))
    ) + 1;

    let indexRubrik = Math.max(
        -1,
        ...Array.from(
            daftarRubrik.querySelectorAll('.rubrik-item')
        ).map(item => Number(item.dataset.index))
    ) + 1;


    // ================================================
    // KODE OPSI A, B, C, ... AA, AB
    // ================================================

    function ambilKode(index) {

        let kode = '';
        let nomor = index;

        do {

            kode = String.fromCharCode(65 + (nomor % 26)) + kode;

            nomor = Math.floor(nomor / 26) - 1;

        } while (nomor >= 0);

        return kode;
    }


    // ================================================
    // MEMPERBARUI KUNCI JAWABAN
    // ================================================

    function perbaruiKunciJawaban() {

        const nilaiLama = selectJawaban.value;

        selectJawaban.innerHTML = '';

        daftarOpsi.querySelectorAll('.opsi-item').forEach(item => {

            const kode = item.querySelector('.kode-opsi').value;

            const option = document.createElement('option');

            option.value = kode;
            option.textContent = 'Pilihan ' + kode;

            selectJawaban.appendChild(option);

        });

        if (
            [...selectJawaban.options].some(
                option => option.value === nilaiLama
            )
        ) {

            selectJawaban.value = nilaiLama;

        }

    }


    // ================================================
    // MEMBUAT OPSI BARU
    // ================================================

    function buatOpsi(index) {

        const kode = ambilKode(index);

        const wrapper = document.createElement('div');

        wrapper.className =
            'opsi-item rounded-xl border border-slate-200 bg-slate-50/70 p-4';

        wrapper.dataset.index = index;

        wrapper.innerHTML = `
            <div class="flex flex-col gap-3 sm:flex-row sm:items-start">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white font-bold text-indigo-600 shadow-sm kode-label">
                    ${kode}
                </div>

                <input type="hidden"
                       class="kode-opsi"
                       name="opsi[${index}][kode]"
                       value="${kode}">

                <div class="min-w-0 flex-1">

                    <label class="mb-2 block text-xs font-semibold text-slate-600">
                        Pilihan ${kode}
                    </label>

                    <input type="text"
                           name="opsi[${index}][teks]"
                           placeholder="Masukkan pilihan jawaban..."
                           required
                           class="input-teks-opsi w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-indigo-500">

                </div>

                <button type="button"
                        class="hapus-opsi flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500">

                    <i class="fas fa-trash-alt"></i>

                </button>

            </div>
        `;

        return wrapper;
    }


    // ================================================
    // TAMBAH OPSI
    // ================================================

    document.getElementById('tambahOpsi').addEventListener('click', function () {

        if (daftarOpsi.querySelectorAll('.opsi-item').length >= 26) {

            alert('Maksimal 26 pilihan jawaban.');

            return;
        }

        daftarOpsi.appendChild(buatOpsi(indexOpsi));

        indexOpsi++;

        perbaruiKunciJawaban();

    });


    // ================================================
    // HAPUS OPSI
    // ================================================

    daftarOpsi.addEventListener('click', function (event) {

        const tombol = event.target.closest('.hapus-opsi');

        if (!tombol) return;

        const jumlah = daftarOpsi.querySelectorAll('.opsi-item').length;

        if (jumlah <= 2) {

            alert('Minimal harus tersedia 2 pilihan jawaban.');

            return;
        }

        tombol.closest('.opsi-item').remove();

        perbaruiKunciJawaban();

    });


    // ================================================
    // MEMBUAT RUBRIK BARU
    // ================================================

    function buatRubrik(index) {

        const wrapper = document.createElement('div');

        wrapper.className =
            'rubrik-item rounded-xl border border-slate-200 bg-slate-50/70 p-4 sm:p-5';

        wrapper.dataset.index = index;

        wrapper.innerHTML = `

            <div class="mb-4 flex items-center justify-between">

                <span class="nomor-rubrik rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-bold text-emerald-700">
                    KRITERIA
                </span>

                <button type="button"
                        class="hapus-rubrik flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 hover:bg-red-50 hover:text-red-500">

                    <i class="fas fa-trash-alt"></i>

                </button>

            </div>

            <div class="grid gap-4 sm:grid-cols-3">

                <div class="sm:col-span-2">

                    <label class="mb-2 block text-xs font-semibold text-slate-600">
                        Nama Kriteria
                    </label>

                    <input type="text"
                           name="rubrik_penilaian[${index}][nama]"
                           placeholder="Contoh: Ketepatan Konsep"
                           required
                           class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-500">

                </div>

                <div>

                    <label class="mb-2 block text-xs font-semibold text-slate-600">
                        Bobot (%)
                    </label>

                    <input type="number"
                           name="rubrik_penilaian[${index}][bobot]"
                           value="0"
                           min="0"
                           max="100"
                           required
                           class="input-bobot w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-500">

                </div>

            </div>

            <div class="mt-4">

                <label class="mb-2 block text-xs font-semibold text-slate-600">
                    Deskripsi Kriteria
                </label>

                <textarea name="rubrik_penilaian[${index}][deskripsi]"
                          rows="2"
                          required
                          placeholder="Jelaskan aspek yang dinilai..."
                          class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none focus:border-emerald-500"></textarea>

            </div>

        `;

        return wrapper;
    }


    // ================================================
    // TAMBAH RUBRIK
    // ================================================

    document.getElementById('tambahRubrik').addEventListener('click', function () {

        if (daftarRubrik.querySelectorAll('.rubrik-item').length >= 20) {

            alert('Maksimal 20 kriteria penilaian.');

            return;
        }

        daftarRubrik.appendChild(buatRubrik(indexRubrik));

        indexRubrik++;

        perbaruiBobot();

    });


    // ================================================
    // HAPUS RUBRIK
    // ================================================

    daftarRubrik.addEventListener('click', function (event) {

        const tombol = event.target.closest('.hapus-rubrik');

        if (!tombol) return;

        if (daftarRubrik.querySelectorAll('.rubrik-item').length <= 1) {

            alert('Minimal harus tersedia satu kriteria penilaian.');

            return;
        }

        tombol.closest('.rubrik-item').remove();

        perbaruiBobot();

    });


    // ================================================
    // MENGHITUNG TOTAL BOBOT
    // ================================================

    function perbaruiBobot() {

        let total = 0;

        daftarRubrik.querySelectorAll('.input-bobot').forEach(input => {

            total += Number(input.value) || 0;

        });

        totalBobot.textContent = total + '%';

        progressBobot.style.width = Math.min(total, 100) + '%';

        if (total === 100) {

            totalBobot.className =
                'text-xl font-bold text-emerald-600';

            progressBobot.className =
                'h-full rounded-full bg-emerald-500 transition-all duration-300';

            pesanBobot.className =
                'mt-3 text-xs text-emerald-600';

            pesanBobot.innerHTML =
                '<i class="fas fa-check-circle mr-1"></i> Total bobot sudah sesuai.';

        } else {

            totalBobot.className =
                'text-xl font-bold text-red-600';

            progressBobot.className =
                'h-full rounded-full bg-red-500 transition-all duration-300';

            pesanBobot.className =
                'mt-3 text-xs text-red-600';

            pesanBobot.innerHTML =
                '<i class="fas fa-circle-exclamation mr-1"></i> Total bobot harus tepat 100%.';

        }

        return total;
    }


    daftarRubrik.addEventListener('input', function (event) {

        if (event.target.classList.contains('input-bobot')) {

            perbaruiBobot();

        }

    });


    // ================================================
    // PERGANTIAN TIPE SOAL
    // ================================================

    function aturTipeSoal() {

        const tipe = document.querySelector(
            'input[name="tipe"]:checked'
        ).value;

        const isPilihanGanda = tipe === 'pilihan_ganda';

        bagianPilihan.classList.toggle(
            'hidden',
            !isPilihanGanda
        );

        bagianEsai.classList.toggle(
            'hidden',
            isPilihanGanda
        );


        // Nonaktifkan input pada bagian yang tidak digunakan
        bagianPilihan.querySelectorAll(
            'input, select, button, textarea'
        ).forEach(element => {

            element.disabled = !isPilihanGanda;

        });


        bagianEsai.querySelectorAll(
            'input, textarea, select, button'
        ).forEach(element => {

            element.disabled = isPilihanGanda;

        });


        // Required pilihan ganda
        daftarOpsi.querySelectorAll(
            '.input-teks-opsi'
        ).forEach(input => {

            input.required = isPilihanGanda;

        });


        // Required esai
        bagianEsai.querySelectorAll(
            '[name="jawaban_acuan"], [name="skor_maksimal"], [name$="[nama]"], [name$="[bobot]"], [name$="[deskripsi]"]'
        ).forEach(input => {

            input.required = !isPilihanGanda;

        });


        perbaruiKunciJawaban();

        perbaruiBobot();

    }


    // ================================================
    // EVENT RADIO
    // ================================================

    document.querySelectorAll('input[name="tipe"]').forEach(radio => {

        radio.addEventListener('change', aturTipeSoal);

    });


    // ================================================
    // VALIDASI SEBELUM SUBMIT
    // ================================================

    formSoal.addEventListener('submit', function (event) {

        const tipe = document.querySelector(
            'input[name="tipe"]:checked'
        ).value;


        if (tipe === 'pilihan_ganda') {

            const jumlahOpsi =
                daftarOpsi.querySelectorAll('.opsi-item').length;

            if (jumlahOpsi < 2) {

                event.preventDefault();

                alert('Minimal harus tersedia 2 pilihan jawaban.');

                return;
            }

        }


        if (tipe === 'esai') {

            const jumlahRubrik =
                daftarRubrik.querySelectorAll('.rubrik-item').length;

            if (jumlahRubrik < 1) {

                event.preventDefault();

                alert('Minimal harus tersedia satu kriteria penilaian.');

                return;
            }

            const total = perbaruiBobot();

            if (total !== 100) {

                event.preventDefault();

                alert('Total bobot rubrik harus tepat 100%.');

                return;
            }

        }

    });


    // ================================================
    // INISIALISASI
    // ================================================

    perbaruiKunciJawaban();

    aturTipeSoal();

});
</script>

@endpush
