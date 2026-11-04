@extends('layouts.app')

@section('title', $produk->merek . ' ' . $produk->model)

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('katalog.index') }}">&larr; Kembali ke katalog</a>
    </div>

    <div class="detail-layout">
        <div class="detail-thumb">📱</div>

        <div class="detail-info">
            <span class="merek">{{ $produk->merek }}</span>
            <h1>{{ $produk->merek }} {{ $produk->model }}</h1>

            <div class="badges">
                <span class="badge badge-status-{{ \Illuminate\Support\Str::slug($produk->status) }}">{{ $produk->status }}</span>
                <span class="badge">{{ $produk->kondisi }}</span>
                @if ($produk->warna)
                    <span class="badge">{{ $produk->warna }}</span>
                @endif
                @if ($produk->kelengkapan)
                    <span class="badge">{{ $produk->kelengkapan }}</span>
                @endif
            </div>

            <div class="harga">Rp{{ number_format($produk->harga, 0, ',', '.') }}</div>

            <table class="spec-table">
                <tr>
                    <td>Spesifikasi</td>
                    <td>{{ $produk->spesifikasi ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Warna</td>
                    <td>{{ $produk->warna ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Kondisi</td>
                    <td>{{ $produk->kondisi }}</td>
                </tr>
                <tr>
                    <td>Kelengkapan</td>
                    <td>{{ $produk->kelengkapan ?? '-' }}</td>
                </tr>
            </table>

            @if ($produk->status !== 'Tersedia')
                <div class="notice">
                    Unit ini sedang <strong>{{ strtolower($produk->status) }}</strong> dan tidak dapat dipesan saat ini.
                </div>
            @else
                <div class="notice">
                    Fitur keranjang &amp; checkout masih dalam pengembangan.
                </div>
            @endif
        </div>
    </div>
@endsection
