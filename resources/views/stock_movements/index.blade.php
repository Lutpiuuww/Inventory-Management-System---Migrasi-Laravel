@extends('layouts.app')

@section('title', 'Riwayat Transaksi Stok')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Riwayat Transaksi Stok</h2>
    <a href="{{ route('stock-movements.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Transaksi Baru
    </a>
</div>

<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Produk (SKU)</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Catatan</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $m)
                <tr>
                    <td>{{ $m->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $m->product->name ?? '-' }} ({{ $m->product->sku ?? '-' }})</td>
                    <td>
                        @if($m->type === 'in')
                            <span style="color: var(--success); font-weight: 500;">Masuk</span>
                        @else
                            <span style="color: var(--danger); font-weight: 500;">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $m->quantity }}</td>
                    <td>{{ $m->notes ?? '-' }}</td>
                    <td>{{ $m->user->username ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($movements->hasPages())
    {{ $movements->links('vendor.pagination.custom') }}
@endif
@endsection
