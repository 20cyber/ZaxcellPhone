@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan')

@section('content')
    <div class="confirm-box">
        <div class="icon">✅</div>
        <h1 class="page-title" style="margin-bottom:4px;">Pembayaran Berhasil</h1>
        <p class="page-subtitle" style="margin-bottom:0;">
            Pesanan #{{ $pesanan->id_pesanan }} atas nama {{ $pesanan->pembeli->nama }} sudah kami terima.
        </p>
    </div>

    <div class="form-card" style="max-width:none;">
        <h2 style="font-size:16px; margin:0 0 12px;">Detail Pesanan</h2>
        <table class="spec-table">
            @foreach ($pesanan->detailPesanan as $detail)
                <tr>
                    <td>{{ $detail->produk->merek }} {{ $detail->produk->model }}</td>
                    <td>Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Status Pesanan</td>
                <td><span class="badge badge-status-{{ \Illuminate\Support\Str::slug($pesanan->status_pesanan) }}">{{ $pesanan->status_pesanan }}</span></td>
            </tr>
            <tr>
                <td>Dikirim ke</td>
                <td>{{ $pesanan->pembeli->nama }} &middot; {{ $pesanan->pembeli->nomor_hp }}<br>{{ $pesanan->pembeli->alamat }}</td>
            </tr>
        </table>

        <div class="cart-summary">
            <span>Total Dibayar</span>
            <span class="harga">Rp{{ number_format($pesanan->total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('katalog.index') }}" class="btn">Kembali ke Katalog</a>
    </div>
@endsection
