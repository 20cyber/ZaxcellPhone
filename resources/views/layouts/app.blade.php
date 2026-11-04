<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Zaxcellphone') &mdash; Toko HP Second Yogyakarta</title>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --ink: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8fafc;
            --card: #ffffff;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }
        a { color: inherit; text-decoration: none; }
        .site-header {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 16px 24px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .site-header .inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-dark);
        }
        .brand span { color: var(--ink); font-weight: 400; font-size: 13px; display: block; }
        main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 64px;
        }
        .page-title { font-size: 26px; font-weight: 700; margin-bottom: 4px; }
        .page-subtitle { color: var(--muted); margin-bottom: 24px; font-size: 14px; }

        .filter-bar {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: end;
        }
        .filter-bar .field { display: flex; flex-direction: column; gap: 4px; }
        .filter-bar label { font-size: 12px; color: var(--muted); font-weight: 600; }
        .filter-bar input, .filter-bar select {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 14px;
            min-width: 140px;
        }
        .btn {
            display: inline-block;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 18px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn:hover { background: var(--primary-dark); }
        .btn-outline {
            background: transparent;
            color: var(--primary-dark);
            border: 1px solid var(--primary);
        }
        .btn-outline:hover { background: #eff6ff; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow .15s, transform .15s;
        }
        .card:hover { box-shadow: 0 8px 20px rgba(15, 23, 42, .08); transform: translateY(-2px); }
        .card .thumb {
            aspect-ratio: 1 / 1;
            background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }
        .card .body { padding: 14px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
        .card .merek { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: .04em; }
        .card .model { font-size: 16px; font-weight: 700; }
        .card .harga { font-size: 17px; font-weight: 700; color: var(--primary-dark); margin-top: auto; }
        .badges { display: flex; flex-wrap: wrap; gap: 6px; }
        .badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 999px;
            background: #f1f5f9;
            color: var(--muted);
        }
        .badge-status-tersedia { background: #dcfce7; color: var(--success); }
        .badge-status-ditahan { background: #fef3c7; color: var(--warning); }
        .badge-status-terjual { background: #fee2e2; color: var(--danger); }
        .badge-status-menunggu-pembayaran { background: #fef3c7; color: var(--warning); }
        .badge-status-dibayar, .badge-status-diproses, .badge-status-dikirim { background: #dbeafe; color: #1d4ed8; }
        .badge-status-selesai { background: #dcfce7; color: var(--success); }
        .badge-status-dibatalkan { background: #fee2e2; color: var(--danger); }

        .empty-state {
            text-align: center;
            padding: 64px 24px;
            color: var(--muted);
            background: var(--card);
            border: 1px dashed var(--border);
            border-radius: 12px;
        }

        .pagination-wrap { margin-top: 32px; display: flex; justify-content: center; }
        .pagination-wrap nav { display: flex; }
        .pagination-wrap ul, .pagination-wrap span[aria-current] { list-style: none; display: flex; gap: 4px; padding: 0; margin: 0; }
        .pagination-wrap a, .pagination-wrap span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            background: var(--card);
        }
        .pagination-wrap a:hover { background: #eff6ff; }

        .breadcrumb { font-size: 13px; color: var(--muted); margin-bottom: 20px; }
        .breadcrumb a { color: var(--primary-dark); }

        .detail-layout { display: grid; grid-template-columns: 360px 1fr; gap: 32px; }
        @media (max-width: 760px) { .detail-layout { grid-template-columns: 1fr; } }
        .detail-thumb {
            aspect-ratio: 1 / 1;
            background: linear-gradient(135deg, #e2e8f0, #f1f5f9);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 96px;
        }
        .detail-info h1 { font-size: 24px; margin: 0 0 4px; }
        .detail-info .merek { color: var(--muted); font-size: 14px; margin-bottom: 12px; }
        .detail-info .harga { font-size: 28px; font-weight: 700; color: var(--primary-dark); margin: 12px 0; }
        .spec-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .spec-table td { padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 14px; }
        .spec-table td:first-child { color: var(--muted); width: 160px; }
        .notice {
            margin-top: 20px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }
        .notice-danger { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

        .nav-actions { display: flex; align-items: center; gap: 12px; font-size: 14px; }
        .nav-actions form { margin: 0; }
        .nav-actions button {
            background: none;
            border: none;
            color: var(--muted);
            font: inherit;
            cursor: pointer;
            padding: 0;
        }
        .nav-actions button:hover { color: var(--danger); }

        .auth-wrap { display: flex; justify-content: center; padding-top: 24px; }
        .auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 32px;
            width: 100%;
            max-width: 360px;
        }
        .auth-form { display: flex; flex-direction: column; gap: 14px; margin-top: 16px; }
        .auth-form .field { display: flex; flex-direction: column; gap: 4px; }
        .auth-form label { font-size: 13px; font-weight: 600; color: var(--ink); }
        .auth-form input[type=email], .auth-form input[type=password] {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
        }
        .checkbox-field { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted); }
        .back-link { display: block; text-align: center; margin-top: 18px; font-size: 13px; color: var(--primary-dark); }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-top: 8px; }
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px;
        }
        .stat-label { display: block; font-size: 13px; color: var(--muted); margin-bottom: 6px; }
        .stat-value { font-size: 28px; font-weight: 700; color: var(--ink); }

        .toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .alert { padding: 12px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 16px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        table.data-table { width: 100%; border-collapse: collapse; background: var(--card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        table.data-table th, table.data-table td { padding: 10px 14px; text-align: left; font-size: 13px; border-bottom: 1px solid var(--border); }
        table.data-table th { background: #f1f5f9; color: var(--muted); font-weight: 600; }
        table.data-table tr:last-child td { border-bottom: none; }
        table.data-table .thumb-cell img, table.data-table .thumb-cell .ph { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; }
        table.data-table .ph { display: flex; align-items: center; justify-content: center; background: #f1f5f9; font-size: 18px; }
        .row-actions { display: flex; gap: 10px; align-items: center; }
        .row-actions a { color: var(--primary-dark); }
        .row-actions button { background: none; border: none; color: var(--danger); font: inherit; cursor: pointer; padding: 0; }
        .stok-form { display: flex; gap: 6px; align-items: center; }
        .stok-form input { width: 56px; border: 1px solid var(--border); border-radius: 6px; padding: 4px 6px; font-size: 13px; }
        .stok-form button { border: 1px solid var(--border); background: var(--card); border-radius: 6px; padding: 4px 8px; font-size: 12px; cursor: pointer; }

        .form-card { background: var(--card); border: 1px solid var(--border); border-radius: 12px; padding: 24px; max-width: 600px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid .full { grid-column: 1 / -1; }
        .form-field { display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
        .form-field label { font-size: 13px; font-weight: 600; }
        .form-field input, .form-field select, .form-field textarea {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 14px;
            font-family: inherit;
        }
        .form-field .error { color: var(--danger); font-size: 12px; }
        .form-actions { display: flex; gap: 10px; margin-top: 8px; }
        .current-photo { width: 90px; height: 90px; border-radius: 8px; object-fit: cover; margin-bottom: 8px; display: block; }

        .cart-badge {
            background: var(--primary);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            border-radius: 999px;
            padding: 1px 6px;
            margin-left: 4px;
        }
        .cart-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            margin-top: 16px;
            font-weight: 600;
        }
        .cart-summary .harga { font-size: 20px; color: var(--primary-dark); }

        .sim-banner {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
            color: #3730a3;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 20px;
        }
        .pay-actions { display: flex; gap: 12px; margin-top: 20px; }
        .btn-success { background: var(--success); }
        .btn-success:hover { background: #15803d; }
        .btn-danger { background: var(--danger); }
        .btn-danger:hover { background: #b91c1c; }

        .confirm-box {
            text-align: center;
            padding: 32px 24px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: 24px;
        }
        .confirm-box .icon { font-size: 48px; margin-bottom: 8px; }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="inner">
            <a href="{{ route('katalog.index') }}" class="brand">
                Zaxcellphone
                <span>Toko HP Second &middot; Yogyakarta</span>
            </a>

            <div class="nav-actions">
                @auth
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('cart.index') }}">
                        Keranjang
                        @if (\App\Support\Cart::count() > 0)
                            <span class="cart-badge">{{ \App\Support\Cart::count() }}</span>
                        @endif
                    </a>
                    <a href="{{ route('login') }}">Login Admin</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
