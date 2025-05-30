<div class="modal fade" id="newCompetitionModal" tabindex="-1" role="dialog" aria-labelledby="newCompetitionModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="newCompetitionModalLabel">
                    <i class="fas fa-plus-circle mr-2"></i>Ajukan Lomba Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newCompetitionForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-trophy mr-1"></i>Nama Lomba <span class="text-danger">*</span></label>
                                <input type="text" name="lomba_nama" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-building mr-1"></i>Penyelenggara <span class="text-danger">*</span></label>
                                <input type="text" name="lomba_penyelenggara" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-tag mr-1"></i>Kategori Lomba <span class="text-danger">*</span></label>
                                <select name="lomba_kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Akademik">Akademik</option>
                                    <option value="Non-Akademik">Non-Akademik</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-layer-group mr-1"></i>Tingkatan Lomba <span class="text-danger">*</span></label>
                                <select name="lomba_tingkatan_id" class="form-control" required>
                                    <option value="">Pilih Tingkatan</option>
                                    @foreach(\App\Models\Tingkatan::where('tingkatan_visible', true)->get() as $tingkatan)
                                        <option value="{{ $tingkatan->id }}">{{ $tingkatan->tingkatan_nama }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><i class="fas fa-code mr-1"></i>Bidang Keahlian <span class="text-danger">*</span></label>
                                <div class="github-topics-container">
                                    <div class="topics-input-wrapper">
                                        <div class="selected-topics" id="selectedTopics"></div>
                                        <input type="text" id="topicsInput" class="topics-input" placeholder="Ketik bidang keahlian..." autocomplete="off">
                                    </div>
                                    <div class="topics-dropdown" id="topicsDropdown">
                                        <div class="dropdown-content" id="dropdownContent"></div>
                                    </div>
                                </div>
                                <div id="hiddenKeahlianInputs"></div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Ketik untuk mencari bidang keahlian. Tekan Enter untuk menambah bidang baru jika tidak ditemukan.
                                </small>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-alt mr-1"></i>Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="lomba_tanggal_mulai" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-calendar-check mr-1"></i>Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="lomba_tanggal_selesai" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-link mr-1"></i>Link Pendaftaran</label>
                                <input type="url" name="lomba_link_pendaftaran" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-image mr-1"></i>Link Poster</label>
                                <input type="url" name="lomba_link_poster" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-paper-plane mr-1"></i>
                        <span class="submit-text">Ajukan Lomba</span>
                        <span class="submit-loading" style="display: none;">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Memproses...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #102044, #1a365d) !important;
}

.github-topics-container {
    position: relative;
}

.topics-input-wrapper {
    border: 2px solid #e3e6f0;
    border-radius: 0.375rem;
    padding: 10px;
    min-height: 50px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    background: white;
    cursor: text;
    transition: border-color 0.3s ease;
}

