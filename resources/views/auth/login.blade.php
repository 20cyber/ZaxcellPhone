@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
    <div class="auth-wrap">
        <div class="auth-card">
            <h1 class="page-title" style="margin-bottom:4px;">Login Admin</h1>
            <p class="page-subtitle">Khusus untuk admin Zaxcellphone.</p>

            @if ($errors->any())
                <div class="notice notice-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <label class="checkbox-field">
                    <input type="checkbox" name="remember">
                    Ingat saya
                </label>

                <button type="submit" class="btn" style="width:100%;">Login</button>
            </form>

            <a href="{{ route('katalog.index') }}" class="back-link">&larr; Kembali ke katalog</a>
        </div>
    </div>
@endsection
