@csrf

{{-- FOTO SAAT INI (JIKA EDIT) --}}
@if (!empty($produk->foto))
    <div class="mb-3">
        <label class="form-label">Foto Saat Ini</label><br>
        <img src="{{ asset('storage/' . $produk->foto) }}" width="150" class="img-thumbnail rounded">
    </div>
@endif

<div class="row mb-3">
    <div class="col-md-6">
        <div>
            <label class="form-label">Gambar Produk</label>
            <input type="file" 
                   name="foto" 
                   onchange="previewImage(this)" 
                   class="form-control @error('foto') is-invalid @enderror" 
                   accept="image/*">
            @error('foto')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div>
            <label class="form-label">Preview Foto Baru</label><br>
            <img id="preview" class="img-thumbnail mt-2" style="display:none" width="150">
        </div>
    </div>
</div>

{{-- NAMA PRODUK --}}
<div class="mb-3">
    <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
    <input type="text" 
           name="nama" 
           class="form-control @error('nama') is-invalid @enderror" 
           value="{{ old('nama', $produk->nama ?? '') }}" 
           required>
    @error('nama')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- KATEGORI PRODUK (DITAMBAHKAN) --}}
<div class="mb-3">
    <label class="form-label">Kategori Produk <span class="text-danger">*</span></label>
    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
        <option value="" disabled {{ old('kategori_id', $produk->kategori_id ?? '') == '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
        @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
    @error('kategori_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- HARGA BELI & HARGA JUAL --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Harga Beli (Rp)</label>
        <input type="number" 
               name="harga_beli" 
               class="form-control @error('harga_beli') is-invalid @enderror" 
               value="{{ old('harga_beli', $produk->harga_beli ?? '') }}">
        @error('harga_beli')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
        <input type="number" 
               name="harga_jual" 
               class="form-control @error('harga_jual') is-invalid @enderror" 
               value="{{ old('harga_jual', $produk->harga_jual ?? '') }}" 
               required>
        @error('harga_jual')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

{{-- STOK --}}
<div class="mb-3">
    <label class="form-label">Stok <span class="text-danger">*</span></label>
    <input type="number" 
           name="stok" 
           class="form-control @error('stok') is-invalid @enderror" 
           value="{{ old('stok', $produk->stok ?? 0) }}" 
           required>
    @error('stok')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- TOMBOL AKSI --}}
<div class="mt-4">
    <button class="btn btn-success" type="submit">Simpan</button>
    <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
</div>

{{-- SCRIPT PREVIEW --}}
<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const file = input.files[0];

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
}
</script>