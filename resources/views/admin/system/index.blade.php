@extends('layouts.template')

@section('title', 'Pengaturan Sistem | STARS')

@section('page-title', 'Pengaturan Sistem')

@section('breadcrumb')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
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
            
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">Pengaturan Sistem</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4 mb-md-0">
                            <div class="nav flex-column nav-pills settings-tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link {{ !session('tab') || session('tab') == 'pdf' ? 'active' : '' }}" id="v-pills-pdf-tab" data-toggle="pill" href="#v-pills-pdf" role="tab" aria-controls="v-pills-pdf" aria-selected="true">
                                    <i class="fas fa-file-pdf mr-2"></i> Pengaturan Kop Surat PDF
                                </a>
                                <a class="nav-link {{ session('tab') == 'banner' ? 'active' : '' }}" id="v-pills-banner-tab" data-toggle="pill" href="#v-pills-banner" role="tab" aria-controls="v-pills-banner" aria-selected="false">
                                    <i class="fas fa-image mr-2"></i> Pengaturan Banner
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!-- PDF Settings Tab -->
                                <div class="tab-pane fade {{ !session('tab') || session('tab') == 'pdf' ? 'show active' : '' }}" id="v-pills-pdf" role="tabpanel" aria-labelledby="v-pills-pdf-tab">
                                    <h5 class="border-bottom pb-2 mb-4">
                                        <i class="fas fa-file-pdf text-accent mr-2"></i> 
                                        Pengaturan Kop Surat PDF
                                    </h5>
                                    
                                    <form action="{{ route('admin.system.updatePdfSettings') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_instansi1">Instansi Baris 1</label>
                                                    <input type="text" class="form-control" id="pdf_instansi1" name="pdf_instansi1" 
                                                        value="{{ old('pdf_instansi1', $pdfSetting->pdf_instansi1) }}">
                                                    @error('pdf_instansi1')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_instansi2">Instansi Baris 2</label>
                                                    <input type="text" class="form-control" id="pdf_instansi2" name="pdf_instansi2" 
                                                        value="{{ old('pdf_instansi2', $pdfSetting->pdf_instansi2) }}">
                                                    @error('pdf_instansi2')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="pdf_alamat">Alamat</label>
                                            <textarea class="form-control" id="pdf_alamat" name="pdf_alamat" rows="2">{{ old('pdf_alamat', $pdfSetting->pdf_alamat) }}</textarea>
                                            @error('pdf_alamat')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_telepon">Telepon</label>
                                                    <input type="text" class="form-control" id="pdf_telepon" name="pdf_telepon" 
                                                        value="{{ old('pdf_telepon', $pdfSetting->pdf_telepon) }}">
                                                    @error('pdf_telepon')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_fax">Fax</label>
                                                    <input type="text" class="form-control" id="pdf_fax" name="pdf_fax" 
                                                        value="{{ old('pdf_fax', $pdfSetting->pdf_fax) }}">
                                                    @error('pdf_fax')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_pes">Pes</label>
                                                    <input type="text" class="form-control" id="pdf_pes" name="pdf_pes" 
                                                        value="{{ old('pdf_pes', $pdfSetting->pdf_pes) }}">
                                                    @error('pdf_pes')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_website">Website</label>
                                                    <input type="text" class="form-control" id="pdf_website" name="pdf_website" 
                                                        value="{{ old('pdf_website', $pdfSetting->pdf_website) }}">
                                                    @error('pdf_website')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_logo_kiri">Logo Kiri (Max: 100KB)</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="pdf_logo_kiri" name="pdf_logo_kiri">
                                                        <label class="custom-file-label" for="pdf_logo_kiri">Pilih file...</label>
                                                    </div>
                                                    @error('pdf_logo_kiri')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    @if($pdfSetting->pdf_logo_kiri)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kiri) }}" alt="Logo Kiri" height="50">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pdf_logo_kanan">Logo Kanan (Max: 100KB)</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="pdf_logo_kanan" name="pdf_logo_kanan">
                                                        <label class="custom-file-label" for="pdf_logo_kanan">Pilih file...</label>
                                                    </div>
                                                    @error('pdf_logo_kanan')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                    @if($pdfSetting->pdf_logo_kanan)
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kanan) }}" alt="Logo Kanan" height="50">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="pdf-preview mt-4 mb-4">
                                            <h6>Pratinjau Kop Surat:</h6>
                                            <div class="pdf-preview-container border p-3">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td width="15%" class="text-center">
                                                            @if($pdfSetting->pdf_logo_kiri)
                                                                <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kiri) }}" alt="Logo Kiri" style="height: 70px;">
                                                            @else
                                                                <img src="{{ asset('img/poltek100.png') }}" alt="Logo Default" style="height: 70px;">
                                                            @endif
                                                        </td>
                                                        <td width="70%" class="text-center">
                                                            <div style="font-size: 16px; font-weight: bold;">{{ $pdfSetting->pdf_instansi1 ?: 'STARS - Student Achievement Record System' }}</div>
                                                            <div style="font-size: 14px; font-weight: bold;">{{ $pdfSetting->pdf_instansi2 ?: 'POLITEKNIK NEGERI MALANG' }}</div>
                                                            <div style="font-size: 12px;">{{ $pdfSetting->pdf_alamat ?: 'Jl. Soekarno-Hatta No. 9 Malang 65141' }}</div>
                                                            <div style="font-size: 12px;">{{ 'Telepon ' . ($pdfSetting->pdf_telepon ?: '(0341) 404424') . 
                                                                ($pdfSetting->pdf_pes ? ' Pes. ' . $pdfSetting->pdf_pes : '') . 
                                                                ($pdfSetting->pdf_fax ? ', Fax. ' . $pdfSetting->pdf_fax : '') }}</div>
                                                            <div style="font-size: 12px;">{{ 'Laman: ' . ($pdfSetting->pdf_website ?: 'www.polinema.ac.id') }}</div>
                                                        </td>
                                                        <td width="15%" class="text-center">
                                                            @if($pdfSetting->pdf_logo_kanan)
                                                                <img src="{{ asset('storage/' . $pdfSetting->pdf_logo_kanan) }}" alt="Logo Kanan" style="height: 70px;">
                                                            @else
                                                                <img src="{{ asset('img/logo100.png') }}" alt="Logo Default" style="height: 70px;">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i> Simpan Pengaturan
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Banner Settings Tab -->
                                <div class="tab-pane fade {{ session('tab') == 'banner' ? 'show active' : '' }}" id="v-pills-banner" role="tabpanel" aria-labelledby="v-pills-banner-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="mb-0">
                                            <i class="fas fa-image text-accent mr-2"></i> 
                                            Pengaturan Banner
                                        </h5>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="20%">Nama</th>
                                                    <th width="25%">Link</th>
                                                    <th width="30%">Gambar</th>
                                                    <th width="20%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($banners as $index => $banner)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $banner->banner_nama }}</td>
                                                        <td>
                                                            <a href="{{ $banner->banner_link }}" target="_blank">
                                                                {{ $banner->banner_link }}
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($banner->banner_gambar)
                                                                <img src="{{ asset('storage/' . $banner->banner_gambar) }}" 
                                                                    alt="{{ $banner->banner_nama }}" class="img-thumbnail" 
                                                                    style="max-height: 100px;">
                                                            @else
                                                                <span class="badge badge-secondary">No Image</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-warning btn-sm" 
                                                                onclick="openModal('{{ route('admin.system.editBannerModal', $banner->id) }}')">
                                                                <i class="fas fa-edit mr-1"></i> Edit
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada data banner</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Banner Modal -->
    <div class="modal fade" id="addBannerModal" tabindex="-1" role="dialog" aria-labelledby="addBannerModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBannerModalLabel">Tambah Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.system.storeBanner') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="banner_nama">Nama Banner</label>
                            <input type="text" class="form-control" id="banner_nama" name="banner_nama" required>
                        </div>
                        <div class="form-group">
                            <label for="banner_link">Link</label>
                            <input type="text" class="form-control" id="banner_link" name="banner_link" required>
                        </div>
                        <div class="form-group">
                            <label for="banner_gambar">Gambar Banner</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="banner_gambar" name="banner_gambar" required accept="image/*">
                                <label class="custom-file-label" for="banner_gambar">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Format: JPG, PNG. Max: 2MB.</small>
                            <div class="mt-2">
                                <img id="preview-image" src="#" alt="Preview" style="max-height: 150px; display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('css')
    <style>
        .settings-tabs {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        
        .settings-tabs .nav-link {
            color: var(--heading-color);
            padding: 12px 20px;
            transition: all 0.3s ease;
            border-radius: 0;
            border-left: 3px solid transparent;
        }
        
        .settings-tabs .nav-link.active {
            background: linear-gradient(to right, rgba(var(--primary-color-rgb), 0.1), rgba(var(--primary-color-rgb), 0.05), transparent);
            color: var(--primary-color);
            font-weight: 600;
            border-left: 3px solid var(--primary-color);
        }
        
        .settings-tabs .nav-link:hover:not(.active) {
            background-color: rgba(0,0,0,0.02);
        }
        
        .pdf-preview-container {
            background-color: #fff;
            border-radius: 5px;
        }
        
        @media (max-width: 767px) {
            .settings-tabs {
                display: flex;
                overflow-x: auto;
                white-space: nowrap;
                margin-bottom: 20px;
            }
            
            .settings-tabs .nav-link {
                border-left: none;
                border-bottom: 3px solid transparent;
            }
            
            .settings-tabs .nav-link.active {
                border-left: none;
                border-bottom: 3px solid var(--primary-color);
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init();
            
            $('#banner_gambar').change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $('#preview-image').attr('src', event.target.result);
                        $('#preview-image').css('display', 'block');
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            @if ($errors->any() && old('banner_nama'))
                $('#addBannerModal').modal('show');
            @endif
        });
        
        function openModal(url) {
            $('#genericModal').load(url, function() {
                $('#genericModal').modal('show');
                setTimeout(function() {
                    if(typeof bsCustomFileInput !== 'undefined') {
                        bsCustomFileInput.init();
                    }
                }, 500);
            });
        }
    </script>
@endpush