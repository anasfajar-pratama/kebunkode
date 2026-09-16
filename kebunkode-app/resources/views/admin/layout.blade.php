<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('partials.favicon')
    <title>@yield('title', 'Admin') — KebunKode</title>
    @vite('resources/css/admin.css')
    @yield('styles')
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <span class="sidebar-brand-mark"><img src="{{ asset('images/logo-icon.png') }}" alt="KebunKode" /></span>
                <span class="sidebar-brand-name">kebun<span>kode</span></span>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Kelola Koleksi
                </a>
                @php $unreadMessages = \App\Models\Message::where('is_read', false)->count(); @endphp
                <a href="{{ route('admin.messages.index') }}" class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Pesan Masuk
                    @if($unreadMessages > 0)
                        <span class="sidebar-badge">{{ $unreadMessages }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.seo.index') }}" class="sidebar-link {{ request()->routeIs('admin.seo.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Pengaturan SEO
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Lihat Website
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" class="sidebar-logout">
                    @csrf
                    <button type="submit" class="sidebar-link sidebar-link-logout">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                    <h1 class="admin-page-title">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="admin-topbar-right">
                    <span class="admin-user-badge">
                        <span class="admin-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                </div>
            </header>

            <main class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success" id="alertSuccess">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const toggle = document.getElementById('sidebarToggle');
        if (toggle) {
            toggle.addEventListener('click', () => {
                document.querySelector('.admin-shell').classList.toggle('sidebar-collapsed');
            });
        }

        const alert = document.getElementById('alertSuccess');
        if (alert) {
            setTimeout(() => { alert.style.opacity = '0'; setTimeout(() => alert.remove(), 300); }, 4000);
        }
    </script>
    @yield('scripts')
</body>
</html>
