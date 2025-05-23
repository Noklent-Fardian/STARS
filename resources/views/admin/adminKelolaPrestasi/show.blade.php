@extends('layouts.template')

@section('title', 'Detail Prestasi | STARS')

@section('page-title', 'Detail Prestasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.adminKelolaPrestasi.index') }}">Data Prestasi</a></li>
@endsection

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title ?? 'Detail Prestasi' }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($prestasi)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, prestasi yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar" style="background: linear-gradient(135deg, #102044, #1a2a4d);">
                                    <i class="fas fa-trophy"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $prestasi->penghargaan_judul }}</h4>
                            <span class="badge badge-primary px-3 py-2">{{ $prestasi->penghargaan_tempat }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Prestasi</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user-graduate"></i>
                                        <span>Mahasiswa</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->mahasiswa->mahasiswa_nama ?? '-' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-layer-group text-warning"></i>
                                        <span>Lomba</span>
                                    </div>
                                   <div class="info-value">{{ $prestasi->lomba->lomba_nama ?? '-' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-medal"></i>
                                        <span>Peringkat</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->peringkat->peringkat_nama ?? '-' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-layer-group"></i>
                                        <span>Tingkatan</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->tingkatan->tingkatan_nama ?? '-' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-heading text-primary"></i>
                                        <span>Judul</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->penghargaan_judul }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building text-secondary"></i>
                                        <span>Tempat</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->penghargaan_tempat }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-link"></i>
                                        <span>Penghargaan Url</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->penghargaan_url }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt text-success"></i>
                                        <span>Tanggal Mulai</span>
                                    </div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($prestasi->penghargaan_tanggal_mulai)->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check text-success"></i>
                                        <span>Tanggal Selesai</span>
                                    </div>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse($prestasi->penghargaan_tanggal_selesai)->format('d F Y') }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-users text-success"></i>
                                        <span>Jumlah Peserta</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->penghargaan_jumlah_peserta }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-university text-info"></i>
                                        <span>Jumlah Instansi</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->penghargaan_jumlah_instansi }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-file-signature text-warning"></i>
                                        <span>Nomor Surat Tugas</span>
                                    </div>
                                    <div class="info-value"><a href="{{ $prestasi->penghargaan_no_surat_tugas }}"
                                            target="_blank">{{ $prestasi->penghargaan_no_surat_tugas }}</a></div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt text-success"></i>
                                        <span>Tanggal Surat Tugas</span>
                                    </div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($prestasi->penghargaan_tanggal_surat_tugas)->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-file-alt"></i>
                                        <span>File Surat Tugas</span>
                                    </div>
                                    <div class="info-value"><a href="{{ $prestasi->penghargaan_file_surat_tugas }}"
                                            target="_blank">{{ $prestasi->penghargaan_file_surat_tugas }}</a></div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-file-alt"></i>
                                        <span>File Sertifikat</span>
                                    </div>
                                    <div class="info-value"><a href="{{ $prestasi->penghargaan_file_sertifikat }}"
                                            target="_blank">{{ $prestasi->penghargaan_file_sertifikat }}</a></div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-file-alt"></i>
                                        <span>File Poster</span>
                                    </div>
                                    <div class="info-value"><a href="{{ $prestasi->penghargaan_file_poster }}"
                                            target="_blank">{{ $prestasi->penghargaan_file_poster }}</a></div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-camera"></i>
                                        <span>Foto Kegiatan</span>
                                    </div>
                                    <div class="info-value"><a href="{{ $prestasi->penghargaan_photo_kegiatan }}"
                                            target="_blank">{{ $prestasi->penghargaan_photo_kegiatan }}</a></div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-star"></i>
                                        <span>Score</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->penghargaan_score }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-eye text-success"></i>  {{-- Untuk true --}}
                                        {{-- <i class="fas fa-eye-slash text-danger"></i> {{-- Untuk false --}}
                                        <span>Visible</span>
                                    </div>
                                    <div class="info-value">{{ $prestasi->penghargaan_visible }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.adminKelolaPrestasi.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                @if(!empty($prestasi))
                    <div>
                        <button onclick="modalAction('{{ route('admin.adminKelolaPrestasi.editAjax', $prestasi->id) }}')"
                            class="btn btn-warning px-4 mr-2">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                        <button onclick="modalAction('{{ route('admin.adminKelolaPrestasi.confirmAjax', $prestasi->id) }}')"
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
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            $('.user-detail-container').css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });

            setTimeout(function () {
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
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endpush