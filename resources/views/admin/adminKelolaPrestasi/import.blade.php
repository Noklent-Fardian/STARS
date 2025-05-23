<form action="{{ route('admin.adminKelolaPrestasi.importExcel') }}" method="POST" id="form-import"
    enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header py-3">
                <h5 class="modal-title m-0 font-weight-bold text-white">Import Data Prestasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ route('admin.adminKelolaPrestasi.generateTemplate') }}" class="btn btn-info btn-sm">
                        <i class="fa fa-file-excel"></i> Download Template
                    </a>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Format Excel harus sesuai template dengan kolom:
                    <ul class="mb-0 pl-4 mt-1">
                        <li><strong>Kolom A:</strong> Mahasiswa ID</li>
                        <li><strong>Kolom B:</strong> Lomba ID</li>
                        <li><strong>Kolom C:</strong> Peringkat ID</li>
                        <li><strong>Kolom D:</strong> Tingkatan ID</li>
                        <li><strong>Kolom E:</strong> Judul</li>
                        <li><strong>Kolom F:</strong> Tempat</li>
                        <li><strong>Kolom G:</strong> Tanggal Mulai (yyyy-mm-dd)</li>
                        <li><strong>Kolom H:</strong> Tanggal Selesai (yyyy-mm-dd)</li>
                        <li><strong>Kolom I:</strong> Jumlah Peserta</li>
                        <li><strong>Kolom J:</strong> Jumlah Instansi</li>
                        <li><strong>Kolom K:</strong> No Surat Tugas</li>
                        <li><strong>Kolom L:</strong> Tanggal Surat</li>
                        <li><strong>Kolom M:</strong> File Surat</li>
                        <li><strong>Kolom N:</strong> File Sertifikat</li>
                        <li><strong>Kolom O:</strong> File Poster</li>
                        <li><strong>Kolom P:</strong> Foto Kegiatan</li>
                        <li><strong>Kolom Q:</strong> Skor</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_prestasi" id="file_prestasi" class="form-control" required>
                    <small id="error-file_prestasi" class="error-text form-text text-danger"></small>
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
    $(document).ready(function () {
        $("#form-import").on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(this);
            var $submitBtn = $(this).find('button[type="submit"]');
            var originalText = $submitBtn.html();

            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="fas fa-circle-notch fa-spin"></i> Processing...');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        $submitBtn.prop('disabled', false);
                        $submitBtn.html(originalText);

                        $('.error-text').text('');

                        if (response.msgField) {
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }

                        if (response.errors && response.errors.length > 0) {
                            let errorList = '<ul class="text-left mb-0">';
                            $.each(response.errors, function (index, errorMsg) {
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
                error: function () {
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