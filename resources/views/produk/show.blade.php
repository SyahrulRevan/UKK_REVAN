@extends('layouts.app')

@section('title', 'Detail Produk')

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
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    }

    .card-dark-yellow {
        background: var(--card-bg-dark) !important;
        border: 1px solid var(--border-yellow-subtle);
        border-radius: 1.25rem;
    }

    /* Container Foto Produk */
    .product-img-box {
        width: 100%;
        height: 280px;
        background: rgba(12, 10, 9, 0.6);
        border: 1px solid var(--border-yellow-subtle);
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .product-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-stok {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
        font-weight: 600;
        padding: 0.4em 0.9em;
        font-size: 0.85rem;
    }

    .btn-back-custom {
        background: rgba(12, 10, 9, 0.6);
        border: 1px solid var(--border-yellow-subtle);
        color: var(--text-subtle);
        border-radius: 0.75rem;
        padding: 0.6rem 1.25rem;
        transition: all 0.2s ease;
    }

    .btn-back-custom:hover {
        background: rgba(245, 158, 11, 0.1);
        color: var(--accent-yellow);
        border-color: var(--accent-yellow);
    }

    .btn-edit-custom {
        background: var(--accent-yellow);
        color: #000;
        font-weight: 700;
        border: none;
        border-radius: 0.75rem;
        padding: 0.6rem 1.25rem;
        transition: all 0.2s ease;
    }

    .btn-edit-custom:hover {
        background: var(--accent-yellow-hover);
        color: #000;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-4 border-bottom border-secondary border-opacity-25">
        <div>
            <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">Detail Produk</h1>
            <p class="text-muted small mb-0">Informasi rinci mengenai harga, stok, dan gambar barang.</p>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-back-custom d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- CARD DETAIL --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <div class="card card-dark-yellow p-4 p-md-5">
                <div class="row g-4 align-items-center">
                    
                    {{-- FOTO PRODUK --}}
                    <div class="col-md-5">
                        <div class="product-img-box">
                            @if(!empty($produk->foto))
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama ?? $produk->nama_produk }}">
                            @else
                                <div class="text-center text-muted">
                                    <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-50"></i>
                                    <span class="small">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- INFORMASI PRODUK --}}
                    <div class="col-md-7 ps-md-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge badge-stok rounded-pill">
                                Stok: {{ $produk->stok }} Pcs
                            </span>
                        </div>

                        <h2 class="fw-bold text-white mb-4" style="font-size: 2rem;">
                            {{ $produk->nama ?? $produk->nama_produk }}
                        </h2>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background: rgba(12, 10, 9, 0.5); border: 1px solid var(--border-yellow-subtle);">
                                    <span class="text-muted small d-block mb-1">Harga Beli</span>
                                    <span class="fs-5 fw-semibold text-white font-monospace">
                                        Rp {{ number_format($produk->harga_beli ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 rounded-3" style="background: rgba(245, 158, 11, 0.05); border: 1px solid var(--border-yellow-subtle);">
                                    <span class="text-muted small d-block mb-1">Harga Jual</span>
                                    <span class="fs-5 fw-bold font-monospace" style="color: var(--accent-yellow);">
                                        Rp {{ number_format($produk->harga_jual ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="border-top border-secondary border-opacity-25 pt-3 text-muted small">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle" style="color: var(--accent-yellow);"></i>
                                <span>Diinput oleh: <strong>{{ optional($produk->user)->name ?? 'Administrator' }}</strong></span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FOOTER TOMBOL AKSI --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top border-secondary border-opacity-25">
                    <a href="{{ route('produk.index') }}" class="btn btn-back-custom">Kembali</a>
                    @if(Route::has('produk.edit'))
                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-edit-custom d-inline-flex align-items-center gap-2">
                            <i class="bi bi-pencil-square"></i> Edit Produk
                        </a>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

@endsection