
@extends('guru.layouts.app')

@section('title', 'Buat Ruang Ujian')

@section('content')

<div class="w-full space-y-6 pb-10">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('guru.ruang-ujian.index') }}" class="transition hover:text-indigo-600">
                    Ruang Ujian
                </a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="font-medium text-indigo-600">Buat Baru</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-800">
                Buat Ruang Ujian
            </h1>
            <p class="mt-1 text-sm text-gray-500">
                Buat dan konfigurasi ruang ujian untuk digunakan dalam tahapan pembelajaran.
            </p>
        </div>

        <a href="{{ route('guru.ruang-ujian.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 shadow-sm transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-red-500"></i>
                <div>
                    <p class="text-sm font-semibold text-red-700">
                        Terdapat kesalahan pada pengisian formulir.
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

    <form action="{{ route('guru.ruang-ujian.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-3">

            {{-- KOLOM FORM --}}
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
                                Lengkapi informasi dasar ruang ujian.
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
                                value="{{ old('judul') }}"
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
                            >{{ old('deskripsi') }}</textarea>

                            @error('deskripsi')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                            <p class="mt-2 text-xs text-gray-400">
                                Deskripsi ini dapat membantu siswa memahami tujuan ujian.
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
                                        value="{{ old('durasi_menit', 30) }}"
                                        required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-20 text-sm text-gray-700 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-50"
                                    >
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-400">
                                        Menit
                                    </span>
                                </div>

                                <p class="mt-1.5 text-xs text-gray-400">
                                    Maksimal 600 menit.
                                </p>

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
                                        value="{{ old('maksimal_percobaan', 1) }}"
                                        required
                                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 pr-20 text-sm text-gray-700 outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-4 focus:ring-indigo-50"
                                    >
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-medium text-gray-400">
                                        Kali
                                    </span>
                                </div>

                                <p class="mt-1.5 text-xs text-gray-400">
                                    Maksimal 20 kali percobaan.
                                </p>

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
                                    {{ old('acak_soal') ? 'checked' : '' }}
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
                                    {{ old('acak_jawaban') ? 'checked' : '' }}
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
                                Tentukan status ruang ujian setelah dibuat.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-3 sm:p-6">

                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:border-amber-300 has-[:checked]:border-amber-400 has-[:checked]:bg-amber-50">
                            <input
                                type="radio"
                                name="status"
                                value="draft"
                                {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}
                                class="mt-0.5 h-4 w-4 accent-amber-500"
                            >
                            <div>
                                <span class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                    Draft
                                </span>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Masih dalam tahap penyusunan.
                                </p>
                            </div>
                        </label>

                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:border-emerald-300 has-[:checked]:border-emerald-400 has-[:checked]:bg-emerald-50">
                            <input
                                type="radio"
                                name="status"
                                value="aktif"
                                {{ old('status') === 'aktif' ? 'checked' : '' }}
                                class="mt-0.5 h-4 w-4 accent-emerald-500"
                            >
                            <div>
                                <span class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Siap digunakan pada tahapan.
                                </p>
                            </div>
                        </label>

                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-gray-200 p-4 transition hover:border-gray-300 has-[:checked]:border-gray-400 has-[:checked]:bg-gray-50">
                            <input
                                type="radio"
                                name="status"
                                value="nonaktif"
                                {{ old('status') === 'nonaktif' ? 'checked' : '' }}
                                class="mt-0.5 h-4 w-4 accent-gray-500"
                            >
                            <div>
                                <span class="flex items-center gap-2 text-sm font-bold text-gray-700">
                                    <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                                    Nonaktif
                                </span>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Tidak digunakan sementara.
                                </p>
                            </div>
                        </label>

                        @error('status')
                            <p class="text-xs text-red-500 sm:col-span-3">{{ $message }}</p>
                        @enderror

                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex flex-col-reverse justify-end gap-3 rounded-2xl border border-gray-100 bg-white p-4 shadow-sm sm:flex-row sm:p-5">

                    <a href="{{ route('guru.ruang-ujian.index') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-100 transition hover:bg-indigo-700 active:scale-[0.98]">
                        <i class="fa-solid fa-plus"></i>
                        Buat Ruang Ujian
                    </button>

                </div>

            </div>

            {{-- SIDEBAR INFORMASI --}}
            <div class="space-y-5 xl:sticky xl:top-6">

                {{-- ALUR PEMBUATAN --}}
                <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <i class="fa-solid fa-route"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">
                                Langkah Selanjutnya
                            </h3>
                            <p class="text-xs text-gray-400">
                                Alur pembuatan ujian
                            </p>
                        </div>
                    </div>

                    <div class="space-y-5">

                        <div class="flex gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-xs font-bold text-white">
                                1
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">
                                    Buat Ruang Ujian
                                </p>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Lengkapi informasi dan pengaturan ujian.
                                </p>
                                <span class="mt-2 inline-flex rounded-md bg-indigo-50 px-2 py-1 text-[10px] font-semibold text-indigo-600">
                                    Sedang dilakukan
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs font-bold text-gray-500">
                                2
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">
                                    Tambahkan Soal
                                </p>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Masukkan pertanyaan, pilihan jawaban, kunci, dan EXP.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-xs font-bold text-gray-500">
                                3
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-700">
                                    Hubungkan ke Tahapan
                                </p>
                                <p class="mt-1 text-xs leading-relaxed text-gray-400">
                                    Pilih ruang ujian pada tahapan Pre-Test atau Post-Test.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- INFORMASI RUANG UJIAN --}}
                <div class="overflow-hidden rounded-2xl border border-indigo-100 bg-indigo-50/60 p-5">
                    <div class="mb-3 flex items-center gap-2 text-indigo-700">
                        <i class="fa-solid fa-circle-info"></i>
                        <h3 class="text-sm font-bold">Informasi</h3>
                    </div>

                    <p class="text-xs leading-relaxed text-indigo-700/80">
                        Ruang ujian dibuat secara terpisah dari tahapan pembelajaran. Satu ruang ujian dapat digunakan kembali pada tahapan yang sesuai.
                    </p>
                </div>

                {{-- EXP --}}
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
                        EXP ditentukan pada setiap soal. Total EXP ruang ujian dihitung dari akumulasi EXP seluruh soal yang dibuat.
                    </p>
                </div>

            </div>

        </div>
    </form>
</div>

@endsection
