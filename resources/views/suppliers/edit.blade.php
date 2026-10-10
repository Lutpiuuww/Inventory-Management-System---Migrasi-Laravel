@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="form-container">
    <h2 style="margin-bottom: 24px;">Edit Supplier</h2>
    
    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Nama Supplier</label>
            <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" required autofocus>
            @error('name') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div class="form-group">
            <label for="contact_info">Kontak Info</label>
            <input type="text" id="contact_info" name="contact_info" value="{{ old('contact_info', $supplier->contact_info) }}">
            @error('contact_info') <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div> @enderror
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="{{ route('suppliers.index') }}" class="btn" style="flex: 1;">Batal</a>
            <button type="submit" class="btn btn-primary" style="flex: 2;">Update</button>
        </div>
    </form>
</div>
@endsection
