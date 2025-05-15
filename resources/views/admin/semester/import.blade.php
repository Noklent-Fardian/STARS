<form action="{{ route('admin.master.semester.importExcel') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header card-header py-3">
                <h5 class="modal-title m-0 font-weight-bold text-white">Import Data Semester</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ route('admin.master.semester.generateTemplate') }}" class="btn btn-info btn-sm">
                        <i class="fa fa-file-excel"></i> Download Template
                    </a>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i> Format Excel harus sesuai template dengan kolom:
                    <ul class="mb-0 pl-4 mt-1">
                        <li><strong>Kolom A:</strong> Nama Semester (Contoh: Semester Ganjil 2023)</li>
                        <li><strong>Kolom B:</strong> Tahun (Angka antara 2000-{{ date('Y') + 5 }})</li>
                        <li><strong>Kolom C:</strong> Jenis (Ganjil/Genap)</li>
                        <li><strong>Kolom D:</strong> Status Aktif (1/0 atau true/false)</li>
                    </ul>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Perhatian:
                    <ul class="mb-0 pl-4 mt-1">
                        <li>Jika mengimport semester dengan status aktif, semua semester aktif lainnya akan dinonaktifkan</li>
                        <li>Nama semester harus unik</li>
                        <li>Format tahun harus angka 4 digit (contoh: 2023)</li>
                        <li>Jenis semester hanya boleh "Ganjil" atau "Genap"</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label>Pilih File Excel</label>
                    <div class="custom-file">
                        <input type="file" name="file_semester" id="file_semester" class="custom-file-input" required accept=".xlsx">
                        <label class="custom-file-label" for="file_semester">Pilih file Excel</label>
                    </div>
                    <small id="error-file_semester" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-upload mr-2"></i> Import Data
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Update file input label when file is selected
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $("#form-import").on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var $submitBtn = $(this).find('button[type="submit"]');
            var originalText = $submitBtn.html();

            // Disable button and show loading state
            $submitBtn.prop('disabled', true);
            $submitBtn.html('<i class="fas fa-circle-notch fa-spin mr-2"></i> Memproses...');

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
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            if (typeof dataSemester !== 'undefined') {
                                dataSemester.ajax.reload(null, false);
                            } else {
                                window.location.reload();
                            }
                        });
                    } else {
                        // Reset button state on error
                        $submitBtn.prop('disabled', false);
                        $submitBtn.html(originalText);

                        $('.error-text').text('');

                        // Handle field validation errors
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }

                        // Handle detailed errors
                        let errorMessages = [];
                        if (response.errors) errorMessages = errorMessages.concat(response.errors);
                        if (response.duplicateErrors) errorMessages = errorMessages.concat(response.duplicateErrors);

                        if (errorMessages.length > 0) {
                            let errorList = '<ul class="text-left mb-0">';
                            errorMessages.forEach(function(errorMsg) {
                                errorList += '<li>' + errorMsg + '</li>';
                            });
                            errorList += '</ul>';

                            Swal.fire({
                                icon: 'error',
                                title: response.message || 'Error Import',
                                html: errorList,
                                width: '600px'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Terjadi kesalahan saat mengimport data'
                            });
                        }
                    }
                },
                error: function(xhr) {
                    // Reset button state on AJAX error
                    $submitBtn.prop('disabled', false);
                    $submitBtn.html(originalText);

                    let errorMessage = 'Terjadi kesalahan pada server';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                }
            });
        });
    });
</script>