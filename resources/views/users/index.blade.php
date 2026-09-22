@extends('layouts.app')

@section('title', 'Manajemen Users')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-dark-yellow: #0c0a09;
        --card-bg-dark: #1c1917;
        --border-yellow-subtle: rgba(245, 158, 11, 0.15);
        --border-yellow-glow: rgba(245, 158, 11, 0.35);
        --accent-yellow: #f59e0b;
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
        background-color: rgba(12, 10, 9, 0.5) !important;
        color: var(--text-subtle) !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        border-bottom: 1px solid var(--border-yellow-subtle) !important;
        padding: 1rem 1.25rem;
    }

    .table-dark-yellow td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
        padding: 1rem 1.25rem;
        vertical-align: middle;
    }

    .table-dark-yellow tbody tr:hover td {
        background-color: rgba(245, 158, 11, 0.05) !important;
    }

    .badge-admin {
        background: rgba(99, 102, 241, 0.15);
        color: #818cf8;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }

    .badge-kasir {
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .btn-yellow {
        background: var(--accent-yellow);
        color: #000;
        font-weight: 700;
        border: none;
    }

    .btn-yellow:hover {
        background: #d97706;
        color: #000;
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER HALAMAN --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 border-bottom border-secondary border-opacity-25">
        <div>
            <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">
                Manajemen Users
            </h1>
            <p class="text-muted small mb-0">Kelola daftar pengguna, peranan (role), dan hak akses sistem.</p>
        </div>
        <div class="mt-3 mt-md-0">
            @if(Route::has('admin.users.create'))
            <a href="{{ route('admin.users.create') }}" class="btn btn-yellow px-3 py-2 rounded-3 d-inline-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i> Tambah User Baru
            </a>
            @endif
        </div>
    </div>

    {{-- TABEL USERS --}}
    <div class="card card-dark-yellow overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark-yellow align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                    <tr>
                        <td class="text-center text-muted fw-semibold">
                            {{ $users->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; background: rgba(245, 158, 11, 0.2); color: var(--accent-yellow); font-size: 0.85rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold text-white">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-muted font-monospace small">{{ $user->email }}</td>
                        <td class="text-center">
                            @if(optional($user->role)->name == 'admin' || $user->role == 'admin')
                                <span class="badge badge-admin px-3 py-1 rounded-pill fw-medium">Admin</span>
                            @else
                                <span class="badge badge-kasir px-3 py-1 rounded-pill fw-medium">Kasir</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                @if(Route::has('admin.users.edit'))
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @endif

                                @if(Route::has('admin.users.destroy'))
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2 opacity-50"></i>
                            Belum ada data user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center py-3">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>

@endsection