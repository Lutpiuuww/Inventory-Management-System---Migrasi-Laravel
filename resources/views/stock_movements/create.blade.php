@extends('layouts.app')

@section('title', 'Transaksi Stok Baru')

@section('content')
<div class="form-container">
    <h2 style="margin-bottom: 24px;">Transaksi Stok Baru</h2>
    
    <form action="{{ route('stock-movements.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="product_id">Produk</label>
            <select id="product_id" name="product_id" required>
                <option value="">Pilih Produk</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" {{ old('product_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->sku }} - {{ $p->name }} (Stok: {{ $p->stock }})
                    </option>
                @endforeach
            </select>
            @error('product_id') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="type">Tipe Transaksi</label>
            <select id="type" name="type" required>
                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stok Masuk</option>
                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stok Keluar</option>
            </select>
            @error('type') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="quantity">Jumlah</label>
            <input type="number" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
            @error('quantity') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="notes">Catatan (Opsional)</label>
            <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            @error('notes') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('stock-movements.index') }}" class="btn" style="flex: 1;">Batal</a>
            <button type="submit" class="btn btn-primary" style="flex: 2;">Simpan Transaksi</button>
        </div>
    </form>
</div>
@endsection
