@extends('layouts.template')

@section('title', $lomba->lomba_nama . ' | STARS')

@section('page-title', 'Detail Lomba')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.lomba.index') }}">Lihat Lomba</a></li>
    <li class="breadcrumb-item active">{{ $lomba->lomba_nama }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Competition Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row">
                            <!-- Competition Poster -->
                            <div class="col-md-4">
                                <div class="poster-container">
                                    @if($lomba->lomba_link_poster)
                                        <img src="{{ $lomba->lomba_link_poster }}" 
                                             class="img-fluid rounded shadow poster-image"
                                             alt="{{ $lomba->lomba_nama }}"
                                             onerror="this.src='https://picsum.photos/400/400?random={{ $lomba->id }}'">
                                        <div class="default-poster overlay-poster">
                                            <i class="fas fa-trophy fa-5x text-muted mb-3"></i>
                                            <h5 class="text-muted">{{ $lomba->lomba_nama }}</h5>
                                        </div>
                                    @else
                                        <img src="https://picsum.photos/400/400?random={{ $lomba->id }}" 
                                             class="img-fluid rounded shadow poster-image"
                                             alt="{{ $lomba->lomba_nama }}">
                                        <div class="default-poster overlay-poster">
                                            <i class="fas fa-trophy fa-5x text-muted mb-3"></i>
                                            <h5 class="text-muted">{{ $lomba->lomba_nama }}</h5>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Competition Info -->
                            <div class="col-md-8">
                                <div class="competition-header">
                                    <!-- Status Badges -->
                                    <div class="mb-3">
                                        @if($lomba->lomba_terverifikasi)
                                            <span class="badge badge-success badge-lg">
                                                <i class="fas fa-check-circle"></i> Terverifikasi
                                            </span>
                                        @else
                                            <span class="badge badge-warning badge-lg">
                                                <i class="fas fa-clock"></i> Menunggu Verifikasi
                                            </span>
                                        @endif

                                        @php
                                            $now = now();
                                            $start = $lomba->lomba_tanggal_mulai;
                                            $end = $lomba->lomba_tanggal_selesai;
                                        @endphp
                                        
                                        @if($now < $start)
                                            <span class="badge badge-info badge-lg ml-2">
                                                <i class="fas fa-clock"></i> Akan Datang
                                            </span>
                                        @elseif($now >= $start && $now <= $end)
                                            <span class="badge badge-success badge-lg ml-2">
                                                <i class="fas fa-play"></i> Sedang Berlangsung
                                            </span>
                                        @else
                                            <span class="badge badge-secondary badge-lg ml-2">
                                                <i class="fas fa-flag-checkered"></i> Sudah Selesai
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Competition Title -->
                                    <h2 class="font-weight-bold text-dark mb-3">{{ $lomba->lomba_nama }}</h2>

                                    <!-- Basic Info -->
                                    <div class="competition-basic-info">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <div class="info-item">
                                                    <i class="fas fa-building text-primary mr-2"></i>
                                                    <span class="info-label">Penyelenggara:</span>
                                                    <span class="info-value">{{ $lomba->lomba_penyelenggara }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <div class="info-item">
                                                    <i class="fas fa-tag text-primary mr-2"></i>
                                                    <span class="info-label">Kategori:</span>
                                                    <span class="info-value">{{ $lomba->lomba_kategori }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <div class="info-item">
                                                    <i class="fas fa-layer-group text-primary mr-2"></i>
                                                    <span class="info-label">Tingkatan:</span>
                                                    <span class="info-value">{{ $lomba->tingkatan->tingkatan_nama }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <div class="info-item">
                                                    <i class="fas fa-calendar text-primary mr-2"></i>
                                                    <span class="info-label">Semester:</span>
                                                    <span class="info-value">{{ $lomba->semester->semester_nama ?? 'Tidak ditentukan' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="action-buttons mt-4">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                @if($lomba->lomba_link_pendaftaran)
                                                    <a href="{{ $lomba->lomba_link_pendaftaran }}" 
                                                       target="_blank" 
                                                       class="btn btn-success btn-lg btn-block">
                                                        <i class="fas fa-external-link-alt mr-2"></i>
                                                        Buka Link Pendaftaran
                                                    </a>
                                                @else
                                                    <button class="btn btn-outline-secondary btn-lg btn-block" disabled>
                                                        <i class="fas fa-link mr-2"></i>
                                                        Link Pendaftaran Tidak Tersedia
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <a href="{{ route('student.achievement.create') }}?lomba={{ $lomba->id }}" 
                                                   class="btn btn-primary btn-lg btn-block">
                                                    <i class="fas fa-certificate mr-2"></i>
                                                    Ajukan Verifikasi Prestasi
                                                </a>
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

        <!-- Competition Details -->
        <div class="row">
            <!-- Date and Time Info -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt mr-2"></i>Waktu Pelaksanaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline-info">
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="font-weight-bold">Tanggal Mulai Pendaftaran</h6>
                                    <p class="text-muted mb-1">{{ $lomba->lomba_tanggal_mulai->format('l, d F Y') }}</p>
                                    <small class="text-info">{{ $lomba->lomba_tanggal_mulai->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="font-weight-bold">Tanggal Selesai</h6>
                                    <p class="text-muted mb-1">{{ $lomba->lomba_tanggal_selesai->format('l, d F Y') }}</p>
                                    <small class="text-success">{{ $lomba->lomba_tanggal_selesai->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Duration -->
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="text-center">
                                <h6 class="font-weight-bold text-dark">Durasi Lomba</h6>
                                <p class="mb-0 text-primary">
                                    {{ $lomba->lomba_tanggal_mulai->diffInDays($lomba->lomba_tanggal_selesai) + 1 }} hari
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills Required -->
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-code mr-2"></i>Bidang Keahlian
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($lomba->keahlians->count() > 0)
                            <div class="skills-container">
                                @foreach($lomba->keahlians as $keahlian)
                                    <div class="skill-item">
                                        <span class="badge badge-primary badge-lg mb-2">
                                            <i class="fas fa-code mr-1"></i>{{ $keahlian->keahlian_nama }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p>Bidang keahlian tidak ditentukan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        @if($lomba->lomba_link_poster || $lomba->lomba_link_pendaftaran)
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-link mr-2"></i>Informasi Tambahan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($lomba->lomba_link_poster)
                            <div class="col-md-6 mb-3">
                                <div class="link-item">
                                    <h6 class="font-weight-bold">
                                        <i class="fas fa-image text-primary mr-2"></i>Link Poster
                                    </h6>
                                    <a href="{{ $lomba->lomba_link_poster }}" 
                                       target="_blank" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt mr-1"></i>Lihat Poster
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($lomba->lomba_link_pendaftaran)
                            <div class="col-md-6 mb-3">
                                <div class="link-item">
                                    <h6 class="font-weight-bold">
                                        <i class="fas fa-edit text-success mr-2"></i>Link Pendaftaran
                                    </h6>
                                    <a href="{{ $lomba->lomba_link_pendaftaran }}" 
                                       target="_blank" 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-external-link-alt mr-1"></i>Daftar Sekarang
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="row">
            <div class="col-12">
                <a href="{{ route('mahasiswa.lomba.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Lomba
                </a>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .poster-container {
        max-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .poster-container .poster-image {
        max-height: 400px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .poster-container:hover .poster-image {
        transform: scale(1.05);
    }

    .overlay-poster {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(248, 249, 250, 0.9) !important;
        z-index: 2;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 0.5rem;
    }

    .poster-container:hover .overlay-poster {
        opacity: 1;
    }

    .default-poster-large {
        height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border-radius: 0.5rem;
        text-align: center;
        padding: 2rem;
    }

    .badge-lg {
        font-size: 0.9rem;
        padding: 0.5rem 0.8rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .info-label {
        font-weight: 600;
        margin-left: 0.5rem;
        margin-right: 0.5rem;
        min-width: 80px;
    }

    .info-value {
        color: #495057;
    }

    .timeline-info {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: -2rem;
        top: 0.25rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 1.5rem;
        width: 2px;
        height: calc(100% + 1rem);
        background-color: #dee2e6;
    }

    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .skill-item .badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.8rem;
    }

    .link-item {
        padding: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        background: #f8f9fa;
    }

    @media (max-width: 768px) {
        .poster-container {
            max-height: 250px;
            margin-bottom: 2rem;
        }

        .default-poster-large {
            height: 250px;
            padding: 1rem;
        }

        .default-poster-large i {
            font-size: 3rem !important;
        }

        .info-label {
            min-width: auto;
            margin-bottom: 0.25rem;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .timeline-info {
            padding-left: 1.5rem;
        }

        .timeline-marker {
            left: -1.5rem;
        }

        .timeline-item:not(:last-child)::before {
            left: -1rem;
        }
    }
</style>
@endpush
