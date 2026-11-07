
@extends('siswa.layouts.app')

@section('title', 'Kerjakan - ' . $submateri->judul_sub)

@section('content')

@php
    $totalBlocks = count($blocks ?? []);
@endphp

<div
    id="learning-game"
    class="fixed inset-0 z-[999] flex flex-col
           overflow-hidden bg-[#292929] text-white"
>

    {{-- HEADER PEMBELAJARAN --}}
    <div class="relative z-20 w-full shrink-0">
        @include('siswa.aktivitas-materi.kerjakan.partials.header')
    </div>

    {{-- KONTEN YANG DAPAT DI-SCROLL --}}
    <div class="min-h-0 flex-1 overflow-y-auto">

        <main class="mx-auto flex w-full max-w-3xl
                     flex-col px-4 pb-10 pt-6 sm:px-8">

            {{-- KARAKTER --}}
            @include(
                'siswa.aktivitas-materi.kerjakan.partials.character'
            )

            {{-- DAFTAR AKTIVITAS --}}
            <div id="task-wrapper" class="mt-6 space-y-6">

                @forelse($blocks as $index => $block)

                    @include(
                        'siswa.aktivitas-materi.kerjakan.partials.task-renderer',
                        [
                            'block' => $block,
                            'index' => $index
                        ]
                    )

                @empty

                    <div class="rounded-xl bg-[#333]
                                p-8 text-center text-gray-400">
                        Belum ada aktivitas pembelajaran.
                    </div>

                @endforelse

            </div>

            {{-- NAVIGASI --}}
            @include(
                'siswa.aktivitas-materi.kerjakan.partials.navigation'
            )

        </main>

    </div>

</div>

{{-- SCRIPT AKTIVITAS --}}
@include('siswa.aktivitas-materi.kerjakan.scripts.praktik')
@include('siswa.aktivitas-materi.kerjakan.scripts.latihan')
@include('siswa.aktivitas-materi.kerjakan.scripts.pilihan-ganda')
@include('siswa.aktivitas-materi.kerjakan.scripts.coding-project')

{{-- SCRIPT NAVIGASI --}}
@include('siswa.aktivitas-materi.kerjakan.scripts.navigation')
@include('siswa.aktivitas-materi.kerjakan.scripts.character')

{{-- SCRIPT PROGRESS --}}

@endsection
