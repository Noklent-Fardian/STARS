@extends('layouts.template')

@section('title', 'Detail Mahasiswa | STARS')

@section('page-title', 'Detail Mahasiswa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.mahasiswaManagement.index') }}">Mahasiswa</a></li>
    <li class="breadcrumb-item active">Detail Mahasiswa</li>
@endsection

@section('content')
    <div class="rounded-lg overflow-hidden">
        <div class="">
            @empty($mahasiswa)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, mahasiswa yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4 justify-content-center">
                        <div class="col-md-12">
                            <div class="card mx-2 h-100 border-0" style="background: #f8f9fa;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="profile-image-container mr-4" style="width: 100px; height: 100px;">
                                            @if ($mahasiswa->mahasiswa_photo)
                                                <img src="{{ asset('storage/' . $mahasiswa->mahasiswa_photo) }}"
                                                    alt="{{ $mahasiswa->mahasiswa_nama }}"
                                                    class="rounded-circle user-profile-image"
                                                    style="width: 100px; height: 100px;">
                                            @else
                                                <div class="no-avatar rounded-circle bg-secondary"
                                                    style="width: 100px; height: 100px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="mb-1 text-primary font-weight-bold">{{ $mahasiswa->mahasiswa_nama }}</h4>
                                            <div class="mb-1 text-muted" style="font-size: 15px;">
                                                <span class="mr-3">
                                                    <i class="fas fa-id-card text-info mr-1"></i>
                                                    {{ $mahasiswa->mahasiswa_nim }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-university text-primary mr-1"></i>
                                                    {{ $mahasiswa->prodi->prodi_nama ?? '-' }}
                                                </span>
                                            </div>
                                            <div>
                                                <span
                                                    class="badge 
                                                @if ($mahasiswa->mahasiswa_status === 'Aktif') badge-success
                                                @elseif($mahasiswa->mahasiswa_status === 'Cuti') badge-warning
                                                @else badge-secondary @endif">
                                                    {{ $mahasiswa->mahasiswa_status ?? 'Tidak Aktif' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        {{-- Informasi Pribadi --}}
                        <div class="col-md-12 mx-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-user mr-2"></i> Informasi Pribadi
                                </div>
                                <div class="card-body">
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-user text-primary"></i>
                                            <span>Nama Lengkap</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->mahasiswa_nama }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label me-2">
                                            <i class="fas fa-id-card text-info"></i>
                                            <span>NIM</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->mahasiswa_nim }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label me-2">
                                            <i class="fas fa-venus-mars text-warning"></i>
                                            <span>Jenis Kelamin</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->mahasiswa_gender }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-pray text-secondary"></i>
                                            <span>Agama</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->mahasiswa_agama ?? '-' }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-phone text-success"></i>
                                            <span>Nomor Telepon</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->mahasiswa_nomor_telepon }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-map-marker-alt text-danger"></i>
                                            <span>Alamat</span>
                                        </div>
                                        <div class="info-value">
                                            @php
                                                $alamat = implode(
                                                    ', ',
                                                    array_filter([
                                                        $mahasiswa->mahasiswa_desa,
                                                        $mahasiswa->mahasiswa_kecamatan,
                                                        $mahasiswa->mahasiswa_kota,
                                                        $mahasiswa->mahasiswa_provinsi,
                                                    ]),
                                                );
                                            @endphp
                                            {{ $alamat ?: '-' }}
                                        </div>
                                    </div>
                                    <div class="user-info-item">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Informasi Akademik --}}
                        <div class="col-md-12 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-graduation-cap mr-2"></i> Informasi Akademik
                                </div>
                                <div class="card-body">
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-university text-primary"></i>
                                            <span>Program Studi</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->prodi->prodi_nama ?? '-' }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-layer-group text-success"></i>
                                            <span>Semester</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->semester_id }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-calendar-alt text-warning"></i>
                                            <span>Angkatan</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->mahasiswa_angkatan }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-star text-danger"></i>
                                            <span>Keahlian Utama</span>
                                        </div>
                                        <div class="info-value">
                                            @if ($mahasiswa->keahlianUtama)
                                                <span
                                                    class="badge keahlian-badge">{{ $mahasiswa->keahlianUtama->keahlian_nama }}</span>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-star-half-alt text-danger"></i>
                                            <span>Keahlian Tambahan</span>
                                        </div>
                                        <div class="info-value">
                                            @if ($mahasiswa->keahlianTambahan->count())
                                                @foreach ($mahasiswa->keahlianTambahan as $keahlian)
                                                    <span
                                                        class="badge keahlian-badge mb-1">{{ $keahlian->keahlian_nama }}</span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-trophy text-success"></i>
                                            <span>Score Prestasi</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->mahasiswa_score }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Informasi Akun --}}
                        <div class="col-md-12 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-user-circle mr-2"></i> Informasi Akun
                                </div>
                                <div class="card-body">
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-user text-secondary"></i>
                                            <span>Username</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->user->username ?? '-' }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-envelope text-secondary"></i>
                                            <span>Email</span>
                                        </div>
                                        <div class="info-value">{{ $mahasiswa->user->email ?? '-' }}</div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-calendar-plus text-success"></i>
                                            <span>Tanggal Dibuat</span>
                                        </div>
                                        <div class="info-value">
                                            {{ $mahasiswa->created_at ? $mahasiswa->created_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                        </div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-calendar-check text-success"></i>
                                            <span>Terakhir Diperbarui</span>
                                        </div>
                                        <div class="info-value">
                                            {{ $mahasiswa->updated_at ? $mahasiswa->updated_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                        </div>
                                    </div>
                                    <div class="user-info-item">
                                        <div class="info-label">
                                            <i class="fas fa-eye text-info"></i>
                                            <span>Status Akun</span>
                                        </div>
                                        <div class="info-value">
                                            <span
                                                class="badge {{ $mahasiswa->mahasiswa_visible ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $mahasiswa->mahasiswa_visible ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.mahasiswaManagement.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                @if (!empty($mahasiswa))
                    <div>
                        <button onclick="modalAction('{{ route('admin.mahasiswaManagement.editAjax', $mahasiswa->id) }}')"
                            class="btn btn-warning px-4 mr-2">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                        <button
                            onclick="modalAction('{{ route('admin.mahasiswaManagement.confirmAjax', $mahasiswa->id) }}')"
                            class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function() {
            // Add animation to elements when page loads
            $('.user-detail-container').css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });

            setTimeout(function() {
                $('.user-detail-container').css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.6s ease-out'
                });
            }, 200);
        });
    </script>
@endpush

@push('css')
    <style>
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #102044 0%, #3498db 100%);
            z-index: -1;
        }

        .card-header {
            background: transparent;
            border-bottom: none;
            position: relative;
            overflow: hidden;
        }

        .profile-image-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            background-color: #f8f9fa;
        }

        .user-profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-avatar {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
        }

        .no-avatar i {
            font-size: 5rem;
            color: #adb5bd;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
            color: white;
            border-radius: 50%;
        }

        .image-overlay i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .profile-image-container:hover .image-overlay {
            opacity: 1;
        }

        .user-info-item {
            display: flex;
            padding: 12px 15px;
            border-bottom: 1px solid #f2f2f2;
            transition: background-color 0.2s ease;
        }

        .user-info-item:last-child {
            border-bottom: none;
        }

        .user-info-item:hover {
            background-color: #f8f9fa;
        }

        .info-label {
            width: 200px;
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #495057;
        }

        .info-label i {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }

        .info-value {
            flex: 1;
            color: #212529;
        }

        .card-title {
            position: relative;
            z-index: 1;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .keahlian-badge {
            background: #e7f1ff !important;
            color: #0d6efd !important;
            font-size: 0.9em;
            padding: 0.35em 0.9em;
            border-radius: 1.5em;
            margin-right: 0.3em;
            margin-bottom: 0.3em;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 1px 4px rgba(13, 110, 253, 0.08);
            display: inline-block;
        }

        .card .card-header {
            border-radius: 0.35rem 0.35rem 0 0 !important;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }
    </style>
@endpush
