<div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <div class="modal-header bg-info">
            <h5 class="modal-title text-white font-weight-bold">
                <i class="fas fa-users mr-2"></i> Daftar Mahasiswa dengan Bidang Keahlian {{ $keahlian->keahlian_nama ?? '' }}
            </h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body p-4">
            @if(isset($errorMessage))
                <div class="alert alert-danger">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Error</h5>
                            <p class="mb-0">{{ $errorMessage }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Tabs for different mahasiswa lists -->
                <ul class="nav nav-tabs mb-4" id="keahlianTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="primary-tab" data-toggle="tab" href="#primary" role="tab" 
                           aria-controls="primary" aria-selected="true">
                            <i class="fas fa-star mr-1"></i> Keahlian Utama
                            <span class="badge badge-primary ml-1">{{ count($mahasiswas) }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" 
                           aria-controls="additional" aria-selected="false">
                            <i class="fas fa-plus-circle mr-1"></i> Semua Mahasiswa
                            <span class="badge badge-info ml-1">{{ count($allMahasiswas) }}</span>
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content" id="keahlianTabsContent">
                    <!-- Primary skill tab -->
                    <div class="tab-pane fade show active" id="primary" role="tabpanel" aria-labelledby="primary-tab">
                        @if(count($mahasiswas) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" width="5%">No</th>
                                            <th width="15%">NIM</th>
                                            <th width="25%">Nama Mahasiswa</th>
                                            <th width="20%">Program Studi</th>
                                            <th width="15%">Status</th>
                                            <th width="10%">Angkatan</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mahasiswas as $index => $mahasiswa)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $mahasiswa->mahasiswa_nim }}</td>
                                                <td>{{ $mahasiswa->mahasiswa_nama }}</td>
                                                <td>{{ $mahasiswa->prodi->prodi_nama ?? 'N/A' }}</td>
                                                <td>
                                                    @if($mahasiswa->mahasiswa_status == 'Aktif')
                                                        <span class="badge badge-success">Aktif</span>
                                                    @elseif($mahasiswa->mahasiswa_status == 'Cuti')
                                                        <span class="badge badge-warning">Cuti</span>
                                                    @else
                                                        <span class="badge badge-danger">Tidak Aktif</span>
                                                    @endif
                                                </td>
                                                <td>{{ $mahasiswa->mahasiswa_angkatan }}</td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i> Tidak ada mahasiswa dengan keahlian utama ini
                            </div>
                        @endif
                    </div>
                    
                    <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                        @if(count($allMahasiswas) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="15%">NIM</th>
                                            <th width="20%">Nama Mahasiswa</th>
                                            <th width="20%">Program Studi</th>
                                            <th width="25%">Sertifikat</th>
                                            <th width="10%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allMahasiswas as $index => $mhs)
                                            <tr>
                                                <td>{{ $mhs->mahasiswa_nim }}</td>
                                                <td>{{ $mhs->mahasiswa_nama }}</td>
                                                <td>{{ $mhs->prodi_nama }}</td>
                                                <td>
                                                    @if($mhs->keahlian_sertifikat)
                                                        <button class="btn btn-sm btn-outline-primary view-certificate" 
                                                                data-sertifikat="{{ $mhs->keahlian_sertifikat }}">
                                                            <i class="fas fa-certificate mr-1"></i> Lihat Sertifikat
                                                        </button>
                                                    @else
                                                        <span class="text-muted"><i>Tidak ada sertifikat</i></span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle mr-2"></i> Tidak ada mahasiswa dengan keahlian tambahan ini
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                <i class="fas fa-times mr-2"></i> Tutup
            </button>
            
            
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
       
        $('.table-responsive').css({
            'opacity': 0,
            'transform': 'translateY(20px)'
        });
        
        setTimeout(function() {
            $('.table-responsive').css({
                'opacity': 1,
                'transform': 'translateY(0)',
                'transition': 'all 0.5s ease-out'
            });
        }, 300);
        
        $('.view-certificate').on('click', function() {
            const sertifikat = $(this).data('sertifikat');
            Swal.fire({
                title: 'Sertifikat Keahlian',
                html: `<img src="${sertifikat}" alt="Sertifikat" class="img-fluid">`,
                width: 800,
                showCloseButton: true,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#3085d6'
            });
        });
    });
</script>