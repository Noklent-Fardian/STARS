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
                                            <label class="font-weight-bold">Prodi Homebase <span class="text-danger">*</span></label>
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
                                                <select name="dosen_agama" id="dosen_agama" class="form-control" required>
                                                    <option value="">-- Pilih Agama --</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Katolik">Katolik</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Buddha">Buddha</option>
                                                    <option value="Konghucu">Konghucu</option>
                                                </select>
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
                                            <label class="font-weight-bold">Provinsi <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                </div>
                                                <select name="dosen_provinsi" id="dosen_provinsi" class="form-control" required>
                                                    <option value="">Pilih Provinsi</option>
                                                </select>
                                            </div>
                                            <small id="error-dosen_provinsi" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Kota/Kabupaten -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Kota/Kabupaten <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                </div>
                                                <select name="dosen_kota" id="dosen_kota" class="form-control" disabled required>
                                                    <option value="">Pilih Provinsi terlebih dahulu</option>
                                                </select>
                                            </div>
                                            <small id="error-dosen_kota" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Kecamatan -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Kecamatan <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                </div>
                                                <select name="dosen_kecamatan" id="dosen_kecamatan" class="form-control" disabled required>
                                                    <option value="">Pilih Kota/Kabupaten terlebih dahulu</option>
                                                </select>
                                            </div>
                                            <small id="error-dosen_kecamatan" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Desa/Kelurahan -->
                                        <div class="form-group">
                                            <label class="font-weight-bold">Desa/Kelurahan <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                </div>
                                                <select name="dosen_desa" id="dosen_desa" class="form-control" disabled required>
                                                    <option value="">Pilih Kecamatan terlebih dahulu</option>
                                                </select>
                                            </div>
                                            <small id="error-dosen_desa" class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="dosen_provinsi_text" id="dosen_provinsi_text">
                                <input type="hidden" name="dosen_kota_text" id="dosen_kota_text">
                                <input type="hidden" name="dosen_kecamatan_text" id="dosen_kecamatan_text">
                                <input type="hidden" name="dosen_desa_text" id="dosen_desa_text">
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
    // Menggunakan API dari https://www.emsifa.com/api-wilayah-indonesia/
    // dengan proxy melalui server sendiri untuk menghindari CORS
    
    // Load Provinsi saat modal dibuka
    $('#myModal').on('shown.bs.modal', function() {
        loadProvinsi();
    });
    
    // Fungsi untuk load provinsi
    function loadProvinsi() {
        $('#dosen_provinsi').html('<option value="">Memuat provinsi...</option>');
        
        // Menggunakan endpoint dari server sendiri yang akan memproxy request
        $.ajax({
            url: '/api/wilayah/provinces', // Ganti dengan endpoint di server Anda
            method: 'GET',
            success: function(data) {
                $('#dosen_provinsi').html('<option value="">Pilih Provinsi</option>');
                $.each(data, function(index, provinsi) {
                    $('#dosen_provinsi').append(`<option value="${provinsi.id}" data-name="${provinsi.name}">${provinsi.name}</option>`);
                });
            },
            error: function() {
                $('#dosen_provinsi').html('<option value="">Gagal memuat provinsi</option>');
            }
        });
    }
    
    // Ketika provinsi dipilih
    $('#dosen_provinsi').change(function() {
        const selectedOption = $(this).find('option:selected');
        const provinsiId = $(this).val();
        const provinsiText = selectedOption.text();
        
        $('#dosen_provinsi_text').val(provinsiText); // Simpan teks provinsi
        
        if (provinsiId) {
            loadKabupaten(provinsiId);
            $('#dosen_kota').prop('disabled', false);
            resetWilayah('kecamatan');
            resetWilayah('desa');
        } else {
            resetWilayah('kota');
            resetWilayah('kecamatan');
            resetWilayah('desa');
        }
    });
    
    // Ketika kabupaten/kota dipilih
    $('#dosen_kota').change(function() {
        const selectedOption = $(this).find('option:selected');
        const kotaId = $(this).val();
        const kotaText = selectedOption.text();
        
        $('#dosen_kota_text').val(kotaText); // Simpan teks kota
        
        if (kotaId) {
            loadKecamatan(kotaId);
            $('#dosen_kecamatan').prop('disabled', false);
            resetWilayah('desa');
        } else {
            resetWilayah('kecamatan');
            resetWilayah('desa');
        }
    });
    
    // Ketika kecamatan dipilih
    $('#dosen_kecamatan').change(function() {
        const selectedOption = $(this).find('option:selected');
        const kecamatanId = $(this).val();
        const kecamatanText = selectedOption.text();
        
        $('#dosen_kecamatan_text').val(kecamatanText); // Simpan teks kecamatan
        
        if (kecamatanId) {
            loadDesa(kecamatanId);
            $('#dosen_desa').prop('disabled', false);
        } else {
            resetWilayah('desa');
        }
    });
    
    // Ketika desa dipilih
    $('#dosen_desa').change(function() {
        const selectedOption = $(this).find('option:selected');
        const desaText = selectedOption.text();
        $('#dosen_desa_text').val(desaText); // Simpan teks desa
    });
    
    // Fungsi untuk load kabupaten/kota
    function loadKabupaten(provinsiId) {
        $('#dosen_kota').html('<option value="">Memuat kabupaten/kota...</option>').prop('disabled', true);
        
        $.ajax({
            url: '/api/wilayah/regencies/' + provinsiId, // Ganti dengan endpoint di server Anda
            method: 'GET',
            success: function(data) {
                $('#dosen_kota').html('<option value="">Pilih Kabupaten/Kota</option>');
                $.each(data, function(index, kota) {
                    $('#dosen_kota').append(`<option value="${kota.id}" data-name="${kota.name}">${kota.name}</option>`);
                });
                $('#dosen_kota').prop('disabled', false);
            },
            error: function() {
                $('#dosen_kota').html('<option value="">Gagal memuat kabupaten/kota</option>').prop('disabled', true);
            }
        });
    }
    
    // Fungsi untuk load kecamatan
    function loadKecamatan(kotaId) {
        $('#dosen_kecamatan').html('<option value="">Memuat kecamatan...</option>').prop('disabled', true);
        
        $.ajax({
            url: '/api/wilayah/districts/' + kotaId, // Ganti dengan endpoint di server Anda
            method: 'GET',
            success: function(data) {
                $('#dosen_kecamatan').html('<option value="">Pilih Kecamatan</option>');
                $.each(data, function(index, kecamatan) {
                    $('#dosen_kecamatan').append(`<option value="${kecamatan.id}" data-name="${kecamatan.name}">${kecamatan.name}</option>`);
                });
                $('#dosen_kecamatan').prop('disabled', false);
            },
            error: function() {
                $('#dosen_kecamatan').html('<option value="">Gagal memuat kecamatan</option>').prop('disabled', true);
            }
        });
    }
    
    // Fungsi untuk load desa/kelurahan
    function loadDesa(kecamatanId) {
        $('#dosen_desa').html('<option value="">Memuat desa/kelurahan...</option>').prop('disabled', true);
        
        $.ajax({
            url: '/api/wilayah/villages/' + kecamatanId, // Ganti dengan endpoint di server Anda
            method: 'GET',
            success: function(data) {
                $('#dosen_desa').html('<option value="">Pilih Desa/Kelurahan</option>');
                $.each(data, function(index, desa) {
                    $('#dosen_desa').append(`<option value="${desa.id}" data-name="${desa.name}">${desa.name}</option>`);
                });
                $('#dosen_desa').prop('disabled', false);
            },
            error: function() {
                $('#dosen_desa').html('<option value="">Gagal memuat desa/kelurahan</option>').prop('disabled', true);
            }
        });
    }
    
    // Fungsi untuk reset wilayah
    function resetWilayah(tingkat) {
        const element = $('#dosen_' + tingkat);
        element.html('<option value="">Pilih ' + (tingkat === 'kota' ? 'Kota/Kabupaten' : 
                    tingkat === 'kecamatan' ? 'Kecamatan' : 'Desa/Kelurahan') + '</option>')
               .prop('disabled', true)
               .val('')
               .trigger('change');
               
        // Reset hidden field
        $('#dosen_' + tingkat + '_nama').val('');
    }
    
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

    $("#dosen_nama").on("input", function () {
        let value = $(this).val();
        let cleaned = value.replace(/[^a-zA-Z\s.,]/g, ""); // hapus karakter lain
        if (value !== cleaned) {
            $(this).val(cleaned);
        }
    });

    $("#dosen_nip").on("input", function () {
        let value = $(this).val();
        let cleaned = value.replace(/[^0-9]/g, ""); // hanya angka
        if (value !== cleaned) {
            $(this).val(cleaned);
        }
    });

    $("#dosen_nomor_telepon").on("input", function () {
        let value = $(this).val();
        let cleaned = value.replace(/[^0-9]/g, ""); // hanya angka
        if (value !== cleaned) {
            $(this).val(cleaned);
        }
    });

    $("#form-tambah").validate({
        rules: {
            dosen_nama: {
                required: true,
                minlength: 3,
                maxlength: 255,
                pattern: /^[a-zA-Z\s.,]+$/
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
                required: true
            },
            dosen_kota: {
                required: true
            },
            dosen_kecamatan: {
                required: true
            },
            dosen_desa: {
                required: true
            }
        },
        messages: {
            dosen_nama: {
                required: "Nama dosen tidak boleh kosong",
                minlength: "Nama dosen minimal 3 karakter",
                maxlength: "Nama dosen maksimal 255 karakter",
                pattern: "Hanya huruf, spasi, titik, dan koma yang diperbolehkan"
            },
            dosen_nip: {
                required: "NIP tidak boleh kosong",
                minlength: "NIP minimal 10 karakter",
                maxlength: "NIP maksimal 20 karakter"
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
            },
            dosen_provinsi: {
                required: "Provinsi tidak boleh kosong"
            },
            dosen_kota: {
                required: "Kota/Kabupaten tidak boleh kosong"
            },
            dosen_kecamatan: {
                required: "Kecamatan tidak boleh kosong"
            },
            dosen_desa: {
                required: "Desa/Kelurahan tidak boleh kosong"
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