@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">&larr; Kembali ke dashboard</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="toolbar">
        <div>
            <h1 class="page-title" style="margin-bottom:4px;">Kelola Produk</h1>
            <p class="page-subtitle" style="margin-bottom:0;">{{ $produk->total() }} unit terdaftar</p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="btn">+ Tambah Produk</a>
    </div>

    <form method="GET" action="{{ route('admin.produk.index') }}" class="filter-bar">
        <div class="field">
            <label for="q">Cari</label>
            <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Merek atau model...">
        </div>
        <button type="submit" class="btn btn-outline">Cari</button>
    </form>

    <table class="data-table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $item)
                <tr>
                    <td class="thumb-cell">
                        @if ($item->foto)
                            <img src="{{ Storage::url($item->foto) }}" alt="">
                        @else
                            <div class="ph">📱</div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->merek }} {{ $item->model }}</strong><br>
                        <span style="color:var(--muted)">{{ $item->kondisi }}</span>
                    </td>
                    <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.produk.stok', $item) }}" class="stok-form">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="stok" value="{{ $item->stok }}" min="0">
                            <button type="submit">Simpan</button>
                        </form>
                    </td>
                    <td>
                        <span class="badge badge-status-{{ \Illuminate\Support\Str::slug($item->status) }}">{{ $item->status }}</span>
                    </td>
                    <td>
                        <div class="row-actions">
                            <a href="{{ route('admin.produk.edit', $item) }}">Ubah</a>
                            <form method="POST" action="{{ route('admin.produk.destroy', $item) }}" onsubmit="return confirm('Hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--muted); padding:32px;">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        {{ $produk->links() }}
    </div>
@endsection
