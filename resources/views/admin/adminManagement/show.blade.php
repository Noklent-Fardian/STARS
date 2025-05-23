@extends('layouts.template')

@section('title', 'Detail Admin | STARS')

@section('page-title', 'Detail Admin')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.adminManagement.index') }}">Admin</a></li>
@endsection

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title ?? 'Detail Admin' }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($admin)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, admin yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="profile-image-container mb-3">
                                @if($admin->admin_photo)
                                    <img src="{{ asset('storage/admin_photos/' . $admin->admin_photo) }}" 
                                        alt="{{ $admin->admin_name }}" class="img-fluid user-profile-image">
                                    <div class="image-overlay" onclick="window.open('{{ asset('storage/admin_photos/' . $admin->admin_photo) }}', '_blank')">
                                        <i class="fas fa-search-plus"></i>
                                        <span>Lihat Foto</span>
                                    </div>
                                @else
                                    <div class="no-avatar">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="image-overlay">
                                        <i class="fas fa-camera"></i>
                                        <span>Tidak Ada Foto</span>
                                    </div>
                                @endif
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $admin->admin_name }}</h4>
                            <span class="badge badge-primary px-3 py-2">Admin</span>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Admin</span>
                                    </div>
                                    <div class="info-value">{{ $admin->id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user text-info"></i>
                                        <span>Nama Admin</span>
                                    </div>
                                    <div class="info-value">{{ $admin->admin_name }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-venus-mars text-warning"></i>
                                        <span>Jenis Kelamin</span>
                                    </div>
                                    <div class="info-value">{{ $admin->admin_gender == 'Laki-laki' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-phone text-success"></i>
                                        <span>Nomor Telepon</span>
                                    </div>
                                    <div class="info-value">{{ $admin->admin_nomor_telepon }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-user-circle text-primary"></i>
                                        <span>Username</span>
                                    </div>
                                    <div class="info-value">{{ $admin->user->username }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus text-success"></i>
                                        <span>Tanggal Dibuat</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $admin->created_at ? $admin->created_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check text-success"></i>
                                        <span>Terakhir Diperbarui</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $admin->updated_at ? $admin->updated_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.adminManagement.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                @if (!empty($admin))
                    <div>
                        <button onclick="modalAction('{{ route('admin.adminManagement.editAjax', $admin->id) }}')"
                            class="btn btn-warning px-4 mr-2">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                        <button onclick="modalAction('{{ route('admin.adminManagement.confirmAjax', $admin->id) }}')"
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
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endpush
