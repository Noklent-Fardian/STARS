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
                                        <div class="col-md-6">
                                            <!-- Program Studi -->
                                            <div class="form-group">
                                                <label class="font-weight-bold">Program Studi</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-secondary text-white"><i class="fas fa-graduation-cap"></i></span>
                                                    </div>
                                                    <select name="prodi_id" id="prodi_id" class="form-control">
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
                                                        @foreach ($semester as $semester)
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
                                                        <option value="Laki-laki" {{ $mahasiswa->mahasiswa_gender === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="Perempuan" {{ $mahasiswa->mahasiswa_gender === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                                    <input value="{{ $mahasiswa->mahasiswa_angkatan }}" type="number" name="mahasiswa_angkatan" id="mahasiswa_angkatan" class="form-control" placeholder="Masukkan tahun angkatan" min="2000" max="{{ date('Y') + 5 }}" required>
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
                                                    <input value="{{ $mahasiswa->mahasiswa_nomor_telepon }}" type="text" name="mahasiswa_nomor_telepon" id="mahasiswa_nomor_telepon" class="form-control" placeholder="Masukkan nomor telepon" required>
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
                                                    <select name="mahasiswa_agama" id="mahasiswa_agama" class="form-control">
                                                        <option value="">-- Pilih Agama --</option>
                                                        <option value="Islam" {{ $mahasiswa->mahasiswa_agama === 'Islam' ? 'selected' : '' }}>Islam</option>
                                                        <option value="Kristen" {{ $mahasiswa->mahasiswa_agama === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                        <option value="Katolik" {{ $mahasiswa->mahasiswa_agama === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                        <option value="Hindu" {{ $mahasiswa->mahasiswa_agama === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                        <option value="Buddha" {{ $mahasiswa->mahasiswa_agama === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                        <option value="Konghucu" {{ $mahasiswa->mahasiswa_agama === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                                    </select>
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
                                                <label class="font-weight-bold">Provinsi <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <select name="mahasiswa_provinsi" id="mahasiswa_provinsi" class="form-control" required>
                                                        <option value="">Memuat provinsi...</option>
                                                    </select>
                                                </div>
                                                <small id="error-mahasiswa_provinsi" class="error-text form-text text-danger"></small>
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
                                                    <select name="mahasiswa_kota" id="mahasiswa_kota" class="form-control" disabled required>
                                                        <option value="">Pilih Provinsi terlebih dahulu</option>
                                                    </select>
                                                </div>
                                                <small id="error-mahasiswa_kota" class="error-text form-text text-danger"></small>
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
                                                    <select name="mahasiswa_kecamatan" id="mahasiswa_kecamatan" class="form-control" disabled required>
                                                        <option value="">Pilih Kota/Kabupaten terlebih dahulu</option>
                                                    </select>
                                                </div>
                                                <small id="error-mahasiswa_kecamatan" class="error-text form-text text-danger"></small>
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
                                                    <select name="mahasiswa_desa" id="mahasiswa_desa" class="form-control" disabled required>
                                                        <option value="">Pilih Kecamatan terlebih dahulu</option>
                                                    </select>
                                                </div>
                                                <small id="error-mahasiswa_desa" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="mahasiswa_provinsi_text" id="mahasiswa_provinsi_text" value="{{ $mahasiswa->mahasiswa_provinsi }}">
                                    <input type="hidden" name="mahasiswa_kota_text" id="mahasiswa_kota_text" value="{{ $mahasiswa->mahasiswa_kota }}">
                                    <input type="hidden" name="mahasiswa_kecamatan_text" id="mahasiswa_kecamatan_text" value="{{ $mahasiswa->mahasiswa_kecamatan }}">
                                    <input type="hidden" name="mahasiswa_desa_text" id="mahasiswa_desa_text" value="{{ $mahasiswa->mahasiswa_desa }}">
                                </div>
                            </div>
                        </div>
                        <!-- Card: Status dan Reset Password -->
                        <div class="col-12">
                            <div class="card card-info card-outline mb-4">
                                <div class="card-header bg-info">
                                    <h5 class="card-title font-weight-bold mb-0 text-white">
                                        <i class="fas fa-user-check mr-2"></i> Status dan Reset Password
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
                                        <div class="col-md-1"></div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Status <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-info text-white"><i class="fas fa-user-check"></i></span>
                                                    </div>
                                                    <select name="mahasiswa_status" id="mahasiswa_status" class="form-control" required>
                                                        <option value="">Pilih Status</option>
                                                        <option value="Aktif" {{ $mahasiswa->mahasiswa_status === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="Tidak Aktif" {{ $mahasiswa->mahasiswa_status === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                        <option value="Cuti" {{ $mahasiswa->mahasiswa_status === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                                    </select>
                                                </div>
                                                <small id="error-mahasiswa_status" class="error-text form-text text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
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
        // Data alamat yang sudah ada dari database (berupa ID)
        const existingAddress = {
            provinsi: '{{ $mahasiswa->mahasiswa_provinsi }}', // Field ini berisi ID wilayah
            kota: '{{ $mahasiswa->mahasiswa_kota }}',
            kecamatan: '{{ $mahasiswa->mahasiswa_kecamatan }}',
            desa: '{{ $mahasiswa->mahasiswa_desa }}'
        };
        
        // Load provinsi saat modal shown
        $('#myModal').on('shown.bs.modal', function() {
            loadProvinsi();
        });

        $("#mahasiswa_nama").on("input", function () {
            let value = $(this).val();
            let cleaned = value.replace(/[^a-zA-Z\s.,]/g, ""); // hapus karakter lain
            if (value !== cleaned) {
                $(this).val(cleaned);
            }
        });

        $("#mahasiswa_nim").on("input", function () {
            let value = $(this).val();
            let cleaned = value.replace(/[^0-9]/g, ""); // hanya angka
            if (value !== cleaned) {
                $(this).val(cleaned);
            }
        });

        $("#mahasiswa_nomor_telepon").on("input", function () {
            let value = $(this).val();
            let cleaned = value.replace(/[^0-9]/g, ""); // hanya angka
            if (value !== cleaned) {
                $(this).val(cleaned);
            }
        });
        
        // Fungsi untuk load provinsi
        function loadProvinsi() {
            $('#mahasiswa_provinsi').html('<option value="">Memuat provinsi...</option>');
            
            $.ajax({
                url: '/api/wilayah/provinces',
                method: 'GET',
                success: function(data) {
                    $('#mahasiswa_provinsi').html('<option value="">Pilih Provinsi</option>');
                    $.each(data, function(index, provinsi) {
                        $('#mahasiswa_provinsi').append(`<option value="${provinsi.id}" data-name="${provinsi.name}">${provinsi.name}</option>`);
                    });

                    console.log('Existing Address:', existingAddress);
                    
                    // Set provinsi berdasarkan ID dan trigger cascade loading
                    if (existingAddress.provinsi) {
                        setSelectedById('#mahasiswa_provinsi', existingAddress.provinsi, function() {
                            loadKabupaten(existingAddress.provinsi, existingAddress.kota);
                        });
                    }
                },
                error: function() {
                    $('#mahasiswa_provinsi').html('<option value="">Gagal memuat provinsi</option>');
                    console.error('Gagal memuat data provinsi');
                }
            });
        }
        
        // Fungsi untuk set selected option berdasarkan ID
        function setSelectedById(selector, idValue, callback) {
            const selectElement = $(selector);
            
            // Set value dan trigger change
            selectElement.val(idValue);
            
            // Update hidden text field
            const selectedText = selectElement.find('option:selected').text();
            const fieldName = selector.replace('#mahasiswa_', '').replace('#', '');
            $('#mahasiswa_' + fieldName + '_text').val(selectedText);
            
            // Trigger change event
            selectElement.trigger('change');
            
            if (typeof callback === 'function') {
                // Berikan delay untuk memastikan DOM sudah terupdate
                setTimeout(callback, 300);
            }
        }
        
        // Event handlers untuk dropdown changes
        $('#mahasiswa_provinsi').change(function() {
            const selectedOption = $(this).find('option:selected');
            const provinsiId = $(this).val();
            const provinsiText = selectedOption.text();
            
            $('#mahasiswa_provinsi_text').val(provinsiText);
            
            if (provinsiId) {
                loadKabupaten(provinsiId);
                $('#mahasiswa_kota').prop('disabled', false);
                resetWilayah('kecamatan');
                resetWilayah('desa');
            } else {
                resetWilayah('kota');
                resetWilayah('kecamatan');
                resetWilayah('desa');
            }
        });
        
        $('#mahasiswa_kota').change(function() {
            const selectedOption = $(this).find('option:selected');
            const kotaId = $(this).val();
            const kotaText = selectedOption.text();
            
            $('#mahasiswa_kota_text').val(kotaText);
            
            if (kotaId) {
                loadKecamatan(kotaId);
                $('#mahasiswa_kecamatan').prop('disabled', false);
                resetWilayah('desa');
            } else {
                resetWilayah('kecamatan');
                resetWilayah('desa');
            }
        });
        
        $('#mahasiswa_kecamatan').change(function() {
            const selectedOption = $(this).find('option:selected');
            const kecamatanId = $(this).val();
            const kecamatanText = selectedOption.text();
            
            $('#mahasiswa_kecamatan_text').val(kecamatanText);
            
            if (kecamatanId) {
                loadDesa(kecamatanId);
                $('#mahasiswa_desa').prop('disabled', false);
            } else {
                resetWilayah('desa');
            }
        });
        
        $('#mahasiswa_desa').change(function() {
            const selectedOption = $(this).find('option:selected');
            const desaText = selectedOption.text();
            $('#mahasiswa_desa_text').val(desaText);
        });
        
        // Fungsi untuk load kabupaten dengan auto-select
        function loadKabupaten(provinsiId, autoSelectKota = null) {
            $('#mahasiswa_kota').html('<option value="">Memuat kabupaten/kota...</option>').prop('disabled', true);
            
            $.ajax({
                url: '/api/wilayah/regencies/' + provinsiId,
                method: 'GET',
                success: function(data) {
                    $('#mahasiswa_kota').html('<option value="">Pilih Kabupaten/Kota</option>');
                    $.each(data, function(index, kota) {
                        $('#mahasiswa_kota').append(`<option value="${kota.id}" data-name="${kota.name}">${kota.name}</option>`);
                    });
                    $('#mahasiswa_kota').prop('disabled', false);
                    
                    // Auto-select kota berdasarkan ID
                    if (autoSelectKota) {
                        setSelectedById('#mahasiswa_kota', autoSelectKota, function() {
                            loadKecamatan(autoSelectKota, existingAddress.kecamatan);
                        });
                    }
                },
                error: function() {
                    $('#mahasiswa_kota').html('<option value="">Gagal memuat kabupaten/kota</option>').prop('disabled', true);
                    console.error('Gagal memuat data kabupaten/kota');
                }
            });
        }
        
        // Fungsi untuk load kecamatan dengan auto-select
        function loadKecamatan(kotaId, autoSelectKecamatan = null) {
            $('#mahasiswa_kecamatan').html('<option value="">Memuat kecamatan...</option>').prop('disabled', true);
            
            $.ajax({
                url: '/api/wilayah/districts/' + kotaId,
                method: 'GET',
                success: function(data) {
                    $('#mahasiswa_kecamatan').html('<option value="">Pilih Kecamatan</option>');
                    $.each(data, function(index, kecamatan) {
                        $('#mahasiswa_kecamatan').append(`<option value="${kecamatan.id}" data-name="${kecamatan.name}">${kecamatan.name}</option>`);
                    });
                    $('#mahasiswa_kecamatan').prop('disabled', false);
                    
                    // Auto-select kecamatan berdasarkan ID
                    if (autoSelectKecamatan) {
                        setSelectedById('#mahasiswa_kecamatan', autoSelectKecamatan, function() {
                            loadDesa(autoSelectKecamatan, existingAddress.desa);
                        });
                    }
                },
                error: function() {
                    $('#mahasiswa_kecamatan').html('<option value="">Gagal memuat kecamatan</option>').prop('disabled', true);
                    console.error('Gagal memuat data kecamatan');
                }
            });
        }
        
        // Fungsi untuk load desa dengan auto-select
        function loadDesa(kecamatanId, autoSelectDesa = null) {
            $('#mahasiswa_desa').html('<option value="">Memuat desa/kelurahan...</option>').prop('disabled', true);
            
            $.ajax({
                url: '/api/wilayah/villages/' + kecamatanId,
                method: 'GET',
                success: function(data) {
                    $('#mahasiswa_desa').html('<option value="">Pilih Desa/Kelurahan</option>');
                    $.each(data, function(index, desa) {
                        $('#mahasiswa_desa').append(`<option value="${desa.id}" data-name="${desa.name}">${desa.name}</option>`);
                    });
                    $('#mahasiswa_desa').prop('disabled', false);
                    
                    // Auto-select desa berdasarkan ID
                    if (autoSelectDesa) {
                        setSelectedById('#mahasiswa_desa', autoSelectDesa);
                    }
                },
                error: function() {
                    $('#mahasiswa_desa').html('<option value="">Gagal memuat desa/kelurahan</option>').prop('disabled', true);
                    console.error('Gagal memuat data desa/kelurahan');
                }
            });
        }
        
        // Fungsi untuk reset wilayah
        function resetWilayah(tingkat) {
            const element = $('#mahasiswa_' + tingkat);
            const placeholder = tingkat === 'kota' ? 'Kota/Kabupaten' : 
                            tingkat === 'kecamatan' ? 'Kecamatan' : 'Desa/Kelurahan';
            
            element.html(`<option value="">Pilih ${placeholder}</option>`)
                .prop('disabled', true)
                .val('');
                
            // Reset hidden field
            $('#mahasiswa_' + tingkat + '_text').val('');
            
            // Reset dependent fields
            if (tingkat === 'kota') {
                resetWilayah('kecamatan');
                resetWilayah('desa');
            } else if (tingkat === 'kecamatan') {
                resetWilayah('desa');
            }
        }
            
        // Debug function untuk melihat data yang dimuat
        function debugAddressData() {
            console.log('Existing Address Data:', existingAddress);
            console.log('Current Selected Values:', {
                provinsi: $('#mahasiswa_provinsi').val(),
                kota: $('#mahasiswa_kota').val(),
                kecamatan: $('#mahasiswa_kecamatan').val(),
                desa: $('#mahasiswa_desa').val()
            });
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
                    minlength: 5,
                    maxlength: 20
                },
                mahasiswa_gender: {
                    required: true
                },
                mahasiswa_angkatan: {
                    required: true,
                    min: 2000,
                    max: {{ date('Y') + 5 }}
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
                    required: true
                },
                mahasiswa_kota: {
                    required: true
                },
                mahasiswa_kecamatan: {
                    required: true
                },
                mahasiswa_desa: {
                    required: true
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
                    minlength: "NIM minimal 5 karakter",
                    maxlength: "NIM maksimal 20 karakter"
                },
                mahasiswa_gender: {
                    required: "Jenis kelamin tidak boleh kosong"
                },
                mahasiswa_angkatan: {
                    required: "Angkatan tidak boleh kosong",
                    min: "Angkatan minimal tahun 2000",
                    max: "Angkatan maksimal tahun {{ date('Y') + 5 }}"
                },
                mahasiswa_nomor_telepon: {
                    required: "Nomor telepon tidak boleh kosong",
                    minlength: "Nomor telepon minimal 10 karakter",
                    maxlength: "Nomor telepon maksimal 15 karakter"
                },
                mahasiswa_provinsi: {
                    required: "Provinsi tidak boleh kosong"
                },
                mahasiswa_kota: {
                    required: "Kota/Kabupaten tidak boleh kosong"
                },
                mahasiswa_kecamatan: {
                    required: "Kecamatan tidak boleh kosong"
                },
                mahasiswa_desa: {
                    required: "Desa/Kelurahan tidak boleh kosong"
                },
                mahasiswa_status: {
                    required: "Status tidak boleh kosong"
                },
                username: {
                    required: "Username tidak boleh kosong",
                    minlength: "Username minimal 3 karakter",
                    maxlength: "Username maksimal 50 karakter"
                },
                password: {
                    minlength: "Password minimal 8 karakter",
                    maxlength: "Password maksimal 50 karakter"
                }
            },
                submitHandler: function (form) {
                    // Create FormData object for file upload
                    let formData = new FormData(form);
                    
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    if (response.self) {
                                        location.reload();
                                    }
                                });
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