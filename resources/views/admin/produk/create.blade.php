@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.produk.index') }}">&larr; Kembali ke daftar produk</a>
    </div>

    <h1 class="page-title">Tambah Produk</h1>
    <p class="page-subtitle">Unit baru otomatis berstatus stok 1 &amp; Tersedia.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
            @include('admin.produk._form')

            <div class="form-actions">
                <button type="submit" class="btn">Simpan Produk</button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection
