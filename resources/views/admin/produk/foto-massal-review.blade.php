@extends('layouts.app')

@section('title', 'Konfirmasi Foto Massal')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.foto-massal.create') }}">&larr; Upload ulang</a>
    </div>

    <h1 class="page-title">Konfirmasi {{ count($baris) }} Foto</h1>
    <p class="page-subtitle">AI sudah menebak tiap foto. Cek dan sesuaikan produk tujuan, lalu simpan.</p>

    <form method="POST" action="{{ route('admin.foto-massal.simpan') }}">
        @csrf

        <div class="form-card" style="max-width:none;">
            @foreach ($baris as $i => $item)
                <div class="review-row">
                    <img src="{{ $item['url'] }}" alt="" class="thumb-preview">

                    <div class="info">
                        <input type="hidden" name="baris[{{ $i }}][path]" value="{{ $item['path'] }}">

                        <div class="ai-guess">
                            @if ($item['tebakan']['error'])
                                <span style="color:var(--danger);">{{ $item['tebakan']['error'] }}</span>
                            @elseif ($item['tebakan']['merek'])
                                AI menebak: <strong>{{ $item['tebakan']['merek'] }} {{ $item['tebakan']['model'] }}</strong>
                                @if ($item['tebakan']['warna']) &middot; {{ $item['tebakan']['warna'] }} @endif
                                &middot; keyakinan {{ $item['tebakan']['keyakinan'] }}
                            @else
                                AI tidak yakin ini foto handphone — pilih produk manual di bawah.
                            @endif
                        </div>

                        <select name="baris[{{ $i }}][produk_id]">
                            <option value="">— Lewati foto ini —</option>
                            @foreach ($item['kandidat'] as $k)
                                <option value="{{ $k['produk']->id_produk }}" @selected($loop->first && $k['skor'] > 0)>
                                    {{ $k['produk']->merek }} {{ $k['produk']->model }}
                                    @if ($k['produk']->warna) &middot; {{ $k['produk']->warna }} @endif
                                    (skor kecocokan: {{ $k['skor'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan Semua</button>
            <a href="{{ route('admin.produk.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
@endsection
