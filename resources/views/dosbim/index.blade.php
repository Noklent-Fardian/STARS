@extends('layouts.template')

@section('title', 'Dosen Dashboard | STARS')

@section('page-title', 'Dashboard')

@section('breadcrumb')
@endsection

@section('content')
    <div class="row mb-4">
        <!-- Welcome Card -->
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body d-flex align-items-center">
                    <div class="mr-4">
                        <img src="{{ asset('img/logo.svg') }}" alt="STARS Logo" width="60">
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="mb-1">Selamat Datang, {{ $dosen->dosen_nama ?? Auth::user()->username }}</h4>
                        <p class="mb-2">Anda dapat memantau dan mengelola prestasi mahasiswa bimbingan Anda melalui dashboard ini.</p>
                    </div>
                    <div class="ml-auto text-center">
                        <div class="score-display">
                            <div class="score-number">{{ number_format($stats['current_score'], 1) }}</div>
                            <div class="score-label">Total Skor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- Total Mahasiswa Bimbingan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100 clickable"
                onclick="window.location='{{ route('dosen.prestasiVerification.index') }}'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Mahasiswa Bimbingan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_mahasiswa_bimbingan']) }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success mr-2">
                                    <i class="fas fa-users"></i> Aktif Bimbingan
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon bg-info text-white">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Prestasi Bimbingan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100 clickable"
                onclick="window.location='{{ route('dosen.prestasiVerification.index') }}'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Prestasi Bimbingan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['total_prestasi_bimbingan']) }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                @if ($stats['total_prestasi_bimbingan'] > 0)
                                    <span class="text-info">
                                        {{ number_format(($stats['verified_prestasi'] / $stats['total_prestasi_bimbingan']) * 100, 1) }}%
                                        terverifikasi
                                    </span>
                                @else
                                    <span class="text-muted">Belum ada prestasi</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon bg-success text-white">
                                <i class="fas fa-award"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi Terverifikasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100 clickable"
                onclick="window.location='{{ route('dosen.prestasiVerification.index') }}'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Prestasi Terverifikasi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['verified_prestasi']) }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-success">
                                    <i class="fas fa-check-double"></i> Lengkap Terverifikasi
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon bg-primary text-white">
                                <i class="fas fa-check-double"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi Pending -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card h-100 clickable"
                onclick="window.location='{{ route('dosen.prestasiVerification.index') }}'">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Prestasi Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($stats['pending_prestasi']) }}</div>
                            <div class="mt-2 mb-0 text-muted text-xs">
                                <span class="text-warning">
                                    <i class="fas fa-clock"></i> Menunggu Verifikasi
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="stat-icon bg-warning text-white">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ranking and Performance Cards -->
    <div class="row mb-4">
        <!-- Overall Ranking Card -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Peringkat Dosen</h6>
                    <i class="fas fa-ranking-star text-gray-300"></i>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="rank-circle mb-3">
                            <div class="rank-number">#{{ $stats['overall_rank'] }}</div>
                            <div class="rank-total">dari {{ number_format($stats['total_dosen']) }}</div>
                        </div>
                        <h5 class="font-weight-bold text-gray-800">Peringkat Anda</h5>
                        <p class="text-muted">di antara semua dosen aktif</p>
                        @php
                            $percentile = (($stats['total_dosen'] - $stats['overall_rank'] + 1) / $stats['total_dosen']) * 100;
                        @endphp
                        <div class="progress mb-2">
                            <div class="progress-bar bg-gradient-primary" role="progressbar"
                                style="width: {{ $percentile }}%" aria-valuenow="{{ $percentile }}" aria-valuemin="0"
                                aria-valuemax="100">
                            </div>
                        </div>
                        <small class="text-muted">Top {{ number_format($percentile, 1) }}% dosen</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mahasiswa Bimbingan Summary -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Ringkasan Bimbingan</h6>
                    <i class="fas fa-user-graduate text-gray-300"></i>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="summary-item">
                                <div class="summary-number text-info">{{ $stats['total_mahasiswa_bimbingan'] }}</div>
                                <div class="summary-label">Mahasiswa</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="summary-item">
                                <div class="summary-number text-success">{{ $stats['verified_prestasi'] }}</div>
                                <div class="summary-label">Prestasi Verified</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="summary-item">
                                <div class="summary-number text-warning">{{ $stats['pending_prestasi'] }}</div>
                                <div class="summary-label">Pending Review</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="summary-item">
                                <div class="summary-number text-primary">{{ $stats['approved_lomba_submissions'] }}</div>
                                <div class="summary-label">Lomba Approved</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Yearly Score Progress Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Perkembangan Skor Pembimbingan Tahunan</h6>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" onclick="exportChart('yearlyScore')">
                                <i class="fas fa-download"></i> Export PNG
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 350px;">
                        <canvas id="yearlyScoreChart"></canvas>
                    </div>
                    <div class="mt-3 text-center">
                        <small class="text-muted">
                            Menampilkan total skor yang diperoleh dari prestasi mahasiswa bimbingan yang terverifikasi per tahun
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <!-- Recent Prestasi Verifications -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Verifikasi Prestasi Terbaru</h6>
                    <a href="{{ route('dosen.prestasiVerification.index') }}"
                        class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentPrestasi as $prestasi)
                        <div class="activity-item mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 font-weight-bold">
                                        {{ $prestasi->penghargaan->penghargaan_judul ?? 'N/A' }}</h6>
                                    <p class="mb-1 text-sm text-muted">
                                        {{ $prestasi->mahasiswa->mahasiswa_nama ?? 'N/A' }} -
                                        {{ $prestasi->penghargaan->lomba->lomba_nama ?? 'N/A' }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt"></i> {{ $prestasi->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="text-right">
                                    @if ($prestasi->verifikasi_admin_status === 'Diterima' && $prestasi->verifikasi_dosen_status === 'Diterima')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-double"></i> Terverifikasi
                                        </span>
                                        <div class="mt-1">
                                            <small class="text-success font-weight-bold">
                                                +{{ $prestasi->penghargaan->penghargaan_score ?? 0 }} poin
                                            </small>
                                        </div>
                                    @elseif($prestasi->verifikasi_admin_status === 'Ditolak' || $prestasi->verifikasi_dosen_status === 'Ditolak')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-award fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada prestasi yang perlu diverifikasi</p>
                            <a href="{{ route('dosen.prestasiVerification.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Cek Verifikasi
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Lomba Submissions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Pengajuan Lomba Terbaru</h6>
                    <a href="{{ route('dosen.riwayatPengajuanLomba.index') }}" class="btn btn-sm btn-primary">Lihat
                        Semua</a>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentLombaSubmissions as $submission)
                        <div class="activity-item mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 font-weight-bold">{{ $submission->lomba_nama }}</h6>
                                    <p class="mb-1 text-sm text-muted">
                                        {{ $submission->lomba_penyelenggara }} -
                                        {{ $submission->lomba->tingkatan->tingkatan_nama ?? 'N/A' }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt"></i> {{ $submission->created_at->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="text-right">
                                    @if ($submission->pendaftaran_status === 'Diterima')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Diterima
                                        </span>
                                    @elseif($submission->pendaftaran_status === 'Ditolak')
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-trophy fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada pengajuan lomba</p>
                            <a href="{{ route('dosen.lomba.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Ajukan Lomba
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <style>
        .welcome-card {
            background: linear-gradient(135deg, #102044, #1a2a4d);
            color: white;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .welcome-card .card-body {
            padding: 1.5rem;
        }

        .welcome-card h4 {
            color: white;
            font-weight: 600;
        }

        .welcome-card p {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 0;
        }

        .score-display {
            background: rgba(250, 157, 28, 0.2);
            padding: 15px 20px;
            border-radius: 12px;
            min-width: 120px;
        }

        .score-number {
            font-size: 2rem;
            font-weight: bold;
            color: #fa9d1c;
            line-height: 1;
        }

        .score-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 4px;
        }

        .stat-card {
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.75rem;
        }

        .rank-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #102044, #1a2a4d);
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
        }

        .rank-number {
            font-size: 2rem;
            font-weight: bold;
            line-height: 1;
        }

        .rank-total {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .summary-item {
            padding: 10px 0;
        }

        .summary-number {
            font-size: 1.5rem;
            font-weight: bold;
            line-height: 1;
        }

        .summary-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 4px;
        }

        .activity-item {
            border-bottom: 1px solid #f8f9fc;
            padding-bottom: 1rem;
        }

        .activity-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .clickable {
            cursor: pointer;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
        }

        .bg-gradient-primary {
            background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
        }

        .chart-area {
            position: relative;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Add click handlers for stat cards
        $('.clickable').hover(
            function() {
                $(this).css('cursor', 'pointer');
            }
        );

        // Export chart function
        function exportChart(chartId) {
            const canvas = document.getElementById(chartId + 'Chart');
            if (canvas) {
                const url = canvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.download = `${chartId}_chart.png`;
                link.href = url;
                link.click();
            }
        }

        // Yearly Score Chart
        document.addEventListener('DOMContentLoaded', function() {
            const yearlyScoreCtx = document.getElementById('yearlyScoreChart').getContext('2d');
            const yearlyScoreData = @json($yearlyScoreData);

            const yearlyScoreChart = new Chart(yearlyScoreCtx, {
                type: 'bar',
                data: {
                    labels: yearlyScoreData.years,
                    datasets: [{
                        label: 'Skor Pembimbingan',
                        data: yearlyScoreData.scores,
                        backgroundColor: 'rgba(16, 32, 68, 0.8)',
                        borderColor: 'rgba(16, 32, 68, 1)',
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                        hoverBackgroundColor: 'rgba(16, 32, 68, 0.9)',
                        hoverBorderColor: 'rgba(16, 32, 68, 1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(16, 32, 68, 1)',
                            borderWidth: 1,
                            cornerRadius: 6,
                            callbacks: {
                                label: function(context) {
                                    return `Skor: ${context.parsed.y.toFixed(1)} poin`;
                                },
                                afterLabel: function(context) {
                                    const data = yearlyScoreData.scores;
                                    const currentIndex = context.dataIndex;
                                    if (currentIndex > 0) {
                                        const currentScore = data[currentIndex];
                                        const previousScore = data[currentIndex - 1];
                                        const difference = currentScore - previousScore;

                                        if (difference > 0) {
                                            return `Peningkatan: +${difference.toFixed(1)} poin`;
                                        } else if (difference < 0) {
                                            return `Penurunan: ${difference.toFixed(1)} poin`;
                                        } else {
                                            return 'Tidak ada perubahan';
                                        }
                                    }
                                    return '';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(1) + ' poin';
                                },
                                font: {
                                    size: 11
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                lineWidth: 1
                            },
                            title: {
                                display: true,
                                text: 'Total Skor Pembimbingan',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11,
                                    weight: '500'
                                }
                            },
                            title: {
                                display: true,
                                text: 'Tahun',
                                font: {
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
        });

        // Initialize tooltips
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush