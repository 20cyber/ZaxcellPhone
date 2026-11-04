@extends('layouts.app')

@section('title', 'Ubah Produk')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.produk.index') }}">&larr; Kembali ke daftar produk</a>
    </div>

    <h1 class="page-title">Ubah Produk</h1>
    <p class="page-subtitle">{{ $produk->merek }} {{ $produk->model }} &middot; stok diatur lewat menu Stok di daftar produk.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.produk._form')

            <div class="form-actions">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.produk.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection
