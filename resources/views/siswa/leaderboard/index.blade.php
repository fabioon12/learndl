@extends('siswa.layouts.app')

@section('title', 'Papan Klasemen Juara Ujian')

@section('content')
<div class="flex items-center space-x-2 text-xs text-gray-400 dark:text-pink-400/40 mb-6">
    <a href="/ruang-belajar" class="hover:text-pink-500 transition-colors">Ruang Belajar</a>
    <span><i class="fa-solid fa-angle-right text-[10px]"></i></span>
    <a href="/ruang-belajar/ujian" class="hover:text-pink-500 transition-colors">Pusat Ujian</a>
    <span><i class="fa-solid fa-angle-right text-[10px]"></i></span>
    <span class="text-pink-500 font-medium">Klasemen Keaktifan</span>
</div>

<div class="text-center space-y-1 mb-12">
    <h1 class="text-xl font-black text-gray-800 dark:text-white uppercase tracking-wider flex items-center justify-center gap-2">
        <i class="fa-solid fa-trophy text-amber-500 drop-shadow-[0_2px_8px_rgba(245,158,11,0.4)]"></i> 
        PAPAN KLASEMEN UTAMA SISWA
    </h1>
    <p class="text-xs text-gray-400 font-mono">Kalkulasi Skor: Akurasi Ruang Ujian + Log Interaksi Keaktifan Kelas</p>
</div>

<div class="max-w-3xl mx-auto flex items-end justify-center h-72 sm:h-80 mb-6 font-mono px-2">
    
    <div class="flex-1 flex flex-col items-center z-10">
        <div class="flex flex-col items-center text-center space-y-1 mb-2">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-slate-800 p-0.5 border-2 border-slate-400 shadow-md relative">
                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Fiona" class="w-full h-full rounded-full bg-slate-900">
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-slate-400 text-slate-950 text-[9px] font-black rounded-full flex items-center justify-center border border-white">2</div>
            </div>
            <div class="w-24 sm:w-32">
                <h4 class="text-[11px] font-black text-gray-700 dark:text-pink-100 truncate">Fiona C.</h4>
                <p class="text-[10px] font-bold text-slate-500">2,450 XP</p>
            </div>
        </div>
        <div class="w-full bg-gradient-to-t from-slate-300 to-slate-200 dark:from-slate-950 dark:to-slate-900 h-28 rounded-t-2xl border-t-2 border-x border-slate-400 flex flex-col items-center justify-center shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
            <span class="text-2xl font-black text-slate-400/60 dark:text-slate-700">II</span>
            <span class="text-[8px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">SILVER</span>
        </div>
    </div>

    <div class="flex-1 flex flex-col items-center z-20 transform scale-105 sm:scale-110">
        <div class="flex flex-col items-center text-center space-y-1 mb-2 relative">
            <div class="absolute -top-5 text-amber-500 animate-bounce text-base">
                <i class="fa-solid fa-crown"></i>
            </div>
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-amber-950 p-0.5 border-2 border-amber-500 shadow-xl relative ring-4 ring-amber-500/10">
                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Alex" class="w-full h-full rounded-full bg-cyberdark-950">
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-amber-500 text-amber-950 text-[9px] font-black rounded-full flex items-center justify-center border border-white">1</div>
            </div>
            <div class="w-24 sm:w-32">
                <h4 class="text-[11px] font-black text-gray-800 dark:text-white truncate">Alex Wijaya</h4>
                <p class="text-[10px] font-black text-amber-500">2,980 XP</p>
            </div>
        </div>
        <div class="w-full bg-gradient-to-t from-amber-600 to-amber-400 dark:from-amber-950 dark:to-amber-900/60 h-40 rounded-t-2xl border-t-2 border-x border-amber-500 flex flex-col items-center justify-center shadow-[0_-4px_20px_rgba(245,158,11,0.15)]">
            <span class="text-3xl font-black text-amber-600/40 dark:text-amber-700/60">I</span>
            <span class="text-[8px] text-amber-700 dark:text-amber-500 font-bold uppercase tracking-wider">GOLDEN</span>
        </div>
    </div>

    <div class="flex-1 flex flex-col items-center z-10">
        <div class="flex flex-col items-center text-center space-y-1 mb-2">
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-amber-900/40 p-0.5 border-2 border-amber-700 shadow-md relative">
                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Budi" class="w-full h-full rounded-full bg-amber-950">
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-amber-700 text-white text-[9px] font-black rounded-full flex items-center justify-center border border-white">3</div>
            </div>
            <div class="w-24 sm:w-32">
                <h4 class="text-[11px] font-black text-gray-700 dark:text-pink-100 truncate">Budi S.</h4>
                <p class="text-[10px] font-bold text-amber-700">2,210 XP</p>
            </div>
        </div>
        <div class="w-full bg-gradient-to-t from-amber-800/40 to-amber-700/20 dark:from-amber-950/60 dark:to-amber-950/20 h-20 rounded-t-2xl border-t-2 border-x border-amber-800 flex flex-col items-center justify-center">
            <span class="text-2xl font-black text-amber-800/40 dark:text-amber-900/30">III</span>
            <span class="text-[8px] text-amber-800/60 dark:text-amber-600 font-bold uppercase tracking-wider">BRONZE</span>
        </div>
    </div>

