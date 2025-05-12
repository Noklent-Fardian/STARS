@extends('layouts.template')

@section('title', 'Detail Bidang Keahlian | STARS')

@section('page-title', 'Detail Bidang Keahlian')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.master.bidangKeahlian.index') }}">Bidang Keahlian</a></li>
@endsection

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title ?? 'Detail Bidang Keahlian' }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($keahlian)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, bidang keahlian yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar" style="background: linear-gradient(135deg, #102044, #1a2a4d);">
                                    <i class="fas fa-cogs"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $keahlian->keahlian_nama }}</h4>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Keahlian</span>
                                    </div>
                                    <div class="info-value">{{ $keahlian->id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-cogs text-info"></i>
                                        <span>Nama Keahlian</span>
                                    </div>
                                    <div class="info-value">{{ $keahlian->keahlian_nama }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-eye text-success"></i>
                                        <span>Keahlian Visible</span>
                                    </div>
                                    <div class="info-value">{{ $keahlian->keahlian_visible ? 'Ya' : 'Tidak' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus text-success"></i>
                                        <span>Tanggal Dibuat</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $keahlian->created_at ? $keahlian->created_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check text-success"></i>
                                        <span>Terakhir Diperbarui</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $keahlian->updated_at ? $keahlian->updated_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.master.bidangKeahlian.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
                @if(!empty($keahlian))
                <div>
                    <button onclick="modalAction('{{ route('admin.master.bidangKeahlian.editAjax', $keahlian->id) }}')" class="btn btn-warning px-4 mr-2">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </button>
                    <button onclick="modalAction('{{ route('admin.master.bidangKeahlian.confirmAjax', $keahlian->id) }}')" class="btn btn-danger px-4">
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