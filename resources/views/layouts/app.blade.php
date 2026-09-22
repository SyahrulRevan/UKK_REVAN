<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi POS')</title>

    {{-- Font Google --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- CSS Bootstrap & Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- CSS Tema Utama (Dark Yellow / Amber Gold) --}}
    <style>
        :root {
            --bg-dark-yellow: #0c0a09;
            --card-bg-dark: #1c1917;
            --border-yellow-subtle: rgba(245, 158, 11, 0.25);
            --accent-yellow: #f59e0b;
            --accent-yellow-hover: #d97706;
            --text-white: #ffffff;
            --text-subtle: #cbd5e1; /* Warna teks terang agar kontras & gampang dibaca */
        }

        body {
            background-color: var(--bg-dark-yellow) !important;
            color: var(--text-white) !important;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
        }

        /* PERBAIKAN WARNA TEKS BIAR GAK GELAP / MATI */
        .text-muted, .text-secondary {
            color: #cbd5e1 !important; /* Diubah jadi abu-abu terang */
        }

        .text-light {
            color: #f1f5f9 !important;
        }

        label, .form-label {
            color: #f8fafc !important;
            font-weight: 600;
        }

        /* STYLES TABEL KONTRAST TINGGI */
        .table {
            color: #ffffff !important;
        }

        .table th {
            color: #f8fafc !important;
            border-color: rgba(245, 158, 11, 0.2) !important;
        }

        .table td {
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }

        /* BADGE & HARGA JELAS */
        .harga-highlight {
            color: #fbbf24 !important;
            font-weight: 700;
        }
    </style>

    @yield('styles')
</head>

<body>

    {{-- Konten Utama / Yield --}}
    @yield('content')

    <style>
        body.theme-light {
            background: #f1f5f9 !important;
            color: #172033 !important;
        }

        body.theme-light .sidebar-custom,
        body.theme-light .mobile-header {
            background: #ffffff !important;
            border-color: #cbd5e1 !important;
        }

        body.theme-light .sidebar-link {
            color: #475569 !important;
        }

        body.theme-light .sidebar-link:hover {
            color: #92400e !important;
            background: #fef3c7 !important;
        }

        body.theme-light .card,
        body.theme-light .card-pro,
        body.theme-light .card-dark-yellow,
        body.theme-light .product-card,
        body.theme-light .cart-box,
        body.theme-light .total-display-box {
            background: #ffffff !important;
            color: #172033 !important;
            border-color: #cbd5e1 !important;
        }

        body.theme-light .text-white,
        body.theme-light .table,
        body.theme-light .table td,
        body.theme-light .table th {
            color: #172033 !important;
        }

        body.theme-light .text-muted,
        body.theme-light .text-secondary,
        body.theme-light .text-light {
            color: #64748b !important;
        }

        body.theme-light .form-control-dark,
        body.theme-light .form-select,
        body.theme-light input,
        body.theme-light textarea,
        body.theme-light select {
            background: #f8fafc !important;
            color: #172033 !important;
            border-color: #cbd5e1 !important;
        }

        body.theme-light .dropdown-menu-dark-yellow {
            background: #ffffff !important;
            border-color: #cbd5e1 !important;
        }

        body.theme-light .dropdown-menu-dark-yellow .dropdown-item {
            color: #475569 !important;
        }

        body.theme-light .dropdown-menu-dark-yellow .dropdown-item:hover {
            background: #fef3c7 !important;
            color: #92400e !important;
        }

        body.theme-light .table-dark-yellow th {
            background: #e2e8f0 !important;
            color: #334155 !important;
        }

        body.theme-light .table-dark-yellow td {
            border-color: #e2e8f0 !important;
        }
    </style>

    {{-- WAJIB ADA: Bootstrap JS Bundle --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const themeKey = 'pos-theme';
            const themeToggle = document.getElementById('themeToggle');
            const savedTheme = localStorage.getItem(themeKey);
            const body = document.body;

            const updateThemeButton = () => {
                if (!themeToggle) return;
                const isLight = body.classList.contains('theme-light');
                themeToggle.querySelector('i').className = isLight ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
                themeToggle.querySelector('span').textContent = isLight ? 'Mode gelap' : 'Mode terang';
            };

            if (savedTheme === 'light') body.classList.add('theme-light');
            updateThemeButton();

            themeToggle?.addEventListener('click', () => {
                const isLight = body.classList.toggle('theme-light');
                localStorage.setItem(themeKey, isLight ? 'light' : 'dark');
                updateThemeButton();
            });
        })();
    </script>

    @yield('scripts')
</body>

</html>