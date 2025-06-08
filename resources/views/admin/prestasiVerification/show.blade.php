@extends('layouts.template')

@section('title', 'Verifikasi Prestasi - ' . $verifikasi->penghargaan->penghargaan_judul . ' | STARS')

@section('page-title', 'Verifikasi Prestasi Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.prestasiVerification.index') }}">Verifikasi Prestasi</a></li>
    <li class="breadcrumb-item active">Detail Prestasi</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Achievement Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="achievement-header-card">
                    <div class="achievement-content">
                        <!-- Status Badges -->
                        <div class="status-badges mb-4">
                            <!-- Dosen Verification Status -->
                            @if ($verifikasi->verifikasi_dosen_status === 'Diterima')
                                <span class="status-badge dosen-approved">
                                    <i class="fas fa-user-check"></i>
                                    <span>Dosen: Disetujui</span>
                                </span>
                            @elseif($verifikasi->verifikasi_dosen_status === 'Ditolak')
                                <span class="status-badge dosen-rejected">
                                    <i class="fas fa-user-times"></i>
                                    <span>Dosen: Ditolak</span>
                                </span>
                            @else
                                <span class="status-badge dosen-pending">
                                    <i class="fas fa-user-clock"></i>
                                    <span>Dosen: Menunggu</span>
                                </span>
                            @endif

                            <!-- Admin Verification Status -->
                            @if ($verifikasi->verifikasi_admin_status === 'Diterima')
                                <span class="status-badge admin-approved">
                                    <i class="fas fa-shield-check"></i>
                                    <span>Admin: Disetujui</span>
                                </span>
                            @elseif($verifikasi->verifikasi_admin_status === 'Ditolak')
                                <span class="status-badge admin-rejected">
                                    <i class="fas fa-shield-times"></i>
                                    <span>Admin: Ditolak</span>
                                </span>
                            @else
                                <span class="status-badge admin-pending">
                                    <i class="fas fa-shield-halved"></i>
                                    <span>Admin: Menunggu</span>
                                </span>
                            @endif

                            <!-- Overall Status -->
                            @if ($verifikasi->verifikasi_dosen_status === 'Diterima' && $verifikasi->verifikasi_admin_status === 'Diterima')
                                <span class="status-badge verified">
                                    <i class="fas fa-certificate"></i>
                                    <span>Terverifikasi</span>
                                </span>
                            @elseif($verifikasi->verifikasi_dosen_status === 'Ditolak' || $verifikasi->verifikasi_admin_status === 'Ditolak')
                                <span class="status-badge rejected">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Ditolak</span>
                                </span>
                            @else
                                <span class="status-badge pending">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span>Dalam Proses</span>
                                </span>
                            @endif
                        </div>

                        <!-- Achievement Title and Score -->
                        <div class="achievement-title-section">
                            <h1 class="achievement-title">{{ $verifikasi->penghargaan->penghargaan_judul }}</h1>
                            <div class="achievement-score">
                                <div class="score-card">
                                    <div class="score-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="score-content">
                                        <div class="score-value">{{ $verifikasi->penghargaan->penghargaan_score ?? 0 }}
                                        </div>
                                        <div class="score-label">Poin Prestasi</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Student Meta Info -->
                        <div class="student-meta">
                            <div class="meta-item">
                                <i class="fas fa-user-graduate"></i>
                                <span>{{ $verifikasi->mahasiswa->mahasiswa_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-id-card"></i>
                                <span>{{ $verifikasi->mahasiswa->mahasiswa_nim ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-university"></i>
                                <span>{{ $verifikasi->mahasiswa->prodi->prodi_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-trophy"></i>
                                <span>{{ $verifikasi->penghargaan->lomba->lomba_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-medal"></i>
                                <span>{{ $verifikasi->penghargaan->peringkat->peringkat_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-layer-group"></i>
                                <span>{{ $verifikasi->penghargaan->lomba->tingkatan->tingkatan_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_mulai)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Cards -->
        <div class="row g-4">
            <!-- Competition Information -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h5 class="header-title">Informasi Lomba</h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Nama Lomba</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->lomba->lomba_nama ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Penyelenggara</div>
                                <div class="detail-value">
                                    {{ $verifikasi->penghargaan->lomba->lomba_penyelenggara ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Kategori</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->lomba->lomba_kategori ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Tingkatan</div>
                                <div class="detail-value">
                                    {{ $verifikasi->penghargaan->lomba->tingkatan->tingkatan_nama ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievement Details -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h5 class="header-title">Detail Prestasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Peringkat</div>
                                <div class="detail-value">
                                    {{ $verifikasi->penghargaan->peringkat->peringkat_nama ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Tempat Pelaksanaan</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->penghargaan_tempat ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Jumlah Peserta</div>
                                <div class="detail-value">
                                    {{ $verifikasi->penghargaan->penghargaan_jumlah_peserta ?? 'N/A' }} peserta</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Jumlah Instansi</div>
                                <div class="detail-value">
                                    {{ $verifikasi->penghargaan->penghargaan_jumlah_instansi ?? 'N/A' }} instansi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="row g-4 mt-2">
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5 class="header-title">Timeline Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline-modern">
                            <div class="timeline-item">
                                <div class="timeline-marker start"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Mulai Kegiatan</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_mulai)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker end"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Selesai Kegiatan</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_selesai)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker document"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Surat Tugas</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_surat_tugas)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                    <small class="timeline-note">No:
                                        {{ $verifikasi->penghargaan->penghargaan_no_surat_tugas }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h5 class="header-title">Dokumen Pendukung</h5>
                    </div>
                    <div class="card-body">
                        <div class="documents-grid">
                            @if ($verifikasi->penghargaan->penghargaan_file_sertifikat)
                                <div class="document-item" style="cursor: pointer;"
                                    onclick="previewDocument('{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_file_sertifikat) }}', 'Sertifikat')">
                                    <div class="document-icon">
                                        <i class="fas fa-certificate"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Sertifikat</div>
                                        <div class="document-link">
                                            <i class="fas fa-eye"></i> Preview
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($verifikasi->penghargaan->penghargaan_file_surat_tugas)
                                <div class="document-item" style="cursor: pointer;"
                                    onclick="previewDocument('{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_file_surat_tugas) }}', 'Surat Tugas')">
                                    <div class="document-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Surat Tugas</div>
                                        <div class="document-link">
                                            <i class="fas fa-eye"></i> Preview
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($verifikasi->penghargaan->penghargaan_file_poster)
                                <div class="document-item" style="cursor: pointer;"
                                    onclick="previewDocument('{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_file_poster) }}', 'Poster Kegiatan')">
                                    <div class="document-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Poster Kegiatan</div>
                                        <div class="document-link">
                                            <i class="fas fa-eye"></i> Preview
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($verifikasi->penghargaan->penghargaan_photo_kegiatan)
                                <div class="document-item" style="cursor: pointer;"
                                    onclick="previewDocument('{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_photo_kegiatan) }}', 'Foto Kegiatan')">
                                    <div class="document-icon">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Foto Kegiatan</div>
                                        <div class="document-link">
                                            <i class="fas fa-eye"></i> Preview
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Details -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h5 class="header-title">Detail Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Dosen Verification -->
                            <div class="col-lg-6">
                                <div class="verification-section">
                                    <h6 class="verification-title">
                                        <i class="fas fa-user-tie"></i>
                                        Verifikasi Dosen Pembimbing
                                    </h6>
                                    <div class="verification-details">
                                        <div class="detail-item">
                                            <div class="detail-label">Dosen Pembimbing</div>
                                            <div class="detail-value">{{ $verifikasi->dosen->dosen_nama ?? 'N/A' }}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Status</div>
                                            <div class="detail-value">
                                                @if ($verifikasi->verifikasi_dosen_status === 'Diterima')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif($verifikasi->verifikasi_dosen_status === 'Ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($verifikasi->verifikasi_dosen_tanggal)
                                            <div class="detail-item">
                                                <div class="detail-label">Tanggal Verifikasi</div>
                                                <div class="detail-value">
                                                    {{ \Carbon\Carbon::parse($verifikasi->verifikasi_dosen_tanggal)->locale('id')->translatedFormat('d F Y') }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($verifikasi->verifikasi_dosen_keterangan)
                                            <div class="detail-item">
                                                <div class="detail-label">Keterangan</div>
                                                <div class="detail-value">{{ $verifikasi->verifikasi_dosen_keterangan }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Verification -->
                            <div class="col-lg-6">
                                <div class="verification-section">
                                    <h6 class="verification-title">
                                        <i class="fas fa-user-shield"></i>
                                        Verifikasi Admin
                                    </h6>
                                    <div class="verification-details">
                                        <div class="detail-item">
                                            <div class="detail-label">Admin</div>
                                            <div class="detail-value">
                                                {{ $verifikasi->admin->admin_nama ?? 'Belum ditugaskan' }}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Status</div>
                                            <div class="detail-value">
                                                @if ($verifikasi->verifikasi_admin_status === 'Diterima')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif($verifikasi->verifikasi_admin_status === 'Ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($verifikasi->verifikasi_admin_tanggal)
                                            <div class="detail-item">
                                                <div class="detail-label">Tanggal Verifikasi</div>
                                                <div class="detail-value">
                                                    {{ \Carbon\Carbon::parse($verifikasi->verifikasi_admin_tanggal)->locale('id')->translatedFormat('d F Y') }}
                                                </div>
                                            </div>
                                        @endif
                                        @if ($verifikasi->verifikasi_admin_keterangan)
                                            <div class="detail-item">
                                                <div class="detail-label">Keterangan</div>
                                                <div class="detail-value">{{ $verifikasi->verifikasi_admin_keterangan }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Action Card -->
        @if ($verifikasi->verifikasi_admin_status === 'Menunggu')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="verification-action-card">
                        <div class="card-header-custom">
                            <div class="header-icon">
                                <i class="fas fa-gavel"></i>
                            </div>
                            <h5 class="header-title">Keputusan Verifikasi Admin</h5>
                        </div>
                        <div class="card-body">
                            <form id="verificationForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="keterangan" class="form-label">Keterangan Verifikasi</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                        placeholder="Berikan keterangan untuk keputusan verifikasi ini..."></textarea>
                                </div>
                                <div class="verification-actions">
                                    <button type="button" class="btn btn-success btn-verify"
                                        onclick="submitVerification('Diterima')">
                                        <i class="fas fa-check mr-2"></i>Terima Prestasi
                                    </button>
                                    <button type="button" class="btn btn-danger btn-verify"
                                        onclick="submitVerification('Ditolak')">
                                        <i class="fas fa-times mr-2"></i>Tolak Prestasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="row mt-4">
            <div class="col-12">
                <a href="{{ route('admin.prestasiVerification.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Daftar Verifikasi</span>
                </a>
            </div>
        </div>
    </div>
        @include('admin.prestasiVerification.previewModal')
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/verifPrestasi.css') }}">
@endpush

@push('js')
    <script>
        function submitVerification(status) {
            const keterangan = $('#keterangan').val();

            Swal.fire({
                title: 'Konfirmasi Verifikasi',
                text: `Apakah Anda yakin ingin ${status.toLowerCase()} prestasi ini?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: status === 'Diterima' ? '#10b981' : '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Ya, ${status}`,
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading('Memproses verifikasi...');

                    $.ajax({
                        url: "{{ route('admin.prestasiVerification.verify', $verifikasi->id) }}",
                        type: 'POST',
                        data: {
                            status: status,
                            keterangan: keterangan,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            hideLoading();

                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    confirmButtonColor: '#102044'
                                }).then(() => {
                                    window.location.href =
                                        "{{ route('admin.prestasiVerification.index') }}";
                                });
                            } else {
                                showError(response.message ||
                                    'Terjadi kesalahan saat memproses verifikasi.');
                            }
                        },
                        error: function(xhr) {
                            hideLoading();

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;
                                let errorMessage = '';
                                for (let field in errors) {
                                    errorMessage += `• ${errors[field][0]}\n`;
                                }
                                showError(errorMessage);
                            } else {
                                showError('Terjadi kesalahan saat memproses verifikasi.');
                            }
                        }
                    });
                }
            });
        }

        function previewDocument(fileUrl, fileName) {
            // Set modal title
            $('#documentPreviewModalLabel').html('<i class="fas fa-file-alt mr-2"></i>' + fileName);

            // Set download button href
            $('#downloadBtn').attr('href', fileUrl);

            // Show loading spinner
            $('#documentContent').html(`
                <div class="loading-spinner d-flex justify-content-center align-items-center" style="height: 500px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            // Show modal using Bootstrap 4 syntax
            $('#documentPreviewModal').modal('show');

            // Get file extension
            const fileExtension = fileUrl.split('.').pop().toLowerCase();

            // Create content based on file type
            let content = '';

            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
                // Image files
                content =
                    `<img src="${fileUrl}" alt="${fileName}" class="img-fluid" style="max-height: 70vh; object-fit: contain;">`;

                // Load image and replace content
                const img = new Image();
                img.onload = function() {
                    $('#documentContent').html(content);
                };
                img.onerror = function() {
                    $('#documentContent').html(`
                        <div class="alert alert-danger m-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Gagal memuat gambar. File mungkin rusak atau tidak dapat diakses.
                        </div>
                    `);
                };
                img.src = fileUrl;

            } else if (fileExtension === 'pdf') {
                // PDF files
                content = `<iframe src="${fileUrl}" style="width: 100%; height: 70vh; border: none;"></iframe>`;

                setTimeout(() => {
                    $('#documentContent').html(content);
                }, 500);

            } else if (['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(fileExtension)) {
                // Office documents - use Google Docs viewer
                const viewerUrl = `https://docs.google.com/viewer?url=${encodeURIComponent(fileUrl)}&embedded=true`;
                content = `<iframe src="${viewerUrl}" style="width: 100%; height: 70vh; border: none;"></iframe>`;

                setTimeout(() => {
                    $('#documentContent').html(content);
                }, 500);

            } else {
                // Unsupported file types
                content = `
                    <div class="alert alert-info m-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        <h5>File tidak dapat dipratinjau</h5>
                        <p>Tipe file ini tidak mendukung pratinjau langsung. Silakan unduh file untuk melihat isinya.</p>
                        <a href="${fileUrl}" class="btn btn-primary" target="_blank" download>
                            <i class="fas fa-download mr-2"></i>Download ${fileName}
                        </a>
                    </div>
                `;

                setTimeout(() => {
                    $('#documentContent').html(content);
                }, 500);
            }
        }

        // Handle modal cleanup when closed - Bootstrap 4 syntax
        $('#documentPreviewModal').on('hidden.bs.modal', function() {
            $('#documentContent').html(`
                <div class="loading-spinner d-flex justify-content-center align-items-center" style="height: 500px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);
        });

        // Manual close handlers for better compatibility
        $(document).on('click', '[data-dismiss="modal"]', function() {
            $(this).closest('.modal').modal('hide');
        });

        // Close modal when clicking outside (backdrop)
        $(document).on('click', '.modal', function(e) {
            if (e.target === this) {
                $(this).modal('hide');
            }
        });

        // Close modal with Escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('#documentPreviewModal').hasClass('show')) {
                $('#documentPreviewModal').modal('hide');
            }
        });
    </script>
@endpush
