
@extends('guru.layouts.app')

@section('title', 'Ruang Ujian - Kelola Ujian')

@section('content')

<style>
    .exam-page {
        --exam-primary: #5b5ce2;
        --exam-primary-light: #f0f0ff;
        --exam-text: #20243a;
        --exam-muted: #8b90a5;
        color: var(--exam-text);
    }

    .exam-page .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 26px;
    }

    .exam-page .page-heading h3 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 6px;
        letter-spacing: -.5px;
    }

    .exam-page .page-heading p {
        color: var(--exam-muted);
        font-size: 13px;
        margin: 0;
    }

    .exam-page .btn-create {
        background: var(--exam-primary);
        color: #fff;
        border: none;
        padding: 12px 19px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        transition: .2s;
        box-shadow: 0 5px 15px rgba(91,92,226,.18);
    }

    .exam-page .btn-create:hover {
        background: #4849c9;
        color: #fff;
        transform: translateY(-2px);
    }

    /* STATISTICS */
    .exam-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 25px;
    }

    .exam-stat-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 17px;
        padding: 19px;
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
        box-shadow: 0 3px 15px rgba(25,35,70,.025);
    }

    .exam-stat-icon {
        width: 47px;
        height: 47px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .exam-stat-icon.purple {
        background: #f0efff;
        color: #6565df;
    }

    .exam-stat-icon.green {
        background: #e9f9f0;
        color: #20a76a;
    }

    .exam-stat-icon.orange {
        background: #fff4e8;
        color: #ef9b39;
    }

    .exam-stat-icon.gray {
        background: #f0f2f6;
        color: #7d8496;
    }

    .exam-stat-card small {
        color: var(--exam-muted);
        font-size: 12px;
        display: block;
        margin-bottom: 4px;
    }

    .exam-stat-card h4 {
        font-size: 23px;
        font-weight: 800;
        margin: 0;
    }

    /* TOOLBAR */
    .exam-toolbar {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 16px;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .exam-search {
        position: relative;
        width: 300px;
        max-width: 100%;
    }

    .exam-search i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0a5b5;
    }

    .exam-search input {
        width: 100%;
        border: 1px solid #edf0f5;
        background: #f9fafc;
        border-radius: 10px;
        padding: 11px 14px 11px 39px;
        outline: none;
        font-size: 13px;
    }

    .exam-search input:focus {
        border-color: #8585ef;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(91,92,226,.08);
    }

    .exam-filter {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .exam-filter select {
        min-width: 155px;
        border: 1px solid #edf0f5;
        border-radius: 10px;
        padding: 10px 13px;
        font-size: 13px;
        color: #555b70;
        outline: none;
        background: #fff;
    }

    .exam-filter button {
        border: none;
        background: #f0efff;
        color: var(--exam-primary);
        border-radius: 10px;
        padding: 10px 15px;
        font-size: 13px;
        font-weight: 700;
    }

    /* EXAM CARD */
    .exam-list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .exam-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        overflow: hidden;
        transition: .25s;
        box-shadow: 0 3px 15px rgba(25,35,70,.025);
    }

    .exam-card:hover {
        transform: translateY(-3px);
        border-color: #d9d9fb;
        box-shadow: 0 10px 28px rgba(25,35,70,.07);
    }

    .exam-card-top {
        padding: 20px 20px 15px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .exam-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0efff;
        color: var(--exam-primary);
        font-size: 21px;
        flex-shrink: 0;
    }

    .exam-card-title {
        flex: 1;
        min-width: 0;
    }

    .exam-card-title h5 {
        font-size: 16px;
        font-weight: 800;
        margin: 1px 0 6px;
        word-break: break-word;
    }

    .exam-card-title p {
        color: var(--exam-muted);
        font-size: 12px;
        margin: 0;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .exam-status {
        font-size: 11px;
        font-weight: 700;
        padding: 6px 11px;
        border-radius: 20px;
        white-space: nowrap;
    }

    .exam-status.aktif {
        background: #e9f9f0;
        color: #15965b;
    }

    .exam-status.draft {
        background: #fff5e8;
        color: #d88a27;
    }

    .exam-status.nonaktif {
        background: #f0f1f5;
        color: #7b8190;
    }

    .exam-card-divider {
        height: 1px;
        background: #f0f1f5;
        margin: 0 20px;
    }

    .exam-card-info {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        padding: 16px 20px;
    }

    .exam-info-item small {
        display: block;
        font-size: 11px;
        color: var(--exam-muted);
        margin-bottom: 5px;
    }

    .exam-info-item strong {
        font-size: 14px;
        font-weight: 800;
    }

    .exam-info-item strong.exp-value {
        color: #e49a28;
    }

    .exam-card-footer {
        padding: 13px 20px;
        background: #fafbfe;
        border-top: 1px solid #f0f1f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .exam-participant {
        color: var(--exam-muted);
        font-size: 11px;
    }

    .exam-actions {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .exam-action {
        border: 1px solid #e9eaf1;
        background: #fff;
        color: #646b7e;
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 13px;
        transition: .2s;
    }

    .exam-action:hover {
        color: var(--exam-primary);
        border-color: #cfcffd;
        background: #f4f3ff;
    }

    .exam-action.delete:hover {
        color: #e04e59;
        border-color: #ffd4d7;
        background: #fff1f2;
    }

    /* EMPTY STATE */
    .exam-empty {
        grid-column: 1 / -1;
        background: #fff;
        border: 1px dashed #dfe2ec;
        border-radius: 18px;
        padding: 55px 20px;
        text-align: center;
    }

    .exam-empty-icon {
        width: 70px;
        height: 70px;
        border-radius: 22px;
        background: #f0efff;
        color: var(--exam-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 29px;
        margin: 0 auto 17px;
    }

    .exam-empty h5 {
        font-weight: 800;
        font-size: 17px;
        margin-bottom: 8px;
    }

    .exam-empty p {
        color: var(--exam-muted);
        font-size: 13px;
        margin-bottom: 18px;
    }

    .exam-pagination {
        margin-top: 22px;
    }

    .exam-alert {
        border-radius: 12px;
        font-size: 13px;
        margin-bottom: 18px;
    }

    @media(max-width: 1100px) {
        .exam-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 768px) {
        .exam-list {
            grid-template-columns: 1fr;
        }

        .exam-page .page-heading h3 {
            font-size: 21px;
        }

        .exam-toolbar {
            align-items: stretch;
        }

        .exam-search {
            width: 100%;
        }

        .exam-filter {
            width: 100%;
        }

        .exam-filter select {
            flex: 1;
            min-width: 0;
        }
    }

    @media(max-width: 480px) {
        .exam-stats {
            grid-template-columns: 1fr 1fr;
            gap: 9px;
        }

        .exam-stat-card {
            padding: 13px 10px;
            gap: 9px;
        }

        .exam-stat-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }

        .exam-stat-card h4 {
            font-size: 19px;
        }

        .exam-stat-card small {
            font-size: 10px;
        }

        .exam-card-top {
            padding: 16px 14px 13px;
        }

        .exam-card-info {
            padding: 14px;
            gap: 5px;
        }

        .exam-card-footer {
            padding: 12px 14px;
        }

        .exam-status {
            font-size: 10px;
            padding: 5px 8px;
        }
    }
</style>

<div class="exam-page">

    {{-- HEADER --}}
    <div class="page-heading">
        <div>
            <h3>Ruang Ujian</h3>
            <p>Kelola ujian, soal, dan pengalaman belajar siswa dalam satu tempat.</p>
        </div>

        <a href="{{ route('guru.ruang-ujian.create') }}" class="btn-create">
            <i class="fas fa-plus"></i>
            Buat Ruang Ujian
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success exam-alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger exam-alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- STATISTICS --}}
    <div class="exam-stats">

        <div class="exam-stat-card">
            <div class="exam-stat-icon purple">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div>
                <small>Total Ruang Ujian</small>
                <h4>{{ $statistik['total'] ?? 0 }}</h4>
            </div>
        </div>

        <div class="exam-stat-card">
            <div class="exam-stat-icon green">
                <i class="fas fa-circle-check"></i>
            </div>
            <div>
                <small>Ujian Aktif</small>
                <h4>{{ $statistik['aktif'] ?? 0 }}</h4>
            </div>
        </div>

        <div class="exam-stat-card">
            <div class="exam-stat-icon orange">
                <i class="fas fa-file-circle-question"></i>
            </div>
            <div>
                <small>Ujian Draft</small>
                <h4>{{ $statistik['draft'] ?? 0 }}</h4>
            </div>
        </div>

        <div class="exam-stat-card">
            <div class="exam-stat-icon gray">
                <i class="fas fa-ban"></i>
            </div>
            <div>
                <small>Ujian Nonaktif</small>
                <h4>{{ $statistik['nonaktif'] ?? 0 }}</h4>
            </div>
        </div>

    </div>

    {{-- SEARCH & FILTER --}}
    <form action="{{ route('guru.ruang-ujian.index') }}" method="GET" class="exam-toolbar">

        <div class="exam-search">
            <i class="fas fa-search"></i>
            <input
                type="text"
                name="search"
                placeholder="Cari nama ruang ujian..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="exam-filter">

            <select name="status">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                    Draft
                </option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>

            <button type="submit">
                <i class="fas fa-filter me-1"></i>
                Filter
            </button>

        </div>
    </form>

    {{-- EXAM LIST --}}
    <div class="exam-list">

        @forelse($ruangUjians as $ruangUjian)

            <div class="exam-card">

                {{-- CARD HEADER --}}
                <div class="exam-card-top">

                    <div class="exam-card-icon">
                        <i class="fas fa-file-signature"></i>
                    </div>

                    <div class="exam-card-title">
                        <h5>{{ $ruangUjian->judul }}</h5>

                        <p>
                            {{ $ruangUjian->deskripsi ?: 'Belum ada deskripsi ruang ujian.' }}
                        </p>
                    </div>

                    <span class="exam-status {{ $ruangUjian->status }}">
                        @if($ruangUjian->status === 'aktif')
                            Aktif
                        @elseif($ruangUjian->status === 'draft')
                            Draft
                        @else
                            Nonaktif
                        @endif
                    </span>

                </div>

                <div class="exam-card-divider"></div>

                {{-- CARD INFORMATION --}}
                <div class="exam-card-info">

                    <div class="exam-info-item">
                        <small><i class="fas fa-list-ol me-1"></i> Jumlah Soal</small>
                        <strong>{{ $ruangUjian->soal_count ?? 0 }} Soal</strong>
                    </div>

                    <div class="exam-info-item">
                        <small><i class="fas fa-star me-1"></i> Total EXP</small>
                        <strong class="exp-value">
                            {{ number_format($ruangUjian->soal_sum_exp ?? 0) }} EXP
                        </strong>
                    </div>

                    <div class="exam-info-item">
                        <small><i class="fas fa-clock me-1"></i> Durasi</small>
                        <strong>{{ $ruangUjian->durasi_menit }} Menit</strong>
                    </div>

                </div>

                {{-- CARD FOOTER --}}
                <div class="exam-card-footer">

                    <div class="exam-participant">
                        <i class="fas fa-users me-1"></i>
                        {{ $ruangUjian->hasil_ujian_count ?? 0 }} Pengerjaan
                    </div>

                    <div class="exam-actions">

                        {{-- Detail --}}
                        <a
                            href="{{ route('guru.ruang-ujian.show', $ruangUjian->id) }}"
                            class="exam-action"
                            title="Lihat Detail"
                        >
                            <i class="fas fa-eye"></i>
                        </a>

                        {{-- Edit --}}
                        <a
                            href="{{ route('guru.ruang-ujian.edit', $ruangUjian->id) }}"
                            class="exam-action"
                            title="Edit Ruang Ujian"
                        >
                            <i class="fas fa-pen"></i>
                        </a>

                        {{-- Delete --}}
                        <form
                            action="{{ route('guru.ruang-ujian.destroy', $ruangUjian->id) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus ruang ujian ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="exam-action delete"
                                title="Hapus Ruang Ujian"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="exam-empty">

                <div class="exam-empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>

                @if(request()->filled('search') || request()->filled('status'))
                    <h5>Ruang Ujian Tidak Ditemukan</h5>
                    <p>Coba ubah kata kunci pencarian atau filter status.</p>

                    <a href="{{ route('guru.ruang-ujian.index') }}" class="btn-create">
                        <i class="fas fa-rotate-left"></i>
                        Reset Filter
                    </a>
                @else
                    <h5>Belum Ada Ruang Ujian</h5>
                    <p>Mulai buat ruang ujian untuk menambahkan soal dan mengatur EXP siswa.</p>

                    <a href="{{ route('guru.ruang-ujian.create') }}" class="btn-create">
                        <i class="fas fa-plus"></i>
                        Buat Ruang Ujian Pertama
                    </a>
                @endif

            </div>

        @endforelse

    </div>

    {{-- PAGINATION --}}
    @if($ruangUjians->hasPages())
        <div class="exam-pagination">
            {{ $ruangUjians->links() }}
        </div>
    @endif

</div>

@endsection
