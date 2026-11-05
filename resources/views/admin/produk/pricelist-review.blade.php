@extends('layouts.app')

@section('title', 'Tinjau Hasil Pricelist')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.pricelist-import.create') }}">&larr; Upload ulang</a>
    </div>

    <h1 class="page-title">Tinjau {{ count($baris) }} Unit dari Pricelist</h1>
    <p class="page-subtitle">
        Cek &amp; perbaiki kalau ada yang salah baca, lalu simpan. Hilangkan centang untuk baris yang tidak mau diimport.
    </p>

    @if ($pesanError)
        <div class="alert alert-error">Sebagian foto gagal dibaca: {{ $pesanError }}</div>
    @endif

    @if (count($catatanUmum) > 0)
        <div class="notice">
            Catatan umum yang kebaca dari foto: "{{ implode('; ', $catatanUmum) }}" — sudah dipakai sebagai kelengkapan default.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pricelist-import.simpan') }}">
        @csrf

        <div class="form-card" style="max-width:none; overflow-x:auto;">
            <table class="data-table edit-table">
                <thead>
                    <tr>
                        <th>✓</th>
                        <th>Merek</th>
                        <th>Model</th>
                        <th>Spesifikasi</th>
                        <th>Warna</th>
                        <th>Kondisi</th>
                        <th>Kelengkapan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($baris as $i => $item)
                        <tr>
                            <td class="col-sertakan">
                                <input type="checkbox" name="baris[{{ $i }}][sertakan]" value="1" checked>
                            </td>
                            <td><input type="text" name="baris[{{ $i }}][merek]" value="{{ $item['merek'] }}"></td>
                            <td><input type="text" name="baris[{{ $i }}][model]" value="{{ $item['model'] }}"></td>
                            <td><input type="text" name="baris[{{ $i }}][spesifikasi]" value="{{ $item['spesifikasi'] }}"></td>
                            <td><input type="text" name="baris[{{ $i }}][warna]" value="{{ $item['warna'] }}"></td>
                            <td><input type="text" name="baris[{{ $i }}][kondisi]" value="{{ $item['kondisi'] }}"></td>
                            <td><input type="text" name="baris[{{ $i }}][kelengkapan]" value="{{ $item['kelengkapan'] }}"></td>
                            <td><input type="number" name="baris[{{ $i }}][harga]" value="{{ $item['harga'] }}" min="0" step="1000"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan Semua Produk</button>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
@endsection
