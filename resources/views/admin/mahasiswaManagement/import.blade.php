<form action="{{ route('admin.mahasiswaManagement.importExcel') }}" method="POST" id="form-import-mahasiswa" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header py-3">
                <h5 class="modal-title m-0 font-weight-bold text-white">Import Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ route('admin.mahasiswaManagement.generateTemplate') }}" class="btn btn-info btn-sm">
                        <i class="fa fa-file-excel"></i> Download Template
                    </a>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Format Excel harus sesuai template dengan kolom:
                    <ul class="mb-0 pl-4 mt-1">
                        <li><strong>Kolom A:</strong> Nama Lengkap</li>
                        <li><strong>Kolom B:</strong> Username</li>
                        <li><strong>Kolom C:</strong> Jenis Kelamin (L/P)</li>
                        <li><strong>Kolom D:</strong> NIM</li>
                        <li><strong>Kolom E:</strong> Status (Aktif/Tidak Aktif/Cuti)</li>
                        <li><strong>Kolom F:</strong> Nomor Telepon</li>
                        <li><strong>Kolom G:</strong> Agama</li>
                        <li><strong>Kolom H:</strong> Angkatan (tahun)</li>
                        <li><strong>Kolom I:</strong> Provinsi</li>
                        <li><strong>Kolom J:</strong> Kota/Kabupaten</li>
                        <li><strong>Kolom K:</strong> Kecamatan</li>
                        <li><strong>Kolom L:</strong> Desa/Kelurahan</li>
                        <li><strong>Kolom M:</strong> ID Program Studi</li>
                        <li><strong>Kolom N:</strong> ID Keahlian</li>
                        <li><strong>Kolom O:</strong> ID Semester</li>
                    </ul>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Password default untuk semua mahasiswa yang diimport adalah NIM
                </div>
                <div class="form-group">
                    <label>Pilih File Excel</label>
                    <input type="file" name="file_mahasiswa" id="file_mahasiswa" class="form-control" required accept=".xlsx">
                    <small id="error-file_mahasiswa" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Import Data</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-import-mahasiswa").on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var $submitBtn = $(this).find('button[type="submit"]');
            var originalText = $submitBtn.html();

            // Disable button and show loading state
            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="fas fa-circle-notch fa-spin"></i> Processing...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        // Reset button state on error
                        $submitBtn.prop('disabled', false);
                        $submitBtn.html(originalText);

                        $('.error-text').text('');

                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }

                        // Check if we have detailed errors to display
                        if (response.errors && response.errors.length > 0) {
                            let errorList = '<ul class="text-left mb-0">';
                            $.each(response.errors, function(index, errorMsg) {
                                errorList += '<li>' + errorMsg + '</li>';
                            });
                            errorList += '</ul>';

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: response.message + '<br><br>' + errorList,
                                width: '600px'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    }
                },
                error: function() {
                    // Reset button state on AJAX error
                    $submitBtn.prop('disabled', false);
                    $submitBtn.html(originalText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server'
                    });
                }
            });
        });
    });
</script>