@extends('layouts.app')

@section('title', 'Profil Saya')

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
        overflow: hidden;
    }

    .profile-summary {
        position: relative;
        min-height: 100%;
        padding-top: 2.25rem !important;
        background: linear-gradient(160deg, rgba(245, 158, 11, 0.12), var(--card-bg-dark) 42%) !important;
    }

    .profile-summary::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 5px;
        background: linear-gradient(90deg, var(--accent-yellow), #fbbf24, transparent);
    }

    .profile-kicker {
        color: var(--accent-yellow);
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.14em;
        text-transform: uppercase;
    }

    .profile-avatar {
        width: 116px;
        height: 116px;
        box-shadow: 0 0 0 7px rgba(245, 158, 11, 0.1), 0 12px 28px rgba(0, 0, 0, 0.25);
    }

    .profile-meta {
        width: 100%;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(245, 158, 11, 0.16);
        text-align: left;
    }

    .profile-meta-row {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        color: var(--text-subtle);
        font-size: 0.78rem;
    }

    .profile-meta-row + .profile-meta-row {
        margin-top: 0.65rem;
    }

    .profile-meta-row i {
        width: 1.25rem;
        color: var(--accent-yellow);
        text-align: center;
    }

    .section-caption {
        color: var(--text-subtle);
        font-size: 0.78rem;
        margin-top: -0.75rem;
        margin-bottom: 1.25rem;
    }

    .form-label.text-subtle {
        color: #d6d3d1 !important;
        letter-spacing: 0.06em;
    }

    .form-hint {
        color: #a8a29e !important;
        line-height: 1.5;
    }

    .security-heading {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 767.98px) {
        .profile-summary {
            min-height: auto;
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

    .profile-avatar {
        width: 90px;
        height: 90px;
        background-color: rgba(245, 158, 11, 0.15);
        color: var(--accent-yellow);
        font-size: 2.2rem;
        font-weight: 700;
        border: 2px solid var(--accent-yellow);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        overflow: hidden;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .upload-box {
        border: 1px dashed rgba(245, 158, 11, 0.45);
        background: rgba(12, 10, 9, 0.5);
        border-radius: 0.75rem;
        padding: 0.75rem;
    }

    .upload-preview {
        width: 64px;
        height: 64px;
        border-radius: 0.75rem;
        object-fit: cover;
        border: 1px solid rgba(245, 158, 11, 0.5);
        display: none;
    }
</style>

<div class="container-fluid px-4 py-4" style="max-width: 900px;">

    {{-- HEADER HALAMAN --}}
    <div class="pb-4 mb-4 border-bottom border-secondary border-opacity-25">
        <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">
            Profil Saya
        </h1>
        <p class="text-muted small mb-0">Kelola informasi akun dan kata sandi Anda.</p>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
    <div class="alert alert-success bg-opacity-10 border-success text-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
    <div class="alert alert-danger bg-opacity-10 border-danger text-danger alert-dismissible fade show mb-4" role="alert">
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        {{-- CARD USER INFO --}}
        <div class="col-md-4">
            <div class="card card-dark-yellow profile-summary p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="profile-kicker mb-4">Ringkasan Akun</div>
                <div class="profile-avatar mb-3" id="profileAvatar">
                    @if($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <h5 class="fw-bold text-white mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-3 text-break">{{ $user->email }}</p>
                <div>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold">
                        <i class="bi bi-shield-lock-fill me-1"></i> {{ ucfirst($user->role?->name ?? 'Admin') }}
                    </span>
                </div>
                <div class="profile-meta">
                    <div class="profile-meta-row"><i class="bi bi-person-check-fill"></i><span>Akun aktif</span></div>
                    <div class="profile-meta-row"><i class="bi bi-shield-check"></i><span>Akses {{ ucfirst($user->role?->name ?? 'Admin') }}</span></div>
                </div>
            </div>
        </div>

        {{-- FORM EDIT PROFIL --}}
        <div class="col-md-8">
            <div class="card card-dark-yellow p-4">
                <h5 class="fw-bold text-white mb-4 pb-2 border-bottom border-secondary border-opacity-25">
                    <i class="bi bi-person-gear me-2" style="color: var(--accent-yellow);"></i> Pengaturan Akun
                </h5>
                <p class="section-caption">Perbarui identitas dan foto yang digunakan di dalam aplikasi.</p>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-subtle small fw-bold">NAMA LENGKAP</label>
                        <input type="text" name="name" class="form-control form-control-dark" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-subtle small fw-bold">ALAMAT EMAIL</label>
                        <input type="email" name="email" class="form-control form-control-dark" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-subtle small fw-bold">FOTO PROFIL</label>
                        <div class="upload-box">
                            <input type="file" name="foto" class="form-control form-control-dark" accept="image/*">
                            <img id="fotoPreview" class="upload-preview mt-3" alt="Pratinjau foto profil">
                            <small class="text-muted d-block mt-2">Pilih gambar dari perangkat. Format JPG, JPEG, PNG, GIF, WEBP. Maks 4MB.</small>
                        </div>
                    </div>

                    <h6 class="security-heading fw-bold text-white mt-4 mb-3 pt-3 border-top border-secondary border-opacity-25">
                        <i class="bi bi-key-fill me-2" style="color: var(--accent-yellow);"></i> Ubah Password <span class="text-muted fw-normal fs-6">(Opsional)</span>
                    </h6>
                    <p class="section-caption">Kosongkan bagian ini jika Anda tidak ingin mengganti password.</p>

                    <div class="mb-3">
                        <label class="form-label text-subtle small fw-bold">PASSWORD LAMA</label>
                        <input type="password" name="current_password" class="form-control form-control-dark" placeholder="Masukkan password saat ini">
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-subtle small fw-bold">PASSWORD BARU</label>
                            <input type="password" name="password" class="form-control form-control-dark" placeholder="Minimal 8 karakter">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-subtle small fw-bold">KONFIRMASI PASSWORD BARU</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-dark" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-yellow px-4 py-2 rounded-3">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    const fotoInput = document.querySelector('input[name="foto"]');
    const fotoPreview = document.getElementById('fotoPreview');

    fotoInput?.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) {
            fotoPreview.style.display = 'none';
            return;
        }

        const imageUrl = URL.createObjectURL(file);
        fotoPreview.src = imageUrl;
        fotoPreview.style.display = 'block';

        document.getElementById('profileAvatar').innerHTML = `<img src="${imageUrl}" alt="Pratinjau foto profil">`;
    });
</script>

@endsection