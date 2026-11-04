@extends('layouts.app')

@section('title', 'Akun Admin')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">&larr; Kembali ke dashboard</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="toolbar">
        <div>
            <h1 class="page-title" style="margin-bottom:4px;">Akun Admin</h1>
            <p class="page-subtitle" style="margin-bottom:0;">{{ $akun->count() }} akun terdaftar</p>
        </div>
        <a href="{{ route('admin.akun.create') }}" class="btn">+ Tambah Admin</a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($akun as $item)
                <tr>
                    <td>
                        {{ $item->name }}
                        @if ($item->id === auth()->id())
                            <span class="badge">Kamu</span>
                        @endif
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->created_at->translatedFormat('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
