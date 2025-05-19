<form action="{{ route('admin.dosenManagement.storeAjax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Dosen
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <!-- Basic Information Section -->
                <h5 class="font-weight-bold mb-3">Informasi Dasar</h5>

                <div class="form-group">
                    <label class="font-weight-bold">Nama Dosen</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="dosen_nama" id="dosen_nama" class="form-control"
                            placeholder="Masukkan nama dosen" required>
                    </div>
                    <small id="error-dosen_nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">NIP</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="dosen_nip" id="dosen_nip" class="form-control"
                            placeholder="Masukkan NIP dosen" required>
                    </div>
                    <small id="error-dosen_nip" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Status</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary text-white"><i
                                    class="fas fa-info-circle"></i></span>
                        </div>
                        <select name="dosen_status" id="dosen_status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Resign">Resign</option>
                            <option value="Pensiun">Pensiun</option>
                        </select>
                    </div>
                    <small id="error-dosen_status" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Jenis Kelamin</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-venus-mars"></i></span>
                        </div>
                        <select name="dosen_gender" id="dosen_gender" class="form-control" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <small id="error-dosen_gender" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Nomor Telepon</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="dosen_nomor_telepon" id="dosen_nomor_telepon" class="form-control"
                            placeholder="Masukkan nomor telepon" required>
                    </div>
                    <small id="error-dosen_nomor_telepon" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Agama</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-warning text-white"><i class="fas fa-pray"></i></span>
                        </div>
                        <input type="text" name="dosen_agama" id="dosen_agama" class="form-control"
                            placeholder="Masukkan agama">
                    </div>
                    <small id="error-dosen_agama" class="error-text form-text text-danger"></small>
                </div>

                <!-- Address Information Section -->
                <h5 class="font-weight-bold mb-3 mt-4">Informasi Alamat</h5>

                <div class="form-group">
                    <label class="font-weight-bold">Provinsi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i
                                    class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" name="dosen_provinsi" id="dosen_provinsi" class="form-control"
                            placeholder="Masukkan provinsi">
                    </div>
                    <small id="error-dosen_provinsi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Kota/Kabupaten</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i
                                    class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" name="dosen_kota" id="dosen_kota" class="form-control"
                            placeholder="Masukkan kota/kabupaten">
                    </div>
                    <small id="error-dosen_kota" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Kecamatan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i
                                    class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" name="dosen_kecamatan" id="dosen_kecamatan" class="form-control"
                            placeholder="Masukkan kecamatan">
                    </div>
                    <small id="error-dosen_kecamatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Desa/Kelurahan</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i
                                    class="fas fa-map-marker-alt"></i></span>
                        </div>
                        <input type="text" name="dosen_desa" id="dosen_desa" class="form-control"
                            placeholder="Masukkan desa/kelurahan">
                    </div>
                    <small id="error-dosen_desa" class="error-text form-text text-danger"></small>
                </div>

                <!-- Academic Information Section -->
                <h5 class="font-weight-bold mb-3 mt-4">Informasi Akademik</h5>

                <div class="form-group">
                    <label class="font-weight-bold">Program Studi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary text-white"><i
                                    class="fas fa-graduation-cap"></i></span>
                        </div>
                        <select name="prodi_id" id="prodi_id" class="form-control">
                            <option value="">Pilih Program Studi</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->prodi_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                </div>

                <!-- Photo Upload Section -->
                <h5 class="font-weight-bold mb-3 mt-4">Foto Profil</h5>

                <div class="form-group">
                    <label class="font-weight-bold">Upload Foto</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="dosen_photo" name="dosen_photo"
                            accept="image/*">
                        <label class="custom-file-label" for="dosen_photo">Pilih file foto (maks. 2MB)</label>
                    </div>
                    <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF (Maksimal 2MB)</small>
                    <small id="error-dosen_photo" class="error-text form-text text-danger"></small>
                </div>

                <!-- Account Information Section -->
                <h5 class="font-weight-bold mb-3 mt-4">Informasi Akun</h5>

                <div class="form-group">
                    <label class="font-weight-bold">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i
                                    class="fas fa-user-circle"></i></span>
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

        // Custom file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $("#form-tambah").validate({
            rules: {
                dosen_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                dosen_nip: {
                    required: true,
                    minlength: 10,
                    maxlength: 20,
                },
                dosen_status: {
                    required: true
                },
                dosen_gender: {
                    required: true
                },
                dosen_nomor_telepon: {
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                dosen_agama: {
                    maxlength: 50
                },
                dosen_provinsi: {
                    maxlength: 255
                },
                dosen_kota: {
                    maxlength: 255
                },
                dosen_kecamatan: {
                    maxlength: 255
                },
                dosen_desa: {
                    maxlength: 255
                },
                username: {
                    required: true,
                    minlength: 3,
                    maxlength: 255,
                },
                password: {
                    required: true,
                    minlength: 8
                },
                dosen_photo: {
                    accept: "image/jpeg,image/png,image/jpg,image/gif",
                    filesize: 2048
                }
            },
            messages: {
                dosen_nama: {
                    required: "Nama dosen tidak boleh kosong",
                    minlength: "Nama dosen minimal 3 karakter",
                    maxlength: "Nama dosen maksimal 255 karakter"
                },
                dosen_nip: {
                    required: "NIP tidak boleh kosong",
                    minlength: "NIP minimal 10 karakter",
                    maxlength: "NIP maksimal 20 karakter",
                    remote: "NIP sudah digunakan"
                },
                dosen_status: {
                    required: "Status tidak boleh kosong"
                },
                dosen_gender: {
                    required: "Jenis kelamin tidak boleh kosong"
                },
                dosen_nomor_telepon: {
                    required: "Nomor telepon tidak boleh kosong",
                    minlength: "Nomor telepon minimal 10 karakter",
                    maxlength: "Nomor telepon maksimal 15 karakter"
                },
                dosen_agama: {
                    maxlength: "Agama maksimal 50 karakter"
                },
                username: {
                    required: "Username tidak boleh kosong",
                    minlength: "Username minimal 3 karakter",
                    maxlength: "Username maksimal 255 karakter",
                    remote: "Username sudah digunakan"
                },
                password: {
                    required: "Password tidak boleh kosong",
                    minlength: "Password minimal 8 karakter"
                },
                dosen_photo: {
                    accept: "Format file harus berupa gambar (JPEG, PNG, JPG, GIF)",
                    filesize: "Ukuran file maksimal 2MB"
                }
            },
            submitHandler: function(form) {
                let formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: form.method,
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
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Reload DataTable
                            if (typeof dataDosen !== 'undefined') {
                                dataDosen.ajax.reload();
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
