@extends('layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">&larr; Kembali ke dashboard</a>
    </div>

    <div class="toolbar">
        <div>
            <h1 class="page-title" style="margin-bottom:4px;">Kelola Pesanan</h1>
            <p class="page-subtitle" style="margin-bottom:0;">{{ $pesanan->total() }} pesanan</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.pesanan.index') }}" class="filter-bar">
        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status" onchange="this.form.submit()">
                <option value="">Semua status</option>
                @foreach (['Menunggu Pembayaran', 'Dibayar', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'] as $opsi)
                    <option value="{{ $opsi }}" @selected(request('status') === $opsi)>{{ $opsi }}</option>
                @endforeach
            </select>
        </div>
        @if (request('status'))
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline">Reset</a>
        @endif
    </form>

    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Pembeli</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan as $item)
                <tr>
                    <td>#{{ $item->id_pesanan }}</td>
                    <td>{{ $item->pembeli->nama }}</td>
                    <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-status-{{ \Illuminate\Support\Str::slug($item->status_pesanan) }}">{{ $item->status_pesanan }}</span></td>
                    <td>{{ $item->created_at->translatedFormat('d M Y, H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.pesanan.show', $item) }}" class="row-actions">Lihat Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:var(--muted); padding:32px;">Belum ada pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        {{ $pesanan->links() }}
    </div>
@endsection
