
@extends('siswa.layouts.app')

@section('title', 'Kerjakan Ujian - ' . $ruangUjian->judul)

@section('content')

@php
    $totalSoal = $soalUjians->count();

    $sisaDetik = max(
        0,
        now()->diffInSeconds($batasWaktu, false)
    );

    $jawabanTersimpan = $jawabanSaya ?? collect();
@endphp

<div
    x-data="ujianApp({
        totalSoal: {{ $totalSoal }},
        sisaDetik: {{ $sisaDetik }}
    })"
    x-init="init()"
    class="min-h-screen pb-10 text-gray-800 dark:text-gray-100"
>
    {{-- HEADER UJIAN --}}
    <div class="mb-6">
        <a href="{{ route('siswa.ujian.index') }}"
           class="inline-flex items-center gap-2 mb-4 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke Daftar Ujian
        </a>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">
                        <i class="fa-solid fa-clipboard-check mr-1"></i>
                        Ujian Berlangsung
                    </span>
                </div>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $ruangUjian->judul }}
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    {{ $ruangUjian->deskripsi ?? 'Kerjakan seluruh soal dengan teliti dan perhatikan waktu ujian.' }}
                </p>
            </div>

            {{-- TIMER --}}
            <div
                class="flex items-center gap-4 p-4 rounded-2xl border shadow-sm transition"
                :class="sisaDetik <= 300
                    ? 'bg-red-50 border-red-200 dark:bg-red-500/10 dark:border-red-500/30'
                    : 'bg-white border-gray-200 dark:bg-cyberdark-800 dark:border-cyberdark-700'"
            >
                <div
                    class="w-12 h-12 rounded-xl flex items-center justify-center"
                    :class="sisaDetik <= 300
                        ? 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400'
                        : 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400'"
                >
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>

                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                        Sisa Waktu
                    </p>

                    <p class="text-2xl font-black tabular-nums"
                       :class="sisaDetik <= 300 ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white'"
                       x-text="formatWaktu()">
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- PROGRESS --}}
    <div class="bg-white dark:bg-cyberdark-800 rounded-2xl border border-gray-200 dark:border-cyberdark-700 p-5 mb-6 shadow-sm">
        <div class="flex items-center justify-between gap-3 mb-3">
            <div>
                <p class="text-sm font-bold text-gray-800 dark:text-white">
                    Progres Pengerjaan
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Jawab seluruh soal sebelum mengumpulkan ujian.
                </p>
            </div>

            <div class="text-right">
                <p class="text-xl font-black text-blue-600 dark:text-blue-400">
                    <span x-text="jumlahTerjawab"></span>/{{ $totalSoal }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Soal terjawab</p>
            </div>
        </div>

        <div class="w-full h-2.5 bg-gray-100 dark:bg-cyberdark-700 rounded-full overflow-hidden">
            <div
                class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full transition-all duration-300"
                :style="'width: ' + progress + '%'"
            ></div>
        </div>
    </div>

    <form
        id="formUjian"
        action="{{ route('siswa.ujian.selesaikan', $hasilUjian->id) }}"
        method="POST"
        @submit="return konfirmasiKumpulkan($event)"
    >
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- BAGIAN SOAL --}}
            <div class="lg:col-span-8 space-y-5">

                @foreach($soalUjians as $index => $soal)
                    @php
                        $jawabanLama = $jawabanTersimpan->get($soal->id)?->jawaban_siswa;
                        $opsiSoal = is_array($soal->opsi)
                            ? $soal->opsi
                            : [];
                    @endphp

                    <div
                        id="soal-{{ $index + 1 }}"
                        x-show="nomorAktif === {{ $index + 1 }}"
                        x-cloak
                        class="bg-white dark:bg-cyberdark-800 rounded-2xl border border-gray-200 dark:border-cyberdark-700 shadow-sm overflow-hidden"
                    >
                        {{-- HEADER SOAL --}}
                        <div class="p-5 md:p-6 border-b border-gray-100 dark:border-cyberdark-700">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 flex items-center justify-center font-black">
                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white">
                                            Soal Nomor {{ $index + 1 }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $soal->tipe === 'esai' ? 'Soal Esai' : 'Pilihan Ganda' }}
                                        </p>
                                    </div>
                                </div>

                                <span class="text-xs font-bold px-3 py-1.5 rounded-lg bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400">
                                    {{ $soal->exp }} EXP
                                </span>
                            </div>
                        </div>

                        {{-- ISI SOAL --}}
                        <div class="p-5 md:p-7">
                            <div class="text-base md:text-lg leading-relaxed font-medium text-gray-800 dark:text-gray-100 whitespace-pre-line">
                                {{ $soal->pertanyaan }}
                            </div>

                            {{-- PILIHAN GANDA --}}
                            @if($soal->tipe === 'pilihan_ganda')
                                <div class="mt-7 space-y-3">
                                    @foreach($opsiSoal as $opsi)
                                        @php
                                            $kode = $opsi['kode'] ?? '';
                                            $teks = $opsi['teks'] ?? '';
                                        @endphp

                                        <label
                                            class="flex items-start gap-4 p-4 rounded-xl border cursor-pointer transition-all duration-200"
                                            :class="jawaban[{{ $soal->id }}] === @js($kode)
                                                ? 'border-blue-500 bg-blue-50 dark:bg-blue-500/10 dark:border-blue-400'
                                                : 'border-gray-200 dark:border-cyberdark-700 hover:border-blue-300 dark:hover:border-blue-500/50'"
                                        >
                                            <input
                                                type="radio"
                                                name="jawaban[{{ $soal->id }}]"
                                                value="{{ $kode }}"
                                                x-model="jawaban[{{ $soal->id }}]"
                                                @checked($jawabanLama === $kode)
                                                class="mt-1 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                            >

                                            <span
                                                class="w-8 h-8 shrink-0 rounded-lg flex items-center justify-center text-sm font-bold"
                                                :class="jawaban[{{ $soal->id }}] === @js($kode)
                                                    ? 'bg-blue-600 text-white'
                                                    : 'bg-gray-100 text-gray-600 dark:bg-cyberdark-700 dark:text-gray-300'"
                                            >
                                                {{ $kode }}
                                            </span>

                                            <span class="flex-1 text-sm md:text-base text-gray-700 dark:text-gray-200 leading-relaxed">
                                                {{ $teks }}
                                            </span>

                                            <i
                                                x-show="jawaban[{{ $soal->id }}] === @js($kode)"
                                                class="fa-solid fa-circle-check text-blue-600 dark:text-blue-400 mt-1"
                                            ></i>
                                        </label>
                                    @endforeach
                                </div>

                            {{-- ESAI --}}
                            @else
                                <div class="mt-7">
                                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">
                                        Tuliskan Jawaban Anda
                                    </label>

                                    <textarea
                                        name="jawaban[{{ $soal->id }}]"
                                        x-model="jawaban[{{ $soal->id }}]"
                                        rows="7"
                                        placeholder="Tuliskan jawaban Anda secara jelas dan sistematis..."
                                        class="w-full rounded-xl border border-gray-200 dark:border-cyberdark-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-800 dark:text-gray-100 p-4 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-y placeholder:text-gray-400"
                                    >{{ $jawabanLama }}</textarea>

                                    <p class="text-xs text-gray-400 mt-2">
                                        <i class="fa-solid fa-circle-info mr-1"></i>
                                        Pastikan jawaban Anda sudah sesuai dengan pertanyaan.
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- NAVIGASI BAWAH --}}
                        <div class="p-5 border-t border-gray-100 dark:border-cyberdark-700 flex items-center justify-between gap-3">
                            <button
                                type="button"
                                @click="sebelumnya()"
                                :disabled="nomorAktif === 1"
                                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-cyberdark-700 text-sm font-bold text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-cyberdark-700 disabled:opacity-40 disabled:cursor-not-allowed transition"
                            >
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                Sebelumnya
                            </button>

                            <button
                                type="button"
                                @click="selanjutnya()"
                                x-show="nomorAktif < totalSoal"
                                class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold transition shadow-lg shadow-blue-500/20"
                            >
                                Selanjutnya
                                <i class="fa-solid fa-arrow-right ml-2"></i>
                            </button>

                            <button
                                type="button"
                                @click="bukaKonfirmasi()"
                                x-show="nomorAktif === totalSoal"
                                class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold transition"
                            >
                                <i class="fa-solid fa-check mr-2"></i>
                                Selesai
                            </button>
                        </div>
                    </div>
                @endforeach

                @if($totalSoal === 0)
                    <div class="bg-white dark:bg-cyberdark-800 rounded-2xl border border-gray-200 dark:border-cyberdark-700 p-10 text-center">
                        <i class="fa-solid fa-circle-exclamation text-4xl text-amber-500 mb-4"></i>
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">
                            Belum Ada Soal
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Ujian ini belum memiliki soal yang dapat dikerjakan.
                        </p>
                    </div>
                @endif
            </div>

            {{-- SIDEBAR NAVIGASI --}}
            <div class="lg:col-span-4">
                <div class="lg:sticky lg:top-6 space-y-5">

                    <div class="bg-white dark:bg-cyberdark-800 rounded-2xl border border-gray-200 dark:border-cyberdark-700 shadow-sm p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-900 dark:text-white">
                                Navigasi Soal
                            </h3>

                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $totalSoal }} Soal
                            </span>
                        </div>

                        <div class="grid grid-cols-5 gap-2">
                            @foreach($soalUjians as $index => $soal)
                                <button
                                    type="button"
                                    @click="pindahKe({{ $index + 1 }})"
                                    class="aspect-square rounded-xl text-sm font-bold border transition-all"
                                    :class="nomorAktif === {{ $index + 1 }}
                                        ? 'bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-500/20'
                                        : (sudahDijawab({{ $soal->id }})
                                            ? 'bg-emerald-50 text-emerald-700 border-emerald-300 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/30'
                                            : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-blue-400 dark:bg-cyberdark-900 dark:text-gray-300 dark:border-cyberdark-700')"
                                >
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-5 space-y-2.5">
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="w-3 h-3 rounded bg-blue-600"></span>
                                Soal sedang dibuka
                            </div>

                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="w-3 h-3 rounded bg-emerald-500"></span>
                                Sudah dijawab
                            </div>

                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                <span class="w-3 h-3 rounded bg-gray-200 dark:bg-cyberdark-700"></span>
                                Belum dijawab
                            </div>
                        </div>
                    </div>

                    {{-- RINGKASAN --}}
                    <div class="bg-white dark:bg-cyberdark-800 rounded-2xl border border-gray-200 dark:border-cyberdark-700 shadow-sm p-5">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                            Ringkasan Jawaban
                        </h3>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 rounded-xl bg-emerald-50 dark:bg-emerald-500/10">
                                <p class="text-xs text-emerald-700 dark:text-emerald-400">
                                    Terjawab
                                </p>
                                <p class="text-2xl font-black text-emerald-700 dark:text-emerald-400 mt-1"
                                   x-text="jumlahTerjawab"></p>
                            </div>

                            <div class="p-3 rounded-xl bg-amber-50 dark:bg-amber-500/10">
                                <p class="text-xs text-amber-700 dark:text-amber-400">
                                    Belum dijawab
                                </p>
                                <p class="text-2xl font-black text-amber-700 dark:text-amber-400 mt-1"
                                   x-text="totalSoal - jumlahTerjawab"></p>
                            </div>
                        </div>

                        <button
                            type="button"
                            @click="bukaKonfirmasi()"
                            class="w-full mt-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm transition shadow-lg shadow-emerald-500/20"
                            @if($totalSoal === 0) disabled @endif
                        >
                            <i class="fa-solid fa-paper-plane mr-2"></i>
                            Kumpulkan Ujian
                        </button>

                        <p class="text-xs text-center text-gray-400 mt-3">
                            Periksa kembali jawaban sebelum dikumpulkan.
                        </p>
                    </div>

                    {{-- INFORMASI --}}
                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-100 dark:bg-blue-500/10 dark:border-blue-500/20">
                        <div class="flex gap-3">
                            <i class="fa-solid fa-lightbulb text-blue-600 dark:text-blue-400 mt-1"></i>
                            <div>
                                <p class="text-sm font-bold text-blue-800 dark:text-blue-300">
                                    Tips Mengerjakan
                                </p>
                                <p class="text-xs text-blue-700 dark:text-blue-400 mt-1 leading-relaxed">
                                    Baca pertanyaan dengan teliti, manfaatkan waktu dengan baik, dan pastikan semua jawaban sudah diperiksa.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    {{-- MODAL KONFIRMASI --}}
    <div
        x-show="modalKonfirmasi"
        x-cloak
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
        @keydown.escape.window="modalKonfirmasi = false"
    >
        <div
            @click.outside="modalKonfirmasi = false"
            x-transition
            class="w-full max-w-md bg-white dark:bg-cyberdark-800 rounded-3xl shadow-2xl p-6"
        >
            <div class="w-16 h-16 rounded-2xl bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-paper-plane"></i>
            </div>

            <h3 class="text-xl font-black text-center text-gray-900 dark:text-white mt-5">
                Kumpulkan Ujian?
            </h3>

            <p class="text-sm text-center text-gray-500 dark:text-gray-400 mt-2">
                Pastikan Anda telah memeriksa seluruh jawaban. Setelah dikumpulkan, ujian tidak dapat dikerjakan kembali.
            </p>

            <div class="grid grid-cols-2 gap-3 mt-6">
                <button
                    type="button"
                    @click="modalKonfirmasi = false"
                    class="py-3 rounded-xl border border-gray-200 dark:border-cyberdark-700 text-gray-600 dark:text-gray-300 font-bold text-sm hover:bg-gray-50 dark:hover:bg-cyberdark-700 transition"
                >
                    Periksa Lagi
                </button>

                <button
                    type="button"
                    @click="kirimUjian()"
                    class="py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm transition"
                >
                    Ya, Kumpulkan
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL WAKTU HABIS --}}
    <div
        x-show="waktuHabis"
        x-cloak
        class="fixed inset-0 z-[10000] flex items-center justify-center p-4 bg-black/70"
    >
        <div class="w-full max-w-sm bg-white dark:bg-cyberdark-800 rounded-3xl p-7 text-center shadow-2xl">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-clock"></i>
            </div>

            <h3 class="text-xl font-black text-gray-900 dark:text-white mt-5">
                Waktu Ujian Habis!
            </h3>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Jawaban Anda sedang dikumpulkan secara otomatis.
            </p>

            <div class="mt-5 flex justify-center">
                <i class="fa-solid fa-spinner fa-spin text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function ujianApp(config) {
        return {
            totalSoal: config.totalSoal,
            sisaDetik: config.sisaDetik,
            nomorAktif: 1,
            jawaban: {},
            modalKonfirmasi: false,
            waktuHabis: false,
            sudahMengirim: false,

            init() {
                this.$nextTick(() => {
                    // Ambil jawaban awal dari input yang sudah terisi.
                    document.querySelectorAll('#formUjian input[type="radio"]:checked')
                        .forEach(input => {
                            const id = input.name.match(/\d+/)?.[0];
                            if (id) this.jawaban[id] = input.value;
                        });

                    document.querySelectorAll('#formUjian textarea')
                        .forEach(textarea => {
                            const id = textarea.name.match(/\d+/)?.[0];
                            if (id && textarea.value.trim() !== '') {
                                this.jawaban[id] = textarea.value;
                            }
                        });
                });

                if (this.sisaDetik <= 0) {
                    this.akhiriOtomatis();
                    return;
                }

                this.intervalTimer = setInterval(() => {
                    if (this.sisaDetik > 0) {
                        this.sisaDetik--;
                    }

                    if (this.sisaDetik <= 0) {
                        this.akhiriOtomatis();
                    }
                }, 1000);
            },

            get jumlahTerjawab() {
                return Object.values(this.jawaban).filter(value =>
                    value !== null &&
                    value !== undefined &&
                    String(value).trim() !== ''
                ).length;
            },

            get progress() {
                if (this.totalSoal === 0) return 0;
                return (this.jumlahTerjawab / this.totalSoal) * 100;
            },

            formatWaktu() {
                const totalDetik = Math.max(0, Math.floor(this.sisaDetik));

                const menit = Math.floor(totalDetik / 60);
                const detik = totalDetik % 60;

                return `${String(menit).padStart(2, '0')}:${String(detik).padStart(2, '0')}`;
            },

            sudahDijawab(id) {
                const value = this.jawaban[id];

                return value !== null &&
                    value !== undefined &&
                    String(value).trim() !== '';
            },

            pindahKe(nomor) {
                this.nomorAktif = nomor;

                this.$nextTick(() => {
                    document.getElementById('soal-' + nomor)?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            },

            sebelumnya() {
                if (this.nomorAktif > 1) {
                    this.pindahKe(this.nomorAktif - 1);
                }
            },

            selanjutnya() {
                if (this.nomorAktif < this.totalSoal) {
                    this.pindahKe(this.nomorAktif + 1);
                }
            },

            bukaKonfirmasi() {
                this.modalKonfirmasi = true;
            },

            konfirmasiKumpulkan(event) {
                if (this.sudahMengirim) return true;

                event.preventDefault();
                this.modalKonfirmasi = true;
                return false;
            },

            kirimUjian() {
                if (this.sudahMengirim) return;

                this.sudahMengirim = true;
                clearInterval(this.intervalTimer);

                document.getElementById('formUjian').submit();
            },

            akhiriOtomatis() {
                if (this.sudahMengirim) return;

                this.sudahMengirim = true;
                this.waktuHabis = true;

                clearInterval(this.intervalTimer);

                document.getElementById('formUjian').submit();
            }
        }
    }
</script>
@endpush
