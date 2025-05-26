@empty($mahasiswa)
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
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
                            <p class="mb-0">Maaf, data mahasiswa yang Anda cari tidak ada dalam database.</p>
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
    <div id="modal-master" class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-warning text-white">
                <h4 class="modal-title font-weight-bold">
                    <i class="fas fa-edit mr-2"></i> Edit Data Mahasiswa
                </h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body p-4">
                <form action="{{ route('admin.mahasiswaManagement.updateAjax', $mahasiswa->id) }}" method="POST" id="form-edit" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- Card: Informasi Dasar -->
                        <div class="col-12">
                            <div class="card card-primary card-outline mb-4">
                                <div class="card-header bg-primary">
                                    <h5 class="card-title font-weight-bold mb-0 text-white">
                                        <i class="fas fa-id-card mr-2"></i> Informasi Dasar
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Nama Mahasiswa -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Nama Mahasiswa <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_nama }}" type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control" placeholder="Masukkan nama mahasiswa" required>
                                                </div>
                                                <small id="error-mahasiswa_nama" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- NIM -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">NIM <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-id-card"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_nim }}" type="text" name="mahasiswa_nim" id="mahasiswa_nim" class="form-control" placeholder="Masukkan NIM mahasiswa" required>
                                                </div>
                                                <small id="error-mahasiswa_nim" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- Program Studi -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Program Studi <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-secondary text-white"><i class="fas fa-graduation-cap"></i></span>
                                                    </div>
                                                    <select name="prodi_id" id="prodi_id" class="form-control" required>
                                                        <option value="">Pilih Program Studi</option>
                                                        @foreach ($prodis as $prodi)
                                                            <option value="{{ $prodi->id }}" {{ $mahasiswa->prodi_id == $prodi->id ? 'selected' : '' }}>
                                                                {{ $prodi->prodi_nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Keahlian -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Keahlian</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-secondary text-white"><i class="fas fa-certificate"></i></span>
                                                    </div>
                                                    <select name="keahlian_id" id="keahlian_id" class="form-control">
                                                        <option value="">Pilih Keahlian</option>
                                                        @foreach ($keahlians as $keahlian)
                                                            <option value="{{ $keahlian->id }}" {{ $mahasiswa->keahlian_id == $keahlian->id ? 'selected' : '' }}>
                                                                {{ $keahlian->keahlian_nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small id="error-keahlian_id" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Semester -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Semester</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-secondary text-white"><i class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <select name="semester_id" id="semester_id" class="form-control">
                                                        <option value="">Pilih Semester</option>
                                                        @foreach ($semesters as $semester)
                                                            <option value="{{ $semester->id }}" {{ $mahasiswa->semester_id == $semester->id ? 'selected' : '' }}>
                                                                {{ $semester->semester_nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <small id="error-semester_id" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <!-- Jenis Kelamin -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-venus-mars"></i></span>
                                                    </div>
                                                    <select name="mahasiswa_gender" id="mahasiswa_gender" class="form-control" required>
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="Laki-laki" {{ $mahasiswa->mahasiswa_gender === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="Perempuan" {{ $mahasiswa->mahasiswa_gender === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                                <small id="error-mahasiswa_gender" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Angkatan -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Angkatan <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-success text-white"><i class="fas fa-calendar"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_angkatan }}" type="number" name="mahasiswa_angkatan" id="mahasiswa_angkatan" 
                                                        class="form-control" placeholder="Masukkan tahun angkatan" 
                                                        min="2000" max="{{ date('Y') + 5 }}" required>
                                                </div>
                                                <small id="error-mahasiswa_angkatan" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <!-- Nomor Telepon -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Nomor Telepon <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-success text-white"><i class="fas fa-phone"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_nomor_telepon }}" type="text" name="mahasiswa_nomor_telepon" id="mahasiswa_nomor_telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
                                                </div>
                                                <small id="error-mahasiswa_nomor_telepon" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Agama -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Agama</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-warning text-white"><i class="fas fa-pray"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_agama }}" type="text" name="mahasiswa_agama" id="mahasiswa_agama" class="form-control" placeholder="Masukkan agama">
                                                </div>
                                                <small id="error-mahasiswa_agama" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Foto Mahasiswa -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Foto Mahasiswa</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="mahasiswa_photo" name="mahasiswa_photo">
                                                    <label class="custom-file-label" for="mahasiswa_photo">Pilih file foto</label>
                                                </div>
                                                @if($mahasiswa->mahasiswa_photo)
                                                    <small class="form-text text-muted">Foto saat ini: 
                                                        <a href="{{ asset('storage/mahasiswa_photos/' . $mahasiswa->mahasiswa_photo) }}" target="_blank">
                                                            {{ $mahasiswa->mahasiswa_photo }}
                                                        </a>
                                                    </small>
                                                @endif
                                                <small id="error-mahasiswa_photo" class="error-text form-text text-danger"></small>
                                                <small class="form-text text-muted">Format: JPG/PNG (Maks. 2MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card: Alamat -->
                        <div class="col-12">
                            <div class="card card-success card-outline mb-4">
                                <div class="card-header bg-success">
                                    <h5 class="card-title font-weight-bold mb-0 text-white">
                                        <i class="fas fa-map-marker-alt mr-2"></i> Alamat
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Provinsi -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Provinsi</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_provinsi }}" type="text" name="mahasiswa_provinsi" id="mahasiswa_provinsi" class="form-control" placeholder="Masukkan provinsi">
                                                </div>
                                                <small id="error-mahasiswa_provinsi" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Kota/Kabupaten -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Kota/Kabupaten</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_kota }}" type="text" name="mahasiswa_kota" id="mahasiswa_kota" class="form-control" placeholder="Masukkan kota/kabupaten">
                                                </div>
                                                <small id="error-mahasiswa_kota" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Kecamatan -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Kecamatan</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_kecamatan }}" type="text" name="mahasiswa_kecamatan" id="mahasiswa_kecamatan" class="form-control" placeholder="Masukkan kecamatan">
                                                </div>
                                                <small id="error-mahasiswa_kecamatan" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Desa/Kelurahan -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Desa/Kelurahan</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->mahasiswa_desa }}" type="text" name="mahasiswa_desa" id="mahasiswa_desa" class="form-control" placeholder="Masukkan desa/kelurahan">
                                                </div>
                                                <small id="error-mahasiswa_desa" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Card: Status dan Reset Password -->
                        <div class="col-12">
                            <div class="card card-info card-outline mb-4">
                                <div class="card-header bg-info">
                                    <h5 class="card-title font-weight-bold mb-0 text-white">
                                        <i class="fas fa-user-check mr-2"></i> Status dan Akun
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Reset Password -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Username <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-user-circle"></i></span>
                                                    </div>
                                                    <input value="{{ $mahasiswa->user->username }}" type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
                                                </div>
                                                <small id="error-username" class="error-text form-text text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Password <span class="text-muted">(Kosongkan jika tidak ingin mengubah)</span></label>
                                                <div class="input-group shadow-sm">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-gradient-danger text-white border-0">
                                                            <i class="fas fa-lock fa-fw"></i>
                                                        </span>
                                                    </div>
                                                    <input type="password" name="password" id="password" class="form-control border-0 py-2" style="transition: all 0.3s" placeholder="Masukkan password baru">
                                                    <div class="input-group-append m-0">
                                                        <button class="btn btn-outline-secondary border-0 toggle-password m-0" type="button" style="transition: all 0.3s; margin: 0;" title="Lihat/Sembunyikan Password">
                                                            <i class="fas fa-eye fa-fw"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="password-strength-meter mt-2 d-none">
                                                    <div class="progress" style="height: 5px">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
                                                    </div>
                                                    <small class="text-muted mt-1 d-block">Kekuatan password: <span class="strength-text">Belum diisi</span></small>
                                                </div>
                                                <small id="error-password" class="error-text form-text text-danger"></small>
                                                <small class="form-text text-muted">Password minimal 8 karakter. Biarkan kosong jika tidak ingin mengubah password.</small>
                                            </div>
                                        </div>
                                        <!-- Status -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-user-check"></i></span>
                                                    </div>
                                                    <select name="mahasiswa_status" id="mahasiswa_status" class="form-control" required>
                                                        <option value="">Pilih Status</option>
                                                        <option value="Aktif" {{ $mahasiswa->mahasiswa_status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Cuti" {{ $mahasiswa->mahasiswa_status === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                                        <option value="Drop Out" {{ $mahasiswa->mahasiswa_status === 'Drop Out' ? 'selected' : '' }}>Drop Out</option>
                                                        <option value="Lulus" {{ $mahasiswa->mahasiswa_status === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                                    </select>
                                                </div>
                                                <small id="error-mahasiswa_status" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer justify-content-between">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary">
                            <i class="fas fa-times mr-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

            $(document).on('click', '.toggle-password', function() {
                const passwordInput = $(this).closest('.input-group').find('input');
                const icon = $(this).find('i');
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Password strength indicator
            $('#password').on('input', function() {
                const password = $(this).val();
                const meter = $(this).closest('.form-group').find('.password-strength-meter');
                const progressBar = meter.find('.progress-bar');
                const strengthText = meter.find('.strength-text');
                if (password.length > 0) {
                    meter.removeClass('d-none');
                    // Simple strength calculation
                    let strength = 0;
                    if (password.length >= 8) strength += 25;
                    if (password.match(/[A-Z]/)) strength += 25;
                    if (password.match(/[0-9]/)) strength += 25;
                    if (password.match(/[^A-Za-z0-9]/)) strength += 25;
                    progressBar.css('width', strength + '%');
                    // Update strength text and color
                    if (strength < 50) {
                        progressBar.removeClass('bg-warning bg-success').addClass('bg-danger');
                        strengthText.text('Lemah');
                    } else if (strength < 75) {
                        progressBar.removeClass('bg-danger bg-success').addClass('bg-warning');
                        strengthText.text('Sedang');
                    } else {
                        progressBar.removeClass('bg-danger bg-warning').addClass('bg-success');
                        strengthText.text('Kuat');
                    }
                } else {
                    meter.addClass('d-none');
                }
            });

            // Custom file input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Validation
            $("#form-edit").validate({
                rules: {
                    mahasiswa_nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    mahasiswa_nim: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    prodi_id: {
                        required: true
                    },
                    mahasiswa_gender: {
                        required: true
                    },
                    mahasiswa_angkatan: {
                        required: true,
                        min: 2000,
                        max: {{ date('Y') + 5 }},
                        digits: true
                    },
                    mahasiswa_nomor_telepon: {
                        required: true,
                        minlength: 10,
                        maxlength: 15
                    },
                    mahasiswa_agama: {
                        maxlength: 50
                    },
                    mahasiswa_provinsi: {
                        maxlength: 255
                    },
                    mahasiswa_kota: {
                        maxlength: 255
                    },
                    mahasiswa_kecamatan: {
                        maxlength: 255
                    },
                    mahasiswa_desa: {
                        maxlength: 255
                    },
                    mahasiswa_status: {
                        required: true
                    },
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    password: {
                        minlength: 8,
                        maxlength: 50
                    }
                },
                messages: {
                    mahasiswa_nama: {
                        required: "Nama mahasiswa tidak boleh kosong",
                        minlength: "Nama mahasiswa minimal 3 karakter",
                        maxlength: "Nama mahasiswa maksimal 255 karakter"
                    },
                    mahasiswa_nim: {
                        required: "NIM tidak boleh kosong",
                        minlength: "NIM minimal 8 karakter",
                        maxlength: "NIM maksimal 20 karakter"
                    },
                    prodi_id: {
                        required: "Program Studi tidak boleh kosong"
                    },
                    mahasiswa_gender: {
                        required: "Jenis kelamin tidak boleh kosong"
                    },
                    mahasiswa_angkatan: {
                        required: "Angkatan tidak boleh kosong",
                        min: "Angkatan minimal tahun 2000",
                        max: "Angkatan maksimal tahun {{ date('Y') + 5 }}",
                        digits: "Angkatan harus berupa angka"
                    },
                    mahasiswa_nomor_telepon: {
                        required: "Nomor telepon tidak boleh kosong",
                        minlength: "Nomor telepon minimal 10 karakter",
                        maxlength: "Nomor telepon maksimal 15 karakter"
                    },
                    mahasiswa_agama: {
                        maxlength: "Agama maksimal 50 karakter"
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
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                $(form).closest('.modal').modal('hide');
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = window.location.href;
                                });

                                if (typeof dataMahasiswa !== 'undefined') {
                                    dataMahasiswa.ajax.reload();
                                }
                            } else {
                                $('.error-text').text('');
                                $('.form-control').removeClass('is-invalid');
                                
                                if (response.errors) {
                                    $.each(response.errors, function(field, messages) {
                                        $('#error-' + field).text(messages[0]);
                                        $('[name="' + field + '"]').addClass('is-invalid');
                                    });
                                }
                                
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message || 'Terjadi kesalahan saat menyimpan data',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('XHR:', xhr); 
                            console.log('Status:', status); 
                            console.log('Error:', error);
                            
                            let errorMessage = "Terjadi kesalahan pada server";
                            
                            if (xhr.responseJSON) {
                                if (xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                } else if (xhr.responseJSON.errors) {
                                    $('.error-text').text('');
                                    $('.form-control').removeClass('is-invalid');
                                    
                                    $.each(xhr.responseJSON.errors, function(field, messages) {
                                        $('#error-' + field).text(messages[0]);
                                        $('[name="' + field + '"]').addClass('is-invalid');
                                    });
                                    errorMessage = "Validasi gagal, periksa kembali data yang dimasukkan";
                                }
                            } else if (xhr.status === 500) {
                                errorMessage = "Terjadi kesalahan internal server";
                            } else if (xhr.status === 404) {
                                errorMessage = "Data tidak ditemukan";
                            } else if (xhr.status === 422) {
                                errorMessage = "Data yang dikirim tidak valid";
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        },
                        complete: function() {
                            if (Swal.isLoading()) {
                                Swal.close();
                            }
                        }
                    });
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