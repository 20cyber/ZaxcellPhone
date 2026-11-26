@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="breadcrumb">Admin &rsaquo; Dashboard</div>

    <h1 class="page-title">Dashboard Overview</h1>
    <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name }}! Berikut ringkasan aktivitas toko.</p>

    <div class="dash-stats">
        <div class="dash-stat">
            <span class="label">Total Produk</span>
            <span class="value">{{ $jumlahProduk }}</span>
        </div>
        <div class="dash-stat">
            <span class="label">Unit Tersedia</span>
            <span class="value">{{ $jumlahTersedia }}</span>
        </div>
        <div class="dash-stat">
            <span class="label">Unit Terjual</span>
            <span class="value">{{ $jumlahTerjual }}</span>
        </div>
        <div class="dash-stat">
            <span class="label">Menunggu Pembayaran</span>
            <span class="value">{{ $jumlahPesananMasuk }}</span>
        </div>
    </div>

    <div class="dash-grid">
        <div class="panel pad">
            <h3>Pesanan Terbaru</h3>
            @forelse ($pesananTerbaru as $item)
                <div class="order-row">
                    <div>
                        <a href="{{ route('admin.pesanan.show', $item) }}" class="who">#{{ $item->id_pesanan }} &middot; {{ $item->pembeli?->nama ?? 'Pembeli' }}</a>
                        <span class="sub">Rp{{ number_format($item->total, 0, ',', '.') }} &middot; {{ $item->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>
                    <span class="badge badge-status-{{ \Illuminate\Support\Str::slug($item->status_pesanan) }}">{{ $item->status_pesanan }}</span>
                </div>
            @empty
                <p style="color:var(--muted); font-size:14px;">Belum ada pesanan.</p>
            @endforelse
        </div>

        <div class="panel pad">
            <h3>Akses Cepat</h3>
            <div class="quick-grid">
                <a href="{{ route('admin.produk.create') }}" class="quick-item">Tambah Produk</a>
                <a href="{{ route('admin.pesanan.index') }}" class="quick-item">Kelola Pesanan</a>
                <a href="{{ route('admin.produk.index') }}" class="quick-item">Kelola Produk</a>
                <a href="{{ route('admin.akun.index') }}" class="quick-item">Akun Admin</a>
            </div>
        </div>
    </div>
@endsection
