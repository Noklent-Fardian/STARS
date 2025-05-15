<form action="{{ route('admin.master.semester.storeAjax') }}" method="POST" id="form-tambah-semester">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Semester
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
                        <input type="text" name="semester_nama" id="semester_nama" class="form-control"
                            placeholder="Contoh: Semester Ganjil 2023" required>
                    </div>
                    <small id="error-semester_nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tahun</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-calendar"></i></span>
                        </div>
                        <input type="number" name="semester_tahun" id="semester_tahun" class="form-control"
                            placeholder="Masukkan tahun (2000-{{ date('Y') + 5 }})" min="2000"
                            max="{{ date('Y') + 5 }}" value="{{ date('Y') }}" required>
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
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <small id="error-semester_jenis" class="error-text form-text text-danger"></small>
                </div>

                {{-- <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="semester_aktif" name="semester_aktif">
                        <label class="custom-control-label font-weight-bold" for="semester_aktif">Aktifkan Semester
                            Ini</label>
                        <small class="form-text text-muted">Centang untuk mengaktifkan semester ini (hanya satu semester
                            yang bisa aktif)</small>
                    </div>
                    <small id="error-semester_aktif" class="error-text form-text text-danger"></small>
                </div> --}}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">
                    <i class="fas fa-times mr-2"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save mr-2"></i> Simpan
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

        $("#form-tambah-semester").validate({
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
                }
            },
            messages: {
                semester_nama: {
                    required: "Nama semester tidak boleh kosong",
                    minlength: "Nama semester minimal 3 karakter",
                    maxlength: "Nama semester maksimal 255 karakter"
                },
                semester_tahun: {
                    required: "Tahun tidak boleh kosong",
                    digits: "Tahun harus berupa angka",
                    min: "Tahun minimal 2000",
                    max: "Tahun maksimal {{ date('Y') + 5 }}"
                },
                semester_jenis: {
                    required: "Jenis semester harus dipilih"
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

                            // Reload DataTable jika ada
                            if (typeof dataSemester !== 'undefined') {
                                dataSemester.ajax.reload();
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
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan pada server'
                        });
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
    });
</script>
