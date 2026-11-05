@extends('layouts.app')

@section('title', 'Import dari Foto Pricelist')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.produk.index') }}">&larr; Kembali ke daftar produk</a>
    </div>

    <h1 class="page-title">Import dari Foto Pricelist</h1>
    <p class="page-subtitle">
        Upload foto/screenshot pricelist, AI akan membaca tabelnya dan menyiapkan data produk
        (merek, model, spesifikasi, harga) — kamu tinggal cek &amp; lengkapi sebelum disimpan.
    </p>

    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if (! $geminiSiap)
        <div class="alert alert-error">
            GEMINI_API_KEY belum diatur di <code>.env</code>. Fitur ini butuh Gemini AI aktif untuk membaca tabel dari foto.
        </div>
    @endif

    <div class="form-card" style="max-width:none;">
        <form method="POST" action="{{ route('admin.pricelist-import.analisis') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-field">
                <label for="foto">Foto Pricelist (bisa lebih dari satu kalau datanya beberapa halaman/screenshot)</label>
                <input type="file" id="foto" name="foto[]" accept="image/*" multiple required>
            </div>

            <div class="form-field">
                <label for="kondisi_default">Kondisi Default untuk Semua Unit</label>
                <input type="text" id="kondisi_default" name="kondisi_default" placeholder="Mis. Baru, Belum dicek, Garansi distributor" required>
                <span style="font-size:12px; color:var(--muted);">Pricelist biasanya tidak mencatat minus per unit — isi kondisi umum di sini, bisa diedit per baris nanti.</span>
            </div>

            <div class="form-field">
                <label for="kelengkapan_default">Kelengkapan Default (opsional)</label>
                <input type="text" id="kelengkapan_default" name="kelengkapan_default" placeholder="Mis. Unit saja (tanpa cas & dus)">
                <span style="font-size:12px; color:var(--muted);">Kosongkan kalau mau dipakai catatan umum yang kebaca otomatis dari foto (kalau ada).</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn" {{ $geminiSiap ? '' : 'disabled' }}>Baca Pricelist dengan AI</button>
            </div>
        </form>
    </div>
@endsection
