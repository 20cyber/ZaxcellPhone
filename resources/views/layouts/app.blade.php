<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Zaxcellphone') &mdash; Toko HP Second Yogyakarta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #075985;
            --accent: #06b6d4;
            --accent2: #22c55e;
            --grad: linear-gradient(135deg, #0f172a 0%, #0369a1 55%, #06b6d4 100%);
            --ink: #0f172a;
            --muted: #5b6b85;
            --border: #dbe4f0;
            --bg: #f3f7fb;
            --card: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            background-image: radial-gradient(circle at 10% -10%, rgba(6, 182, 212, .08), transparent 40%),
                radial-gradient(circle at 90% 0%, rgba(2, 132, 199, .1), transparent 40%);
            color: var(--ink);
        }
        a { color: inherit; text-decoration: none; }
        .site-header {
            background: var(--grad);
            padding: 18px 24px;
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 4px 24px rgba(3, 105, 161, .25);
        }
        .site-header .inner {
            max-width: 1100px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand {
            font-size: 21px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.01em;
        }
        .brand span { color: rgba(255,255,255,.85); font-weight: 500; font-size: 12.5px; display: block; }
        main {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 64px;
        }
        .page-title { font-size: 27px; font-weight: 800; margin-bottom: 4px; letter-spacing: -.02em; }
        .page-subtitle { color: var(--muted); margin-bottom: 24px; font-size: 14px; }

        .filter-bar {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: end;
            box-shadow: 0 2px 10px rgba(3, 105, 161, .05);
        }
        .filter-bar .field { display: flex; flex-direction: column; gap: 4px; }
        .filter-bar label { font-size: 12px; color: var(--muted); font-weight: 700; }
        .filter-bar input, .filter-bar select {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 14px;
            min-width: 140px;
            font-family: inherit;
            background: #fcfbff;
        }
        .filter-bar input:focus, .filter-bar select:focus { outline: none; border-color: var(--primary); }
        .btn {
            display: inline-block;
            background: var(--grad);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(124, 58, 237, .3);
            transition: transform .12s, box-shadow .12s;
            font-family: inherit;
        }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(124, 58, 237, .4); }
        .btn-outline {
            background: #fff;
            color: var(--primary-dark);
            border: 1.5px solid var(--primary);
            box-shadow: none;
        }
        .btn-outline:hover { background: #e0f2fe; transform: none; box-shadow: none; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow .15s, transform .15s;
            box-shadow: 0 2px 10px rgba(3, 105, 161, .06);
        }
        .card:hover { box-shadow: 0 14px 28px rgba(3, 105, 161, .16); transform: translateY(-3px); }
        .card .thumb {
            aspect-ratio: 1 / 1;
            background: linear-gradient(135deg, #bae6fd, #7dd3fc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }
        .card:nth-child(6n+2) .thumb { background: linear-gradient(135deg, #a5f3fc, #67e8f9); }
        .card:nth-child(6n+3) .thumb { background: linear-gradient(135deg, #cbd5e1, #94a3b8); }
        .card:nth-child(6n+4) .thumb { background: linear-gradient(135deg, #99f6e4, #5eead4); }
        .card:nth-child(6n+5) .thumb { background: linear-gradient(135deg, #bfdbfe, #93c5fd); }
        .card:nth-child(6n+6) .thumb { background: linear-gradient(135deg, #c4ddf5, #8fb8e8); }
        .card .body { padding: 14px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
        .card .merek { font-size: 11.5px; color: var(--primary-dark); font-weight: 700; text-transform: uppercase; letter-spacing: .05em; }
        .card .model { font-size: 16px; font-weight: 700; }
        .card .harga { font-size: 17px; font-weight: 800; color: var(--primary-dark); margin-top: auto; }
        .badges { display: flex; flex-wrap: wrap; gap: 6px; }
        .badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 999px;
            background: #e0f2fe;
            color: var(--primary-dark);
        }
        .badge-status-tersedia { background: #d1fae5; color: #047857; }
        .badge-status-ditahan { background: #fef3c7; color: #b45309; }
        .badge-status-terjual { background: #fee2e2; color: #b91c1c; }
        .badge-status-menunggu-pembayaran { background: #fef3c7; color: #b45309; }
        .badge-status-dibayar, .badge-status-diproses, .badge-status-dikirim { background: #dbeafe; color: #1d4ed8; }
        .badge-status-selesai { background: #d1fae5; color: #047857; }
        .badge-status-dibatalkan { background: #fee2e2; color: #b91c1c; }

        .empty-state {
            text-align: center;
            padding: 64px 24px;
            color: var(--muted);
            background: var(--card);
            border: 1.5px dashed var(--border);
            border-radius: 18px;
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
            border-radius: 10px;
            font-size: 13px;
            background: var(--card);
            font-weight: 600;
        }
        .pagination-wrap a:hover { background: #e0f2fe; border-color: var(--primary); }

        .breadcrumb { font-size: 13px; color: var(--muted); margin-bottom: 20px; }
        .breadcrumb a { color: var(--primary-dark); font-weight: 600; }

        .detail-layout { display: grid; grid-template-columns: 360px 1fr; gap: 32px; }
        @media (max-width: 760px) { .detail-layout { grid-template-columns: 1fr; } }
        .detail-thumb {
            aspect-ratio: 1 / 1;
            background: var(--grad);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 96px;
            box-shadow: 0 16px 32px rgba(3, 105, 161, .25);
        }
        .detail-info h1 { font-size: 25px; margin: 0 0 4px; letter-spacing: -.02em; }
        .detail-info .merek { color: var(--primary-dark); font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 12px; }
        .detail-info .harga { font-size: 29px; font-weight: 800; color: var(--primary-dark); margin: 12px 0; }
        .spec-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .spec-table td { padding: 10px 0; border-bottom: 1px solid var(--border); font-size: 14px; }
        .spec-table td:first-child { color: var(--muted); width: 160px; font-weight: 600; }
        .notice {
            margin-top: 20px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }
        .notice-danger { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

        .nav-actions { display: flex; align-items: center; gap: 16px; font-size: 14px; }
        .nav-actions a { color: #fff; font-weight: 600; }
        .nav-actions form { margin: 0; }
        .nav-actions button {
            background: none;
            border: none;
            color: rgba(255,255,255,.85);
            font: inherit;
            font-weight: 600;
            cursor: pointer;
            padding: 0;
        }
        .nav-actions button:hover { color: #fff; }

        .auth-wrap { display: flex; justify-content: center; padding-top: 24px; }
        .auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 10px 30px rgba(3, 105, 161, .1);
        }
        .auth-form { display: flex; flex-direction: column; gap: 14px; margin-top: 16px; }
        .auth-form .field { display: flex; flex-direction: column; gap: 4px; }
        .auth-form label { font-size: 13px; font-weight: 700; color: var(--ink); }
        .auth-form input[type=email], .auth-form input[type=password] {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            font-family: inherit;
        }
        .auth-form input:focus { outline: none; border-color: var(--primary); }
        .checkbox-field { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted); }
        .back-link { display: block; text-align: center; margin-top: 18px; font-size: 13px; color: var(--primary-dark); font-weight: 600; }

        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-top: 8px; }
        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-left: 4px solid var(--primary);
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 2px 10px rgba(3, 105, 161, .06);
        }
        .stat-card:nth-child(2) { border-left-color: var(--accent2); }
        .stat-card:nth-child(3) { border-left-color: var(--accent); }
        .stat-label { display: block; font-size: 13px; color: var(--muted); margin-bottom: 6px; font-weight: 600; }
        .stat-value { font-size: 30px; font-weight: 800; color: var(--ink); }

        .toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .alert { padding: 12px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; font-weight: 600; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        table.data-table { width: 100%; border-collapse: collapse; background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 10px rgba(3, 105, 161, .06); }
        table.data-table th, table.data-table td { padding: 10px 14px; text-align: left; font-size: 13px; border-bottom: 1px solid var(--border); }
        table.data-table th { background: #eaf4fb; color: var(--primary-dark); font-weight: 700; }
        table.data-table tr:last-child td { border-bottom: none; }
        table.data-table tr:hover td { background: #fbfaff; }
        table.data-table .thumb-cell img, table.data-table .thumb-cell .ph { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; }
        table.data-table .ph { display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #dbeafe, #cffafe); font-size: 18px; }
        .row-actions { display: flex; gap: 10px; align-items: center; }
        .row-actions a { color: var(--primary-dark); font-weight: 700; }
        .row-actions button { background: none; border: none; color: var(--danger); font: inherit; font-weight: 700; cursor: pointer; padding: 0; }
        .stok-form { display: flex; gap: 6px; align-items: center; }
        .stok-form input { width: 56px; border: 1.5px solid var(--border); border-radius: 8px; padding: 4px 6px; font-size: 13px; }
        .stok-form button { border: none; background: var(--primary); color: #fff; border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer; }

        .form-card { background: var(--card); border: 1px solid var(--border); border-radius: 18px; padding: 24px; max-width: 600px; box-shadow: 0 2px 10px rgba(3, 105, 161, .06); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid .full { grid-column: 1 / -1; }
        .form-field { display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
        .form-field label { font-size: 13px; font-weight: 700; }
        .form-field input, .form-field select, .form-field textarea {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 9px 12px;
            font-size: 14px;
            font-family: inherit;
        }
        .form-field input:focus, .form-field select:focus, .form-field textarea:focus { outline: none; border-color: var(--primary); }
        .form-field .error { color: var(--danger); font-size: 12px; font-weight: 600; }
        .form-actions { display: flex; gap: 10px; margin-top: 8px; }
        .current-photo { width: 90px; height: 90px; border-radius: 10px; object-fit: cover; margin-bottom: 8px; display: block; }

        .cart-badge {
            background: var(--accent);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
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
            border-radius: 16px;
            padding: 16px 20px;
            margin-top: 16px;
            font-weight: 700;
            box-shadow: 0 2px 10px rgba(3, 105, 161, .06);
        }
        .cart-summary .harga { font-size: 21px; color: var(--primary-dark); }

        .sim-banner {
            background: #e0f2fe;
            border: 1px solid #7dd3fc;
            color: #075985;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .pay-actions { display: flex; gap: 12px; margin-top: 20px; }
        .btn-success { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 14px rgba(16, 185, 129, .35); }
        .btn-success:hover { box-shadow: 0 6px 18px rgba(16, 185, 129, .45); }
        .btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 14px rgba(239, 68, 68, .35); }
        .btn-danger:hover { box-shadow: 0 6px 18px rgba(239, 68, 68, .45); }

        .confirm-box {
            text-align: center;
            padding: 36px 24px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(3, 105, 161, .1);
        }
        .confirm-box .icon { font-size: 52px; margin-bottom: 8px; }
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
