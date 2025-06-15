@extends('layouts.template')

@section('title', 'Detail Rekomendasi | STARS')

@section('page-title', 'Detail Rekomendasi Lomba')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('mahasiswa.rekomendasi.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @php
        $data = json_decode($notification->data, true);
        $isRead = $notification->read_at !== null;
    @endphp

    <!-- Competition Details -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow {{ !$isRead ? 'border-left-success' : '' }}">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-trophy mr-2"></i>
                        {{ $notification->title }}
                        @if(!$isRead)
                            <span class="badge badge-success ml-2">Baru</span>
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-primary mb-3">{{ $data['lomba_nama'] ?? 'Nama Lomba Tidak Tersedia' }}</h4>
                            <p class="lead">{{ $notification->message }}</p>
                            
                            @if(isset($data['lomba_details']))
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Penyelenggara</strong></td>
                                                <td>: {{ $data['lomba_details']['penyelenggara'] ?? 'Tidak tersedia' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Mulai</strong></td>
                                                <td>: {{ isset($data['lomba_details']['tanggal_mulai']) ? \Carbon\Carbon::parse($data['lomba_details']['tanggal_mulai'])->format('d M Y') : 'Tidak tersedia' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Selesai</strong></td>
                                                <td>: {{ isset($data['lomba_details']['tanggal_selesai']) ? \Carbon\Carbon::parse($data['lomba_details']['tanggal_selesai'])->format('d M Y') : 'Tidak tersedia' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        @if(isset($data['lomba_details']['link_pendaftaran']))
                                            <div class="text-center">
                                                <a href="{{ $data['lomba_details']['link_pendaftaran'] }}" 
                                                   target="_blank" 
                                                   class="btn btn-success btn-lg">
                                                    <i class="fas fa-external-link-alt mr-2"></i> Daftar Sekarang
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="bg-gradient-success text-white rounded p-4 mb-3">
                                <h2 class="mb-0">#{{ $data['ranking'] ?? 'N/A' }}</h2>
                                <p class="mb-0">Ranking Anda</p>
                            </div>
                            <div class="text-muted">
                                <small>dari {{ $data['total_recommended'] ?? 0 }} mahasiswa yang direkomendasikan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Qualified Students -->
    @if(isset($data['other_qualified']) && !empty($data['other_qualified']))
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-users mr-2"></i>
                            Mahasiswa Lain yang Direkomendasikan ({{ count($data['other_qualified']) }} orang)
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Ranking</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Angkatan</th>
                                        <th>No. Telepon</th>
                                        <th>Keahlian Utama</th>
                                        <th class="text-center">Skor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['other_qualified'] as $student)
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge badge-{{ $student['ranking'] <= 3 ? 'warning' : 'info' }}">
                                                    #{{ $student['ranking'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if(isset($student['photo']) && $student['photo'] && $student['photo'] !== 'default-avatar.png')
                                                    <img src="{{ asset('storage/photos/' . $student['photo']) }}" 
                                                         alt="{{ $student['nama'] }}" 
                                                         class="rounded-circle" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-white"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $student['nama'] }}</strong>
                                                @if($student['ranking'] <= 3)
                                                    <i class="fas fa-star text-warning ml-1"></i>
                                                @endif
                                            </td>
                                            <td>{{ $student['nim'] }}</td>
                                            <td>{{ $student['angkatan'] }}</td>
                                            <td>{{ $student['nomor_telepon'] }}</td>
                                            <td>{{ $student['keahlian_utama'] }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-primary">{{ $student['skor_preferensi'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Tip:</strong> Anda dapat menghubungi mahasiswa lain yang direkomendasikan untuk membentuk tim atau berbagi informasi tentang lomba ini.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('css')
<style>
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(45deg, #1cc88a, #13855c);
    }
    
    .rounded-circle {
        border: 2px solid #e3e6f0;
    }
    
    .table th {
        border-top: none;
        font-weight: 600;
    }
</style>
@endpush