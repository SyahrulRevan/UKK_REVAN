@extends('layouts.app')

@section('title', 'Detail Transaksi Penjualan')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-main: #090d16;
        --card-bg: #1e293b;
        --card-border: rgba(255, 255, 255, 0.08);
        --accent-emerald: #10b981;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
    }

    .card-pro {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        overflow: hidden;
    }

    .card-header-pro {
        background: #0f172a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1.25rem 1.5rem;
    }

    .table-pro {
        color: #f1f5f9 !important;
        margin-bottom: 0;
        --bs-table-bg: transparent !important;
    }

    .table-pro th {
        background-color: #0f172a !important;
        color: #94a3b8 !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 0.85rem 1rem;
    }

    .table-pro td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 0.85rem 1rem;
        vertical-align: middle;
        background-color: transparent !important;
        color: #f1f5f9 !important;
    }

    .btn-back-pro {
        background: rgba(148, 163, 184, 0.15);
        color: #cbd5e1;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-weight: 600;
        border-radius: 0.75rem;
        padding: 0.65rem 1.25rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-back-pro:hover {
        background: rgba(148, 163, 184, 0.25);
        color: #ffffff;
    }

    .receipt-box {
        background: #0f172a;
        border: 1px dashed rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        padding: 1.5rem;
    }
</style>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-black text-white mb-1" style="font-size: 1.75rem;">
                Detail Transaksi #{{ $penjualan->id }}
            </h1>
            <p class="text-slate-400 mb-0 small" style="color: #94a3b8;">
                Rincian transaksi dan daftar barang yang dibeli.
            </p>
        </div>
        <a href="{{ route('penjualan.index') }}" class="btn btn-back-pro">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        {{-- TABEL ITEM BARANG --}}
        <div class="col-12 col-lg-8">
            <div class="card card-pro">
                <div class="card-header-pro d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-white mb-0">
                        <i class="bi bi-cart-check text-indigo-400 me-2" style="color: #818cf8;"></i> Item Dibeli
                    </h6>
                    <span class="badge bg-slate-800 text-slate-300 border border-slate-700 px-3 py-1">
                        {{ count($penjualan->itemPenjualan ?? []) }} Jenis Produk
                    </span>
                </div>
                <div class="table-responsive">
                    <table class="table table-pro">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualan->itemPenjualan ?? [] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-semibold text-white">
                                    {{ $item->produk->nama ?? $item->nama_produk ?? 'Produk Disembunyikan' }}
                                </td>
                                <td class="text-center font-monospace">
                                    Rp {{ number_format($item->harga_satuan ?? $item->harga ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-center fw-bold">
                                    {{ $item->jumlah ?? $item->qty ?? 1 }} Pcs
                                </td>
                                <td class="text-end font-monospace fw-bold" style="color: #34d399;">
                                    Rp {{ number_format(($item->harga_satuan ?? $item->harga ?? 0) * ($item->jumlah ?? $item->qty ?? 1), 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-slate-400">
                                    Detail item transaksi tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RINGKASAN & NOTA PEMBAYARAN --}}
        <div class="col-12 col-lg-4">
            <div class="card card-pro p-4">
                <h6 class="fw-bold text-white mb-3">Ringkasan Transaksi</h6>
                
                <div class="receipt-box mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-400 small" style="color: #94a3b8;">Kasir:</span>
                        <span class="fw-semibold text-white">{{ $penjualan->user->name ?? 'kude' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-400 small" style="color: #94a3b8;">Tanggal:</span>
                        <span class="fw-semibold text-slate-200 small">
                            {{ \Carbon\Carbon::parse($penjualan->created_at)->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-400 small" style="color: #94a3b8;">Metode:</span>
                        <span class="badge px-2.5 py-1 rounded-pill" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa;">
                            {{ $penjualan->metode_pembayaran ?? 'QRIS' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-slate-400 small" style="color: #94a3b8;">Status:</span>
                        <span class="badge px-2.5 py-1 rounded-pill" style="background: rgba(16, 185, 129, 0.2); color: #34d399;">
                            {{ $penjualan->status ?? 'COMPLETED' }}
                        </span>
                    </div>

                    <hr class="border-secondary border-opacity-25 my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-white">Total Bayar:</span>
                        <span class="fs-4 font-monospace fw-black" style="color: #34d399;">
                            Rp {{ number_format($penjualan->total_pembayaran ?? $penjualan->total_harga ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <button onclick="window.print()" class="btn w-100 py-2.5 fw-bold text-white rounded-3 d-flex align-items-center justify-content-center gap-2" style="background: #6366f1;">
                    <i class="bi bi-printer-fill"></i> Cetak Struk
                </button>
            </div>
        </div>
    </div>

</div>

@endsection