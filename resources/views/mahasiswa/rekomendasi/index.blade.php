@extends('layouts.template')

@section('title', 'Rekomendasi Lomba | STARS')

@section('page-title', 'Rekomendasi Lomba')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rekomendasi Lomba untuk Anda</h1>
        <button onclick="window.location.reload()" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>

    @if(isset($error))
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> {{ $error }}
                </div>
            </div>
        </div>
    @endif

    @if($notifications->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum Ada Rekomendasi</h5>
                        <p class="text-muted">Anda belum menerima rekomendasi lomba dari sistem.</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($notifications as $notification)
                @php
                    $data = json_decode($notification->data, true);
                    $isRead = $notification->read_at !== null;
                @endphp
                <div class="col-lg-12 mb-4">
                    <div class="card shadow {{ !$isRead ? 'border-left-success' : '' }}">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-trophy mr-2"></i>
                                {{ $notification->title }}
                                @if(!$isRead)
                                    <span class="badge badge-success ml-2">Baru</span>
                                @endif
                            </h6>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="card-body">
                            <!-- Competition Info -->
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <h5 class="text-primary">{{ $data['lomba_nama'] ?? 'Nama Lomba Tidak Tersedia' }}</h5>
                                    <p class="text-muted mb-2">{{ $notification->message }}</p>
                                    
                                    @if(isset($data['lomba_details']))
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Penyelenggara:</strong> {{ $data['lomba_details']['penyelenggara'] ?? 'Tidak tersedia' }}<br>
                                                <strong>Tanggal Mulai:</strong> {{ isset($data['lomba_details']['tanggal_mulai']) ? \Carbon\Carbon::parse($data['lomba_details']['tanggal_mulai'])->format('d M Y') : 'Tidak tersedia' }}<br>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Tanggal Selesai:</strong> {{ isset($data['lomba_details']['tanggal_selesai']) ? \Carbon\Carbon::parse($data['lomba_details']['tanggal_selesai'])->format('d M Y') : 'Tidak tersedia' }}<br>
                                                @if(isset($data['lomba_details']['link_pendaftaran']))
                                                    <strong>Link Pendaftaran:</strong> 
                                                    <a href="{{ $data['lomba_details']['link_pendaftaran'] }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-external-link-alt"></i> Daftar Sekarang
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="bg-success text-white rounded p-3">
                                        <h3 class="mb-0">#{{ $data['ranking'] ?? 'N/A' }}</h3>
                                        <small>Ranking Anda</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Other Qualified Students -->
                            @if(isset($data['other_qualified']) && is_array($data['other_qualified']) && count($data['other_qualified']) > 0)
                                <div class="mt-4">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-users mr-2"></i>
                                        Mahasiswa Lain yang Direkomendasikan ({{ count($data['other_qualified']) }} orang)
                                    </h6>
                                    
                                    <div class="row">
                                        @foreach($data['other_qualified'] as $index => $student)
                                            <div class="col-md-6 col-lg-4 mb-3">
                                                <div class="card border-left-info h-100">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-3">
                                                                @if(isset($student['photo']) && $student['photo'] && $student['photo'] !== 'default-avatar.png')
                                                                    <img src="{{ asset('storage/' . $student['photo']) }}" 
                                                                         alt="{{ $student['nama'] ?? 'Student' }}" 
                                                                         class="rounded-circle student-photo" 
                                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                                @else
                                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                                         style="width: 50px; height: 50px;">
                                                                        <i class="fas fa-user text-white"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex justify-content-between align-items-start">
                                                                    <div>
                                                                        <h6 class="mb-1 font-weight-bold">{{ $student['nama'] ?? 'Nama tidak tersedia' }}</h6>
                                                                        <p class="mb-1 text-muted small">{{ $student['nim'] ?? 'NIM tidak tersedia' }}</p>
                                                                        <p class="mb-1 text-muted small">
                                                                            <i class="fas fa-graduation-cap mr-1"></i>
                                                                            Angkatan {{ $student['angkatan'] ?? 'Tidak tersedia' }}
                                                                        </p>
                                                                        @if(isset($student['nomor_telepon']) && $student['nomor_telepon'] !== 'Tidak tersedia')
                                                                            <p class="mb-1 text-muted small">
                                                                                <i class="fas fa-phone mr-1"></i>
                                                                                <a href="tel:{{ $student['nomor_telepon'] }}" class="text-decoration-none">
                                                                                    {{ $student['nomor_telepon'] }}
                                                                                </a>
                                                                            </p>
                                                                        @endif
                                                                        <p class="mb-0 text-muted small">
                                                                            <i class="fas fa-star mr-1"></i>
                                                                            {{ $student['keahlian_utama'] ?? 'Tidak ada' }}
                                                                        </p>
                                                                    </div>
                                                                    <span class="badge badge-{{ ($student['ranking'] ?? 999) <= 3 ? 'warning' : 'info' }}">
                                                                        #{{ $student['ranking'] ?? 'N/A' }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="mt-2">
                                                            <small class="text-muted">
                                                                Skor: <span class="font-weight-bold text-primary">{{ $student['skor_preferensi'] ?? 'N/A' }}</span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <strong>Tip:</strong> Anda dapat menghubungi mahasiswa lain yang direkomendasikan untuk membentuk tim atau berbagi informasi tentang lomba ini.
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <strong>Info:</strong> Tidak ada mahasiswa lain yang direkomendasikan untuk lomba ini, atau data belum tersedia.
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="mt-3 d-flex justify-content-between align-items-center">
                                <div>
                                    @if(isset($data['lomba_details']['link_pendaftaran']))
                                        <a href="{{ $data['lomba_details']['link_pendaftaran'] }}" 
                                           target="_blank" 
                                           class="btn btn-success btn-sm">
                                            <i class="fas fa-external-link-alt mr-1"></i> Daftar Lomba
                                        </a>
                                    @endif
                                    <a href="{{ route('mahasiswa.rekomendasi.show', $notification->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye mr-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif
</div>
@endsection

@push('js')
<script>
    // Mark single notification as read
    $(document).on('click', '.mark-as-read', function() {
        const notificationId = $(this).data('notification-id');
        const button = $(this);
        
        $.ajax({
            url: '{{ route("notifications.markAsRead", ":id") }}'.replace(':id', notificationId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                button.closest('.card').removeClass('border-left-success');
                button.closest('.card').find('.badge-success').remove();
                button.remove();
                
                showAlert('success', 'Notifikasi telah ditandai sebagai sudah dibaca.');
            },
            error: function() {
                showAlert('danger', 'Terjadi kesalahan saat menandai notifikasi.');
            }
        });
    });

    // Mark all notifications as read
    $(document).on('click', '#mark-all-read', function() {
        $.ajax({
            url: '{{ route("notifications.markAllAsRead") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('.border-left-success').removeClass('border-left-success');
                $('.badge-success').remove();
                $('.mark-as-read').remove();
                $('#mark-all-read').remove();
                
                showAlert('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
            },
            error: function() {
                showAlert('danger', 'Terjadi kesalahan saat menandai semua notifikasi.');
            }
        });
    });

    // Function to show alert
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
        
        $('.container-fluid').prepend(alertHtml);
        
        // Auto hide after 3 seconds
        setTimeout(function() {
            $('.alert').alert('close');
        }, 3000);
    }
</script>
@endpush

@push('css')
<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .badge {
        font-size: 0.75em;
    }

    .student-photo {
        border: 2px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .student-photo:hover {
        border-color: #36b9cc;
        transform: scale(1.05);
    }

    .card-body .small {
        font-size: 0.8rem;
    }

    .text-decoration-none {
        text-decoration: none !important;
    }

    .text-decoration-none:hover {
        text-decoration: underline !important;
    }
</style>
@endpush