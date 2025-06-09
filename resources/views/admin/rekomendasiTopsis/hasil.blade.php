@extends('layouts.template')

@section('title', 'Hasil Rekomendasi | STARS')

@section('page-title', 'Hasil Rekomendasi TOPSIS')

@section('breadcrumb')

@if (session('notifikasi'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('notifikasi') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('admin.rekomendasiTopsis.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

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

    <!-- Info Lomba -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Lomba</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Nama Lomba</strong></td>
                                    <td>: {{ $lomba->lomba_nama }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Penyelenggara</strong></td>
                                    <td>: {{ $lomba->lomba_penyelenggara }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td width="30%"><strong>Tanggal Mulai</strong></td>
                                    <td>: {{ \Carbon\Carbon::parse($lomba->lomba_tanggal_mulai)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Selesai</strong></td>
                                    <td>: {{ \Carbon\Carbon::parse($lomba->lomba_tanggal_selesai)->format('d M Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bobot Kriteria -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bobot Kriteria Yang Digunakan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-primary">{{ $bobots['score'] ?? 0.25 }}</div>
                                <div class="small text-muted">Skor Mahasiswa</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-success">{{ $bobots['keahlian_utama'] ?? 0.25 }}</div>
                                <div class="small text-muted">Keahlian Utama</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-info">{{ $bobots['keahlian_tambahan'] ?? 0.25 }}</div>
                                <div class="small text-muted">Keahlian Tambahan</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 text-warning">{{ $bobots['jumlah_lomba'] ?? 0.25 }}</div>
                                <div class="small text-muted">Pengalaman Lomba</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hasil Rekomendasi -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Hasil Rekomendasi Mahasiswa</h6>
                    <small class="text-muted">Total: {{ count($rekomendasi) }} mahasiswa</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center">Ranking</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>NIM</th>
                                    <th class="text-center">Skor Preferensi</th>
                                    <th class="text-center">Skor Mahasiswa</th>
                                    <th>Keahlian Utama</th>
                                    <th class="text-center">Keahlian Tambahan</th>
                                    <th class="text-center">Pengalaman Lomba</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekomendasi as $item)
                                    <tr class="{{ $item['ranking'] <= 3 ? 'table-success' : '' }}">
                                        <td class="text-center">
                                            <span class="badge badge-{{ $item['ranking'] == 1 ? 'warning' : ($item['ranking'] == 2 ? 'secondary' : ($item['ranking'] == 3 ? 'info' : 'light')) }}">
                                                #{{ $item['ranking'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $item['mahasiswa']->nama }}</strong>
                                            @if($item['ranking'] <= 3)
                                                <i class="fas fa-star text-warning ml-1"></i>
                                            @endif
                                        </td>
                                        <td>{{ $item['mahasiswa']->nim }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $item['skor_preferensi'] }}</span>
                                        </td>
                                        <td class="text-center">{{ $item['kriteria']['score'] ?? 0 }}</td>
                                        <td>
                                            {{ $item['mahasiswa']->keahlian_utama ?? 'Tidak ada' }}
                                            @if($item['kriteria']['keahlian_utama'])
                                                <i class="fas fa-check-circle text-success ml-1"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info">{{ $item['kriteria']['keahlian_tambahan'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-warning">{{ $item['kriteria']['jumlah_lomba'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" 
                                                    class="btn btn-success btn-sm btn-rekomendasi" 
                                                    data-mahasiswa-id="{{ $item['mahasiswa']->id }}"
                                                    data-mahasiswa-nama="{{ $item['mahasiswa']->nama }}"
                                                    data-mahasiswa-nim="{{ $item['mahasiswa']->nim }}"
                                                    data-lomba-id="{{ $lomba->id }}"
                                                    data-lomba-nama="{{ $lomba->lomba_nama }}"
                                                    title="Kirim Rekomendasi ke Mahasiswa">
                                                <i class="fas fa-paper-plane"></i> Rekomendasikan
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 text-center">
                        <button onclick="window.print()" class="btn btn-success mr-2">
                            <i class="fas fa-print"></i> Cetak Hasil
                        </button>
                        <button onclick="exportToExcel()" class="btn btn-info mr-2">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <a href="{{ route('admin.rekomendasiTopsis.index') }}" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Generate Ulang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Penjelasan Metode -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Penjelasan Hasil</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Interpretasi Skor Preferensi:</h6>
                            <ul class="text-muted">
                                <li><strong>0.8 - 1.0:</strong> Sangat Direkomendasikan</li>
                                <li><strong>0.6 - 0.7:</strong> Direkomendasikan</li>
                                <li><strong>0.4 - 0.5:</strong> Cukup Direkomendasikan</li>
                                <li><strong>0.0 - 0.3:</strong> Kurang Direkomendasikan</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Kriteria Penilaian:</h6>
                            <ul class="text-muted">
                                <li><strong>Skor Mahasiswa:</strong> Nilai prestasi akademik dan non-akademik</li>
                                <li><strong>Keahlian Utama:</strong> Bidang keahlian utama yang dikuasai</li>
                                <li><strong>Keahlian Tambahan:</strong> Jumlah keahlian tambahan</li>
                                <li><strong>Pengalaman Lomba:</strong> Total lomba yang pernah diikuti</li>
                            </ul>
                        </div>
                    </div>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Hasil rekomendasi ini dihitung menggunakan metode TOPSIS (Technique for Order Preference by Similarity to Ideal Solution) 
                        yang mempertimbangkan kedekatan alternatif dengan solusi ideal positif dan jarak dari solusi ideal negatif.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Rekomendasi -->
    <div class="modal fade" id="modalKonfirmasiRekomendasi" tabindex="-1" role="dialog" aria-labelledby="modalKonfirmasiRekomendasiLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKonfirmasiRekomendasiLabel">
                        <i class="fas fa-paper-plane text-success"></i> Konfirmasi Rekomendasi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fas fa-question-circle fa-3x text-warning mb-3"></i>
                        <h5>Apakah Anda yakin ingin mengirim rekomendasi?</h5>
                        <p class="text-muted">
                            Mahasiswa <strong id="modal-nama-mahasiswa"></strong> (<span id="modal-nim-mahasiswa"></span>) 
                            akan menerima notifikasi rekomendasi untuk mengikuti lomba <strong id="modal-nama-lomba"></strong>.
                        </p>
                        <p class="text-info">
                            <i class="fas fa-info-circle"></i> 
                            Mahasiswa akan menerima notifikasi beserta daftar mahasiswa lain yang juga direkomendasikan.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="button" class="btn btn-success" id="btn-konfirmasi-rekomendasi">
                        <i class="fas fa-paper-plane"></i> Ya, Kirim Rekomendasi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
// Data rekomendasi untuk JavaScript
const rekomendasiData = @json($rekomendasi);
const lombaData = @json($lomba);

// Debug: cek isi rekomendasiData
    console.log('rekomendasiData:', rekomendasiData);

// Event listener untuk button rekomendasi
$(document).on('click', '.btn-rekomendasi', function() {
    const mahasiswaId = $(this).data('mahasiswa-id');
    const mahasiswaNama = $(this).data('mahasiswa-nama');
    const mahasiswaNim = $(this).data('mahasiswa-nim');
    const lombaId = $(this).data('lomba-id');
    const lombaNama = $(this).data('lomba-nama');
    
    // Set data ke modal
    $('#modal-nama-mahasiswa').text(mahasiswaNama);
    $('#modal-nim-mahasiswa').text(mahasiswaNim);
    $('#modal-nama-lomba').text(lombaNama);
    
    // Set data untuk konfirmasi
    $('#btn-konfirmasi-rekomendasi').data('mahasiswa-id', mahasiswaId);
    $('#btn-konfirmasi-rekomendasi').data('lomba-id', lombaId);
    
    // Tampilkan modal
    $('#modalKonfirmasiRekomendasi').modal('show');
});

// Event listener untuk konfirmasi rekomendasi
$(document).on('click', '#btn-konfirmasi-rekomendasi', function() {
    const mahasiswaId = $(this).data('mahasiswa-id');
    const lombaId = $(this).data('lomba-id');
    
    // Disable button untuk mencegah double click
    $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
    
    // Kirim AJAX request
    $.ajax({
        url: '{{ route("admin.rekomendasiTopsis.kirimRekomendasi") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            mahasiswa_id: mahasiswaId,
            lomba_id: lombaId,
            rekomendasi_data: rekomendasiData // Kirim semua data rekomendasi
        },
        success: function(response) {
            $('#modalKonfirmasiRekomendasi').modal('hide');
            
            // Tampilkan pesan sukses
            showAlert('success', 'Rekomendasi berhasil dikirim! Mahasiswa akan menerima notifikasi.');
            
            // Disable button yang sudah diklik dan ubah textnya
            $(`button[data-mahasiswa-id="${mahasiswaId}"]`).prop('disabled', true)
                .removeClass('btn-success').addClass('btn-secondary')
                .html('<i class="fas fa-check"></i> Terkirim');
        },
        error: function(xhr) {
            $('#modalKonfirmasiRekomendasi').modal('hide');
            
            let errorMessage = 'Terjadi kesalahan saat mengirim rekomendasi.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            showAlert('danger', errorMessage);
        },
        complete: function() {
            // Enable button kembali
            $('#btn-konfirmasi-rekomendasi').prop('disabled', false)
                .html('<i class="fas fa-paper-plane"></i> Ya, Kirim Rekomendasi');
        }
    });
});

// Function untuk menampilkan alert
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} border-left-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    
    // Insert alert di atas konten
    $('.content').prepend(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);
}

function exportToExcel() {
    // Simple table to CSV export
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length - 1; j++) { // Exclude last column (Aksi)
            // Clean up the text content
            var cellText = cols[j].innerText.replace(/"/g, '""');
            row.push('"' + cellText + '"');
        }
        
        csv.push(row.join(","));
    }

    // Download CSV file
    var csvFile = csv.join("\n");
    var downloadLink = document.createElement("a");
    var blob = new Blob(["\ufeff", csvFile]);
    var url = URL.createObjectURL(blob);
    downloadLink.href = url;
    downloadLink.download = "rekomendasi_mahasiswa_{{ $lomba->lomba_nama }}.csv";

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

// Print styles
window.addEventListener('beforeprint', function() {
    // Hide buttons when printing
    document.querySelectorAll('.btn').forEach(function(btn) {
        btn.style.display = 'none';
    });
    
    // Hide action column when printing
    document.querySelectorAll('th:last-child, td:last-child').forEach(function(cell) {
        cell.style.display = 'none';
    });
});

window.addEventListener('afterprint', function() {
    // Show buttons after printing
    document.querySelectorAll('.btn').forEach(function(btn) {
        btn.style.display = '';
    });
    
    // Show action column after printing
    document.querySelectorAll('th:last-child, td:last-child').forEach(function(cell) {
        cell.style.display = '';
    });
});
</script>

<style>
@media print {
    .btn {
        display: none !important;
    }
    
    .card {
        border: 1px solid #dee2e6 !important;
        box-shadow: none !important;
    }
    
    .table {
        font-size: 12px;
    }
    
    /* Hide action column when printing */
    th:last-child, 
    td:last-child {
        display: none !important;
    }
}

/* Button rekomendasi styling */
.btn-rekomendasi {
    transition: all 0.3s ease;
}

.btn-rekomendasi:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Modal styling */
.modal-header {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.modal-header .close {
    color: white;
    opacity: 0.8;
}

.modal-header .close:hover {
    opacity: 1;
}
</style>
@endpush