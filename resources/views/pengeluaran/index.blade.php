@extends('layouts.app')

@section('title', 'Riwayat Pengeluaran')

@section('content')
@include('layouts.navbar')

<style>
    :root {
        --expense-bg: #0c0a09;
        --expense-card: #1c1917;
        --expense-border: rgba(245, 158, 11, 0.18);
        --expense-accent: #f59e0b;
        --expense-muted: #a8a29e;
    }

    body {
        background: var(--expense-bg) !important;
        color: #fafaf9 !important;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
    }

    .expense-shell { max-width: 1360px; }
    .expense-card {
        background: linear-gradient(145deg, #211d1a, var(--expense-card));
        border: 1px solid var(--expense-border);
        border-radius: 1rem;
    }
    .expense-eyebrow {
        color: var(--expense-accent);
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }
    .expense-stat {
        min-height: 118px;
        padding: 1.25rem;
        border-radius: 0.9rem;
        border: 1px solid rgba(239, 68, 68, 0.25);
        background: rgba(239, 68, 68, 0.09);
    }
    .expense-stat.month {
        border-color: rgba(245, 158, 11, 0.25);
        background: rgba(245, 158, 11, 0.09);
    }
    .expense-stat-label { color: var(--expense-muted); font-size: 0.75rem; }
    .expense-stat-value { color: #fef2f2; font-size: 1.55rem; font-weight: 800; }
    .expense-table { color: #fafaf9 !important; margin-bottom: 0; --bs-table-bg: transparent !important; }
    .expense-table th {
        background: rgba(12, 10, 9, 0.6) !important;
        color: var(--expense-muted) !important;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-bottom: 1px solid var(--expense-border) !important;
        padding: 1rem 1.25rem;
    }
    .expense-table td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }
    .expense-table tbody tr:hover td { background: rgba(245, 158, 11, 0.04) !important; }
    .expense-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.65rem;
        background: rgba(239, 68, 68, 0.13);
        color: #fca5a5;
    }
    .btn-expense {
        background: var(--expense-accent) !important;
        color: #1c1917 !important;
        border: 0 !important;
        font-weight: 800;
    }
    .btn-expense:hover { background: #fbbf24 !important; }
    .expense-input {
        background: rgba(12, 10, 9, 0.65) !important;
        border: 1px solid var(--expense-border) !important;
        color: #fff !important;
    }
    .expense-input:focus { border-color: var(--expense-accent) !important; box-shadow: 0 0 0 0.2rem rgba(245, 158, 11, 0.15) !important; }
</style>

<div class="container-fluid expense-shell px-4 py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-4 mb-4 border-bottom border-secondary border-opacity-25">
        <div>
            <div class="expense-eyebrow mb-1">Keuangan Operasional</div>
            <h1 class="fw-bold text-white mb-1">Riwayat Pengeluaran</h1>
            <p class="text-muted small mb-0">Pantau seluruh biaya operasional yang tercatat di sistem.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="expense-stat">
                <div class="expense-stat-label text-uppercase fw-bold">Total Pengeluaran Hari Ini</div>
                <div class="expense-stat-value mt-2">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</div>
                <small class="text-muted">{{ now()->translatedFormat('d F Y') }}</small>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="expense-stat month">
                <div class="expense-stat-label text-uppercase fw-bold">Total Bulan Ini</div>
                <div class="expense-stat-value mt-2">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</div>
                <small class="text-muted">Akumulasi bulan berjalan</small>
            </div>
        </div>
    </div>

    <div class="expense-card p-4 mb-4">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="expense-icon"><i class="bi bi-plus-lg"></i></span>
            <div>
                <h5 class="fw-bold text-white mb-0">Catat Pengeluaran Baru</h5>
                <small class="text-muted">Data akan masuk ke total pengeluaran hari ini.</small>
            </div>
        </div>
        <form action="{{ route('pengeluaran.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-12 col-lg-6">
                <label for="keterangan" class="form-label small text-muted">Keterangan</label>
                <input id="keterangan" type="text" name="keterangan" class="form-control expense-input" placeholder="Contoh: Belanja bahan baku" required>
            </div>
            <div class="col-12 col-lg-4">
                <label for="nominal" class="form-label small text-muted">Nominal (Rp)</label>
                <input id="nominal" type="number" name="nominal" min="1" class="form-control expense-input" placeholder="150000" required>
            </div>
            <div class="col-12 col-lg-2">
                <button type="submit" class="btn btn-expense w-100"><i class="bi bi-save me-1"></i>Simpan</button>
            </div>
        </form>
    </div>

    <div class="expense-card overflow-hidden">
        <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-white mb-1">Catatan Pengeluaran</h5>
                <small class="text-muted">{{ $pengeluaran->total() }} catatan tersimpan</small>
            </div>
            <i class="bi bi-receipt text-warning fs-4"></i>
        </div>
        <div class="table-responsive">
            <table class="table expense-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px;">#</th>
                        <th>TANGGAL</th>
                        <th>KETERANGAN</th>
                        <th>DICATAT OLEH</th>
                        <th class="text-end pe-4">NOMINAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengeluaran as $index => $item)
                        <tr>
                            <td class="text-muted">{{ $pengeluaran->firstItem() + $index }}</td>
                            <td class="text-muted small"><i class="bi bi-calendar3 me-1 text-warning"></i>{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="fw-semibold">{{ $item->keterangan }}</td>
                            <td class="text-muted">{{ optional($item->user)->name ?? 'Admin' }}</td>
                            <td class="text-end pe-4 fw-bold text-danger">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Belum ada pengeluaran tercatat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengeluaran->hasPages())
            <div class="p-3 d-flex justify-content-center">{{ $pengeluaran->links() }}</div>
        @endif
    </div>
</div>
@endsection
