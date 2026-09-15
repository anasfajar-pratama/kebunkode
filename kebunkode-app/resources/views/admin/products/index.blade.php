@extends('admin.layout')

@section('title', 'Kelola Koleksi')
@section('page-title', 'Kelola Koleksi')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-description">Kelola produk yang tampil di halaman koleksi website.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Produk
        </a>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <div class="product-color product-color--{{ $product->preview_color }}">
                                        {{ $product->icon }}
                                    </div>
                                    <div class="product-info">
                                        <strong>{{ $product->name }}</strong>
                                        <span>{{ $product->description }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge--{{ $product->category }}">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $product->price_display ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.products.toggle', $product) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="status-toggle {{ $product->is_active ? 'active' : 'inactive' }}">
                                        <span class="status-dot"></span>
                                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-ghost" title="Edit">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-ghost btn-danger-ghost" title="Hapus">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                                <p>Belum ada produk.</p>
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">Tambah Produk Pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
