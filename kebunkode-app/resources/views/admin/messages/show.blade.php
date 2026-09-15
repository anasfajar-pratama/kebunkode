@extends('admin.layout')

@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan')

@section('content')
    <div class="page-header">
        <a href="{{ route('admin.messages.index') }}" class="btn btn-ghost">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
    </div>

    <div class="message-detail-card">
        <div class="message-detail-header">
            <div class="message-detail-meta">
                <div class="message-detail-avatar">{{ strtoupper(substr($message->name, 0, 1)) }}</div>
                <div class="message-detail-info">
                    <h3 class="message-detail-name">{{ $message->name }}</h3>
                    <div class="message-detail-contact">
                        <a href="tel:{{ $message->phone }}" class="contact-link">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            {{ $message->phone }}
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $message->phone) }}" target="_blank" class="contact-link whatsapp-link">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
            <div class="message-detail-status">
                <span class="status-badge {{ $message->is_read ? 'read' : 'unread' }}">
                    {{ $message->is_read ? 'Sudah dibaca' : 'Belum dibaca' }}
                </span>
                <span class="message-detail-date">{{ $message->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        @if($message->product)
            <div class="message-detail-product">
                <span class="product-label">Terkait produk:</span>
                <a href="{{ route('admin.products.edit', $message->product) }}" class="product-link">
                    {{ $message->product->name }}
                </a>
            </div>
        @endif

        <div class="message-detail-body">
            <div class="message-detail-tag">
                <span class="tag-icon">&#127793;</span>
                Aku mau aplikasi seperti ini:
            </div>
            <div class="message-detail-content">
                {{ $message->message }}
            </div>
        </div>

        <div class="message-detail-source">
            <span class="source-label">Sumber:</span>
            <span class="source-value">{{ $message->source === 'product' ? 'Halaman Detail Produk' : 'Landing Page' }}</span>
        </div>

        <div class="message-detail-actions">
            <form action="{{ route('admin.messages.toggle-read', $message) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-ghost">
                    @if($message->is_read)
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Tandai Belum Dibaca
                    @else
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Tandai Sudah Dibaca
                    @endif
                </button>
            </form>
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-ghost btn-danger-ghost">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Hapus Pesan
                </button>
            </form>
        </div>
    </div>
@endsection
