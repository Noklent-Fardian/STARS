@extends('layouts.template')

@section('title', 'Detail Verifikasi Lomba | STARS')

@section('page-title', 'Detail Verifikasi Lomba')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.lombaVerification.index') }}">Verifikasi Lomba</a>
    </li>
@endsection

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">Detail Verifikasi Lomba</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @empty($submission)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, submission lomba yang Anda cari tidak ada dalam database</p>
                        </div>
                    </div>
                </div>
            @else
                    @php
                        $isDataComplete =
                            !empty($submission->lomba_nama) &&
                            !empty($submission->lomba_penyelenggara) &&
                            !empty($submission->lomba_kategori) &&
                            !empty($submission->lomba_tanggal_mulai) &&
                            !empty($submission->lomba_tanggal_selesai) &&
                            !empty($submission->tingkatan);
                    @endphp

                    <div class="lomba-detail-container">
                        <!-- Status Badge -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="status-section text-center p-4 rounded">
                                    <div class="trophy-icon mb-3">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    @if ($submission->pendaftaran_status == 'Menunggu')
                                        <span class="badge badge-warning badge-lg">
                                            <i class="fas fa-clock mr-2"></i> Menunggu Verifikasi
                                        </span>
                                    @elseif($submission->pendaftaran_status == 'Diterima')
                                        <span class="badge badge-success badge-lg">
                                            <i class="fas fa-check mr-2"></i> Diterima
                                        </span>
                                    @else
                                        <span class="badge badge-danger badge-lg">
                                            <i class="fas fa-times mr-2"></i> Ditolak
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Warning for Incomplete Data -->
                        @if (!$isDataComplete && $submission->pendaftaran_status == 'Menunggu')
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                                            <div>
                                                <h5 class="mb-1">Data Tidak Lengkap</h5>
                                                <p class="mb-0">Tidak dapat melakukan verifikasi karena ada data yang belum
                                                    lengkap</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Informasi Penginput --><!-- Informasi Penginput -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="info-card">
                                    <div class="info-card-header">
                                        @if ($submission->dosen)
                                            <i class="fas fa-user-tie text-white"></i>
                                        @else
                                            <i class="fas fa-user-graduate text-white"></i>
                                        @endif
                                        <h6 class="mb-0">Informasi Penginput</h6>
                                    </div>
                                    <div class="info-card-body">
                                        <div class="row">
                                            @if ($submission->dosen)
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <label>Nama Dosen</label>
                                                        <span>{{ $submission->dosen->dosen_nama ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <label>NIP</label>
                                                        <span>{{ $submission->dosen->dosen_nip ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <label>Role</label>
                                                        <span><i class="fas fa-user-tie mr-1"></i>Dosen</span>
                                                    </div>
                                                </div>
                                            @elseif($submission->mahasiswa)
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <label>Nama Mahasiswa</label>
                                                        <span>{{ $submission->mahasiswa->mahasiswa_nama ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <label>NIM</label>
                                                        <span>{{ $submission->mahasiswa->mahasiswa_nim ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="info-item">
                                                        <label>Role</label>
                                                        <span><i class="fas fa-user-graduate mr-1"></i>Mahasiswa</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-12">
                                                    <div class="info-item">
                                                        <label>Status</label>
                                                        <span class="text-warning">Data penginput tidak tersedia</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail Lomba -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="info-card">
                                    <div class="info-card-header">
                                        <i class="fas fa-trophy text-warning"></i>
                                        <h6 class="mb-0">Detail Lomba</h6>
                                    </div>
                                    <div class="info-card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <label>Nama Lomba:</label>
                                                    <span
                                                        class="font-weight-bold">{{ $submission->lomba_nama ?: 'Belum diisi' }}</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Penyelenggara:</label>
                                                    <span>{{ $submission->lomba_penyelenggara ?: 'Belum diisi' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <label>Kategori:</label>
                                                    <span>{{ $submission->lomba_kategori ?: 'Belum diisi' }}</span>
                                                </div>
                                                <div class="info-item">
                                                    <label>Tingkatan:</label>
                                                    <span>{{ $submission->tingkatan->tingkatan_nama ?? 'Belum diisi' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date and Time Info -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="info-card-header">
                                    <i class="fas fa-clock text-danger"></i>
                                    <h6 class="mb-0">Waktu Pelaksanaan Lomba</h6>
                                </div>
                                <div class="card-body p-4">
                                    <div class="timeline-modern">
                                        <div class="timeline-item-modern">
                                            <div class="timeline-marker start"></div>
                                            <div class="timeline-content-modern">
                                                <h6 class="timeline-title">Tanggal Mulai Pendaftaran</h6>
                                                <p class="timeline-date">
                                                    {{ \Carbon\Carbon::parse($submission->lomba_tanggal_mulai)->locale('id')->translatedFormat('l, d F Y') }}
                                                </p>
                                                <small
                                                    class="timeline-relative">{{ $submission->lomba_tanggal_mulai->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <div class="timeline-item-modern">
                                            <div class="timeline-marker end"></div>
                                            <div class="timeline-content-modern">
                                                <h6 class="timeline-title">Tanggal Selesai</h6>
                                                <p class="timeline-date">
                                                    {{ \Carbon\Carbon::parse($submission->lomba_tanggal_selesai)->locale('id')->translatedFormat('l, d F Y') }}
                                                </p>
                                                <small
                                                    class="timeline-relative">{{ $submission->lomba_tanggal_selesai->diffForHumans() }}</small>
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
                                                {{ $submission->lomba_tanggal_mulai->diffInDays($submission->lomba_tanggal_selesai) + 1 }}
                                                hari
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keahlian -->
                    @if ($keahlians->count() > 0)
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="info-card">
                                    <div class="info-card-header">
                                        <i class="fas fa-cogs text-info"></i>
                                        <h6 class="mb-0">Keahlian Terkait</h6>
                                    </div>
                                    <div class="info-card-body">
                                        <div class="keahlian-tags">
                                            @foreach ($keahlians as $keahlian)
                                                <span class="badge badge-outline-primary mr-2 mb-2">{{ $keahlian->keahlian_nama }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Link Terkait -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="info-card">
                                <div class="info-card-header">
                                    <i class="fas fa-link text-success"></i>
                                    <h6 class="mb-0">Link Terkait</h6>
                                </div>
                                <div class="info-card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label>Link Pendaftaran:</label>
                                                @if ($submission->lomba_link_pendaftaran)
                                                    <a href="#" class="btn btn-sm btn-outline-primary show-link-modal"
                                                        data-title="Link Pendaftaran"
                                                        data-url="{{ $submission->lomba_link_pendaftaran }}">
                                                        <i class="fas fa-external-link-alt mr-1"></i> Buka Link
                                                    </a>
                                                @else
                                                    <span class="text-muted">Tidak ada</span>
                                                @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <label>Link Poster:</label>
                                                    @if ($submission->lomba_link_poster)
                                                        <a href="#" class="btn btn-sm btn-outline-success show-link-modal"
                                                            data-title="Link Poster" data-url="{{ $submission->lomba_link_poster }}">
                                                            <i class="fas fa-image mr-1"></i> Lihat Poster
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Tidak ada</span>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal untuk Link Pendaftaran/Poster -->
                            <div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="linkModalLabel">Link</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="linkModalBody">
                                            <!-- preview will be loaded here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons untuk Verifikasi -->
                            @if ($submission->pendaftaran_status == 'Menunggu' && $isDataComplete)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="verification-actions">
                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                <strong>Perhatian:</strong> Silakan periksa semua informasi lomba di atas dengan teliti
                                                sebelum melakukan verifikasi
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button class="btn btn-success btn-lg mr-3" onclick="showApproveModal()">
                                                    <i class="fas fa-check mr-2"></i> Setujui Lomba
                                                </button>
                                                <button class="btn btn-danger btn-lg" onclick="showRejectModal()">
                                                    <i class="fas fa-times mr-2"></i> Tolak Lomba
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <!-- Action Buttons -->
                            <hr class="my-4">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.lombaVerification.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

        <!-- Approval Modal -->
        <div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-check mr-2"></i>Konfirmasi Persetujuan
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                            <h5>Apakah Anda yakin ingin menyetujui lomba ini?</h5>
                            <p class="text-muted">Lomba yang disetujui akan aktif</p>
                        </div>
                        <div class="lomba-summary">
                            <strong>{{ $submission->lomba_nama ?? '' }}</strong><br>
                            <small class="text-muted">{{ $submission->lomba_penyelenggara ?? '' }}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <form method="POST" action="{{ route('admin.lombaVerification.approve', $submission->id ?? 0) }}"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check mr-1"></i> Ya, Setujui
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rejection Modal -->
        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-times mr-2"></i>Konfirmasi Penolakan
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <i class="fas fa-times-circle text-danger fa-4x mb-3"></i>
                            <h5>Apakah Anda yakin ingin menolak lomba ini?</h5>
                            <p class="text-muted">Lomba yang ditolak tidak akan ditampilkan dalam sistem</p>
                        </div>
                        <div class="lomba-summary mb-3">
                            <strong>{{ $submission->lomba_nama ?? '' }}</strong><br>
                            <small class="text-muted">{{ $submission->lomba_penyelenggara ?? '' }}</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <form method="POST" action="{{ route('admin.lombaVerification.reject', $submission->id ?? 0) }}"
                            style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times mr-1"></i> Ya, Tolak
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection

    @push('js')
        <script>
            function showApproveModal() {
                $('#approveModal').modal('show');
            }

            function showRejectModal() {
                $('#rejectModal').modal('show');
            }

            $(document).ready(function () {
                // Add animation to elements when page loads
                $('.lomba-detail-container').css({
                    'opacity': 0,
                    'transform': 'translateY(20px)'
                });

                setTimeout(function () {
                    $('.lomba-detail-container').css({
                        'opacity': 1,
                        'transform': 'translateY(0)',
                        'transition': 'all 0.6s ease-out'
                    });
                }, 200);

                // Modal preview untuk link pendaftaran/poster
                $('.show-link-modal').on('click', function (e) {
                    e.preventDefault();
                    var title = $(this).data('title');
                    var url = $(this).data('url');
                    $('#linkModalLabel').text(title);

                    let bodyHtml = '';
                    if (/.(jpg|jpeg|png|gif|webp)$/i.test(url)) {
                        bodyHtml = `<div class="text-center"><img src="${url}" alt="Poster" style="max-width:100%;max-height:500px"></div>`;
                    } else if (/\.pdf(\?|$)/i.test(url) || /drive\.google\.com/i.test(url)) {
                        let embedUrl = url;
                        if (/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/.test(url)) {
                            // Format: https://drive.google.com/file/d/FILE_ID/view?usp=sharing
                            let fileId = url.match(/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/)[1];
                            embedUrl = `https://drive.google.com/file/d/${fileId}/preview`;
                        }
                        bodyHtml = `<iframe src="${embedUrl}" style="width:100%;height:500px;" frameborder="0" allowfullscreen></iframe>
                        <div class="mt-2"><a href="${url}" target="_blank">${url}</a></div>`;
                    } else if (/^(http|https):\/\//.test(url)) {
                        bodyHtml = `<iframe src="${url}" style="width:100%;height:500px;border:none"></iframe>
                        <div class="mt-2"><a href="${url}" target="_blank">${url}</a></div>`;
                    } else {
                        bodyHtml = `<div><a href="${url}" target="_blank">${url}</a></div>`;
                    }

                    $('#linkModalBody').html(bodyHtml);
                    $('#linkModal').modal('show');
                });
            });
        </script>
    @endpush

    @push('css')
        <link rel="stylesheet" href="{{ asset('css/show.css') }}">
        <style>
            .info-card {
                border: 1px solid #e3e6f0;
                border-radius: 0.5rem;
                margin-bottom: 1rem;
                background: #fff;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            }

            .info-card-header {
                background: linear-gradient(-45deg, #102044, #1a2a4d, #293c5d, #1a2a4d);
                color: white;
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #e3e6f0;
                border-radius: 0.5rem 0.5rem 0 0;
                display: flex;
                align-items: center;
            }

            .info-card-header i {
                margin-right: 0.5rem;
            }

            .info-card-body {
                padding: 1rem;
            }

            .info-item {
                margin-bottom: 0.75rem;
            }

            .info-item:last-child {
                margin-bottom: 0;
            }

            .info-item label {
                font-weight: 600;
                color: #5a5c69;
                display: block;
                margin-bottom: 0.25rem;
                font-size: 0.9rem;
            }

            .info-item span {
                display: block;
                color: #3a3b45;
            }

            .status-section {
                background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
                border: 1px solid #e3e6f0;
            }

            .badge-lg {
                font-size: 1rem;
                padding: 0.75rem 1.25rem;
            }

            .verification-actions {
                text-align: center;
                padding: 2rem;
                background: #f8f9fc;
                border-radius: 0.5rem;
                border: 1px solid #e3e6f0;
            }

            .keahlian-tags {
                display: flex;
                flex-wrap: wrap;
            }

            .badge-outline-primary {
                color: #4e73df;
                border: 1px solid #4e73df;
                background: transparent;
            }

            .lomba-summary {
                padding: 1rem;
                background: #f8f9fc;
                border-radius: 0.5rem;
                border: 1px solid #e3e6f0;
            }

            .animated-bg {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(-45deg, #102044, #1a2a4d, #293c5d, #1a2a4d);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
                z-index: -1;
            }

            @keyframes gradient {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }

            /* Trophy Icon Styling */
            .trophy-icon {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: linear-gradient(135deg, #102044, #1a2a4d);
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                box-shadow: 0 6px 20px rgba(16, 32, 68, 0.4);
                animation: floatTrophy 3s ease-in-out infinite;
            }

            .trophy-icon i {
                font-size: 2.5rem;
                color: #fff;
            }

            @keyframes floatTrophy {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-8px);
                }
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

            .modern-card {
                border: 1px solid #e3e6f0;
                border-radius: 0.5rem;
                background: #fff;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            }

            .card-header-modern {
                background: linear-gradient(-45deg, #102044, #1a2a4d, #293c5d, #1a2a4d);
                color: white;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem 0.5rem 0 0;
            }

            .header-title {
                margin-bottom: 0;
                font-weight: 600;
            }

            .duration-card {
                margin-top: 1.5rem;
                padding: 1rem;
                background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
                border-radius: 0.5rem;
                display: flex;
                align-items: center;
            }

            .duration-icon {
                margin-right: 1rem;
                font-size: 1.5rem;
                color: #667eea;
            }

            .duration-label {
                font-weight: 600;
                margin-bottom: 0.25rem;
            }

            .duration-value {
                margin-bottom: 0;
                font-size: 1.1rem;
                color: #3a3b45;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .timeline-modern {
                    padding-left: 1.5rem;
                }

                .timeline-marker {
                    left: -1.5rem;
                }

                .duration-card {
                    flex-direction: column;
                    text-align: center;
                }

                .duration-icon {
                    margin-right: 0;
                    margin-bottom: 0.5rem;
                }

                .trophy-icon {
                    width: 80px;
                    height: 80px;
                }

                .trophy-icon i {
                    font-size: 2rem;
                }
            }
        </style>
    @endpush