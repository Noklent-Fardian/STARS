<form action="{{ route('admin.master.prodi.storeAjax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Program Studi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">Nama Program Studi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-graduation-cap"></i></span>
                        </div>
                        <input type="text" name="prodi_nama" id="prodi_nama" class="form-control"
                            placeholder="Masukkan nama program studi" required>
                    </div>
                    <small id="error-prodi_nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Kode Program Studi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-code"></i></span>
                        </div>
                        <input type="text" name="prodi_kode" id="prodi_kode" class="form-control"
                            placeholder="Masukkan kode program studi" required>
                    </div>
                    <small id="error-prodi_kode" class="error-text form-text text-danger"></small>
                </div>

                {{-- <div class="form-group">
                    <label class="font-weight-bold">Status</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white"><i class="fas fa-eye"></i></span>
                        </div>
                        <select name="prodi_visible" id="prodi_visible" class="form-control" required>
                            <option value="1" selected>Aktif</option>
                            <option value="0">Non-Aktif</option>
                        </select>
                    </div>
                    <small id="error-prodi_visible" class="error-text form-text text-danger"></small>
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
    $(document).ready(function () {
        // Add animation to form elements when modal loads
        $('.form-group').each(function (i) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });

            setTimeout(function () {
                $('.form-group').eq(i).css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.4s ease-out'
                });
            }, 100 * (i + 1));
        });

        $("#form-tambah").validate({
            rules: {
                prodi_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                prodi_kode: {
                    required: true,
                    minlength: 2,
                    maxlength: 10
                },
                prodi_visible: {
                    required: true
                }
            },
            messages: {
                prodi_nama: {
                    required: "Nama program studi tidak boleh kosong",
                    minlength: "Nama program studi minimal 3 karakter",
                    maxlength: "Nama program studi maksimal 255 karakter"
                },
                prodi_kode: {
                    required: "Kode program studi tidak boleh kosong",
                    minlength: "Kode program studi minimal 2 karakter",
                    maxlength: "Kode program studi maksimal 10 karakter"
                },
                prodi_visible: {
                    required: "Status tidak boleh kosong"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
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
                            if (typeof dataProdi !== 'undefined') {
                                dataProdi.ajax.reload();
                            }
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
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
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>