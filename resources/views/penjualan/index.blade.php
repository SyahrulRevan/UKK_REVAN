@extends('layouts.app')

@section('title', 'Riwayat Penjualan')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-dark-yellow: #0c0a09;
        --card-bg-dark: #1c1917;
        --border-yellow-subtle: rgba(245, 158, 11, 0.15);
        --accent-yellow: #f59e0b;
        --accent-yellow-hover: #d97706;
        --text-white: #fafaf9;
        --text-subtle: #a8a29e;
    }

    body {
        background-color: var(--bg-dark-yellow) !important;
        color: var(--text-white) !important;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
    }

    .card-dark-yellow {
        background: var(--card-bg-dark) !important;
        border: 1px solid var(--border-yellow-subtle);
        border-radius: 1rem;
    }

    .table-dark-yellow {
        color: var(--text-white) !important;
        margin-bottom: 0;
        --bs-table-bg: transparent !important;
    }

    .table-dark-yellow th {
        background-color: rgba(12, 10, 9, 0.6) !important;
        color: var(--text-subtle) !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        border-bottom: 1px solid var(--border-yellow-subtle) !important;
        padding: 1rem 1.25rem;
    }

    .table-dark-yellow td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    .table-dark-yellow tbody tr:hover td {
        background-color: rgba(245, 158, 11, 0.04) !important;
    }

    /* Tombol Utama Khas Dark Yellow */
    .btn-yellow {
        background: var(--accent-yellow) !important;
        color: #000000 !important;
        font-weight: 700;
        border: none !important;
        transition: all 0.2s ease;
    }

    .btn-yellow:hover {
        background: var(--accent-yellow-hover) !important;
        color: #000000 !important;
    }

    .form-control-dark {
        background-color: rgba(12, 10, 9, 0.7) !important;
        border: 1px solid var(--border-yellow-subtle) !important;
        color: #ffffff !important;
        padding: 0.65rem 1rem;
        border-radius: 0.625rem;
    }

    .form-control-dark:focus {
        border-color: var(--accent-yellow) !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.2) !important;
    }

    /* Badge Style */
    .badge-cash {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
        font-weight: 600;
        padding: 0.35em 0.8em;
    }

    .badge-qris {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
        font-weight: 600;
        padding: 0.35em 0.8em;
    }

    .badge-completed {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
        font-weight: 600;
        padding: 0.35em 0.8em;
    }

    .badge-refunded {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.3);
        font-weight: 600;
        padding: 0.35em 0.8em;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
        font-weight: 600;
        padding: 0.35em 0.8em;
    }

    .btn-action-detail {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.25);
    }
    .btn-action-detail:hover {
        background: rgba(59, 130, 246, 0.25);
        color: #93c5fd;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 border-bottom border-secondary border-opacity-25">
        <div>
            <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">
                Riwayat Penjualan
            </h1>
            <p class="text-muted small mb-0">Daftar seluruh transaksi kasir dan riwayat pembayaran.</p>
        </div>
        <div class="mt-3 mt-md-0">
            @if(Route::has('penjualan.create'))
            <a href="{{ route('penjualan.create') }}" class="btn btn-yellow px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                <i class="bi bi-cart-plus-fill"></i> Transaksi Baru
            </a>
            @endif
        </div>
    </div>

    {{-- FITUR PENCARIAN --}}
    <div class="row mb-4">
        <div class="col-12 col-md-6 col-lg-4">
            <form action="{{ route('penjualan.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-dark" placeholder="Cari transaksi / kasir..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-yellow px-3 d-flex align-items-center gap-1">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    {{-- TABEL RIWAYAT PENJUALAN --}}
    <div class="card card-dark-yellow overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-yellow align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>TANGGAL TRANSAKSI</th>
                        <th>KASIR</th>
                        <th>TOTAL PEMBAYARAN</th>
                        <th class="text-center">METODE PEMBAYARAN</th>
                        <th class="text-center">STATUS</th>
                        <th class="text-end pe-4">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualans ?? $penjualan ?? [] as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-semibold">
                            {{ (isset($penjualans) && method_exists($penjualans, 'firstItem')) ? $penjualans->firstItem() + $index : ((isset($penjualan) && method_exists($penjualan, 'firstItem')) ? $penjualan->firstItem() + $index : $index + 1) }}
                        </td>
                        <td class="text-muted small">
                            <i class="bi bi-clock me-1" style="color: var(--accent-yellow);"></i>
                            {{ \Carbon\Carbon::parse($item->created_at ?? $item->tanggal)->format('d-m-Y H:i:s') }}
                        </td>
                        <td class="small">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle fs-6" style="color: var(--accent-yellow);"></i>
                                <span>{{ optional($item->user)->name ?? $item->kasir ?? 'Kasir' }}</span>
                            </div>
                        </td>
                        <td class="fw-bold font-monospace" style="color: var(--accent-yellow);">
                            Rp {{ number_format($item->total_harga ?? $item->total_pembayaran ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if(strtolower($item->metode_pembayaran ?? $item->metode ?? 'cash') == 'qris')
                                <span class="badge badge-qris rounded-pill"><i class="bi bi-qr-code me-1"></i> QRIS</span>
                            @else
                                <span class="badge badge-cash rounded-pill"><i class="bi bi-cash-stack me-1"></i> CASH</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(strtolower($item->status ?? 'completed') == 'refunded')
                                <span class="badge badge-refunded rounded-pill"><i class="bi bi-arrow-counterclockwise me-1"></i> REFUNDED</span>
                            @elseif(strtolower($item->status ?? 'completed') == 'completed' || strtolower($item->status ?? '') == 'selesai')
                                <span class="badge badge-completed rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> COMPLETED</span>
                            @else
                                <span class="badge badge-pending rounded-pill"><i class="bi bi-hourglass-split me-1"></i> PENDING</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if(Route::has('penjualan.show'))
                            <a href="{{ route('penjualan.show', $item->id) }}" class="btn btn-sm btn-action-detail rounded-2 px-2.5 py-1 d-inline-flex align-items-center gap-1">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-receipt fs-1 d-block mb-2 opacity-50"></i>
                            Belum ada riwayat transaksi penjualan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($penjualans) && method_exists($penjualans, 'hasPages') && $penjualans->hasPages())
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
            {{ $penjualans->links() }}
        </div>
        @elseif(isset($penjualan) && method_exists($penjualan, 'hasPages') && $penjualan->hasPages())
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
            {{ $penjualan->links() }}
        </div>
        @endif
    </div>

</div>

@endsection