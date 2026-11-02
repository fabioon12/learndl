@extends('admin.layouts.app')

@section('title', 'Tambah Ruang Belajar - LearnDL')

@section('content')
<div class="space-y-6 pb-12 font-sans max-w-5xl mx-auto">

    <!-- Header / Banner Header -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center space-x-3.5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-100/70 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="fa-solid fa-plus"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight leading-tight">
                    Tambah Ruang Belajar
                </h1>
                <p class="text-xs text-slate-400 font-normal mt-0.5">
                    Buat ruang belajar baru dan tentukan sekolah SMK target penerima secara fleksibel.
                </p>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ route('admin.ruang-belajar.index') }}" 
           class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-xs font-bold transition flex items-center space-x-2 whitespace-nowrap cursor-pointer">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form Utama -->
    <form action="{{ route('admin.ruang-belajar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Card 1: Informasi Dasar Ruang Belajar -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center space-x-2 border-b border-slate-100 pb-3">
                <div class="w-2 h-5 bg-emerald-500 rounded-full"></div>
                <h2 class="text-sm font-bold text-slate-900">Informasi Utama</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Judul / Nama Ruang Belajar -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Nama / Judul Ruang Belajar <span class="text-emerald-500">*</span>
                    </label>
                    <input type="text" 
                           name="judul" 
                           value="{{ old('judul') }}"
                           required 
                           placeholder="Contoh: Pemrograman Web Lanjutan" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    @error('judul')
                        <span class="text-[10px] text-red-500 mt-1 block font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mata Pelajaran -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Mata Pelajaran <span class="text-emerald-500">*</span>
                    </label>
                    <input type="text" 
                           name="mapel" 
                           value="{{ old('mapel') }}"
                           required 
                           placeholder="Contoh: Pemrograman Web & Bergerak" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">
                    @error('mapel')
                        <span class="text-[10px] text-red-500 mt-1 block font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tingkat / Kelas -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Tingkat / Kelas Target <span class="text-emerald-500">*</span>
                    </label>
                    <select name="kelas" 
                            required 
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('kelas') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition cursor-pointer">
                        <option value="">Pilih Kelas Siswa</option>
                        <option value="X" {{ old('kelas') == 'X' ? 'selected' : '' }}>Kelas X</option>
                        <option value="XI" {{ old('kelas') == 'XI' ? 'selected' : '' }}>Kelas XI</option>
                        <option value="XII" {{ old('kelas') == 'XII' ? 'selected' : '' }}>Kelas XII</option>
                    </select>
                    @error('kelas')
                        <span class="text-[10px] text-red-500 mt-1 block font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Thumbnail Ruang Belajar (Opsional) -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Sampul / Thumbnail Ruang Belajar <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <input type="file" 
                           name="thumbnail" 
                           accept="image/*"
                           class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer">
                </div>

                <!-- Deskripsi Ruang Belajar -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Deskripsi Ruang Belajar <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <textarea name="deskripsi" 
                              rows="4" 
                              placeholder="Tuliskan deskripsi ringkas mengenai materi atau capaian di ruang belajar ini..." 
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition">{{ old('deskripsi') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 2: Pilihan Target Sekolah SMK -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-5 bg-emerald-500 rounded-full"></div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-school text-emerald-600"></i> Target Sekolah SMK
                        </h2>
                    </div>
                </div>
                <span class="text-[10px] bg-emerald-50 text-emerald-600 font-bold px-2.5 py-1 rounded-full">
                    Pilih Minimal 1 Sekolah
                </span>
            </div>

            <p class="text-xs text-slate-400">
                Ruang belajar ini secara otomatis akan tampil pada dashboard Guru dan Siswa yang terdaftar di sekolah yang dipilih bawah ini.
            </p>

            @error('target_schools')
                <span class="text-[10px] text-red-500 block font-semibold">{{ $message }}</span>
            @enderror

            <!-- Grid Checkbox Pilihan SMK Target -->
            <div x-data="{ 
                selectedSchools: {{ json_encode(old('target_schools', [])) }},
                allGurus: {{ json_encode($gurus) }},
                get filteredGurus() {
                    if (this.selectedSchools.length === 0) return [];
                    return this.allGurus.filter(guru => this.selectedSchools.includes(guru.school_name));
                }
            }" class="space-y-6">

                <!-- Section 1: Checkbox Target Sekolah -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h2 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-school text-emerald-600"></i> Pilih Target Sekolah SMK
                        </h2>
                        <span class="text-[10px] bg-emerald-50 text-emerald-600 font-bold px-2.5 py-1 rounded-full">
                            Pilih Minimal 1 Sekolah
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 pt-2">
                        @php
                            $schoolList = [
                                'SMKN 4 MALANG',
                                'SMKN 5 MALANG',
                                'SMKN 6 MALANG',
                                'SMKN 8 MALANG',
                                'SMKN 9 MALANG',
                                'SMKN 11 MALANG',
                                'SMKN 12 MALANG',
                            ];
                        @endphp

                        @foreach($schoolList as $school)
                            <label class="flex items-center space-x-3 p-3.5 bg-slate-50 hover:bg-emerald-50/60 rounded-2xl border border-slate-200/60 cursor-pointer transition group">
                                <input type="checkbox" 
                                    name="target_schools[]" 
                                    value="{{ $school }}" 
                                    x-model="selectedSchools"
                                    class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500/30">
                                <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 transition">
                                    {{ $school }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Section 2: Dropdown Pilih Guru Pengajar (Otomatis Terfilter) -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Guru Pengajar <span class="text-emerald-500">*</span>
                    </label>
                    
                    <select name="guru_id" 
                            required 
                            class="w-full px-4 py-2.5 bg-slate-50 border @error('guru_id') border-red-500 @else border-slate-200 @enderror rounded-xl text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition cursor-pointer">
                        
                        <template x-if="selectedSchools.length === 0">
                            <option value="">-- Pilih Sekolah Terlebih Dahulu --</option>
                        </template>

                        <template x-if="selectedSchools.length > 0 && filteredGurus.length === 0">
                            <option value="">-- Tidak ada guru terdaftar di sekolah ini --</option>
                        </template>

                        <template x-if="filteredGurus.length > 0">
                            <option value="">-- Pilih Guru Pengajar --</option>
                        </template>

                        <!-- Loop Hasil Filter Guru -->
                        <template x-for="guru in filteredGurus" :key="guru.id">
                            <option :value="guru.id" x-text="`${guru.fullname} - ${guru.major_or_subject ?? 'Tanpa Jurusan'} (${guru.school_name})`"></option>
                        </template>
                    </select>

                    @error('guru_id')
                        <span class="text-[10px] text-red-500 mt-1 block font-semibold">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

        <!-- Submit & Actions -->
        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('admin.ruang-belajar.index') }}" 
               class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-2xl text-xs font-bold transition">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl text-xs font-bold transition shadow-md shadow-emerald-200 flex items-center space-x-2 cursor-pointer">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Terbitkan Ruang Belajar</span>
            </button>
        </div>

    </form>
</div>
@endsection