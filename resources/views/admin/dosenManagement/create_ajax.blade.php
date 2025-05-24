<div id="modal-master" class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white">
            <h4 class="modal-title font-weight-bold">
                <i class="fas fa-user-plus mr-2"></i> Tambah Data Dosen
            </h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="modal-body p-4">
            <form action="{{ route('admin.dosenManagement.storeAjax') }}" method="POST" id="form-tambah" enctype="multipart/form-data">
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
                                        <!-- Nama Dosen -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Nama Dosen <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" name="dosen_nama" id="dosen_nama" class="form-control"
                                                    placeholder="Masukkan nama dosen" required>
                                            </div>
                                            <small id="error-dosen_nama" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- NIP -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">NIP <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <input type="text" name="dosen_nip" id="dosen_nip" class="form-control"
                                                    placeholder="Masukkan NIP dosen" required>
                                            </div>
                                            <small id="error-dosen_nip" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Program Studi (mengganti Status) -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Program Studi <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-secondary text-white"><i class="fas fa-graduation-cap"></i></span>
                                                </div>
                                                <select name="prodi_id" id="prodi_id" class="form-control" required>
                                                    <option value="">Pilih Program Studi Homebase</option>
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
                                        <!-- Jenis Kelamin -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Jenis Kelamin <span class="text-danger">*</span></label>
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
                                                <input type="text" name="dosen_nomor_telepon" id="dosen_nomor_telepon" class="form-control"
                                                    placeholder="Masukkan nomor telepon" required>
                                            </div>
                                            <small id="error-dosen_nomor_telepon" class="error-text form-text text-danger"></small>
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
                                                <input type="text" name="dosen_agama" id="dosen_agama" class="form-control"
                                                    placeholder="Masukkan agama">
                                            </div>
                                            <small id="error-dosen_agama" class="error-text form-text text-danger"></small>
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
                                                <input type="text" name="dosen_provinsi" id="dosen_provinsi" class="form-control"
                                                    placeholder="Masukkan provinsi">
                                            </div>
                                            <small id="error-dosen_provinsi" class="error-text form-text text-danger"></small>
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
                                                <input type="text" name="dosen_kota" id="dosen_kota" class="form-control"
                                                    placeholder="Masukkan kota/kabupaten">
                                            </div>
                                            <small id="error-dosen_kota" class="error-text form-text text-danger"></small>
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
                                                <input type="text" name="dosen_kecamatan" id="dosen_kecamatan" class="form-control"
                                                    placeholder="Masukkan kecamatan">
                                            </div>
                                            <small id="error-dosen_kecamatan" class="error-text form-text text-danger"></small>
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
                                                <input type="text" name="dosen_desa" id="dosen_desa" class="form-control"
                                                    placeholder="Masukkan desa/kelurahan">
                                            </div>
                                            <small id="error-dosen_desa" class="error-text form-text text-danger"></small>
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
            prodi_id: {
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
            prodi_id: {
                required: "Program Studi tidak boleh kosong"
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

                        if (typeof dataDosen !== 'undefined') {
                            dataDosen.ajax.reload();
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
