
@extends('guru.layouts.app')

@section('title', 'Buat Soal Ujian')

@section('content')

<div class="min-h-screen bg-slate-50/70 px-4 py-6 sm:px-6 lg:px-8">

    <div class="mx-auto max-w-5xl">

        {{-- Breadcrumb --}}
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

        {{-- Header --}}
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
                    Buat pertanyaan, atur pilihan jawaban, dan tentukan EXP yang diperoleh siswa.
                </p>
            </div>

            <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-100">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        {{-- Informasi Ruang Ujian --}}
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
                            {{ $ruangUjian->soal_count ?? $ruangUjian->soal()->count() }} soal telah dibuat
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

        {{-- Error Validasi --}}
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

        {{-- Form --}}
        <form action="{{ route('guru.ruang-ujian.soal.store', $ruangUjian->id) }}"
              method="POST"
              id="formSoal">

            @csrf

            <div class="space-y-6">

                {{-- Pertanyaan --}}
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

                    <div>
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

                </div>

                {{-- Pengaturan Tipe Soal --}}
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

                        <label class="cursor-pointer">
                            <input type="radio"
                                   name="tipe"
                                   value="pilihan_ganda"
                                   class="peer sr-only"
                                   {{ old('tipe', 'pilihan_ganda') === 'pilihan_ganda' ? 'checked' : '' }}>

                            <div class="rounded-xl border-2 border-slate-200 p-4 transition peer-checked:border-indigo-500 peer-checked:bg-indigo-50/60 hover:border-indigo-300">
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

                        <label class="cursor-pointer">
                            <input type="radio"
                                   name="tipe"
                                   value="esai"
                                   class="peer sr-only"
                                   {{ old('tipe') === 'esai' ? 'checked' : '' }}>

                            <div class="rounded-xl border-2 border-slate-200 p-4 transition peer-checked:border-indigo-500 peer-checked:bg-indigo-50/60 hover:border-indigo-300">
                                <div class="flex items-center justify-between">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                        <i class="fas fa-align-left"></i>
                                    </div>
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

                {{-- Pilihan Jawaban --}}
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

                        @php
                            $opsiLama = old('opsi', [
                                ['kode' => 'A', 'teks' => ''],
                                ['kode' => 'B', 'teks' => ''],
                                ['kode' => 'C', 'teks' => ''],
                                ['kode' => 'D', 'teks' => ''],
                            ]);
                        @endphp

                        @foreach ($opsiLama as $index => $opsi)
                            <div class="opsi-item rounded-xl border border-slate-200 bg-slate-50/70 p-4"
                                 data-index="{{ $index }}">

                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white font-bold text-indigo-600 shadow-sm">
                                        {{ $opsi['kode'] ?? chr(65 + $index) }}
                                    </div>

                                    <input type="hidden"
                                           class="kode-opsi"
                                           name="opsi[{{ $index }}][kode]"
                                           value="{{ $opsi['kode'] ?? chr(65 + $index) }}">

                                    <div class="min-w-0 flex-1">
                                        <label class="mb-2 block text-xs font-semibold text-slate-600">
                                            Pilihan {{ $opsi['kode'] ?? chr(65 + $index) }}
                                        </label>

                                        <input type="text"
                                               name="opsi[{{ $index }}][teks]"
                                               value="{{ $opsi['teks'] ?? '' }}"
                                               placeholder="Masukkan pilihan jawaban..."
                                               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
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

                    {{-- Kunci Jawaban --}}
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

                {{-- Pengaturan EXP dan Pembahasan --}}
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
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 pr-20 text-sm font-semibold text-slate-700 outline-none transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">

                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-amber-500">
                                EXP
                            </span>
                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            EXP diberikan kepada siswa yang menjawab soal dengan benar.
                        </p>

                        @error('exp')
                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

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
                                  class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">{{ old('pembahasan') }}</textarea>

                        <p class="mt-2 text-xs text-slate-500">
                            Pembahasan dapat digunakan untuk memberikan umpan balik kepada siswa setelah mengerjakan ujian.
                        </p>
                    </div>

                </div>

                {{-- Tombol Aksi --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">

                    <a href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                        <i class="fas fa-times"></i>
                        Batal
                    </a>

                    <button type="submit"
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

    const bagianPilihan = document.getElementById('bagianPilihan');
    const daftarOpsi = document.getElementById('daftarOpsi');
    const tombolTambah = document.getElementById('tambahOpsi');
    const selectJawaban = document.getElementById('jawaban_benar');
    const formSoal = document.getElementById('formSoal');

    let indexOpsi = Math.max(
        ...Array.from(daftarOpsi.querySelectorAll('.opsi-item'))
            .map(item => Number(item.dataset.index)),
        -1
    ) + 1;

    function ambilKode(index) {
        let kode = '';
        let nomor = index;

        do {
            kode = String.fromCharCode(65 + (nomor % 26)) + kode;
            nomor = Math.floor(nomor / 26) - 1;
        } while (nomor >= 0);

        return kode;
    }

    function perbaruiKunciJawaban() {
        const nilaiLama = selectJawaban.value;

        selectJawaban.innerHTML = '';

        daftarOpsi.querySelectorAll('.opsi-item').forEach(function (item) {
            const kode = item.querySelector('.kode-opsi').value;

            const option = document.createElement('option');
            option.value = kode;
            option.textContent = 'Pilihan ' + kode;

            selectJawaban.appendChild(option);
        });

        if ([...selectJawaban.options].some(option => option.value === nilaiLama)) {
            selectJawaban.value = nilaiLama;
        }
    }

    function buatOpsi(index, teks = '') {
        const kode = ambilKode(index);

        const wrapper = document.createElement('div');
        wrapper.className = 'opsi-item rounded-xl border border-slate-200 bg-slate-50/70 p-4';
        wrapper.dataset.index = index;

        const row = document.createElement('div');
        row.className = 'flex flex-col gap-3 sm:flex-row sm:items-start';

        const badge = document.createElement('div');
        badge.className = 'flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white font-bold text-indigo-600 shadow-sm';
        badge.textContent = kode;

        const kodeInput = document.createElement('input');
        kodeInput.type = 'hidden';
        kodeInput.name = `opsi[${index}][kode]`;
        kodeInput.value = kode;
        kodeInput.className = 'kode-opsi';

        const content = document.createElement('div');
        content.className = 'min-w-0 flex-1';

        const label = document.createElement('label');
        label.className = 'mb-2 block text-xs font-semibold text-slate-600';
        label.textContent = 'Pilihan ' + kode;

        const input = document.createElement('input');
        input.type = 'text';
        input.name = `opsi[${index}][teks]`;
        input.value = teks;
        input.placeholder = 'Masukkan pilihan jawaban...';
        input.required = true;
        input.className = 'w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10';

        content.appendChild(label);
        content.appendChild(input);

        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'hapus-opsi flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-50 hover:text-red-500';
        remove.title = 'Hapus pilihan';
        remove.innerHTML = '<i class="fas fa-trash-alt"></i>';

        row.appendChild(badge);
        row.appendChild(kodeInput);
        row.appendChild(content);
        row.appendChild(remove);

        wrapper.appendChild(row);

        return wrapper;
    }

    function aturTipeSoal() {
        const tipe = document.querySelector('input[name="tipe"]:checked').value;
        const isPilihanGanda = tipe === 'pilihan_ganda';

        bagianPilihan.classList.toggle('hidden', !isPilihanGanda);

        bagianPilihan.querySelectorAll('input, select, button').forEach(function (element) {
            element.disabled = !isPilihanGanda;
        });

        // Pilihan jawaban tidak wajib ketika tipe soal adalah esai.
        daftarOpsi.querySelectorAll('input[type="text"]').forEach(function (input) {
            input.required = isPilihanGanda;
        });

        perbaruiKunciJawaban();
    }

    tombolTambah.addEventListener('click', function () {
        if (daftarOpsi.querySelectorAll('.opsi-item').length >= 26) {
            alert('Maksimal 26 pilihan jawaban.');
            return;
        }

        daftarOpsi.appendChild(buatOpsi(indexOpsi));
        indexOpsi++;

        perbaruiKunciJawaban();
    });

    daftarOpsi.addEventListener('click', function (event) {
        const tombolHapus = event.target.closest('.hapus-opsi');

        if (!tombolHapus) return;

        const jumlahOpsi = daftarOpsi.querySelectorAll('.opsi-item').length;

        if (jumlahOpsi <= 2) {
            alert('Minimal harus tersedia 2 pilihan jawaban.');
            return;
        }

        tombolHapus.closest('.opsi-item').remove();
        perbaruiKunciJawaban();
    });

    document.querySelectorAll('input[name="tipe"]').forEach(function (radio) {
        radio.addEventListener('change', aturTipeSoal);
    });

    // Mempertahankan nilai lama setelah validasi gagal.
    perbaruiKunciJawaban();
    aturTipeSoal();

    formSoal.addEventListener('submit', function (event) {
        const tipe = document.querySelector('input[name="tipe"]:checked').value;

        if (tipe === 'pilihan_ganda') {
            const jumlahOpsi = daftarOpsi.querySelectorAll('.opsi-item').length;

            if (jumlahOpsi < 2) {
                event.preventDefault();
                alert('Soal pilihan ganda minimal memiliki 2 pilihan jawaban.');
            }
        }
    });

});
</script>
@endpush
