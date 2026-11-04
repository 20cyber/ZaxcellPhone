@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h1 class="page-title">Dashboard Admin</h1>
    <p class="page-subtitle">Halo, {{ auth()->user()->name }} &middot; selamat datang kembali.</p>

    <div class="stat-grid">
        <div class="stat-card">
            <span class="stat-label">Total Produk</span>
            <span class="stat-value">{{ $jumlahProduk }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Unit Tersedia</span>
            <span class="stat-value">{{ $jumlahTersedia }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">Pesanan Menunggu Pembayaran</span>
            <span class="stat-value">{{ $jumlahPesananMasuk }}</span>
        </div>
    </div>

    <div class="toolbar" style="margin-top:24px;">
        <a href="{{ route('admin.produk.index') }}" class="btn">Kelola Produk</a>
        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline">Kelola Pesanan</a>
        <a href="{{ route('admin.akun.index') }}" class="btn btn-outline">Akun Admin</a>
    </div>
@endsection
