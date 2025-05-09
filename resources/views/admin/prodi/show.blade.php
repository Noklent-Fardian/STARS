@extends('layouts.template')

@section('title', 'Detail Program Studi | STARS')

@section('page-title', 'Detail Program Studi')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.master.prodi.index') }}">Program Studi</a></li>
@endsection

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title ?? 'Detail Program Studi' }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($prodi)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, program studi yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar" style="background: linear-gradient(135deg, #102044, #1a2a4d);">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $prodi->prodi_nama }}</h4>
                            <span class="badge badge-primary px-3 py-2">Kode: {{ $prodi->prodi_kode }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Program Studi</span>
                                    </div>
                                    <div class="info-value">{{ $prodi->id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-graduation-cap text-info"></i>
                                        <span>Nama Program Studi</span>
                                    </div>
                                    <div class="info-value">{{ $prodi->prodi_nama }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-code text-warning"></i>
                                        <span>Kode Program Studi</span>
                                    </div>
                                    <div class="info-value">{{ $prodi->prodi_kode }}</div>
                                </div>
                                {{-- <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-eye text-success"></i>
                                        <span>Status</span>
                                    </div>
                                    <div class="info-value">
                                        @if($prodi->prodi_visible)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Non-Aktif</span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-plus text-success"></i>
                                        <span>Tanggal Dibuat</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $prodi->created_at ? $prodi->created_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check text-success"></i>
                                        <span>Terakhir Diperbarui</span>
                                    </div>
                                    <div class="info-value">
                                        {{ $prodi->updated_at ? $prodi->updated_at->format('d F Y H:i') : 'Tidak Ada Data' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.master.prodi.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
                
                @if(!empty($prodi))
                <div>
                    <button onclick="modalAction('{{ route('admin.master.prodi.editAjax', $prodi->id) }}')" class="btn btn-warning px-4 mr-2">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </button>
                    <button onclick="modalAction('{{ route('admin.master.prodi.confirmAjax', $prodi->id) }}')" class="btn btn-danger px-4">
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
    .user-avatar-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    
    .user-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .user-info-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
    }
    
    .info-label i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    
    .info-value {
        flex: 1;
        font-weight: 500;
    }
    
    .animated-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0.1) 100%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
        z-index: 0;
    }
    
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endpush