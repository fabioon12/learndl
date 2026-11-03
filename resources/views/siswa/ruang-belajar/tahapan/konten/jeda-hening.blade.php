
@extends('siswa.layouts.app')

@section('title', 'Pengerjaan Jeda Hening')

@php
    $instruksi = $konten['instruksi'] ?? 'Ambil waktu sejenak untuk menenangkan pikiran dan mempersiapkan diri sebelum melanjutkan pembelajaran.';

    $durasi = (int) ($konten['durasi'] ?? 60);
    $durasi = max(10, $durasi);

    $checkIn = $konten['check_in'] ?? [];
    $checkInAktif = (bool) ($checkIn['aktif'] ?? false);

    $pertanyaan = $checkIn['pertanyaan'] ?? 'Bagaimana kondisi diri Anda saat ini?';
    $pilihan = $checkIn['pilihan'] ?? [];

    $pilihanDefault = [
        'Sangat siap dan bersemangat',
        'Cukup siap untuk belajar',
        'Kurang fokus saat ini',
        'Belum siap untuk belajar',
    ];

    if ($checkInAktif && count($pilihan) === 0) {
        $pilihan = $pilihanDefault;
    }
@endphp

@push('styles')
<style>
    .breathing-circle {
        animation: breathing 5s ease-in-out infinite;
    }

    @keyframes breathing {
        0%, 100% {
            transform: scale(.88);
            opacity: .75;
        }
        50% {
            transform: scale(1.08);
            opacity: 1;
        }
    }

    .choice-card {
        transition: all .2s ease;
    }

    .choice-card:has(input:checked) {
        border-color: #10b981;
        background: #ecfdf5;
        box-shadow: 0 0 0 2px rgba(16,185,129,.12);
    }

    .dark .choice-card:has(input:checked) {
        background: rgba(16,185,129,.12);
    }

    .choice-card:hover {
        transform: translateY(-2px);
    }

    .timer-number {
        font-variant-numeric: tabular-nums;
    }
