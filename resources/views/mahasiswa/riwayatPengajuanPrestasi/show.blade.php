@extends('layouts.template')

@section('title', $verifikasi->penghargaan->penghargaan_judul . ' | STARS')

@section('page-title', 'Detail Verifikasi Prestasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.riwayatPengajuanPrestasi.index') }}">Riwayat Verifikasi Prestasi</a></li>
    <li class="breadcrumb-item active">{{ $verifikasi->penghargaan->penghargaan_judul }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Achievement Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="achievement-header-card">
                    <div class="achievement-content">
                        <!-- Status Badges -->
                        <div class="status-badges mb-4">
                            <!-- Dosen Verification Status -->
                            @if ($verifikasi->verifikasi_dosen_status === 'Diterima')
                                <span class="status-badge dosen-approved">
                                    <i class="fas fa-user-check"></i>
                                    <span>Dosen: Disetujui</span>
                                </span>
                            @elseif($verifikasi->verifikasi_dosen_status === 'Ditolak')
                                <span class="status-badge dosen-rejected">
                                    <i class="fas fa-user-times"></i>
                                    <span>Dosen: Ditolak</span>
                                </span>
                            @else
                                <span class="status-badge dosen-pending">
                                    <i class="fas fa-user-clock"></i>
                                    <span>Dosen: Menunggu</span>
                                </span>
                            @endif

                            <!-- Admin Verification Status -->
                            @if ($verifikasi->verifikasi_admin_status === 'Diterima')
                                <span class="status-badge admin-approved">
                                    <i class="fas fa-shield-check"></i>
                                    <span>Admin: Disetujui</span>
                                </span>
                            @elseif($verifikasi->verifikasi_admin_status === 'Ditolak')
                                <span class="status-badge admin-rejected">
                                    <i class="fas fa-shield-times"></i>
                                    <span>Admin: Ditolak</span>
                                </span>
                            @else
                                <span class="status-badge admin-pending">
                                    <i class="fas fa-shield-halved"></i>
                                    <span>Admin: Menunggu</span>
                                </span>
                            @endif

                            <!-- Overall Status -->
                            @if ($verifikasi->verifikasi_dosen_status === 'Diterima' && $verifikasi->verifikasi_admin_status === 'Diterima')
                                <span class="status-badge verified">
                                    <i class="fas fa-certificate"></i>
                                    <span>Terverifikasi</span>
                                </span>
                            @elseif($verifikasi->verifikasi_dosen_status === 'Ditolak' || $verifikasi->verifikasi_admin_status === 'Ditolak')
                                <span class="status-badge rejected">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Ditolak</span>
                                </span>
                            @else
                                <span class="status-badge pending">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span>Dalam Proses</span>
                                </span>
                            @endif
                        </div>

                        <!-- Achievement Title and Score -->
                        <div class="achievement-title-section">
                            <h1 class="achievement-title">{{ $verifikasi->penghargaan->penghargaan_judul }}</h1>
                            <div class="achievement-score">
                                <div class="score-card">
                                    <div class="score-icon">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="score-content">
                                        <div class="score-value">{{ $verifikasi->penghargaan->penghargaan_score ?? 0 }}</div>
                                        <div class="score-label">Poin Prestasi</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Achievement Meta Info -->
                        <div class="achievement-meta">
                            <div class="meta-item">
                                <i class="fas fa-trophy"></i>
                                <span>{{ $verifikasi->penghargaan->lomba->lomba_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-medal"></i>
                                <span>{{ $verifikasi->penghargaan->peringkat->peringkat_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-layer-group"></i>
                                <span>{{ $verifikasi->penghargaan->lomba->tingkatan->tingkatan_nama ?? 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_mulai)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Cards -->
        <div class="row g-4">
            <!-- Competition Information -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h5 class="header-title">Informasi Lomba</h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Nama Lomba</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->lomba->lomba_nama ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Penyelenggara</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->lomba->lomba_penyelenggara ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Kategori</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->lomba->lomba_kategori ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Tingkatan</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->lomba->tingkatan->tingkatan_nama ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievement Details -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h5 class="header-title">Detail Prestasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Peringkat</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->peringkat->peringkat_nama ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Tempat Pelaksanaan</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->penghargaan_tempat ?? 'N/A' }}</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Jumlah Peserta</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->penghargaan_jumlah_peserta ?? 'N/A' }} peserta</div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Jumlah Instansi</div>
                                <div class="detail-value">{{ $verifikasi->penghargaan->penghargaan_jumlah_instansi ?? 'N/A' }} instansi</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline and Documents -->
        <div class="row g-4 mt-2">
            <!-- Timeline -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h5 class="header-title">Timeline Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline-container">
                            <div class="timeline-item">
                                <div class="timeline-marker start"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Mulai Kegiatan</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_mulai)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker end"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Selesai Kegiatan</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_selesai)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker document"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Surat Tugas</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($verifikasi->penghargaan->penghargaan_tanggal_surat_tugas)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                    <small class="timeline-note">No: {{ $verifikasi->penghargaan->penghargaan_no_surat_tugas }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="col-lg-6">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h5 class="header-title">Dokumen Pendukung</h5>
                    </div>
                    <div class="card-body">
                        <div class="documents-grid">
                            @if($verifikasi->penghargaan->penghargaan_file_sertifikat)
                                <div class="document-item">
                                    <div class="document-icon">
                                        <i class="fas fa-certificate"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Sertifikat</div>
                                        <a href="{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_file_sertifikat) }}" 
                                           target="_blank" class="document-link">
                                            <i class="fas fa-external-link-alt"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($verifikasi->penghargaan->penghargaan_file_surat_tugas)
                                <div class="document-item">
                                    <div class="document-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Surat Tugas</div>
                                        <a href="{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_file_surat_tugas) }}" 
                                           target="_blank" class="document-link">
                                            <i class="fas fa-external-link-alt"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($verifikasi->penghargaan->penghargaan_file_poster)
                                <div class="document-item">
                                    <div class="document-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Poster Kegiatan</div>
                                        <a href="{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_file_poster) }}" 
                                           target="_blank" class="document-link">
                                            <i class="fas fa-external-link-alt"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($verifikasi->penghargaan->penghargaan_photo_kegiatan)
                                <div class="document-item">
                                    <div class="document-icon">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <div class="document-content">
                                        <div class="document-name">Foto Kegiatan</div>
                                        <a href="{{ asset('storage/' . $verifikasi->penghargaan->penghargaan_photo_kegiatan) }}" 
                                           target="_blank" class="document-link">
                                            <i class="fas fa-external-link-alt"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Details -->
        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="detail-card">
                    <div class="card-header-custom">
                        <div class="header-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h5 class="header-title">Detail Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Dosen Verification -->
                            <div class="col-lg-6">
                                <div class="verification-section">
                                    <h6 class="verification-title">
                                        <i class="fas fa-user-tie"></i>
                                        Verifikasi Dosen Pembimbing
                                    </h6>
                                    <div class="verification-details">
                                        <div class="detail-item">
                                            <div class="detail-label">Dosen Pembimbing</div>
                                            <div class="detail-value">{{ $verifikasi->dosen->dosen_nama ?? 'N/A' }}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Status</div>
                                            <div class="detail-value">
                                                @if($verifikasi->verifikasi_dosen_status === 'Diterima')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif($verifikasi->verifikasi_dosen_status === 'Ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($verifikasi->verifikasi_dosen_tanggal)
                                            <div class="detail-item">
                                                <div class="detail-label">Tanggal Verifikasi</div>
                                                <div class="detail-value">
                                                    {{ \Carbon\Carbon::parse($verifikasi->verifikasi_dosen_tanggal)->locale('id')->translatedFormat('d F Y') }}
                                                </div>
                                            </div>
                                        @endif
                                        @if($verifikasi->verifikasi_dosen_keterangan)
                                            <div class="detail-item">
                                                <div class="detail-label">Keterangan</div>
                                                <div class="detail-value">{{ $verifikasi->verifikasi_dosen_keterangan }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Verification -->
                            <div class="col-lg-6">
                                <div class="verification-section">
                                    <h6 class="verification-title">
                                        <i class="fas fa-user-shield"></i>
                                        Verifikasi Admin
                                    </h6>
                                    <div class="verification-details">
                                        <div class="detail-item">
                                            <div class="detail-label">Admin</div>
                                            <div class="detail-value">{{ $verifikasi->admin->admin_nama ?? 'Belum ditugaskan' }}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Status</div>
                                            <div class="detail-value">
                                                @if($verifikasi->verifikasi_admin_status === 'Diterima')
                                                    <span class="badge badge-success">Disetujui</span>
                                                @elseif($verifikasi->verifikasi_admin_status === 'Ditolak')
                                                    <span class="badge badge-danger">Ditolak</span>
                                                @else
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($verifikasi->verifikasi_admin_tanggal)
                                            <div class="detail-item">
                                                <div class="detail-label">Tanggal Verifikasi</div>
                                                <div class="detail-value">
                                                    {{ \Carbon\Carbon::parse($verifikasi->verifikasi_admin_tanggal)->locale('id')->translatedFormat('d F Y') }}
                                                </div>
                                            </div>
                                        @endif
                                        @if($verifikasi->verifikasi_admin_keterangan)
                                            <div class="detail-item">
                                                <div class="detail-label">Keterangan</div>
                                                <div class="detail-value">{{ $verifikasi->verifikasi_admin_keterangan }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mt-4">
            <div class="col-12">
                <a href="{{ route('mahasiswa.riwayatPengajuanPrestasi.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Riwayat Prestasi</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --primary-color: #102044;
            --secondary-color: #1a2a4d;
            --accent-color: #fa9d1c;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        /* Achievement Header */
        .achievement-header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2.5rem;
            color: white;
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .achievement-header-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .achievement-content {
            position: relative;
            z-index: 2;
        }

        .status-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .status-badge.verified {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .status-badge.pending {
            background: rgba(245, 158, 11, 0.2);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .status-badge.rejected {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .status-badge.dosen-approved,
        .status-badge.admin-approved {
            background: rgba(16, 185, 129, 0.2);
            border-color: rgba(16, 185, 129, 0.3);
        }

        .status-badge.dosen-pending,
        .status-badge.admin-pending {
            background: rgba(245, 158, 11, 0.2);
            border-color: rgba(245, 158, 11, 0.3);
        }

        .status-badge.dosen-rejected,
        .status-badge.admin-rejected {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.3);
        }

        .achievement-title-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .achievement-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin: 0;
            flex: 1;
        }

        .score-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .score-icon {
            width: 60px;
            height: 60px;
            background: rgba(250, 157, 28, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--accent-color);
        }

        .score-value {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .score-label {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .achievement-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .meta-item i {
            width: 16px;
            text-align: center;
        }

        /* Detail Cards */
        .detail-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--light-bg), white);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--accent-color), #d97706);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .header-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        /* Detail Grid */
        .detail-grid {
            display: grid;
            gap: 1.5rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Timeline */
        .timeline-container {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-container::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--accent-color), var(--success-color));
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
        }

        .timeline-marker {
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .timeline-marker.start {
            background: var(--info-color);
        }

        .timeline-marker.end {
            background: var(--success-color);
        }

        .timeline-marker.document {
            background: var(--accent-color);
        }

        .timeline-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .timeline-date {
            color: var(--text-secondary);
            margin: 0;
        }

        .timeline-note {
            color: var(--text-secondary);
            font-style: italic;
        }

        /* Documents Grid */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .document-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--light-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .document-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .document-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--info-color), #2563eb);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
        }

        .document-name {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .document-link {
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .document-link:hover {
            color: #d97706;
            text-decoration: none;
        }

        /* Verification Section */
        .verification-section {
            background: var(--light-bg);
            border-radius: 12px;
            padding: 1.5rem;
            height: 100%;
        }

        .verification-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border-color);
        }

        .verification-details .detail-item {
            margin-bottom: 1rem;
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .achievement-header-card {
                margin-bottom: 1rem;
            }

            .achievement-content {
                padding: 1.5rem;
            }

            .achievement-title {
                font-size: 2rem;
            }

            .meta-item {
                font-size: 0.9rem;
            }

            .achievement-title-section {
                flex-direction: column;
                gap: 1.5rem;
            }

            .documents-grid {
                grid-template-columns: 1fr;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .achievement-content {
                padding: 1rem;
            }

            .achievement-title {
                font-size: 1.5rem;
            }

            .score-value {
                font-size: 2rem;
            }

            .card-header-custom {
                padding: 1rem;
            }

            .header-icon {
                width: 40px;
                height: 40px;
            }

            .header-title {
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Add animation to achievement header
            $('.achievement-header-card').addClass('animate__animated animate__fadeIn');
            
            // Add stagger animation to status cards
            $('.status-badge').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
                $(this).addClass('animate__animated animate__fadeInUp');
            });

            // Add stagger animation to detail cards
            $('.detail-card').each(function(index) {
                $(this).css('animation-delay', (index * 0.2) + 's');
                $(this).addClass('animate__animated animate__fadeInUp');
            });

            // Document hover effects
            $('.document-item').hover(
                function() {
                    $(this).find('.document-icon').addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).find('.document-icon').removeClass('animate__animated animate__pulse');
                }
            );
        });
    </script>
@endpush
