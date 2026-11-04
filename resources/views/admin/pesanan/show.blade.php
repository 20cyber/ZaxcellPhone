@extends('layouts.app')

@section('title', 'Pesanan #' . $pesanan->id_pesanan)

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.pesanan.index') }}">&larr; Kembali ke daftar pesanan</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="toolbar">
        <div>
            <h1 class="page-title" style="margin-bottom:4px;">Pesanan #{{ $pesanan->id_pesanan }}</h1>
            <p class="page-subtitle" style="margin-bottom:0;">{{ $pesanan->created_at->translatedFormat('d M Y, H:i') }}</p>
        </div>
        <span class="badge badge-status-{{ \Illuminate\Support\Str::slug($pesanan->status_pesanan) }}" style="font-size:13px; padding:6px 14px;">{{ $pesanan->status_pesanan }}</span>
    </div>

    <div class="detail-layout" style="grid-template-columns: 1fr 320px;">
        <div>
            <div class="form-card" style="max-width:none; margin-bottom:20px;">
                <h2 style="font-size:16px; margin:0 0 12px;">Unit Dipesan</h2>
                <table class="spec-table">
                    @foreach ($pesanan->detailPesanan as $detail)
                        <tr>
                            <td>
                                {{ $detail->produk->merek ?? '(produk dihapus)' }} {{ $detail->produk->model ?? '' }}
                                @if ($detail->produk)
                                    <br><span style="color:var(--muted); font-size:12px;">Status unit: {{ $detail->produk->status }}</span>
                                @endif
                            </td>
                            <td>Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>Rp{{ number_format($pesanan->total, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>

            <div class="form-card" style="max-width:none; margin-bottom:20px;">
                <h2 style="font-size:16px; margin:0 0 12px;">Pembayaran</h2>
                @forelse ($pesanan->pembayaran as $bayar)
                    <table class="spec-table">
                        <tr>
                            <td>Kode Transaksi</td>
                            <td>{{ $bayar->order_id_gateway ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Metode</td>
                            <td>{{ $bayar->metode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{{ ucfirst($bayar->status) }}</td>
                        </tr>
                        <tr>
                            <td>Waktu Bayar</td>
                            <td>{{ $bayar->waktu_bayar?->translatedFormat('d M Y, H:i') ?? '-' }}</td>
                        </tr>
                    </table>
                    <hr style="border:none; border-top:1px solid var(--border); margin:12px 0;">
                @empty
                    <p style="color:var(--muted); font-size:13px;">Belum ada percobaan pembayaran.</p>
                @endforelse
            </div>

            @if (! empty($statusLanjutan))
                <div class="form-card" style="max-width:none;">
                    <h2 style="font-size:16px; margin:0 0 12px;">Perbarui Status</h2>
                    <form method="POST" action="{{ route('admin.pesanan.status', $pesanan) }}" id="form-status">
                        @csrf
                        @method('PATCH')

                        <div class="form-field">
                            <label for="status_pesanan">Status Baru</label>
                            <select id="status_pesanan" name="status_pesanan" required onchange="document.getElementById('field-resi').style.display = this.value === 'Dikirim' ? 'flex' : 'none';">
                                <option value="">-- pilih status --</option>
                                @foreach ($statusLanjutan as $opsi)
                                    <option value="{{ $opsi }}">{{ $opsi }}</option>
                                @endforeach
                            </select>
                            @error('status_pesanan') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-field" id="field-resi" style="display:none;">
                            <label for="nomor_resi">Nomor Resi</label>
                            <input type="text" id="nomor_resi" name="nomor_resi" value="{{ old('nomor_resi', $pesanan->nomor_resi) }}">
                            @error('nomor_resi') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn">Simpan Status</button>
                    </form>
                </div>
            @endif
        </div>

        <div>
            <div class="form-card" style="max-width:none;">
                <h2 style="font-size:16px; margin:0 0 12px;">Data Pembeli</h2>
                <p style="font-size:14px; margin:0 0 4px;"><strong>{{ $pesanan->pembeli->nama }}</strong></p>
                <p style="font-size:14px; margin:0 0 4px; color:var(--muted);">{{ $pesanan->pembeli->nomor_hp }}</p>
                <p style="font-size:14px; margin:0; color:var(--muted);">{{ $pesanan->pembeli->alamat }}</p>

                @if ($pesanan->nomor_resi)
                    <hr style="border:none; border-top:1px solid var(--border); margin:16px 0;">
                    <p style="font-size:13px; color:var(--muted); margin:0 0 4px;">Nomor Resi</p>
                    <p style="font-size:14px; margin:0;"><strong>{{ $pesanan->nomor_resi }}</strong></p>
                @endif

                @if ($pesanan->admin)
                    <hr style="border:none; border-top:1px solid var(--border); margin:16px 0;">
                    <p style="font-size:13px; color:var(--muted); margin:0;">Diproses oleh {{ $pesanan->admin->name }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
