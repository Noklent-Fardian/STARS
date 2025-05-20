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
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@push('js')
    <script src="{{ asset('js/profile.js') }}"></script>
@endpush
