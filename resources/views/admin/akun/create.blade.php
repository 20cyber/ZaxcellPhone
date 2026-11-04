@extends('layouts.app')

@section('title', 'Tambah Admin')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.akun.index') }}">&larr; Kembali ke daftar akun</a>
    </div>

    <h1 class="page-title">Tambah Akun Admin</h1>
    <p class="page-subtitle">Akun baru langsung bisa dipakai untuk login.</p>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.akun.store') }}">
            @csrf

            <div class="form-field">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required minlength="8">
                @error('password') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">Simpan Akun</button>
                <a href="{{ route('admin.akun.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection
