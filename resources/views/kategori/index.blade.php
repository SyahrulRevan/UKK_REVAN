@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-dark-yellow: #0c0a09;
        --card-bg-dark: #1c1917;
        --border-yellow-subtle: rgba(245, 158, 11, 0.15);
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

    .modal-dark-yellow {
        background-color: var(--card-bg-dark) !important;
        border: 1px solid var(--border-yellow-subtle);
        color: var(--text-white);
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
                Daftar Kategori
            </h1>
            <p class="text-muted small mb-0">Kelola kategori produk toko kamu.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <button type="button" class="btn btn-yellow px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </button>
        </div>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
    <div class="alert alert-success bg-opacity-10 border-success text-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- TABEL KATEGORI --}}
    <div class="card card-dark-yellow overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-yellow align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>NAMA KATEGORI</th>
                        <th>DESKRIPSI</th>
                        <th class="text-end pe-4" style="width: 180px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $index => $item)
                    <tr>
                        <td class="text-center text-muted fw-semibold">
                            {{ method_exists($kategori, 'firstItem') ? $kategori->firstItem() + $index : $index + 1 }}
                        </td>
                        <td class="fw-bold text-white">
                            <i class="bi bi-tag-fill me-2" style="color: var(--accent-yellow);"></i>
                            {{ $item->nama_kategori }}
                        </td>
                        <td class="text-muted small">
                            {{ $item->deskripsi ?? '-' }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-1">
                                <button type="button" class="btn btn-sm btn-action-edit rounded-2 px-2.5 py-1 d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalEditKategori{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>

                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-action-delete rounded-2 px-2.5 py-1 d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT KATEGORI --}}
                    <div class="modal fade" id="modalEditKategori{{ $item->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-dark-yellow">
                                <div class="modal-header border-secondary border-opacity-25">
                                    <h5 class="modal-title fw-bold">Edit Kategori</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('kategori.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label text-subtle small fw-bold">NAMA KATEGORI</label>
                                            <input type="text" name="nama_kategori" class="form-control form-control-dark" value="{{ $item->nama_kategori }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-subtle small fw-bold">DESKRIPSI</label>
                                            <textarea name="deskripsi" class="form-control form-control-dark" rows="3">{{ $item->deskripsi }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-secondary border-opacity-25">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-yellow btn-sm">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-tags fs-1 d-block mb-2 opacity-50"></i>
                            Belum ada data kategori.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($kategori, 'hasPages') && $kategori->hasPages())
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
            {{ $kategori->links() }}
        </div>
        @endif
    </div>

</div>

{{-- MODAL TAMBAH KATEGORI --}}
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-dark-yellow">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-subtle small fw-bold">NAMA KATEGORI</label>
                        <input type="text" name="nama_kategori" class="form-control form-control-dark" placeholder="Contoh: Makanan, Minuman, dll." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-subtle small fw-bold">DESKRIPSI</label>
                        <textarea name="deskripsi" class="form-control form-control-dark" rows="3" placeholder="Deskripsi singkat (opsional)..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-secondary border-opacity-25">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-yellow btn-sm">Tambah Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection