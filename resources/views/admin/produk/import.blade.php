@extends('layouts.app')

@section('title', 'Import Produk')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.produk.index') }}">&larr; Kembali ke daftar produk</a>
    </div>

    <h1 class="page-title">Import Produk dari Excel</h1>
    <p class="page-subtitle">Cocok untuk input puluhan/ratusan unit sekaligus tanpa isi form satu-satu.</p>

    @if (session('importErrors') && count(session('importErrors')) > 0)
        <div class="alert alert-error">
            Beberapa baris gagal diimport:
            <ul style="margin:8px 0 0; padding-left:18px;">
                @foreach (session('importErrors') as $pesan)
                    <li>{{ $pesan }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card" style="max-width:none;">
        <h2 style="font-size:16px; margin:0 0 8px;">1. Download Template</h2>
        <p style="font-size:13px; color:var(--muted); margin:0 0 12px;">
            Isi kolom: <strong>merek, model, spesifikasi, warna, kondisi, kelengkapan, harga</strong>.
            Kolom kondisi diisi manual oleh admin (catat minus/cacat unit di sini).
        </p>
        <a href="{{ route('admin.produk.import.template') }}" class="btn btn-outline">⬇ Download Template Excel</a>
    </div>

    <div class="form-card" style="max-width:none; margin-top:20px;">
        <h2 style="font-size:16px; margin:0 0 12px;">2. Upload File yang Sudah Diisi</h2>
        <form method="POST" action="{{ route('admin.produk.import.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-field">
                <label for="file">File Excel (.xlsx)</label>
                <input type="file" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                @error('file') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Import Sekarang</button>
            </div>
        </form>
    </div>

    <div class="notice">
        Produk hasil import belum ada foto. Lanjut ke <a href="{{ route('admin.foto-massal.create') }}" style="color:inherit; text-decoration:underline;">Upload Foto Massal</a> untuk melengkapi foto tiap unit.
    </div>
@endsection
