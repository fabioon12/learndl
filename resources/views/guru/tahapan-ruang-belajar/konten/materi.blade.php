```blade
@extends('guru.layouts.app')

@section('title', 'Pilih Ruang Materi')

@section('content')

<div class="min-h-screen bg-gray-50 dark:bg-cyberdark-900 px-4 py-6 sm:px-6 lg:px-8">

    <div class="max-w-6xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-2">
                    <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}"
                       class="hover:text-indigo-600">
                        Tahapan Pembelajaran
                    </a>
                    <i class="fa-solid fa-chevron-right text-[9px]"></i>
                    <span class="text-indigo-600 font-semibold">Pilih Ruang Materi</span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 dark:text-white">
                    Hubungkan Ruang Materi
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    Pilih materi pembelajaran yang akan digunakan pada tahapan ini.
                </p>
            </div>

            <a href="{{ route('guru.ruang-belajar.tahapan.index', $ruangBelajar->id) }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-sm font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        {{-- INFORMASI TAHAPAN --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 p-5 sm:p-6 text-white shadow-lg">
            <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-white/10"></div>
            <div class="absolute right-20 -bottom-16 w-48 h-48 rounded-full bg-white/10"></div>

            <div class="relative flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-book-open text-xl"></i>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-semibold text-indigo-100 uppercase tracking-wider">
                        Tahapan Materi
                    </p>
                    <h2 class="text-lg sm:text-xl font-bold mt-1">
                        {{ $tahapan->judul_tahapan }}
                    </h2>
                    <p class="text-sm text-indigo-100 mt-1">
                        {{ $ruangBelajar->judul ?? 'Ruang Belajar' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm dark:bg-green-950/30 dark:border-green-900 dark:text-green-300">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm dark:bg-rose-950/30 dark:border-rose-900 dark:text-rose-300">
                <div class="font-bold mb-2">Terjadi kesalahan:</div>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- MATERI TERPILIH SEBELUMNYA --}}
        @if($tahapan->ruangMateri)
            <div class="rounded-2xl border border-green-200 bg-green-50 dark:bg-green-950/20 dark:border-green-900/50 p-5">
                <div class="flex items-start gap-3">
                    <div class="w-11 h-11 rounded-xl bg-green-100 dark:bg-green-900/50 flex items-center justify-center text-green-600 dark:text-green-400 shrink-0">
                        <i class="fa-solid fa-check text-lg"></i>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-green-700 dark:text-green-400">
                            MATERI SUDAH TERHUBUNG
                        </p>

                        <h3 class="font-bold text-gray-800 dark:text-white mt-1">
                            {{ $tahapan->ruangMateri->judul }}
                        </h3>

                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Anda dapat memilih materi lain untuk mengganti materi yang digunakan.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- JUDUL DAFTAR MATERI --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    Daftar Ruang Materi
                </h3>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Pilih salah satu materi yang tersedia untuk tahapan ini.
                </p>
            </div>

            <a href="{{ route('guru.materi.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-md transition">
                <i class="fa-solid fa-plus"></i>
                Buat Materi Baru
            </a>
        </div>

        {{-- DAFTAR MATERI --}}
        @if($ruangMateris->isNotEmpty())

            <form action="{{ route('guru.ruang-belajar.tahapan.konten.store', [$ruangBelajar->id, $tahapan->id]) }}"
                  method="POST"
                  id="form-pilih-materi">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                    @foreach($ruangMateris as $materi)

                        @php
                            $isSelected = (int) old(
                                'ruang_materi_id',
                                $tahapan->ruang_materi_id
                            ) === (int) $materi->id;

                            $totalXP = (int) ($materi->sub_materis_sum_xp_reward ?? 0);
                            $jumlahSubmateri = (int) ($materi->sub_materis_count ?? 0);
                        @endphp

                        <label class="materi-card relative cursor-pointer group">

                            <input type="radio"
                                   name="ruang_materi_id"
                                   value="{{ $materi->id }}"
                                   data-total-xp="{{ $totalXP }}"
                                   data-judul="{{ $materi->judul }}"
                                   data-jumlah-submateri="{{ $jumlahSubmateri }}"
                                   class="materi-radio peer sr-only"
                                   {{ $isSelected ? 'checked' : '' }}
                                   required>

                            <div class="h-full overflow-hidden rounded-2xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-cyberdark-800 transition-all duration-200 hover:-translate-y-1 hover:shadow-lg peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-100 dark:peer-checked:ring-indigo-900/40">

                                {{-- THUMBNAIL --}}
                                <div class="relative h-40 bg-gradient-to-br from-indigo-500 to-violet-600 overflow-hidden">

                                    @if($materi->thumbnail)
                                        <img src="{{ asset('storage/' . $materi->thumbnail) }}"
                                             alt="{{ $materi->judul }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fa-solid fa-book-open text-5xl text-white/80"></i>
                                        </div>
                                    @endif

                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                    {{-- CHECK ICON --}}
                                    <div class="absolute top-3 right-3">
                                        <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-indigo-600 shadow">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </div>

                                    <div class="absolute bottom-3 left-4 text-white">
                                        <span class="text-[10px] uppercase tracking-wider font-bold text-white/80">
                                            Ruang Materi
                                        </span>
                                    </div>
                                </div>

                                {{-- INFORMASI MATERI --}}
                                <div class="p-4 space-y-4">

                                    <div>
                                        <h4 class="font-bold text-gray-800 dark:text-white text-base line-clamp-2">
                                            {{ $materi->judul }}
                                        </h4>

                                        <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 min-h-8 mt-2">
                                            {{ $materi->deskripsi ?: 'Belum ada deskripsi materi.' }}
                                        </p>
                                    </div>

                                    {{-- STATISTIK MATERI --}}
                                    <div class="grid grid-cols-2 gap-3">

                                        <div class="rounded-xl bg-indigo-50 dark:bg-indigo-950/30 p-3">
                                            <div class="flex items-center gap-2 text-indigo-500 mb-1">
                                                <i class="fa-solid fa-layer-group text-xs"></i>
                                                <span class="text-[10px] font-semibold">Submateri</span>
                                            </div>

                                            <p class="text-lg font-extrabold text-gray-800 dark:text-white">
                                                {{ $jumlahSubmateri }}
                                            </p>
                                        </div>

                                        <div class="rounded-xl bg-amber-50 dark:bg-amber-950/30 p-3">
                                            <div class="flex items-center gap-2 text-amber-500 mb-1">
                                                <i class="fa-solid fa-bolt text-xs"></i>
                                                <span class="text-[10px] font-semibold">Total XP</span>
                                            </div>

                                            <p class="text-lg font-extrabold text-amber-600 dark:text-amber-400">
                                                {{ number_format($totalXP, 0, ',', '.') }}
                                            </p>
                                        </div>

                                    </div>

                                    {{-- PILIH MATERI --}}
                                    <div class="pt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">

                                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                            Hubungkan materi
                                        </span>

                                        <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400">
                                            Pilih Materi
                                            <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </span>

                                    </div>

                                </div>
                            </div>
                        </label>

                    @endforeach

                </div>

                {{-- RINGKASAN MATERI TERPILIH --}}
                <div id="ringkasanMateri"
                     class="mt-7 rounded-2xl border border-indigo-200 dark:border-indigo-900/50 bg-indigo-50 dark:bg-indigo-950/20 p-5">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div class="flex items-start gap-3">
                            <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-book-bookmark text-lg"></i>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                                    Ringkasan Pilihan
                                </p>

                                <h4 id="namaMateriTerpilih"
                                    class="font-bold text-gray-800 dark:text-white mt-1">
                                    Belum ada materi dipilih
                                </h4>

                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <span id="jumlahSubmateriTerpilih">0</span>
                                    submateri tersedia
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl bg-white dark:bg-cyberdark-800 border border-amber-200 dark:border-amber-900/40 px-5 py-3 min-w-[150px]">
                            <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Potensi Reward
                            </p>

                            <div class="flex items-center gap-2 mt-1">
                                <i class="fa-solid fa-bolt text-amber-500"></i>

                                <span id="totalMateriXP"
                                      class="text-2xl font-black text-amber-500">
                                    0
                                </span>

                                <span class="text-xs font-bold text-amber-500">
                                    XP
                                </span>
                            </div>
                        </div>

                    </div>

                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-4">
                        <i class="fa-solid fa-circle-info mr-1 text-indigo-500"></i>
                        Total XP merupakan akumulasi reward seluruh submateri. Siswa memperoleh XP secara bertahap setelah menyelesaikan setiap submateri.
                    </p>
                </div>

                {{-- TOMBOL SIMPAN --}}
                <div class="sticky bottom-4 z-20 mt-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 rounded-2xl bg-white/95 dark:bg-cyberdark-800/95 backdrop-blur border border-gray-200 dark:border-gray-700 shadow-xl">

                        <div>
                            <p class="text-sm font-bold text-gray-800 dark:text-white">
                                Simpan Materi
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Materi terpilih akan dihubungkan dengan tahapan ini.
                            </p>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold shadow-lg transition">
                            <i class="fa-solid fa-link"></i>
                            Hubungkan Materi
                        </button>

                    </div>
                </div>

            </form>

        @else

            {{-- EMPTY STATE --}}
            <div class="rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-cyberdark-800 p-10 text-center">

                <div class="w-20 h-20 mx-auto rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 flex items-center justify-center text-indigo-500 mb-5">
                    <i class="fa-solid fa-book-open text-3xl"></i>
                </div>

                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    Belum Ada Ruang Materi
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mt-2">
                    Anda belum memiliki Ruang Materi. Buat materi terlebih dahulu, kemudian hubungkan dengan tahapan pembelajaran ini.
                </p>

                <a href="{{ route('guru.ruang-materi.create') }}"
                   class="inline-flex items-center gap-2 mt-6 px-5 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold transition">
                    <i class="fa-solid fa-plus"></i>
                    Buat Ruang Materi
                </a>

            </div>

        @endif

    </div>
</div>

{{-- JAVASCRIPT TOTAL XP --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const pilihanMateri = document.querySelectorAll('.materi-radio');

    const namaMateri = document.getElementById('namaMateriTerpilih');
    const jumlahSubmateri = document.getElementById('jumlahSubmateriTerpilih');
    const totalXP = document.getElementById('totalMateriXP');

    function formatAngka(angka) {
        return Number(angka || 0).toLocaleString('id-ID');
    }

    function perbaruiRingkasan(radio) {

        if (!radio) {
            if (namaMateri) namaMateri.textContent = 'Belum ada materi dipilih';
            if (jumlahSubmateri) jumlahSubmateri.textContent = '0';
            if (totalXP) totalXP.textContent = '0';
            return;
        }

        const xp = Number(radio.dataset.totalXp || 0);
        const jumlah = Number(radio.dataset.jumlahSubmateri || 0);

        if (namaMateri) {
            namaMateri.textContent = radio.dataset.judul || 'Materi terpilih';
        }

        if (jumlahSubmateri) {
            jumlahSubmateri.textContent = formatAngka(jumlah);
        }

        if (totalXP) {
            totalXP.textContent = formatAngka(xp);
        }
    }

    pilihanMateri.forEach(function (radio) {
        radio.addEventListener('change', function () {
            perbaruiRingkasan(this);
        });
    });

    // Tampilkan materi yang sudah terpilih saat halaman pertama kali dibuka
    const materiTerpilih = document.querySelector('.materi-radio:checked');

    perbaruiRingkasan(materiTerpilih);

});
</script>

@endsection
