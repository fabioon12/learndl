@extends('guru.layouts.app')

@section('title', 'Jeda Hening & Check-in')

@section('content')

@php
    $konten = $konten ?? [];

    $isEdit = !empty($tahapan->konten);

    $instruksi = old(
        'instruksi',
        data_get($konten, 'instruksi', 'Luangkan waktu sejenak untuk menenangkan pikiran, mengatur pernapasan, dan mempersiapkan diri sebelum memulai pembelajaran.')
    );

    $durasi = old(
        'durasi',
        data_get($konten, 'durasi', 60)
    );

    $checkInAktif = old(
        'check_in.aktif',
        data_get($konten, 'check_in.aktif', true)
    );

    $pertanyaan = old(
        'check_in.pertanyaan',
        data_get($konten, 'check_in.pertanyaan', 'Bagaimana kondisi diri Anda saat ini?')
    );

    $pilihan = old(
        'check_in.pilihan',
        data_get($konten, 'check_in.pilihan', [
            'Sangat siap dan bersemangat',
            'Cukup siap untuk belajar',
            'Kurang fokus',
            'Belum siap untuk belajar'
        ])
    );

    $formAction = route('guru.ruang-belajar.tahapan.konten.update', [
        $ruangBelajar->id,
        $tahapan->id
    ]);
@endphp

