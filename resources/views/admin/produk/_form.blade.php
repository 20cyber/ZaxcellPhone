@csrf

<div class="form-grid">
    <div class="form-field">
        <label for="merek">Merek</label>
        <input type="text" id="merek" name="merek" value="{{ old('merek', $produk->merek ?? '') }}" required>
        @error('merek') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="model">Model</label>
        <input type="text" id="model" name="model" value="{{ old('model', $produk->model ?? '') }}" required>
        @error('model') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="warna">Warna</label>
        <input type="text" id="warna" name="warna" value="{{ old('warna', $produk->warna ?? '') }}">
        @error('warna') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="kondisi">Kondisi</label>
        <input type="text" id="kondisi" name="kondisi" value="{{ old('kondisi', $produk->kondisi ?? '') }}" placeholder="Mis. Mulus 95%" required>
        @error('kondisi') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="kelengkapan">Kelengkapan</label>
        <input type="text" id="kelengkapan" name="kelengkapan" value="{{ old('kelengkapan', $produk->kelengkapan ?? '') }}" placeholder="Mis. Fullset (dus + charger)">
        @error('kelengkapan') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="harga">Harga (Rp)</label>
        <input type="number" id="harga" name="harga" value="{{ old('harga', $produk->harga ?? '') }}" min="0" step="1000" required>
        @error('harga') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field full">
        <label for="spesifikasi">Spesifikasi</label>
        <textarea id="spesifikasi" name="spesifikasi" rows="3">{{ old('spesifikasi', $produk->spesifikasi ?? '') }}</textarea>
        @error('spesifikasi') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="status">Status</label>
        <select id="status" name="status" required>
            @foreach (['Tersedia', 'Ditahan', 'Terjual'] as $opsi)
                <option value="{{ $opsi }}" @selected(old('status', $produk->status ?? 'Tersedia') === $opsi)>{{ $opsi }}</option>
            @endforeach
        </select>
        @error('status') <span class="error">{{ $message }}</span> @enderror
    </div>

    <div class="form-field">
        <label for="foto">Foto</label>
        @isset($produk)
            @if ($produk->foto)
                <img src="{{ Storage::url($produk->foto) }}" alt="Foto saat ini" class="current-photo">
            @endif
        @endisset
        <input type="file" id="foto" name="foto" accept="image/*">
        @error('foto') <span class="error">{{ $message }}</span> @enderror
    </div>
</div>
