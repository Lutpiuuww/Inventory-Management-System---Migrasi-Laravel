@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="form-container">
    <h2 style="margin-bottom: 24px;">Tambah Kategori</h2>
    
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('categories.index') }}" class="btn" style="flex: 1;">Batal</a>
            <button type="submit" class="btn btn-primary" style="flex: 2;">Simpan</button>
        </div>
    </form>
</div>
@endsection
