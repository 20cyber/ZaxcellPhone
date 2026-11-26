@extends('layouts.app')

@section('title', 'Katalog')

@section('content')
    @php($adaFilter = request()->anyFilled(['q', 'merek', 'harga_min', 'harga_max']))

    @unless ($adaFilter || ! $produk->onFirstPage())
        <section class="hero">
            <div>
                <span class="eyebrow">Smart choice, smart price</span>
                <h1>Upgrade Gadget, Bolong.</h1>
                <p>Temukan smartphone second berkualitas yang sudah melalui pengecekan. Kondisi transparan, harga bersahabat, dan transaksi nyaman.</p>
                <div class="cta">
                    <a href="#katalog" class="btn btn-lg">Jelajahi Katalog</a>
                    <a href="{{ route('cart.index') }}" class="btn btn-lg btn-white">Lihat Keranjang</a>
                </div>
            </div>
            <div class="hero-art" aria-hidden="true">
                <div class="hero-phone p1"></div>
                <div class="hero-phone p2"></div>
                <div class="hero-phone p3"></div>
                <span class="hero-chip c1">&#10003; Quality Checked</span>
                <span class="hero-chip c2">Unit sudah dicek kondisinya</span>
            </div>
        </section>
    @endunless

    <div class="section-head" id="katalog">
        <div>
            <span class="eyebrow">Pilihan terbaik</span>
            <h2>Katalog handphone second</h2>
            <p>{{ $produk->total() }} unit tersedia &middot; semua unit sudah dicek kondisinya</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

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
        @if ($adaFilter)
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
                <div class="card">
                    <div class="thumb">
                        <span class="thumb-badge">{{ $item->kondisi }}</span>
                        <a href="{{ route('katalog.show', $item) }}" aria-label="{{ $item->merek }} {{ $item->model }}">
                            @if ($item->foto)
                                <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->merek }} {{ $item->model }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                📱
                            @endif
                        </a>
                    </div>
                    <div class="body">
                        <span class="model">{{ $item->merek }} {{ $item->model }}</span>
                        @if ($item->warna)
                            <span class="meta">{{ $item->warna }}</span>
                        @endif
                        <span class="harga">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                        <div class="card-foot">
                            <a href="{{ route('katalog.show', $item) }}" class="detail-link">Detail produk</a>
                            <form method="POST" action="{{ route('cart.store', $item) }}">
                                @csrf
                                <button type="submit" class="add-btn" title="Tambah ke keranjang" aria-label="Tambah ke keranjang">+</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $produk->links() }}
        </div>
    @endif
@endsection
