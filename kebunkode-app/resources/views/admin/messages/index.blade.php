@extends('admin.layout')

@section('title', 'Pesan Masuk')
@section('page-title', 'Pesan Masuk')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-description">Kelola pesan dari calon pelanggan.</p>
        </div>
        @if($unreadCount > 0)
            <span class="unread-badge">{{ $unreadCount }} pesan belum dibaca</span>
        @endif
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th>Pesan</th>
                        <th>Produk</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr class="{{ !$message->is_read ? 'unread-row' : '' }}">
                            <td>
                                <div class="sender-cell">
                                    <strong>{{ $message->name }}</strong>
                                    <span>{{ $message->phone }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="message-preview">
                                    {{ Str::limit($message->message, 60) }}
                                </div>
                            </td>
                            <td>
                                @if($message->product)
                                    <span class="product-badge">{{ $message->product->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="date-cell">{{ $message->created_at->format('d M Y, H:i') }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.messages.toggle-read', $message) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="status-toggle {{ $message->is_read ? 'read' : 'unread' }}">
                                        <span class="status-dot"></span>
                                        {{ $message->is_read ? 'Dibaca' : 'Baru' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-ghost" title="Lihat detail">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    </a>
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
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
                            <td colspan="6" class="empty-state">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                <p>Belum ada pesan masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="pagination-wrapper">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
@endsection