</style>
@endpush

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                <i class="fa-solid fa-spa text-emerald-600 dark:text-emerald-400 text-xl"></i>
            </div>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-[.2em] text-emerald-600 dark:text-emerald-400">
                    Aktivitas Pembelajaran
                </p>

                <h1 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">
                    Jeda Hening
                </h1>
            </div>
        </div>

        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 text-xs font-bold">
            <i class="fa-solid fa-leaf"></i>
            Waktu untuk diri sendiri
        </span>

    </div>

    {{-- INFORMASI TAHAPAN --}}
    <div class="bg-white dark:bg-cyberdark-900 rounded-3xl border border-gray-100 dark:border-gray-800 p-5 sm:p-6">

        <div class="flex items-start gap-3">

            <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <i class="fa-solid fa-book-open text-blue-600 dark:text-blue-400"></i>
            </div>

            <div class="min-w-0">
                <p class="text-[10px] uppercase tracking-wider font-bold text-gray-400">
                    Ruang Belajar
                </p>

                <h2 class="font-black text-gray-900 dark:text-white mt-1">
                    {{ $ruangBelajar->judul ?? 'Ruang Belajar' }}
                </h2>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $tahapan->judul_tahapan }}
                </p>
            </div>

        </div>

    </div>

    {{-- KONTEN UTAMA --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-teal-50 dark:from-emerald-950/30 dark:via-cyberdark-900 dark:to-teal-950/20 rounded-[2rem] border border-emerald-100 dark:border-emerald-900/40 p-6 sm:p-10">

        {{-- DEKORASI --}}
        <div class="absolute -top-20 -right-20 w-64 h-64 rounded-full bg-emerald-200/30 dark:bg-emerald-500/5 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl mx-auto text-center">

            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 dark:bg-gray-800/70 border border-emerald-100 dark:border-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[10px] font-black uppercase tracking-widest mb-6">
                <i class="fa-solid fa-heart"></i>
                Berhenti sejenak, persiapkan diri
            </div>

            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 dark:text-white leading-tight">
                Tenangkan Pikiranmu
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mt-4">
                {{ $instruksi }}
            </p>

            {{-- ANIMASI PERNAPASAN --}}
            <div class="flex justify-center my-9">

                <div class="relative w-52 h-52 flex items-center justify-center">

                    <div class="absolute inset-0 rounded-full bg-emerald-200/40 dark:bg-emerald-500/10"></div>

                    <div class="absolute inset-4 rounded-full bg-teal-200/50 dark:bg-teal-500/10"></div>

                    <div class="breathing-circle relative w-36 h-36 rounded-full bg-gradient-to-br from-emerald-300 to-teal-500 shadow-xl shadow-emerald-500/20 flex flex-col items-center justify-center">

                        <i class="fa-solid fa-leaf text-white text-3xl mb-2"></i>

                        <span class="text-white text-xs font-black tracking-widest">
                            BERNAPAS
                        </span>

                    </div>

                </div>

            </div>

            {{-- TIMER --}}
            <div class="bg-white/90 dark:bg-gray-800/80 rounded-3xl border border-emerald-100 dark:border-gray-700 p-6 shadow-sm">

                <p class="text-[10px] uppercase tracking-[.2em] font-black text-gray-400 mb-3">
                    Waktu jeda hening
                </p>

                <div id="timer" class="timer-number text-5xl sm:text-6xl font-black text-emerald-600 dark:text-emerald-400">
                    00:{{ str_pad($durasi, 2, '0', STR_PAD_LEFT) }}
                </div>

                <p id="timer-message" class="text-xs font-semibold text-gray-500 dark:text-gray-400 mt-3">
                    Luangkan waktu untuk mengikuti instruksi di atas.
                </p>

                {{-- PROGRESS TIMER --}}
                <div class="w-full h-2.5 rounded-full bg-gray-100 dark:bg-gray-700 mt-6 overflow-hidden">
                    <div
                        id="timer-progress"
                        class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-500 transition-all duration-1000"
                        style="width: 0%">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2">
                    <span class="text-[9px] text-gray-400 font-bold">MULAI</span>
                    <span class="text-[9px] text-gray-400 font-bold">SELESAI</span>
                </div>

            </div>

        </div>

    </div>

    {{-- CHECK-IN --}}
    @if ($checkInAktif)

        <div id="checkin-section" class="bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 p-6 sm:p-8">

            <div class="flex items-start gap-4 mb-6">

                <div class="w-12 h-12 shrink-0 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-clipboard-question text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>

                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-purple-600 dark:text-purple-400">
                        Check-in Kondisi Diri
                    </span>

                    <h3 class="text-lg font-black text-gray-900 dark:text-white mt-1">
                        Bagaimana perasaanmu sekarang?
                    </h3>

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Pilih jawaban yang paling menggambarkan kondisimu saat ini.
                    </p>
                </div>

            </div>

            <div class="rounded-2xl bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-900/30 p-4 mb-5">
                <p class="text-sm font-bold text-purple-900 dark:text-purple-200">
                    {{ $pertanyaan }}
                </p>
            </div>

            <div class="space-y-3">

                @foreach ($pilihan as $index => $opsi)

                    <label class="choice-card flex items-center gap-3 p-4 rounded-2xl border border-gray-200 dark:border-gray-700 cursor-pointer">

                        <input
                            type="radio"
                            name="check_in_jawaban"
                            value="{{ $opsi }}"
                            form="form-selesaikan-tahapan"
                            class="w-4 h-4 accent-emerald-500 shrink-0"
                            required>

                        <span class="w-8 h-8 shrink-0 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-xs font-black text-gray-500 dark:text-gray-300">
                            {{ $index + 1 }}
                        </span>

                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                            {{ $opsi }}
                        </span>

                    </label>

                @endforeach

            </div>

            <p class="text-[10px] text-gray-400 mt-4">
                <i class="fa-solid fa-lock mr-1"></i>
                Jawabanmu digunakan sebagai refleksi kondisi belajar.
            </p>

        </div>

    @endif

    {{-- SELESAIKAN --}}
    <div class="bg-white dark:bg-cyberdark-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 p-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">

            <div>
                <h3 class="text-sm font-black text-gray-900 dark:text-white">
                    Siap melanjutkan pembelajaran?
                </h3>

                <p id="completion-message" class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Selesaikan waktu jeda terlebih dahulu.
                </p>
            </div>

            <form
                id="form-selesaikan-tahapan"
                action="{{ route('siswa.ruang-belajar.tahapan.selesaikan', [
                    'ruang_belajar_id' => $ruangBelajar->id,
                    'tahapan_id' => $tahapan->id
                ]) }}"
                method="POST">

                @csrf

                <input type="hidden" name="durasi_terpenuhi" id="durasi-terpenuhi" value="0">

                <button
                    type="submit"
                    id="btn-selesai"
                    disabled
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 rounded-2xl bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-black text-xs uppercase tracking-wider cursor-not-allowed transition-all">

                    <i class="fa-solid fa-lock" id="button-icon"></i>

                    <span id="button-text">Selesaikan Jeda</span>

                </button>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const totalDurasi = {{ $durasi }};
    const checkInAktif = @json($checkInAktif);

    const timerElement = document.getElementById('timer');
    const progressElement = document.getElementById('timer-progress');
    const timerMessage = document.getElementById('timer-message');

    const completionMessage = document.getElementById('completion-message');

    const button = document.getElementById('btn-selesai');
    const buttonText = document.getElementById('button-text');
    const buttonIcon = document.getElementById('button-icon');

    const durasiInput = document.getElementById('durasi-terpenuhi');
    const form = document.getElementById('form-selesaikan-tahapan');

    let remaining = totalDurasi;
    let timerInterval = null;
    let timerSelesai = false;

    function formatWaktu(seconds) {
        const menit = Math.floor(seconds / 60);
        const detik = seconds % 60;

        return String(menit).padStart(2, '0') + ':' +
               String(detik).padStart(2, '0');
    }

    function updateTimer() {

        timerElement.textContent = formatWaktu(remaining);

        const progress = ((totalDurasi - remaining) / totalDurasi) * 100;

        progressElement.style.width = progress + '%';
    }

    function checkFormReady() {

        if (!timerSelesai) {
            button.disabled = true;
            return;
        }

        let checkInTerisi = true;

        if (checkInAktif) {
            const jawaban = document.querySelector(
                'input[name="check_in_jawaban"]:checked'
            );

            checkInTerisi = !!jawaban;
        }

        button.disabled = !checkInTerisi;

        if (checkInTerisi) {

            button.className =
                'w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-500/20 border-b-4 border-emerald-700 transition-all hover:-translate-y-0.5';

            buttonIcon.className = 'fa-solid fa-check-circle';
            buttonText.textContent = 'Selesaikan Tahapan';

            completionMessage.textContent =
                'Semua sudah siap. Kamu dapat melanjutkan pembelajaran.';

        } else {

            button.className =
                'w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 rounded-2xl bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400 font-black text-xs uppercase tracking-wider cursor-not-allowed transition-all';

            buttonIcon.className = 'fa-solid fa-circle-exclamation';
            buttonText.textContent = 'Pilih Check-in';

            completionMessage.textContent =
                'Silakan isi check-in kondisi dirimu terlebih dahulu.';
        }
    }

    function selesaiTimer() {

        timerSelesai = true;
        remaining = 0;

        updateTimer();

        timerMessage.textContent =
            'Waktu jeda selesai. Terima kasih sudah meluangkan waktu.';

        timerElement.classList.add('text-teal-500');

        durasiInput.value = '1';

        checkFormReady();
    }

    updateTimer();

    timerInterval = setInterval(function () {

        if (remaining > 0) {
            remaining--;
            updateTimer();
        }

        if (remaining <= 0) {
            clearInterval(timerInterval);
            selesaiTimer();
        }

    }, 1000);

    document.querySelectorAll('input[name="check_in_jawaban"]').forEach(input => {
        input.addEventListener('change', checkFormReady);
    });

    form.addEventListener('submit', function (event) {

        if (!timerSelesai) {
            event.preventDefault();
            alert('Silakan selesaikan waktu jeda terlebih dahulu.');
            return;
        }

        if (checkInAktif) {
            const jawaban = document.querySelector(
                'input[name="check_in_jawaban"]:checked'
            );

            if (!jawaban) {
                event.preventDefault();
                alert('Silakan isi check-in kondisi dirimu terlebih dahulu.');
                return;
            }
        }

    });

});
</script>
@endpush
