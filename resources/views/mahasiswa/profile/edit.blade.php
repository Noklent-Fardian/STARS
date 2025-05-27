@extends('layouts.template')

@section('title', 'Edit Profil Mahasiswa | STARS')

@section('page-title', 'Edit Profil Mahasiswa')

@section('content')
<div class="container py-4">
    <form id="form-edit-profile" action="{{ route('mahasiswa.updateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow-sm border-0 mb-3">
                    <div class="card-body d-flex flex-column align-items-center">
                        <div class="mb-3 profile-image-container position-relative">
                            <img id="profile-preview"
                                src="{{ $mahasiswa->mahasiswa_photo ? asset('storage/' . $mahasiswa->mahasiswa_photo) : asset('imgs/profile_placeholder.jpg') }}"
                                alt="Foto Profil">
                        </div>
                        <button type="button" class="btn btn-outline-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalPhoto">
                            Ganti Foto Profil
                        </button>
                        <input type="file" name="profile_picture" id="profile_picture" class="d-none"
                            accept="image/jpeg, image/jpg, image/png, image/webp"
                            onchange="document.getElementById('profile-preview').src = window.URL.createObjectURL(this.files[0]);">
                        @error('profile_picture')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                        <button type="button" class="btn btn-outline-danger w-100 mt-2" style="height: 40px;" data-bs-toggle="modal" data-bs-target="#modalPassword">
                            Ganti Password
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header fw-bold">Edit Bagian</div>
                    <div class="card-body p-2">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="showAll">
                            <label class="form-check-label" for="showAll">Tampilkan Semua</label>
                        </div>
                        <ul class="nav flex-column gap-1" id="edit-nav">
                        <li>
                            <a href="#" class="nav-link active" data-target="pribadi">
                                <i class="bi bi-person-badge me-2"></i> Informasi Pribadi
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link" data-target="akademik">
                                <i class="bi bi-mortarboard me-2"></i> Informasi Akademik
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link" data-target="alamat">
                                <i class="bi bi-geo-alt me-2"></i> Alamat / Domisili
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link" data-target="lain">
                                <i class="bi bi-link-45deg me-2"></i> Lain-lain
                            </a>
                        </li>
                    </ul>
                    </div>
                </div>
            </div>
            {{-- Main Edit Form --}}
            <div class="col-md-8">
                <div id="form-pribadi" class="edit-section mb-4 active">
                <div class="card">
                    <div class="card-header fw-bold">Informasi Pribadi</div>
                    <div class="card-body">
                        {{-- ...informasi pribadi... --}}
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="mahasiswa_nomor_telepon" class="form-control" value="{{ old('mahasiswa_nomor_telepon', $mahasiswa->mahasiswa_nomor_telepon) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div id="form-akademik" class="edit-section mb-4">
                <div class="card">
                    <div class="card-header fw-bold">Informasi Akademik</div>
                    <div class="card-body">
                        {{-- Informasi Akademik --}}
                        {{-- Keahlian Utama --}}
                        <div class="mb-3">
                            <label class="form-label">Keahlian Utama</label>
                            <select name="keahlian_id" class="form-select" required>
                                <option value="">Pilih Keahlian Utama</option>
                                @foreach($keahlians as $keahlian)
                                    <option value="{{ $keahlian->id }}" {{ old('keahlian_id', $mahasiswa->keahlian_id) == $keahlian->id ? 'selected' : '' }}>
                                        {{ $keahlian->keahlian_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Keahlian Tambahan --}}
                        <div class="mb-3">
                            <label class="form-label">Keahlian Tambahan</label>
                            <div id="keahlian-tambahan-list">
                                @php
                                    $oldTambahan = old('keahlian_tambahan', $mahasiswa->keahlianTambahan->pluck('id')->toArray());
                                @endphp
                                @forelse($oldTambahan as $i => $id)
                                    <div class="input-group mb-2 keahlian-tambahan-item">
                                        <select name="keahlian_tambahan[]" class="form-select" required>
                                            <option value="">Pilih Keahlian Tambahan</option>
                                            @foreach($keahlians as $keahlian)
                                                <option value="{{ $keahlian->id }}" {{ $id == $keahlian->id ? 'selected' : '' }}>
                                                    {{ $keahlian->keahlian_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-outline-danger btn-remove-keahlian" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </div>
                                @empty
                                    <div class="input-group mb-2 keahlian-tambahan-item">
                                        <select name="keahlian_tambahan[]" class="form-select" required>
                                            <option value="">Pilih Keahlian Tambahan</option>
                                            @foreach($keahlians as $keahlian)
                                                <option value="{{ $keahlian->id }}">{{ $keahlian->keahlian_nama }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-outline-danger btn-remove-keahlian" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </div>
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-outline-primary mt-2" id="btn-tambah-keahlian"><i class="bi bi-plus"></i> Tambah Keahlian</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="form-alamat" class="edit-section mb-4">
                <div class="card">
                    <div class="card-header fw-bold">Alamat / Domisili</div>
                    <div class="card-body">
                        {{-- ...informasi alamat... --}}
                        <div class="mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="mahasiswa_provinsi" class="form-control" value="{{ old('mahasiswa_provinsi', $mahasiswa->mahasiswa_provinsi) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kota</label>
                            <input type="text" name="mahasiswa_kota" class="form-control" value="{{ old('mahasiswa_kota', $mahasiswa->mahasiswa_kota) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="mahasiswa_kecamatan" class="form-control" value="{{ old('mahasiswa_kecamatan', $mahasiswa->mahasiswa_kecamatan) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Desa</label>
                            <input type="text" name="mahasiswa_desa" class="form-control" value="{{ old('mahasiswa_desa', $mahasiswa->mahasiswa_desa) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div id="form-lain" class="edit-section mb-4">
                <div class="card">
                    <div class="card-header fw-bold">Lain-lain</div>
                    <div class="card-body">
                        {{-- Link Sertifikat Keahlian Utama --}}
                        <div class="mb-3">
                            <label class="form-label">Link Sertifikat Keahlian Utama</label>
                            <div class="mb-1">
                                <span class="badge keahlian-badge">{{ $mahasiswa->keahlianUtama->keahlian_nama ?? '-' }}</span>
                            </div>
                            <input type="url" name="keahlian_sertifikat" class="form-control"
                                placeholder="Link sertifikat utama (Google Drive, PDF, dll)"
                                value="{{ old('keahlian_sertifikat', $mahasiswa->keahlian_sertifikat ??'') }}">
                        </div>
                        {{-- Link Sertifikat Keahlian Tambahan --}}
                        <label class="form-label">Link Sertifikat Keahlian Tambahan</label>
                        @foreach($mahasiswa->keahlianTambahan as $keahlian)
                            <div class="mb-2">
                                <span class="badge keahlian-badge">{{ $keahlian->keahlian_nama }}</span>
                                <input type="url" name="keahlian_sertifikat_tambahan[{{ $keahlian->id }}]" class="form-control mt-1"
                                    placeholder="Link sertifikat (Google Drive, PDF, dll)"
                                    value="{{ old('keahlian_sertifikat_tambahan.' . $keahlian->id, $keahlian->pivot->keahlian_sertifikat ?? '') }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-flex gap-3 mt-3">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('mahasiswa.profile') }}" class="btn btn-secondary">Batal</a>
            </div>
                @yield('form-edit-content')
            </div>
        </div>
    </form>
</div>

@include('mahasiswa.profile.upload-photo')

<!-- Enhanced Modal Ubah Password -->
<div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('mahasiswa.changePassword') }}" method="POST" class="modal-content" id="form-password">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="modalPasswordLabel">
            <i class="fas fa-shield-alt me-2"></i>Ganti Password
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">
              <i class="fas fa-key me-1"></i>Password Saat Ini
          </label>
          <div class="input-group">
              <input type="password" name="current_password" id="current_password" class="form-control" required>
              <button type="button" class="btn btn-outline-secondary toggle-password" data-target="current_password">
                  <i class="fas fa-eye"></i>
              </button>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">
              <i class="fas fa-lock me-1"></i>Password Baru
          </label>
          <div class="input-group">
              <input type="password" name="new_password" id="new_password" class="form-control" required>
              <button type="button" class="btn btn-outline-secondary toggle-password" data-target="new_password">
                  <i class="fas fa-eye"></i>
              </button>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">
              <i class="fas fa-lock-open me-1"></i>Konfirmasi Password Baru
          </label>
          <div class="input-group">
              <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
              <button type="button" class="btn btn-outline-secondary toggle-password" data-target="confirm_password">
                  <i class="fas fa-eye"></i>
              </button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-lock me-1"></i>Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('css')
<style>
    .profile-image-container {
        width: 130px;
        height: 130px;
        margin: 0 auto;
        position: relative;
    }
    .profile-image-container img {
        display: block;
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #0d6efd;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: box-shadow 0.2s;
    }
    .profile-image-container img:hover {
        box-shadow: 0 0 0 6px #0d6efd33;
    }
    #edit-nav .nav-link.active {
        background: #0d6efd;
        color: #fff;
        border-radius: 5px;
    }
    .edit-section {
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.4s, visibility 0.4s;
    position: absolute;
    width: 100%;
    left: 0;
    top: 0;
    }
    .edit-section.active {
        opacity: 1;
        visibility: visible;
        position: relative;
        z-index: 1;
    }
    .edit-section:not(.active) {
        z-index: 0;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Enhanced password toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});

// Enhanced form submission with SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-edit-profile');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(form);
        formData.append('_method', 'PUT');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(async response => {
            const data = await response.json();
            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Profil berhasil diperbarui!',
                    timer: 1500,
                    showConfirmButton: false
                });
                setTimeout(function() {
                    window.location.href = "{{ route('mahasiswa.profile') }}";
                }, 1500);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message || 'Terjadi kesalahan saat memperbarui profil.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server.',
                confirmButtonText: 'OK'
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('#edit-nav .nav-link');
    const sections = document.querySelectorAll('.edit-section');
    const showAll = document.getElementById('showAll');

    function showSection(target) {
        sections.forEach(sec => sec.classList.remove('active'));
        document.getElementById('form-' + target).classList.add('active');
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            showAll.checked = false;
            showSection(this.dataset.target);
        });
    });

    showAll.addEventListener('change', function() {
        if (this.checked) {
            sections.forEach(sec => sec.classList.add('active'));
            navLinks.forEach(l => l.classList.remove('active'));
        } else {
            showSection('pribadi');
            navLinks[0].classList.add('active');
        }
    });

    // Inisialisasi
    sections.forEach(sec => sec.classList.remove('active'));
    showAll.checked = false;
    showSection('pribadi');
    navLinks[0].classList.add('active');
});

document.addEventListener('DOMContentLoaded', function() {
    const keahlianList = document.getElementById('keahlian-tambahan-list');
    const btnTambah = document.getElementById('btn-tambah-keahlian');
    // Langsung generate opsi dari PHP
    const keahlianOptions = `
        <option value="">Pilih Keahlian Tambahan</option>
        @foreach($keahlians as $keahlian)
            <option value="{{ $keahlian->id }}">{{ $keahlian->keahlian_nama }}</option>
        @endforeach
    `;

    btnTambah.addEventListener('click', function() {
        const div = document.createElement('div');
        div.className = 'input-group mb-2 keahlian-tambahan-item';
        div.innerHTML = `
            <select name="keahlian_tambahan[]" class="form-select" required>
                ${keahlianOptions}
            </select>
            <button type="button" class="btn btn-outline-danger btn-remove-keahlian" title="Hapus"><i class="bi bi-trash"></i></button>
        `;
        keahlianList.appendChild(div);
    });

    keahlianList.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-keahlian')) {
            const item = e.target.closest('.keahlian-tambahan-item');
            if (item) item.remove();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const formPassword = document.getElementById('form-password');
    if (formPassword) {
        formPassword.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang mengubah password',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let formData = new FormData(formPassword);

            fetch(formPassword.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                Swal.close();
                
                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message || 'Password berhasil diubah!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(function() {
                        document.getElementById('modalPassword').querySelector('.btn-close').click();
                        formPassword.reset();
                        // Reset password visibility
                        document.querySelectorAll('#modalPassword input[type="text"]').forEach(input => {
                            input.type = 'password';
                        });
                        document.querySelectorAll('#modalPassword .fa-eye-slash').forEach(icon => {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        });
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat mengubah password.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server.',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const formPhoto = document.getElementById('form-photo');
    if (formPhoto) {
        formPhoto.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Mengunggah...',
                text: 'Sedang mengunggah foto profil',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let formData = new FormData(formPhoto);

            fetch(formPhoto.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                Swal.close();
                
                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message || 'Foto profil berhasil diubah!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    // Update foto profil di halaman tanpa reload
                    document.getElementById('profile-preview').src = data.photo_url + '?' + new Date().getTime();
                    setTimeout(function() {
                        document.getElementById('modalPhoto').querySelector('.btn-close').click();
                        formPhoto.reset();
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: data.message || 'Terjadi kesalahan saat upload foto.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan pada server.',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('js')
@endpush