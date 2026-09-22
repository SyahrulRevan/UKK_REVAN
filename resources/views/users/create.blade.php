@extends('layouts.app')

@section('title', 'Tambah User Baru')

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

    .form-control-dark, .form-select-dark {
        background-color: rgba(12, 10, 9, 0.7) !important;
        border: 1px solid var(--border-yellow-subtle) !important;
        color: #ffffff !important;
        padding: 0.75rem 1rem;
        border-radius: 0.625rem;
    }

    .form-control-dark:focus, .form-select-dark:focus {
        border-color: var(--accent-yellow) !important;
        box-shadow: 0 0 0 0.25rem rgba(245, 158, 11, 0.2) !important;
    }

    .input-group-text-dark {
        background-color: rgba(12, 10, 9, 0.9) !important;
        border: 1px solid var(--border-yellow-subtle) !important;
        border-right: none !important;
        color: var(--text-subtle) !important;
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

    .btn-outline-dark-custom {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-subtle);
    }

    .btn-outline-dark-custom:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER FORM --}}
    <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom border-secondary border-opacity-25">
        <div>
            <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">
                Tambah User Baru
            </h1>
            <p class="text-muted small mb-0">Buat akun baru untuk kasir atau administrator sistem.</p>
        </div>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-dark-custom px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- FORMULIR PENGGUNA --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card card-dark-yellow p-4">
                <div class="d-flex align-items-center gap-2 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                    <i class="bi bi-person-plus-fill fs-5" style="color: var(--accent-yellow);"></i>
                    <h5 class="fw-bold text-white mb-0">Formulir Pengguna</h5>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-muted">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-dark"><i class="bi bi-person"></i></span>
                            <input type="text" name="name" class="form-control form-control-dark @error('name') is-invalid @enderror" placeholder="Masukkan nama pengguna" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- Alamat Email --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold small text-muted">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control form-control-dark @error('email') is-invalid @enderror" placeholder="admin@gmail.com" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold small text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-dark"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control form-control-dark @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Peranan / Role --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-muted">Peranan (Role)</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-dark"><i class="bi bi-shield-check"></i></span>
                            <select name="role_id" class="form-select form-select-dark @error('role_id') is-invalid @enderror" required>
                                <option value="" selected disabled>-- Pilih Role --</option>
                                <option value="1">Admin</option>
                                <option value="2">Kasir</option>
                            </select>
                        </div>
                        @error('role_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-secondary border-opacity-25">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-dark-custom px-4 py-2 rounded-3">Batal</a>
                        <button type="submit" class="btn btn-yellow px-4 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill"></i> Simpan User
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

@endsection