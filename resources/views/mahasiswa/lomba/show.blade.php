@extends('layouts.template')

@section('title', $lomba->lomba_nama . ' | STARS')

@section('page-title', 'Detail Lomba')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.lomba.index') }}">Lihat Lomba</a></li>
    <li class="breadcrumb-item active">{{ $lomba->lomba_nama }}</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Competition Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="modern-card shadow-lg border-0">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Competition Poster -->
                            <div class="col-lg-4">
                                <div class="poster-container modern-poster">
                                    @if ($lomba->lomba_link_poster)
                                        <img src="{{ $lomba->lomba_link_poster }}" class="img-fluid poster-image"
                                            alt="{{ $lomba->lomba_nama }}"
                                            onerror="this.src='https://picsum.photos/500/500?random={{ $lomba->id }}'">
                                    @else
                                        <div class="default-poster-modern">
                                            <div class="poster-icon">
                                                <i class="fas fa-trophy"></i>
                                            </div>
                                            <h5 class="poster-title">{{ $lomba->lomba_nama }}</h5>
                                        </div>
                                    @endif
                                    <div class="poster-overlay">
                                        <div class="poster-overlay-content">
                                            <i class="fas fa-expand-alt"></i>
                                            <span>Lihat Poster</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Competition Info -->
                            <div class="col-lg-8">
                                <div class="competition-content p-4 p-lg-5">
                                    <!-- Status Badges -->
                                    <div class="status-badges mb-4">
                                        @if ($lomba->lomba_terverifikasi)
                                            <span class="modern-badge verified">
                                                <i class="fas fa-shield-check"></i>
                                                <span>Terverifikasi</span>
                                            </span>
                                        @else
                                            <span class="modern-badge pending">
                                                <i class="fas fa-clock"></i>
                                                <span>Menunggu Verifikasi</span>
                                            </span>
                                        @endif

                                        @php
                                            $now = now();
                                            $start = $lomba->lomba_tanggal_mulai;
                                            $end = $lomba->lomba_tanggal_selesai;
                                        @endphp

                                        @if ($now < $start)
                                            <span class="modern-badge upcoming">
                                                <i class="fas fa-calendar-plus"></i>
                                                <span>Akan Datang</span>
                                            </span>
                                        @elseif($now >= $start && $now <= $end)
                                            <span class="modern-badge ongoing">
                                                <i class="fas fa-play-circle"></i>
                                                <span>Sedang Berlangsung</span>
                                            </span>
                                        @else
                                            <span class="modern-badge finished">
                                                <i class="fas fa-flag-checkered"></i>
                                                <span>Sudah Selesai</span>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Competition Title -->
                                    <h1 class="competition-title mb-4">{{ $lomba->lomba_nama }}</h1>

                                    <!-- Basic Info Grid -->
                                    <div class="info-grid mb-4">
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-building"></i>
                                            </div>
                                            <div class="info-content">
                                                <span class="info-label">Penyelenggara</span>
                                                <span class="info-value">{{ $lomba->lomba_penyelenggara }}</span>
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <div class="info-content">
                                                <span class="info-label">Kategori</span>
                                                <span class="info-value">{{ $lomba->lomba_kategori }}</span>
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-layer-group"></i>
                                            </div>
                                            <div class="info-content">
                                                <span class="info-label">Tingkatan</span>
                                                <span class="info-value">{{ $lomba->tingkatan->tingkatan_nama }}</span>
                                            </div>
                                        </div>
                                        <div class="info-item">
                                            <div class="info-icon">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div class="info-content">
                                                <span class="info-label">Semester</span>
                                                <span
                                                    class="info-value">{{ $lomba->semester->semester_nama ?? 'Tidak ditentukan' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="action-buttons">
                                        @if ($lomba->lomba_link_pendaftaran)
                                            <a href="{{ $lomba->lomba_link_pendaftaran }}" target="_blank"
                                                class="modern-btn primary">
                                                <i class="fas fa-external-link-alt"></i>
                                                <span>Buka Link Pendaftaran</span>
                                            </a>
                                        @endif
                                        <button type="button" class="modern-btn secondary"
                                            onclick="selectCompetition({{ $lomba->id }})">
                                            <i class="fas fa-user-plus"></i>
                                            <span>Ajukan Verifikasi Pengghargaan</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Competition Details -->
        <div class="row g-4">
            <!-- Date and Time Info -->
            <div class="col-lg-6">
                <div class="modern-card h-100">
                    <div class="card-header-modern">
                        <div class="header-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h5 class="header-title">Waktu Pelaksanaan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline-modern">
                            <div class="timeline-item-modern">
                                <div class="timeline-marker start"></div>
                                <div class="timeline-content-modern">
                                    <h6 class="timeline-title">Tanggal Mulai Pendaftaran</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($lomba->lomba_tanggal_mulai)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                    <small
                                        class="timeline-relative">{{ $lomba->lomba_tanggal_mulai->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="timeline-item-modern">
                                <div class="timeline-marker end"></div>
                                <div class="timeline-content-modern">
                                    <h6 class="timeline-title">Tanggal Selesai</h6>
                                    <p class="timeline-date">
                                        {{ \Carbon\Carbon::parse($lomba->lomba_tanggal_selesai)->locale('id')->translatedFormat('l, d F Y') }}
                                    </p>
                                    <small
                                        class="timeline-relative">{{ $lomba->lomba_tanggal_selesai->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Card -->
                        <div class="duration-card">
                            <div class="duration-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="duration-content">
                                <h6 class="duration-label">Durasi Lomba</h6>
                                <p class="duration-value">
                                    {{ $lomba->lomba_tanggal_mulai->diffInDays($lomba->lomba_tanggal_selesai) + 1 }} hari
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills Required -->
            <div class="col-lg-6">
                <div class="modern-card h-100">
                    <div class="card-header-modern">
                        <div class="header-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h5 class="header-title">Bidang Keahlian</h5>
                    </div>
                    <div class="card-body p-4">
                        @if ($lomba->keahlians->count() > 0)
                            <div class="skills-grid">
                                @foreach ($lomba->keahlians as $keahlian)
                                    <div class="skill-tag">
                                        <i class="fas fa-code"></i>
                                        <span>{{ $keahlian->keahlian_nama }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state-modern">
                                <i class="fas fa-info-circle"></i>
                                <p>Bidang keahlian tidak ditentukan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        @if ($lomba->lomba_link_poster || $lomba->lomba_link_pendaftaran)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="modern-card">
                        <div class="card-header-modern">
                            <div class="header-icon">
                                <i class="fas fa-link"></i>
                            </div>
                            <h5 class="header-title">Informasi Tambahan</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="links-grid">
                                @if ($lomba->lomba_link_poster)
                                    <div class="link-card">
                                        <div class="link-icon">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <div class="link-content">
                                            <h6 class="link-title">Link Poster</h6>
                                            <a href="{{ $lomba->lomba_link_poster }}" target="_blank"
                                                class="link-button">
                                                <i class="fas fa-external-link-alt"></i>
                                                Lihat Poster
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                @if ($lomba->lomba_link_pendaftaran)
                                    <div class="link-card">
                                        <div class="link-icon">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                        <div class="link-content">
                                            <h6 class="link-title">Link Pendaftaran</h6>
                                            <a href="{{ $lomba->lomba_link_pendaftaran }}" target="_blank"
                                                class="link-button">
                                                <i class="fas fa-external-link-alt"></i>
                                                Akses Pendaftaran
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="row mt-4">
            <div class="col-12">
                <a href="{{ route('mahasiswa.lomba.index') }}" class="modern-btn outline">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Daftar Lomba</span>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        /* Modern Card Styles */
        .modern-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12), 0 16px 40px rgba(0, 0, 0, 0.08);
        }

        /* Poster Container */
        .modern-poster {
            position: relative;
            height: 400px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .poster-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .default-poster-modern {
            text-align: center;
            color: white;
            z-index: 2;
        }

        .poster-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .poster-icon i {
            font-size: 2rem;
            color: white;
        }

        .poster-title {
            color: white;
            font-weight: 600;
            margin: 0;
        }

        .poster-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .modern-poster:hover .poster-overlay {
            opacity: 1;
        }

        .modern-poster:hover .poster-image {
            transform: scale(1.05);
        }

        .poster-overlay-content {
            text-align: center;
            color: white;
        }

        .poster-overlay-content i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Competition Content */
        .competition-content {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .competition-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a202c;
            line-height: 1.2;
            margin: 0;
        }

        /* Modern Badges */
        .status-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .modern-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modern-badge.verified {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .modern-badge.pending {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .modern-badge.upcoming {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .modern-badge.ongoing {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .modern-badge.finished {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .info-content {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 500;
        }

        .info-value {
            font-size: 1rem;
            color: #1e293b;
            font-weight: 600;
        }

        /* Modern Buttons */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .modern-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .modern-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .modern-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .modern-btn.secondary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .modern-btn.secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
            color: white;
            text-decoration: none;
        }

        .modern-btn.outline {
            background: transparent;
            color: #667eea;
            border-color: #667eea;
        }

        .modern-btn.outline:hover {
            background: #667eea;
            color: white;
            text-decoration: none;
        }

        /* Card Header Modern */
        .card-header-modern {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem 1.5rem 0;
            border-bottom: none;
            background: transparent;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .header-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
        }

        /* Timeline Modern */
        .timeline-modern {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-modern::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #667eea, #764ba2);
        }

        .timeline-item-modern {
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
            background: #667eea;
        }

        .timeline-marker.end {
            background: #10b981;
        }

        .timeline-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .timeline-date {
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .timeline-relative {
            color: #94a3b8;
            font-style: italic;
        }

        /* Duration Card */
        .duration-card {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 1px solid #0ea5e9;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .duration-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .duration-label {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .duration-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0ea5e9;
            margin: 0;
        }

        /* Skills Grid */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .skill-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Empty State Modern */
        .empty-state-modern {
            text-align: center;
            padding: 3rem 1rem;
            color: #64748b;
        }

        .empty-state-modern i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Links Grid */
        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .link-card {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
        }

        .link-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
        }

        .link-title {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .link-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #10b981;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .link-button:hover {
            color: #059669;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-poster {
                height: 250px;
            }

            .competition-content {
                height: auto;
                padding: 2rem 1.5rem !important;
            }

            .competition-title {
                font-size: 1.875rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .modern-btn {
                justify-content: center;
            }

            .timeline-modern {
                padding-left: 1.5rem;
            }

            .timeline-marker {
                left: -1.5rem;
            }

            .timeline-modern::before {
                left: 0.75rem;
            }

            .links-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .status-badges {
                justify-content: center;
            }

            .modern-badge {
                font-size: 0.75rem;
                padding: 0.375rem 0.75rem;
            }

            .card-header-modern {
                padding: 1rem 1rem 0;
            }

            .header-icon {
                width: 40px;
                height: 40px;
            }

            .header-title {
                font-size: 1.25rem;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        function selectCompetition(lombaId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin memilih lomba ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#102044',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check mr-1"></i>Ya, Pilih',
                cancelButtonText: '<i class="fas fa-times mr-1"></i>Batal',
                showClass: {
                    popup: 'animate__animated animate__fadeIn'
                }
            }).then((result) => {
                if (result.isConfirmed) {


                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('student.achievement.select-competition') }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const lombaInput = document.createElement('input');
                    lombaInput.type = 'hidden';
                    lombaInput.name = 'lomba_id';
                    lombaInput.value = lombaId;

                    form.appendChild(csrfToken);
                    form.appendChild(lombaInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endpush
