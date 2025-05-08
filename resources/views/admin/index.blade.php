@extends('layouts.template')

@section('title', 'Admin Dashboard | STARS')

@section('page-title', 'Dashboard')

@section('breadcrumb')
<!-- Dashboard is home page, so no additional breadcrumb needed -->
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
                <div>
                    <h4 class="mb-1">Selamat Datang, {{ Auth::user()->admin->admin_name ?? Auth::user()->username }}</h4>
                    <p>Selamat datang di dashboard Admin. Pantau dan kelola data prestasi mahasiswa dengan mudah.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <!-- Total Mahasiswa -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Mahasiswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">358</div>
                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                            <span>Dari bulan lalu</span>
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

    <!-- Rest of your content -->
    <!-- ... -->
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
</style>
@endpush