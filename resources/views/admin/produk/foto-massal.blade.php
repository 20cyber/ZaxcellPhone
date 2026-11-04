@extends('layouts.app')

@section('title', 'Upload Foto Massal')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.produk.index') }}">&larr; Kembali ke daftar produk</a>
    </div>

    <h1 class="page-title">Upload Foto Massal (AI-assisted)</h1>
    <p class="page-subtitle">
        Pilih banyak foto sekaligus. Gemini AI akan menebak merek/model/warna tiap foto dan
        menyarankan produk yang cocok — kamu tinggal konfirmasi, bukan isi satu-satu.
    </p>

    @if (! $geminiSiap)
        <div class="alert alert-error">
            GEMINI_API_KEY belum diatur di <code>.env</code>. Foto tetap bisa diupload, tapi AI tidak akan
            menebak otomatis — kamu perlu pilih produk secara manual di langkah berikutnya.
        </div>
    @endif

    <div class="notice">
        {{ $jumlahBelumAdaFoto }} produk saat ini belum punya foto.
    </div>

    <div class="form-card" style="max-width:none; margin-top:16px;">
        <form method="POST" action="{{ route('admin.foto-massal.analisis') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-field">
                <label for="foto">Pilih Foto (bisa banyak sekaligus)</label>
                <input type="file" id="foto" name="foto[]" accept="image/*" multiple required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Analisis dengan AI</button>
            </div>
        </form>
    </div>
@endsection
