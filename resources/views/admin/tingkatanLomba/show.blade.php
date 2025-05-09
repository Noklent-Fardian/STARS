@extends('layouts.template')

@section('title', 'Detail Tingkatan Lomba | STARS')

@section('page-title', 'Detail Tingkatan Lomba')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.master.tingkatanLomba.index') }}">Tingkatan Lomba</a></li>
@endsection

@section('content')
<div class="card shadow-sm rounded-lg overflow-hidden">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Detail Tingkatan Lomba</h6>
        <a href="{{ route('admin.master.tingkatanLomba.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        
        @empty($tingkatan)
            <div class="alert alert-danger">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                    <div>
                        <h5 class="mb-1">Data Tidak Ditemukan</h5>
                        <p class="mb-0">Maaf, tingkatan lomba yang Anda cari tidak ada dalam database.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <div class="p-4 bg-light rounded">
                        <div class="mb-3">
                            <i class="fas fa-trophy fa-4x text-warning"></i>
                        </div>
                        <h4 class="mb-2 font-weight-bold">{{ $tingkatan->tingkatan_nama }}</h4>
                        <div class="d-flex justify-content-center mt-2">
                            <div class="px-3 py-2 bg-primary text-white rounded-pill">
                                <i class="fas fa-star mr-1"></i> {{ $tingkatan->tingkatan_point }} Poin
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 font-weight-bold">Informasi Tingkatan</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th width="200">ID</th>
                                    <td width="30">:</td>
                                    <td>{{ $tingkatan->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Tingkatan</th>
                                    <td>:</td>
                                    <td>{{ $tingkatan->tingkatan_nama }}</td>
                                </tr>
                                <tr>
                                    <th>Poin</th>
                                    <td>:</td>
                                    <td>{{ $tingkatan->tingkatan_point }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Dibuat</th>
                                    <td>:</td>
                                    <td>{{ $tingkatan->created_at ? $tingkatan->created_at->format('d F Y H:i') : 'Tidak Ada Data' }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diperbarui</th>
                                    <td>:</td>
                                    <td>{{ $tingkatan->updated_at ? $tingkatan->updated_at->format('d F Y H:i') : 'Tidak Ada Data' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-3 d-flex">
                        <button onclick="modalAction('{{ route('admin.master.tingkatanLomba.editAjax', $tingkatan->id) }}')" class="btn btn-warning mr-2">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                        <button onclick="modalAction('{{ route('admin.master.tingkatanLomba.confirmAjax', $tingkatan->id) }}')" class="btn btn-danger mr-2">
                            <i class="fas fa-trash-alt mr-1"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        @endempty
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
        $('.card').css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        });
        
        setTimeout(function() {
            $('.card').css({
                'opacity': 1,
                'transform': 'translateY(0)',
                'transition': 'all 0.6s ease-out'
            });
        }, 200);
    });
</script>
@endpush