<div class="max-w-5xl mx-auto space-y-6 pb-10">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

        <div class="flex items-start gap-3">

            <div class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-950/50 flex items-center justify-center text-purple-600 shrink-0">
                <i class="fa-solid fa-spa text-xl"></i>
            </div>

            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white">
                    Jeda Hening & Check-in
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Atur aktivitas kesadaran diri dan kesiapan siswa sebelum belajar.
                </p>
            </div>

        </div>

        <a href="{{ route('guru.ruang-belajar.tahapan.konten.index', $ruangBelajar->id) }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 text-sm font-semibold transition">

            <i class="fa-solid fa-arrow-left"></i>
            Kembali

        </a>

    </div>

    {{-- INFORMASI TAHAPAN --}}
    <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-5">

        <div class="flex items-center gap-2 mb-4">
            <i class="fa-solid fa-circle-info text-purple-500"></i>
            <h3 class="font-bold text-gray-800 dark:text-white">
                Informasi Tahapan
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <p class="text-xs text-gray-400 mb-1">Ruang Belajar</p>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                    {{ $ruangBelajar->judul }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-400 mb-1">Nama Tahapan</p>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                    {{ $tahapan->judul_tahapan }}
                </p>
            </div>

            <div>
                <p class="text-xs text-gray-400 mb-1">Jenis Aktivitas</p>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-300 text-xs font-bold">
                    <i class="fa-solid fa-spa"></i>
                    Jeda Hening
                </span>
            </div>

        </div>

    </div>

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-900">
            <div class="flex items-center gap-2 text-red-600 dark:text-red-400 font-bold text-sm mb-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                Periksa kembali pengisian Anda
            </div>

            <ul class="list-disc pl-5 text-sm text-red-600 dark:text-red-400 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ $formAction }}" method="POST" id="jedaHeningForm">

        @csrf

        {{-- Gunakan method POST atau PUT sesuai preferensi route Anda (di sini diarahkan ke Route::post dinamis) --}}

        {{-- SECTION 1: INSTRUKSI --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden mb-6">

            <div class="p-5 border-b border-gray-100 dark:border-gray-700">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-500 flex items-center justify-center">
                        <i class="fa-solid fa-wind text-lg"></i>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-white">
                            01. Instruksi Jeda Hening
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Berikan arahan kepada siswa sebelum memulai aktivitas.
                        </p>
                    </div>

                </div>

            </div>

            <div class="p-5 space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Instruksi Aktivitas
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        name="instruksi"
                        rows="4"
                        required
                        placeholder="Tuliskan instruksi yang akan dibaca siswa..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none resize-none">{{ $instruksi }}</textarea>

                    <p class="text-xs text-gray-400 mt-2">
                        Gunakan kalimat yang menenangkan dan mudah dipahami siswa.
                    </p>

                </div>

                <div class="max-w-sm">

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Durasi Jeda Hening
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <input
                            type="number"
                            name="durasi"
                            id="durasi"
                            min="10"
                            max="600"
                            required
                            value="{{ $durasi }}"
                            class="w-full px-4 py-3 pr-20 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none">

                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-semibold text-gray-400">
                            Detik
                        </span>

                    </div>

                    <p class="text-xs text-gray-400 mt-2">
                        Durasi minimal 10 detik dan maksimal 600 detik.
                    </p>

                    <div class="flex flex-wrap gap-2 mt-3">

                        @foreach([30, 60, 90, 120, 180] as $second)

                            <button
                                type="button"
                                onclick="setDurasi({{ $second }})"
                                class="px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 text-xs text-gray-600 dark:text-gray-300 hover:border-purple-500 hover:text-purple-600 transition">

                                {{ $second }} detik

                            </button>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        {{-- SECTION 2: CHECK-IN --}}
        <div class="bg-white dark:bg-cyberdark-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden mb-6">

            <div class="p-5 border-b border-gray-100 dark:border-gray-700">

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-500 flex items-center justify-center">
                            <i class="fa-solid fa-face-smile text-lg"></i>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-white">
                                02. Check-in Kesadaran Siswa
                            </h3>

                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Mengetahui kondisi dan kesiapan siswa sebelum belajar.
                            </p>
                        </div>

                    </div>

                    <label class="relative inline-flex items-center cursor-pointer">

                        <input
                            type="hidden"
                            name="check_in[aktif]"
                            value="0">

                        <input
                            type="checkbox"
                            name="check_in[aktif]"
                            value="1"
                            id="checkInToggle"
                            class="sr-only peer"
                            {{ $checkInAktif ? 'checked' : '' }}>

                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:bg-purple-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>

                        <span class="ml-3 text-xs font-semibold text-gray-600 dark:text-gray-300">
                            Aktifkan
                        </span>

                    </label>

                </div>

            </div>

            <div id="checkInContent" class="p-5 space-y-5">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Pertanyaan Check-in
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        name="check_in[pertanyaan]"
                        rows="2"
                        placeholder="Contoh: Bagaimana kondisi diri Anda saat ini?"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none resize-none">{{ $pertanyaan }}</textarea>

                </div>

                {{-- PILIHAN JAWABAN --}}
                <div>

                    <div class="flex items-center justify-between mb-3">

                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Pilihan Jawaban Siswa
                            </label>

                            <p class="text-xs text-gray-400 mt-1">
                                Tambahkan minimal dua pilihan jawaban.
                            </p>
                        </div>

                        <button
                            type="button"
                            onclick="tambahPilihan()"
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-300 text-xs font-bold hover:bg-purple-100 transition">

                            <i class="fa-solid fa-plus"></i>
                            Tambah Pilihan

                        </button>

                    </div>

                    <div id="pilihanContainer" class="space-y-3">

                        @foreach($pilihan as $index => $item)

                            <div class="flex items-center gap-3 pilihan-item">

                                <div class="w-9 h-9 shrink-0 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 text-sm font-bold nomor-pilihan">
                                    {{ $index + 1 }}
                                </div>

                                <input
                                    type="text"
                                    name="check_in[pilihan][]"
                                    value="{{ $item }}"
                                    required
                                    placeholder="Masukkan pilihan jawaban..."
                                    class="flex-1 min-w-0 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none">

                                <button
                                    type="button"
                                    onclick="hapusPilihan(this)"
                                    class="w-9 h-9 shrink-0 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-950/40 transition">

                                    <i class="fa-solid fa-trash-can"></i>

                                </button>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

            <div id="checkInDisabled" class="hidden p-5 bg-gray-50 dark:bg-cyberdark-900/50">

                <div class="flex items-center gap-3 text-gray-500 dark:text-gray-400">

                    <i class="fa-solid fa-circle-info text-lg"></i>

                    <p class="text-sm">
                        Fitur check-in dinonaktifkan. Siswa hanya perlu menyelesaikan aktivitas jeda hening.
                    </p>

                </div>

            </div>

        </div>

        {{-- PREVIEW INFORMASI --}}
        <div class="bg-purple-50 dark:bg-purple-950/20 border border-purple-100 dark:border-purple-900/50 rounded-2xl p-5 mb-6">

            <div class="flex gap-3">

                <div class="w-10 h-10 rounded-xl bg-white dark:bg-purple-900/50 text-purple-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>

                <div>
                    <h4 class="font-bold text-purple-800 dark:text-purple-300 text-sm">
                        Informasi Pemantauan Guru
                    </h4>

                    <p class="text-xs text-purple-700 dark:text-purple-400 mt-1 leading-relaxed">
                        Setelah siswa menyelesaikan aktivitas, guru dapat melihat siapa saja yang telah menyelesaikan Jeda Hening, waktu penyelesaian, serta hasil check-in siswa apabila fitur tersebut diaktifkan.
                    </p>
                </div>

            </div>

        </div>

        {{-- ACTION BUTTON --}}
        <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3">

            <a href="{{ route('guru.ruang-belajar.tahapan.konten.index', $ruangBelajar->id) }}"
               class="w-full sm:w-auto px-5 py-3 rounded-xl text-sm font-semibold text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition text-center">

                Batal

            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-sm font-bold shadow-lg shadow-purple-500/20 transition">

                <i class="fa-solid fa-floppy-disk"></i>

                Simpan Konten Aktivitas

                <i class="fa-solid fa-arrow-right ml-1"></i>

            </button>

        </div>

    </form>

</div>

<script>
    // Mengatur durasi cepat
    function setDurasi(value) {
        document.getElementById('durasi').value = value;
    }

    // Menambahkan pilihan check-in
    function tambahPilihan() {
        const container = document.getElementById('pilihanContainer');
        const jumlah = container.querySelectorAll('.pilihan-item').length;
        const item = document.createElement('div');

        item.className = 'flex items-center gap-3 pilihan-item';
        item.innerHTML = `
            <div class="w-9 h-9 shrink-0 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 text-sm font-bold nomor-pilihan">
                ${jumlah + 1}
            </div>
            <input
                type="text"
                name="check_in[pilihan][]"
                required
                placeholder="Masukkan pilihan jawaban..."
                class="flex-1 min-w-0 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-cyberdark-900 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-purple-500 outline-none">
            <button
                type="button"
                onclick="hapusPilihan(this)"
                class="w-9 h-9 shrink-0 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-950/40 transition">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        `;

        container.appendChild(item);
        updateNomorPilihan();
    }

    // Menghapus pilihan
    function hapusPilihan(button) {
        const container = document.getElementById('pilihanContainer');

        if (container.querySelectorAll('.pilihan-item').length <= 2) {
            alert('Minimal harus terdapat dua pilihan jawaban.');
            return;
        }

        button.closest('.pilihan-item').remove();
        updateNomorPilihan();
    }

    // Memperbarui nomor pilihan
    function updateNomorPilihan() {
        document.querySelectorAll('.nomor-pilihan').forEach((item, index) => {
            item.textContent = index + 1;
        });
    }

    // Toggle fitur check-in
    const checkInToggle = document.getElementById('checkInToggle');
    const checkInContent = document.getElementById('checkInContent');
    const checkInDisabled = document.getElementById('checkInDisabled');

    function toggleCheckIn() {
        const aktif = checkInToggle.checked;

        checkInContent.classList.toggle('hidden', !aktif);
        checkInDisabled.classList.toggle('hidden', aktif);

        checkInContent.querySelectorAll('input, textarea, button').forEach(element => {
            if (element.type === 'button') return;
            element.disabled = !aktif;
        });
    }

    checkInToggle.addEventListener('change', toggleCheckIn);
    toggleCheckIn();

    // Validasi minimal pilihan sebelum submit
    document.getElementById('jedaHeningForm').addEventListener('submit', function(e) {
        if (checkInToggle.checked) {
            const pilihan = document.querySelectorAll(
                '#pilihanContainer input[name="check_in[pilihan][]"]'
            );
            const pilihanValid = [...pilihan].filter(item => item.value.trim() !== '');

            if (pilihanValid.length < 2) {
                e.preventDefault();
                alert('Tambahkan minimal dua pilihan jawaban check-in.');
            }
        }
    });
</script>

@endsection