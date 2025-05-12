<form action="{{ route('admin.adminManagement.storeAjax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Admin
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">Nama Admin</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="admin_name" id="admin_name" class="form-control"
                            placeholder="Masukkan nama admin" required>
                    </div>
                    <small id="error-admin_name" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Jenis Kelamin</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-venus-mars"></i></span>
                        </div>
                        <select name="admin_gender" id="admin_gender" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <small id="error-admin_gender" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Nomor Telepon</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="admin_nomor_telepon" id="admin_nomor_telepon" class="form-control"
                            placeholder="Masukkan nomor telepon" required>
                    </div>
                    <small id="error-admin_nomor_telepon" class="error-text form-text text-danger"></small>
                </div>

                <hr>
                <h5 class="font-weight-bold mb-3">Informasi Akun</h5>

                <div class="form-group">
                    <label class="font-weight-bold">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-user-circle"></i></span>
                        </div>
                        <input type="text" name="username" id="username" class="form-control"
                            placeholder="Masukkan username" required>
                    </div>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-danger text-white"><i class="fas fa-lock"></i></span>
                        </div>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                    <small class="form-text text-muted">Password minimal 8 karakter.</small>
                </div>
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

        // Show/hide password
        $('.toggle-password').click(function() {
            const passwordField = $('#password');
            const passwordFieldType = passwordField.attr('type');
            
            if(passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        $("#form-tambah").validate({
            rules: {
                admin_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                admin_gender: {
                    required: true
                },
                admin_nomor_telepon: {
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                admin_name: {
                    required: "Nama admin tidak boleh kosong",
                    minlength: "Nama admin minimal 3 karakter",
                    maxlength: "Nama admin maksimal 255 karakter"
                },
                admin_gender: {
                    required: "Jenis kelamin tidak boleh kosong"
                },
                admin_nomor_telepon: {
                    required: "Nomor telepon tidak boleh kosong",
                    minlength: "Nomor telepon minimal 10 karakter",
                    maxlength: "Nomor telepon maksimal 15 karakter"
                },
                username: {
                    required: "Username tidak boleh kosong",
                    minlength: "Username minimal 3 karakter",
                    maxlength: "Username maksimal 255 karakter"
                },
                password: {
                    required: "Password tidak boleh kosong",
                    minlength: "Password minimal 8 karakter"
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
                            if (typeof dataAdmin !== 'undefined') {
                                dataAdmin.ajax.reload();
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