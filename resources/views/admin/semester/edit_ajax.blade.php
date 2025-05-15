@empty($semester)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-ban fa-2x mr-3"></i>
                        <div>
                            <h5 class="mb-1">Data Tidak Ditemukan</h5>
                            <p class="mb-0">Maaf, data semester yang Anda cari tidak ada dalam database.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </button>
            </div>
        </div>
    </div>
@else
    <form action="{{ route('admin.master.semester.updateAjax', $semester->id) }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Semester
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Semester</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i
                                        class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input value="{{ $semester->semester_nama }}" type="text" name="semester_nama"
                                id="semester_nama" class="form-control" placeholder="Contoh: Semester Ganjil 2023" required>
                        </div>
                        <small id="error-semester_nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Tahun</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-calendar"></i></span>
                            </div>
                            <input value="{{ $semester->semester_tahun }}" type="number" name="semester_tahun"
                                id="semester_tahun" class="form-control"
                                placeholder="Masukkan tahun (2000-{{ date('Y') + 5 }})" min="2000"
                                max="{{ date('Y') + 5 }}" required>
                        </div>
                        <small id="error-semester_tahun" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Semester</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-success text-white"><i
                                        class="fas fa-exchange-alt"></i></span>
                            </div>
                            <select name="semester_jenis" id="semester_jenis" class="form-control" required>
                                <option value="Ganjil" {{ $semester->semester_jenis == 'Ganjil' ? 'selected' : '' }}>Ganjil
                                </option>
                                <option value="Genap" {{ $semester->semester_jenis == 'Genap' ? 'selected' : '' }}>Genap
                                </option>
                            </select>
                        </div>
                        <small id="error-semester_jenis" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Status Aktif</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-danger text-white"><i class="fas fa-power-off"></i></span>
                            </div>
                            <select name="semester_aktif" id="semester_aktif" class="form-control" required>
                                <option value="1" {{ $semester->semester_aktif ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$semester->semester_aktif ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                        <small id="error-semester_aktif" class="error-text form-text text-danger"></small>
                        <small class="form-text text-muted">Jika memilih aktif, semester aktif lainnya akan dinonaktifkan
                            secara otomatis.</small>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            // Add animation to form elements when modal loads
            $('.form-group').each(function(i) {
                $(this).css({
                    'opacity': 0,
                    'transform': 'translateY(20px)'
                });

                setTimeout(function() {
                    $('.form-group').eq(i).css({
                        'opacity': 1,
                        'transform': 'translateY(0)',
                        'transition': 'all 0.4s ease-out'
                    });
                }, 100 * (i + 1));
            });

            $("#form-edit").validate({
                rules: {
                    semester_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    semester_tahun: {
                        required: true,
                        digits: true,
                        min: 2000,
                        max: {{ date('Y') + 5 }}
                    },
                    semester_jenis: {
                        required: true
                    },
                    semester_aktif: {
                        required: true
                    }
                },
                messages: {
                    semester_nama: {
                        required: "Nama semester tidak boleh kosong",
                        minlength: "Nama semester minimal 3 karakter",
                        maxlength: "Nama semester maksimal 255 karakter"
                    },
                    semester_tahun: {
                        required: "Tahun semester tidak boleh kosong",
                        digits: "Tahun harus berupa angka",
                        min: "Tahun minimal 2000",
                        max: "Tahun maksimal {{ date('Y') + 5 }}"
                    },
                    semester_jenis: {
                        required: "Jenis semester tidak boleh kosong"
                    },
                    semester_aktif: {
                        required: "Status aktif tidak boleh kosong"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // Check if we're on the detail/show page by looking for specific elements
                                if ($('.card-header:contains("Detail Semester")').length >
                                    0) {
                                    // Update the view with new data without page refresh
                                    updateDetailView({
                                        nama: $('#semester_nama').val(),
                                        tahun: $('#semester_tahun').val(),
                                        jenis: $('#semester_jenis').val(),
                                        aktif: $('#semester_aktif').val() == '1' ?
                                            'Aktif' : 'Non-Aktif'
                                    });
                                } else {
                                    // If on index page, just reload the DataTable
                                    if (typeof dataSemester !== 'undefined') {
                                        dataSemester.ajax.reload();
                                    }
                                }
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            // Function to update the detail view without page refresh
            function updateDetailView(data) {
                // Update the heading and card info
                $('h4.font-weight-bold').text(data.nama);
                $('.badge.badge-primary').text('Tahun: ' + data.tahun);

                // Update the table data
                let tableRows = $('.user-info-item');
                $(tableRows[1]).find('.info-value').text(data.nama);
                $(tableRows[2]).find('.info-value').text(data.tahun);
                $(tableRows[3]).find('.info-value').text(data.jenis);
                $(tableRows[4]).find('.info-value').html(data.aktif === 'Aktif' ?
                    '<span class="badge badge-success">Aktif</span>' :
                    '<span class="badge badge-secondary">Non-Aktif</span>');

                // Update the timestamp with current time
                let now = new Date();
                let formattedDate = now.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                $(tableRows[5]).find('.info-value').text(formattedDate);

                // Add a highlight effect to show updated content
                $('.user-info-item .info-value').css({
                    'background-color': '#fffde7',
                    'transition': 'background-color 1s'
                });

                setTimeout(function() {
                    $('.user-info-item .info-value').css('background-color', '');
                }, 2000);
            }
        });
    </script>
    @endif
