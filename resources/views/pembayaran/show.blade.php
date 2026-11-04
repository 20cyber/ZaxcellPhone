@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
    <div class="sim-banner">
        Mode simulasi &mdash; payment gateway (Midtrans/Xendit) belum diintegrasikan. Tombol di bawah ini hanya untuk
        mensimulasikan notifikasi pembayaran dari gateway (FS-01).
    </div>

    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <h1 class="page-title">Pembayaran Pesanan #{{ $pesanan->id_pesanan }}</h1>
    <p class="page-subtitle">
        Kode transaksi: {{ $pembayaran->order_id_gateway }} &middot;
        Bayar sebelum {{ $pesanan->batas_bayar->translatedFormat('d M Y, H:i') }}
    </p>

    <div class="form-card" style="max-width:none;">
        <table class="spec-table">
            @foreach ($pesanan->detailPesanan as $detail)
                <tr>
                    <td>{{ $detail->produk->merek }} {{ $detail->produk->model }}</td>
                    <td>Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>

        <div class="cart-summary">
            <span>Total Bayar</span>
            <span class="harga">Rp{{ number_format($pesanan->total, 0, ',', '.') }}</span>
        </div>

        <div class="pay-actions">
            <form method="POST" action="{{ route('pembayaran.notifikasi', $pesanan) }}">
                @csrf
                <input type="hidden" name="hasil" value="berhasil">
                <button type="submit" class="btn btn-success">Simulasikan Pembayaran Berhasil</button>
            </form>
            <form method="POST" action="{{ route('pembayaran.notifikasi', $pesanan) }}">
                @csrf
                <input type="hidden" name="hasil" value="gagal">
                <button type="submit" class="btn btn-danger">Simulasikan Pembayaran Gagal</button>
            </form>
        </div>
    </div>
@endsection
