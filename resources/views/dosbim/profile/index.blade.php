@extends('layouts.template')

@section('title', 'Profil Dosen | STARS')

@section('page-title', 'Profil Dosen')

@section('breadcrumb')
    <!-- Tidak perlu breadcrumb tambahan -->
@endsection

@section('content')
    <div class="container py-4">
        <div class="row">
            {{-- Sidebar Profile --}}
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 profile-sidebar"
                    style="background: linear-gradient(135deg, #f8fafc 60%, #e7f1ff 100%);">
                    <div class="card-body d-flex flex-column align-items-center text-center">
                        <div class="mb-3 profile-image-container position-relative">
                            <img src="{{ $dosen->dosen_photo ? asset('storage/' . $dosen->dosen_photo) : asset('imgs/profile_placeholder.jpg') }}"
                                alt="Profil" class="shadow">
                        </div>
                        <h4 class="fw-bold mb-1 text-primary">
                            {{ $dosen->dosen_nama }}
                        </h4>
                        <ul class="list-unstyled w-100 mt-3 mb-2">
                            <li class="mb-2 text-muted text-center">
                                NIP: {{ $dosen->dosen_nip }}
                            </li>
                            <li class="mb-2 fw-semibold text-center">
                                {{ $dosen->prodi->prodi_nama ?? '-' }}
                            </li>

                            <li>
                                <hr class="my-2">
                            </li>
                            <li class="mb-2 text-center">
                                Status:
                                <span
                                    class="badge rounded-pill px-3 py-2 ms-2 {{ $dosen->dosen_visible ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $dosen->dosen_visible ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </li>
                        </ul>
                        <a href="{{ route('dosen.editProfile') }}" class="btn btn-outline-primary w-100 mt-3">
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>
            <!-- Main Profile Content -->
            <div class="col-md-8">
                <!-- Informasi Pribadi -->
                <div class="card mb-4 card-gradient">
                    <div class="card-header fw-bold">Informasi Pribadi</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">Nama</div>
                            <div class="col-sm-8">{{ $dosen->dosen_nama }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">NIP</div>
                            <div class="col-sm-8">{{ $dosen->dosen_nip }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">No. Telepon</div>
                            <div class="col-sm-8">{{ $dosen->dosen_nomor_telepon }}</div>
                        </div>
                    </div>
                </div>
                <!-- Informasi Akademik -->
                <div class="card mb-4 card-gradient">
                    <div class="card-header fw-bold">Informasi Akademik</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">Program Studi</div>
                            <div class="col-sm-8">{{ $dosen->prodi->prodi_nama ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Keahlian Utama</div>
                            <div class="col-sm-8">
                                @if ($dosen->keahlianUtama)
                                    <span
                                        class="badge keahlian-badge mb-1">{{ $dosen->keahlianUtama->keahlian_nama }}</span>
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Bidang Minat Penelitian</div>
                            <div class="col-sm-8">
                                @if ($dosen->keahlianTambahan->count())
                                    @foreach ($dosen->keahlianTambahan as $keahlian)
                                        <span class="badge keahlian-badge mb-1">{{ $keahlian->keahlian_nama }}</span>
                                    @endforeach
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alamat / Domisili -->
                <div class="card mb-4 card-gradient">
                    <div class="card-header fw-bold">Alamat / Domisili</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">Provinsi</div>
                            <div class="col-sm-8">{{ $dosen->dosen_provinsi }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Kota</div>
                            <div class="col-sm-8">{{ $dosen->dosen_kota }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Kecamatan</div>
                            <div class="col-sm-8">{{ $dosen->dosen_kecamatan }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Desa</div>
                            <div class="col-sm-8">{{ $dosen->dosen_desa }}</div>
                        </div>
                    </div>
                </div>
                <!-- Lain-lain -->
                <div class="card mb-4" style="background: linear-gradient(135deg, #f8fafc 60%, #e7f1ff 100%);">
                    <div class="card-header fw-bold">Lain-lain</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">Username</div>
                            <div class="col-sm-8">{{ Auth::user()->username }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Foto Profil</div>
                            <div class="col-sm-8">
                                @if ($dosen->dosen_photo)
                                    <img src="{{ $dosen->dosen_photo ? asset('storage/' . $dosen->dosen_photo) : asset('imgs/profile_placeholder.jpg') }}"
                                        alt="Foto Profil" class="rounded"
                                        style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div id="profileImagePlaceholder" class="profile-placeholder" class="rounded"
                                        style="width: 60px; height: 60px; object-fit: cover;"> <i class="fas fa-user"
                                            style="color: #6b7280; font-size: 24px;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Keahlian Sertifikat</div>
                            <div class="col-sm-8">
                                {{-- Sertifikat Keahlian Utama --}}
                                <div class="mb-2">
                                    <span class="badge keahlian-badge">
                                        {{ $dosen->keahlianUtama->keahlian_nama ?? '-' }}
                                    </span>
                                    @if (!empty($dosen->keahlian_sertifikat))
                                        <a href="{{ $dosen->keahlian_sertifikat }}" target="_blank"
                                            class="ms-2 text-primary" title="Lihat Sertifikat Keahlian Utama">
                                            <i class="bi bi-link-45deg"></i> Sertifikat Utama
                                        </a>
                                    @else
                                        <span class="text-muted ms-2">-</span>
                                    @endif
                                </div>
                                {{-- Sertifikat Keahlian Tambahan --}}
                                @if ($dosen->keahlianTambahan->count())
                                    @foreach ($dosen->keahlianTambahan as $keahlian)
                                        @php $pivot = $keahlian->pivot ?? null; @endphp
                                        <div class="mb-1">
                                            <span class="badge keahlian-badge">{{ $keahlian->keahlian_nama }}</span>
                                            @if ($pivot && $pivot->keahlian_sertifikat)
                                                <a href="{{ $pivot->keahlian_sertifikat }}" target="_blank"
                                                    class="ms-2 text-primary" title="Lihat Sertifikat">
                                                    <i class="bi bi-link-45deg"></i> Sertifikat
                                                </a>
                                            @else
                                                <span class="text-muted ms-2">-</span>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <span>-</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Score Prestasi</div>
                            <div class="col-sm-8">{{ $dosen->dosen_score }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4">Status Aktif</div>
                            <div class="col-sm-8">
                                <span class="badge {{ $dosen->dosen_visible ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $dosen->dosen_visible ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection

        @push('css')
            <style>
                .profile-image-container {
                    width: 130px;
                    height: 130px;
                    margin: 0 auto;
                    position: relative;
                }

                .profile-image-container img {
                    display: block;
                    width: 130px;
                    height: 130px;
                    object-fit: cover;
                    border-radius: 50%;
                    border: 3px solid #0d6efd;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
                    transition: box-shadow 0.2s;
                }

                .profile-image-container img:hover {
                    box-shadow: 0 0 0 6px #0d6efd33;
                }

                .profile-sidebar:hover {
                    box-shadow: 0 4px 24px 0 rgba(13, 110, 253, 0.12);
                    transform: translateY(-2px) scale(1.01);
                    transition: all 0.2s;
                }

                .card-gradient {
                    background: linear-gradient(135deg, #f8fafc 60%, #e7f1ff 100%);
                }

                .keahlian-badge {
                    background: #e7f1ff !important;
                    color: #0d6efd !important;
                    font-size: 1.05em;
                    padding: 0.5em 1.2em;
                    border-radius: 1.5em;
                    margin-right: 0.3em;
                    margin-bottom: 0.3em;
                    font-weight: 500;
                    letter-spacing: 0.5px;
                    display: inline-block;
                    box-shadow: 0 1px 4px rgba(13, 110, 253, 0.08);
                }
            </style>
        @endpush
