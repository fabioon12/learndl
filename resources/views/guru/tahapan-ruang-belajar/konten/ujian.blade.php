
@extends('guru.layouts.app')

@section('title', 'Pilih Ruang Ujian')

@section('content')

<div class="space-y-6">

    <div>
        <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}"
           class="text-sm text-gray-500 hover:text-blue-600">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Kembali ke Tahapan
        </a>

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-4">
            {{ $tahapan->tipe === 'pre_test' ? 'Pilih Pre-Test' : 'Pilih Post-Test' }}
        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            Pilih Ruang Ujian yang akan digunakan pada tahapan
            {{ $tahapan->judul_tahapan }}.
        </p>
    </div>

    @if($ruangUjians->isEmpty())
        <div class="bg-white dark:bg-cyberdark-800 rounded-2xl border border-gray-200 dark:border-cyberdark-700 p-10 text-center">
            <i class="fa-solid fa-file-circle-question text-4xl text-gray-400 mb-4"></i>

            <h3 class="font-bold text-gray-800 dark:text-white">
                Belum Ada Ruang Ujian
            </h3>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Buat dan aktifkan Ruang Ujian terlebih dahulu sebelum memasangnya pada tahapan ini.
            </p>

            <a href="{{ route('guru.ruang-ujian.create') }}"
               class="inline-flex items-center gap-2 mt-5 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold">
                <i class="fa-solid fa-plus"></i>
                Buat Ruang Ujian
            </a>
        </div>
    @else

        <form action="{{ route('guru.ruang-belajar.tahapan.konten.store', [$ruangBelajar->id, $tahapan->id]) }}"
              method="POST">

            @csrf

            @if($tahapan->ruang_ujian_id)
                <div class="mb-5 p-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-300 text-sm">
                    Ruang Ujian sudah dipilih. Kamu dapat memilih ujian lain untuk menggantinya.
                </div>
            @endif

            @error('ruang_ujian_id')
                <div class="mb-4 text-sm text-red-600">
                    {{ $message }}
                </div>
            @enderror

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                @foreach($ruangUjians as $ujian)
                    <label class="cursor-pointer block">

                        <input type="radio"
                               name="ruang_ujian_id"
                               value="{{ $ujian->id }}"
                               class="peer sr-only"
                               {{ (string) old('ruang_ujian_id', $tahapan->ruang_ujian_id) === (string) $ujian->id ? 'checked' : '' }}
                               required>

                        <div class="h-full bg-white dark:bg-cyberdark-800 border-2 border-gray-200 dark:border-cyberdark-700 rounded-2xl p-5 transition peer-checked:border-blue-600 peer-checked:bg-blue-50/50 dark:peer-checked:bg-blue-500/10 hover:border-blue-400">

                            <div class="flex items-start justify-between gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl">
                                    <i class="fa-solid fa-file-pen"></i>
                                </div>

                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                    Aktif
                                </span>
                            </div>

                            <h3 class="font-bold text-gray-900 dark:text-white mt-4">
                                {{ $ujian->judul }}
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 line-clamp-2">
                                {{ $ujian->deskripsi ?: 'Tidak ada deskripsi ujian.' }}
                            </p>

                            <div class="flex flex-wrap gap-3 mt-5 text-xs text-gray-500 dark:text-gray-400">
                                <span>
                                    <i class="fa-solid fa-list-ol mr-1"></i>
                                    {{ $ujian->soal_count }} Soal
                                </span>

                                <span>
                                    <i class="fa-regular fa-clock mr-1"></i>
                                    {{ $ujian->durasi_menit }} Menit
                                </span>
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100 dark:border-cyberdark-700 flex items-center justify-between">
                                <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                    Pilih Ujian
                                </span>

                                <i class="fa-solid fa-circle-check text-gray-300 peer-checked:text-blue-600"></i>
                            </div>

                        </div>
                    </label>
                @endforeach

            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold shadow-lg shadow-blue-500/20">
                    <i class="fa-solid fa-link mr-2"></i>
                    Pasang Ruang Ujian
                </button>
            </div>

        </form>
    @endif

</div>

@endsection
