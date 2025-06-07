@extends('layouts.template')

@section('title', 'Detail Lomba | STARS')

@section('page-title', 'Detail Lomba')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.adminKelolaLomba.index') }}">Data Lomba</a></li>
@endsection

@section('content')
    <div class="card shadow-lg rounded-lg overflow-hidden">
        <div class="card-header position-relative p-4">
            <h3 class="card-title font-weight-bold mb-0 text-white">{{ $page->title ?? 'Detail Lomba' }}</h3>
            <div class="animated-bg"></div>
        </div>
        <div class="card-body p-4">
            @empty($lomba)
                <div class="alert alert-danger alert-dismissible fade show">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, lomba yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="user-detail-container">
                    <div class="row mb-4">
                        <div class="col-md-3 text-center">
                            <div class="user-avatar-container mb-3">
                                <div class="user-avatar" style="background: linear-gradient(135deg, #102044, #1a2a4d);">
                                    <i class="fas fa-trophy"></i>
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ $lomba->lomba_nama }}</h4>
                            <span class="badge badge-primary px-3 py-2">{{ $lomba->lomba_kategori }}</span>
                        </div>
                        <div class="col-md-9">
                            <div class="user-info-card">
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-hashtag text-primary"></i>
                                        <span>ID Lomba</span>
                                    </div>
                                    <div class="info-value">{{ $lomba->id }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-cogs text-info"></i>
                                        <span>Bidang Keahlian</span>
                                    </div>
                                    <div class="info-value">
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
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-layer-group text-warning"></i>
                                        <span>Tingkatan</span>
                                    </div>
                                    <div class="info-value">{{ $lomba->tingkatan->tingkatan_nama ?? '-' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-graduation-cap text-success"></i>
                                        <span>Semester</span>
                                    </div>
                                    <div class="info-value">{{ $lomba->semester->semester_nama ?? '-' }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building text-secondary"></i>
                                        <span>Penyelenggara</span>
                                    </div>
                                    <div class="info-value">{{ $lomba->lomba_penyelenggara }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-building text-secondary"></i>
                                        <span>Kategori</span>
                                    </div>
                                    <div class="info-value">{{ $lomba->lomba_kategori }}</div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt text-success"></i>
                                        <span>Tanggal Mulai</span>
                                    </div>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse($lomba->lomba_tanggal_mulai)->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-check text-success"></i>
                                        <span>Tanggal Selesai</span>
                                    </div>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse($lomba->lomba_tanggal_selesai)->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-link text-info"></i>
                                        <span>Link Pendaftaran</span>
                                    </div>
                                    <div class="info-value">
                                        <a href="#" class="show-link-modal" data-title="Link Pendaftaran"
                                            data-url="{{ $lomba->lomba_link_pendaftaran }}">
                                            {{ $lomba->lomba_link_pendaftaran }}
                                        </a>
                                    </div>
                                </div>
                                <div class="user-info-item">
                                    <div class="info-label">
                                        <i class="fas fa-image text-warning"></i>
                                        <span>Link Poster</span>
                                    </div>
                                    <div class="info-value">
                                        <a href="#" class="show-link-modal" data-title="Link Poster"
                                            data-url="{{ $lomba->lomba_link_poster }}">
                                            {{ $lomba->lomba_link_poster }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty

            <hr class="my-4">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.adminKelolaLomba.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                @if(!empty($lomba))
                    <div>
                        <button onclick="modalAction('{{ route('admin.adminKelolaLomba.editAjax', $lomba->id) }}')"
                            class="btn btn-warning px-4 mr-2">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </button>
                        <button onclick="modalAction('{{ route('admin.adminKelolaLomba.confirmAjax', $lomba->id) }}')"
                            class="btn btn-danger px-4">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>
    <div class="modal fade" id="linkModal" tabindex="-1" role="dialog" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="linkModalLabel">Link</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="linkModalBody">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        $(document).ready(function () {
            $('.user-detail-container').css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });

            setTimeout(function () {
                $('.user-detail-container').css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.6s ease-out'
                });
            }, 200);
            // Modal untuk link pendaftaran/poster
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
@endpush