
@extends('siswa.layouts.app')

@section('title', 'Daftar Ujian')

@section('content')

<div class="min-h-screen bg-slate-50 dark:bg-cyberdark-900 px-4 py-6 sm:px-6 lg:px-8 transition-colors duration-300">

    <div class="mx-auto max-w-7xl space-y-8">

        {{-- HEADER --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-blue-600 to-blue-500 p-6 sm:p-8 shadow-lg shadow-blue-500/10">

            <div class="relative z-10 max-w-2xl">

                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-green-300"></span>
                    Pusat Ujian Siswa
                </span>

                <h1 class="mt-4 text-2xl font-bold tracking-tight text-white sm:text-3xl">
                    Tingkatkan Kemampuanmu!
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-6 text-blue-100 sm:text-base">
                    Temukan dan ikuti berbagai ujian yang tersedia untuk menguji
                    pemahaman serta kemampuanmu. Kerjakan dengan teliti dan raih
                    hasil terbaikmu.
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <a href="#daftar-ujian"
                       class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-indigo-700 shadow-lg transition hover:bg-blue-50">
                        Jelajahi Ujian
                        <i class="fa-solid fa-arrow-down"></i>
                    </a>

                    <span class="text-xs font-medium text-blue-100">
                        {{ $totalUjian }} ujian tersedia
                    </span>

                </div>

            </div>

            {{-- DEKORASI HEADER --}}
            <div class="pointer-events-none absolute -right-10 -top-20 h-72 w-72 rounded-full border-[35px] border-white/10"></div>

            <div class="pointer-events-none absolute -bottom-28 right-28 h-64 w-64 rounded-full border-[30px] border-white/10"></div>

            <div class="pointer-events-none absolute bottom-5 right-8 hidden lg:block">
                <div class="flex h-36 w-36 items-center justify-center rounded-3xl bg-white/10 backdrop-blur-sm">
                    <i class="fa-solid fa-clipboard-check text-7xl text-white/90"></i>
                </div>
            </div>

        </div>


        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-400">
                <i class="fa-solid fa-circle-check mt-0.5 text-xl"></i>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-500/20 dark:bg-red-500/10 dark:text-red-400">
                <i class="fa-solid fa-circle-exclamation mt-0.5 text-xl"></i>
                <p class="text-sm font-medium">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="flex items-start gap-3 rounded-2xl border border-blue-200 bg-blue-50 p-4 text-blue-700 dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-400">
                <i class="fa-solid fa-circle-info mt-0.5 text-xl"></i>
                <p class="text-sm font-medium">{{ session('info') }}</p>
            </div>
        @endif


        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- TOTAL UJIAN --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md dark:border-cyberdark-700 dark:bg-cyberdark-800">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-gray-400">
                            Total Ujian
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                            {{ $totalUjian }}
                        </h3>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <i class="fa-solid fa-clipboard-list text-xl"></i>
                    </div>

                </div>

                <p class="mt-3 text-xs text-slate-400 dark:text-gray-500">
                    Seluruh ujian aktif
                </p>

            </div>


            {{-- BELUM DIKERJAKAN --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md dark:border-cyberdark-700 dark:bg-cyberdark-800">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-gray-400">
                            Belum Dikerjakan
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                            {{ $totalTersedia }}
                        </h3>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        <i class="fa-solid fa-clock text-xl"></i>
                    </div>

                </div>

                <p class="mt-3 text-xs text-slate-400 dark:text-gray-500">
                    Ujian yang bisa dimulai
                </p>

            </div>


            {{-- BERLANGSUNG --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md dark:border-cyberdark-700 dark:bg-cyberdark-800">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-gray-400">
                            Sedang Berlangsung
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                            {{ $totalBerlangsung }}
                        </h3>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                        <i class="fa-solid fa-spinner text-xl"></i>
                    </div>

                </div>

                <p class="mt-3 text-xs text-slate-400 dark:text-gray-500">
                    Ujian yang belum selesai
                </p>

            </div>


            {{-- SELESAI --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-md dark:border-cyberdark-700 dark:bg-cyberdark-800">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-gray-400">
                            Selesai
                        </p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800 dark:text-white">
                            {{ $totalSelesai }}
                        </h3>
                    </div>

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>

                </div>

                <p class="mt-3 text-xs text-slate-400 dark:text-gray-500">
                    Ujian yang telah diselesaikan
                </p>

            </div>

        </div>


        {{-- DAFTAR UJIAN --}}
        <section id="daftar-ujian" class="space-y-5">

            {{-- JUDUL DAN PENCARIAN --}}
            <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">

                <div>

                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 dark:text-indigo-400">
                        Eksplorasi Evaluasi
                    </span>

                    <h2 class="mt-1 text-xl font-bold text-slate-800 dark:text-white sm:text-2xl">
                        Daftar Ruang Ujian
                    </h2>

                    <p class="mt-1 text-sm text-slate-500 dark:text-gray-400">
                        Pilih ujian yang ingin kamu ikuti dan tingkatkan pemahamanmu.
                    </p>

                </div>


                {{-- SEARCH --}}
                <div class="relative w-full sm:w-72">

                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-base text-slate-400 dark:text-gray-500"></i>

                    <input
                        type="text"
                        id="searchUjian"
                        placeholder="Cari nama ujian..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 dark:border-cyberdark-700 dark:bg-cyberdark-800 dark:text-gray-200 dark:placeholder:text-gray-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500/10"
                    >

                </div>

            </div>


            {{-- FILTER --}}
            <div class="flex flex-wrap gap-2" id="filterUjian">

                <button type="button"
                        data-filter="semua"
                        class="filter-btn rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Semua Ujian
                </button>

                <button type="button"
                        data-filter="tersedia"
                        class="filter-btn rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-cyberdark-700 dark:bg-cyberdark-800 dark:text-gray-300 dark:hover:bg-cyberdark-700">
                    Belum Dikerjakan
                </button>

                <button type="button"
                        data-filter="berlangsung"
                        class="filter-btn rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-cyberdark-700 dark:bg-cyberdark-800 dark:text-gray-300 dark:hover:bg-cyberdark-700">
                    Berlangsung
                </button>

                <button type="button"
                        data-filter="selesai"
                        class="filter-btn rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 dark:border-cyberdark-700 dark:bg-cyberdark-800 dark:text-gray-300 dark:hover:bg-cyberdark-700">
                    Selesai
                </button>

            </div>


            {{-- GRID UJIAN --}}
            <div id="gridUjian" class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">

                @forelse($ruangUjians as $ujian)

                    @php
                        $statusSiswa = $ujian->status_siswa;
                        $hasilSaya = $ujian->hasil_saya;

                        $statusLabel = match($statusSiswa) {
                            'berlangsung' => 'Sedang Berlangsung',
                            'selesai' => 'Sudah Selesai',
                            default => 'Belum Dikerjakan'
                        };

                        $statusClass = match($statusSiswa) {
                            'berlangsung' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-300',
                            'selesai' => 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-300',
                            default => 'bg-amber-50 text-amber-700 dark:bg-amber-500/15 dark:text-amber-300'
                        };
                    @endphp

                    <article
                        class="ujian-card group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-cyberdark-700 dark:bg-cyberdark-800 dark:hover:shadow-black/20"
                        data-status="{{ $statusSiswa }}"
                        data-search="{{ strtolower($ujian->judul . ' ' . ($ujian->deskripsi ?? '')) }}"
                    >

                        {{-- CARD HEADER --}}
                        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 to-blue-500 p-5">

                            <div class="absolute -right-8 -top-10 h-32 w-32 rounded-full border-[18px] border-white/10"></div>

                            <div class="relative flex items-start justify-between gap-3">

                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-white backdrop-blur">
                                    <i class="fa-solid fa-file-lines text-xl"></i>
                                </div>

                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>

                            </div>

                            <h3 class="relative mt-5 min-h-14 text-lg font-bold text-white line-clamp-2">
                                {{ $ujian->judul }}
                            </h3>

                            <p class="relative mt-1 min-h-10 text-sm leading-5 text-blue-100 line-clamp-2">
                                {{ $ujian->deskripsi ?: 'Uji pemahaman dan kemampuanmu melalui evaluasi ini.' }}
                            </p>

                        </div>


                        {{-- CARD BODY --}}
                        <div class="flex flex-1 flex-col p-5">

                            {{-- INFORMASI UJIAN --}}
                            <div class="grid grid-cols-3 gap-3">

                                <div class="rounded-xl bg-slate-50 p-3 text-center dark:bg-cyberdark-900">
                                    <i class="fa-solid fa-file-circle-question text-xl text-indigo-600 dark:text-indigo-400"></i>

                                    <p class="mt-1 text-lg font-bold text-slate-800 dark:text-white">
                                        {{ $ujian->soal_count }}
                                    </p>

                                    <p class="text-xs text-slate-500 dark:text-gray-400">
                                        Soal
                                    </p>
                                </div>

                                <div class="rounded-xl bg-slate-50 p-3 text-center dark:bg-cyberdark-900">
                                    <i class="fa-solid fa-clock text-xl text-amber-600 dark:text-amber-400"></i>

                                    <p class="mt-1 text-lg font-bold text-slate-800 dark:text-white">
                                        {{ $ujian->durasi_menit }}
                                    </p>

                                    <p class="text-xs text-slate-500 dark:text-gray-400">
                                        Menit
                                    </p>
                                </div>

                                <div class="rounded-xl bg-slate-50 p-3 text-center dark:bg-cyberdark-900">
                                    <i class="fa-solid fa-star text-xl text-yellow-500"></i>

                                    <p class="mt-1 text-lg font-bold text-slate-800 dark:text-white">
                                        {{ $ujian->soal_sum_exp ?? 0 }}
                                    </p>

                                    <p class="text-xs text-slate-500 dark:text-gray-400">
                                        Total EXP
                                    </p>
                                </div>

                            </div>


                            {{-- NILAI JIKA SELESAI --}}
                            @if($statusSiswa === 'selesai')

                                <div class="mt-4 flex items-center justify-between rounded-xl border border-green-100 bg-green-50 px-4 py-3 dark:border-green-500/20 dark:bg-green-500/10">

                                    <div>
                                        <p class="text-xs font-medium text-green-700 dark:text-green-400">
                                            Nilai kamu
                                        </p>

                                        <p class="mt-1 text-xl font-bold text-green-800 dark:text-green-300">
                                            {{ number_format($hasilSaya->nilai, 2, ',', '.') }}
                                        </p>
                                    </div>

                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-green-600 dark:bg-green-500/10 dark:text-green-400">
                                        <i class="fa-solid fa-trophy text-xl"></i>
                                    </div>

                                </div>

                            @elseif($statusSiswa === 'berlangsung')

                                <div class="mt-4 rounded-xl border border-indigo-100 bg-indigo-50 px-4 py-3 dark:border-indigo-500/20 dark:bg-indigo-500/10">

                                    <p class="text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                        Kamu memiliki ujian yang belum selesai.
                                    </p>

                                    <p class="mt-1 text-xs text-indigo-600 dark:text-indigo-400">
                                        Lanjutkan pengerjaan untuk menyelesaikan ujian.
                                    </p>

                                </div>

                            @else

                                <div class="mt-4 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 dark:border-amber-500/20 dark:bg-amber-500/10">

                                    <p class="text-xs font-semibold text-amber-800 dark:text-amber-300">
                                        Ujian tersedia untuk dikerjakan.
                                    </p>

                                    <p class="mt-1 text-xs text-amber-700 dark:text-amber-400">
                                        Pastikan kamu siap sebelum memulai.
                                    </p>

                                </div>

                            @endif


                            {{-- ACTION --}}
                            <div class="mt-auto pt-5">

                                @if($statusSiswa === 'selesai')

                                    <a href="{{ route('siswa.ujian.hasil', $hasilSaya->id) }}"
                                       class="flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-green-700">
                                        <i class="fa-solid fa-chart-column"></i>
                                        Lihat Nilai
                                    </a>

                                @elseif($statusSiswa === 'berlangsung')

                                    <a href="{{ route('siswa.ujian.kerjakan', $hasilSaya->id) }}"
                                       class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-indigo-700">
                                        <i class="fa-solid fa-play"></i>
                                        Lanjutkan Ujian
                                    </a>

                                @else

                                    <a href="{{ route('siswa.ujian.detail', $ujian->id) }}"
                                       class="flex w-full items-center justify-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm font-bold text-indigo-700 transition hover:bg-indigo-100 dark:border-indigo-500/30 dark:bg-indigo-500/10 dark:text-indigo-300 dark:hover:bg-indigo-500/20">
                                        <i class="fa-solid fa-eye"></i>
                                        Lihat Detail Ujian
                                    </a>

                                @endif

                            </div>

                        </div>

                    </article>

                @empty

                    {{-- EMPTY DATA --}}
                    <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center dark:border-cyberdark-600 dark:bg-cyberdark-800">

                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-cyberdark-900 dark:text-gray-500">
                            <i class="fa-solid fa-clipboard-list text-4xl"></i>
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-slate-800 dark:text-white">
                            Belum Ada Ujian Tersedia
                        </h3>

                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-gray-400">
                            Saat ini belum ada Ruang Ujian aktif yang dapat kamu ikuti.
                            Silakan kembali lagi nanti.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- EMPTY FILTER --}}
            <div id="emptyFilter"
                 class="hidden rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center dark:border-cyberdark-600 dark:bg-cyberdark-800">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-cyberdark-900 dark:text-gray-500">
                    <i class="fa-solid fa-magnifying-glass text-3xl"></i>
                </div>

                <h3 class="mt-3 font-bold text-slate-700 dark:text-white">
                    Ujian Tidak Ditemukan
                </h3>

                <p class="mt-1 text-sm text-slate-500 dark:text-gray-400">
                    Tidak ada ujian yang sesuai dengan pencarian atau filter.
                </p>

                <button type="button"
                        id="resetFilter"
                        class="mt-4 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Reset Pencarian
                </button>

            </div>

        </section>

    </div>

</div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchUjian');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.ujian-card');
    const emptyFilter = document.getElementById('emptyFilter');
    const resetButton = document.getElementById('resetFilter');

    if (!searchInput || !emptyFilter) return;

    let activeFilter = 'semua';

    function filterUjian() {

        const keyword = searchInput.value.toLowerCase().trim();

        let visibleCount = 0;

        cards.forEach(card => {

            const status = card.dataset.status;
            const searchText = card.dataset.search || '';

            const cocokStatus =
                activeFilter === 'semua' ||
                status === activeFilter;

            const cocokSearch =
                searchText.includes(keyword);

            const tampil = cocokStatus && cocokSearch;

            card.classList.toggle('hidden', !tampil);

            if (tampil) {
                visibleCount++;
            }

        });

        emptyFilter.classList.toggle(
            'hidden',
            visibleCount !== 0 || cards.length === 0
        );
    }


    // PENCARIAN
    searchInput.addEventListener('input', filterUjian);


    // FILTER STATUS
    filterButtons.forEach(button => {

        button.addEventListener('click', function () {

            activeFilter = this.dataset.filter;

            filterButtons.forEach(btn => {

                const aktif = btn === this;

                btn.classList.toggle('bg-indigo-600', aktif);
                btn.classList.toggle('text-white', aktif);

                btn.classList.toggle('border', !aktif);
                btn.classList.toggle('border-slate-200', !aktif);
                btn.classList.toggle('bg-white', !aktif);
                btn.classList.toggle('text-slate-600', !aktif);

                btn.classList.toggle('dark:border-cyberdark-700', !aktif);
                btn.classList.toggle('dark:bg-cyberdark-800', !aktif);
                btn.classList.toggle('dark:text-gray-300', !aktif);

            });

            filterUjian();

        });

    });


    // RESET PENCARIAN DAN FILTER
    if (resetButton) {

        resetButton.addEventListener('click', function () {

            searchInput.value = '';
            activeFilter = 'semua';

            filterButtons.forEach(btn => {

                const aktif = btn.dataset.filter === 'semua';

                btn.classList.toggle('bg-indigo-600', aktif);
                btn.classList.toggle('text-white', aktif);

                btn.classList.toggle('border', !aktif);
                btn.classList.toggle('border-slate-200', !aktif);
                btn.classList.toggle('bg-white', !aktif);
                btn.classList.toggle('text-slate-600', !aktif);

                btn.classList.toggle('dark:border-cyberdark-700', !aktif);
                btn.classList.toggle('dark:bg-cyberdark-800', !aktif);
                btn.classList.toggle('dark:text-gray-300', !aktif);

            });

            filterUjian();

        });

    }

});
</script>

@endpush
