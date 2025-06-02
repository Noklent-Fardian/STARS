@extends('layouts.template')

@section('title', 'Rekomendasi SAW | STARS')

@section('page-title', 'Rekomendasi SAW')

@section('breadcrumb')
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Generate Rekomendasi Mahasiswa untuk Lomba IT (SAW Method)</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted">
                            <i class="fas fa-info-circle"></i> Sistem ini akan merekomendasikan mahasiswa terbaik untuk mengikuti lomba IT berdasarkan metode SAW (Simple Additive Weighting) dengan 4 kriteria:
                        </h6>
                        <ul class="text-muted mt-2">
                            <li><strong>Skor Mahasiswa:</strong> Nilai dari prestasi akademik dan non-akademik</li>
                            <li><strong>Keahlian Utama:</strong> Bidang keahlian utama yang dikuasai</li>
                            <li><strong>Keahlian Tambahan:</strong> Jumlah keahlian tambahan yang dimiliki</li>
                            <li><strong>Pengalaman Lomba:</strong> Total lomba yang pernah diikuti sebelumnya</li>
                        </ul>
                    </div>

                    {{-- Debug info --}}
                    <div class="alert alert-info">
                        <strong>Debug:</strong> Found {{ $lombaAkanDatang->count() }} upcoming competitions
                    </div>

                    @if($lombaAkanDatang->count() > 0)
                        <form action="{{ route('admin.rekomendasiSaw.generate') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lomba_id" class="form-label">Pilih Lomba</label>
                                        <select class="form-control @error('lomba_id') is-invalid @enderror" 
                                                id="lomba_id" name="lomba_id" required>
                                            <option value="">-- Pilih Lomba --</option>
                                            @foreach($lombaAkanDatang as $lomba)
                                                <option value="{{ $lomba->id }}" {{ old('lomba_id') == $lomba->id ? 'selected' : '' }}>
                                                    {{ $lomba->lomba_nama }} 
                                                    <small>({{ \Carbon\Carbon::parse($lomba->lomba_tanggal_mulai)->format('d M Y') }})</small>
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('lomba_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jumlah_rekomendasi" class="form-label">Jumlah Rekomendasi</label>
                                        <select class="form-control @error('jumlah_rekomendasi') is-invalid @enderror" 
                                                id="jumlah_rekomendasi" name="jumlah_rekomendasi" required>
                                            <option value="">-- Pilih Jumlah --</option>
                                            @for($i = 1; $i <= 20; $i++)
                                                <option value="{{ $i }}" {{ old('jumlah_rekomendasi') == $i ? 'selected' : '' }}>
                                                    {{ $i }} Mahasiswa
                                                </option>
                                            @endfor
                                        </select>
                                        @error('jumlah_rekomendasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-calculator"></i> Generate Rekomendasi
                                </button>
                                <a href="{{ route('admin.kelolaBobot.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-weight-hanging"></i> Kelola Bobot Kriteria
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Tidak ada lomba yang akan datang.</strong> 
                            Silakan tambahkan lomba terlebih dahulu atau tunggu hingga ada lomba yang dijadwalkan.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info Lomba Yang Akan Datang -->
    @if($lombaAkanDatang->count() > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lomba Yang Akan Datang</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lomba</th>
                                        <th>Penyelenggara</th>
                                        <th>Kategori</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lombaAkanDatang as $lomba)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $lomba->lomba_nama }}</td>
                                            <td>{{ $lomba->lomba_penyelenggara }}</td>
                                            <td>{{ $lomba->lomba_kategori }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lomba->lomba_tanggal_mulai)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lomba->lomba_tanggal_selesai)->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge badge-info">Akan Datang</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection