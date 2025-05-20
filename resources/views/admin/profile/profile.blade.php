@extends('layouts.template')

@section('title', 'Profil | STARS')

@section('page-title', 'Profil Saya')

@section('breadcrumb')
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error') || $errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') ?? $errors->first() }}</span>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-body">

                    <div class="profile-tabs">
                        <div class="tabs-wrapper">
                            <input type="radio" name="profile-tab" id="tab1" checked>
                            <label for="tab1" class="tab"><i class="fas fa-user mr-2"></i> Informasi Profil</label>

                            <input type="radio" name="profile-tab" id="tab2">
                            <label for="tab2" class="tab"><i class="fas fa-lock mr-2"></i> Ubah Kata Sandi</label>

                            <div class="tab-content">
                                <div id="content1" class="content">
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="profile-image-container mb-4" id="viewProfileImage">
                                                @if ($admin && $admin->admin_photo)
                                                    <a href="{{ asset('storage/admin_photos/' . $admin->admin_photo) }}"
                                                        target="_blank" title="View full image">
                                                        <img src="{{ asset('storage/admin_photos/' . $admin->admin_photo) }}"
                                                            alt="Foto Profil" class="profile-image" id="profileImage">
                                                    </a>
                                                @else
                                                    <div class="profile-placeholder" id="profileImagePlaceholder">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                                <div class="image-overlay" id="reviewTrigger">
                                                    <i class="fas fa-camera-retro"></i>
                                                    <span>Lihat Foto</span>
                                                </div>
                                            </div>

                                            <div class="profile-image-container mb-4 d-none" id="editProfileImage">
                                                @if ($admin && $admin->admin_photo)
                                                    <img src="{{ asset('storage/admin_photos/' . $admin->admin_photo) }}"
                                                        alt="Foto Profil" class="profile-image" id="previewImage">
                                                @else
                                                    <div class="profile-placeholder" id="previewPlaceholder">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                                <div class="image-overlay" id="uploadTrigger">
                                                    <i class="fas fa-camera"></i>
                                                    <span>Ubah</span>
                                                </div>
                                            </div>

                                            <form id="photoUploadForm" action="{{ route('admin.updatePhoto') }}"
                                                method="POST" enctype="multipart/form-data" style="display: none;">
                                                @csrf
                                                <input type="file" name="admin_photo" id="profilePhotoInput"
                                                    accept="image/jpeg,image/png,image/jpg">
                                            </form>

                                            <h4 class="font-weight-bold mb-0">{{ $admin->admin_name ?? 'Admin' }}</h4>
                                            <p class="text-accent"><i class="fas fa-user-shield mr-1"></i> Administrator</p>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="section-heading mb-0">Informasi Pribadi</h5>
                                            </div>

                                            <div id="viewInfoMode">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="info-item">
                                                            <span class="info-label">Nama Lengkap</span>
                                                            <span
                                                                class="info-value">{{ $admin->admin_name ?? 'Belum diatur' }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-item">
                                                            <span class="info-label">Username</span>
                                                            <span class="info-value">{{ Auth::user()->username }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-item">
                                                            <span class="info-label">Jenis Kelamin</span>
                                                            <span class="info-value">
                                                                @if ($admin && $admin->admin_gender == 'Laki-laki')
                                                                    Laki-laki
                                                                @elseif($admin && $admin->admin_gender == 'Perempuan')
                                                                    Perempuan
                                                                @else
                                                                    Belum diatur
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="info-item">
                                                            <span class="info-label">Nomor Telepon</span>
                                                            <span
                                                                class="info-value">{{ $admin->admin_nomor_telepon ?? 'Belum diatur' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="editInfoMode" class="d-none">
                                                <form action="{{ route('admin.updateProfile') }}" method="POST"
                                                    enctype="multipart/form-data" id="profileForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group row">
                                                        <label for="admin_name" class="col-sm-3 col-form-label">Nama
                                                            Lengkap</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="admin_name"
                                                                name="admin_name" value="{{ $admin->admin_name ?? '' }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="username"
                                                            class="col-sm-3 col-form-label">Username</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="username"
                                                                value="{{ Auth::user()->username }}" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="admin_gender" class="col-sm-3 col-form-label">Jenis
                                                            Kelamin</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" id="admin_gender"
                                                                name="admin_gender">
                                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                                <option value="Laki-laki"
                                                                    {{ $admin && $admin->admin_gender == 'Laki-laki' ? 'selected' : '' }}>
                                                                    Laki-laki</option>
                                                                <option value="Perempuan"
                                                                    {{ $admin && $admin->admin_gender == 'Perempuan' ? 'selected' : '' }}>
                                                                    Perempuan</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="admin_nomor_telepon"
                                                            class="col-sm-3 col-form-label">Nomor Telepon</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control"
                                                                id="admin_nomor_telepon" name="admin_nomor_telepon"
                                                                value="{{ $admin->admin_nomor_telepon ?? '' }}">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="section-heading mb-0"></h5>
                                                <div>
                                                    <button type="button" id="editInfoBtn"
                                                        class="btn btn-gradient-primary mr-4">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </button>
                                                    <div class="d-none" id="saveButtons">
                                                        <button type="submit" form="profileForm"
                                                            class="btn btn-gradient-success mr-2">
                                                            <i class="fas fa-save mr-1"></i> Simpan
                                                        </button>
                                                        <button type="button" id="cancelEditBtn"
                                                            class="btn btn-gradient-secondary">
                                                            <i class="fas fa-times mr-1"></i> Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Change Password Tab -->
                                <div id="content2" class="content">
                                    <form action="{{ route('admin.changePassword') }}" method="POST" id="passwordForm">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <div class="password-form-container">
                                                    <div class="password-header">
                                                        <div class="password-icon">
                                                            <i class="fas fa-shield-alt"></i>
                                                        </div>
                                                        <div>
                                                            <h4>Keamanan Akun</h4>
                                                            <p class="text-muted">Perbarui kata sandi untuk meningkatkan
                                                                keamanan akun Anda</p>
                                                        </div>
                                                    </div>

                                                    <div class="password-field">
                                                        <label for="current_password">
                                                            <i class="fas fa-key"></i>
                                                            <span>Kata Sandi Saat Ini</span>
                                                        </label>
                                                        <div class="password-input">
                                                            <input type="password" id="current_password"
                                                                name="current_password"
                                                                placeholder="Masukkan kata sandi saat ini">
                                                            <button type="button" class="toggle-password-btn"
                                                                data-target="current_password">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="password-field">
                                                        <label for="new_password">
                                                            <i class="fas fa-lock"></i>
                                                            <span>Kata Sandi Baru</span>
                                                        </label>
                                                        <div class="password-input">
                                                            <input type="password" id="new_password" name="new_password"
                                                                placeholder="Masukkan kata sandi baru">
                                                            <button type="button" class="toggle-password-btn"
                                                                data-target="new_password">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="password-field">
                                                        <label for="confirm_password">
                                                            <i class="fas fa-lock-open"></i>
                                                            <span>Konfirmasi Kata Sandi Baru</span>
                                                        </label>
                                                        <div class="password-input">
                                                            <input type="password" id="confirm_password"
                                                                name="confirm_password"
                                                                placeholder="Konfirmasi kata sandi baru">
                                                            <button type="button" class="toggle-password-btn"
                                                                data-target="confirm_password">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="password-actions">
                                                        <button type="submit" class="btn-change-password">
                                                            <i class="fas fa-lock"></i> Perbarui Kata Sandi
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .profile-tabs {
            width: 100%;
            margin: 0 auto;
        }

        .tabs-wrapper {
            width: 100%;
        }

        .tabs-wrapper input[type="radio"] {
            display: none;
        }

        .tabs-wrapper label.tab {
            display: inline-block;
            padding: 14px 24px;
            color: var(--light-text);
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        .tabs-wrapper label.tab:hover {
            color: var(--accent-color);
        }

        .tabs-wrapper input:checked+label {
            color: var(--primary-color);
            border-bottom: 2px solid var(--accent-color);
        }

        .tab-content {
            padding: 30px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            margin-top: -2px;
        }

        .content {
            display: none;
        }

        #tab1:checked~.tab-content #content1,
        #tab2:checked~.tab-content #content2 {
            display: block;
        }

        .profile-image-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 5px solid rgba(var(--primary-color-rgb), 0.1);
            box-shadow: var(--shadow);
            cursor: pointer;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8));
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
            border-radius: 50%;
        }

        .image-overlay i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .image-overlay span {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .profile-image-container:hover .image-overlay {
            opacity: 1;
        }

        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 4rem;
        }

        .info-group {
            margin-bottom: 1.5rem;
        }

        .section-heading {
            color: var(--heading-color);
            font-weight: 600;
            padding-bottom: 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-label {
            display: block;
            color: var(--light-text);
            font-size: 0.875rem;
            margin-bottom: 5px;
        }

        .info-value {
            display: block;
            color: var(--heading-color);
            font-weight: 500;
        }

        .custom-file-upload {
            display: inline-block;
            margin-top: 10px;
        }

        .custom-file-upload input[type="file"] {
            display: none;
        }

        .custom-file-upload label {
            display: inline-block;
            padding: 8px 16px;
            background: var(--accent-color);
            color: white;
            border-radius: 30px;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
        }

        .custom-file-upload label:hover {
            background: var(--accent-color-gradient);
        }

        .password-form-container {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            padding: 2.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .password-form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        }

        .password-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .password-header h4 {
            color: #293c5d;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .password-header p {
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .password-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 16px;
            margin-right: 1.5rem;
            font-size: 1.8rem;
            box-shadow: 0 8px 16px rgba(16, 32, 68, 0.2);
        }

        .password-field {
            margin-bottom: 1.5rem;
        }

        .password-field label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 500;
            color: #293c5d;
        }

        .password-field label i {
            margin-right: 8px;
            color: var(--accent-color);
        }

        .password-input {
            position: relative;
        }

        .password-input input {
            width: 100%;
            padding: 12px 50px 12px 16px;
            border: 1px solid #e0e6ed;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .password-input input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(250, 157, 28, 0.15);
            background-color: #fff;
            outline: none;
        }

        .toggle-password-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #6c757d;
            cursor: pointer;
            padding: 5px;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .toggle-password-btn:hover,
        .toggle-password-btn:focus {
            color: var(--accent-color);
            outline: none;
        }

        .password-requirements {
            background-color: #f8fafc;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .password-requirements h6 {
            color: #293c5d;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .password-requirements h6 i {
            color: var(--accent-color);
            margin-right: 8px;
        }

        .password-requirements ul {
            list-style: none;
            padding-left: 1.5rem;
            margin-bottom: 0;
        }

        .password-requirements ul li {
            margin-bottom: 0.5rem;
            position: relative;
            font-size: 0.9rem;
            color: #495057;
        }

        .password-requirements ul li i {
            position: absolute;
            left: -1.5rem;
            top: 3px;
            color: #28a745;
        }

        .password-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .btn-change-password {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 28px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(16, 32, 68, 0.2);
            display: inline-flex;
            align-items: center;
        }

        .btn-change-password i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .btn-change-password:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(16, 32, 68, 0.3);
            background: linear-gradient(135deg, var(--accent-color), var(--accent-color-gradient));
        }

        .btn-change-password:active {
            transform: translateY(-1px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .password-form-container {
                padding: 1.5rem;
            }

            .password-header {
                flex-direction: column;
                text-align: center;
            }

            .password-icon {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }

        .fadeIn {
            animation: fadeIn 0.3s ease-in-out;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(16, 32, 68, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient-primary:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            box-shadow: 0 6px 15px rgba(16, 32, 68, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .btn-gradient-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient-success:hover {
            background: linear-gradient(135deg, #20c997, #28a745);
            box-shadow: 0 6px 15px rgba(40, 167, 69, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .btn-gradient-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.2);
            transition: all 0.3s ease;
        }

        .btn-gradient-secondary:hover {
            background: linear-gradient(135deg, #495057, #6c757d);
            box-shadow: 0 6px 15px rgba(108, 117, 125, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .password-error {
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
            clear: both;
        }

        .password-field {
            margin-bottom: 1.75rem;
            position: relative;
        }

        .password-input {
            position: relative;
        }

        .password-input input.error {
            border-color: #dc3545;
        }

        .password-input input:focus.error {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
        }

        .alert {
            border-radius: 12px;
            padding: 12px 16px;
        }

        .toggle-password-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            $('#editInfoBtn').click(function() {
                // Hide view mode elements
                $('#viewInfoMode').addClass('d-none');
                $('#editInfoBtn').addClass('d-none');
                $('#viewProfileImage').addClass('d-none');

                $('#editInfoMode').removeClass('d-none').addClass('fadeIn');
                $('#saveButtons').removeClass('d-none').addClass('fadeIn');
                $('#editProfileImage').removeClass('d-none').addClass('fadeIn');
            });

            $('#cancelEditBtn').click(function() {
                $('#viewInfoMode').removeClass('d-none').addClass('fadeIn');
                $('#editInfoBtn').removeClass('d-none');
                $('#viewProfileImage').removeClass('d-none').addClass('fadeIn');
                $('#editInfoMode').addClass('d-none');
                $('#saveButtons').addClass('d-none');
                $('#editProfileImage').addClass('d-none');
            });

            $('#uploadTrigger').click(function() {
                $('#profilePhotoInput').click();
            });

            $('#profilePhotoInput').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#profileImage').attr('src', e.target.result);
                        $('#previewImage').removeClass('d-none').attr('src', e.target.result);
                        $('#previewPlaceholder').addClass('d-none');
                        $('#profileImagePlaceholder').addClass('d-none');

                        $('#photoUploadForm').submit();
                    }
                    reader.readAsDataURL(file);
                }
            });



            $('#reviewTrigger').click(function() {
                if ($('#profileImage').length) {
                    //modal review photo
                    const imgSrc = $('#profileImage').attr('src');
                    const modal = `
            <div class="modal fade" id="profileImageModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Foto Profil</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${imgSrc}" class="img-fluid" style="max-height: 70vh;">
                        </div>
                    </div>
                </div>
            </div>
        `;

                    $('body').append(modal);
                    $('#profileImageModal').modal('show');
                    $('#profileImageModal').on('hidden.bs.modal', function() {
                        $(this).remove();
                    });

                    $('#changePhotoBtn').click(function() {
                        $('#profileImageModal').modal('hide');
                        $('#editInfoBtn').click();
                    });
                } else {
                    $('#editInfoBtn').click();
                }
            });
            $('.toggle-password-btn').click(function() {
                const target = $(this).data('target');
                const input = $('#' + target);
                const icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Handle password form submission
            $('#passwordForm').submit(function(e) {
                e.preventDefault();

                // Remove previous error messages
                $('.password-error').remove();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear the form
                            $('#passwordForm')[0].reset();

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },

                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('error');

                                $('#' + key).closest('.password-input').after(
                                    '<span class="password-error text-danger"><small><i class="fas fa-exclamation-circle mr-1"></i>' +
                                    value[0] + '</small></span>');
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            $('.password-actions').before(
                                '<div class="password-error alert alert-danger mt-3 mb-0">' +
                                xhr.responseJSON.message + '</div>');
                        }
                    }
                });
            });

        });
    </script>
@endpush
