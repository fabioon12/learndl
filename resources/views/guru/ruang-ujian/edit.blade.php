
@extends('guru.layouts.app')

@section('title', 'Edit Ruang Ujian')

@section('content')

@php
    $statusConfig = [
        'draft' => [
            'label' => 'Draft',
            'dot' => 'bg-amber-400',
            'active' => 'border-amber-400 bg-amber-50',
            'accent' => 'accent-amber-500',
        ],
        'aktif' => [
            'label' => 'Aktif',
            'dot' => 'bg-emerald-500',
            'active' => 'border-emerald-400 bg-emerald-50',
            'accent' => 'accent-emerald-500',
        ],
        'nonaktif' => [
            'label' => 'Nonaktif',
            'dot' => 'bg-gray-400',
            'active' => 'border-gray-400 bg-gray-50',
            'accent' => 'accent-gray-500',
        ],
    ];

    $currentStatus = old('status', $ruangUjian->status);
@endphp

<div class="w-full space-y-6 pb-10">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex flex-wrap items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('guru.ruang-ujian.index') }}"
                   class="transition hover:text-indigo-600">
                    Ruang Ujian
                </a>

                <i class="fa-solid fa-chevron-right text-[10px]"></i>

                <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
                   class="transition hover:text-indigo-600">
                    Detail Ujian
                </a>

                <i class="fa-solid fa-chevron-right text-[10px]"></i>

                <span class="font-medium text-indigo-600">Edit</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-800">
                Edit Ruang Ujian
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Perbarui informasi dan konfigurasi ruang ujian.
            </p>
        </div>

        <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Detail
        </a>
    </div>

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-500"></i>

                <div>
                    <p class="text-sm font-semibold text-red-700">
                        Periksa kembali data yang Anda masukkan.
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-xs text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- INFORMASI RINGKAS --}}
    <div class="flex flex-col gap-4 rounded-2xl border border-indigo-100 bg-gradient-to-r from-indigo-50 to-white p-5 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                <i class="fa-solid fa-file-signature text-xl"></i>
            </div>

            <div>
                <p class="text-xs font-medium text-indigo-500">
                    Sedang mengedit
                </p>

                <h2 class="mt-1 text-base font-bold text-gray-800">
                    {{ $ruangUjian->judul }}
                </h2>

                <p class="mt-1 text-xs text-gray-400">
                    Dibuat {{ $ruangUjian->created_at?->format('d M Y') ?? '-' }}
                </p>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <div class="rounded-xl border border-white bg-white px-4 py-2.5">
                <p class="text-[10px] font-medium text-gray-400">Total Soal</p>
                <p class="mt-1 text-sm font-bold text-gray-800">
                    {{ $ruangUjian->soal_count ?? $ruangUjian->soal()->count() }}
                </p>
            </div>

            <div class="rounded-xl border border-white bg-white px-4 py-2.5">
                <p class="text-[10px] font-medium text-gray-400">Total EXP</p>
                <p class="mt-1 text-sm font-bold text-amber-500">
                    {{ number_format($ruangUjian->soal_sum_exp ?? $ruangUjian->soal()->sum('exp')) }}
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('guru.ruang-ujian.update', $ruangUjian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">

            {{-- FORM UTAMA --}}
            <div class="space-y-6 xl:col-span-2">

                {{-- INFORMASI DASAR --}}
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-5 sm:px-6">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <i class="fa-solid fa-file-lines text-lg"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-gray-800">
                                Informasi Ruang Ujian
                            </h2>
                            <p class="mt-0.5 text-xs text-gray-400">
                                Perbarui informasi dasar ruang ujian.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-5 p-5 sm:p-6">

                        <div>
                            <label for="judul" class="mb-2 block text-sm font-semibold text-gray-700">
                                Judul Ruang Ujian
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                type="text"
                                id="judul"
                                name="judul"
                                value="{{ old('judul', $ruangUjian->judul) }}"
                                placeholder="Contoh: Ujian Dasar Pemrograman"
                                required
                                class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-50 @error('judul') border-red-400 @enderror"
                            >

                            @error('judul')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="deskripsi" class="mb-2 block text-sm font-semibold text-gray-700">
                                Deskripsi Ruang Ujian
                                <span class="font-normal text-gray-400">(Opsional)</span>
                            </label>

                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                placeholder="Tuliskan gambaran umum, tujuan, atau petunjuk pelaksanaan ujian..."
                                class="w-full resize-y rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700 outline-none transition placeholder:text-gray-400 focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-50 @error('deskripsi') border-red-400 @enderror"
                            >{{ old('deskripsi', $ruangUjian->deskripsi) }}</textarea>

                            @error('deskripsi')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-xs text-gray-400">
                                Deskripsi membantu siswa memahami tujuan ujian.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- PENGATURAN UJIAN --}}
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-5 sm:px-6">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-sliders text-lg"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-gray-800">
                                Pengaturan Ujian
                            </h2>
                            <p class="mt-0.5 text-xs text-gray-400">
                                Atur durasi dan kesempatan pengerjaan ujian.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-6 p-5 sm:p-6">

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                            <div>
                                <label for="durasi_menit" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Durasi Ujian
                                    <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        id="durasi_menit"
                                        name="durasi_menit"
                                        min="1"
                                        max="600"
                                        value="{{ old('durasi_menit', $ruangUjian->durasi_menit) }}"
                                        required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-20 text-sm text-gray-700 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-50 @error('durasi_menit') border-red-400 @enderror"
                                    >

                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-400">
                                        Menit
                                    </span>
                                </div>

                                @error('durasi_menit')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="maksimal_percobaan" class="mb-2 block text-sm font-semibold text-gray-700">
                                    Maksimal Percobaan
                                    <span class="text-red-500">*</span>
                                </label>

                                <div class="relative">
                                    <input
                                        type="number"
                                        id="maksimal_percobaan"
                                        name="maksimal_percobaan"
                                        min="1"
                                        max="20"
                                        value="{{ old('maksimal_percobaan', $ruangUjian->maksimal_percobaan) }}"
                                        required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-20 text-sm text-gray-700 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-50 @error('maksimal_percobaan') border-red-400 @enderror"
                                    >

                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-400">
                                        Kali
                                    </span>
                                </div>

                                @error('maksimal_percobaan')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="border-t border-gray-100 pt-5">
                            <h3 class="mb-4 text-sm font-bold text-gray-800">
                                Pengacakan Ujian
                            </h3>

                            {{-- ACAK SOAL --}}
                            <label for="acak_soal"
                                   class="flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-gray-100 p-4 transition hover:border-indigo-200 hover:bg-indigo-50/30">

                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
                                        <i class="fa-solid fa-shuffle"></i>
                                    </div>

                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            Acak Urutan Soal
                                        </p>
                                        <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                            Urutan soal berbeda untuk setiap siswa.
                                        </p>
                                    </div>
                                </div>

                                <input
                                    type="checkbox"
                                    id="acak_soal"
                                    name="acak_soal"
                                    value="1"
                                    {{ old('acak_soal', $ruangUjian->acak_soal) ? 'checked' : '' }}
                                    class="h-5 w-5 shrink-0 cursor-pointer rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                >
                            </label>

                            {{-- ACAK JAWABAN --}}
                            <label for="acak_jawaban"
                                   class="mt-3 flex cursor-pointer items-center justify-between gap-4 rounded-xl border border-gray-100 p-4 transition hover:border-indigo-200 hover:bg-indigo-50/30">

                                <div class="flex items-start gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                        <i class="fa-solid fa-list-ol"></i>
                                    </div>

                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            Acak Pilihan Jawaban
                                        </p>
                                        <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                            Urutan pilihan jawaban diacak untuk setiap siswa.
                                        </p>
                                    </div>
                                </div>

                                <input
                                    type="checkbox"
                                    id="acak_jawaban"
                                    name="acak_jawaban"
                                    value="1"
                                    {{ old('acak_jawaban', $ruangUjian->acak_jawaban) ? 'checked' : '' }}
                                    class="h-5 w-5 shrink-0 cursor-pointer rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                >
                            </label>
                        </div>

                    </div>
                </div>

                {{-- STATUS --}}
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">

                    <div class="flex items-center gap-3 border-b border-gray-100 px-5 py-5 sm:px-6">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <i class="fa-solid fa-toggle-on text-lg"></i>
                        </div>

                        <div>
                            <h2 class="text-base font-bold text-gray-800">
                                Status Ruang Ujian
                            </h2>
                            <p class="mt-0.5 text-xs text-gray-400">
                                Tentukan status ruang ujian.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-3 sm:p-6">

                        @foreach ($statusConfig as $value => $config)
                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:border-indigo-200 has-[:checked]:{{ $config['active'] }}">
                                <input
                                    type="radio"
                                    name="status"
                                    value="{{ $value }}"
                                    {{ $currentStatus === $value ? 'checked' : '' }}
                                    class="mt-0.5 h-4 w-4 {{ $config['accent'] }}"
                                >

                                <div>
                                    <span class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                        <span class="h-2 w-2 rounded-full {{ $config['dot'] }}"></span>
                                        {{ $config['label'] }}
                                    </span>

                                    <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                        @if ($value === 'draft')
                                            Masih dalam tahap penyusunan.
                                        @elseif ($value === 'aktif')
                                            Siap digunakan pada tahapan.
                                        @else
                                            Tidak digunakan sementara.
                                        @endif
                                    </p>
                                </div>
                            </label>
                        @endforeach

                        @error('status')
                            <p class="text-xs text-red-500 sm:col-span-3">{{ $message }}</p>
                        @enderror

                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex flex-col-reverse justify-end gap-3 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:flex-row sm:p-5">

                    <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
                       class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-100 transition hover:bg-indigo-700 active:scale-[0.98]">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-5 xl:sticky xl:top-6">

                {{-- PETUNJUK --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">

                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-gray-800">
                                Panduan Pengaturan
                            </h3>
                            <p class="text-xs text-gray-400">
                                Hal yang perlu diperhatikan
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">

                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-clock mt-0.5 text-indigo-500"></i>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">Durasi Ujian</p>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Tentukan waktu yang cukup agar siswa dapat mengerjakan seluruh soal.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-rotate mt-0.5 text-indigo-500"></i>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">Maksimal Percobaan</p>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Atur jumlah kesempatan siswa dalam mengikuti ujian.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="fa-solid fa-shuffle mt-0.5 text-indigo-500"></i>
                            <div>
                                <p class="text-xs font-semibold text-gray-700">Pengacakan</p>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Pengacakan membantu memberikan variasi urutan soal dan jawaban.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- PERINGATAN --}}
                <div class="rounded-2xl border border-amber-100 bg-amber-50 p-5">
                    <div class="mb-3 flex items-center gap-2 text-amber-700">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <h3 class="text-sm font-bold">Perhatian</h3>
                    </div>

                    <p class="text-xs leading-relaxed text-amber-700/80">
                        Perubahan pengaturan ujian dapat memengaruhi pelaksanaan ujian berikutnya. Jika ruang ujian sudah pernah dikerjakan siswa, pertimbangkan dampaknya terhadap percobaan yang sedang berlangsung.
                    </p>
                </div>

                {{-- INFORMASI EXP --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="mb-3 flex items-center gap-2">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-500">
                            <i class="fa-solid fa-star"></i>
                        </div>

                        <h3 class="text-sm font-bold text-gray-800">
                            Sistem EXP
                        </h3>
                    </div>

                    <p class="text-xs leading-relaxed text-gray-500">
                        Total EXP dihitung dari akumulasi EXP seluruh soal. Mengubah konfigurasi ruang ujian tidak otomatis mengubah nilai EXP pada masing-masing soal.
                    </p>

                    <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
                       class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                        Lihat detail ruang ujian
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>

@endsection
