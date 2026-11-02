@extends('siswa.layouts.app')

@section('title', 'Dashboard Portal Ujian Essay: Deep Learning')

@section('content')
<div class="flex items-center space-x-2 text-xs text-gray-400 dark:text-pink-400/40 mb-6">
    <a href="/ruang-belajar" class="hover:text-pink-500 transition-colors">Ruang Belajar</a>
    <span><i class="fa-solid fa-angle-right text-[10px]"></i></span>
    <a href="/ruang-belajar/ujian" class="hover:text-pink-500 transition-colors">Dashboard Evaluasi</a>
    <span><i class="fa-solid fa-angle-right text-[10px]"></i></span>
    <span class="text-pink-500 font-medium">Persiapan Essay</span>
</div>

<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="bg-gradient-to-r from-amber-900 via-cyberdark-950 to-cyberdark-950 p-6 rounded-3xl border border-amber-950/30 shadow-lg text-white relative overflow-hidden">
        <div class="absolute -right-6 -bottom-6 text-9xl text-amber-500/10 pointer-events-none font-mono font-black select-none">
            ESSAY
        </div>
        <div class="relative z-10 space-y-2 max-w-2xl">
            <span class="px-2.5 py-0.5 bg-amber-500 text-white font-mono font-bold text-[9px] uppercase rounded tracking-wider shadow-sm">
                Subjective Analytical Test
            </span>
            <h1 class="text-lg font-black tracking-tight md:text-xl">Evaluasi Kemampuan Analisis & Coding Uraian</h1>
            <p class="text-[11px] text-amber-100/70 leading-relaxed">
                Anda akan menempuh **Ujian Essay Modul 02 (CNN)**. Pada tipe ujian ini, argumentasi ilmiah, ketepatan logika pemecahan masalah, dan kebersihan penulisan sintaks pemrograman akan menjadi parameter penilaian utama.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        
        <div class="md:col-span-7 space-y-4">
            
            <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-sm">
                <h3 class="text-xs font-black text-gray-800 dark:text-white font-mono uppercase tracking-wider mb-3.5 flex items-center gap-2">
                    <i class="fa-solid fa-file-signature text-amber-500"></i> Atribut Lembar Soal Uraian
                </h3>
                
                <div class="border border-gray-100 dark:border-pink-950/10 rounded-xl overflow-hidden font-mono text-[11px]">
                    <div class="grid grid-cols-2 border-b border-gray-100 dark:border-pink-950/10 bg-gray-50/50 dark:bg-gray-950/30 p-2.5">
                        <span class="text-gray-400">Jenis Evaluasi</span>
                        <span class="font-bold text-gray-800 dark:text-pink-200 text-right">Essay & Studi Kasus Coding</span>
                    </div>
                    <div class="grid grid-cols-2 border-b border-gray-100 dark:border-pink-950/10 p-2.5">
                        <span class="text-gray-400">Jumlah Soal</span>
                        <span class="font-bold text-gray-800 dark:text-pink-200 text-right">5 Butir Soal Komprehensif</span>
                    </div>
                    <div class="grid grid-cols-2 border-b border-gray-100 dark:border-pink-950/10 bg-gray-50/50 dark:bg-gray-950/30 p-2.5">
                        <span class="text-gray-400">Alokasi Waktu</span>
                        <span class="font-bold text-purple-600 dark:text-purple-400 text-right">75 Menit (01:15:00)</span>
                    </div>
                    <div class="grid grid-cols-2 border-b border-gray-100 dark:border-pink-950/10 p-2.5">
                        <span class="text-gray-400">Total Bobot Maksimal</span>
                        <span class="font-bold text-emerald-500 text-right">100 Poin</span>
                    </div>
                    <div class="grid grid-cols-2 bg-gray-50/50 dark:bg-gray-950/30 p-2.5">
                        <span class="text-gray-400">Sistem Koreksi</span>
                        <span class="font-bold text-amber-500 text-right">Penilaian Manual oleh Instruktur</span>
                    </div>
                </div>
            </div>

            <div class="bg-purple-500/5 p-5 rounded-2xl border border-purple-500/20 shadow-sm space-y-3">
                <h4 class="text-xs font-black text-purple-700 dark:text-purple-400 font-mono uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-keyboard"></i> Panduan Pengisian Lembar Kerja
                </h4>
                <ul class="text-[11px] text-gray-600 dark:text-purple-200/70 space-y-2 list-disc pl-4 leading-relaxed">
                    <li>Setiap soal memiliki batas <strong>minimal 20 karakter</strong> agar indikator sistem mendeteksi bahwa jawaban telah terisi.</li>
                    <li>Gunakan kolom **"Lampiran Kode Program"** yang terletak di bawah textarea utama jika soal meminta demonstrasi sintaks Python/Keras.</li>
                    <li>Jawaban tersimpan secara otomatis (*Auto-Save*) ke server setiap kali Anda berhenti mengetik selama 1 detik.</li>
                </ul>
            </div>
        </div>

        <div class="md:col-span-5 space-y-4">
            
            <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-md space-y-4">
                <div class="text-center pb-2 border-b border-gray-100 dark:border-pink-950/10">
                    <p class="text-[10px] font-mono font-black text-gray-400 dark:text-pink-400/50 uppercase tracking-widest">Otorisasi Ujian Essay</p>
                    <h3 class="text-xs font-bold text-gray-700 dark:text-pink-200 mt-0.5">Masukkan Token Akses Soal</h3>
                </div>

                <div class="space-y-1.5 font-mono">
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Token Essay :</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 text-xs">
                            <i class="fa-solid fa-lock-open"></i>
                        </div>
                        <input type="text" id="input-token-essay" oninput="validateEssayToken()" placeholder="Contoh: ESSAY-CNN" class="w-full pl-9 pr-3 py-2.5 bg-gray-50 dark:bg-cyberdark-950 text-gray-800 dark:text-pink-200 font-bold text-xs rounded-xl border border-gray-200 dark:border-pink-950/30 focus:outline-none focus:ring-2 focus:ring-amber-500 uppercase tracking-widest placeholder-gray-400">
                    </div>
                    <p id="token-status-message" class="text-[9px] text-gray-400 leading-tight">Minta token khusus Lembar Uraian kepada pengawas ruangan Anda.</p>
                </div>

                <div class="pt-2">
                    <a href="/ruang-belajar/ujian/room-essay" id="btn-start-essay" class="pointer-events-none opacity-40 w-full px-4 py-3 bg-gradient-to-r from-amber-600 via-orange-600 to-pink-600 text-white font-bold text-xs rounded-xl shadow-md flex items-center justify-center gap-2 transition-all uppercase tracking-wider">
                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                        <span>Buka Lembar Kerja Essay</span>
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-cyberdark-950/40 p-4 rounded-2xl border border-gray-200 dark:border-pink-950/10 flex items-center justify-between font-mono text-[10px]">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center text-[10px]">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <div>
                        <p class="text-gray-400 uppercase">Akun Ujian</p>
                        <p class="font-bold text-gray-700 dark:text-pink-200">Siswa Lab Komputasi 1</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gray-400 uppercase">Nilai Pilihan Ganda</p>
                    <span class="px-1.5 py-0.5 bg-emerald-500/10 text-emerald-500 font-bold rounded text-[9px]">85/100 (TERVALIDASI)</span>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function validateEssayToken() {
        const inputField = document.getElementById('input-token-essay');
        const tokenMsg = document.getElementById('token-status-message');
        const startBtn = document.getElementById('btn-start-essay');
        
        // Kode token simulasi: "ESSAYCNN"
        const cleanValue = inputField.value.trim().toUpperCase();

        if (cleanValue === "ESSAYCNN") {
            tokenMsg.innerHTML = "<span class='text-emerald-500 font-bold'><i class='fa-solid fa-circle-check'></i> Verifikasi Sukses!</span> Lembar kerja analisis subjective telah dibuka.";
            startBtn.classList.remove('pointer-events-none', 'opacity-40');
            startBtn.className = "w-full px-4 py-3 bg-gradient-to-r from-amber-600 via-orange-600 to-pink-600 text-white font-bold text-xs rounded-xl shadow-lg shadow-amber-600/20 flex items-center justify-center gap-2 transition-all uppercase tracking-wider hover:scale-[1.01]";
        } else if (cleanValue.length > 0) {
            tokenMsg.innerHTML = "<span class='text-amber-500 font-bold'><i class='fa-solid fa-circle-notch animate-spin'></i> Memeriksa basis data token...</span>";
            startBtn.classList.add('pointer-events-none', 'opacity-40');
        } else {
            tokenMsg.innerHTML = "Minta token khusus Lembar Uraian kepada pengawas ruangan Anda.";
            startBtn.classList.add('pointer-events-none', 'opacity-40');
        }
    }
</script>
@endsection