</div>

<div class="max-w-3xl mx-auto h-3 bg-gray-200 dark:bg-cyberdark-950 rounded-full shadow-inner mb-10 border border-gray-300/30 dark:border-pink-950/10"></div>


<div class="max-w-4xl mx-auto space-y-2.5">
    
    <div class="bg-white dark:bg-cyberdark-900 p-3 rounded-xl border border-gray-200 dark:border-pink-950/20 shadow-sm flex items-center justify-between gap-4 hover:translate-x-1 transition-transform">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-gray-100 dark:bg-cyberdark-950 border dark:border-pink-950/20 rounded-lg flex items-center justify-center font-mono font-black text-xs text-gray-400">
                04
            </div>
            <div class="flex items-center gap-3">
                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Dewi" class="w-7 h-7 bg-gray-50 border dark:border-pink-950/10 rounded-lg">
                <div>
                    <h5 class="text-xs font-bold text-gray-700 dark:text-pink-200">Diana Citra</h5>
                    <p class="text-[9px] text-gray-400 font-mono"><i class="fa-solid fa-circle text-emerald-500 text-[6px] mr-1"></i>Keaktifan Forum Tinggi</p>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-6 text-right font-mono">
            <span class="hidden sm:inline text-[10px] text-gray-400">Akurasi Tes: <b>90%</b></span>
            <div class="pr-2">
                <span class="text-xs font-black text-purple-600 dark:text-purple-400">2,150</span>
                <span class="text-[9px] text-gray-400 block -mt-1">XP</span>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-cyberdark-900 p-3 rounded-xl border border-gray-200 dark:border-pink-950/20 shadow-sm flex items-center justify-between gap-4 hover:translate-x-1 transition-transform">
        <div class="flex items-center space-x-4">
            <div class="w-7 h-7 bg-gray-100 dark:bg-cyberdark-950 border dark:border-pink-950/20 rounded-lg flex items-center justify-center font-mono font-black text-xs text-gray-400">
                05
            </div>
            <div class="flex items-center gap-3">
                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Eko" class="w-7 h-7 bg-gray-50 border dark:border-pink-950/10 rounded-lg">
                <div>
                    <h5 class="text-xs font-bold text-gray-700 dark:text-pink-200">Eko Prasetyo</h5>
                    <p class="text-[9px] text-gray-400 font-mono"><i class="fa-solid fa-circle text-emerald-500 text-[6px] mr-1"></i>Konsisten Unduh Modul</p>
                </div>
            </div>
        </div>
        <div class="flex items-center space-x-6 text-right font-mono">
            <span class="hidden sm:inline text-[10px] text-gray-400">Akurasi Tes: <b>85%</b></span>
            <div class="pr-2">
                <span class="text-xs font-black text-purple-600 dark:text-purple-400">1,980</span>
                <span class="text-[9px] text-gray-400 block -mt-1">XP</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-purple-900 to-indigo-950 text-white p-3.5 rounded-2xl border-2 border-purple-500/40 shadow-lg flex items-center justify-between gap-4 ring-4 ring-purple-600/10 mt-6">
        <div class="flex items-center space-x-4">
            <div class="w-8 h-8 rounded-xl bg-pink-500 text-white flex flex-col items-center justify-center font-mono font-black shadow-inner">
                <span class="text-[6px] leading-none uppercase text-pink-200">Rank</span>
                <span class="text-xs leading-tight">12</span>
            </div>
            <div class="flex items-center gap-2.5">
                <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed=Siswa1" class="w-7 h-7 rounded-xl bg-white/10 p-0.5 border border-white/20">
                <div>
                    <h5 class="font-bold text-xs flex items-center gap-1.5">
                        Siswa Lab Komputasi 1 
                        <span class="text-[8px] px-1.5 py-0.5 bg-pink-500 text-white rounded font-mono font-bold uppercase tracking-wider">Kamu</span>
                    </h5>
                    <p class="text-[10px] text-purple-200/50 font-mono">Tingkat Keaktifan Sesi: <span class="text-emerald-400 font-bold">65%</span></p>
                </div>
            </div>
        </div>
        
        <div class="text-right font-mono pr-2">
            <span class="text-sm font-black text-emerald-400">1,540</span>
            <span class="text-[9px] text-purple-300 block -mt-1">TOTAL XP</span>
        </div>
    </div>

</div>
@endsection