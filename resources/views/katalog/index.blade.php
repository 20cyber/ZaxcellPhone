@extends('layouts.app')

@section('title', 'Katalog')

@section('content')
    <h1 class="page-title">Katalog Handphone Second</h1>
    <p class="page-subtitle">{{ $produk->total() }} unit tersedia &middot; semua unit sudah dicek kondisinya</p>

    <form method="GET" action="{{ route('katalog.index') }}" class="filter-bar">
        <div class="field">
            <label for="q">Cari</label>
            <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Merek atau model...">
        </div>
        <div class="field">
            <label for="merek">Merek</label>
            <select id="merek" name="merek">
                <option value="">Semua merek</option>
                @foreach ($daftarMerek as $merek)
                    <option value="{{ $merek }}" @selected(request('merek') === $merek)>{{ $merek }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="harga_min">Harga min</label>
            <input type="number" id="harga_min" name="harga_min" value="{{ request('harga_min') }}" placeholder="0" min="0" step="100000">
        </div>
        <div class="field">
            <label for="harga_max">Harga maks</label>
            <input type="number" id="harga_max" name="harga_max" value="{{ request('harga_max') }}" placeholder="Tanpa batas" min="0" step="100000">
        </div>
        <button type="submit" class="btn">Terapkan Filter</button>
        @if (request()->anyFilled(['q', 'merek', 'harga_min', 'harga_max']))
            <a href="{{ route('katalog.index') }}" class="btn btn-outline">Reset</a>
        @endif
    </form>

    @if ($produk->isEmpty())
        <div class="empty-state">
            <p>Tidak ada unit yang cocok dengan pencarian kamu.</p>
        </div>
    @else
        <div class="grid">
            @foreach ($produk as $item)
                <a href="{{ route('katalog.show', $item) }}" class="card">
                    <div class="thumb">📱</div>
                    <div class="body">
                        <span class="merek">{{ $item->merek }}</span>
                        <span class="model">{{ $item->model }}</span>
                        <div class="badges">
                            <span class="badge">{{ $item->kondisi }}</span>
                            @if ($item->warna)
                                <span class="badge">{{ $item->warna }}</span>
                            @endif
                        </div>
                        <span class="harga">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $produk->links() }}
        </div>
    @endif
@endsection
