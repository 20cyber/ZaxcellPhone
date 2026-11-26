@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('katalog.index') }}">Beranda</a> &rsaquo; Keranjang
    </div>

    <h1 class="page-title">Keranjang Belanja</h1>
    <p class="page-subtitle">Periksa kembali unit pilihanmu sebelum checkout.</p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if ($items->isEmpty())
        <div class="empty-state">
            <p>Keranjang kamu masih kosong.</p>
            <p style="margin-top:12px;"><a href="{{ route('katalog.index') }}" class="btn">Lihat Katalog</a></p>
        </div>
    @else
        <div class="cart-layout">
            <div class="panel">
                @foreach ($items as $item)
                    <div class="cart-row">
                        <div class="cart-thumb">
                            @if ($item->foto)
                                <img src="{{ Storage::url($item->foto) }}" alt="">
                            @else
                                📱
                            @endif
                        </div>
                        <div class="cart-info">
                            <a href="{{ route('katalog.show', $item) }}" class="nama">{{ $item->merek }} {{ $item->model }}</a>
                            <span class="sub">{{ $item->kondisi }}@if ($item->warna) &middot; {{ $item->warna }}@endif</span>
                        </div>
                        <span class="cart-price">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                        <form method="POST" action="{{ route('cart.destroy', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="remove-btn" title="Hapus dari keranjang" aria-label="Hapus dari keranjang">&times;</button>
                        </form>
                    </div>
                @endforeach
                <a href="{{ route('katalog.index') }}" class="panel-link">&larr; Tambah unit lainnya</a>
            </div>

            <aside class="panel pad">
                <h3>Ringkasan Pesanan</h3>
                <div class="sum-row"><span>Total unit</span><span>{{ $items->count() }}</span></div>
                <div class="sum-total">
                    <span>Subtotal</span>
                    <span class="harga">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout.create') }}" class="btn btn-block">Lanjut ke Checkout &rarr;</a>
                <div class="info-box">
                    Unit akan ditahan untukmu setelah checkout. Selesaikan pembayaran sebelum batas waktu yang tertera.
                </div>
            </aside>
        </div>
    @endif
@endsection
