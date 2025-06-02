@extends('layouts.template')

@section('title', 'Admin Dashboard | STARS')

@section('page-title', 'Dashboard')

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
                    <h4 class="mb-1">Selamat Datang, {{ $admin->admin_name ?? Auth::user()->username }}</h4>
                    <p class="mb-2">Selamat datang di dashboard Admin. Pantau dan kelola data prestasi mahasiswa dengan mudah.</p>
                    <div class="d-flex gap-2">
                    </div>
                </div>
                <div class="ml-auto">
                    <button class="btn btn-light btn-sm" onclick="refreshDashboard()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <!-- Total Mahasiswa -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100 clickable" onclick="window.location='{{ route('admin.mahasiswa.index') }}'">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Mahasiswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $stats['total_mahasiswa'] }}">0</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> Aktif</span>
                            <span>Mahasiswa terdaftar</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-primary text-white">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Dosen -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100 clickable" onclick="window.location='{{ route('admin.dosen.index') }}'">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Dosen</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $stats['total_dosen'] }}">0</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-info mr-2"><i class="fas fa-chalkboard-teacher"></i></span>
                            <span>Dosen pembimbing</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-info text-white">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Prestasi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100 clickable" onclick="window.location='{{ route('admin.prestasi.index') }}'">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Prestasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $stats['total_prestasi'] }}">0</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-success mr-2"><i class="fas fa-trophy"></i></span>
                            <span>Prestasi tercatat</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-success text-white">
                            <i class="fas fa-trophy"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Verifikasi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100 clickable" onclick="window.location='{{ route('admin.prestasi.verification') }}'">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Pending Verifikasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $stats['pending_verifikasi_prestasi'] + $stats['pending_verifikasi_lomba'] }}">0</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-warning mr-2"><i class="fas fa-clock"></i></span>
                            <span>Menunggu verifikasi</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="stat-icon bg-warning text-white">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.prestasi.verification') }}" class="btn btn-warning btn-block">
                            <i class="fas fa-check-circle"></i> Verifikasi Prestasi
                            @if($stats['pending_verifikasi_prestasi'] > 0)
                                <span class="badge badge-light ml-1">{{ $stats['pending_verifikasi_prestasi'] }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.lomba.verification') }}" class="btn btn-info btn-block">
                            <i class="fas fa-clipboard-check"></i> Verifikasi Lomba
                            @if($stats['pending_verifikasi_lomba'] > 0)
                                <span class="badge badge-light ml-1">{{ $stats['pending_verifikasi_lomba'] }}</span>
                            @endif
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-primary btn-block">
                            <i class="fas fa-user-plus"></i> Kelola Mahasiswa
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('admin.lomba.index') }}" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Tambah Lomba
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Recent Activities -->
<div class="row">
    <!-- Monthly Statistics Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Bulanan</h6>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" onclick="exportChart('monthly')">Export PNG</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 300px;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Prestasi by Tingkatan -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Prestasi by Tingkatan</h6>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#" onclick="exportChart('tingkatan')">Export PNG</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2" style="height: 250px;">
                    <canvas id="tingkatanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <!-- Recent Prestasi -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Prestasi Terbaru</h6>
                <a href="{{ route('admin.prestasi.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($recentPrestasi as $prestasi)
                <div class="media mb-3 activity-item">
                    <div class="mr-3">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-trophy text-white"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <div class="small text-gray-500">
                            {{ $prestasi->created_at ? $prestasi->created_at->diffForHumans() : 'Waktu tidak tersedia' }}
                        </div>
                        <strong>{{ $prestasi->mahasiswa->mahasiswa_nama ?? 'N/A' }}</strong>
                        <div class="text-gray-700">{{ $prestasi->lomba->lomba_nama ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600">Peringkat: {{ $prestasi->peringkat->peringkat_nama ?? 'N/A' }}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-trophy fa-3x mb-3 text-gray-300"></i>
                    <p>Belum ada prestasi terbaru</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Lomba -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Lomba Terbaru</h6>
                <a href="{{ route('admin.lomba.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($recentLomba as $lomba)
                <div class="media mb-3 activity-item">
                    <div class="mr-3">
                        <div class="icon-circle bg-info">
                            <i class="fas fa-medal text-white"></i>
                        </div>
                    </div>
                    <div class="media-body">
                        <div class="small text-gray-500">
                            {{ $lomba->created_at ? $lomba->created_at->diffForHumans() : 'Waktu tidak tersedia' }}
                        </div>
                        <strong>{{ $lomba->lomba_nama }}</strong>
                        <div class="text-gray-700">{{ $lomba->tingkatan->tingkatan_nama ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600">
                            {{ $lomba->lomba_tanggal_mulai ? \Carbon\Carbon::parse($lomba->lomba_tanggal_mulai)->format('d M Y') : 'Tanggal tidak tersedia' }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="fas fa-medal fa-3x mb-3 text-gray-300"></i>
                    <p>Belum ada lomba terbaru</p>
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
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
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
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .clickable {
        cursor: pointer;
    }
    .activity-item {
        border-bottom: 1px solid #f8f9fc;
        padding-bottom: 1rem;
    }
    .activity-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .counter {
        transition: all 0.3s ease;
    }
    .chart-area, .chart-pie {
        position: relative;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Counter Animation
function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const current = parseInt(counter.innerText);
        const increment = target / 100;
        
        if (current < target) {
            counter.innerText = Math.ceil(current + increment);
            setTimeout(() => animateCounters(), 10);
        } else {
            counter.innerText = target;
        }
    });
}

// Dashboard refresh
function refreshDashboard() {
    showLoading('Memuat ulang dashboard...');
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

// Export chart function
function exportChart(chartId) {
    const canvas = document.getElementById(chartId + 'Chart');
    const url = canvas.toDataURL('image/png');
    const link = document.createElement('a');
    link.download = `${chartId}_chart.png`;
    link.href = url;
    link.click();
}

// Monthly Statistics Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
const monthlyChart = new Chart(monthlyCtx, {
    type: 'line',
    data: {
        labels: @json($monthlyData['months']),
        datasets: [{
            label: 'Mahasiswa Baru',
            data: @json($monthlyData['mahasiswa']),
            borderColor: 'rgb(16, 32, 68)',
            backgroundColor: 'rgba(16, 32, 68, 0.1)',
            tension: 0.3,
            fill: true
        }, {
            label: 'Prestasi Baru',
            data: @json($monthlyData['prestasi']),
            borderColor: 'rgb(40, 167, 69)',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.3,
            fill: true
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
                position: 'top'
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: 'white',
                bodyColor: 'white'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            }
        }
    }
});

// Prestasi by Tingkatan Chart
const tingkatanCtx = document.getElementById('tingkatanChart').getContext('2d');
const tingkatanChart = new Chart(tingkatanCtx, {
    type: 'doughnut',
    data: {
        labels: @json($prestasiByTingkatan->pluck('tingkatan_nama')),
        datasets: [{
            data: @json($prestasiByTingkatan->pluck('total')),
            backgroundColor: [
                '#4e73df',
                '#1cc88a',
                '#36b9cc',
                '#f6c23e',
                '#e74a3b',
                '#858796'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: 'white',
                bodyColor: 'white'
            }
        }
    }
});

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    animateCounters();
});
</script>
@endpush