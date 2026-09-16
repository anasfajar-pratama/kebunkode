@extends('admin.layout')

@section('title', 'Pengaturan SEO')
@section('page-title', 'Pengaturan SEO')

@section('content')
    <div class="page-header">
        <div>
            <p class="page-description">Kelola meta tag, Open Graph, Twitter Card, Analytics, sitemap, dan robots.txt.</p>
        </div>
        <div class="seo-quick-links">
            <a href="{{ route('sitemap') }}" target="_blank" class="btn btn-ghost btn-sm">Lihat Sitemap</a>
            <a href="{{ route('robots') }}" target="_blank" class="btn btn-ghost btn-sm">Lihat robots.txt</a>
        </div>
    </div>

    <div class="seo-tabs">
        <button type="button" class="seo-tab active" data-tab="global">Global</button>
        <button type="button" class="seo-tab" data-tab="home">Beranda</button>
        <button type="button" class="seo-tab" data-tab="produk">Produk</button>
    </div>

    {{-- ================= GLOBAL ================= --}}
    <div class="seo-panel active" id="panel-global">
        <form action="{{ route('admin.seo.update', 'global') }}" method="POST" class="form-layout">
            @csrf
            @method('PUT')

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Meta Default</h3>
                    <p class="card-description">Digunakan sebagai fallback untuk semua halaman.</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="g_meta_title">Meta Title Default</label>
                        <input type="text" id="g_meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $global->meta_title) }}" placeholder="KebunKode — Petik solusi digitalmu" />
                    </div>
                    <div class="form-group">
                        <label for="g_meta_description">Meta Description Default</label>
                        <textarea id="g_meta_description" name="meta_description" rows="2" maxlength="500" placeholder="Koleksi website dan web app siap pakai...">{{ old('meta_description', $global->meta_description) }}</textarea>
                        <span class="form-hint">Ideal 150–160 karakter.</span>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="g_meta_keywords">Meta Keywords</label>
                            <input type="text" id="g_meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $global->meta_keywords) }}" placeholder="website siap pakai, web app, template" />
                        </div>
                        <div class="form-group">
                            <label for="g_robots">Robots</label>
                            <select id="g_robots" name="robots">
                                @foreach(['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'] as $opt)
                                    <option value="{{ $opt }}" {{ old('robots', $global->robots) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Integrasi & Verifikasi</h3>
                    <p class="card-description">Google Analytics, Tag Manager, dan verifikasi Search Console.</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="g_ga">Google Analytics ID</label>
                            <input type="text" id="g_ga" name="google_analytics_id" value="{{ old('google_analytics_id', $global->google_analytics_id) }}" placeholder="G-XXXXXXXXXX" />
                        </div>
                        <div class="form-group">
                            <label for="g_gtm">Google Tag Manager ID</label>
                            <input type="text" id="g_gtm" name="google_tag_manager_id" value="{{ old('google_tag_manager_id', $global->google_tag_manager_id) }}" placeholder="GTM-XXXXXXX" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="g_verify">Google Site Verification</label>
                        <input type="text" id="g_verify" name="google_site_verification" value="{{ old('google_site_verification', $global->google_site_verification) }}" placeholder="Kode verifikasi Search Console" />
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Structured Data (JSON-LD)</h3>
                    <p class="card-description">Schema default untuk semua halaman (Organization / WebSite).</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea name="structured_data" rows="8" class="code-input" placeholder='{"@@context":"https://schema.org","@@type":"Organization","name":"KebunKode"}'>{{ old('structured_data', $global->structured_data) }}</textarea>
                        @error('structured_data') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">robots.txt</h3>
                    <p class="card-description">Konten file robots.txt yang ditampilkan di /robots.txt.</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea name="robots_txt" rows="6" class="code-input" placeholder="User-agent: *&#10;Allow: /&#10;Disallow: /admin">{{ old('robots_txt', $global->robots_txt) }}</textarea>
                        <span class="form-hint">Kosongkan untuk memakai default otomatis (sudah termasuk Sitemap).</span>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan Global</button>
            </div>
        </form>
    </div>

    {{-- ================= HOME ================= --}}
    <div class="seo-panel" id="panel-home">
        <form action="{{ route('admin.seo.update', 'home') }}" method="POST" enctype="multipart/form-data" class="form-layout">
            @csrf
            @method('PUT')

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Google Preview</h3>
                </div>
                <div class="card-body">
                    <div class="seo-preview">
                        <div class="seo-preview-url">{{ url('/') }}</div>
                        <div class="seo-preview-title" id="previewTitle">{{ $home->meta_title ?: 'Judul halaman' }}</div>
                        <div class="seo-preview-desc" id="previewDesc">{{ $home->meta_description ?: 'Deskripsi halaman akan muncul di sini.' }}</div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Meta Halaman Beranda</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="h_meta_title">Meta Title</label>
                        <input type="text" id="h_meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $home->meta_title) }}" placeholder="KebunKode — Petik solusi digitalmu" data-preview="title" />
                    </div>
                    <div class="form-group">
                        <label for="h_meta_description">Meta Description</label>
                        <textarea id="h_meta_description" name="meta_description" rows="2" maxlength="500" placeholder="Koleksi website dan web app siap pakai..." data-preview="desc">{{ old('meta_description', $home->meta_description) }}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="h_meta_keywords">Meta Keywords</label>
                            <input type="text" id="h_meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $home->meta_keywords) }}" />
                        </div>
                        <div class="form-group">
                            <label for="h_robots">Robots</label>
                            <select id="h_robots" name="robots">
                                @foreach(['index, follow', 'noindex, follow', 'index, nofollow', 'noindex, nofollow'] as $opt)
                                    <option value="{{ $opt }}" {{ old('robots', $home->robots) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="h_canonical">Canonical URL</label>
                        <input type="text" id="h_canonical" name="canonical_url" value="{{ old('canonical_url', $home->canonical_url) }}" placeholder="{{ url('/') }}" />
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Open Graph (Facebook / WhatsApp / LinkedIn)</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="h_og_title">OG Title</label>
                            <input type="text" id="h_og_title" name="og_title" value="{{ old('og_title', $home->og_title) }}" />
                        </div>
                        <div class="form-group">
                            <label for="h_og_type">OG Type</label>
                            <input type="text" id="h_og_type" name="og_type" value="{{ old('og_type', $home->og_type ?: 'website') }}" placeholder="website" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="h_og_description">OG Description</label>
                        <textarea id="h_og_description" name="og_description" rows="2" maxlength="500">{{ old('og_description', $home->og_description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="h_og_image">OG Image (1200×630 disarankan)</label>
                        <input type="file" id="h_og_image" name="og_image" accept="image/*" />
                        <span class="form-hint">Otomatis dikonversi ke WebP dan dioptimalkan.</span>
                        @if($home->og_image)
                            <div class="seo-image-preview">
                                <img src="{{ \App\Support\Seo::imageUrl($home->og_image) }}" alt="OG Image" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Twitter Card</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="h_twitter_card">Card Type</label>
                            <select id="h_twitter_card" name="twitter_card">
                                @foreach(['summary_large_image', 'summary'] as $opt)
                                    <option value="{{ $opt }}" {{ old('twitter_card', $home->twitter_card) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="h_twitter_site">Twitter Site</label>
                            <input type="text" id="h_twitter_site" name="twitter_site" value="{{ old('twitter_site', $home->twitter_site) }}" placeholder="@kebunkode" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="h_twitter_title">Twitter Title</label>
                        <input type="text" id="h_twitter_title" name="twitter_title" value="{{ old('twitter_title', $home->twitter_title) }}" />
                    </div>
                    <div class="form-group">
                        <label for="h_twitter_description">Twitter Description</label>
                        <textarea id="h_twitter_description" name="twitter_description" rows="2" maxlength="500">{{ old('twitter_description', $home->twitter_description) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="h_twitter_image">Twitter Image</label>
                        <input type="file" id="h_twitter_image" name="twitter_image" accept="image/*" />
                        @if($home->twitter_image)
                            <div class="seo-image-preview">
                                <img src="{{ \App\Support\Seo::imageUrl($home->twitter_image) }}" alt="Twitter Image" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom:20px;">
                <div class="card-header">
                    <h3 class="card-title">Structured Data & Sitemap</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="h_structured_data">Structured Data (JSON-LD)</label>
                        <textarea id="h_structured_data" name="structured_data" rows="6" class="code-input">{{ old('structured_data', $home->structured_data) }}</textarea>
                        @error('structured_data') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="h_freq">Sitemap Change Frequency</label>
                            <select id="h_freq" name="sitemap_frequency">
                                @foreach(['always','hourly','daily','weekly','monthly','yearly','never'] as $opt)
                                    <option value="{{ $opt }}" {{ old('sitemap_frequency', $home->sitemap_frequency) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="h_priority">Sitemap Priority (0–1)</label>
                            <input type="number" step="0.1" min="0" max="1" id="h_priority" name="sitemap_priority" value="{{ old('sitemap_priority', $home->sitemap_priority ?? 1.0) }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan SEO Beranda</button>
            </div>
        </form>
    </div>

    {{-- ================= PRODUK ================= --}}
    <div class="seo-panel" id="panel-produk">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">SEO Produk</h3>
                <p class="card-description">SEO setiap produk diatur dari form edit produk (bagian SEO).</p>
            </div>
            <div class="card-body">
                <p style="font-size:13px;color:var(--muted);margin-bottom:16px;">
                    Setiap produk punya meta title, meta description, keywords, dan OG image sendiri.
                    Buka produk di bawah untuk mengaturnya.
                </p>
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">Kelola Produk</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.seo-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.seo-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.seo-panel').forEach(p => p.classList.remove('active'));
            tab.classList.add('active');
            document.getElementById('panel-' + tab.dataset.tab).classList.add('active');
        });
    });

    const titleInput = document.querySelector('[data-preview="title"]');
    const descInput = document.querySelector('[data-preview="desc"]');
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');

    if (titleInput) titleInput.addEventListener('input', () => {
        previewTitle.textContent = titleInput.value || 'Judul halaman';
    });
    if (descInput) descInput.addEventListener('input', () => {
        previewDesc.textContent = descInput.value || 'Deskripsi halaman akan muncul di sini.';
    });
</script>
@endsection
