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
        /* Palet mengikuti desain Figma: putih, oranye, navy */
        :root {
            --primary: #e2804a;
            --primary-dark: #c8622b;
            --accent: #f0a46f;
            --accent2: #2f8f5b;
            --grad: #e2804a;
            --ink: #1a2238;
            --muted: #6e7385;
            --border: #ece9ee;
            --bg: #ffffff;
            --card: #ffffff;
            --field: #f7f5f8;
            --peach: #fdeee4;
            --navy: #161e33;
            --success: #2f8f5b;
            --warning: #b7791f;
            --danger: #c0392b;
            --info: #3b6fd4;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background: var(--bg);
            color: var(--ink);
        }
        a { color: inherit; text-decoration: none; }
        main {
            max-width: 1200px;
            width: 100%;
            flex: 1;
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
            box-shadow: 0 2px 10px rgba(26, 34, 56, .06);
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
            background: var(--field);
            color: var(--ink);
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
            box-shadow: 0 4px 14px rgba(226, 128, 74, .28);
            transition: transform .12s, box-shadow .12s;
            font-family: inherit;
        }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(226, 128, 74, .36); }
        .btn-outline {
            background: transparent;
            color: var(--primary-dark);
            border: 1.5px solid var(--primary);
            box-shadow: none;
        }
        .btn-outline:hover { background: rgba(226, 128, 74, .10); transform: none; box-shadow: none; }

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
            box-shadow: 0 2px 10px rgba(26, 34, 56, .06);
        }
        .card:hover { box-shadow: 0 14px 28px rgba(26, 34, 56, .06); transform: translateY(-3px); }
        .card .thumb {
            aspect-ratio: 1 / 1;
            background: linear-gradient(135deg, #f6f4f7, #ebe8ee);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
        }
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
            background: var(--field);
            color: var(--ink);
        }
        .badge-status-tersedia { background: #e6f4ea; color: #2f8f5b; }
        .badge-status-ditahan { background: #fdf1dc; color: #b7791f; }
        .badge-status-terjual { background: #fde8e8; color: #c0392b; }
        .badge-status-menunggu-pembayaran { background: #fdf1dc; color: #b7791f; }
        .badge-status-dibayar { background: #e8f0fe; color: #3b6fd4; }
        .badge-status-diproses, .badge-status-dikirim { background: #e6f4ea; color: #2f8f5b; }
        .badge-status-selesai { background: #e6f4ea; color: #2f8f5b; }
        .badge-status-dibatalkan { background: #fde8e8; color: #c0392b; }

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
        .pagination-wrap a:hover { background: rgba(226, 128, 74, .10); border-color: var(--primary); }

        .breadcrumb { font-size: 13px; color: var(--muted); margin-bottom: 20px; }
        .breadcrumb a { color: var(--primary-dark); font-weight: 600; }

        .detail-layout { display: grid; grid-template-columns: 360px 1fr; gap: 32px; }
        @media (max-width: 760px) { .detail-layout { grid-template-columns: 1fr; } }
        .detail-thumb {
            aspect-ratio: 1 / 1;
            background: var(--field);
            border-radius: 22px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 96px;
            box-shadow: none;
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
            background: #fdf1dc;
            color: #b7791f;
            border: 1px solid #f3dcae;
        }
        .notice-danger { background: #fde8e8; color: #c0392b; border-color: #f5c2c2; }


        .auth-wrap { display: flex; justify-content: center; padding-top: 24px; }
        .auth-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 10px 30px rgba(26, 34, 56, .06);
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
            background: var(--field);
            color: var(--ink);
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
            box-shadow: 0 2px 10px rgba(26, 34, 56, .06);
        }
        .stat-card:nth-child(2) { border-left-color: var(--accent2); }
        .stat-card:nth-child(3) { border-left-color: var(--accent); }
        .stat-label { display: block; font-size: 13px; color: var(--muted); margin-bottom: 6px; font-weight: 600; }
        .stat-value { font-size: 30px; font-weight: 800; color: var(--ink); }

        .toolbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .alert { padding: 12px 14px; border-radius: 10px; font-size: 13px; margin-bottom: 16px; font-weight: 600; }
        .alert-success { background: #e6f4ea; color: #2f8f5b; border: 1px solid #bfe3cc; }
        .alert-error { background: #fde8e8; color: #c0392b; border: 1px solid #f5c2c2; }

        table.data-table { width: 100%; border-collapse: collapse; background: var(--card); border: 1px solid var(--border); border-radius: 16px; overflow: hidden; box-shadow: 0 2px 10px rgba(26, 34, 56, .06); }
        table.data-table th, table.data-table td { padding: 10px 14px; text-align: left; font-size: 13px; border-bottom: 1px solid var(--border); }
        table.data-table th { background: var(--field); color: var(--primary-dark); font-weight: 700; }
        table.data-table tr:last-child td { border-bottom: none; }
        table.data-table tr:hover td { background: rgba(226, 128, 74, .05); }
        table.data-table .thumb-cell img, table.data-table .thumb-cell .ph { width: 40px; height: 40px; border-radius: 10px; object-fit: cover; }
        table.data-table .ph { display: flex; align-items: center; justify-content: center; background: var(--peach); font-size: 18px; }
        .row-actions { display: flex; gap: 10px; align-items: center; }
        .row-actions a { color: var(--primary-dark); font-weight: 700; }
        .row-actions button { background: none; border: none; color: var(--danger); font: inherit; font-weight: 700; cursor: pointer; padding: 0; }
        .stok-form { display: flex; gap: 6px; align-items: center; }
        .stok-form input { width: 56px; border: 1.5px solid var(--border); border-radius: 8px; padding: 4px 6px; font-size: 13px; background: var(--field); color: var(--ink); }
        .stok-form button { border: none; background: var(--primary); color: #fff; border-radius: 8px; padding: 4px 10px; font-size: 12px; font-weight: 700; cursor: pointer; }

        .form-card { background: var(--card); border: 1px solid var(--border); border-radius: 18px; padding: 24px; max-width: 600px; box-shadow: 0 2px 10px rgba(26, 34, 56, .06); }
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
            background: var(--field);
            color: var(--ink);
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
            box-shadow: 0 2px 10px rgba(26, 34, 56, .06);
        }
        .cart-summary .harga { font-size: 21px; color: var(--primary-dark); }

        .sim-banner {
            background: var(--peach);
            border: 1px solid #f6d5c0;
            color: var(--primary-dark);
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
        .btn:disabled { opacity: .4; cursor: not-allowed; box-shadow: none; transform: none; }
        .btn:disabled:hover { transform: none; box-shadow: none; }

        .confirm-box {
            text-align: center;
            padding: 36px 24px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            margin-bottom: 24px;
            box-shadow: 0 10px 30px rgba(26, 34, 56, .06);
        }
        .confirm-box .icon { font-size: 52px; margin-bottom: 8px; }

        .review-row {
            display: flex;
            gap: 16px;
            align-items: flex-start;
            padding: 18px 0;
            border-bottom: 1px solid var(--border);
        }
        .review-row:last-child { border-bottom: none; }
        .review-row .thumb-preview {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid var(--border);
        }
        .review-row .info { flex: 1; min-width: 0; }
        .ai-guess { font-size: 13px; color: var(--muted); margin-bottom: 10px; }
        .ai-guess strong { color: var(--primary-dark); }
        .edit-table input[type=text], .edit-table input[type=number] {
            width: 100%;
            min-width: 90px;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 5px 7px;
            font-size: 12.5px;
            background: var(--field);
            color: var(--ink);
            font-family: inherit;
        }
        .edit-table td { padding: 6px 8px; vertical-align: top; }
        .edit-table th { white-space: nowrap; }
        .edit-table td.col-sertakan { text-align: center; }

        .review-row select {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 14px;
            font-family: inherit;
            background: var(--field);
            color: var(--ink);
            width: 100%;
            max-width: 420px;
        }

        /* ===== Header, navigasi, footer (mengikuti Figma) ===== */
        .site-header {
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .site-header .inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 40px;
        }
        .brand { font-size: 23px; font-weight: 800; color: var(--ink); letter-spacing: -.03em; }
        .main-nav { display: flex; gap: 28px; font-size: 14px; font-weight: 700; flex: 1; }
        .main-nav a { color: #3b4258; padding: 6px 0; border-bottom: 2px solid transparent; }
        .main-nav a:hover { color: var(--primary); }
        .main-nav a.active { color: var(--primary); }
        .nav-actions { display: flex; align-items: center; gap: 14px; font-size: 14px; }
        .nav-actions form { margin: 0; }
        .nav-user { color: var(--muted); font-size: 13px; }
        .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: var(--peach); color: var(--primary-dark);
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 14px;
        }
        .btn-sm { padding: 8px 16px; font-size: 13px; }
        .link-button { background: none; border: none; color: var(--muted); font: inherit; font-weight: 600; cursor: pointer; padding: 0; }
        .link-button:hover { color: var(--primary); }
        .site-footer { background: var(--navy); color: #fff; margin-top: 48px; }
        .site-footer .inner {
            max-width: 1200px; margin: 0 auto; padding: 36px 24px;
            display: flex; justify-content: space-between; align-items: center; gap: 24px; flex-wrap: wrap;
        }
        .site-footer .brand { color: #fff; }
        .site-footer .copy { color: #9aa3b8; font-size: 13px; }

        .eyebrow { font-size: 12px; font-weight: 800; letter-spacing: .06em; color: var(--primary); text-transform: uppercase; }
        .section-head { display: flex; justify-content: space-between; align-items: end; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
        .section-head h2 { font-size: 28px; font-weight: 800; letter-spacing: -.02em; margin: 4px 0; }
        .section-head p { margin: 0; color: var(--muted); font-size: 14px; }

        /* ===== Hero beranda ===== */
        .hero {
            display: grid; grid-template-columns: 1.1fr 1fr; gap: 24px; align-items: center;
            background: linear-gradient(120deg, #fff1e8 0%, #fff8f4 55%, #f8e7dc 100%);
            border-radius: 28px; padding: 56px 56px; margin-bottom: 48px; overflow: hidden;
        }
        .hero h1 { font-size: 52px; line-height: 1.1; font-weight: 800; letter-spacing: -.03em; margin: 14px 0 16px; }
        .hero p { color: var(--muted); font-size: 16px; line-height: 1.7; max-width: 460px; margin: 0 0 24px; }
        .hero .cta { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-lg { padding: 14px 26px; font-size: 15px; border-radius: 12px; }
        .btn-white { background: #fff; color: var(--ink); border: 1px solid var(--border); box-shadow: none; }
        .btn-white:hover { box-shadow: 0 4px 12px rgba(26, 34, 56, .08); }
        .hero-art { position: relative; height: 300px; }
        .hero-phone { position: absolute; width: 150px; height: 260px; border: 7px solid var(--ink); border-radius: 30px; }
        .hero-phone::after { content: ""; position: absolute; left: 10px; top: 50%; width: 22px; height: 22px; border-radius: 50%; background: var(--ink); transform: translateY(-50%); }
        .hero-phone.p1 { left: 8%; top: 0; background: linear-gradient(160deg, #e3e8f1, #aab4c8); }
        .hero-phone.p2 { left: 34%; top: 20px; background: linear-gradient(160deg, #f4b890, #e2804a); }
        .hero-phone.p3 { left: 58%; top: 40px; background: linear-gradient(160deg, #c8dccf, #7b9b8c); }
        .hero-chip { position: absolute; background: #fff; border-radius: 12px; padding: 10px 16px; font-size: 13px; font-weight: 700; box-shadow: 0 6px 18px rgba(26, 34, 56, .08); }
        .hero-chip.c1 { right: 4%; top: 6%; }
        .hero-chip.c2 { left: 0; bottom: 10%; }
        @media (max-width: 860px) { .hero { grid-template-columns: 1fr; padding: 32px 24px; } .hero h1 { font-size: 36px; } .hero-art { display: none; } .main-nav { gap: 16px; } .site-header .inner { gap: 16px; flex-wrap: wrap; } }

        /* ===== Kartu produk (gaya Figma) ===== */
        .card .thumb { position: relative; font-size: 56px; }
        .card .thumb a { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
        .thumb-badge {
            position: absolute; top: 12px; left: 12px; z-index: 1;
            background: #e6f4ea; color: #2f8f5b; font-size: 10.5px; font-weight: 800;
            letter-spacing: .04em; text-transform: uppercase; padding: 5px 10px; border-radius: 8px;
        }
        .card .meta { font-size: 12.5px; color: var(--muted); }
        .card-foot { display: flex; justify-content: space-between; align-items: center; margin-top: 6px; }
        .card-foot .detail-link { color: var(--primary); font-weight: 800; font-size: 14px; }
        .card-foot form { margin: 0; }
        .add-btn {
            width: 36px; height: 36px; border-radius: 10px; border: none; cursor: pointer;
            background: var(--peach); color: var(--primary-dark); font-size: 20px; font-weight: 700; line-height: 1;
        }
        .add-btn:hover { background: var(--primary); color: #fff; }
        .card .harga { color: var(--ink); }

        /* ===== Keranjang dua kolom ===== */
        .cart-layout { display: grid; grid-template-columns: 1fr 360px; gap: 28px; align-items: start; }
        @media (max-width: 860px) { .cart-layout { grid-template-columns: 1fr; } }
        .panel { background: #fff; border: 1px solid var(--border); border-radius: 20px; padding: 8px 24px; }
        .panel.pad { padding: 24px; }
        .panel h3 { font-size: 17px; font-weight: 800; margin: 0 0 16px; }
        .cart-row { display: flex; align-items: center; gap: 18px; padding: 18px 0; border-bottom: 1px solid var(--border); }
        .cart-row:last-of-type { border-bottom: none; }
        .cart-thumb { width: 84px; height: 84px; border-radius: 14px; background: var(--field); display: flex; align-items: center; justify-content: center; font-size: 32px; overflow: hidden; flex-shrink: 0; }
        .cart-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .cart-info { flex: 1; min-width: 0; }
        .cart-info .nama { font-weight: 700; font-size: 16px; display: block; }
        .cart-info .sub { color: var(--muted); font-size: 13px; }
        .cart-price { font-weight: 800; font-size: 16px; }
        .remove-btn { background: none; border: none; color: #a3a8b8; font-size: 22px; cursor: pointer; padding: 4px 8px; }
        .remove-btn:hover { color: var(--danger); }
        .panel-link { display: inline-block; color: var(--primary); font-weight: 800; font-size: 14px; padding: 16px 0; }
        .sum-row { display: flex; justify-content: space-between; font-size: 14px; color: var(--muted); padding: 7px 0; }
        .sum-total { display: flex; justify-content: space-between; align-items: center; font-weight: 800; font-size: 17px; padding: 16px 0; margin-top: 8px; border-top: 1px solid var(--border); }
        .sum-total .harga { color: var(--primary-dark); font-size: 21px; }
        .btn-block { display: block; width: 100%; text-align: center; padding: 14px; font-size: 15px; border-radius: 12px; }
        .info-box { margin-top: 16px; background: var(--peach); color: var(--primary-dark); border-radius: 12px; padding: 12px 14px; font-size: 12.5px; line-height: 1.6; }

        /* ===== Dashboard admin ===== */
        .dash-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 18px; margin-bottom: 24px; }
        .dash-stat { background: #fff; border: 1px solid var(--border); border-radius: 18px; padding: 22px; }
        .dash-stat .label { display: block; font-size: 13px; color: var(--muted); font-weight: 600; margin-bottom: 10px; }
        .dash-stat .value { font-size: 34px; font-weight: 800; letter-spacing: -.02em; }
        .dash-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 24px; align-items: start; }
        @media (max-width: 860px) { .dash-grid { grid-template-columns: 1fr; } }
        .order-row { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 14px 0; border-top: 1px solid var(--border); font-size: 14px; }
        .order-row .who { font-weight: 700; display: block; }
        .order-row .sub { color: var(--muted); font-size: 12.5px; }
        .quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .quick-item { background: var(--field); border-radius: 14px; padding: 20px 16px; font-weight: 700; font-size: 14px; }
        .quick-item:hover { background: var(--peach); color: var(--primary-dark); }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="inner">
            <a href="{{ route('katalog.index') }}" class="brand">zaxcellphone</a>

            <nav class="main-nav">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.produk.index') }}" class="{{ request()->routeIs('admin.produk.*', 'admin.produk-*', 'admin.pricelist-*', 'admin.foto-*') ? 'active' : '' }}">Produk</a>
                    <a href="{{ route('admin.pesanan.index') }}" class="{{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">Pesanan</a>
                    <a href="{{ route('admin.akun.index') }}" class="{{ request()->routeIs('admin.akun.*') ? 'active' : '' }}">Akun</a>
                @else
                    <a href="{{ route('katalog.index') }}" class="{{ request()->routeIs('katalog.*') ? 'active' : '' }}">Katalog</a>
                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        Keranjang
                        @if (\App\Support\Cart::count() > 0)
                            <span class="cart-badge">{{ \App\Support\Cart::count() }}</span>
                        @endif
                    </a>
                @endauth
            </nav>

            <div class="nav-actions">
                @auth
                    <span class="nav-user">{{ auth()->user()->name }}</span>
                    <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="link-button">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm">Login Admin</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="inner">
            <span class="brand">zaxcellphone</span>
            <span class="copy">
                @auth Admin Panel &middot; @endauth
                &copy; {{ date('Y') }} Zaxcellphone &middot; Toko HP Second Yogyakarta
            </span>
        </div>
    </footer>
</body>
</html>
