<div class="modal-overlay" id="contactModal">
    <div class="modal-container">
        <button class="modal-close" id="modalClose" aria-label="Tutup">&times;</button>
        
        <div class="modal-header">
            <div class="modal-brand">
                <span class="modal-brand-mark">&lt;/&gt;</span>
                <span class="modal-brand-name">kebun<span>kode</span></span>
            </div>
            <h2 class="modal-title">Mulai ngobrol</h2>
        </div>

        <form id="contactForm" class="modal-form">
            @csrf
            <input type="hidden" name="source" value="{{ $source ?? 'landing' }}" />

            <div class="modal-section">
                <div class="modal-tag">
                    <span class="modal-tag-icon">&#127793;</span>
                    Aku mau aplikasi seperti ini:
                </div>

                @if(!isset($productId))
                    <div class="modal-form-group">
                        <select id="contactProductSelect" name="product_id" class="modal-select">
                            <option value="">Pilih dari koleksi atau buat baru...</option>
                            @foreach(\App\Models\Product::where('is_active', true)->get() as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="product_id" value="{{ $productId }}" />
                @endif

                <div class="modal-form-group">
                    <textarea id="contactMessage" name="message" rows="4" required placeholder="Ceritakan kebutuhanmu... Aplikasi seperti apa yang kamu bayangkan?"></textarea>
                </div>
            </div>

            <div class="modal-section">
                <div class="modal-tag modal-tag-secondary">
                    <span class="modal-tag-icon">&#128172;</span>
                    Lanjut isi Form ya, biar interaksi lebih mudah !!
                </div>

                <div class="modal-form-group">
                    <label for="contactName">Nama <span class="required">*</span></label>
                    <input type="text" id="contactName" name="name" required placeholder="Nama kamu" />
                </div>

                <div class="modal-form-group">
                    <label for="contactPhone">No. Handphone <span class="required">*</span></label>
                    <input type="tel" id="contactPhone" name="phone" required placeholder="08xxxxxxxxxx" />
                </div>
            </div>

            <button type="submit" class="modal-submit" id="modalSubmitBtn">
                <span class="modal-submit-text">Kirim pesan</span>
                <span class="modal-submit-loading" style="display: none;">Mengirim...</span>
            </button>
        </form>

        <div class="modal-success" id="modalSuccess" style="display: none;">
            <div class="modal-success-icon">&#127793;</div>
            <h3 class="modal-success-title">Terima kasih sudah menghubungi kami!</h3>
            <p class="modal-success-text">
                Pesan kamu sudah kami terima. Tim kami akan segera menghubungi kamu melalui WhatsApp atau telepon dalam 1x24 jam.<br><br>
                <strong>Sambil menunggu, kamu bisa jelajahi koleksi kami yang lain ya!</strong>
            </p>
            <button class="modal-submit" id="modalSuccessClose">Tutup</button>
        </div>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(23, 57, 45, 0.6);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    padding: 20px;
}
.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}
.modal-container {
    position: relative;
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 520px;
    max-height: min(90vh, 760px);
    overflow: hidden;
    background: var(--paper, #fffdf7);
    border-radius: 24px;
    box-shadow: 0 24px 60px rgba(34, 74, 54, 0.2);
    transform: translateY(20px) scale(0.95);
    transition: transform 0.3s ease;
}
.modal-overlay.active .modal-container {
    transform: translateY(0) scale(1);
}
.modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 36px;
    height: 36px;
    display: grid;
    place-items: center;
    background: transparent;
    border: 1px solid rgba(39, 90, 68, 0.14);
    border-radius: 50%;
    font-size: 24px;
    color: #6e7a6d;
    cursor: pointer;
    transition: all 0.2s ease;
}
.modal-close:hover {
    background: rgba(39, 90, 68, 0.08);
    color: #1e3029;
}
.modal-header {
    flex-shrink: 0;
    text-align: center;
    padding: 32px 32px 20px;
    border-bottom: 1px solid rgba(39, 90, 68, 0.08);
}
.modal-brand {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.modal-brand-mark {
    display: grid;
    place-items: center;
    width: 36px;
    height: 36px;
    color: #17392d;
    background: #83b66f;
    border-radius: 11px 11px 11px 3px;
    font-weight: 900;
    font-size: 14px;
}
.modal-brand-name {
    font-size: 18px;
    font-weight: 800;
    color: #17392d;
}
.modal-brand-name span {
    color: #83b66f;
}
.modal-title {
    font-family: Georgia, "Times New Roman", serif;
    font-size: 28px;
    font-weight: 500;
    color: #17392d;
    letter-spacing: -0.04em;
    margin: 0;
}
.modal-section {
    margin-bottom: 24px;
}
.modal-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: #d8e8c8;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    color: #275a44;
    margin-bottom: 16px;
}
.modal-tag-secondary {
    background: #f5f1e7;
    color: #9e5137;
}
.modal-tag-icon {
    font-size: 16px;
}
.modal-form {
    display: flex;
    flex-direction: column;
    min-height: 0;
    overflow-y: auto;
    padding: 24px 32px 32px;
    scrollbar-width: thin;
    scrollbar-color: rgba(39, 90, 68, 0.22) transparent;
}
.modal-form::-webkit-scrollbar {
    width: 6px;
}
.modal-form::-webkit-scrollbar-track {
    background: transparent;
}
.modal-form::-webkit-scrollbar-thumb {
    background: rgba(39, 90, 68, 0.2);
    border-radius: 99px;
}
.modal-form::-webkit-scrollbar-thumb:hover {
    background: rgba(39, 90, 68, 0.35);
}
.modal-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 16px;
}
.modal-form-group:last-child {
    margin-bottom: 0;
}
.modal-form-group label {
    font-size: 12px;
    font-weight: 700;
    color: #275a44;
}
.modal-form-group .required {
    color: #c97851;
}
.modal-form-group input,
.modal-form-group textarea,
.modal-select {
    width: 100%;
    padding: 12px 14px;
    background: #fffdf7;
    border: 1px solid rgba(39, 90, 68, 0.14);
    border-radius: 12px;
    font-size: 14px;
    color: #1e3029;
    font-family: inherit;
    transition: all 0.2s ease;
}
.modal-select {
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23275a44' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 36px;
}
.modal-form-group input:focus,
.modal-form-group textarea:focus,
.modal-select:focus {
    outline: none;
    border-color: #83b66f;
    box-shadow: 0 0 0 3px rgba(131, 182, 111, 0.15);
}
.modal-form-group textarea {
    resize: vertical;
    min-height: 100px;
}
.modal-submit {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 20px;
    background: #275a44;
    color: #fff;
    border: none;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 8px;
}
.modal-submit:hover {
    background: #1d4938;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(39, 90, 68, 0.25);
}
.modal-submit:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}
.modal-success {
    text-align: center;
    min-height: 0;
    padding: 32px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(39, 90, 68, 0.22) transparent;
}
.modal-success::-webkit-scrollbar {
    width: 6px;
}
.modal-success::-webkit-scrollbar-thumb {
    background: rgba(39, 90, 68, 0.2);
    border-radius: 99px;
}
.modal-success-icon {
    display: grid;
    place-items: center;
    width: 72px;
    height: 72px;
    margin: 0 auto 24px;
    background: #d8e8c8;
    color: #275a44;
    border-radius: 50%;
    font-size: 36px;
}
.modal-success-title {
    font-family: Georgia, "Times New Roman", serif;
    font-size: 22px;
    font-weight: 500;
    color: #17392d;
    margin: 0 0 16px;
    line-height: 1.3;
}
.modal-success-text {
    font-size: 14px;
    color: #6e7a6d;
    margin: 0 0 24px;
    line-height: 1.7;
}
.modal-success-text strong {
    color: #275a44;
}
@media (max-width: 560px) {
    .modal-header {
        padding: 26px 20px 16px;
    }
    .modal-form {
        padding: 20px 20px 26px;
    }
    .modal-success {
        padding: 26px 20px;
    }
    .modal-title {
        font-size: 24px;
    }
}
</style>

