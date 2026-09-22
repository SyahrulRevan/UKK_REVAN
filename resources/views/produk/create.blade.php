@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

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

    /* Form Styling */
    .form-label-custom {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-subtle);
        margin-bottom: 0.5rem;
    }

    .form-control-dark {
        background-color: rgba(12, 10, 9, 0.7) !important;
        border: 1px solid var(--border-yellow-subtle) !important;
        color: #ffffff !important;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }

    .form-control-dark:focus {
        border-color: var(--accent-yellow) !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.15) !important;
    }

    /* FIX DROPDOWN & ICON PANAH */
    select.form-control-dark {
        color: #ffffff !important;
        background-color: rgba(12, 10, 9, 0.7) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23f59e0b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
    }

    /* FIX WARNA TEKS OPTION DROPDOWN */
    select.form-control-dark option {
        background-color: #1c1917 !important;
        color: #ffffff !important;
        padding: 10px;
    }

    /* Preview Foto Box */
    .preview-box {
        width: 100%;
        height: 250px;
        border: 2px dashed var(--border-yellow-subtle);
        border-radius: 1rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-subtle);
        overflow: hidden;
        background: rgba(12, 10, 9, 0.4);
        transition: all 0.3s ease;
    }

    .preview-box:hover {
        border-color: var(--accent-yellow);
    }

    .preview-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* Button Styling */
    .btn-yellow {
        background: var(--accent-yellow) !important;
        color: #000000 !important;
        font-weight: 700;
        border: none !important;
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
    }

    .btn-yellow:hover {
        background: var(--accent-yellow-hover) !important;
        box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    }

    .btn-cancel-custom {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-subtle);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        text-decoration: none;
    }

    .btn-cancel-custom:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    .btn-back-custom {
        background: rgba(12, 10, 9, 0.6);
        border: 1px solid var(--border-yellow-subtle);
        color: var(--text-subtle);
        border-radius: 0.75rem;
        padding: 0.5rem 1rem;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-4 border-bottom border-secondary border-opacity-25">
        <div>
            <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">Tambah Produk Baru</h1>
            <p class="text-muted small mb-0">Isi formulir berikut untuk menambahkan stok barang ke dalam sistem.</p>
        </div>
        <a href="{{ route('produk.index') }}" class="btn btn-back-custom d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORM CARD --}}
    <div class="card card-dark-yellow p-4 p-lg-5">
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-5">
                
                {{-- SISI KIRI: INPUT DATA --}}
                <div class="col-lg-7">
                    {{-- NAMA PRODUK --}}
                    <div class="mb-4">
                        <label class="form-label-custom">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control form-control-dark @error('nama') is-invalid @enderror" placeholder="Contoh: Kopi Susu Aren" value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- KATEGORI PRODUK --}}
                    <div class="mb-4">
                        <label class="form-label-custom">Kategori Produk <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select form-control-dark @error('kategori_id') is-invalid @enderror" required>
                            <option value="" disabled selected class="text-muted">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }} style="background-color: #1c1917; color: #ffffff;">
                                    {{ $kategori->nama ?? $kategori->nama_kategori ?? $kategori->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- HARGA BELI & HARGA JUAL --}}
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Harga Beli (Rp)</label>
                            <input type="number" name="harga_beli" class="form-control form-control-dark" placeholder="0" value="{{ old('harga_beli') }}">
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga_jual" class="form-control form-control-dark @error('harga_jual') is-invalid @enderror" placeholder="0" value="{{ old('harga_jual') }}" required>
                            @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label-custom">Diskon Produk (%)</label>
                            <div class="input-group">
                                <input type="number" name="diskon_persen" min="0" max="100" class="form-control form-control-dark @error('diskon_persen') is-invalid @enderror" placeholder="0" value="{{ old('diskon_persen', 0) }}">
                                <span class="input-group-text form-control-dark">%</span>
                            </div>
                            @error('diskon_persen') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            <small class="text-muted">Isi 0 jika tidak ada promo.</small>
                        </div>
                    </div>

                    {{-- JUMLAH STOK --}}
                    <div class="mb-4">
                        <label class="form-label-custom">Jumlah Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" min="1" class="form-control form-control-dark @error('stok') is-invalid @enderror" placeholder="1" value="{{ old('stok', 1) }}" required>
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- SISI KANAN: UPLOAD FOTO --}}
                <div class="col-lg-5">
                    <label class="form-label-custom">Foto Produk</label>
                    <div class="preview-box mb-3" id="imagePreviewContainer">
                        <i class="bi bi-cloud-arrow-up fs-1 mb-2"></i>
                        <span class="small">Preview Foto Produk</span>
                    </div>
                    <input type="file" name="foto" id="fotoInput" class="form-control form-control-dark @error('foto') is-invalid @enderror" accept="image/*">
                    <p class="text-muted small mt-2"><i class="bi bi-info-circle me-1"></i> Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                    @error('foto') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="col-12 d-flex justify-content-end gap-3 mt-4 pt-4 border-top border-secondary border-opacity-25">
                    <a href="{{ route('produk.index') }}" class="btn btn-cancel-custom">Batal</a>
                    <button type="submit" class="btn btn-yellow d-inline-flex align-items-center gap-2">
                        <i class="bi bi-floppy-fill"></i> Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT UNTUK PREVIEW GAMBAR --}}
<script>
    document.getElementById('fotoInput').onchange = evt => {
        const [file] = document.getElementById('fotoInput').files
        if (file) {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = `<img src="${URL.createObjectURL(file)}" alt="Preview">`;
        }
    }
</script>

@endsection