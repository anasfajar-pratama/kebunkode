@extends('layouts.app')

@section('title', 'KebunKode — Petik solusi digitalmu')

@section('styles')
    @vite('resources/css/landing.css')
@endsection

@section('content')
    <header class="site-header">
        <nav class="nav shell" aria-label="Navigasi utama">
            <a class="brand" href="#beranda" aria-label="KebunKode beranda">
                <span class="brand-mark">&lt;/&gt;</span>
                <span class="brand-name">kebun<span>kode</span></span>
            </a>
            <div class="nav-links" id="navLinks">
                <a href="#koleksi">Koleksi</a>
                <a href="#cara-kerja">Cara kerja</a>
                <a href="#tentang">Tentang KebunKode</a>
            </div>
            <a class="nav-cta" href="#koleksi">Lihat koleksi <span>&#8599;</span></a>
            <button class="nav-toggle" id="navToggle" aria-label="Buka navigasi">&#9776;</button>
        </nav>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="shell hero-grid">
                <div>
                    <div class="eyebrow">Kebun solusi digital</div>
                    <h1>Petik solusi.<br /><em>Tanam ide.</em><br />Tumbuh bersama.</h1>
                    <p class="hero-copy">Koleksi website dan web app yang dirancang untuk membuat pekerjaan sehari-hari terasa lebih ringan, rapi, dan menyenangkan.</p>
                    <div class="hero-actions">
                        <a class="button button-primary" href="#koleksi">Jelajahi koleksi <span>&#8599;</span></a>
                        <a class="button button-ghost" href="#cara-kerja">Cara kerjanya <span>&#8595;</span></a>
                    </div>
                    <p class="hero-note">Dibuat dengan kode yang rapi. Dirawat dengan perhatian.</p>
                </div>

                <div class="garden-illustration" aria-label="Ilustrasi website dan kode di dalam kebun">
                    <div class="garden-sun"></div>
                    <div class="leaf-shape leaf-one"></div>
                    <div class="leaf-shape leaf-two"></div>
                    <div class="garden-card">
                        <div class="browser-bar"><span class="browser-dot"></span><span class="browser-dot"></span><span class="browser-dot"></span></div>
                        <div class="mockup-screen">
                            <div class="mockup-label">kebun / ruang tumbuh</div>
                            <div class="mockup-title">Ruang yang membuat ide tumbuh.</div>
                            <span class="mockup-button">Mulai jelajah &#8594;</span>
                            <div class="mockup-stem"></div><div class="mockup-leaf"></div><div class="mockup-leaf two"></div>
                        </div>
                    </div>
                    <div class="code-card">
                        <div class="code-top"><span>garden.js</span><span>&#9679; live</span></div>
                        <div class="code-lines">
                            <span>const solusi = [</span>
                            <span>'rapi', 'berguna',</span>
                            <span>'siap tumbuh'</span>
                            <span>]</span>
                        </div>
                    </div>
                    <div class="plant"></div>
                </div>
            </div>
        </section>

        <div class="trust-strip">
            <div class="shell trust-row">
                <p>Temukan alat kecil untuk pekerjaan besar.</p>
                <div class="trust-items">
                    <span class="trust-item">Siap pakai</span>
                    <span class="trust-item">Bisa dikembangkan</span>
                    <span class="trust-item">Dibuat untuk manusia</span>
                </div>
            </div>
        </div>

        <section id="koleksi">
            <div class="shell">
                <div class="section-heading">
                    <div>
                        <div class="section-kicker">Koleksi pilihan</div>
                        <h2>Temukan alat yang cocok untuk kebutuhanmu.</h2>
                    </div>
                    <p class="section-intro">Mulai dari website sederhana sampai aplikasi yang membantu pekerjaan berjalan otomatis.</p>
                </div>

                <div class="filter-row" role="group" aria-label="Filter koleksi">
                    <button class="filter active" data-filter="all">Semua koleksi</button>
                    <button class="filter" data-filter="website">Website</button>
                    <button class="filter" data-filter="produktif">Produktivitas</button>
                    <button class="filter" data-filter="bisnis">Bisnis</button>
                </div>

                <div class="collection-grid">
                    @foreach($products as $product)
                        <article class="product-card" data-category="{{ $product->category }}">
                            <div class="product-preview preview-{{ $product->preview_color }}">
                                <span class="preview-icon">{{ $product->icon }}</span>
                                <div class="preview-window{{ $product->is_dark_preview ? ' dark' : '' }}">
                                    <span class="mini-chip">{{ $product->preview_label }}</span>
                                    <h4>{{ $product->preview_title }}</h4>
                                    <div class="preview-lines"><span></span><span></span></div>
                                </div>
                            </div>
                            <div class="product-body">
                                <div class="product-tag">{{ $product->tag }}</div>
                                <h3>{{ $product->name }}</h3>
                                <p>{{ $product->description }}</p>
                                <a class="product-link" href="{{ route('product.show', $product) }}">Lihat detail <span>&#8594;</span></a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="how-section" id="cara-kerja">
            <div class="shell">
                <div class="section-heading">
                    <div>
                        <div class="section-kicker">Cara kerja</div>
                        <h2>Semudah memilih bibit yang tepat.</h2>
                    </div>
                    <p class="section-intro">Tidak perlu mulai dari halaman kosong. Pilih, sesuaikan, lalu biarkan solusi ini tumbuh bersamamu.</p>
                </div>
                <div class="steps">
                    <div class="step">
                        <div class="step-number">01</div>
                        <h3>Pilih dari koleksi</h3>
                        <p>Jelajahi berbagai website dan aplikasi berdasarkan kebutuhanmu.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">02</div>
                        <h3>Sesuaikan denganmu</h3>
                        <p>Tambahkan identitas, alur kerja, dan fitur yang membuatnya terasa milikmu.</p>
                    </div>
                    <div class="step">
                        <div class="step-number">03</div>
                        <h3>Mulai digunakan</h3>
                        <p>Terima solusi yang siap dipakai dan terus bisa dikembangkan saat kebutuhan berubah.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang">
            <div class="shell">
                <div class="about-card">
                    <div class="about-art">
                        <div class="about-quote">Kode yang baik terasa seperti <em>kebun yang terawat.</em></div>
                        <div class="about-leaf"></div>
                    </div>
                    <div class="about-copy">
                        <div class="section-kicker">Tentang KebunKode</div>
                        <h2>Teknologi yang terasa dekat.</h2>
                        <p>KebunKode mengumpulkan solusi digital yang tidak hanya terlihat bagus, tapi juga masuk akal untuk dipakai sehari-hari. Setiap produk dibuat supaya sederhana saat pertama digunakan dan tetap punya ruang untuk tumbuh.</p>
                        <div class="about-points">
                            <span class="about-point">Fungsional</span>
                            <span class="about-point">Fleksibel</span>
                            <span class="about-point">Manusiawi</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section" id="kontak">
            <div class="shell">
                <div class="section-kicker">Punya kebutuhan khusus?</div>
                <h2>Kita bisa menumbuhkan sesuatu yang baru.</h2>
                <p>Ceritakan kebutuhanmu. Mungkin solusinya sudah ada di koleksi, atau mungkin perlu kita tanam bersama dari awal.</p>
                <button class="button" onclick="openContactModal(null, 'landing')">Mulai ngobrol <span>&#8599;</span></button>
            </div>
        </section>
    </main>

    @include('partials.footer')

    @include('partials.contact-modal', ['source' => 'landing'])
@endsection

@section('scripts')
    @vite('resources/js/app.js')
    <script>
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');
        navToggle.addEventListener('click', () => navLinks.classList.toggle('open'));
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => navLinks.classList.remove('open'));
        });

        const filters = document.querySelectorAll('.filter');
        const products = document.querySelectorAll('.product-card');
        filters.forEach(filter => {
            filter.addEventListener('click', () => {
                filters.forEach(item => item.classList.remove('active'));
                filter.classList.add('active');
                const category = filter.dataset.filter;
                products.forEach(product => {
                    product.classList.toggle('hide', category !== 'all' && product.dataset.category !== category);
                });
            });
        });
    </script>
@endsection
