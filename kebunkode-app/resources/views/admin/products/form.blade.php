@extends('admin.layout')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', isset($product) ? 'Edit Produk' : 'Tambah Produk Baru')

@section('content')
    <form action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" class="form-layout">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="form-grid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Informasi Dasar</h3>
                    <p class="card-description">Data utama produk yang akan ditampilkan.</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama Produk <span class="required">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required placeholder="Contoh: Daily Planner" />
                        @error('name') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="category">Kategori <span class="required">*</span></label>
                            <select id="category" name="category" required>
                                <option value="">Pilih kategori</option>
                                <option value="website" {{ old('category', $product->category ?? '') === 'website' ? 'selected' : '' }}>Website</option>
                                <option value="produktif" {{ old('category', $product->category ?? '') === 'produktif' ? 'selected' : '' }}>Produktivitas</option>
                                <option value="bisnis" {{ old('category', $product->category ?? '') === 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                            </select>
                            @error('category') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="tag">Tag <span class="required">*</span></label>
                            <input type="text" id="tag" name="tag" value="{{ old('tag', $product->tag ?? '') }}" required placeholder="Contoh: Website, Produktivitas" />
                            @error('tag') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi Singkat <span class="required">*</span></label>
                        <textarea id="description" name="description" rows="2" required placeholder="Deskripsi singkat yang muncul di card produk">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="long_description">Deskripsi Lengkap</label>
                        <textarea id="long_description" name="long_description" rows="3" placeholder="Deskripsi detail untuk halaman produk">{{ old('long_description', $product->long_description ?? '') }}</textarea>
                        @error('long_description') <span class="form-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="meta_pills">Meta Pills</label>
                        <input type="text" id="meta_pills" name="meta_pills" value="{{ old('meta_pills', isset($product) && $product->meta_pills ? implode(', ', $product->meta_pills) : '') }}" placeholder="Pisahkan dengan koma: Siap pakai, Responsive, Bisa dikembangkan" />
                        <span class="form-hint">Label kecil yang muncul di halaman detail produk.</span>
                        @error('meta_pills') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Preview Card</h3>
                    <p class="card-description">Tampilan visual produk di halaman koleksi.</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="preview_color">Warna Preview <span class="required">*</span></label>
                            <select id="preview_color" name="preview_color" required>
                                <option value="">Pilih warna</option>
                                <option value="green" {{ old('preview_color', $product->preview_color ?? '') === 'green' ? 'selected' : '' }}>Hijau</option>
                                <option value="sky" {{ old('preview_color', $product->preview_color ?? '') === 'sky' ? 'selected' : '' }}>Biru</option>
                                <option value="sand" {{ old('preview_color', $product->preview_color ?? '') === 'sand' ? 'selected' : '' }}>Kuning</option>
                                <option value="purple" {{ old('preview_color', $product->preview_color ?? '') === 'purple' ? 'selected' : '' }}>Ungu</option>
                                <option value="orange" {{ old('preview_color', $product->preview_color ?? '') === 'orange' ? 'selected' : '' }}>Oranye</option>
                                <option value="dark" {{ old('preview_color', $product->preview_color ?? '') === 'dark' ? 'selected' : '' }}>Gelap</option>
                            </select>
                            @error('preview_color') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="icon">Ikon <span class="required">*</span></label>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', $product->icon ?? '✦') }}" required maxlength="10" placeholder="✦" />
                            <span class="form-hint">Emoji atau simbol unicode.</span>
                            @error('icon') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="preview_label">Label Preview <span class="required">*</span></label>
                            <input type="text" id="preview_label" name="preview_label" value="{{ old('preview_label', $product->preview_label ?? '') }}" required placeholder="PLANNER" />
                            @error('preview_label') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="preview_title">Judul Preview <span class="required">*</span></label>
                            <input type="text" id="preview_title" name="preview_title" value="{{ old('preview_title', $product->preview_title ?? '') }}" required placeholder="Hari yang lebih tertata." />
                            @error('preview_title') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="is_dark_preview" value="1" {{ old('is_dark_preview', $product->is_dark_preview ?? false) ? 'checked' : '' }} />
                            <span>Preview mode gelap</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Harga</h3>
                    <p class="card-description">Informasi harga yang ditampilkan.</p>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="price_display">Tampilan Harga</label>
                            <input type="text" id="price_display" name="price_display" value="{{ old('price_display', $product->price_display ?? '') }}" placeholder="Rp 249.000" />
                            @error('price_display') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="price_note">Catatan Harga</label>
                            <input type="text" id="price_note" name="price_note" value="{{ old('price_note', $product->price_note ?? '') }}" placeholder="sekali bayar" />
                            @error('price_note') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-full">
                <div class="card-header">
                    <h3 class="card-title">Fitur Produk</h3>
                    <p class="card-description">Daftar fitur dalam format JSON. Kosongkan jika belum ada.</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="features_text">Data Fitur (JSON)</label>
                        <textarea id="features_text" name="features_text" rows="6" class="code-input" placeholder='[{"icon":"☼","title":"Daily overview","description":"Ringkasan tugas..."}]'>{{ old('features_text', isset($product) && $product->features ? json_encode($product->features, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                        @error('features_text') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="card card-full">
                <div class="card-header">
                    <h3 class="card-title">Target Audiens</h3>
                    <p class="card-description">Siapa yang cocok menggunakan produk ini.</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="audiences_text">Data Audiens (JSON)</label>
                        <textarea id="audiences_text" name="audiences_text" rows="6" class="code-input" placeholder='[{"icon":"✎","title":"Freelancer","description":"...","points":["Poin 1","Poin 2"]}]'>{{ old('audiences_text', isset($product) && $product->audiences ? json_encode($product->audiences, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                        @error('audiences_text') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="card card-full">
                <div class="card-header">
                    <h3 class="card-title">Tech Stack</h3>
                    <p class="card-description">Teknologi yang digunakan.</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="tech_stack_text">Data Tech Stack (JSON)</label>
                        <textarea id="tech_stack_text" name="tech_stack_text" rows="5" class="code-input" placeholder='[{"label":"Frontend","values":["React","Tailwind CSS"]}]'>{{ old('tech_stack_text', isset($product) && $product->tech_stack ? json_encode($product->tech_stack, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                        @error('tech_stack_text') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="card card-full">
                <div class="card-header">
                    <h3 class="card-title">FAQ</h3>
                    <p class="card-description">Pertanyaan yang sering diajukan.</p>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="faq_text">Data FAQ (JSON)</label>
                        <textarea id="faq_text" name="faq_text" rows="5" class="code-input" placeholder='[{"question":"Apakah bisa disesuaikan?","answer":"Bisa, warna dan fitur..."}]'>{{ old('faq_text', isset($product) && $product->faq ? json_encode($product->faq, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                        @error('faq_text') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.products.index') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}
            </button>
        </div>
    </form>

    @if(isset($product))
        <div class="form-layout" style="margin-top: 32px;">
            <div class="card card-full">
                <div class="card-header">
                    <h3 class="card-title">Galeri Produk</h3>
                    <p class="card-description">Upload gambar untuk slider di halaman detail produk. Gambar akan otomatis diresize dan dikonversi ke WebP.</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.images.store', $product) }}" method="POST" enctype="multipart/form-data" class="upload-form">
                        @csrf
                        <div class="upload-area" id="uploadArea">
                            <input type="file" name="images[]" id="imageInput" multiple accept="image/*" style="display: none;" />
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <p>Klik atau drag gambar ke sini</p>
                                <span>Maks 5MB per file. Format: JPG, PNG, WebP, GIF</span>
                            </div>
                            <div class="upload-preview" id="uploadPreview"></div>
                        </div>
                        <div class="upload-actions">
                            <button type="button" class="btn btn-ghost btn-sm" id="selectBtn">Pilih Gambar</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="uploadBtn" style="display: none;">Upload Gambar</button>
                        </div>
                    </form>

                    @if($product->images->count() > 0)
                        <div class="image-gallery">
                            <h4 class="gallery-title">Gambar Terupload ({{ $product->images->count() }})</h4>
                            <form action="{{ route('admin.products.images.reorder', $product) }}" method="POST" id="reorderForm">
                                @csrf
                                @method('PATCH')
                                <div class="gallery-grid" id="galleryGrid">
                                    @foreach($product->images as $image)
                                        <div class="gallery-item" data-id="{{ $image->id }}">
                                            <input type="hidden" name="order[]" value="{{ $image->id }}" />
                                            <img src="{{ $image->thumbnail_url }}" alt="{{ $image->alt_text }}" />
                                            <div class="gallery-item-overlay">
                                                <span class="gallery-item-order">{{ $image->sort_order }}</span>
                                                <form action="{{ route('admin.products.images.destroy', $image) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="gallery-delete-btn" title="Hapus">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                            <p class="form-hint" style="margin-top: 12px;">Drag gambar untuk mengubah urutan tampilan di slider.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
@if(isset($product))
<script>
    const uploadArea = document.getElementById('uploadArea');
    const imageInput = document.getElementById('imageInput');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const uploadPreview = document.getElementById('uploadPreview');
    const selectBtn = document.getElementById('selectBtn');
    const uploadBtn = document.getElementById('uploadBtn');
    let selectedFiles = [];

    selectBtn.addEventListener('click', () => imageInput.click());
    uploadPlaceholder.addEventListener('click', () => imageInput.click());

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });

    imageInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        selectedFiles = [...files].filter(f => f.type.startsWith('image/'));
        if (selectedFiles.length === 0) return;

        uploadPlaceholder.style.display = 'none';
        uploadPreview.innerHTML = '';
        uploadBtn.style.display = 'inline-flex';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'preview-thumb';
                div.innerHTML = `<img src="${e.target.result}" alt="Preview" /><span class="preview-remove" data-index="${index}">&times;</span>`;
                uploadPreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        document.querySelectorAll('.preview-remove').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const idx = parseInt(e.target.dataset.index);
                selectedFiles.splice(idx, 1);
                if (selectedFiles.length === 0) {
                    uploadPlaceholder.style.display = 'flex';
                    uploadPreview.innerHTML = '';
                    uploadBtn.style.display = 'none';
                    imageInput.value = '';
                } else {
                    renderPreviews();
                }
            });
        });
    }

    function renderPreviews() {
        uploadPreview.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'preview-thumb';
                div.innerHTML = `<img src="${e.target.result}" alt="Preview" /><span class="preview-remove" data-index="${index}">&times;</span>`;
                uploadPreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    const galleryGrid = document.getElementById('galleryGrid');
    if (galleryGrid) {
        let draggedItem = null;

        galleryGrid.querySelectorAll('.gallery-item').forEach(item => {
            item.setAttribute('draggable', true);

            item.addEventListener('dragstart', (e) => {
                draggedItem = item;
                item.classList.add('dragging');
            });

            item.addEventListener('dragend', () => {
                item.classList.remove('dragging');
                updateOrderInputs();
            });

            item.addEventListener('dragover', (e) => {
                e.preventDefault();
                if (item !== draggedItem) {
                    const rect = item.getBoundingClientRect();
                    const midX = rect.left + rect.width / 2;
                    if (e.clientX < midX) {
                        galleryGrid.insertBefore(draggedItem, item);
                    } else {
                        galleryGrid.insertBefore(draggedItem, item.nextSibling);
                    }
                }
            });
        });

        function updateOrderInputs() {
            const inputs = galleryGrid.querySelectorAll('input[name="order[]"]');
            const orders = galleryGrid.querySelectorAll('.gallery-item-order');
            inputs.forEach((input, i) => {
                orders[i].textContent = i + 1;
            });
            document.getElementById('reorderForm').submit();
        }
    }
</script>
@endif
@endsection
