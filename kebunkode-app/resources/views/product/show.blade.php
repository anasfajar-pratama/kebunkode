@extends('layouts.app')

@section('title', $product->name . ' — KebunKode')
@section('description', 'Detail produk ' . $product->name . ' — KebunKode')

@section('styles')
    @vite('resources/css/product.css')
@endsection

@section('content')
    <header class="topbar">
        <nav class="nav shell" aria-label="Navigasi produk">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-mark">&lt;/&gt;</span>
                <span>kebun<span>kode</span></span>
            </a>
            <div class="breadcrumb">
                <a href="{{ route('home') }}#koleksi">Koleksi</a>
                <span>/</span>
                <strong>{{ $product->name }}</strong>
            </div>
            <a class="back-link" href="{{ route('home') }}#koleksi"><span>&#8592;</span> Kembali ke koleksi</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="shell hero-grid">
                <div>
                    <div class="eyebrow">{{ $product->tag }} &middot; Web app</div>
                    <h1>{{ explode(' ', $product->name)[0] }} yang lebih <em>tertata.</em></h1>
                    <p class="hero-description">{{ $product->long_description ?? $product->description }}</p>
                    @if($product->meta_pills)
                        <div class="meta-row">
                            @foreach($product->meta_pills as $pill)
                                <span class="meta-pill">{{ $pill }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="preview-stage" aria-label="Preview {{ $product->name }}">
                    <div class="app-window">
                        <div class="window-bar">
                            <span class="window-dot"></span><span class="window-dot"></span><span class="window-dot"></span>
                            <span class="window-address"></span>
                        </div>
                        <div class="app-body">
                            <aside class="app-sidebar">
                                <div class="app-logo">DAILY / PLANNER</div>
                                <div class="side-link active">&#9646; Overview</div>
                                <div class="side-link">&#9633; Tasks</div>
                                <div class="side-link">&#9203; Calendar</div>
                                <div class="side-link">&#9831; Habits</div>
                            </aside>
                            <div class="app-main">
                                <div class="app-welcome">
                                    <div><div class="app-date">Senin, 13 September 2026</div><h3>Selamat pagi, Raka.</h3></div>
                                    <span class="app-add">+ Tugas</span>
                                </div>
                                <div class="progress-card">
                                    <div class="progress-ring">68%</div>
                                    <div><strong>Hari ini sudah bertumbuh.</strong><span>5 dari 7 tugas selesai</span></div>
                                </div>
                                <div class="task-grid">
                                    <div class="task-column">
                                        <h4>Prioritas hari ini</h4>
                                        <div class="task done">Kirim proposal klien</div>
                                        <div class="task done">Review desain homepage</div>
                                        <div class="task">Riset kebutuhan pengguna</div>
                                    </div>
                                    <div class="task-column">
                                        <h4>Ritual kecil</h4>
                                        <div class="task done">Minum air putih</div>
                                        <div class="task">Jalan 20 menit</div>
                                        <div class="task">Tulis jurnal singkat</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="product-bar">
            <div class="shell">
                <div class="product-bar-inner">
                    <div class="product-bar-title">{{ $product->name }} <span>Web app untuk rutinitas yang lebih ringan</span></div>
                    <div class="buy-group">
                        <div class="price"><small>Harga mulai dari</small><strong>{{ $product->price_display ?? 'Rp 249.000' }}</strong></div>
                        <a class="button button-primary" href="#pricing">Pilih produk <span>&#8599;</span></a>
                    </div>
                </div>
            </div>
        </div>

        @if($product->images->count() > 0)
            <section class="gallery-section">
                <div class="shell">
                    <div class="gallery-slider" id="gallerySlider">
                        <div class="slider-main">
                            <div class="slider-track" id="sliderTrack">
                                @foreach($product->images as $index => $image)
                                    <div class="slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                        <img src="{{ $image->url }}" alt="{{ $image->alt_text ?? $product->name }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" />
                                    </div>
                                @endforeach
                            </div>
                            <button class="slider-nav slider-prev" id="sliderPrev" aria-label="Previous">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                            <button class="slider-nav slider-next" id="sliderNext" aria-label="Next">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                            <div class="slider-counter" id="sliderCounter">
                                <span id="currentSlide">1</span> / {{ $product->images->count() }}
                            </div>
                        </div>
                        <div class="slider-thumbs" id="sliderThumbs">
                            @foreach($product->images as $index => $image)
                                <button class="thumb {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}" aria-label="Go to slide {{ $index + 1 }}">
                                    <img src="{{ $image->thumbnail_url }}" alt="" loading="lazy" />
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="benefit-section">
            <div class="shell benefit-layout">
                <div class="benefit-intro">
                    <div class="section-kicker">Apa yang kamu dapat</div>
                    <h2>Bukan sekadar daftar tugas.</h2>
                    <div class="benefit-note">
                        <span>&#10022;</span>
                        <div><strong>Dibuat untuk dipakai setiap hari.</strong><span>Informasi penting tetap terlihat, tanpa membuat layar terasa ramai.</span></div>
                    </div>
                </div>
                <div class="feature-grid">
                    @if($product->features)
                        @foreach($product->features as $feature)
                            <article class="feature-card">
                                <div class="feature-icon">{{ $feature['icon'] ?? '&#9733;' }}</div>
                                <h3>{{ $feature['title'] }}</h3>
                                <p>{{ $feature['description'] }}</p>
                            </article>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <section class="audience-section">
            <div class="shell">
                <div class="section-heading">
                    <div class="section-kicker">Cocok untuk siapa</div>
                    <h2>Satu alat, beberapa cara untuk bertumbuh.</h2>
                    <p>Jelaskan konteks penggunaan secara konkret supaya calon pembeli bisa langsung merasa, "ini dibuat untuk saya."</p>
                </div>
                <div class="audience-grid">
                    @if($product->audiences)
                        @foreach($product->audiences as $audience)
                            <article class="audience-card">
                                <div class="audience-avatar">{{ $audience['icon'] ?? '&#9998;' }}</div>
                                <h3>{{ $audience['title'] }}</h3>
                                <p>{{ $audience['description'] }}</p>
                                <ul class="audience-list">
                                    @foreach($audience['points'] ?? [] as $point)
                                        <li>{{ $point }}</li>
                                    @endforeach
                                </ul>
                            </article>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <section class="tech-section">
            <div class="shell tech-layout">
                <div>
                    <div class="section-kicker">Di balik kebun</div>
                    <h2>Teknologi yang bekerja, tanpa harus terasa rumit.</h2>
                    <p class="tech-copy">Detail teknis tetap tersedia untuk pembeli yang ingin tahu kualitas dan ruang pengembangannya. Letakkan setelah manfaat, agar tidak menghalangi pengunjung non-teknis.</p>
                </div>
                <div class="tech-list">
                    @if($product->tech_stack)
                        @foreach($product->tech_stack as $tech)
                            <div class="tech-row">
                                <div class="tech-label">{{ $tech['label'] }}</div>
                                <div class="tech-values">
                                    @foreach($tech['values'] as $value)
                                        <span class="tech-chip">{{ $value }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <section class="pricing-section" id="pricing">
            <div class="shell pricing-layout">
                <div class="pricing-content">
                    <div class="section-kicker">Pilihan harga</div>
                    <h2>Jelas dari awal, tidak ada kejutan di akhir.</h2>
                    <p>Tampilkan harga dekat dengan tombol aksi, lalu jelaskan apa yang termasuk di dalamnya. Jika ada paket berbeda, gunakan tabel singkat seperti contoh ini.</p>
                    <div class="comparison">
                        <div class="comparison-row header"><span>Fitur</span><span>Starter</span><span>Custom</span></div>
                        <div class="comparison-row"><strong>Dashboard harian</strong><span class="yes">&#10003;</span><span class="yes">&#10003;</span></div>
                        <div class="comparison-row"><strong>Task & habit tracker</strong><span class="yes">&#10003;</span><span class="yes">&#10003;</span></div>
                        <div class="comparison-row"><strong>Branding personal</strong><span>&mdash;</span><span class="yes">&#10003;</span></div>
                        <div class="comparison-row"><strong>Fitur tambahan</strong><span>&mdash;</span><span class="yes">&#10003;</span></div>
                        <div class="comparison-row"><strong>Support implementasi</strong><span>7 hari</span><span>30 hari</span></div>
                    </div>
                </div>
                <aside class="price-card">
                    <div class="price-card-label">Paket paling sederhana</div>
                    <h3>{{ $product->name }} Starter</h3>
                    <p class="price-card-description">Untuk penggunaan personal dan langsung dipakai.</p>
                    <div class="large-price">{{ $product->price_display ?? 'Rp 249.000' }}</div>
                    <div class="large-price-note">{{ $product->price_note ?? 'sekali bayar · contoh harga' }}</div>
                    <button class="button button-primary full-button" onclick="openContactModal({{ $product->id }}, 'product_interest')">Saya tertarik <span>&#8599;</span></button>
                    <div class="price-includes">
                        <div>Dashboard harian</div>
                        <div>Task dan habit tracker</div>
                        <div>Responsive di semua perangkat</div>
                        <div>Update minor selama 7 hari</div>
                    </div>
                    <div class="price-note"><strong>Catatan:</strong> harga pada prototype ini adalah contoh tampilan. Ganti dengan harga final, model lisensi, biaya setup, dan biaya maintenance yang sebenarnya.</div>
                </aside>
            </div>
        </section>

        <section class="faq-section">
            <div class="shell">
                <div class="section-heading">
                    <div class="section-kicker">Pertanyaan umum</div>
                    <h2>Jawaban sebelum kamu memilih.</h2>
                </div>
                <div class="faq-grid">
                    @if($product->faq)
                        @foreach($product->faq as $index => $item)
                            <details{{ $index === 0 ? ' open' : '' }}>
                                <summary>{{ $item['question'] }}</summary>
                                <p>{{ $item['answer'] }}</p>
                            </details>
                        @endforeach
                    @else
                        <details open>
                            <summary>Apakah produk bisa disesuaikan?</summary>
                            <p>Bisa. Warna, logo, alur, dan fitur tambahan dapat dibicarakan sebagai paket custom.</p>
                        </details>
                        <details>
                            <summary>Apakah sudah termasuk hosting?</summary>
                            <p>Jelaskan dengan tegas apakah hosting termasuk, berapa lama, dan biaya perpanjangannya.</p>
                        </details>
                        <details>
                            <summary>Apakah saya mendapat source code?</summary>
                            <p>Tuliskan model lisensi dengan jelas: source code penuh, akses terbatas, atau layanan berlangganan.</p>
                        </details>
                        <details>
                            <summary>Berapa lama proses setup?</summary>
                            <p>Contoh jawaban: produk siap digunakan dalam 1–3 hari kerja setelah data dan branding diterima.</p>
                        </details>
                    @endif
                </div>
            </div>
        </section>

        <section class="bottom-cta">
            <div class="shell">
                <div class="section-kicker">Siap mulai?</div>
                <h2>Pilih alat yang ingin kamu tanam hari ini.</h2>
                <p>Kalau kebutuhanmu sedikit berbeda, KebunKode juga bisa membantu menumbuhkan versi yang lebih sesuai.</p>
                <button class="button" onclick="openContactModal({{ $product->id }}, 'product')">Diskusikan kebutuhanmu <span>&#8599;</span></button>
            </div>
        </section>
    </main>

    @include('partials.footer')

    @include('partials.contact-modal', ['productId' => $product->id, 'source' => 'product'])

    @if($product->images->count() > 0)
    <script>
    (function() {
        const track = document.getElementById('sliderTrack');
        const slides = track.querySelectorAll('.slide');
        const thumbs = document.querySelectorAll('#sliderThumbs .thumb');
        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');
        const counter = document.getElementById('currentSlide');
        let current = 0;
        const total = slides.length;

        function goTo(index) {
            if (index < 0) index = total - 1;
            if (index >= total) index = 0;
            slides[current].classList.remove('active');
            thumbs[current].classList.remove('active');
            current = index;
            slides[current].classList.add('active');
            thumbs[current].classList.add('active');
            counter.textContent = current + 1;
            thumbs[current].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }

        prevBtn.addEventListener('click', () => goTo(current - 1));
        nextBtn.addEventListener('click', () => goTo(current + 1));

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', () => {
                goTo(parseInt(thumb.dataset.index));
            });
        });

        let startX = 0;
        let isDragging = false;

        track.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            isDragging = true;
        });

        track.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
        }, { passive: false });

        track.addEventListener('touchend', (e) => {
            if (!isDragging) return;
            isDragging = false;
            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) goTo(current + 1);
                else goTo(current - 1);
            }
        });

        let mouseStartX = 0;
        let isMouseDragging = false;

        track.addEventListener('mousedown', (e) => {
            mouseStartX = e.clientX;
            isMouseDragging = true;
            track.style.cursor = 'grabbing';
        });

        document.addEventListener('mousemove', (e) => {
            if (!isMouseDragging) return;
            e.preventDefault();
        });

        document.addEventListener('mouseup', (e) => {
            if (!isMouseDragging) return;
            isMouseDragging = false;
            track.style.cursor = '';
            const diff = mouseStartX - e.clientX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) goTo(current + 1);
                else goTo(current - 1);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') goTo(current - 1);
            if (e.key === 'ArrowRight') goTo(current + 1);
        });
    })();
    </script>
    @endif
@endsection
