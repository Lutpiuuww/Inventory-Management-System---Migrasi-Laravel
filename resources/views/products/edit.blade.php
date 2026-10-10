@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="form-container">
    <h2 style="margin-bottom: 24px;">Edit Produk</h2>
    
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="sku">SKU</label>
            <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}" required>
            @error('sku') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
            @error('name') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select id="category_id" name="category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Harga (Rp)</label>
            <input type="number" id="price" name="price" min="0" value="{{ old('price', (int)$product->price) }}" required>
            @error('price') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label>Supplier (Bisa Pilih Banyak)</label>
            <div style="background: var(--bg-color); border: 2px solid var(--border-color); padding: 12px; border-radius: var(--radius);">
                @php
                    $currentSuppliers = old('suppliers', $product->suppliers->pluck('id')->toArray());
                @endphp
                @foreach ($suppliers as $sup)
                    <label style="font-weight: normal; margin-bottom: 8px; text-transform: none; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="suppliers[]" value="{{ $sup->id }}" {{ in_array($sup->id, $currentSuppliers) ? 'checked' : '' }} style="width: auto;">
                        {{ $sup->name }}
                    </label>
                @endforeach
            </div>
            @error('suppliers') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="image">Gambar Produk (Maks 2MB)</label>
            @if($product->image_path)
                <div style="margin-bottom: 12px;">
                    <img src="{{ asset(Storage::url($product->image_path)) }}" alt="Current Image" style="max-height: 100px; border-radius: var(--radius);">
                </div>
            @endif
            <input type="file" id="image" name="image" accept="image/*">
            <small style="color: var(--text-muted);">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            @error('image') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>

        <div class="alert" style="padding: 12px; font-size: 0.85rem; border-color: var(--border-color);">
            <em>* Catatan: Stok barang saat ini adalah <strong>{{ $product->stock }}</strong>. Stok hanya bisa diubah melalui halaman <strong>Stock Movements</strong>.</em>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('products.index') }}" class="btn" style="flex: 1; text-align: center;">Batal</a>
            <button type="submit" class="btn btn-primary" style="flex: 2;">Update Produk</button>
        </div>
    </form>
</div>
@endsection
