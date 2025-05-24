<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-gradient-primary">
            <h5 class="modal-title text-white">
                <i class="fas fa-edit mr-2"></i>
                Edit Banner
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="editBannerForm" action="{{ route('admin.system.updateBanner', $banner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="alert alert-info border-0 rounded-lg">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Informasi:</strong> Silakan isi form di bawah ini untuk memperbarui informasi banner.
                </div>
                
                <div class="form-group">
                    <label for="banner_nama" class="form-label">
                        <i class="fas fa-tag mr-1"></i>
                        Nama Banner
                    </label>
                    <input type="text" class="form-control modern-input" id="banner_nama" name="banner_nama" 
                           value="{{ $banner->banner_nama }}" required placeholder="Masukkan nama banner">
                    <div class="invalid-feedback"></div>
                </div>
                
                <div class="form-group">
                    <label for="banner_link" class="form-label">
                        <i class="fas fa-link mr-1"></i>
                        Link
                    </label>
                    <input type="url" class="form-control modern-input" id="banner_link" name="banner_link" 
                           value="{{ $banner->banner_link }}" required placeholder="https://example.com">
                    <div class="invalid-feedback"></div>
                </div>
                
                <div class="form-group">
                    <label for="banner_gambar" class="form-label">
                        <i class="fas fa-image mr-1"></i>
                        Gambar Banner
                    </label>
                    <div class="custom-file-wrapper">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input modern-file-input" id="banner_gambar" name="banner_gambar" accept="image/*">
                            <label class="custom-file-label" for="banner_gambar">Pilih file baru...</label>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <small class="form-text text-muted">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        Format: JPG, PNG, GIF. Maksimal: 2MB. Biarkan kosong jika tidak ingin mengubah gambar.
                    </small>
                    
                    @if($banner->banner_gambar)
                        <div class="current-banner-wrapper mt-3">
                            <label class="form-label">Gambar Saat Ini:</label>
                            <div class="current-banner-container">
                                <img src="{{ asset('storage/' . $banner->banner_gambar) }}" 
                                     alt="{{ $banner->banner_nama }}" 
                                     class="current-banner-image">
                                <div class="current-banner-overlay">
                                    <i class="fas fa-eye"></i>
                                    <span>Klik untuk memperbesar</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="preview-wrapper mt-3" style="display: none;">
                        <label class="form-label">Pratinjau Gambar Baru:</label>
                        <div class="preview-container">
                            <img id="preview-edit-image" src="#" alt="Preview" class="preview-image">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-preview">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i>
                    <span class="btn-text">Simpan Perubahan</span>
                    <span class="spinner-border spinner-border-sm ml-2 d-none" role="status"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
    }
    
    .form-label {
        color: var(--heading-color);
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }
    
    .modern-input {
        border: 1px solid #e0e6ed;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: var(--transition);
        background: var(--white);
    }
    
    .modern-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(var(--primary-color-rgb), 0.1);
        background: var(--white);
    }
    
    .custom-file-wrapper {
        position: relative;
    }
    
    .custom-file-label {
        border: 1px solid #e0e6ed;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        transition: var(--transition);
        background: var(--white);
    }
    
    .custom-file-input:focus ~ .custom-file-label {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(var(--primary-color-rgb), 0.1);
    }
    
    .current-banner-wrapper {
        background: var(--light-gray);
        border-radius: 8px;
        padding: 1rem;
    }
    
    .current-banner-container {
        position: relative;
        display: inline-block;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: var(--transition);
    }
    
    .current-banner-container:hover {
        transform: scale(1.02);
    }
    
    .current-banner-image {
        max-height: 120px;
        max-width: 200px;
        object-fit: cover;
        border-radius: 8px;
        display: block;
    }
    
    .current-banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: var(--transition);
        font-size: 0.9rem;
    }
    
    .current-banner-container:hover .current-banner-overlay {
        opacity: 1;
    }
    
    .preview-wrapper {
        background: var(--light-gray);
        border-radius: 8px;
        padding: 1rem;
    }
    
    .preview-container {
        position: relative;
        display: inline-block;
    }
    
    .preview-image {
        max-height: 120px;
        max-width: 200px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--primary-color);
    }
    
    .remove-preview {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 0.7rem;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
    
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    $(document).ready(function() {
        if (typeof bsCustomFileInput !== 'undefined') {
            bsCustomFileInput.init();
        }
        
        $('#banner_gambar').change(function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 2097152) {
                    $(this).addClass('is-invalid');
                    $(this).closest('.form-group').find('.invalid-feedback').text('Ukuran file tidak boleh lebih dari 2MB');
                    return;
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).closest('.form-group').find('.invalid-feedback').text('');
                }
                
                let reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview-edit-image').attr('src', event.target.result);
                    $('.preview-wrapper').show();
                }
                reader.readAsDataURL(file);
            } else {
                $('.preview-wrapper').hide();
            }
        });
        
        $('.remove-preview').click(function() {
            $('#banner_gambar').val('');
            $('.preview-wrapper').hide();
            if (typeof bsCustomFileInput !== 'undefined') {
                bsCustomFileInput.init();
            }
        });
        
        $('.current-banner-container').click(function() {
            const src = $(this).find('img').attr('src');
            const title = $(this).find('img').attr('alt');
            
            const modalHtml = `
                <div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${title}</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center p-0">
                                <img src="${src}" alt="${title}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modalHtml);
            $('#viewImageModal').modal('show');
            
            $('#viewImageModal').on('hidden.bs.modal', function() {
                $(this).remove();
            });
        });
        
        $('#editBannerForm').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const btnText = submitBtn.find('.btn-text');
            const spinner = submitBtn.find('.spinner-border');
            
            submitBtn.prop('disabled', true);
            btnText.text('Menyimpan...');
            spinner.removeClass('d-none');
            
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').text('');
            
            const formData = new FormData(this);
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#genericModal').modal('hide');
                    
                    if (typeof showAlert === 'function') {
                        showAlert('success', 'Banner berhasil diperbarui!');
                    }
                    
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            const input = form.find(`[name="${key}"]`);
                            input.addClass('is-invalid');
                            input.closest('.form-group').find('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        const errorHtml = `
                            <div class="alert alert-danger border-0 rounded-lg">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Error:</strong> ${xhr.responseJSON?.message || 'Terjadi kesalahan sistem'}
                            </div>
                        `;
                        form.prepend(errorHtml);
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                    btnText.text('Simpan Perubahan');
                    spinner.addClass('d-none');
                }
            });
        });
    });
</script>