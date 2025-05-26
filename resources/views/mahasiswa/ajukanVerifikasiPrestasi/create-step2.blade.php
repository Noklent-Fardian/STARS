@extends('layouts.template')

@section('title', 'Verifikasi Prestasi - Data Penghargaan | STARS')

@section('page-title', 'Verifikasi Prestasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('student.achievement.create') }}">Verifikasi Prestasi</a></li>
    <li class="breadcrumb-item active">Data Penghargaan</li>
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
                            <div class="step active">
                                <div class="step-number">2</div>
                                <div class="step-title">Data Penghargaan</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-title">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Award Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Data Penghargaan</h5>
                        <small class="text-muted">Lengkapi informasi penghargaan yang diperoleh</small>
                    </div>
                    <div class="card-body">
                        @if ($selectedLomba->lomba_terverifikasi == 1)
                            <div class="alert alert-info">
                                <strong>Lomba Terpilih:</strong> {{ $selectedLomba->lomba_nama }} -
                                {{ $selectedLomba->lomba_penyelenggara }}
                            </div>
                        @elseif($selectedLomba->lomba_terverifikasi == 0)
                            <div class="alert alert-warning">
                                <strong>Lomba Terpilih:</strong> {{ $selectedLomba->lomba_nama }} -
                                {{ $selectedLomba->lomba_penyelenggara }}
                                <br>
                                <strong>Status:</strong> Lomba yang diajukan sedang
                                menunggu verifikasi admin
                            </div>
                        @endif

                        <form action="{{ route('student.achievement.finalize') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($selectedLomba)
                                <input type="hidden" name="lomba_id" value="{{ $selectedLomba->id }}">
                            @endif
                            @if ($competitionSubmissionId)
                                <input type="hidden" name="competition_submission_id"
                                    value="{{ $competitionSubmissionId }}">
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Judul Penghargaan <span class="text-danger">*</span></label>
                                        <input type="text" name="penghargaan_judul" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Peringkat <span class="text-danger">*</span></label>
                                        <select name="peringkat_id" class="form-control" required>
                                            <option value="">Pilih Peringkat</option>
                                            @foreach ($peringkats as $peringkat)
                                                <option value="{{ $peringkat->id }}">{{ $peringkat->peringkat_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dosen Pembimbing <span class="text-danger">*</span></label>
                                        <select name="dosen_id" class="form-control" required>
                                            <option value="">Pilih Dosen Pembimbing</option>
                                            @foreach ($dosens as $dosen)
                                                <option value="{{ $dosen->id }}">{{ $dosen->dosen_nama }} -
                                                    {{ $dosen->dosen_nip }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Pilih dosen yang membimbing dalam lomba ini</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Pelaksanaan <span class="text-danger">*</span></label>
                                        <input type="text" name="penghargaan_tempat" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>URL Lomba</label>
                                        <input type="url" name="penghargaan_url" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Space for future fields -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" name="penghargaan_tanggal_mulai" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Selesai <span class="text-danger">*</span></label>
                                        <input type="date" name="penghargaan_tanggal_selesai" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Peserta <span class="text-danger">*</span></label>
                                        <input type="number" name="penghargaan_jumlah_peserta" class="form-control"
                                            min="1" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Instansi <span class="text-danger">*</span></label>
                                        <input type="number" name="penghargaan_jumlah_instansi" class="form-control"
                                            min="1" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nomor Surat Tugas <span class="text-danger">*</span></label>
                                        <input type="text" name="penghargaan_no_surat_tugas" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Surat Tugas <span class="text-danger">*</span></label>
                                        <input type="date" name="penghargaan_tanggal_surat_tugas" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6>Upload Dokumen</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>File Surat Tugas <span class="text-danger">*</span></label>
                                        <input type="file" name="penghargaan_file_surat_tugas"
                                            class="form-control-file" required accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>File Sertifikat <span class="text-danger">*</span></label>
                                        <input type="file" name="penghargaan_file_sertifikat"
                                            class="form-control-file" required accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>File Poster</label>
                                        <input type="file" name="penghargaan_file_poster" class="form-control-file"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Format: PDF, JPG, PNG (Max: 2MB)</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto Kegiatan</label>
                                        <input type="file" name="penghargaan_photo_kegiatan" class="form-control-file"
                                            accept=".jpg,.jpeg,.png">
                                        <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="text-right">
                                <a href="{{ route('student.achievement.create') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Lanjutkan <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </form>
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
            background-color: #007bff;
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
            color: #007bff;
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
