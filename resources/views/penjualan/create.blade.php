@extends('layouts.app')

@section('title', 'Kasir Transaksi')

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
            --panel-dark: #151210;
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

        .cashier-shell {
            max-width: 1500px;
            margin: 0 auto;
        }

        .cashier-header {
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .cashier-eyebrow {
            color: var(--accent-yellow);
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .cashier-stat {
            border: 1px solid var(--border-yellow-subtle);
            background: rgba(245, 158, 11, 0.07);
            border-radius: 0.75rem;
            padding: 0.55rem 0.8rem;
            min-width: 105px;
        }

        .cashier-stat strong {
            display: block;
            color: var(--accent-yellow-light);
            font-size: 1rem;
        }

        .cashier-stat span {
            color: var(--text-subtle);
            font-size: 0.68rem;
        }

        .product-toolbar {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            margin-bottom: 1.25rem;
        }

        .product-toolbar .input-group {
            flex: 1;
        }

        .product-count {
            color: var(--text-subtle);
            font-size: 0.78rem;
            white-space: nowrap;
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

        /* Product Card Styling */
        .product-card {
            background: linear-gradient(160deg, #211d1a, var(--card-bg-dark));
            border: 1px solid var(--border-yellow-subtle);
            border-radius: 0.9rem;
            padding: 0.8rem;
            transition: all 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            border-color: var(--accent-yellow);
            transform: translateY(-2px);
        }

        .product-img-box {
            width: 100%;
            height: 124px;
            background: #11100f;
            border-radius: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .product-img-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
            background: #f5f5f4;
        }

        .product-image-fallback {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: var(--text-subtle);
        }

        .btn-add-cart {
            background: rgba(245, 158, 11, 0.15);
            color: var(--accent-yellow);
            border: 1px solid var(--border-yellow-subtle);
            border-radius: 0.5rem;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .product-price {
            color: var(--accent-yellow);
            font-size: 0.85rem;
        }

        .discount-badge {
            display: inline-block;
            margin-bottom: 0.25rem;
            padding: 0.18rem 0.45rem;
            border-radius: 0.35rem;
            background: rgba(239, 68, 68, 0.16);
            color: #fca5a5;
            font-size: 0.65rem;
            font-weight: 800;
        }

        .product-old-price {
            color: #78716c;
            font-size: 0.68rem;
            text-decoration: line-through;
        }

        .product-stock {
            color: var(--text-subtle);
            font-size: 0.72rem;
        }

        .btn-add-cart:hover {
            background: var(--accent-yellow);
            color: #000;
            border-color: var(--accent-yellow);
        }

        /* Cart Section Styling */
        .cart-box {
            background: linear-gradient(160deg, #211d1a, var(--card-bg-dark));
            border: 1px solid var(--border-yellow-subtle);
            border-radius: 1rem;
            position: sticky;
            top: 1.5rem;
            min-height: 480px;
        }

        .cart-heading-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 0.6rem;
            background: rgba(245, 158, 11, 0.15);
            color: var(--accent-yellow);
        }

        .cart-count {
            color: var(--text-subtle);
            font-size: 0.72rem;
        }

        .cart-item-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0.75rem 0;
        }

        .btn-qty {
            background: rgba(255, 255, 255, 0.08);
            color: var(--text-white);
            border: none;
            width: 24px;
            height: 24px;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-qty:hover {
            background: var(--accent-yellow);
            color: #000;
        }

        .total-display-box {
            background: var(--panel-dark);
            border: 1px solid var(--border-yellow-subtle);
            border-radius: 0.75rem;
            padding: 1rem;
        }

        .payment-summary {
            background: rgba(12, 10, 9, 0.58);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.75rem;
            padding: 0.85rem;
        }

        .payment-summary .change-value {
            color: #34d399;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .empty-cart-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 1rem;
            background: rgba(245, 158, 11, 0.1);
            color: var(--accent-yellow);
            font-size: 1.25rem;
        }

        .btn-checkout {
            background: var(--accent-yellow) !important;
            color: #000000 !important;
            font-weight: 700;
            border: none !important;
            padding: 0.85rem;
            border-radius: 0.75rem;
            width: 100%;
            transition: all 0.2s ease;
        }

        .btn-checkout:hover {
            background: var(--accent-yellow-hover) !important;
            color: #000000 !important;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-checkout:disabled {
            background: rgba(255, 255, 255, 0.1) !important;
            color: var(--text-subtle) !important;
            cursor: not-allowed;
        }

        .btn-back-custom {
            background: rgba(12, 10, 9, 0.6);
            border: 1px solid var(--border-yellow-subtle);
            color: var(--text-subtle);
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
        }
    </style>

    <div class="container-fluid px-4 py-4 cashier-shell">

        {{-- HEADER HALAMAN --}}
        <div class="cashier-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <div class="cashier-eyebrow mb-1">Point of Sale</div>
                <h1 class="fw-bold text-white mb-1" style="font-size: 1.8rem;">
                    <i class="bi bi-calculator me-2" style="color: var(--accent-yellow);"></i>Kasir Transaksi
                </h1>
                <p class="text-muted small mb-0">Pilih produk untuk memulai transaksi baru.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="cashier-stat"><strong>{{ count($produks ?? $produk ?? []) }}</strong><span>Produk tersedia</span></div>
                <a href="{{ route('penjualan.index') }}" class="btn btn-back-custom d-inline-flex align-items-center gap-2">
                    <i class="bi bi-clock-history"></i> Riwayat
                </a>
            </div>
        </div>

        <form action="{{ route('penjualan.store') }}" method="POST" id="formTransaksi">
            @csrf
            <div class="row g-4">

                {{-- KOLOM KIRI: DAFTAR PRODUK --}}
                <div class="col-lg-8 col-xl-9">

                    {{-- SEARCH BAR --}}
                    <div class="product-toolbar">
                        <div class="input-group">
                            <span class="input-group-text form-control-dark border-end-0 text-muted">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="inputSearch"
                                class="form-control form-control-dark border-start-0 ps-0"
                                placeholder="Cari nama produk...">
                        </div>
                        <span class="product-count"><i class="bi bi-grid-3x3-gap me-1"></i> Pilih produk</span>
                    </div>

                    {{-- GRID PRODUK --}}
                    <div class="row g-3" id="productGrid">
                        @forelse($produks ?? $produk ?? [] as $item)
                            <div class="col-12 col-sm-6 col-md-4 col-xl-3 product-item"
                                data-nama="{{ strtolower($item->nama ?? $item->nama_produk) }}">
                                <div class="product-card">
                                    <div>
                                        <div class="product-img-box">
                                            @if (!empty($item->foto))
                                                <img src="{{ asset('storage/' . $item->foto) }}"
                                                    alt="{{ $item->nama ?? $item->nama_produk }}"
                                                    onerror="this.hidden = true; this.nextElementSibling.hidden = false;">
                                                <div class="product-image-fallback" hidden aria-label="Foto produk tidak tersedia">
                                                    <i class="bi bi-box-seam fs-2 opacity-50"></i>
                                                </div>
                                            @else
                                                <div class="product-image-fallback">
                                                    <i class="bi bi-box-seam fs-2 opacity-50"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <h6 class="fw-bold text-white mb-1 text-truncate"
                                            title="{{ $item->nama ?? $item->nama_produk }}">
                                            {{ $item->nama ?? $item->nama_produk }}
                                        </h6>
                                        <p class="product-stock mb-2">Stok tersedia: <strong
                                            class="text-white">{{ $item->stok }}</strong></p>
                                    </div>

                                    <div
                                        class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary border-opacity-25">
                                        <div>
                                            @if(($item->diskon_persen ?? 0) > 0)
                                                <span class="discount-badge">PROMO {{ $item->diskon_persen }}%</span>
                                                <span class="product-old-price d-block">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                                @php $hargaPromo = $item->harga_jual - intdiv($item->harga_jual * $item->diskon_persen, 100); @endphp
                                                <span class="product-price fw-bold font-monospace">Rp {{ number_format($hargaPromo, 0, ',', '.') }}</span>
                                            @else
                                                <span class="product-price fw-bold font-monospace">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-add-cart"
                                            onclick="addToCart({{ $item->id }}, '{{ addslashes($item->nama ?? $item->nama_produk) }}', {{ $item->harga_jual }}, {{ $item->stok }}, {{ $item->diskon_persen ?? 0 }})">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                Tidak ada produk yang tersedia.
                            </div>
                        @endforelse
                    </div>

                </div>

                {{-- KOLOM KANAN: KERANJANG BELANJA --}}
                <div class="col-lg-4 col-xl-3">
                    <div class="cart-box p-4">
                        <div
                            class="d-flex justify-content-between align-items-center pb-3 border-bottom border-secondary border-opacity-25 mb-3">
                            <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                                <span class="cart-heading-icon"><i class="bi bi-cart3"></i></span> Keranjang
                            </h5>
                            <button type="button" class="btn btn-link text-danger text-decoration-none p-0 small"
                                onclick="clearCart()">
                                <i class="bi bi-trash me-1"></i>Hapus semua
                            </button>
                        </div>
                        <div class="cart-count mb-3" id="cartCount">0 produk dipilih</div>

                        {{-- LIST ITEM KERANJANG --}}
                        <div id="cartList" class="mb-4" style="max-height: 280px; overflow-y: auto;">
                            <div class="text-center py-4 text-muted small" id="cartEmptyState">
                                <span class="empty-cart-icon mb-3"><i class="bi bi-basket3"></i></span>
                                <div>Keranjang masih kosong.</div><span>Tambahkan produk dari daftar.</span>
                            </div>
                        </div>

                        {{-- METODE PEMBAYARAN --}}
                        <div class="mb-4">
                            <label class="form-label-custom small text-muted mb-2 fw-semibold">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metodePembayaran" class="form-select form-control-dark">
                                <option value="CASH">CASH (Tunai)</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>

                        <div id="qrisPanel" class="mb-4 p-3 rounded-3 text-center" style="display: none; background: rgba(59, 130, 246, 0.08); border: 1px solid rgba(59, 130, 246, 0.35);">
                            <span class="text-white small fw-semibold d-block mb-2">Scan QRIS untuk membayar</span>
                            @if(Auth::user()->foto_qris)
                                <img src="{{ asset('storage/' . Auth::user()->foto_qris) }}" alt="QRIS pembayaran" style="width: 190px; height: 190px; object-fit: contain; background: #ffffff; padding: 8px; border-radius: 0.75rem;">
                            @else
                                <div class="text-warning small py-3">Foto QRIS belum ditambahkan. Upload melalui halaman perusahaan.</div>
                                <a href="{{ route('perusahaan.index') }}" class="btn btn-sm btn-outline-warning">Atur QRIS</a>
                            @endif
                        </div>

                        {{-- TOTAL HARGA --}}
                        <div class="total-display-box mb-4">
                            <span class="text-muted small d-block mb-1">Total Pembayaran</span>
                            <div class="fs-2 fw-bold font-monospace" style="color: var(--accent-yellow);" id="totalDisplay">
                                Rp 0
                            </div>
                        </div>

                        <div class="payment-summary mb-4">
                            <label for="uangDibayar" class="form-label small text-muted mb-2">Uang Dibayar</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text form-control-dark border-end-0">Rp</span>
                                <input type="number" name="uang_dibayar" id="uangDibayar" min="0"
                                    class="form-control form-control-dark border-start-0" placeholder="Contoh: 20000"
                                    inputmode="numeric" disabled required>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted">Kembalian</span>
                                <span class="change-value font-monospace" id="changeDisplay">Rp 0</span>
                            </div>
                            <div class="small text-danger mt-2" id="paymentWarning" hidden>Uang dibayar masih kurang.</div>
                        </div>

                        {{-- SUBMIT BUTTON --}}
                        <button type="submit"
                            class="btn btn-checkout d-flex align-items-center justify-content-center gap-2" id="btnSubmit"
                            disabled>
                            <i class="bi bi-check-circle-fill"></i> Selesaikan Transaksi
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK HITUNGAN POS & SERACH --}}
    <script>
        let cart = [];

        function addToCart(id, nama, hargaAsli, maxStok, diskonPersen) {
            const harga = hargaAsli - Math.floor((hargaAsli * diskonPersen) / 100);
            let item = cart.find(i => i.id === id);
            if (item) {
                if (item.qty < maxStok) {
                    item.qty++;
                } else {
                    alert('Stok produk telah mencapai batas maksimum!');
                }
            } else {
                cart.push({
                    id,
                    nama,
                    harga,
                    hargaAsli,
                    diskonPersen,
                    qty: 1,
                    maxStok
                });
            }
            renderCart();
        }

        function updateQty(id, change) {
            let item = cart.find(i => i.id === id);
            if (item) {
                item.qty += change;
                if (item.qty <= 0) {
                    cart = cart.filter(i => i.id !== id);
                } else if (item.qty > item.maxStok) {
                    item.qty = item.maxStok;
                    alert('Stok produk telah mencapai batas maksimum!');
                }
            }
            renderCart();
        }

        function clearCart() {
            cart = [];
            renderCart();
        }

        function renderCart() {
            const cartList = document.getElementById('cartList');
            const totalDisplay = document.getElementById('totalDisplay');
            const btnSubmit = document.getElementById('btnSubmit');

            if (cart.length === 0) {
                cartList.innerHTML = `
                <div class="text-center py-4 text-muted small" id="cartEmptyState">
                    <span class="empty-cart-icon mb-3"><i class="bi bi-basket3"></i></span>
                    <div>Keranjang masih kosong.</div><span>Tambahkan produk dari daftar.</span>
                </div>`;
                totalDisplay.innerText = 'Rp 0';
                document.getElementById('cartCount').innerText = '0 produk dipilih';
                updatePaymentState(0);
                return;
            }

            let html = '';
            let total = 0;
            let totalQty = 0;

            cart.forEach((item, index) => {
                let subtotal = item.harga * item.qty;
                total += subtotal;
                totalQty += item.qty;

                html += `
                <div class="cart-item-row">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <span class="fw-semibold text-white small">${item.nama}</span>
                        <span class="font-monospace small text-white">Rp ${subtotal.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted x-small">Rp ${item.harga.toLocaleString('id-ID')} x ${item.qty}</span>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn-qty" onclick="updateQty(${item.id}, -1)">-</button>
                            <span class="small text-white fw-bold">${item.qty}</span>
                            <button type="button" class="btn-qty" onclick="updateQty(${item.id}, 1)">+</button>
                        </div>
                    </div>
                    <input type="hidden" name="items[${index}][produk_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                    <input type="hidden" name="items[${index}][subtotal]" value="${subtotal}">
                </div>
            `;
            });

            cartList.innerHTML = html;
            totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('cartCount').innerText = `${totalQty} produk dipilih`;
            updatePaymentState(total);
        }

        function updatePaymentState(total) {
            const paymentInput = document.getElementById('uangDibayar');
            const changeDisplay = document.getElementById('changeDisplay');
            const paymentWarning = document.getElementById('paymentWarning');
            const btnSubmit = document.getElementById('btnSubmit');
            const isCash = metodePembayaran.value === 'CASH';
            const amount = isCash ? Number(paymentInput.value || 0) : total;
            const change = Math.max(amount - total, 0);

            paymentInput.disabled = !isCash || total === 0;
            if (!isCash && total > 0) paymentInput.value = total;
            changeDisplay.innerText = 'Rp ' + change.toLocaleString('id-ID');
            paymentWarning.hidden = !isCash || total === 0 || amount >= total;
            btnSubmit.disabled = total === 0 || (isCash && amount < total);
        }

        // Filter Pencarian Realtime
        document.getElementById('inputSearch').addEventListener('input', function(e) {
            const keyword = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.product-item');

            items.forEach(item => {
                const nama = item.getAttribute('data-nama');
                if (nama.includes(keyword)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        const metodePembayaran = document.getElementById('metodePembayaran');
        const qrisPanel = document.getElementById('qrisPanel');
        const uangDibayar = document.getElementById('uangDibayar');

        function toggleQrisPanel() {
            qrisPanel.style.display = metodePembayaran.value === 'QRIS' ? 'block' : 'none';
            updatePaymentState(cart.reduce((total, item) => total + (item.harga * item.qty), 0));
        }

        metodePembayaran.addEventListener('change', toggleQrisPanel);
        uangDibayar.addEventListener('input', () => {
            updatePaymentState(cart.reduce((total, item) => total + (item.harga * item.qty), 0));
        });
        toggleQrisPanel();
    </script>

@endsection
