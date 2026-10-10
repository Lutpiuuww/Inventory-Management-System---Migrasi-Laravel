@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Daftar Produk</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Tambah Produk
    </a>
</div>

<form method="GET" class="search-form" style="flex-wrap: wrap;" action="{{ route('products.index') }}">
    <input type="text" name="search" placeholder="Cari nama atau SKU..." value="{{ request('search') }}" style="min-width: 200px;">
    
    <select name="category_id" style="padding: 12px; border: 2px solid var(--border-color); border-radius: var(--radius); background: var(--surface); color: var(--text-main);">
        <option value="">Semua Kategori</option>
        @foreach ($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
    
    <select name="sort" style="padding: 12px; border: 2px solid var(--border-color); border-radius: var(--radius); background: var(--surface); color: var(--text-main);">
        @foreach (['id', 'sku', 'name', 'price', 'stock'] as $s)
            <option value="{{ $s }}" {{ request('sort', 'id') === $s ? 'selected' : '' }}>Urut: {{ ucfirst($s) }}</option>
        @endforeach
    </select>
    
    <select name="order" style="padding: 12px; border: 2px solid var(--border-color); border-radius: var(--radius); background: var(--surface); color: var(--text-main);">
        <option value="asc" {{ request('order', 'asc') === 'asc' ? 'selected' : '' }}>Naik</option>
        <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>Turun</option>
    </select>

    <button type="submit" class="btn">Filter</button>
</form>

@if ($products->count() > 0)
    <div class="products-grid">
        @foreach ($products as $p)
            <div class="card {{ $p->stock == 0 ? 'out-of-stock' : '' }}">
                @if ($p->image_path)
                    <div class="card-img-wrapper">
                        <img src="{{ asset(Storage::url($p->image_path)) }}" alt="{{ $p->name }}">
                    </div>
                @endif
                
                <span class="card-badge">{{ $p->category->name ?? 'Uncategorized' }}</span>
                <h3>{{ $p->name }}</h3>
                
                <div class="card-data">
                    <span class="label">SKU</span>
                    <span class="value">{{ $p->sku }}</span>
                </div>
                <div class="card-data">
                    <span class="label">Harga</span>
                    <span class="value">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                </div>
                <div class="card-data">
                    <span class="label">Stok</span>
                    <span class="value" {!! $p->stock == 0 ? 'style="color: var(--danger);"' : '' !!}>
                        {{ $p->stock == 0 ? 'HABIS' : $p->stock }}
                    </span>
                </div>
                
                <div class="card-actions">
                    <a href="{{ route('products.edit', $p->id) }}" class="btn">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $p->id) }}" style="flex: 1;" onsubmit="return confirm('Hapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="width: 100%;">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert">Tidak ada produk yang ditemukan.</div>
@endif

@if ($products->hasPages())
    {{ $products->links('vendor.pagination.custom') }}
@endif
@endsection