<script>
(function() {
    const modal = document.getElementById('contactModal');
    const closeBtn = document.getElementById('modalClose');
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('modalSubmitBtn');
    const submitText = submitBtn.querySelector('.modal-submit-text');
    const submitLoading = submitBtn.querySelector('.modal-submit-loading');
    const successDiv = document.getElementById('modalSuccess');
    const successClose = document.getElementById('modalSuccessClose');
    const csrfToken = form.querySelector('input[name="_token"]').value;

    window.openContactModal = function(productId, source) {
        if (productId) {
            const productInput = form.querySelector('input[name="product_id"]');
            const productSelect = form.querySelector('select[name="product_id"]');
            if (productInput) {
                productInput.value = productId;
            } else if (productSelect) {
                productSelect.value = productId;
            }
        }
        if (source) {
            form.querySelector('[name="source"]').value = source;
        }
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeContactModal = function() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        setTimeout(() => {
            form.reset();
            form.style.display = '';
            successDiv.style.display = 'none';
            submitBtn.disabled = false;
            submitText.style.display = '';
            submitLoading.style.display = 'none';
        }, 300);
    };

    closeBtn.addEventListener('click', closeContactModal);
    successClose.addEventListener('click', closeContactModal);

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeContactModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeContactModal();
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        submitText.style.display = 'none';
        submitLoading.style.display = '';

        const formData = new FormData(form);

        try {
            const response = await fetch('{{ route("contact.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
            });

            if (!response.ok) {
                throw new Error('Server error: ' + response.status);
            }

            const data = await response.json();

            if (data.success) {
                form.style.display = 'none';
                successDiv.style.display = 'block';
            } else {
                throw new Error(data.message || 'Unknown error');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message + '\n\nSilakan coba lagi atau hubungi kami langsung via email.');
            submitBtn.disabled = false;
            submitText.style.display = '';
            submitLoading.style.display = 'none';
        }
    });
})();
</script>