.topics-input-wrapper:focus-within {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.selected-topics {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.topic-tag {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 6px;
    animation: fadeInScale 0.3s ease;
}

.topic-tag .remove-topic {
    cursor: pointer;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    transition: background-color 0.2s ease;
}

.topic-tag .remove-topic:hover {
    background: rgba(255, 255, 255, 0.5);
}

.topics-input {
    border: none;
    outline: none;
    flex: 1;
    min-width: 150px;
    padding: 5px;
    font-size: 0.875rem;
}

.topics-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 2px solid #e3e6f0;
    border-top: none;
    border-radius: 0 0 0.375rem 0.375rem;
    max-height: 200px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}

.topics-dropdown.show {
    display: block;
}

.dropdown-content {
    padding: 0;
}

.dropdown-item-custom {
    padding: 12px 16px;
    cursor: pointer;
    border-bottom: 1px solid #f8f9fa;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.2s ease;
}

.dropdown-item-custom:hover,
.dropdown-item-custom.highlighted {
    background-color: #f8f9fa;
}

.dropdown-item-custom .item-icon {
    color: #667eea;
    width: 16px;
}

.dropdown-item-custom .item-text {
    flex: 1;
    color: #495057;
}

.dropdown-item-custom .item-badge {
    background: #e9ecef;
    color: #6c757d;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
}

.dropdown-item-custom.create-new {
    background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
    border-top: 2px solid #e0e0e0;
    color: #667eea;
    font-weight: 600;
}

.dropdown-item-custom.create-new:hover {
    background: linear-gradient(135deg, #d1e9fc, #ede7f6);
}

.no-results {
    padding: 16px;
    text-align: center;
    color: #6c757d;
    font-style: italic;
}

@keyframes fadeInScale {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Loading states */
.submit-loading {
    display: none;
}

.loading .submit-text {
    display: none;
}

.loading .submit-loading {
    display: inline;
}

/* Form validation styles */
.is-invalid .topics-input-wrapper {
    border-color: #dc3545;
}

.is-invalid .topics-input-wrapper:focus-within {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .topics-input {
        min-width: 120px;
    }
    
    .topic-tag {
        font-size: 0.8rem;
        padding: 3px 6px;
    }
}

/* Modal customizations */
.modal-header {
    border-bottom: none;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8, #6a4190);
    transform: translateY(-1px);
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-1px);
}
</style>

<script>
$(document).ready(function() {
    let availableKeahlians = [];
    let selectedKeahlians = [];
    let currentHighlightIndex = -1;

    // Load available keahlians
    loadAvailableKeahlians();

    function loadAvailableKeahlians() {
        // In a real implementation, this would be an AJAX call
        // For now, we'll use some sample data
        availableKeahlians = [
            { id: 1, name: 'Web Development' },
            { id: 2, name: 'Mobile Development' },
            { id: 3, name: 'Data Science' },
            { id: 4, name: 'UI/UX Design' },
            { id: 5, name: 'Database Management' },
            { id: 6, name: 'Network Security' },
            { id: 7, name: 'Machine Learning' },
            { id: 8, name: 'Game Development' }
        ];
    }

    // Topics input functionality
    $('#topicsInput').on('input', function() {
        const query = $(this).val().toLowerCase();
        showDropdown(query);
    });

    $('#topicsInput').on('keydown', function(e) {
        const dropdown = $('#topicsDropdown');
        const items = dropdown.find('.dropdown-item-custom');

        switch(e.key) {
            case 'ArrowDown':
                e.preventDefault();
                currentHighlightIndex = Math.min(currentHighlightIndex + 1, items.length - 1);
                updateHighlight(items);
                break;
            case 'ArrowUp':
                e.preventDefault();
                currentHighlightIndex = Math.max(currentHighlightIndex - 1, -1);
                updateHighlight(items);
                break;
            case 'Enter':
                e.preventDefault();
                if (currentHighlightIndex >= 0) {
                    items.eq(currentHighlightIndex).click();
                } else {
                    const query = $(this).val().trim();
                    if (query) {
                        addNewKeahlian(query);
                    }
                }
                break;
            case 'Escape':
                hideDropdown();
                break;
        }
    });

    $('#topicsInput').on('blur', function() {
        // Delay hiding to allow clicking on dropdown items
        setTimeout(() => {
            hideDropdown();
        }, 200);
    });

    $('.topics-input-wrapper').on('click', function() {
        $('#topicsInput').focus();
    });

    function showDropdown(query) {
        const dropdown = $('#topicsDropdown');
        const content = $('#dropdownContent');
        
        if (query.length === 0) {
            hideDropdown();
            return;
        }

        const filtered = availableKeahlians.filter(k => 
            !selectedKeahlians.some(s => s.id === k.id) &&
            k.name.toLowerCase().includes(query)
        );

        let html = '';
        
        filtered.forEach(keahlian => {
            html += `
                <div class="dropdown-item-custom" data-id="${keahlian.id}" data-name="${keahlian.name}">
                    <i class="fas fa-code item-icon"></i>
                    <span class="item-text">${keahlian.name}</span>
                    <span class="item-badge">Existing</span>
                </div>
            `;
        });

        // Add "Create new" option if no exact match
        const exactMatch = filtered.find(k => k.name.toLowerCase() === query.toLowerCase());
        if (!exactMatch && query.trim().length > 0) {
            html += `
                <div class="dropdown-item-custom create-new" data-new-name="${query}">
                    <i class="fas fa-plus item-icon"></i>
                    <span class="item-text">Tambah "${query}"</span>
                    <span class="item-badge">New</span>
                </div>
            `;
        }

        if (html === '') {
            html = '<div class="no-results">Tidak ada bidang keahlian ditemukan</div>';
        }

        content.html(html);
        dropdown.addClass('show');
        currentHighlightIndex = -1;

        // Bind click events
        content.find('.dropdown-item-custom').on('click', function() {
            const newName = $(this).data('new-name');
            if (newName) {
                addNewKeahlian(newName);
            } else {
                const id = $(this).data('id');
                const name = $(this).data('name');
                addExistingKeahlian(id, name);
            }
        });
    }

    function hideDropdown() {
        $('#topicsDropdown').removeClass('show');
        currentHighlightIndex = -1;
    }

    function updateHighlight(items) {
        items.removeClass('highlighted');
        if (currentHighlightIndex >= 0) {
            items.eq(currentHighlightIndex).addClass('highlighted');
        }
    }

    function addExistingKeahlian(id, name) {
        if (!selectedKeahlians.some(k => k.id === id)) {
            selectedKeahlians.push({ id, name, isNew: false });
            updateSelectedTopics();
            $('#topicsInput').val('');
            hideDropdown();
        }
    }

    function addNewKeahlian(name) {
        const trimmedName = name.trim();
        if (trimmedName && !selectedKeahlians.some(k => k.name.toLowerCase() === trimmedName.toLowerCase())) {
            selectedKeahlians.push({ 
                id: 'new_' + Date.now(), 
                name: trimmedName, 
                isNew: true 
            });
            updateSelectedTopics();
            $('#topicsInput').val('');
            hideDropdown();
        }
    }

    function removeKeahlian(id) {
        selectedKeahlians = selectedKeahlians.filter(k => k.id !== id);
        updateSelectedTopics();
    }

    function updateSelectedTopics() {
        const container = $('#selectedTopics');
        const hiddenContainer = $('#hiddenKeahlianInputs');
        
        let html = '';
        let hiddenHtml = '';

        selectedKeahlians.forEach(keahlian => {
            html += `
                <div class="topic-tag" data-id="${keahlian.id}">
                    <span>${keahlian.name}</span>
                    <span class="remove-topic" onclick="removeTopicTag('${keahlian.id}')">×</span>
                </div>
            `;

            if (keahlian.isNew) {
                hiddenHtml += `<input type="hidden" name="new_keahlian_names[]" value="${keahlian.name}">`;
            } else {
                hiddenHtml += `<input type="hidden" name="lomba_keahlian_ids[]" value="${keahlian.id}">`;
            }
        });

        container.html(html);
        hiddenContainer.html(hiddenHtml);
    }

    // Global function for removing topics
    window.removeTopicTag = function(id) {
        removeKeahlian(id);
    };

    // Form submission
    $('#newCompetitionForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate keahlian selection
        if (selectedKeahlians.length === 0) {
            showValidationError('Pilih minimal satu bidang keahlian');
            return;
        }

        const submitBtn = $('#submitBtn');
        submitBtn.addClass('loading').prop('disabled', true);

        const formData = new FormData(this);

        $.ajax({
            url: "{{ route('dosen.lomba.storeAjax') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonColor: '#102044'
                    }).then(() => {
                        $('#newCompetitionModal').modal('hide');
                        location.reload();
                    });
                } else {
                    showValidationError(response.message || 'Terjadi kesalahan');
                }
            },
            error: function(xhr) {
                let message = 'Terjadi kesalahan saat memproses data';
                
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    message = Object.values(errors).flat().join('\n');
                    
                    // Show field-specific errors
                    Object.keys(errors).forEach(field => {
                        const input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').text(errors[field][0]);
                    });
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                    confirmButtonColor: '#102044'
                });
            },
            complete: function() {
                submitBtn.removeClass('loading').prop('disabled', false);
            }
        });
    });

    function showValidationError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Validasi Error',
            text: message,
            confirmButtonColor: '#102044'
        });
    }

    // Reset form when modal is closed
    $('#newCompetitionModal').on('hidden.bs.modal', function() {
        $('#newCompetitionForm')[0].reset();
        selectedKeahlians = [];
        updateSelectedTopics();
        $('.form-control').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        hideDropdown();
    });

    // Date validation
    $('input[name="lomba_tanggal_mulai"]').on('change', function() {
        const startDate = $(this).val();
        $('input[name="lomba_tanggal_selesai"]').attr('min', startDate);
    });

    $('input[name="lomba_tanggal_selesai"]').on('change', function() {
        const endDate = $(this).val();
        const startDate = $('input[name="lomba_tanggal_mulai"]').val();
        
        if (startDate && endDate < startDate) {
            $(this).val(startDate);
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai',
                confirmButtonColor: '#102044'
            });
        }
    });
});
</script>
