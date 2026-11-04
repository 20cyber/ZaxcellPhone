@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
    <h1 class="page-title">Keranjang</h1>
    <p class="page-subtitle">{{ $items->count() }} unit dipilih</p>

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
        <table class="data-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td class="thumb-cell">
                            @if ($item->foto)
                                <img src="{{ Storage::url($item->foto) }}" alt="">
                            @else
                                <div class="ph">📱</div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('katalog.show', $item) }}"><strong>{{ $item->merek }} {{ $item->model }}</strong></a><br>
                            <span style="color:var(--muted)">{{ $item->kondisi }}</span>
                        </td>
                        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.destroy', $item) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="row-actions" style="background:none;border:none;color:var(--danger);cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="cart-summary">
            <span>Total</span>
            <span class="harga">Rp{{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <div class="form-actions">
            <a href="{{ route('checkout.create') }}" class="btn">Lanjut ke Checkout</a>
            <a href="{{ route('katalog.index') }}" class="btn btn-outline">Tambah Unit Lain</a>
        </div>
    @endif
@endsection
