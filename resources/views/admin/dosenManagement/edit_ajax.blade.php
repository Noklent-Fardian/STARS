@empty($dosen)
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
                            <p class="mb-0">Maaf, data dosen yang Anda cari tidak ada dalam database.</p>
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
    <form action="{{ route('admin.dosenManagement.updateAjax', $dosen->id) }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Dosen
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
                            <input value="{{ $dosen->dosen_nama }}" type="text" name="dosen_nama" id="dosen_nama"
                                class="form-control" placeholder="Masukkan nama dosen" required>
                        </div>
                        <small id="error-dosen_nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">NIP</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input value="{{ $dosen->dosen_nip }}" type="text" name="dosen_nip" id="dosen_nip"
                                class="form-control" placeholder="Masukkan NIP dosen" required>
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
                                <option value="Aktif" {{ $dosen->dosen_status === 'Aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="Cuti" {{ $dosen->dosen_status === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="Resign" {{ $dosen->dosen_status === 'Resign' ? 'selected' : '' }}>Resign
                                </option>
                                <option value="Pensiun" {{ $dosen->dosen_status === 'Pensiun' ? 'selected' : '' }}>Pensiun
                                </option>
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
                                <option value="Laki-laki" {{ $dosen->dosen_gender === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ $dosen->dosen_gender === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
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
                            <input value="{{ $dosen->dosen_nomor_telepon }}" type="text" name="dosen_nomor_telepon"
                                id="dosen_nomor_telepon" class="form-control" placeholder="Masukkan nomor telepon"
                                required>
                        </div>
                        <small id="error-dosen_nomor_telepon" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Agama</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white"><i class="fas fa-pray"></i></span>
                            </div>
                            <input value="{{ $dosen->dosen_agama }}" type="text" name="dosen_agama" id="dosen_agama"
                                class="form-control" placeholder="Masukkan agama">
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
                            <input value="{{ $dosen->dosen_provinsi }}" type="text" name="dosen_provinsi"
                                id="dosen_provinsi" class="form-control" placeholder="Masukkan provinsi">
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
                            <input value="{{ $dosen->dosen_kota }}" type="text" name="dosen_kota" id="dosen_kota"
                                class="form-control" placeholder="Masukkan kota/kabupaten">
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
                            <input value="{{ $dosen->dosen_kecamatan }}" type="text" name="dosen_kecamatan"
                                id="dosen_kecamatan" class="form-control" placeholder="Masukkan kecamatan">
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
                            <input value="{{ $dosen->dosen_desa }}" type="text" name="dosen_desa" id="dosen_desa"
                                class="form-control" placeholder="Masukkan desa/kelurahan">
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
                                    <option value="{{ $prodi->id }}"
                                        {{ $dosen->prodi_id == $prodi->id ? 'selected' : '' }}>
                                        {{ $prodi->prodi_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Photo Upload Section -->
                    <h5 class="font-weight-bold mb-3 mt-4">Foto Profil</h5>

                    <div class="form-group">
                        <label class="font-weight-bold">Foto Saat Ini</label>
                        @if ($dosen->dosen_photo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/dosen_photos/' . $dosen->dosen_photo) }}" alt="Foto Profil"
                                    class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-2"></i>Tidak ada foto profil
                            </div>
                        @endif

                        <label class="font-weight-bold">Ganti Foto</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="dosen_photo" name="dosen_photo"
                                accept="image/*">
                            <label class="custom-file-label" for="dosen_photo">Pilih file foto baru (maks. 2MB)</label>
                        </div>
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
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
                            <input value="{{ $dosen->user->username }}" type="text" name="username" id="username"
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
            $('#dosen_photo').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Tampilkan preview
                        $('.img-thumbnail').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            $.validator.addMethod('filesize', function(value, element, param) {
                if (element.files.length === 0) return true; // Skip jika tidak ada file
                
                const fileSize = element.files[0].size; // dalam bytes
                const maxSize = param * 1024 * 1024; // konversi MB ke bytes
                return this.optional(element) || (fileSize <= maxSize);
            }, 'Ukuran file maksimal {0}MB');

            $("#form-edit").validate({
                rules: {
                    dosen_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    dosen_nip: {
                        required: true,
                        minlength: 10,
                        maxlength: 20
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
                        minlength: 8
                    },
                    dosen_photo: {
                    accept: "image/jpeg,image/png,image/jpg,image/gif",
                    filesize: 2 
                }
                },
                messages: {
                    dosen_photo: {
                        accept: "Hanya file gambar (JPEG, PNG, JPG, GIF) yang diperbolehkan"
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
                    dataType: 'json', // Pastikan kita mengharapkan JSON
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                if (typeof dataDosen !== 'undefined') {
                                    dataDosen.ajax.reload(null, false); 
                                }
                            });
                        } else {
                            showValidationErrors(response.msgField);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let msg = 'Terjadi kesalahan pada server';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: msg
                        });
                    }
                });
                return false;
            },
                invalidHandler: function(event, validator) {
                    const errors = validator.numberOfInvalids();
                    if (errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Terdapat kesalahan pada form. Silakan periksa kembali.'
                        });
                    }
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
@endif
