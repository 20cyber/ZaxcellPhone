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

    <div class="notice">
        Menu kelola produk &amp; pesanan masih dalam pengembangan.
    </div>
@endsection
