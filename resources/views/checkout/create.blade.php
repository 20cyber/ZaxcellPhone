@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <h1 class="page-title">Checkout</h1>
    <p class="page-subtitle">Lengkapi data pengiriman sebelum membayar.</p>

    <div class="detail-layout" style="grid-template-columns: 1fr 320px;">
        <div class="form-card" style="max-width:none;">
            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <div class="form-field">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
                    @error('nama') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label for="nomor_hp">Nomor HP</label>
                    <input type="text" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="08xxxxxxxxxx" required>
                    @error('nomor_hp') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label for="alamat">Alamat Pengiriman</label>
                    <textarea id="alamat" name="alamat" rows="4" required>{{ old('alamat') }}</textarea>
                    @error('alamat') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="notice">
                    Unit akan ditahan selama 30 menit untuk menyelesaikan pembayaran. Jika tidak dibayar, pesanan otomatis dibatalkan.
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn">Lanjut ke Pembayaran</button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline">Kembali</a>
                </div>
            </form>
        </div>

        <div>
            <div class="form-card" style="max-width:none;">
                <h2 style="font-size:16px; margin:0 0 12px;">Ringkasan Pesanan</h2>
                @foreach ($items as $item)
                    <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px;">
                        <span>{{ $item->merek }} {{ $item->model }}</span>
                        <span>Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="cart-summary" style="margin-top:12px;">
                    <span>Total</span>
                    <span class="harga">Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
