@extends('layouts.template')

@section('title', 'Detail Semester | STARS')

@section('page-title', 'Detail Semester')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.master.semester.index') }}">Semester</a></li>
@endsection

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title ?? 'Detail Semester' }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($semester)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, semester yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar" style="background: linear-gradient(135deg, #102044, #1a2a4d);">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $semester->semester_nama }}</h4>
                            <span class="badge badge-primary px-3 py-2">{{ $semester->semester_jenis }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Semester</span>
                                    </div>
                                    <div class="info-value">{{ $semester->id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt text-info"></i>
                                        <span>Nama Semester</span>
                                    </div>
                                    <div class="info-value">{{ $semester->semester_nama }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar text-warning"></i>
                                        <span>Tahun</span>
                                    </div>
                                    <div class="info-value">{{ $semester->semester_tahun }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-exchange-alt text-success"></i>
                                        <span>Jenis Semester</span>
                                    </div>
                                    <div class="info-value">{{ $semester->semester_jenis }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <span>Status</span>
                                    </div>
                                    <div class="info-value">
                                        @if ($semester->semester_aktif)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Non-Aktif</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus text-success"></i>
                                        <span>Tanggal Dibuat</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $semester->created_at ? $semester->created_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check text-success"></i>
                                        <span>Terakhir Diperbarui</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $semester->updated_at ? $semester->updated_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.master.semester.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                @if (!empty($semester))
                    <div>
                        <button onclick="modalAction('{{ route('admin.master.semester.editAjax', $semester->id) }}')"
                            class="btn btn-warning px-4 mr-2">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                        <button onclick="modalAction('{{ route('admin.master.semester.confirmAjax', $semester->id) }}')"
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
        /* Custom styles for the show page */
        .card-header {
            background: linear-gradient(-45deg, #102044, #1a2a4d, #293c5d, #1a2a4d);
            background-size: 400% 400%;
            position: relative;
            overflow: hidden;
        }

        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
            z-index: 1;
            animation: gradientBG 15s ease infinite;
        }

        .card-title {
            position: relative;
            z-index: 2;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .user-avatar-container {
            display: flex;
            justify-content: center;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .user-info-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .user-info-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .user-info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            width: 200px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .info-label i {
            margin-right: 10px;
            font-size: 18px;
        }

        .info-value {
            flex: 1;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .user-info-item {
                flex-direction: column;
            }

            .info-label {
                width: 100%;
                margin-bottom: 5px;
            }

            .info-value {
                padding-left: 28px;
            }
        }
    </style>
@endpush
