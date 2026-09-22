@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-dark-yellow: #0c0a09;
        --card-bg-dark: #1c1917;
        --border-yellow-subtle: rgba(245, 158, 11, 0.15);
        --border-yellow-glow: rgba(245, 158, 11, 0.35);
        --accent-yellow: #f59e0b;
        --accent-yellow-hover: #d97706;
        --accent-yellow-light: #fef08a;
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

    .product-thumb {
        width: 64px;
        height: 64px;
        object-fit: contain;
        background: #f5f5f4;
        padding: 3px;
    }

    .stock-alert {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.9rem 1rem;
        background: linear-gradient(100deg, rgba(245, 158, 11, 0.16), rgba(245, 158, 11, 0.05));
        border: 1px solid rgba(245, 158, 11, 0.3);
        border-left: 4px solid var(--accent-yellow);
        border-radius: 0.875rem;
        color: #fef3c7;
    }

    .stock-alert-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 2.5rem;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        background: rgba(245, 158, 11, 0.2);
        color: var(--accent-yellow);
        font-size: 1.2rem;
    }

    .stock-alert-title {
        color: #fef3c7;
        font-weight: 700;
        margin-bottom: 0.15rem;
    }

    .stock-alert-detail {
        color: #d6d3d1;
        font-size: 0.8rem;
        margin: 0;
    }

    .stock-alert-link {
        margin-left: auto;
        flex-shrink: 0;
        color: var(--accent-yellow);
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
    }

    .stock-alert-link:hover {
        color: #fef08a;
    }

    @media (max-width: 575.98px) {
        .stock-alert {
            align-items: flex-start;
        }

        .stock-alert-link {
            margin-left: 0;
            margin-top: 0.25rem;
        }
    }

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

    .badge-stok {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
        font-weight: 600;
        padding: 0.35em 0.8em;
    }

    .badge-stok-low {
        background: rgba(239, 68, 68, 0.15);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
        font-weight: 600;
        padding: 0.35em 0.8em;
    }

    .badge-discount {
        background: rgba(239, 68, 68, 0.15);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.3);
        font-size: 0.68rem;
        font-weight: 700;
    }

    .discount-control {
        width: 86px;
        background: rgba(12, 10, 9, 0.7) !important;
        border: 1px solid rgba(239, 68, 68, 0.3) !important;
        color: #fca5a5 !important;
        font-weight: 700;
    }

    .discount-control:focus {
        border-color: #f87171 !important;
        box-shadow: 0 0 0 0.2rem rgba(239, 68, 68, 0.12) !important;
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

    .btn-action-edit {
        background: rgba(245, 158, 11, 0.1);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.25);
    }
    .btn-action-edit:hover {
        background: rgba(245, 158, 11, 0.25);
        color: #fef08a;
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.25);
    }
    .btn-action-delete:hover {
        background: rgba(239, 68, 68, 0.25);
        color: #fca5a5;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 border-bottom border-secondary border-opacity-25">
        <div>
            <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">
                Daftar Produk
            </h1>
            <p class="text-muted small mb-0">Kelola informasi stok, harga beli, dan harga jual barang.</p>
        </div>
        <div class="mt-3 mt-md-0">
            @if(Route::has('produk.create'))
            <a href="{{ route('produk.create') }}" class="btn btn-yellow px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </a>
            @endif
        </div>
    </div>

    {{-- FITUR PENCARIAN --}}
    <div class="row mb-4">
        <div class="col-12 col-md-6 col-lg-4">
            <form action="{{ route('produk.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-dark" placeholder="Cari nama produk..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-yellow px-3 d-flex align-items-center gap-1">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    @if($produkStokMenipis > 0 || $produkStokHabis > 0)
        <div class="stock-alert mb-4">
            <span class="stock-alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></span>
            <div class="flex-grow-1">
                <div class="stock-alert-title">Perhatian stok perlu ditindaklanjuti</div>
                <p class="stock-alert-detail">
                    @if($produkStokMenipis > 0)
                        {{ $produkStokMenipis }} produk mulai menipis (stok 1-10).
                    @endif
                    @if($produkStokHabis > 0)
                        {{ $produkStokHabis }} produk sudah habis.
                    @endif
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="stock-alert-link">Lihat ringkasan <i class="bi bi-arrow-up-right ms-1"></i></a>
        </div>
    @endif

    {{-- TABEL PRODUK --}}
    <div class="card card-dark-yellow overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-yellow align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">#</th>
                        <th>USER</th>
                        <th class="text-center">FOTO</th>
                        <th>NAMA PRODUK</th>
                        <th>HARGA BELI</th>
                        <th>HARGA JUAL</th>
                        <th>DISKON</th>
                        <th class="text-center">STOK</th>
                        <th class="text-end pe-4">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produk as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-semibold">
                            {{ method_exists($produk, 'firstItem') ? $produk->firstItem() + $index : $index + 1 }}
                        </td>
                        <td class="small text-muted">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-person-circle fs-6" style="color: var(--accent-yellow);"></i>
                                <span>{{ optional($item->user)->name ?? 'Admin' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            @if(!empty($item->foto))
                                <img src="{{ asset('storage/' . $item->foto) }}" class="product-thumb rounded-3 border border-secondary border-opacity-25" alt="Foto {{ $item->nama ?? $item->nama_produk }}">
                            @else
                                <div class="product-thumb rounded-3 d-inline-flex align-items-center justify-content-center text-muted border border-secondary border-opacity-25">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold text-white">{{ $item->nama ?? $item->nama_produk }}</td>
                        <td class="text-muted font-monospace">Rp {{ number_format($item->harga_beli ?? 0, 0, ',', '.') }}</td>
                        <td class="fw-bold font-monospace" style="color: var(--accent-yellow);">
                            @if(($item->diskon_persen ?? 0) > 0)
                                <span class="text-muted text-decoration-line-through d-block small">Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}</span>
                                @php $hargaPromo = $item->harga_jual - intdiv($item->harga_jual * $item->diskon_persen, 100); @endphp
                                Rp {{ number_format($hargaPromo, 0, ',', '.') }}
                                <span class="badge badge-discount rounded-pill ms-1">-{{ $item->diskon_persen }}%</span>
                            @else
                                Rp {{ number_format($item->harga_jual ?? 0, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('produk.discount.update', $item->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                @csrf
                                @method('PATCH')
                                <div class="input-group input-group-sm flex-nowrap">
                                    <input type="number" name="diskon_persen" min="0" max="100" value="{{ $item->diskon_persen ?? 0 }}" class="form-control discount-control" aria-label="Diskon {{ $item->nama ?? $item->nama_produk }} dalam persen">
                                    <span class="input-group-text bg-transparent border-secondary text-muted">%</span>
                                </div>
                                <button type="submit" class="btn btn-sm btn-action-edit" title="Simpan diskon"><i class="bi bi-check-lg"></i></button>
                            </form>
                        </td>
                        <td class="text-center">
                            @if(($item->stok ?? 0) > 10)
                                <span class="badge badge-stok rounded-pill">{{ $item->stok }}</span>
                            @else
                                <span class="badge badge-stok-low rounded-pill">{{ $item->stok }}</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-1">
                                @if(Route::has('produk.show'))
                                <a href="{{ route('produk.show', $item->id) }}" class="btn btn-sm btn-action-detail rounded-2 px-2.5 py-1 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                @endif

                                @if(Route::has('produk.edit'))
                                <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-sm btn-action-edit rounded-2 px-2.5 py-1 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @endif

                                @if(Route::has('produk.destroy'))
                                <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-action-delete rounded-2 px-2.5 py-1 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-50"></i>
                            Belum ada data produk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($produk, 'hasPages') && $produk->hasPages())
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
            {{ $produk->links() }}
        </div>
        @endif
    </div>

</div>

@endsection