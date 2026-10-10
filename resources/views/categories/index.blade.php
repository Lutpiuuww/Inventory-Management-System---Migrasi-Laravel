@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Daftar Kategori</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn">Edit</a>
                            <form method="POST" action="{{ route('categories.destroy', $category->id) }}" onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
