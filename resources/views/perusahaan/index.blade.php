<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->nama_perusahaan ?: 'POSSYHRUL' }} - Profil Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { color-scheme: dark; }
        body { transition: background-color 0.25s ease, color 0.25s ease; }
        .company-photo {
            width: 132px;
            height: 132px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f59e0b;
            box-shadow: 0 0 0 8px rgba(245, 158, 11, 0.12);
        }
        .company-photo-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(245, 158, 11, 0.18);
            color: #fcd34d;
            font-size: 3rem;
            font-weight: 800;
        }
        .theme-light { background: #f1f5f9 !important; color: #172033 !important; }
        .theme-light .bg-gray-900 { background: #ffffff !important; }
        .theme-light .bg-gray-950 { background: #f1f5f9 !important; }
        .theme-light .text-white { color: #172033 !important; }
        .theme-light .text-gray-300,
        .theme-light .text-gray-400 { color: #475569 !important; }
        .theme-light .text-gray-500 { color: #64748b !important; }
        .theme-light .border-gray-800 { border-color: #cbd5e1 !important; }
        .theme-light input,
        .theme-light textarea { background: #f8fafc !important; color: #172033 !important; border-color: #cbd5e1 !important; }
    </style>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen font-sans p-6 md:p-10" id="companyPage">

    <main class="max-w-5xl mx-auto space-y-6">

        @if(session('success'))
            <div class="rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">{{ $errors->first() }}</div>
        @endif

        <div class="bg-gray-900 rounded-2xl p-6 border border-gray-800 shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-xl bg-amber-500/20 border border-amber-500/40 flex items-center justify-center text-2xl font-bold text-amber-300">{{ strtoupper(substr($user->nama_perusahaan ?: 'P', 0, 1)) }}</div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-amber-400 mb-1">Profil Perusahaan</p>
                    <h1 class="text-3xl font-extrabold tracking-tight text-white">{{ $user->nama_perusahaan ?: 'POSSYHRUL' }}</h1>
                    <p class="text-sm text-gray-400 mt-1">{{ $user->deskripsi ?: 'Sistem Manajemen Stok & Rekapitulasi Data Penjualan.' }}</p>
                    @if($user->website)
                        <a href="{{ $user->website }}" target="_blank" rel="noopener noreferrer" class="inline-block text-xs mt-2 text-amber-400 hover:text-amber-300">{{ $user->website }}</a>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="rounded-xl border border-gray-700 bg-gray-800 px-4 py-2.5 text-xs font-semibold text-gray-200 hover:bg-gray-700">Kembali</a>
                <button type="button" id="themeToggle" class="rounded-xl border border-amber-500/40 bg-amber-500/10 px-4 py-2.5 text-xs font-semibold text-amber-300 hover:bg-amber-500/20">Mode terang</button>
            </div>

        </div>

        <section class="bg-gray-900 rounded-2xl p-7 border border-gray-800 shadow-xl text-center">
            <p class="text-xs uppercase tracking-[0.2em] text-amber-400 mb-4">Foto Profil Perusahaan</p>
            @if($user->foto_perusahaan)
                <img id="companyPhotoPreview" src="{{ asset('storage/' . $user->foto_perusahaan) }}" alt="Foto {{ $user->nama_perusahaan ?: 'perusahaan' }}" class="company-photo mx-auto">
            @else
                <div id="companyPhotoPlaceholder" class="company-photo company-photo-placeholder mx-auto">{{ strtoupper(substr($user->nama_perusahaan ?: 'P', 0, 1)) }}</div>
                <img id="companyPhotoPreview" alt="Pratinjau foto perusahaan" class="company-photo mx-auto hidden">
            @endif
            <form action="{{ route('perusahaan.profile.update') }}" method="POST" enctype="multipart/form-data" class="mx-auto mt-6 max-w-xl text-left">
                @csrf
                @method('PUT')
                <label for="fotoPerusahaan" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Pilih foto perusahaan</label>
                <input id="fotoPerusahaan" type="file" name="foto_perusahaan" accept="image/*" class="w-full rounded-xl border border-gray-700 bg-gray-950 px-3 py-2 text-sm text-gray-200">
                <p class="mt-2 text-xs text-gray-500">JPG, JPEG, PNG, GIF, atau WEBP. Maksimal 4MB.</p>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $user->nama_perusahaan) }}" placeholder="Nama perusahaan" class="rounded-xl border border-gray-700 bg-gray-950 px-4 py-3 text-sm text-white">
                    <input type="url" name="website" value="{{ old('website', $user->website) }}" placeholder="https://website.com" class="rounded-xl border border-gray-700 bg-gray-950 px-4 py-3 text-sm text-white">
                </div>
                <textarea name="deskripsi" rows="3" placeholder="Keterangan singkat perusahaan" class="mt-4 w-full rounded-xl border border-gray-700 bg-gray-950 px-4 py-3 text-sm text-white">{{ old('deskripsi', $user->deskripsi) }}</textarea>
                <label for="fotoQris" class="mt-5 mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Foto QRIS pembayaran</label>
                <input id="fotoQris" type="file" name="foto_qris" accept="image/*" class="w-full rounded-xl border border-gray-700 bg-gray-950 px-3 py-2 text-sm text-gray-200">
                <p class="mt-2 text-xs text-gray-500">Upload QRIS resmi toko agar pelanggan dapat memindainya.</p>
                <button type="submit" class="mt-4 w-full rounded-xl bg-amber-500 px-4 py-3 text-sm font-bold text-black hover:bg-amber-400">Simpan Profil Perusahaan</button>
            </form>
        </section>

        <section class="grid gap-6 md:grid-cols-[1.2fr_0.8fr]">
            <article class="bg-gray-900 rounded-2xl p-7 border border-gray-800 shadow-xl">
                <p class="text-xs uppercase tracking-[0.2em] text-amber-400 mb-3">Tentang Kami</p>
                <h2 class="text-2xl font-bold text-white mb-4">Mengelola bisnis dengan data yang lebih jelas.</h2>
                <p class="text-gray-400 leading-7">{{ $user->deskripsi ?: 'Website ini dibuat untuk membantu perusahaan mengelola produk, stok, kategori, dan transaksi penjualan dalam satu tempat yang rapi dan mudah digunakan.' }}</p>
            </article>

            <article class="bg-gray-900 rounded-2xl p-7 border border-gray-800 shadow-xl">
                <p class="text-xs uppercase tracking-[0.2em] text-amber-400 mb-3">Tujuan Website</p>
                <ul class="space-y-4 text-sm text-gray-300">
                    <li class="flex gap-3"><span class="text-amber-400">01</span><span>Mencatat transaksi penjualan secara teratur.</span></li>
                    <li class="flex gap-3"><span class="text-amber-400">02</span><span>Memantau stok produk dengan lebih cepat.</span></li>
                    <li class="flex gap-3"><span class="text-amber-400">03</span><span>Menyediakan ringkasan pemasukan dan stok.</span></li>
                </ul>
            </article>
        </section>

        <section class="bg-gray-900 rounded-2xl p-7 border border-gray-800 shadow-xl">
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-amber-400 mb-3">Informasi Perusahaan</p>
                    <dl class="space-y-4 text-sm">
                        <div><dt class="text-gray-500">Nama perusahaan</dt><dd class="text-white font-semibold mt-1">{{ $user->nama_perusahaan ?: 'Belum diatur' }}</dd></div>
                        <div><dt class="text-gray-500">Pemilik / pengelola</dt><dd class="text-white font-semibold mt-1">{{ $user->name }}</dd></div>
                        <div><dt class="text-gray-500">Email</dt><dd class="text-white font-semibold mt-1 break-all">{{ $user->email }}</dd></div>
                    </dl>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-amber-400 mb-3">Website</p>
                    @if($user->website)
                        <a href="{{ $user->website }}" target="_blank" rel="noopener noreferrer" class="text-lg text-white font-semibold break-all hover:text-amber-400">{{ $user->website }}</a>
                    @else
                        <p class="text-gray-500">Website belum ditambahkan.</p>
                    @endif
                    <p class="text-sm text-gray-500 mt-4">Data perusahaan ditampilkan terpisah dari profil pribadi pengguna.</p>
                </div>
            </div>
        </section>
    </main>
    <script>
        const page = document.getElementById('companyPage');
        const themeToggle = document.getElementById('themeToggle');
        const savedTheme = localStorage.getItem('pos-theme');

        if (savedTheme === 'light') {
            page.classList.add('theme-light');
            themeToggle.textContent = 'Mode gelap';
        }

        themeToggle.addEventListener('click', () => {
            const isLight = page.classList.toggle('theme-light');
            localStorage.setItem('pos-theme', isLight ? 'light' : 'dark');
            themeToggle.textContent = isLight ? 'Mode gelap' : 'Mode terang';
        });

        document.getElementById('fotoPerusahaan').addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (!file) return;

            const preview = document.getElementById('companyPhotoPreview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            document.getElementById('companyPhotoPlaceholder')?.classList.add('hidden');
        });
    </script>
</body>
</html>