
@extends('guru.layouts.app')

@section('title', 'Monitoring Progres Siswa')

@section('content')
<div class="min-h-screen bg-slate-50 pb-12">

    {{-- HEADER --}}
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-5 lg:px-8 py-6">
            <div class="flex items-center gap-2 text-xs text-slate-400 mb-3">
                <span>Ruang Belajar</span>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span class="text-indigo-600 font-semibold">Monitoring Siswa</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800">
                        Monitoring Progres Siswa
                    </h1>
                    <p class="text-sm text-slate-500 mt-1">
                        Pantau perkembangan belajar siswa pada
                        <span class="font-bold text-indigo-600">
                            {{ $ruangBelajar->judul }}
                        </span>
                    </p>
                </div>

                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5
                          bg-white border border-slate-200 rounded-xl text-xs
                          font-bold text-slate-600 hover:bg-slate-50 transition">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-5 lg:px-8 py-7">

        {{-- STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Total Siswa
                        </p>
                        <h3 class="text-3xl font-black text-slate-800 mt-2">
                            {{ $totalSiswa }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Sedang Belajar
                        </p>
                        <h3 class="text-3xl font-black text-indigo-600 mt-2">
                            {{ $totalBerlangsung }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-book-reader text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Telah Selesai
                        </p>
                        <h3 class="text-3xl font-black text-emerald-600 mt-2">
                            {{ $totalSelesai }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">
                            Rata-rata Progres
                        </p>
                        <h3 class="text-3xl font-black text-amber-600 mt-2">
                            {{ $rataRataProgress }}%
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- DAFTAR TAHAPAN --}}
        <div class="mb-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                <div>
                    <h2 class="text-lg font-black text-slate-800">
                        Tahapan Pembelajaran
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">
                        Pilih tahapan untuk melihat aktivitas dan jawaban siswa.
                    </p>
                </div>

                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-2 rounded-lg">
                    <i class="fas fa-layer-group mr-1"></i>
                    {{ $ruangBelajar->tahapans->count() }} Tahapan
                </span>
            </div>

            @if($ruangBelajar->tahapans->isNotEmpty())

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    @foreach($ruangBelajar->tahapans as $index => $tahapan)

                        @php
                            $icon = $tahapan->icon ?? 'fa-book-open';

                            $warna = match(strtolower($tahapan->tipe ?? '')) {
                                'apersepsi' => [
                                    'bg' => 'bg-amber-50',
                                    'text' => 'text-amber-600',
                                    'border' => 'border-amber-100',
                                ],
                                'eksplorasi' => [
                                    'bg' => 'bg-blue-50',
                                    'text' => 'text-blue-600',
                                    'border' => 'border-blue-100',
                                ],
                                'pengaplikasian' => [
                                    'bg' => 'bg-violet-50',
                                    'text' => 'text-violet-600',
                                    'border' => 'border-violet-100',
                                ],
                                'evaluasi' => [
                                    'bg' => 'bg-emerald-50',
                                    'text' => 'text-emerald-600',
                                    'border' => 'border-emerald-100',
                                ],
                                default => [
                                    'bg' => 'bg-indigo-50',
                                    'text' => 'text-indigo-600',
                                    'border' => 'border-indigo-100',
                                ],
                            };
                        @endphp

                        <div class="bg-white border border-slate-200 rounded-2xl p-5
                                    hover:border-indigo-200 hover:shadow-lg
                                    hover:shadow-indigo-100/40 transition group">

                            <div class="flex items-start justify-between gap-3">

                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl {{ $warna['bg'] }}
                                                {{ $warna['text'] }} flex items-center
                                                justify-center text-lg">
                                        <i class="fas {{ $icon }}"></i>
                                    </div>

                                    <div>
                                        <span class="text-[10px] font-bold uppercase
                                                     tracking-wider text-slate-400">
                                            Tahapan {{ $index + 1 }}
                                        </span>

                                        <h3 class="text-sm font-black text-slate-800 mt-0.5">
                                            {{ $tahapan->judul_tahapan }}
                                        </h3>
                                    </div>
                                </div>

                                <span class="text-[10px] font-bold px-2.5 py-1
                                             rounded-full {{ $warna['bg'] }}
                                             {{ $warna['text'] }}">
                                    {{ ucfirst($tahapan->tipe ?? 'Pembelajaran') }}
                                </span>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100">

                                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                    Lihat aktivitas, hasil pengerjaan, dan respons
                                    siswa pada tahapan ini.
                                </p>

                                <a href="{{ route('guru.ruang-belajar.tahapan.monitoring', [
                                        'ruang_belajar' => $ruangBelajar->id,
                                        'tahapan' => $tahapan->id
                                    ]) }}"
                                   class="flex items-center justify-center gap-2 w-full
                                          py-2.5 px-4 rounded-xl bg-slate-50
                                          text-indigo-600 text-xs font-bold
                                          hover:bg-indigo-600 hover:text-white
                                          transition">

                                    <i class="fas fa-eye"></i>
                                    Lihat Aktivitas Siswa
                                    <i class="fas fa-arrow-right ml-auto"></i>
                                </a>

                            </div>
                        </div>

                    @endforeach

                </div>

            @else

                <div class="bg-white border border-dashed border-slate-300
                            rounded-2xl py-12 text-center">
                    <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100
                                text-slate-400 flex items-center justify-center text-xl">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700 mt-3">
                        Belum Ada Tahapan
                    </h3>
                    <p class="text-xs text-slate-400 mt-1">
                        Tahapan pembelajaran yang dibuat akan muncul di sini.
                    </p>
                </div>

            @endif

        </div>

        {{-- TABEL MONITORING SISWA --}}
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">

            <div class="p-5 border-b border-slate-100">
                <h3 class="font-black text-slate-800">
                    Daftar Progres Siswa
                </h3>
                <p class="text-xs text-slate-400 mt-1">
                    Informasi tahapan terakhir dan posisi belajar setiap siswa.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">

                    <thead class="bg-slate-50">
                        <tr class="text-[10px] uppercase tracking-wider text-slate-400">
                            <th class="px-5 py-4">Siswa</th>
                            <th class="px-5 py-4">Progres</th>
                            <th class="px-5 py-4">Tahapan Terakhir</th>
                            <th class="px-5 py-4">Posisi Sekarang</th>
                            <th class="px-5 py-4">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($monitoringSiswa as $siswa)

                            <tr class="hover:bg-slate-50 transition">

                                {{-- IDENTITAS SISWA --}}
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50
                                                    text-indigo-600 flex items-center
                                                    justify-center font-black">
                                            {{ strtoupper(substr($siswa->fullname, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="text-sm font-bold text-slate-800">
                                                {{ $siswa->fullname }}
                                            </p>
                                            <p class="text-xs text-slate-400">
                                                {{ $siswa->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- PROGRES --}}
                                <td class="px-5 py-4 min-w-[180px]">
                                    <div class="flex justify-between text-xs mb-2">
                                        <span class="font-bold text-slate-700">
                                            {{ $siswa->monitoring['tahapan_selesai'] }}
                                            /
                                            {{ $siswa->monitoring['total_tahapan'] }}
                                            Tahapan
                                        </span>

                                        <span class="font-black text-indigo-600">
                                            {{ $siswa->monitoring['persentase'] }}%
                                        </span>
                                    </div>

                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-indigo-600 rounded-full transition-all"
                                             style="width: {{ $siswa->monitoring['persentase'] }}%">
                                        </div>
                                    </div>
                                </td>

                                {{-- TAHAPAN TERAKHIR --}}
                                <td class="px-5 py-4">
                                    @if($siswa->monitoring['tahapan_terakhir'])
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $siswa->monitoring['tahapan_terakhir']->judul_tahapan }}
                                        </p>
                                        <span class="text-[10px] text-emerald-600 font-bold">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">
                                            Belum ada tahapan selesai
                                        </span>
                                    @endif
                                </td>

                                {{-- POSISI SEKARANG --}}
                                <td class="px-5 py-4">
                                    @if($siswa->monitoring['status'] === 'selesai')
                                        <span class="text-xs font-bold text-emerald-600">
                                            Semua tahapan selesai
                                        </span>
                                    @elseif($siswa->monitoring['tahapan_aktif'])
                                        <p class="text-sm font-bold text-indigo-600">
                                            {{ $siswa->monitoring['tahapan_aktif']->judul_tahapan }}
                                        </p>
                                        <span class="text-[10px] text-slate-400">
                                            Tahapan berikutnya yang perlu diselesaikan
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">
                                            Belum tersedia tahapan
                                        </span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td class="px-5 py-4">
                                    @if($siswa->monitoring['status'] === 'selesai')
                                        <span class="inline-flex px-3 py-1.5 rounded-full
                                                     bg-emerald-50 text-emerald-600
                                                     text-[10px] font-black">
                                            SELESAI
                                        </span>
                                    @elseif($siswa->monitoring['status'] === 'sedang_berlangsung')
                                        <span class="inline-flex px-3 py-1.5 rounded-full
                                                     bg-indigo-50 text-indigo-600
                                                     text-[10px] font-black">
                                            BERLANGSUNG
                                        </span>
                                    @else
                                        <span class="inline-flex px-3 py-1.5 rounded-full
                                                     bg-slate-100 text-slate-500
                                                     text-[10px] font-black">
                                            BELUM DIMULAI
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center py-16">
                                    <i class="fas fa-users text-4xl text-slate-200"></i>
                                    <p class="text-sm font-bold text-slate-500 mt-3">
                                        Belum ada siswa terdaftar
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">
                                        Siswa yang bergabung akan muncul di sini.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- INFORMASI --}}
        <div class="mt-5 bg-indigo-50 border border-indigo-100
                    rounded-2xl p-5 flex gap-3">
            <i class="fas fa-info-circle text-indigo-600 mt-1"></i>
            <div>
                <p class="text-sm font-bold text-indigo-900">
                    Informasi Monitoring
                </p>
                <p class="text-xs text-indigo-700 mt-1 leading-relaxed">
                    Guru dapat memilih salah satu tahapan pembelajaran pada bagian
                    Tahapan Pembelajaran untuk melihat aktivitas dan respons siswa.
                    Sementara itu, tabel progres menampilkan perkembangan belajar
                    setiap siswa berdasarkan tahapan yang telah diselesaikan.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection
