@extends('siswa.layouts.app')
@section('title', 'Peta Petualangan Belajar')

@section('content')
@php
    $materis = isset($ruangMateri) && $ruangMateri
        ? collect([$ruangMateri])
        : collect($materis ?? [])->filter(fn ($item) => $item instanceof \App\Models\Materi)->values();

    $completedIds = collect($completedIds ?? [])->map(fn ($id) => (string) $id)->all();

    $user = $user ?? auth()->user();
    $totalXp = max(0, (int) $user->totalXp());
    $xpMisiSelesai = (int) ($xpMisiSelesai ?? $xpDiperoleh ?? 0);

    $xpNeeded = 1000;
    $level = intdiv((int) $totalXp, $xpNeeded) + 1;
    $xpInLevel = $totalXp % $xpNeeded;

    $levelProgress = max(0, min(100, ($xpInLevel / $xpNeeded) * 100));
    $overall = max(0, min(100, (float) ($overallProgress ?? 0)));
    $playerName = $user->fullname ?? $user->name ?? 'Petualang';

    // Hitung progres berdasarkan seluruh submateri pada dashboard ini.
    $totalSubmateriDashboard = $materis->sum(
        fn ($materi) => collect($materi->submateris ?? [])->count()
    );

    $totalCompletedDashboard = $materis->sum(
        fn ($materi) => collect($materi->submateris ?? [])
            ->filter(fn ($submateri) => in_array(
                (string) $submateri->id,
                $completedIds,
                true
            ))
            ->count()
    );

    $allSubmateriCompleted = $totalSubmateriDashboard > 0
        && $totalCompletedDashboard === $totalSubmateriDashboard;

    // Penanda apakah dashboard sedang dibuka dari Ruang Belajar.
    $isFromRuangBelajar = isset($ruangBelajar, $tahapan)
        && $ruangBelajar
        && $tahapan;
@endphp

<style>
    .adventure-page {
        --q-bg:#f4f5fc; --q-panel:#ffffff; --q-panel-soft:#f8f7ff;
        --q-text:#19243a; --q-muted:#64748b; --q-border:#e1e5f1;
        --q-map-a:#f5edff; --q-map-b:#f6f9ff; --q-path:#cbd5e1;
        --q-done:#16a34a; --q-current:#9333ea; --q-locked:#94a3b8;
        background:var(--q-bg);color:var(--q-text);min-height:100vh;
        transition:background .25s,color .25s;
    }
    .dark .adventure-page, .adventure-page.quest-dark {
        --q-bg:#0e1724; --q-panel:#182536; --q-panel-soft:#202f42;
        --q-text:#f4f6ff; --q-muted:#a2afc2; --q-border:#304154;
        --q-map-a:#25223e; --q-map-b:#111e2d; --q-path:#43536a;
        --q-done:#22c55e; --q-current:#a855f7; --q-locked:#64748b;
    }
    .adventure-page .q-card {background:var(--q-panel);border:1px solid var(--q-border);border-radius:22px;box-shadow:0 12px 35px rgba(25,35,70,.045)}
    .adventure-page .q-muted{color:var(--q-muted)}
    .adventure-page .q-soft{background:var(--q-panel-soft);border:1px solid var(--q-border)}
    .adventure-page .q-progress{height:9px;border-radius:99px;overflow:hidden;background:var(--q-border)}
    .adventure-page .q-progress>div{height:100%;border-radius:99px;background:linear-gradient(90deg,#7c3aed,#d946ef);transition:width .5s}
    .adventure-page .q-map{overflow:hidden;border-radius:24px;border:1px solid var(--q-border);background:radial-gradient(ellipse at 50% 12%,var(--q-map-a),var(--q-map-b) 65%)}
    .adventure-page .q-path{position:relative;width:100%;max-width:460px;margin:0 auto;min-height:120px}
    .adventure-page .q-lines{position:absolute;inset:0;width:100%;height:100%;pointer-events:none;overflow:visible}
    .adventure-page .q-lines line{stroke:var(--q-path);stroke-width:9;stroke-linecap:round}
    .adventure-page .q-lines line.complete{stroke:var(--q-done)}
    .adventure-page .q-lines line.next{stroke:var(--q-current);stroke-dasharray:9 9}
    .adventure-page .q-node{position:absolute;z-index:2;display:flex;align-items:center;flex-direction:column;transform:translateX(-50%);width:126px;text-align:center}
    .adventure-page .q-hex{display:flex;align-items:center;justify-content:center;width:78px;height:84px;clip-path:polygon(25% 4%,75% 4%,100% 27%,100% 73%,75% 96%,25% 96%,0 73%,0 27%);border:0;cursor:pointer;color:white;font-size:28px;font-weight:900;transition:transform .2s,filter .2s}
    .adventure-page button.q-hex:hover{transform:translateY(-4px) scale(1.06);filter:brightness(1.08)}
    .adventure-page button.q-hex:focus-visible{outline:3px solid #f59e0b;outline-offset:5px}
    .adventure-page .q-hex.done{background:linear-gradient(145deg,#4ade80,#15803d);filter:drop-shadow(0 5px 2px rgba(21,128,61,.2))}
    .adventure-page .q-hex.active{background:linear-gradient(145deg,#d8b4fe,#9333ea 65%,#6b21a8);animation:q-pulse 2.2s ease-in-out infinite}
    .adventure-page .q-hex.locked{background:linear-gradient(145deg,#aab5c5,#64748b);color:#edf2f7;cursor:not-allowed;opacity:.78}
    .adventure-page .q-label{margin-top:7px;max-width:124px;font-size:11px;line-height:1.4;font-weight:700;overflow-wrap:anywhere;color:var(--q-muted)}
    .adventure-page .q-label.active{color:var(--q-current)}
    .adventure-page .q-label.done{color:var(--q-done)}
    .adventure-page .q-status{font-size:10px;font-weight:800;padding:4px 9px;border-radius:99px;margin-bottom:6px;white-space:nowrap}
    .adventure-page .q-status.active{background:#ede9fe;color:#6d28d9}
    .adventure-page .q-status.done{background:#dcfce7;color:#166534}
    .adventure-page .q-status.locked{background:var(--q-panel-soft);color:var(--q-muted);border:1px solid var(--q-border)}
    .adventure-page .q-back{display:flex;align-items:center;gap:10px;width:100%;padding:12px;border:1px solid var(--q-border);border-radius:14px;background:var(--q-panel-soft);color:var(--q-text);font-size:12px;font-weight:800;transition:transform .2s,border-color .2s}
    .adventure-page .q-back:hover{transform:translateY(-2px);border-color:#a78bfa}
    .adventure-page .q-modal-overlay{position:fixed;inset:0;z-index:1000;background:rgba(8,13,28,.72);display:flex;align-items:center;justify-content:center;padding:18px;backdrop-filter:blur(6px)}
    .adventure-page .q-modal{width:100%;max-width:440px;background:var(--q-panel);color:var(--q-text);border:1px solid var(--q-border);border-radius:26px;padding:26px;box-shadow:0 24px 70px rgba(0,0,0,.25)}
    .adventure-page .q-action{display:flex;justify-content:center;align-items:center;gap:9px;width:100%;padding:13px 16px;border-radius:13px;background:linear-gradient(90deg,#7c3aed,#a21caf);color:white;font-size:14px;font-weight:800;text-decoration:none;transition:filter .2s}
    .adventure-page .q-action:hover{filter:brightness(1.12)}
    [x-cloak]{display:none!important}
    @keyframes q-pulse{0%,100%{filter:drop-shadow(0 0 4px rgba(147,51,234,.45))}50%{filter:drop-shadow(0 0 15px rgba(168,85,247,.85))}}
    @media(max-width:640px){.adventure-page .q-node{width:102px}.adventure-page .q-hex{width:64px;height:70px;font-size:23px}.adventure-page .q-label{max-width:102px;font-size:10px}.adventure-page .q-map{border-radius:18px}}
    @media(prefers-reduced-motion:reduce){.adventure-page .q-hex.active{animation:none} .adventure-page *{scroll-behavior:auto!important}}
</style>

<div class="adventure-page px-3 py-6 sm:px-6 lg:px-8"
     x-data="{
        selected: null,
        showMission(mission) { this.selected = mission; },
        closeMission() { this.selected = null; }
     }"
     x-bind:class="typeof darkMode !== 'undefined' && darkMode ? 'quest-dark' : ''"
     @keydown.escape.window="closeMission()">

    <div class="mx-auto max-w-[1450px]">

        <header class="mb-6 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-black uppercase tracking-[.2em] text-violet-500">✦ Adventure Learning</p>
                <h1 class="mt-1 text-2xl font-black sm:text-3xl">🗺️ Peta Petualangan</h1>
                <p class="q-muted mt-2 text-sm">Halo, {{ $playerName }}! Selesaikan misi untuk membuka perjalanan berikutnya.</p>
            </div>
            <span class="q-soft rounded-full px-4 py-2 text-xs font-extrabold">
                ✨ {{ $totalCompleted ?? $totalCompletedDashboard }} / {{ $totalSubmateri ?? $totalSubmateriDashboard }} misi selesai
            </span>
        </header>

        <div class="grid grid-cols-1 items-start gap-5 xl:grid-cols-[245px_minmax(0,1fr)_245px]">

            {{-- KIRI: PLAYER & XP --}}
            <aside class="order-2 space-y-4 xl:order-1 xl:sticky xl:top-5 xl:self-start">
                <section class="q-card overflow-hidden p-5 text-center">
                    <div class="relative mx-auto mb-3 w-fit">
                        <div class="absolute -inset-2 rounded-3xl bg-violet-400/20 blur-lg"></div>
                        <img src="https://api.dicebear.com/7.x/bottts-neutral/svg?seed={{ urlencode($playerName) }}&backgroundColor=b6e3f4"
                             alt="Avatar {{ $playerName }}"
                             class="relative h-20 w-20 rounded-2xl border-2 border-violet-300 object-cover">
                        <span class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white bg-emerald-500"></span>
                    </div>

                    <h2 class="truncate text-base font-black" title="{{ $playerName }}">{{ $playerName }}</h2>
                    <p class="q-muted mt-1 text-xs">Penjelajah Pengetahuan</p>
                    <span class="mt-3 inline-flex rounded-full bg-violet-100 px-3 py-1 text-xs font-black text-violet-700">🏆 LEVEL {{ $level }}</span>

                    <div class="q-soft mt-5 rounded-2xl p-4 text-left">
                        <div class="mb-2 flex items-center justify-between gap-2 text-xs font-bold">
                            <span>Progress Level</span>
                            <span class="text-violet-500">{{ round($levelProgress) }}%</span>
                        </div>
                        <div class="q-progress"><div style="width:{{ $levelProgress }}%"></div></div>
                        <p class="q-muted mt-2 text-[11px]">{{ number_format($xpInLevel) }} / {{ number_format($xpNeeded) }} XP</p>
                    </div>

                    <div class="mt-3 rounded-2xl border border-amber-300/30 bg-amber-400/10 p-4 text-left">
                        <p class="text-xs font-black text-amber-600 dark:text-amber-300">⚡ TOTAL XP</p>
                        <p class="mt-1 text-2xl font-black">{{ number_format($xpMisiSelesai, 0, ',', '.') }} <span class="text-sm text-amber-500">XP</span></p>
                        <p class="q-muted mt-1 text-[11px]">Hadiah dari misi yang kamu taklukkan</p>
                    </div>

                    <a href="{{ route('siswa.ruang-materi.index') }}" class="q-back mt-4 text-left">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-violet-100 text-violet-700">
                            <i class="fa-solid fa-arrow-left"></i>
                        </span>
                        <span>
                            <span class="block">Kembali ke Dashboard</span>
                            <span class="q-muted mt-0.5 block text-[10px] font-medium">Halaman ruang materi</span>
                        </span>
                    </a>
                </section>
            </aside>

            {{-- TENGAH: MAP --}}
            <main class="order-1 min-w-0 space-y-5 xl:order-2">

                @forelse($materis as $materi)
                    @php
                        $submateris = collect($materi->submateris ?? [])->values();
                        $total = $submateris->count();

                        $completedCount = $submateris->filter(
                            fn ($sub) => in_array((string) $sub->id, $completedIds, true)
                        )->count();

                        $percentage = $total ? round($completedCount / $total * 100) : 0;
                        $previousCompleted = true;
                        $positions = [50, 32, 50, 68, 50, 32, 50, 68];
                        $rowHeight = 142;
                        $mapHeight = max(155, $total * $rowHeight + 10);
                    @endphp

                    <section class="q-map">

                        <div class="flex flex-wrap items-center justify-between gap-3 bg-gradient-to-r from-violet-700 to-fuchsia-600 px-5 py-5 text-white sm:px-7">
                            <div class="min-w-0">
                                <p class="text-[10px] font-black uppercase tracking-[.18em] text-violet-100">✦ Dunia Pembelajaran</p>
                                <h2 class="mt-1 text-lg font-black sm:text-xl">{{ $materi->judul }}</h2>
                                <p class="mt-1 text-xs text-violet-100">{{ $completedCount }} dari {{ $total }} misi selesai</p>
                            </div>
                            <span class="rounded-xl border border-white/30 bg-white/15 px-4 py-2 text-sm font-black">{{ $percentage }}%</span>
                        </div>

                        <div class="px-3 py-7 sm:px-7">
                            @if($total > 0)

                                <div class="text-center">
                                    <span class="q-soft inline-flex rounded-full px-4 py-2 text-xs font-black">🏁 START</span>
                                    <p class="q-muted mt-3 text-xs">Pilih checkpoint untuk melihat detail misi!</p>
                                </div>

                                <div class="q-path mt-7" style="height:{{ $mapHeight }}px">

                                    <svg class="q-lines" viewBox="0 0 100 {{ $mapHeight }}" preserveAspectRatio="none" aria-hidden="true">
                                        @foreach($submateris as $index => $submateri)
                                            @if($index > 0)
                                                @php
                                                    $prevCompleted = in_array((string) $submateris[$index - 1]->id, $completedIds, true);
                                                    $currCompleted = in_array((string) $submateri->id, $completedIds, true);
                                                    $lineState = $prevCompleted && $currCompleted ? 'complete' : ($prevCompleted ? 'next' : '');
                                                @endphp

                                                <line x1="{{ $positions[($index - 1) % count($positions)] }}"
                                                      y1="{{ ($index - 1) * $rowHeight + 66 }}"
                                                      x2="{{ $positions[$index % count($positions)] }}"
                                                      y2="{{ $index * $rowHeight + 66 }}"
                                                      class="{{ $lineState }}"
                                                      vector-effect="non-scaling-stroke" />
                                            @endif
                                        @endforeach
                                    </svg>

                                    @foreach($submateris as $index => $submateri)
                                        @php
                                            $isCompleted = in_array((string) $submateri->id, $completedIds, true);
                                            $isUnlocked = $previousCompleted || $isCompleted;
                                            $isActive = $isUnlocked && !$isCompleted;
                                            $previousCompleted = $isCompleted;

                                            $state = $isCompleted ? 'done' : ($isActive ? 'active' : 'locked');
                                            $position = $positions[$index % count($positions)];
                                            $missionUrl = null;

                                            if ($isUnlocked) {
                                                if ($isFromRuangBelajar) {
                                                    $missionUrl = route(
                                                        'siswa.ruang-materi.ruang-belajar.submateri.show',
                                                        [
                                                            'ruangBelajar' => $ruangBelajar->id,
                                                            'tahapan' => $tahapan->id,
                                                            'materi' => $materi->id,
                                                            'submateri' => $submateri->id,
                                                        ]
                                                    );
                                                } else {
                                                    $missionUrl = route(
                                                        'siswa.ruang-materi.dashboard-belajar.submateri.show',
                                                        [
                                                            'materi' => $materi->id,
                                                            'submateri' => $submateri->id,
                                                        ]
                                                    );
                                                }
                                            }
                                        @endphp

                                        <div class="q-node" style="top:{{ $index * $rowHeight }}px;left:{{ $position }}%">
                                            <span class="q-status {{ $state }}">
                                                {{ $isCompleted ? '✓ SELESAI' : ($isActive ? '▶ MAIN' : '🔒 TERKUNCI') }}
                                            </span>

                                            @if($isUnlocked)
                                                <button type="button"
                                                        class="q-hex {{ $state }}"
                                                        @click="showMission({
                                                            title: @js($submateri->judul_sub),
                                                            number: {{ $index + 1 }},
                                                            xp: {{ (int) ($submateri->xp_reward ?? 0) }},
                                                            done: {{ $isCompleted ? 'true' : 'false' }},
                                                            url: @js($missionUrl)
                                                        })"
                                                        aria-label="Lihat misi {{ $submateri->judul_sub }}">
                                                    <span aria-hidden="true">{{ $isCompleted ? '✓' : '✦' }}</span>
                                                </button>
                                            @else
                                                <button type="button"
                                                        class="q-hex locked"
                                                        disabled
                                                        title="Selesaikan misi sebelumnya"
                                                        aria-label="Misi {{ $submateri->judul_sub }} terkunci">
                                                    <i class="fa-solid fa-lock text-xl" aria-hidden="true"></i>
                                                </button>
                                            @endif

                                            <p class="q-label {{ $state }}">{{ $submateri->judul_sub }}</p>

                                            @if($isActive)
                                                <span class="mt-1 text-[10px] font-black text-amber-500">
                                                    ⚡ +{{ number_format($submateri->xp_reward ?? 0) }} XP
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-3 border-t pt-6 text-center text-xs font-bold"
                                     style="border-color:var(--q-border);color:var(--q-muted)">
                                    {{ $percentage === 100 ? '🏆 Selamat! Semua misi di dunia ini selesai.' : '🏆 Selesaikan semua misi untuk menaklukkan dunia ini!' }}
                                </div>

                            @else
                                <div class="py-12 text-center">
                                    <div class="text-5xl">📖</div>
                                    <h3 class="mt-3 font-black">Belum ada misi</h3>
                                    <p class="q-muted mt-2 text-sm">Guru belum menambahkan submateri.</p>
                                </div>
                            @endif
                        </div>
                    </section>

                @empty
                    <div class="q-card px-5 py-16 text-center">
                        <div class="text-5xl">🗺️</div>
                        <h2 class="mt-4 text-xl font-black">Petualangan belum dimulai</h2>
                        <p class="q-muted mt-2 text-sm">Pilih materi untuk memulai perjalananmu.</p>
                        <a href="{{ route('siswa.ruang-materi.eksplorasi') }}"
                           class="mt-5 inline-flex rounded-xl bg-violet-600 px-5 py-3 text-sm font-bold text-white">
                            Jelajahi Materi →
                        </a>
                    </div>
                @endforelse

                {{-- TOMBOL KEMBALI HANYA UNTUK AKSES DARI RUANG BELAJAR --}}
                @if($isFromRuangBelajar && $allSubmateriCompleted)
                    <div class="q-card relative overflow-hidden border border-green-300 p-6 text-center">

                        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-green-400/10"></div>
                        <div class="absolute -bottom-8 -left-8 h-28 w-28 rounded-full bg-green-400/10"></div>

                        <div class="relative">
                            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-green-100 text-5xl">
                                🏆
                            </div>

                            <span class="inline-flex rounded-full bg-green-100 px-4 py-1.5 text-xs font-black text-green-700">
                                SEMUA MISI SELESAI
                            </span>

                            <h3 class="mt-4 text-xl font-black text-green-600">
                                Selamat! Kamu Berhasil!
                            </h3>

                            <p class="q-muted mx-auto mt-3 max-w-md text-sm leading-relaxed">
                                Kamu telah menyelesaikan seluruh submateri dalam tahapan
                                <strong>{{ $tahapan->nama ?? $tahapan->judul ?? 'ini' }}</strong>.
                                Sekarang kamu dapat kembali ke Ruang Belajar untuk
                                melanjutkan tahapan pembelajaran berikutnya.
                            </p>

                            <div class="mx-auto mt-5 flex max-w-xs items-center justify-center gap-3 rounded-2xl bg-green-50 p-4 text-green-700">
                                <i class="fa-solid fa-circle-check text-xl"></i>
                                <div class="text-left">
                                    <p class="text-sm font-black">
                                        {{ $totalCompletedDashboard }} / {{ $totalSubmateriDashboard }} Submateri
                                    </p>
                                    <p class="text-xs">Seluruh pembelajaran telah diselesaikan</p>
                                </div>
                            </div>

                            <a href="{{ route('siswa.ruang-belajar.tahapan', ['id' => $ruangBelajar->id]) }}"
                               class="mt-6 inline-flex w-full max-w-sm items-center justify-center gap-3 rounded-2xl bg-green-600 px-6 py-4 text-sm font-black text-white shadow-lg shadow-green-600/20 transition hover:-translate-y-1 hover:bg-green-700">
                                <i class="fa-solid fa-arrow-left"></i>
                                KEMBALI KE RUANG BELAJAR
                            </a>
                        </div>
                    </div>
                @endif

            </main>

            {{-- KANAN: STATISTIK & PANDUAN --}}
            <aside class="order-3 space-y-4 xl:sticky xl:top-5 xl:self-start">

                <section class="q-card p-5">
                    <h2 class="font-black">📊 Progres Petualangan</h2>
                    <p class="mt-4 text-3xl font-black text-violet-500">{{ round($overall) }}%</p>
                    <div class="q-progress mt-3"><div style="width:{{ $overall }}%"></div></div>
                    <p class="q-muted mt-2 text-xs">Total perjalanan yang diselesaikan</p>

                    <div class="mt-5 space-y-3 border-t pt-4 text-sm" style="border-color:var(--q-border)">
                        <div class="flex justify-between">
                            <span class="q-muted">📚 Dunia</span>
                            <strong>{{ $materis->count() }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="q-muted">⭐ Misi selesai</span>
                            <strong>{{ $totalCompleted ?? $totalCompletedDashboard }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span class="q-muted">🎯 Total misi</span>
                            <strong>{{ $totalSubmateri ?? $totalSubmateriDashboard }}</strong>
                        </div>
                    </div>
                </section>

                <section class="q-card p-5">
                    <h2 class="font-black">🎮 Panduan Peta</h2>
                    <div class="mt-4 space-y-3 text-xs">
                        <p class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-full bg-green-500"></span>
                            <span class="q-muted">Hijau — misi selesai</span>
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-full bg-purple-500"></span>
                            <span class="q-muted">Ungu — misi aktif</span>
                        </p>
                        <p class="flex items-center gap-3">
                            <span class="h-3 w-3 rounded-full bg-slate-400"></span>
                            <span class="q-muted">Abu-abu — misi terkunci</span>
                        </p>
                    </div>
                    <p class="q-muted mt-5 text-xs leading-relaxed">
                        Klik misi yang terbuka untuk melihat detail dan mulai belajar.
                        Misi berikutnya terbuka setelah misi sebelumnya selesai.
                    </p>
                </section>

            </aside>
        </div>
    </div>

    {{-- MODAL DETAIL MISI --}}
    <template x-if="selected !== null">
        <div class="q-modal-overlay" @click.self="closeMission()" role="presentation">
            <section class="q-modal relative" role="dialog" aria-modal="true" aria-labelledby="quest-dialog-title">

                <button type="button"
                        @click="closeMission()"
                        aria-label="Tutup detail misi"
                        class="q-soft absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-xl">
                    ✕
                </button>

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl text-3xl"
                     :class="selected.done ? 'bg-green-100 text-green-700' : 'bg-violet-100 text-violet-700'">
                    <span x-text="selected.done ? '✓' : '✦'"></span>
                </div>

                <p class="mt-5 text-center text-xs font-black uppercase tracking-widest text-violet-500"
                   x-text="'MISI ' + String(selected.number).padStart(2, '0')"></p>

                <h2 id="quest-dialog-title"
                    class="mt-2 text-center text-xl font-black"
                    x-text="selected.title"></h2>

                <p class="q-muted mt-3 text-center text-sm"
                   x-text="selected.done ? 'Misi ini sudah kamu selesaikan. Kamu bisa mempelajarinya kembali.' : 'Siap menaklukkan tantangan berikutnya?'"></p>

                <div class="q-soft mx-auto mt-5 w-fit rounded-full px-4 py-2 text-xs font-black text-amber-600">
                    <span x-text="'⚡ +' + selected.xp + ' XP'"></span>
                </div>

                <a class="q-action mt-6" :href="selected.url">
                    <i class="fa-solid fa-play"></i>
                    <span x-text="selected.done ? 'Pelajari Lagi' : 'Mulai Misi'"></span>
                </a>

                <button type="button"
                        @click="closeMission()"
                        class="q-muted mt-4 w-full py-2 text-center text-sm font-bold">
                    Nanti Saja
                </button>

            </section>
        </div>
    </template>
</div>

@if(session()->has('earned_xp') && session('earned_xp') > 0)
<script>
window.addEventListener('load', function () {
    const earnedXp = Number(@json(session('earned_xp')));
    const submateri = @json(session('completed_submateri', 'Submateri'));

    if (typeof window.Swal === 'undefined') {
        console.error('SweetAlert2 belum tersedia.');
        return;
    }

    Swal.fire({
        icon: 'success',
        title: '🏆 MISI SELESAI!',
        text: 'Selamat! Kamu menyelesaikan ' +
              submateri + ' dan mendapatkan +' +
              earnedXp + ' XP!',
        background: '#ffffff',
        color: '#1f2937',
        confirmButtonText: 'LANJUT BELAJAR →',
        confirmButtonColor: '#eab308',
        customClass: {
            popup: 'rounded-3xl',
            title: 'font-extrabold',
            confirmButton: 'rounded-xl font-bold px-6 py-3'
        },
        buttonsStyling: true,
        allowOutsideClick: false
    });
});
</script>
@endif

@endsection
