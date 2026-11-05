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
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.produk.import.create') }}" class="btn btn-outline">Import Excel</a>
            <a href="{{ route('admin.pricelist-import.create') }}" class="btn btn-outline">Import dari Foto Pricelist</a>
            <a href="{{ route('admin.foto-massal.create') }}" class="btn btn-outline">Upload Foto Massal</a>
            <a href="{{ route('admin.produk.create') }}" class="btn">+ Tambah Produk</a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.produk.index') }}" class="filter-bar">
        <div class="field">
            <label for="q">Cari</label>
            <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Merek atau model...">
        </div>
        <button type="submit" class="btn btn-outline">Cari</button>
    </form>

    <form id="form-hapus-massal" method="POST" action="{{ route('admin.produk.hapus-massal') }}"
          onsubmit="return confirm('Hapus semua produk yang dicentang? Tindakan ini tidak bisa dibatalkan.');">
        @csrf
        @method('DELETE')
    </form>

    <div class="toolbar" style="margin-bottom:12px;">
        <span id="info-terpilih" style="font-size:13px; color:var(--muted);">Belum ada yang dicentang</span>
        <button type="submit" form="form-hapus-massal" id="btn-hapus-massal" class="btn btn-danger" disabled>
            Hapus yang Dicentang
        </button>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th><input type="checkbox" id="chk-semua" onclick="toggleSemuaCentang(this)"></th>
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
                    <td>
                        <input type="checkbox" name="produk_id[]" value="{{ $item->id_produk }}"
                               form="form-hapus-massal" class="chk-produk" onchange="updateInfoTerpilih()">
                    </td>
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
                    <td colspan="7" style="text-align:center; color:var(--muted); padding:32px;">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination-wrap">
        {{ $produk->links() }}
    </div>

    <script>
        function updateInfoTerpilih() {
            const dicentang = document.querySelectorAll('.chk-produk:checked');
            const info = document.getElementById('info-terpilih');
            const tombol = document.getElementById('btn-hapus-massal');

            if (dicentang.length === 0) {
                info.textContent = 'Belum ada yang dicentang';
                tombol.disabled = true;
            } else {
                info.textContent = dicentang.length + ' produk dicentang';
                tombol.disabled = false;
            }

            const semua = document.querySelectorAll('.chk-produk');
            document.getElementById('chk-semua').checked = semua.length > 0 && dicentang.length === semua.length;
        }

        function toggleSemuaCentang(sumber) {
            document.querySelectorAll('.chk-produk').forEach(chk => chk.checked = sumber.checked);
            updateInfoTerpilih();
        }
    </script>
@endsection
