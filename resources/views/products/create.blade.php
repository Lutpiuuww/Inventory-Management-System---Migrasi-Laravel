@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="form-container">
    <h2 style="margin-bottom: 24px;">Tambah Produk Baru</h2>
    
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" value="{{ old('sku') }}" required>
            @error('sku') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select id="category_id" name="category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Harga (Rp)</label>
            <input type="number" id="price" name="price" min="0" value="{{ old('price') }}" required>
            @error('price') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label>Supplier (Bisa Pilih Banyak)</label>
            <div style="background: var(--bg-color); border: 2px solid var(--border-color); padding: 12px; border-radius: var(--radius);">
                @foreach ($suppliers as $sup)
                    <label style="font-weight: normal; margin-bottom: 8px; text-transform: none; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="suppliers[]" value="{{ $sup->id }}" {{ (is_array(old('suppliers')) && in_array($sup->id, old('suppliers'))) ? 'checked' : '' }} style="width: auto;">
                        {{ $sup->name }}
                    </label>
                @endforeach
            </div>
            @error('suppliers') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="image">Gambar Produk (Maks 2MB)</label>
            <input type="file" id="image" name="image" accept="image/*">
            @error('image') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>

        <div class="alert" style="padding: 12px; font-size: 0.85rem; border-color: var(--border-color);">
            <em>* Stok default adalah 0. Silakan lakukan transaksi Barang Masuk untuk menambah stok.</em>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('products.index') }}" class="btn" style="flex: 1; text-align: center;">Batal</a>
            <button type="submit" class="btn btn-primary" style="flex: 2;">Simpan Produk</button>
        </div>
    </form>
</div>
@endsection
