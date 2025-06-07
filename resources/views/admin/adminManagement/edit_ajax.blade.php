@empty($admin)
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
                            <p class="mb-0">Maaf, data admin yang Anda cari tidak ada dalam database.</p>
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
    <form action="{{ route('admin.adminManagement.updateAjax', $admin->id) }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Admin
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
                            <input value="{{ $admin->admin_name }}" type="text" name="admin_name" id="admin_name"
                                class="form-control" placeholder="Masukkan nama admin" required>
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
                                <option value="Laki-laki" {{ $admin->admin_gender === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ $admin->admin_gender === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
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
                            <input value="{{ $admin->admin_nomor_telepon }}" type="text" name="admin_nomor_telepon"
                                id="admin_nomor_telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                        </div>
                        <small id="error-admin_nomor_telepon" class="error-text form-text text-danger"></small>
                    </div>

                    <hr>
                    <h5 class="font-weight-bold mb-3">Informasi Akun</h5>

                    <div class="form-group">
                        <label class="font-weight-bold">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i
                                        class="fas fa-user-circle"></i></span>
                            </div>
                            <input value="{{ $admin->user->username }}" type="text" name="username" id="username"
                                class="form-control" placeholder="Masukkan username" required>
                        </div>
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Password <span class="text-muted">(Kosongkan jika tidak ingin
                                mengubah)</span></label>
                        <div class="input-group shadow-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-gradient-danger text-white border-0">
                                    <i class="fas fa-lock fa-fw"></i>
                                </span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control border-0 py-2"
                                style="transition: all 0.3s" placeholder="Masukkan password baru">
                            <div class="input-group-append m-0">
                                <button class="btn btn-outline-secondary border-0 toggle-password m-0" type="button"
                                    style="transition: all 0.3s; margin: 0;" title="Lihat/Sembunyikan Password">
                                    <i class="fas fa-eye fa-fw"></i>
                                </button>
                            </div>
                        </div>
                        <div class="password-strength-meter mt-2 d-none">
                            <div class="progress" style="height: 5px">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted mt-1 d-block">Kekuatan password: <span class="strength-text">Belum
                                    diisi</span></small>
                        </div>
                        <small id="error-password" class="error-text form-text text-danger"></small>
                        <small class="form-text text-muted">Password minimal 8 karakter. Biarkan kosong jika tidak ingin
                            mengubah password.</small>
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

            // Show/hide password
            $('.toggle-password').click(function() {
                const passwordField = $('#password');
                const passwordFieldType = passwordField.attr('type');

                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            $("#form-edit").validate({
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
                        minlength: "Password minimal 8 karakter"
                    }
                },
                submitHandler: function(form) {
                    // Show loading state
                    const submitBtn = $(form).find('button[type="submit"]');
                    const originalText = submitBtn.html();
                    submitBtn.prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            // Reset button state
                            submitBtn.prop('disabled', false).html(originalText);

                            if (response.status) {
                                // Clear any previous errors
                                $('.error-text').text('');
                                $('.form-control').removeClass('is-invalid');

                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Close modal
                                    $('#myModal').modal('hide');

                                    if ($('.card-header:contains("Detail Admin")')
                                        .length > 0) {
                                        // Update the view with new data without page refresh
                                        updateDetailView({
                                            name: $('#admin_name').val(),
                                            gender: $('#admin_gender')
                                            .val(),
                                            phone: $('#admin_nomor_telepon')
                                                .val(),
                                            username: $('#username').val()
                                        });
                                    } else {
                                        if (typeof dataAdmin !== 'undefined') {
                                            dataAdmin.ajax.reload(null,
                                            false); // false to keep pagination
                                        }
                                    }
                                });
                            } else {
                                // Handle validation errors
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                        $('#' + prefix).addClass('is-invalid');
                                    });
                                }

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Reset button state
                            submitBtn.prop('disabled', false).html(originalText);

                            let errorMessage = 'Terjadi kesalahan sistem';

                            if (xhr.status === 422) {
                                // Validation errors
                                const errors = xhr.responseJSON.errors || xhr.responseJSON
                                    .msgField;
                                if (errors) {
                                    $('.error-text').text('');
                                    $.each(errors, function(prefix, val) {
                                        $('#error-' + prefix).text(Array.isArray(
                                            val) ? val[0] : val);
                                        $('#' + prefix).addClass('is-invalid');
                                    });
                                    errorMessage =
                                        'Mohon periksa kembali data yang dimasukkan';
                                }
                            } else if (xhr.status === 500) {
                                errorMessage =
                                    'Terjadi kesalahan server. Silakan coba lagi.';
                            } else if (xhr.status === 404) {
                                errorMessage = 'Data tidak ditemukan';
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menyimpan',
                                text: errorMessage,
                                confirmButtonText: 'OK'
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

            function updateDetailView(data) {
                $('h4.font-weight-bold').text(data.name);

                // Update the table data
                let tableRows = $('.user-info-item');
                $(tableRows).each(function(index) {
                    const infoLabel = $(this).find('.info-label span').text();

                    if (infoLabel === 'Nama Admin') {
                        $(this).find('.info-value').text(data.name);
                    } else if (infoLabel === 'Jenis Kelamin') {
                        $(this).find('.info-value').text(data.gender);
                    } else if (infoLabel === 'Nomor Telepon') {
                        $(this).find('.info-value').text(data.phone);
                    } else if (infoLabel === 'Username') {
                        $(this).find('.info-value').text(data.username);
                    }
                });

                let now = new Date();
                let formattedDate = now.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                $(tableRows).each(function(index) {
                    const infoLabel = $(this).find('.info-label span').text();
                    if (infoLabel === 'Terakhir Diperbarui') {
                        $(this).find('.info-value').text(formattedDate);
                    }
                });

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