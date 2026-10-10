@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Daftar Supplier</h2>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Tambah Supplier
    </a>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Supplier</th>
                <th>Kontak</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->contact_info ?? '-' }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn">Edit</a>
                            <form method="POST" action="{{ route('suppliers.destroy', $supplier->id) }}" onsubmit="return confirm('Hapus supplier ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada supplier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
