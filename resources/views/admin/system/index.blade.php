@extends('layouts.template')

@section('title', 'Pengaturan Sistem | STARS')

@section('page-title', 'Pengaturan Sistem')

@section('breadcrumb')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Alert Container for AJAX responses -->
            <div id="alert-container"></div>

            <div class="card shadow-sm border-0">
                <div class="card-header py-3 bg-gradient-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-cogs mr-2"></i>
                        Pengaturan Sistem
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="nav flex-column nav-pills settings-tabs" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <a class="nav-link {{ !session('tab') || session('tab') == 'pdf' ? 'active' : '' }}"
                                    id="v-pills-pdf-tab" data-toggle="pill" href="#v-pills-pdf" role="tab"
                                    aria-controls="v-pills-pdf" aria-selected="true">
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    <span class="nav-text">Pengaturan Kop Surat PDF</span>
                                </a>
                                <a class="nav-link {{ session('tab') == 'banner' ? 'active' : '' }}" id="v-pills-banner-tab"
                                    data-toggle="pill" href="#v-pills-banner" role="tab" aria-controls="v-pills-banner"
                                    aria-selected="false">
                                    <i class="fas fa-image mr-2"></i>
                                    <span class="nav-text">Pengaturan Banner</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!-- PDF Settings Tab -->
                                <div class="tab-pane fade {{ !session('tab') || session('tab') == 'pdf' ? 'show active' : '' }}"
                                    id="v-pills-pdf" role="tabpanel" aria-labelledby="v-pills-pdf-tab">
                                    <div class="settings-header mb-4">
                                        <h5 class="settings-title">
                                            <i class="fas fa-file-pdf text-accent mr-2"></i>
                                            Pengaturan Kop Surat PDF
                                        </h5>
                                        <p class="text-muted mb-0">Atur informasi yang akan ditampilkan pada kop surat PDF
                                        </p>
                                    </div>

                                    <form id="pdfSettingsForm" action="{{ route('admin.system.updatePdfSettings') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-section">
                                            <h6 class="form-section-title">
                                                <i class="fas fa-building mr-2"></i>
                                                Informasi Instansi
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_instansi1" class="form-label">Instansi Baris
                                                            1</label>
                                                        <input type="text" class="form-control modern-input"
                                                            id="pdf_instansi1" name="pdf_instansi1"
                                                            value="{{ old('pdf_instansi1', $pdfSetting->pdf_instansi1) }}"
                                                            placeholder="Nama instansi baris pertama">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_instansi2" class="form-label">Instansi Baris
                                                            2</label>
                                                        <input type="text" class="form-control modern-input"
                                                            id="pdf_instansi2" name="pdf_instansi2"
                                                            value="{{ old('pdf_instansi2', $pdfSetting->pdf_instansi2) }}"
                                                            placeholder="Nama instansi baris kedua">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="pdf_alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control modern-input" id="pdf_alamat" name="pdf_alamat" rows="3"
                                                    placeholder="Alamat lengkap instansi">{{ old('pdf_alamat', $pdfSetting->pdf_alamat) }}</textarea>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <h6 class="form-section-title">
                                                <i class="fas fa-phone mr-2"></i>
                                                Informasi Kontak
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_telepon" class="form-label">Telepon</label>
                                                        <input type="text" class="form-control modern-input"
                                                            id="pdf_telepon" name="pdf_telepon"
                                                            value="{{ old('pdf_telepon', $pdfSetting->pdf_telepon) }}"
                                                            placeholder="(0341) 123456">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_fax" class="form-label">Fax</label>
                                                        <input type="text" class="form-control modern-input"
                                                            id="pdf_fax" name="pdf_fax"
                                                            value="{{ old('pdf_fax', $pdfSetting->pdf_fax) }}"
                                                            placeholder="(0341) 654321">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_pes" class="form-label">Pes</label>
                                                        <input type="text" class="form-control modern-input"
                                                            id="pdf_pes" name="pdf_pes"
                                                            value="{{ old('pdf_pes', $pdfSetting->pdf_pes) }}"
                                                            placeholder="123">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_website" class="form-label">Website</label>
                                                        <input type="text" class="form-control modern-input"
                                                            id="pdf_website" name="pdf_website"
                                                            value="{{ old('pdf_website', $pdfSetting->pdf_website) }}"
                                                            placeholder="www.example.com">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-section">
                                            <h6 class="form-section-title">
                                                <i class="fas fa-images mr-2"></i>
                                                Logo Instansi
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_logo_kiri" class="form-label">Logo Kiri <small
                                                                class="text-muted">(Max: 100KB)</small></label>
                                                        <div class="custom-file-wrapper">
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input modern-file-input"
                                                                    id="pdf_logo_kiri" name="pdf_logo_kiri"
                                                                    accept="image/*">
                                                                <label class="custom-file-label" for="pdf_logo_kiri">Pilih
                                                                    file...</label>
                                                            </div>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        @if ($pdfSetting->pdf_logo_kiri)
                                                            <div class="mt-3 text-center">
                                                                <div class="current-image-wrapper">
                                                                    <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kiri) }}"
                                                                        alt="Logo Kiri" class="current-image">
                                                                    <small class="d-block text-muted mt-1">Logo saat
                                                                        ini</small>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="pdf_logo_kanan" class="form-label">Logo Kanan <small
                                                                class="text-muted">(Max: 100KB)</small></label>
                                                        <div class="custom-file-wrapper">
                                                            <div class="custom-file">
                                                                <input type="file"
                                                                    class="custom-file-input modern-file-input"
                                                                    id="pdf_logo_kanan" name="pdf_logo_kanan"
                                                                    accept="image/*">
                                                                <label class="custom-file-label"
                                                                    for="pdf_logo_kanan">Pilih file...</label>
                                                            </div>
                                                            <div class="invalid-feedback"></div>
                                                        </div>
                                                        @if ($pdfSetting->pdf_logo_kanan)
                                                            <div class="mt-3 text-center">
                                                                <div class="current-image-wrapper">
                                                                    <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kanan) }}"
                                                                        alt="Logo Kanan" class="current-image">
                                                                    <small class="d-block text-muted mt-1">Logo saat
                                                                        ini</small>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="pdf-preview-section">
                                            <h6 class="form-section-title">
                                                <i class="fas fa-eye mr-2"></i>
                                                Pratinjau Kop Surat
                                            </h6>
                                            <div class="pdf-preview-container">
                                                <table class="preview-table">
                                                    <tr>
                                                        <td width="15%" class="text-center">
                                                            @if ($pdfSetting->pdf_logo_kiri)
                                                                <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kiri) }}"
                                                                    alt="Logo Kiri" class="preview-logo">
                                                            @else
                                                                <img src="{{ asset('img/poltek100.png') }}"
                                                                    alt="Logo Default" class="preview-logo">
                                                            @endif
                                                        </td>
                                                        <td width="70%" class="text-center preview-content">
                                                            <div class="preview-title">
                                                                {{ $pdfSetting->pdf_instansi1 ?: ' ' }}</div>
                                                            <div class="preview-subtitle">
                                                                {{ $pdfSetting->pdf_instansi2 ?: ' ' }}</div>
                                                            <div class="preview-address">
                                                                {{ $pdfSetting->pdf_alamat ?: ' ' }}</div>
                                                            <div class="preview-contact">
                                                                {{ 'Telepon ' .
                                                                    ($pdfSetting->pdf_telepon ?: ' ') .
                                                                    ($pdfSetting->pdf_pes ? ' Pes. ' . $pdfSetting->pdf_pes : '') .
                                                                    ($pdfSetting->pdf_fax ? ', Fax. ' . $pdfSetting->pdf_fax : '') }}
                                                            </div>
                                                            <div class="preview-website">
                                                                {{ 'Laman: ' . ($pdfSetting->pdf_website ?: '') }}</div>
                                                        </td>
                                                        <td width="15%" class="text-center">
                                                            @if ($pdfSetting->pdf_logo_kanan)
                                                                <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kanan) }}"
                                                                    alt="Logo Kanan" class="preview-logo">
                                                            @else
                                                                <img src="{{ asset('img/logo100.png') }}"
                                                                    alt="Logo Default" class="preview-logo">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-save mr-2"></i>
                                                <span class="btn-text">Simpan Pengaturan</span>
                                                <span class="spinner-border spinner-border-sm ml-2 d-none"
                                                    role="status"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Banner Settings Tab -->
                                <div class="tab-pane fade {{ session('tab') == 'banner' ? 'show active' : '' }}"
                                    id="v-pills-banner" role="tabpanel" aria-labelledby="v-pills-banner-tab">
                                    <div class="settings-header mb-4">
                                        <h5 class="settings-title">
                                            <i class="fas fa-image text-accent mr-2"></i>
                                            Pengaturan Banner
                                        </h5>
                                        <p class="text-muted mb-0">Kelola banner yang ditampilkan di halaman publik</p>
                                    </div>

                                    <div class="table-container">
                                        <div class="table-responsive">
                                            <table class="table table-modern" id="bannersTable">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th width="25%">Nama</th>
                                                        <th width="30%">Link</th>
                                                        <th width="25%">Gambar</th>
                                                        <th width="15%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($banners as $index => $banner)
                                                        <tr>
                                                            <td>
                                                                <span class="table-number">{{ $index + 1 }}</span>
                                                            </td>
                                                            <td>
                                                                <div class="banner-name">{{ $banner->banner_nama }}</div>
                                                            </td>
                                                            <td>
                                                                <a href="{{ $banner->banner_link }}" target="_blank"
                                                                    class="banner-link">
                                                                    <i class="fas fa-external-link-alt mr-1"></i>
                                                                    {{ Str::limit($banner->banner_link, 30) }}
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($banner->banner_gambar)
                                                                    <div class="banner-image-wrapper">
                                                                        <img src="{{ asset('storage/' . $banner->banner_gambar) }}"
                                                                            alt="{{ $banner->banner_nama }}"
                                                                            class="banner-thumbnail" data-toggle="modal"
                                                                            data-target="#imagePreviewModal"
                                                                            data-src="{{ asset('storage/' . $banner->banner_gambar) }}"
                                                                            data-title="{{ $banner->banner_nama }}">
                                                                    </div>
                                                                @else
                                                                    <span class="badge badge-secondary">
                                                                        <i class="fas fa-image mr-1"></i>
                                                                        No Image
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-warning btn-sm modern-btn"
                                                                    onclick="openEditModal('{{ route('admin.system.editBannerModal', $banner->id) }}')">
                                                                    <i class="fas fa-edit"></i>
                                                                    <span
                                                                        class="btn-text d-none d-md-inline ml-1">Edit</span>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center py-5">
                                                                <div class="empty-state">
                                                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                                    <h6 class="text-muted">Tidak ada data banner</h6>
                                                                    <p class="text-muted small">Banner akan ditampilkan di
                                                                        sini setelah ditambahkan</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center p-0">
                    <img src="" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Generic Modal for Edit -->
    <div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('css')
    <style>
        :root {
            --primary-color-rgb: 16, 32, 68;
            --accent-color-rgb: 250, 157, 28;
        }

        .settings-header {
            border-bottom: 2px solid var(--light-gray);
            padding-bottom: 1rem;
        }

        .settings-title {
            color: var(--heading-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .settings-tabs {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .settings-tabs .nav-link {
            color: var(--text-color);
            padding: 1rem 1.5rem;
            transition: var(--transition);
            border-radius: 0;
            border: none;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
        }

        .settings-tabs .nav-link.active {
            background: linear-gradient(135deg, rgba(var(--primary-color-rgb), 0.1), rgba(var(--primary-color-rgb), 0.05));
            color: var(--primary-color);
            font-weight: 600;
            border-left: 3px solid var(--primary-color);
        }

        .settings-tabs .nav-link:hover:not(.active) {
            background-color: var(--light-gray);
            color: var(--primary-color);
        }

        .settings-tabs .nav-link i {
            font-size: 1.1rem;
            width: 20px;
        }

        .form-section {
            background: var(--white);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 0.3rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .form-section-title {
            color: var(--heading-color);
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--light-gray);
        }

        .form-label {
            color: var(--heading-color);
            font-weight: 500;
            margin-bottom: 0.5rem;
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

        .custom-file-input:focus~.custom-file-label {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(var(--primary-color-rgb), 0.1);
        }

        .current-image-wrapper {
            background: var(--light-gray);
            border-radius: 8px;
            padding: 1rem;
            display: inline-block;
        }

        .current-image {
            height: 60px;
            max-width: 120px;
            object-fit: contain;
            border-radius: 4px;
        }

        .pdf-preview-section {
            background: var(--light-gray);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .pdf-preview-container {
            background: var(--white);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .preview-table {
            width: 100%;
            margin: 0;
        }

        .preview-logo {
            height: 70px;
            max-width: 80px;
            object-fit: contain;
        }

        .preview-content {
            padding: 0 1rem;
        }

        .preview-title {
            font-size: 16px;
            font-weight: bold;
            color: var(--heading-color);
            margin-bottom: 4px;
        }

        .preview-subtitle {
            font-size: 14px;
            font-weight: bold;
            color: var(--heading-color);
            margin-bottom: 6px;
        }

        .preview-address,
        .preview-contact,
        .preview-website {
            font-size: 12px;
            color: var(--text-color);
            margin-bottom: 2px;
        }

        .form-actions {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid var(--light-gray);
        }

        .btn-lg {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            border-radius: 8px;
            font-weight: 600;
        }

        .table-container {
            background: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-modern {
            margin-bottom: 0;
        }

        .table-modern thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            font-weight: 600;
            border: none;
            padding: 1rem;
            text-align: center;
        }

        .table-modern tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-modern tbody tr:hover {
            background-color: rgba(var(--primary-color-rgb), 0.02);
        }

        .table-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: var(--accent-color);
            color: var(--white);
            border-radius: 50%;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .banner-name {
            font-weight: 500;
            color: var(--heading-color);
        }

        .banner-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .banner-link:hover {
            color: var(--accent-color);
            text-decoration: none;
        }

        .banner-image-wrapper {
            position: relative;
            display: inline-block;
        }

        .banner-thumbnail {
            max-height: 60px;
            max-width: 100px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .banner-thumbnail:hover {
            border-color: var(--primary-color);
            transform: scale(1.05);
        }

        .modern-btn {
            border-radius: 6px;
            font-weight: 500;
            transition: var(--transition);
            border: none;
        }

        .empty-state {
            padding: 2rem;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)) !important;
        }

        /* Alert Styles */
        .alert-custom {
            border: none;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .alert-success-custom {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger-custom {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Responsive Design */
        @media (max-width: 767px) {
            .settings-tabs {
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
                margin-bottom: 1.5rem;
            }

            .settings-tabs .nav-link {
                border-left: none;
                border-bottom: 3px solid transparent;
                min-width: max-content;
            }

            .settings-tabs .nav-link.active {
                border-left: none;
                border-bottom: 3px solid var(--primary-color);
            }

            .nav-text {
                display: none;
            }

            .form-section {
                padding: 1rem;
            }

            .btn-text {
                display: none;
            }

            .table-modern tbody td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            if (typeof bsCustomFileInput !== 'undefined') {
                bsCustomFileInput.init();
            }

            $('[data-toggle="tooltip"]').tooltip();

            $('#pdfSettingsForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const btnText = submitBtn.find('.btn-text');
                const spinner = submitBtn.find('.spinner-border');

                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');

                submitBtn.prop('disabled', true);
                btnText.text('Menyimpan...');
                spinner.removeClass('d-none');

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Sedang memproses pengaturan PDF',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData(this);

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message ||
                                'Pengaturan PDF berhasil disimpan!',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#102044',
                            timer: 3000,
                            timerProgressBar: true,
                            allowOutsideClick: false
                        }).then((result) => {
                            updatePreview();

                            $('html, body').animate({
                                scrollTop: 0
                            }, 500);
                        });
                    },
                    error: function(xhr) {
                        Swal.close();

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = [];

                            Object.keys(errors).forEach(function(key) {
                                const input = form.find(`[name="${key}"]`);
                                input.addClass('is-invalid');
                                input.closest('.form-group').find('.invalid-feedback')
                                    .text(errors[key][0]);
                                errorMessages.push(errors[key][0]);
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan Validasi',
                                html: `
                                    <div class="text-left">
                                        <p class="mb-2">Terdapat kesalahan dalam pengisian form:</p>
                                        <ul class="list-unstyled">
                                            ${errorMessages.map(msg => `<li class="text-danger mb-1"><i class="fas fa-exclamation-circle mr-2"></i>${msg}</li>`).join('')}
                                        </ul>
                                    </div>
                                `,
                                confirmButtonText: 'Perbaiki',
                                confirmButtonColor: '#dc3545',
                                allowOutsideClick: false
                            }).then(() => {
                                form.find('.is-invalid').first().focus();
                            });
                        } else if (xhr.status === 413) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Terlalu Besar',
                                text: 'Ukuran file yang diunggah melebihi batas maksimal. Silakan pilih file yang lebih kecil.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#dc3545'
                            });
                        } else {
                            const errorMessage = xhr.responseJSON?.message ||
                                'Terjadi kesalahan sistem. Silakan coba lagi.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Kesalahan Sistem',
                                text: errorMessage,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        btnText.text('Simpan Pengaturan');
                        spinner.addClass('d-none');
                    }
                });
            });

            $('#pdf_logo_kiri, #pdf_logo_kanan').on('change', function() {
                const file = this.files[0];
                const $input = $(this);
                const maxSize = 100 * 1024; // 100KB in bytes

                $input.removeClass('is-invalid');
                $input.closest('.form-group').find('.invalid-feedback').text('');

                if (file) {
                    if (file.size > maxSize) {
                        $input.addClass('is-invalid');
                        $input.closest('.form-group').find('.invalid-feedback').text(
                            'Ukuran file tidak boleh lebih dari 100KB');

                        Swal.fire({
                            icon: 'warning',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file tidak boleh lebih dari 100KB. Silakan pilih file yang lebih kecil.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#fa9d1c'
                        });

                        $input.val('');
                        if (typeof bsCustomFileInput !== 'undefined') {
                            bsCustomFileInput.init();
                        }
                        return;
                    }

                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        $input.addClass('is-invalid');
                        $input.closest('.form-group').find('.invalid-feedback').text(
                            'Format file harus JPG, JPEG, atau PNG');

                        Swal.fire({
                            icon: 'warning',
                            title: 'Format File Salah',
                            text: 'Format file harus JPG, JPEG, atau PNG',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#fa9d1c'
                        });

                        $input.val('');
                        if (typeof bsCustomFileInput !== 'undefined') {
                            bsCustomFileInput.init();
                        }
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        updateLogoPreview(e.target.result, $input.attr('id'));
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#pdf_instansi1, #pdf_instansi2').on('input', function() {
                const $input = $(this);
                const value = $input.val().trim();

                $input.removeClass('is-invalid');
                $input.closest('.form-group').find('.invalid-feedback').text('');

                if (value.length > 255) {
                    $input.addClass('is-invalid');
                    $input.closest('.form-group').find('.invalid-feedback').text('Maksimal 255 karakter');
                }
            });

            $('#pdf_alamat').on('input', function() {
                const $input = $(this);
                const value = $input.val().trim();

                $input.removeClass('is-invalid');
                $input.closest('.form-group').find('.invalid-feedback').text('');

                if (value.length > 500) {
                    $input.addClass('is-invalid');
                    $input.closest('.form-group').find('.invalid-feedback').text('Maksimal 500 karakter');
                }
            });

            $('#pdf_instansi1, #pdf_instansi2, #pdf_alamat, #pdf_telepon, #pdf_fax, #pdf_pes, #pdf_website').on(
                'input', debounce(function() {
                    updateTextPreview();
                }, 500));

            $('#imagePreviewModal').on('show.bs.modal', function(e) {
                const trigger = $(e.relatedTarget);
                const src = trigger.data('src');
                const title = trigger.data('title');

                $(this).find('.modal-title').text(title);
                $(this).find('.modal-body img').attr('src', src).attr('alt', title);
            });
        });

         function openEditModal(url) {
            $('#genericModal').html(`
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body text-center p-4">
                            <i class="fas fa-spinner fa-spin fa-2x text-primary mb-3"></i>
                            <p>Memuat data...</p>
                        </div>
                    </div>
                </div>
            `);
            
            $('#genericModal').modal({
                backdrop: 'static',
                keyboard: true
            });

            $.get(url)
                .done(function(data) {
                    $('#genericModal').html(data);
                    
                    setTimeout(function() {
                        if (typeof bsCustomFileInput !== 'undefined') {
                            bsCustomFileInput.init();
                        }
                        
                        $('#genericModal').modal('handleUpdate');
                    }, 100);
                })
                .fail(function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat memuat data.';
                    
                    if (xhr.status === 404) {
                        errorMessage = 'Data tidak ditemukan.';
                    } else if (xhr.status === 403) {
                        errorMessage = 'Anda tidak memiliki akses untuk melihat data ini.';
                    }
                    
                    $('#genericModal').html(`
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title text-white">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Error
                                    </h5>
                                    <button type="button" class="close text-white" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center py-4">
                                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                    <p class="mb-3">${errorMessage}</p>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fas fa-times mr-1"></i>
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    `);
                });
        }

        function updateLogoPreview(src, inputId) {
            const side = inputId.includes('kiri') ? 'kiri' : 'kanan';
            const previewImg = $(`.preview-table td:${side === 'kiri' ? 'first' : 'last'}-child img`);
            previewImg.attr('src', src);
        }

        function updateTextPreview() {
            const instansi1 = $('#pdf_instansi1').val() || 'STARS - Student Achievement Record System';
            const instansi2 = $('#pdf_instansi2').val() || 'POLITEKNIK NEGERI MALANG';
            const alamat = $('#pdf_alamat').val() || 'Jl. Soekarno-Hatta No. 9 Malang 65141';
            const telepon = $('#pdf_telepon').val() || '(0341) 404424';
            const pes = $('#pdf_pes').val();
            const fax = $('#pdf_fax').val();
            const website = $('#pdf_website').val() || 'www.polinema.ac.id';

            $('.preview-title').text(instansi1);
            $('.preview-subtitle').text(instansi2);
            $('.preview-address').text(alamat);

            let contactText = 'Telepon ' + telepon;
            if (pes) contactText += ' Pes. ' + pes;
            if (fax) contactText += ', Fax. ' + fax;
            $('.preview-contact').text(contactText);

            $('.preview-website').text('Laman: ' + website);
        }

        function updatePreview() {
            updateTextPreview();
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    </script>
@endpush
