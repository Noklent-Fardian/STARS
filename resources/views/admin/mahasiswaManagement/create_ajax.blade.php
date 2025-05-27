<div id="modal-master" class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white">
            <h4 class="modal-title font-weight-bold">
                <i class="fas fa-user-plus mr-2"></i> Tambah Data Mahasiswa
            </h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body p-4">
            <form action="{{ route('admin.mahasiswaManagement.storeAjax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Card: Informasi Dasar -->
                    <div class="col-12">
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header bg-light">
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
                                                <input type="text" name="mahasiswa_nama" id="mahasiswa_nama" class="form-control"
                                                    placeholder="Masukkan nama mahasiswa" required>
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
                                                <input type="text" name="mahasiswa_nim" id="mahasiswa_nim" class="form-control"
                                                    placeholder="Masukkan NIM mahasiswa" required>
                                            </div>
                                            <small id="error-mahasiswa_nim" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
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
                                                        <option value="{{ $prodi->id }}">
                                                            {{ $prodi->prodi_nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <small id="error-prodi_id" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                                        <option value="{{ $semester->id }}">
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
                                    <div class="col-md-6">
                                        <!-- Jenis Kelamin -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white"><i class="fas fa-venus-mars"></i></span>
                                                </div>
                                                <select name="mahasiswa_gender" id="mahasiswa_gender" class="form-control" required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Laki-laki">Laki-laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                            <small id="error-mahasiswa_gender" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Angkatan -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Angkatan <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-success text-white"><i class="fas fa-calendar"></i></span>
                                                </div>
                                                <input type="number" name="mahasiswa_angkatan" id="mahasiswa_angkatan" 
                                                    class="form-control" placeholder="Masukkan tahun angkatan" 
                                                    min="2000" max="{{ date('Y') + 5 }}" required>
                                            </div>
                                            <small id="error-mahasiswa_angkatan" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Nomor Telepon -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nomor Telepon <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-success text-white"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" name="mahasiswa_nomor_telepon" id="mahasiswa_nomor_telepon" class="form-control"
                                                    placeholder="Masukkan nomor telepon" required>
                                            </div>
                                            <small id="error-mahasiswa_nomor_telepon" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Agama -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Agama</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-warning text-white"><i class="fas fa-pray"></i></span>
                                                </div>
                                                <input type="text" name="mahasiswa_agama" id="mahasiswa_agama" class="form-control"
                                                    placeholder="Masukkan agama">
                                            </div>
                                            <small id="error-mahasiswa_agama" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card: Alamat -->
                    <div class="col-12">
                        <div class="card card-success card-outline mb-4">
                            <div class="card-header bg-light">
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
                                                <input type="text" name="mahasiswa_provinsi" id="mahasiswa_provinsi" class="form-control"
                                                    placeholder="Masukkan provinsi">
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
                                                <input type="text" name="mahasiswa_kota" id="mahasiswa_kota" class="form-control"
                                                    placeholder="Masukkan kota/kabupaten">
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
                                                <input type="text" name="mahasiswa_kecamatan" id="mahasiswa_kecamatan" class="form-control"
                                                    placeholder="Masukkan kecamatan">
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
                                                <input type="text" name="mahasiswa_desa" id="mahasiswa_desa" class="form-control"
                                                    placeholder="Masukkan desa/kelurahan">
                                            </div>
                                            <small id="error-mahasiswa_desa" class="error-text form-text text-danger"></small>
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
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-2"></i> Simpan
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

    // Custom file input label
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    $("#form-tambah").validate({
        rules: {
            mahasiswa_nama: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            mahasiswa_nim: {
                required: true,
                minlength: 8,
                maxlength: 20,
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
                maxlength: "NIM maksimal 20 karakter",
                remote: "NIM sudah digunakan"
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
                        if (response.msgField) {
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan pada server: ' + error
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