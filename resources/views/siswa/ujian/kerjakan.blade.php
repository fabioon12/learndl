@extends('siswa.layouts.app')

@section('title', 'Ruang Ujian Utama: Evaluasi Essay Deep Learning CNN')

@section('content')
<div class="sticky top-0 z-40 bg-white dark:bg-cyberdark-900 border-b border-gray-200 dark:border-pink-950/30 shadow-md -mx-4 px-4 py-3 mb-6 flex flex-col sm:flex-row items-center justify-between gap-3">
    <div class="flex items-center space-x-3">
        <div class="w-8 h-8 rounded-lg bg-pink-500 text-white flex items-center justify-center text-xs font-mono font-black animate-pulse">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div>
            <h2 class="text-xs font-black text-gray-800 dark:text-white leading-tight uppercase tracking-wider">Ujian Evaluasi Essay Modul 02</h2>
            <p class="text-[10px] text-gray-400 font-mono">Materi: Analisis Dampak Hyperparameter & Desain Lapangan Konvolusi</p>
        </div>
    </div>
    
    <div class="flex items-center space-x-2 bg-gray-50 dark:bg-gray-950 px-4 py-1.5 rounded-xl border border-gray-200 dark:border-pink-950/20 font-mono">
        <span class="text-[10px] uppercase font-bold text-gray-400">Sisa Waktu:</span>
        <div id="countdown-timer" class="text-sm font-black text-purple-600 dark:text-purple-400 tracking-widest">
            01:14:22
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    
    <div class="lg:col-span-8 space-y-4">
        <div class="bg-white dark:bg-cyberdark-900 p-6 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-sm relative overflow-hidden">
            
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-[0.02] select-none dark:opacity-[0.01]">
                <p class="text-4xl font-mono font-black uppercase tracking-widest transform -rotate-45">SISWA-ESSAY-SECURE-2026</p>
            </div>

            <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100 dark:border-pink-950/10">
                <span id="current-question-badge" class="px-3 py-1 bg-amber-500/10 text-amber-600 dark:text-amber-400 text-xs font-mono font-bold rounded-lg border border-amber-500/20">
                    SOAL ESSAY NOMOR 03
                </span>
                <span class="text-[10px] text-gray-400 font-mono"><i class="fa-solid fa-circle-info mr-1"></i> Bobot Maksimal: 25 Poin</span>
            </div>

            <div class="text-xs text-gray-700 dark:text-pink-100/90 leading-relaxed space-y-3 font-sans">
                <p class="font-bold text-gray-800 dark:text-white text-sm">
                    Studi Kasus: Reduksi Overfitting pada Model Deteksi Objek Medis
                </p>
                <p>
                    Sebuah model jaringan CNN yang Anda latih untuk mendeteksi sel kanker mengalami gejala <strong>overfitting</strong> yang cukup parah, di mana akurasi data *training* mencapai 98% namun akurasi data *validation* tertahan di angka 62%.
                </p>
                <p class="font-bold text-gray-800 dark:text-white">
                    Tugas Anda:
                </p>
                <ol class="list-decimal pl-4 space-y-1">
                    <li>Analisislah mengapa fenomena tersebut dapat terjadi pada arsitektur ekstraksi fitur spasial!</li>
                    <li>Berikan minimal 2 solusi konkret terkait manipulasi <em>hyperparameter</em> atau penambahan layer struktural untuk mengatasi masalah tersebut!</li>
                    <li>Tuliskan contoh modifikasi sintaks pembuat modelnya secara ringkas!</li>
                </ol>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider mb-1.5">
                        <i class="fa-solid fa-pen-nib text-purple-500"></i> Lembar Lembar Jawaban Uraian Teori:
                    </label>
                    <textarea id="essay-text-answer" oninput="handleEssayTyping()" rows="6" placeholder="Tuliskan analisis argumentasi ilmiah Anda di sini secara detail..." class="w-full bg-gray-50 dark:bg-cyberdark-950 text-gray-800 dark:text-pink-100/90 p-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 border border-gray-200 dark:border-pink-950/30 text-xs leading-relaxed font-sans"></textarea>
                    
                    <div class="flex items-center justify-between text-[9px] text-gray-400 font-mono mt-1 px-1">
                        <span id="char-counter">Jumlah Karakter: 0 (Minimal 20 karakter)</span>
                        <span id="save-status" class="hidden text-emerald-500 font-bold"><i class="fa-solid fa-cloud-arrow-up"></i> Draft Tersimpan otomatis</span>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider">
                            <i class="fa-solid fa-code text-pink-500"></i> Lampiran Kode Program Pendukung (Opsional):
                        </label>
                        <span class="text-[9px] text-pink-400/60 font-mono">Format: Python / Keras</span>
                    </div>
                    <textarea id="essay-code-answer" rows="5" placeholder="# Tuliskan modifikasi baris kode arsitektur di sini jika diperlukan&#10;# Contoh: layers.Dropout(0.5)" class="w-full bg-gray-950 text-emerald-400 p-3.5 rounded-xl focus:outline-none focus:ring-1 focus:ring-pink-500 border border-gray-900 font-mono text-[11px] leading-relaxed resize-none shadow-inner"></textarea>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between p-4 bg-white dark:bg-cyberdark-900 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-sm gap-2">
            <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-cyberdark-800 dark:hover:bg-cyberdark-700 text-gray-700 dark:text-pink-200 text-xs font-bold rounded-xl flex items-center gap-1.5 transition-all">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> SEBELUMNYA
            </button>

            <button onclick="toggleDoubtfulStatus()" id="btn-ragu" class="px-4 py-2 bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 text-xs font-bold rounded-xl flex items-center gap-1.5 transition-all">
                <i class="fa-solid fa-question text-[10px]"></i> RAGU-RAGU
            </button>

            <button class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 shadow-md shadow-purple-600/10 transition-all">
                SELANJUTNYA <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </button>
        </div>
    </div>

    <div class="lg:col-span-4 space-y-4 lg:sticky lg:top-[74px]">
        
        <div class="bg-white dark:bg-cyberdark-900 p-5 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-sm">
            <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100 dark:border-pink-950/10">
                <h4 class="text-xs font-bold font-mono text-gray-400 dark:text-pink-400/50 uppercase tracking-wider flex items-center gap-1.5">
                    <i class="fa-solid fa-th-large text-purple-500"></i> Navigator Essay
                </h4>
                <span class="font-mono text-[10px] text-gray-400">Tuntas: <b id="answered-count">0</b>/5 Soal</span>
            </div>

            <div class="grid grid-cols-5 gap-2 text-center font-mono text-xs font-black">
                <button class="p-2 bg-emerald-500 text-white rounded-lg hover:opacity-90 transition-all shadow-sm">01</button>
                <button class="p-2 bg-emerald-500 text-white rounded-lg hover:opacity-90 transition-all shadow-sm">02</button>
                <button id="nav-node-essay" class="p-2 bg-purple-100 dark:bg-pink-950/40 text-purple-600 dark:text-pink-400 rounded-lg ring-2 ring-purple-500 transition-all">03</button>
                <button class="p-2 bg-gray-50 dark:bg-cyberdark-950 text-gray-400 dark:text-pink-950/40 border border-gray-100 dark:border-pink-950/10 rounded-lg hover:bg-gray-100 dark:hover:bg-cyberdark-800 transition-all">04</button>
                <button class="p-2 bg-gray-50 dark:bg-cyberdark-950 text-gray-400 dark:text-pink-950/40 border border-gray-100 dark:border-pink-950/10 rounded-lg hover:bg-gray-100 transition-all">05</button>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-pink-950/10 flex flex-wrap gap-x-4 gap-y-1.5 text-[10px] text-gray-400 font-mono">
                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-emerald-500"></span> Sudah Diisi</div>
                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-amber-500"></span> Ragu-ragu</div>
                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-gray-100 dark:bg-cyberdark-950 border dark:border-pink-950/20"></span> Belum Diisi</div>
                <div class="flex items-center gap-1.5"><span class="w-2 h-2 rounded bg-purple-100 dark:bg-pink-950/40 ring-1 ring-purple-500"></span> Aktif</div>
            </div>
        </div>

        <div class="bg-white dark:bg-cyberdark-900 p-4 rounded-2xl border border-gray-200 dark:border-pink-950/20 shadow-sm">
            <button onclick="confirmSubmitExam()" class="w-full px-4 py-3 bg-gradient-to-r from-red-500 to-pink-600 hover:opacity-95 text-white font-bold text-xs rounded-xl shadow-lg shadow-red-500/10 flex items-center justify-center gap-2 transition-all tracking-wider">
                <i class="fa-solid fa-paper-plane text-[10px]"></i> KUMPULKAN JAWABAN ESSAY
            </button>
            <p class="text-[9px] text-gray-400 font-mono text-center mt-2">Pastikan argumentasi teks dan lampiran sintaks kode telah terisi penuh sebelum submit.</p>
        </div>
    </div>
</div>

<script>
    // 1. ENGINE COUNTDOWN TIMER
    let totalSeconds = 1 * 60 * 60 + 14 * 60 + 22; 
    const timerElement = document.getElementById('countdown-timer');

    const examInterval = setInterval(() => {
        if (totalSeconds <= 0) {
            clearInterval(examInterval);
            timerElement.innerText = "WAKTU HABIS";
            timerElement.className = "text-sm font-black text-red-500 animate-bounce";
            return;
        }
        totalSeconds--;
        let hrs = Math.floor(totalSeconds / 3600);
        let mins = Math.floor((totalSeconds % 3600) / 60);
        let secs = totalSeconds % 60;
        timerElement.innerText = (hrs < 10 ? "0" + hrs : hrs) + ":" + (mins < 10 ? "0" + mins : mins) + ":" + (secs < 10 ? "0" + secs : secs);
    }, 1000);

    // 2. DETEKSI AKSI KETIK ESSAY (AUTO-SAVE SIMULATION & INDIKATOR NAVIGASI)
    let isDoubtful = false;
    let typingTimer;
    const activeNode = document.getElementById('nav-node-essay');
    const txtAnswer = document.getElementById('essay-text-answer');
    const charCounter = document.getElementById('char-counter');
    const saveStatus = document.getElementById('save-status');
    const answeredCount = document.getElementById('answered-count');

    function handleEssayTyping() {
        const textLength = txtAnswer.value.trim().length;
        charCounter.innerText = `Jumlah Karakter: ${textLength} (Minimal 20 karakter)`;
        
        // Munculkan efek menyala 'Saving Draft' ke server cloud local
        saveStatus.classList.remove('hidden');
        saveStatus.innerHTML = "<i class='fa-solid fa-spinner animate-spin text-purple-400'></i> Menyimpan draft...";
        
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            saveStatus.innerHTML = "<i class='fa-solid fa-cloud-arrow-up'></i> Draft tersimpan otomatis";
        }, 1000);

        // Jika panjang karakter memenuhi syarat ganti warna kotak navigasi kanan jadi hijau (Terisi)
        if (!isDoubtful && textLength >= 20) {
            activeNode.className = "p-2 bg-emerald-500 text-white rounded-lg ring-2 ring-purple-500 transition-all";
            answeredCount.innerText = "3"; // Simulasi increment total tuntas
        } else if (!isDoubtful && textLength < 20) {
            activeNode.className = "p-2 bg-purple-100 dark:bg-pink-950/40 text-purple-600 dark:text-pink-400 rounded-lg ring-2 ring-purple-500 transition-all";
            answeredCount.innerText = "2";
        }
    }

    // 3. TOMBOL RAGU-RAGU FOR ESSAY
    function toggleDoubtfulStatus() {
        const btnRagu = document.getElementById('btn-ragu');
        isDoubtful = !isDoubtful;

        if(isDoubtful) {
            btnRagu.className = "px-4 py-2 bg-amber-500 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 transition-all shadow-md shadow-amber-500/20";
            activeNode.className = "p-2 bg-amber-500 text-white rounded-lg ring-2 ring-purple-500 transition-all animate-pulse";
        } else {
            btnRagu.className = "px-4 py-2 bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 border border-amber-500/30 text-xs font-bold rounded-xl flex items-center gap-1.5 transition-all";
            handleEssayTyping(); // Kalkulasi ulang status warna berdasar isi ketikan teks terakhir
        }
    }

    // 4. ENGINE PROMPT VALIDASI SUBMIT
    function confirmSubmitExam() {
        if (confirm("Apakah Anda yakin seluruh berkas lembar analisis essay dan sintaks program ini sudah benar? Jawaban akan segera dikunci oleh tim pengawas.")) {
            alert("[System] Enkripsi teks essay berhasil dilakukan! Berkas telah dikirim ke server penilaian.");
            window.location.href = "/ruang-belajar/materi";
        }
    }
</script>
@endsection