@extends('layouts.template')

@section('title', 'Verifikasi Prestasi - Data Penghargaan | STARS')

@section('page-title', 'Verifikasi Prestasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('student.achievement.create') }}">Verifikasi Prestasi</a></li>
    <li class="breadcrumb-item active">Data Penghargaan</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Progress Steps -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="step-progress">
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pilih Lomba</div>
                            </div>
                            <div class="step-line completed"></div>
                            <div class="step active">
                                <div class="step-number">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="step-title">Data Penghargaan</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-title">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Award Form -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-award mr-2"></i>
                            <div>
                                <h5 class="mb-0 text-white">Data Penghargaan</h5>
                                <small class="text-white-50">Lengkapi informasi penghargaan yang diperoleh</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Competition Info Alert -->
                        @if ($selectedLomba->lomba_terverifikasi == 1)
                            <div class="alert alert-success border-left-success">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x text-success mr-3"></i>
                                    <div>
                                        <strong><i class="fas fa-trophy mr-1"></i>Lomba Terpilih:</strong> {{ $selectedLomba->lomba_nama }} - {{ $selectedLomba->lomba_penyelenggara }}
                                        <br>
                                        <span class="badge badge-success mt-1">
                                            <i class="fas fa-shield-alt mr-1"></i>Terverifikasi
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @elseif($selectedLomba->lomba_terverifikasi == 0)
                            <div class="alert alert-warning border-left-warning">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle fa-2x text-warning mr-3"></i>
                                    <div>
                                        <strong><i class="fas fa-trophy mr-1"></i>Lomba Terpilih:</strong> {{ $selectedLomba->lomba_nama }} - {{ $selectedLomba->lomba_penyelenggara }}
                                        <br>
                                        <span class="badge badge-warning mt-1">
                                            <i class="fas fa-clock mr-1"></i>Menunggu Verifikasi Admin
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form id="awardForm" action="{{ route('student.achievement.finalize') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($selectedLomba)
                                <input type="hidden" name="lomba_id" value="{{ $selectedLomba->id }}">
                            @endif
                            @if ($competitionSubmissionId)
                                <input type="hidden" name="competition_submission_id" value="{{ $competitionSubmissionId }}">
                            @endif

                            <!-- Basic Information Section -->
                            <div class="section-header">
                                <h6 class="text-primary font-weight-bold">
                                    <i class="fas fa-info-circle mr-2"></i>Informasi Dasar Penghargaan
                                </h6>
                                <hr class="section-divider">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-medal mr-1 text-warning"></i>Judul Penghargaan 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="penghargaan_judul" class="form-control form-control-custom" 
                                               placeholder="Masukkan judul penghargaan" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-ranking-star mr-1 text-success"></i>Peringkat 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="peringkat_id" class="form-control form-control-custom" required>
                                            <option value="">Pilih Peringkat</option>
                                            @foreach ($peringkats as $peringkat)
                                                <option value="{{ $peringkat->id }}">{{ $peringkat->peringkat_nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-user-tie mr-1 text-info"></i>Dosen Pembimbing 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="dosen_id" class="form-control form-control-custom" required>
                                            <option value="">Pilih Dosen Pembimbing</option>
                                            @foreach ($dosens as $dosen)
                                                <option value="{{ $dosen->id }}">{{ $dosen->dosen_nama }} - {{ $dosen->dosen_nip }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Pilih dosen yang membimbing dalam lomba ini
                                        </small>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt mr-1 text-danger"></i>Tempat Pelaksanaan 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="penghargaan_tempat" class="form-control form-control-custom" 
                                               placeholder="Masukkan tempat pelaksanaan" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-link mr-1 text-primary"></i>URL Lomba
                                        </label>
                                        <input type="url" name="penghargaan_url" class="form-control form-control-custom" 
                                               placeholder="https://example.com">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Information Section -->
                            <div class="section-header mt-4">
                                <h6 class="text-primary font-weight-bold">
                                    <i class="fas fa-calendar-alt mr-2"></i>Informasi Tanggal
                                </h6>
                                <hr class="section-divider">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-play-circle mr-1 text-success"></i>Tanggal Mulai 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="penghargaan_tanggal_mulai" class="form-control form-control-custom" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-stop-circle mr-1 text-danger"></i>Tanggal Selesai 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="penghargaan_tanggal_selesai" class="form-control form-control-custom" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Competition Details Section -->
                            <div class="section-header mt-4">
                                <h6 class="text-primary font-weight-bold">
                                    <i class="fas fa-chart-bar mr-2"></i>Detail Kompetisi
                                </h6>
                                <hr class="section-divider">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-users mr-1 text-info"></i>Jumlah Peserta 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="penghargaan_jumlah_peserta" class="form-control form-control-custom" 
                                               min="1" placeholder="0" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-building mr-1 text-warning"></i>Jumlah Instansi 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="penghargaan_jumlah_instansi" class="form-control form-control-custom" 
                                               min="1" placeholder="0" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Official Documents Section -->
                            <div class="section-header mt-4">
                                <h6 class="text-primary font-weight-bold">
                                    <i class="fas fa-file-alt mr-2"></i>Dokumen Resmi
                                </h6>
                                <hr class="section-divider">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-file-signature mr-1 text-primary"></i>Nomor Surat Tugas 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="penghargaan_no_surat_tugas" class="form-control form-control-custom" 
                                               placeholder="Masukkan nomor surat tugas" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-calendar-check mr-1 text-success"></i>Tanggal Surat Tugas 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="penghargaan_tanggal_surat_tugas" class="form-control form-control-custom" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- File Upload Section -->
                            <div class="section-header mt-4">
                                <h6 class="text-primary font-weight-bold">
                                    <i class="fas fa-cloud-upload-alt mr-2"></i>Upload Dokumen
                                </h6>
                                <hr class="section-divider">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-file-pdf mr-1 text-danger"></i>File Surat Tugas 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="penghargaan_file_surat_tugas" class="custom-file-input" 
                                                   id="fileSuratTugas" required accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="fileSuratTugas">Pilih file...</label>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Format: PDF, JPG, PNG (Max: 2MB)
                                        </small>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-certificate mr-1 text-warning"></i>File Sertifikat 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="penghargaan_file_sertifikat" class="custom-file-input" 
                                                   id="fileSertifikat" required accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="fileSertifikat">Pilih file...</label>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Format: PDF, JPG, PNG (Max: 2MB)
                                        </small>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-image mr-1 text-info"></i>File Poster
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="penghargaan_file_poster" class="custom-file-input" 
                                                   id="filePoster" accept=".pdf,.jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="filePoster">Pilih file...</label>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Format: PDF, JPG, PNG (Max: 2MB)
                                        </small>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-camera mr-1 text-success"></i>Foto Kegiatan
                                        </label>
                                        <div class="custom-file">
                                            <input type="file" name="penghargaan_photo_kegiatan" class="custom-file-input" 
                                                   id="fotoKegiatan" accept=".jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="fotoKegiatan">Pilih file...</label>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Format: JPG, PNG (Max: 2MB)
                                        </small>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="form-actions mt-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('student.achievement.create') }}" class="btn btn-secondary btn-custom">
                                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-custom" id="submitBtn">
                                        <i class="fas fa-paper-plane mr-1"></i>
                                        <span class="submit-text">Submit Pengajuan</span>
                                        <span class="submit-loading" style="display: none;">
                                            <i class="fas fa-spinner fa-spin mr-1"></i>Processing...
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        /* Step Progress Styling */
        .step-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .step.active .step-number {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            box-shadow: var(--shadow);
        }

        .step.completed .step-number {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: var(--shadow);
        }

        .step-title {
            font-size: 14px;
            text-align: center;
            color: #6c757d;
            font-weight: 500;
        }

        .step.active .step-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        .step.completed .step-title {
            color: #28a745;
            font-weight: 600;
        }

        .step-line {
            width: 100px;
            height: 3px;
            background-color: #e9ecef;
            margin: 0 20px;
            margin-bottom: 25px;
            border-radius: 2px;
        }

        .step-line.completed {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        /* Enhanced Card Styling */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }

        .border-left-success {
            border-left: 4px solid #28a745 !important;
        }

        .border-left-warning {
            border-left: 4px solid var(--accent-color) !important;
        }

        /* Section Headers */
        .section-header {
            margin-bottom: 1.5rem;
        }

        .section-header h6 {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .section-divider {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            margin: 0;
        }

        /* Enhanced Form Controls */
        .form-label {
            font-weight: 600;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-control-custom {
            border-radius: var(--border-radius);
            border: 2px solid #e3e6f0;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .form-control-custom:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(16, 32, 68, 0.25);
        }

        .form-control-custom.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        /* Custom File Upload */
        .custom-file-label {
            border-radius: var(--border-radius);
            border: 2px solid #e3e6f0;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .custom-file-input:focus~.custom-file-label {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(16, 32, 68, 0.25);
        }

        .custom-file-input.is-invalid~.custom-file-label {
            border-color: #dc3545;
        }

        /* Enhanced Buttons */
        .btn-custom {
            padding: 0.75rem 2rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            transition: var(--transition);
            min-width: 150px;
        }

        .btn-primary.btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: var(--shadow);
        }

        .btn-primary.btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 32, 68, 0.3);
        }

        .btn-secondary.btn-custom {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
        }

        .btn-secondary.btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
        }

        /* Form Actions */
        .form-actions {
            background: linear-gradient(135deg, #f8f9fc, #ffffff);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            border: 2px solid #e3e6f0;
        }

        /* Enhanced Alerts */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--shadow);
        }

        /* Loading State */
        .submit-loading {
            display: none;
        }

        #submitBtn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Invalid Feedback */
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
            font-weight: 500;
        }

        .is-invalid~.invalid-feedback {
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .step-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .step-title {
                font-size: 12px;
            }

            .step-line {
                width: 50px;
                margin: 0 10px;
                margin-bottom: 20px;
            }

            .btn-custom {
                min-width: 120px;
                padding: 0.6rem 1.5rem;
            }

            .form-actions {
                padding: 1rem;
            }

            .form-actions .d-flex {
                flex-direction: column;
                gap: 1rem;
            }

            .section-header h6 {
                font-size: 1rem;
            }
        }

        /* Animation for form submission */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .btn-custom.submitting {
            animation: pulse 0.5s ease-in-out;
        }

        /* File upload enhancements */
        .custom-file {
            position: relative;
            overflow: hidden;
        }

        .custom-file-input:lang(en)~.custom-file-label::after {
            content: "Browse";
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        /* Icon styling in labels */
        .form-label i {
            font-size: 1rem;
            margin-right: 0.5rem;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Initialize custom file inputs
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName || 'Pilih file...');
            });

            // Clear validation errors
            function clearValidationErrors() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('').hide();
            }

            // Show validation errors
            function showValidationErrors(errors) {
                clearValidationErrors();
                
                $.each(errors, function(field, messages) {
                    const fieldElement = $(`[name="${field}"]`);
                    fieldElement.addClass('is-invalid');
                    fieldElement.siblings('.invalid-feedback').text(messages[0]).show();
                    
                    // Scroll to first error
                    if (Object.keys(errors).indexOf(field) === 0) {
                        $('html, body').animate({
                            scrollTop: fieldElement.offset().top - 100
                        }, 500);
                    }
                });
            }

            // File size validation
            function validateFileSize(input, maxSize = 2048) {
                const file = input.files[0];
                if (file && file.size > maxSize * 1024) {
                    showError(`File ${file.name} terlalu besar. Maksimal ${maxSize}KB.`);
                    input.value = '';
                    $(input).siblings('.custom-file-label').removeClass('selected').html('Pilih file...');
                    return false;
                }
                return true;
            }

            // File type validation
            function validateFileType(input, allowedTypes) {
                const file = input.files[0];
                if (file) {
                    const fileType = file.type;
                    const fileName = file.name.toLowerCase();
                    const isValidType = allowedTypes.some(type => {
                        if (type.startsWith('.')) {
                            return fileName.endsWith(type);
                        }
                        return fileType.includes(type);
                    });
                    
                    if (!isValidType) {
                        showError(`Format file ${file.name} tidak didukung.`);
                        input.value = '';
                        $(input).siblings('.custom-file-label').removeClass('selected').html('Pilih file...');
                        return false;
                    }
                }
                return true;
            }

            // Validate file inputs
            $('input[type="file"]').on('change', function() {
                const fieldName = $(this).attr('name');
                
                // Define allowed types per field
                const allowedTypes = {
                    'penghargaan_file_surat_tugas': ['.pdf', '.jpg', '.jpeg', '.png'],
                    'penghargaan_file_sertifikat': ['.pdf', '.jpg', '.jpeg', '.png'],
                    'penghargaan_file_poster': ['.pdf', '.jpg', '.jpeg', '.png'],
                    'penghargaan_photo_kegiatan': ['.jpg', '.jpeg', '.png']
                };
                
                if (allowedTypes[fieldName]) {
                    if (!validateFileType(this, allowedTypes[fieldName])) {
                        return;
                    }
                }
                
                validateFileSize(this);
            });

            // Date validation
            $('input[name="penghargaan_tanggal_selesai"]').on('change', function() {
                const startDate = $('input[name="penghargaan_tanggal_mulai"]').val();
                const endDate = $(this).val();
                
                if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                    showError('Tanggal selesai harus setelah atau sama dengan tanggal mulai.');
                    $(this).val('');
                }
            });

            // Form submission with AJAX
            $('#awardForm').on('submit', function(e) {
                e.preventDefault();
                
                clearValidationErrors();
                
                const submitBtn = $('#submitBtn');
                const submitText = submitBtn.find('.submit-text');
                const submitLoading = submitBtn.find('.submit-loading');
                
                // Disable submit button and show loading
                submitBtn.prop('disabled', true).addClass('submitting');
                submitText.hide();
                submitLoading.show();
                
                // Show loading overlay
                showLoading('Memproses pengajuan prestasi...');
                
                // Create FormData for file upload
                const formData = new FormData(this);
                
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    timeout: 30000, // 30 seconds timeout
                    success: function(response) {
                        hideLoading();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pengajuan prestasi berhasil disubmit dan sedang menunggu verifikasi.',
                            confirmButtonColor: '#102044',
                            showClass: {
                                popup: 'animate__animated animate__bounceIn'
                            }
                        }).then((result) => {
                            // Redirect to step 3 or success page
                            window.location.href = response.redirect || '{{ route("student.achievement.create") }}';
                        });
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        
                        // Reset button state
                        submitBtn.prop('disabled', false).removeClass('submitting');
                        submitText.show();
                        submitLoading.hide();
                        
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            showValidationErrors(errors);
                            
                            showError('Mohon perbaiki kesalahan pada form sebelum melanjutkan.');
                        } else if (xhr.status === 413) {
                            // File too large
                            showError('File yang diupload terlalu besar. Maksimal 2MB per file.');
                        } else if (status === 'timeout') {
                            showError('Koneksi timeout. Silakan coba lagi.');
                        } else {
                            showError('Terjadi kesalahan sistem. Silakan coba lagi.');
                        }
                        
                        console.error('Error:', error);
                    }
                });
            });

            // Form validation on field change
            $('input, select, textarea').on('blur change', function() {
                if ($(this).hasClass('is-invalid')) {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.invalid-feedback').hide();
                }
            });

            // Auto-resize textarea if any
            $('textarea').on('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            // Show confirmation before leaving page if form is dirty
            let formChanged = false;
            $('#awardForm input, #awardForm select, #awardForm textarea').on('change input', function() {
                formChanged = true;
            });

            $(window).on('beforeunload', function() {
                if (formChanged && !$('#submitBtn').prop('disabled')) {
                    return 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
                }
            });

            // Remove beforeunload when form is submitted
            $('#awardForm').on('submit', function() {
                formChanged = false;
                $(window).off('beforeunload');
            });
        });
    </script>
@endpush