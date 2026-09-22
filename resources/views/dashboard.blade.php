@extends('layouts.app')

@section('title', 'Dashboard - Analytics')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-main: #0d0c07; /* Dark background dengan sentuhan hangat */
        --card-bg: #1c1912; /* Card background gelap bernuansa amber */
        --card-border: rgba(245, 158, 11, 0.18);
        --card-hover-border: rgba(245, 158, 11, 0.6);
        --accent-yellow: #eab308;
        --accent-amber: #f59e0b;
        --accent-emerald: #10b981;
        --accent-rose: #f43f5e;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #fef08a !important;
        font-family: 'Plus Jakarta Sans', 'Instrument Sans', system-ui, -apple-system, sans-serif;
    }

    /* Keyframe Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .anim-item {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* Modern Glassmorphism Cards */
    .row > [class*='col-'] {
        display: flex;
    }

    .card-pro {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 100%;
    }

    .card-pro:hover {
        transform: translateY(-5px);
        border-color: var(--card-hover-border);
        box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.6), 0 0 20px 0 rgba(245, 158, 11, 0.2);
    }

    /* Label Header Card Penjualan */
    .card-title-label {
        color: #fef08a !important;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 0.08em;
    }

    /* Gradient Background Cards (Dark Yellow Theme) */
    .card-grad-amber { background: linear-gradient(135deg, #1c1912 0%, #451a03 100%) !important; }
    .card-grad-yellow { background: linear-gradient(135deg, #1c1912 0%, #713f12 100%) !important; }
    .card-grad-emerald { background: linear-gradient(135deg, #1c1912 0%, #064e3b 100%) !important; }
    .card-grad-gold { background: linear-gradient(135deg, #1c1912 0%, #3f2c00 100%) !important; }

    /* Icon Box Premium Glow */
    .icon-box-pro {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        transition: transform 0.3s ease;
    }

    .card-pro:hover .icon-box-pro {
        transform: scale(1.1) rotate(4deg);
    }

    /* Pulse Live Status */
    .pulse-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--accent-amber);
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
        animation: pulse-ring 2s infinite;
    }

    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }

    /* Custom Modern Table */
    .table-pro {
        color: #fef9c3 !important;
        margin-bottom: 0;
        --bs-table-bg: transparent !important;
        --bs-table-color: #fef9c3 !important;
    }

    .table-pro th {
        background-color: #292524 !important;
        color: #d97706 !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-bottom: 1px solid rgba(245, 158, 11, 0.15) !important;
        padding: 1rem 1.25rem;
    }

    .table-pro td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 1rem 1.25rem;
        vertical-align: middle;
        color: #fef9c3 !important;
        background-color: transparent !important;
    }

    .table-pro tbody tr:hover td {
        background-color: rgba(245, 158, 11, 0.05) !important;
    }

    /* Trophy Rank Badges */
    .rank-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.85rem;
    }
    .rank-1 { background: rgba(245, 158, 11, 0.3); color: #fef08a; border: 1px solid rgba(245, 158, 11, 0.6); }
    .rank-2 { background: rgba(234, 179, 8, 0.2); color: #fde047; border: 1px solid rgba(234, 179, 8, 0.4); }
    .rank-3 { background: rgba(180, 83, 9, 0.2); color: #f59e0b; border: 1px solid rgba(180, 83, 9, 0.4); }
</style>

<div class="container py-5">

    {{-- HEADER DASHBOARD --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-5 border-bottom border-warning border-opacity-10 anim-item delay-1">
        <div>
            <div class="d-flex align-items-center gap-2 fw-semibold small mb-1" style="color: #fde047; letter-spacing: 0.05em;">
                <i class="bi bi-calendar2-week-fill"></i>
                <span>{{ $tanggalHariIni->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="fw-black text-white mb-0" style="font-size: 2.25rem; letter-spacing: -0.02em;">
                Ringkasan Bisnis
            </h1>
        </div>
        <div class="mt-3 mt-md-0">
            <div class="badge rounded-pill px-3 py-2 d-inline-flex align-items-center gap-2" style="background: rgba(43, 30, 0, 0.8); border: 1px solid rgba(245, 158, 11, 0.3);">
                <span class="pulse-dot"></span>
                <span class="fw-semibold fs-7" style="color: #fef08a;">Sistem Realtime Active</span>
            </div>
        </div>
    </div>

    {{-- DIGITAL BUSINESS SUMMARY --}}
    <div class="mb-5">
        <div class="d-flex align-items-center justify-content-between mb-3 anim-item delay-1">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-wallet2" style="color: var(--accent-yellow);"></i>
                Ringkasan Keuangan & Stok
            </h5>
        </div>

        <div class="row g-3">
            {{-- Pemasukan Uang --}}
            <div class="col-12 col-sm-6 col-xl-4 anim-item delay-1">
                <div class="card card-pro card-grad-emerald p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #86efac; letter-spacing: 0.05em;">Total Pemasukan</span>
                            <h3 class="fw-bold text-white mt-2 mb-0" style="font-size: 1.5rem;">
                                Rp {{ number_format($keuangan['total_pemasukan']) }}
                            </h3>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(16, 185, 129, 0.15); color: #86efac; border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pendapatan Hari Ini --}}
            <div class="col-12 col-sm-6 col-xl-4 anim-item delay-2">
                <div class="card card-pro card-grad-amber p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #fde047; letter-spacing: 0.05em;">Pendapatan Hari Ini</span>
                            <h3 class="fw-bold text-white mt-2 mb-0" style="font-size: 1.5rem;">
                                Rp {{ number_format($pemasukanHariIni ?? 0) }}
                            </h3>
                            <small class="text-muted">{{ $tanggalPendapatanHariIni->translatedFormat('d M Y') }}</small>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(245, 158, 11, 0.15); color: #fde047; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pendapatan Hari Berikutnya --}}
            <div class="col-12 col-sm-6 col-xl-4 anim-item delay-3">
                <div class="card card-pro card-grad-blue p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #93c5fd; letter-spacing: 0.05em;">Pendapatan Besok</span>
                            <h3 class="fw-bold text-white mt-2 mb-0" style="font-size: 1.5rem;">
                                Rp {{ number_format($pemasukanBesok ?? 0) }}
                            </h3>
                            <small class="text-muted">{{ $tanggalPendapatanBesok->translatedFormat('d M Y') }}</small>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(59, 130, 246, 0.15); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.3);">
                            <i class="bi bi-calendar-plus"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengeluaran Hari Ini --}}
            <div class="col-12 col-sm-6 col-xl-4 anim-item delay-3">
                <div class="card card-pro card-grad-red p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #fca5a5; letter-spacing: 0.05em;">Pengeluaran Hari Ini</span>
                            <h3 class="fw-bold text-white mt-2 mb-0" style="font-size: 1.5rem;">
                                Rp {{ number_format($pengeluaranHariIni ?? 0) }}
                            </h3>
                            <small class="text-muted">Catatan pengeluaran hari ini</small>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3);">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jumlah Stok --}}
            <div class="col-12 col-sm-6 col-xl-4 anim-item delay-2">
                <div class="card card-pro card-grad-yellow p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #fef08a; letter-spacing: 0.05em;">Jumlah Stok</span>
                            <h3 class="fw-bold text-white mt-2 mb-0" style="font-size: 1.5rem;">
                                {{ number_format($keuangan['total_stok']) }} <span class="fs-6 fw-normal" style="color: #fef08a;">pcs</span>
                            </h3>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(245, 158, 11, 0.15); color: #fef08a; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="bi bi-box-seam"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CATAT PENGELUARAN --}}
    <div class="card card-pro p-4 mb-5 anim-item delay-4">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
            <div>
                <h5 class="fw-bold text-white mb-1"><i class="bi bi-wallet2 me-2" style="color: #fca5a5;"></i>Catat Pengeluaran</h5>
                <p class="text-muted small mb-0">Tambahkan biaya operasional agar total pengeluaran hari ini akurat.</p>
            </div>
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-light btn-sm text-nowrap">
                <i class="bi bi-clock-history me-1"></i>Riwayat
            </a>
        </div>
        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('pengeluaran.store') }}" method="POST" class="row g-3 align-items-end">
            @csrf
            <div class="col-12 col-md-6">
                <label for="keteranganPengeluaran" class="form-label text-muted small">Keterangan</label>
                <input id="keteranganPengeluaran" type="text" name="keterangan" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Belanja bahan baku" required>
            </div>
            <div class="col-12 col-md-4">
                <label for="nominalPengeluaran" class="form-label text-muted small">Nominal (Rp)</label>
                <input id="nominalPengeluaran" type="number" name="nominal" min="1" class="form-control bg-dark text-white border-secondary" placeholder="50000" required>
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-danger w-100"><i class="bi bi-plus-circle me-1"></i>Simpan</button>
            </div>
        </form>
    </div>

    <div class="mb-5">
        <div class="d-flex align-items-center justify-content-between mb-3 anim-item delay-1">
            <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-graph-up-arrow" style="color: var(--accent-yellow);"></i>
                Performa Penjualan & Pembayaran
            </h5>
        </div>

        <div class="row g-3">
            {{-- Total Penjualan --}}
            <div class="col-12 col-sm-6 col-xl-3 anim-item delay-1">
                <div class="card card-pro card-grad-amber p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #fde047; letter-spacing: 0.05em;">Total Penjualan</span>
                            <h3 class="fw-bold text-white mt-2 mb-0" style="font-size: 1.5rem;">
                                Rp {{ number_format($ringkasan['total_penjualan']) }}
                            </h3>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(245, 158, 11, 0.15); color: #fde047; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jumlah Transaksi --}}
            <div class="col-12 col-sm-6 col-xl-3 anim-item delay-2">
                <div class="card card-pro card-grad-yellow p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #fef08a; letter-spacing: 0.05em;">Jumlah Transaksi</span>
                            <h3 class="fw-bold text-white mt-2 mb-0" style="font-size: 1.5rem;">
                                {{ number_format($ringkasan['total_transaksi']) }} <span class="fs-6 fw-normal" style="color: #fef08a;">trx</span>
                            </h3>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(234, 179, 8, 0.15); color: #fef08a; border: 1px solid rgba(234, 179, 8, 0.3);">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pembayaran Tunai --}}
            <div class="col-12 col-sm-6 col-xl-3 anim-item delay-3">
                <div class="card card-pro card-grad-emerald p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7 text-slate-400" style="letter-spacing: 0.05em;">Pembayaran Tunai</span>
                            <h3 class="fw-bold mt-2 mb-0" style="color: #34d399; font-size: 1.5rem;">
                                Rp {{ number_format($ringkasan['total_cash']) }}
                            </h3>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3);">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Non-Tunai / QRIS --}}
            <div class="col-12 col-sm-6 col-xl-3 anim-item delay-4">
                <div class="card card-pro card-grad-gold p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-uppercase fw-bold fs-7" style="color: #fca5a5; letter-spacing: 0.05em;">Non-Tunai / QRIS</span>
                            <h3 class="fw-bold mt-2 mb-0" style="color: #fde047; font-size: 1.5rem;">
                                Rp {{ number_format($ringkasan['total_non_tunai']) }}
                            </h3>
                        </div>
                        <div class="icon-box-pro" style="background: rgba(245, 158, 11, 0.15); color: #fef08a; border: 1px solid rgba(245, 158, 11, 0.3);">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CRITICAL INVENTORY STATUS --}}
    <div class="mb-5 anim-item delay-2">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-shield-exclamation" style="color: var(--accent-amber);"></i>
            Status Inventaris Kritis
        </h5>

        <div class="row g-4">
            {{-- Stok Rendah --}}
            <div class="col-12 col-lg-6">
                <div class="card card-pro h-100">
                    <div class="p-3 px-4 d-flex justify-content-between align-items-center" style="background: rgba(43, 30, 0, 0.4); border-bottom: 1px solid rgba(245, 158, 11, 0.1);">
                        <span class="fw-bold d-flex align-items-center gap-2" style="color: #fbbf24;">
                            <i class="bi bi-exclamation-triangle-fill"></i> Stok Menipis
                        </span>
                        <span class="badge rounded-pill fw-semibold px-3 py-1" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);">Perlu Restock</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-pro align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th>Nama Produk</th>
                                    <th class="text-center" style="width: 100px;">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokRendah as $index => $produk)
                                <tr>
                                    <td class="text-center fw-medium" style="color: #a1a1aa;">
                                        {{ $produkStokRendah->firstItem() + $index }}
                                    </td>
                                    <td class="fw-semibold text-white">{{ $produk->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge px-3 py-1.5 rounded-pill fw-bold" style="background: rgba(245, 158, 11, 0.15); color: #fbbf24;">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5" style="color: #a1a1aa;">
                                        <i class="bi bi-check2-circle fs-1 d-block mb-2" style="color: var(--accent-emerald);"></i>
                                        Seluruh stok produk dalam batas aman.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($produkStokRendah->hasPages())
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
                        {{ $produkStokRendah->links() }}
                    </div>
                    @endif
                </div>
            </div>

            {{-- Stok Habis --}}
            <div class="col-12 col-lg-6">
                <div class="card card-pro h-100">
                    <div class="p-3 px-4 d-flex justify-content-between align-items-center" style="background: rgba(43, 30, 0, 0.4); border-bottom: 1px solid rgba(245, 158, 11, 0.1);">
                        <span class="fw-bold d-flex align-items-center gap-2" style="color: #f87171;">
                            <i class="bi bi-x-circle-fill"></i> Stok Habis
                        </span>
                        <span class="badge rounded-pill fw-semibold px-3 py-1" style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3);">Kosong</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-pro align-middle">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th>Nama Produk</th>
                                    <th class="text-center" style="width: 100px;">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokHabis as $index => $produk)
                                <tr>
                                    <td class="text-center fw-medium" style="color: #a1a1aa;">
                                        {{ $produkStokHabis->firstItem() + $index }}
                                    </td>
                                    <td class="fw-semibold text-white">{{ $produk->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge px-3 py-1.5 rounded-pill fw-bold" style="background: rgba(239, 68, 68, 0.15); color: #f87171;">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5" style="color: #a1a1aa;">
                                        <i class="bi bi-box-seam fs-1 d-block mb-2" style="color: #71717a;"></i>
                                        Tidak ada produk yang kehabisan stok.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($produkStokHabis->hasPages())
                    <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
                        {{ $produkStokHabis->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- RECENT SALES TRANSACTIONS --}}
    <div class="mb-5 anim-item delay-3">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-receipt-cutoff" style="color: #fbbf24;"></i>
            Transaksi Penjualan
        </h5>

        <div class="card card-pro overflow-hidden">
            <div class="table-responsive">
                <table class="table table-pro align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 80px;">#</th>
                            <th>Invoice</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Metode</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksiTerbaru as $index => $trx)
                        <tr>
                            <td class="ps-4 fw-semibold" style="color: #a1a1aa;">{{ $index + 1 }}</td>
                            <td class="fw-semibold text-white">#{{ $trx->id }}</td>
                            <td style="color: #fef3c7;">{{ \Carbon\Carbon::parse($trx->created_at)->translatedFormat('d M Y') }}</td>
                            <td>{{ $trx->kasir }}</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2" style="background: rgba(245, 158, 11, 0.14); color: #fef08a; border: 1px solid rgba(245, 158, 11, 0.25);">
                                    {{ strtoupper($trx->metode_pembayaran) }}
                                </span>
                            </td>
                            <td class="text-end fw-bold" style="color: #fde047;">
                                Rp {{ number_format($trx->total_pembayaran) }}
                            </td>
                            <td class="text-center">
                                @if(strtoupper($trx->status) === 'COMPLETED')
                                    <span class="badge rounded-pill px-3 py-2" style="background: rgba(16, 185, 129, 0.12); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.3);">
                                        {{ $trx->status }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-2" style="background: rgba(245, 158, 11, 0.12); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3);">
                                        {{ $trx->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5" style="color: #a1a1aa;">
                                <i class="bi bi-receipt fs-1 d-block mb-2" style="color: #71717a;"></i>
                                Belum ada transaksi penjualan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BEST SELLER PRODUCTS --}}
    <div class="mb-4 anim-item delay-4">
        <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-trophy-fill" style="color: #fbbf24;"></i>
            Produk Terlaris
        </h5>

        <div class="card card-pro overflow-hidden">
            <div class="table-responsive">
                <table class="table table-pro align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 80px;">Peringkat</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Sisa Stok</th>
                            <th class="text-end pe-4">Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkTerlaris as $index => $produk)
                        <tr>
                            <td class="ps-4">
                                @if($index == 0)
                                    <span class="rank-badge rank-1">1</span>
                                @elseif($index == 1)
                                    <span class="rank-badge rank-2">2</span>
                                @elseif($index == 2)
                                    <span class="rank-badge rank-3">3</span>
                                @else
                                    <span class="fw-bold ps-2" style="color: #a1a1aa;">{{ $index + 1 }}</span>
                                @endif
                            </td>
                            <td class="fw-semibold text-white">
                                {{ $produk->nama }}
                            </td>
                            <td class="text-center font-monospace" style="color: #fef08a;">{{ $produk->stok }}</td>
                            <td class="text-end pe-4">
                                <span class="badge fw-bold px-3 py-2 rounded-pill" style="background: rgba(0, 0, 0, 0.3); color: #fde047; border: 1px solid rgba(245, 158, 11, 0.3);">
                                    {{ number_format($produk->total_terjual) }} unit
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5" style="color: #a1a1aa;">
                                <i class="bi bi-bar-chart-line fs-1 d-block mb-2" style="color: #71717a;"></i>
                                Belum ada data penjualan tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection