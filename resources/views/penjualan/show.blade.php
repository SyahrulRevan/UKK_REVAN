@extends('layouts.app')

@section('title', 'Detail Transaksi Penjualan')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-dark-yellow: #0c0a09;
        --card-bg-dark: #1c1917;
        --border-yellow-subtle: rgba(245, 158, 11, 0.3);
        --accent-yellow: #f59e0b;
        --accent-yellow-hover: #d97706;
        --text-white: #ffffff;
        --text-subtle: #e2e8f0;
    }

    body {
        background-color: var(--bg-dark-yellow) !important;
        color: var(--text-white) !important;
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;
    }

    .card-dark-yellow {
        background: var(--card-bg-dark) !important;
        border: 1px solid var(--border-yellow-subtle);
        border-radius: 1.25rem;
    }

    .table-dark-yellow {
        color: var(--text-white) !important;
        margin-bottom: 0;
        --bs-table-bg: transparent !important;
    }

    .table-dark-yellow th {
        background-color: rgba(0, 0, 0, 0.5) !important;
        color: #f8fafc !important;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-yellow-subtle) !important;
        padding: 1rem 1.25rem;
    }

    .table-dark-yellow td {
        color: #ffffff !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    .badge-cash {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
        border: 1px solid rgba(16, 185, 129, 0.4);
        font-weight: 600;
        padding: 0.4em 0.8em;
    }

    .badge-qris {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
        border: 1px solid rgba(59, 130, 246, 0.4);
        font-weight: 600;
        padding: 0.4em 0.8em;
    }

    .badge-completed {
        background: rgba(16, 185, 129, 0.2);
        color: #6ee7b7;
        border: 1px solid rgba(16, 185, 129, 0.4);
        font-weight: 600;
        padding: 0.4em 0.8em;
    }

    .badge-refunded {
        background: rgba(239, 68, 68, 0.2);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.4);
        font-weight: 600;
        padding: 0.4em 0.8em;
    }

    .badge-discount {
        background: rgba(239, 68, 68, 0.16);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.35);
        font-size: 0.7rem;
        font-weight: 700;
    }

    .btn-refund {
        background: rgba(239, 68, 68, 0.12);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.35);
        font-weight: 700;
    }

    .btn-refund:hover {
        background: rgba(239, 68, 68, 0.22);
        color: #fecaca;
    }

    .btn-yellow {
        background: var(--accent-yellow) !important;
        color: #000000 !important;
        font-weight: 700;
        border: none !important;
        padding: 0.6rem 1.25rem;
        border-radius: 0.75rem;
    }

    .btn-yellow:hover {
        background: var(--accent-yellow-hover) !important;
        color: #000000 !important;
    }

    .btn-back-custom {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #ffffff;
        border-radius: 0.75rem;
        padding: 0.6rem 1.25rem;
    }

    .btn-back-custom:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    @media print {
        body { background-color: #ffffff !important; color: #000000 !important; }
        .no-print { display: none !important; }
        .card-dark-yellow { background: #ffffff !important; border: none !important; color: #000000 !important; }
        .table-dark-yellow th, .table-dark-yellow td { color: #000000 !important; }
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-4 border-bottom border-secondary border-opacity-25 no-print">
        <div>
            <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">
                Detail Transaksi #{{ $penjualan->id }}
            </h1>
            <p class="text-light small mb-0" style="opacity: 0.8;">Rincian produk dan informasi pembayaran kasir.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('penjualan.index') }}" class="btn btn-back-custom d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
                @can('refund', $penjualan)
                    <form action="{{ route('penjualan.refund', $penjualan) }}" method="POST" onsubmit="return confirm('Proses pengembalian uang untuk transaksi ini? Stok akan dikembalikan dan transaksi ditandai REFUNDED.');">
                        @csrf
                        <button type="submit" class="btn btn-refund d-inline-flex align-items-center gap-2">
                            <i class="bi bi-arrow-counterclockwise"></i> Refund
                        </button>
                    </form>
                @endcan
            <button onclick="window.print()" class="btn btn-yellow d-inline-flex align-items-center gap-2">
                <i class="bi bi-printer-fill"></i> Cetak Struk
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-4 mx-auto" style="max-width: 960px;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-4 mx-auto" style="max-width: 960px;">{{ session('error') }}</div>
    @endif

    {{-- KARTU RINCIAN --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card card-dark-yellow p-4 p-md-5">
                
                {{-- METADATA TRANSAKSI --}}
                <div class="row g-3 mb-4 pb-4 border-bottom border-secondary border-opacity-25">
                    <div class="col-sm-6 col-md-3">
                        <span class="d-block mb-1 small text-light" style="opacity: 0.75;">Tanggal Transaksi</span>
                        <strong class="text-white d-flex align-items-center gap-1">
                            <i class="bi bi-calendar-event" style="color: var(--accent-yellow);"></i>
                            {{ \Carbon\Carbon::parse($penjualan->created_at)->format('d-m-Y H:i:s') }}
                        </strong>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="d-block mb-1 small text-light" style="opacity: 0.75;">Kasir</span>
                        <strong class="text-white d-flex align-items-center gap-1">
                            <i class="bi bi-person-circle" style="color: var(--accent-yellow);"></i>
                            {{ optional($penjualan->user)->name ?? 'Kasir' }}
                        </strong>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="d-block mb-1 small text-light" style="opacity: 0.75;">Metode Pembayaran</span>
                        @if(strtolower($penjualan->metode_pembayaran) == 'qris')
                            <span class="badge badge-qris rounded-pill"><i class="bi bi-qr-code me-1"></i> QRIS</span>
                        @else
                            <span class="badge badge-cash rounded-pill"><i class="bi bi-cash-stack me-1"></i> CASH</span>
                        @endif
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="d-block mb-1 small text-light" style="opacity: 0.75;">Status</span>
                        @if($penjualan->status === 'REFUNDED')
                            <span class="badge badge-refunded rounded-pill"><i class="bi bi-arrow-counterclockwise me-1"></i> REFUNDED</span>
                        @else
                            <span class="badge badge-completed rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> {{ strtoupper($penjualan->status ?? 'COMPLETED') }}</span>
                        @endif
                    </div>
                </div>

                {{-- TABEL ITEM DIBELI --}}
                <h5 class="fw-bold text-white mb-3">Item Pembelian</h5>
                <div class="table-responsive mb-4 rounded-3 border border-secondary border-opacity-25 overflow-hidden">
                    <table class="table table-dark-yellow align-middle">
                        <thead>
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th>NAMA PRODUK</th>
                                <th class="text-end">HARGA SATUAN</th>
                                <th class="text-center">QTY</th>
                                <th class="text-end pe-4">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penjualan->itemPenjualan as $index => $item)
                            @php
                                $namaProduk  = optional($item->produk)->nama 
                                            ?? optional($item->produk)->nama_produk 
                                            ?? $item->nama_produk 
                                            ?? 'Produk #' . $item->produk_id;

                                $hargaSatuan = $item->harga_satuan
                                            ?? $item->harga
                                            ?? optional($item->produk)->harga_jual
                                            ?? 0;

                                $qty         = $item->kuantitas
                                            ?? $item->jumlah
                                            ?? $item->qty
                                            ?? 1;

                                $diskonPersen = (int) ($item->diskon_persen ?? 0);
                                $hargaPromo = $hargaSatuan - intdiv($hargaSatuan * $diskonPersen, 100);

                                $subtotal    = $item->subtotal 
                                            ?? ($hargaPromo * $qty);
                            @endphp
                            <tr>
                                <td class="text-light small">{{ $index + 1 }}</td>
                                <td class="fw-semibold text-white">
                                    {{ $namaProduk }}
                                </td>
                                <td class="text-end font-monospace text-light">
                                    @if($diskonPersen > 0)
                                        <span class="text-decoration-line-through text-muted small d-block">Rp {{ number_format($hargaSatuan, 0, ',', '.') }}</span>
                                        <strong>Rp {{ number_format($hargaPromo, 0, ',', '.') }}</strong>
                                        <span class="badge badge-discount rounded-pill">-{{ $diskonPersen }}%</span>
                                    @else
                                        Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="text-center font-monospace fw-bold text-white">
                                    {{ $qty }}
                                </td>
                                <td class="text-end pe-4 font-monospace fw-bold" style="color: #fbbf24;">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-light opacity-75">
                                    Rincian barang tidak ditemukan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- TOTAL HARGA --}}
                <div class="row align-items-center pt-2">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.4); border: 1px solid var(--border-yellow-subtle);">
                            <span class="text-light small d-block mb-1"><i class="bi bi-info-circle me-1" style="color: var(--accent-yellow);"></i> Catatan:</span>
                            <span class="small text-light opacity-75">Transaksi ini telah berhasil diselesaikan dan stok produk sudah berkurang otomatis.</span>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-light small d-block mb-1" style="opacity: 0.85;">Total Pembayaran</span>
                        <div class="fs-1 fw-bold font-monospace" style="color: #fbbf24;">
                            Rp {{ number_format($penjualan->total_pembayaran ?? 0, 0, ',', '.') }}
                        </div>
                        @if(strtoupper($penjualan->metode_pembayaran) === 'CASH')
                            <div class="small text-light mt-2">
                                Uang dibayar: <strong>Rp {{ number_format($penjualan->uang_dibayar ?? 0, 0, ',', '.') }}</strong>
                            </div>
                            <div class="fw-bold mt-1" style="color: #6ee7b7;">
                                Kembalian: Rp {{ number_format($penjualan->kembalian ?? 0, 0, ',', '.') }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- FOOTER TOMBOL --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top border-secondary border-opacity-25 no-print">
                    <a href="{{ route('penjualan.index') }}" class="btn btn-back-custom">Kembali ke Riwayat</a>
                    <button onclick="window.print()" class="btn btn-yellow d-inline-flex align-items-center gap-2">
                        <i class="bi bi-printer-fill"></i> Cetak Struk
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

@if(session('auto_print'))
<script>
    window.addEventListener('load', () => {
        window.print();
    });
</script>
@endif

@endsection