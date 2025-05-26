@extends('layouts.template')

@section('title', 'Verifikasi Prestasi - Selesai | STARS')

@section('page-title', 'Verifikasi Prestasi')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Verifikasi Prestasi</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Progress Steps -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="step-progress">
                        <div class="step completed">
                            <div class="step-number"><i class="fas fa-check"></i></div>
                            <div class="step-title">Pilih Lomba</div>
                        </div>
                        <div class="step-line completed"></div>
                        <div class="step completed">
                            <div class="step-number"><i class="fas fa-check"></i></div>
                            <div class="step-title">Data Penghargaan</div>
                        </div>
                        <div class="step-line completed"></div>
                        <div class="step active">
                            <div class="step-number"><i class="fas fa-check"></i></div>
                            <div class="step-title">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x text-success"></i>
                    </div>
                    <h3 class="text-success mb-3">Pengajuan Berhasil Disubmit!</h3>
                    <p class="text-muted mb-4">
                        Pengajuan verifikasi prestasi Anda telah berhasil disubmit dan sedang menunggu verifikasi dari admin dan dosen.
                    </p>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Proses Selanjutnya:</h6>
                        <ol class="text-left mb-0">
                            <li>Setelah kedua verifikasi selesai, prestasi akan masuk ke dalam sistem dan anda akan mendapat score penghargaan</li>
                            <li>Anda akan mendapatkan notifikasi hasil verifikasi</li>
                        </ol>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('mahasiswa.prestasi.index') }}" class="btn btn-primary mr-2">
                            <i class="fas fa-list"></i> Lihat Status Prestasi
                        </a>
                        <a href="{{ route('student.achievement.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-plus"></i> Ajukan Prestasi Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.step-progress {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 20px 0;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 8px;
}

.step.active .step-number {
    background-color: #28a745;
    color: white;
}

.step.completed .step-number {
    background-color: #28a745;
    color: white;
}

.step-title {
    font-size: 12px;
    text-align: center;
    color: #6c757d;
}

.step.active .step-title {
    color: #28a745;
    font-weight: 600;
}

.step.completed .step-title {
    color: #28a745;
    font-weight: 600;
}

.step-line {
    width: 100px;
    height: 2px;
    background-color: #e9ecef;
    margin: 0 20px;
    margin-bottom: 20px;
}

.step-line.completed {
    background-color: #28a745;
}
</style>
@endpush