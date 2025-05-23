@empty($prestasi)
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
                            <p class="mb-0">Maaf, data prestasi yang Anda cari tidak ada dalam database.</p>
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
<form action="{{ route('admin.adminKelolaPrestasi.updateAjax', $prestasi->id) }}" method="POST" id="form-edit-prestasi">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-edit mr-2"></i> Edit Data Prestasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">ID Mahasiswa</label>
                    <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                        <option value="" disabled>-- Pilih Mahasiswa --</option>
                        @foreach ($mahasiswas as $mahasiswa)
                            <option value="{{ $mahasiswa->id }}" {{ old('mahasiswa_id', $prestasi->mahasiswa_id) == $mahasiswa->id ? 'selected' : '' }}>
                                {{ $mahasiswa->mahasiswa_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-mahasiswa_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">ID Lomba</label>
                    <select name="lomba_id" id="lomba_id" class="form-control" required>
                        <option value="" disabled>-- Pilih lomba --</option>
                        @foreach ($lombas as $lomba)
                            <option value="{{ $lomba->id }}" {{ old('lomba_id', $lomba->lomba_id) == $lomba->id ? 'selected' : '' }}>
                                {{ $lomba->lomba_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-lomba_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">ID Peringkat</label>
                    <select name="peringkat_id" id="peringkat_id" class="form-control" required>
                        <option value="" disabled>-- Pilih Peringkat --</option>
                        @foreach ($peringkats as $peringkat)
                            <option value="{{ $peringkat->id }}" {{ old('peringkat_id', $peringkat->peringkat_id) == $peringkat->id ? 'selected' : '' }}>
                                {{ $peringkat->peringkat_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-peringkat_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">ID Tingkatan</label>
                    <select name="tingkatan_id" id="tingkatan_id" class="form-control" required>
                        <option value="" disabled>-- Pilih Tingkatan --</option>
                        @foreach ($tingkatans as $tingkatan)
                            <option value="{{ $tingkatan->id }}" {{ old('tingkatan_id', $tingkatan->tingkatan_id) == $tingkatan->id ? 'selected' : '' }}>
                                {{ $tingkatan->tingkatan_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-tingkatan_id" class="error-text form-text text-danger"></small>
                </div>
                @php
                    $fields = [
                        'penghargaan_judul' => 'Nama Penghargaan',
                        'penghargaan_tempat' => 'Tempat',
                        'penghargaan_url' => 'Url Penghargaan',
                        'penghargaan_tanggal_mulai' => 'Tanggal Mulai',
                        'penghargaan_tanggal_selesai' => 'Tanggal Selesai',
                        'penghargaan_jumlah_peserta' => 'Jumlah Peserta',
                        'penghargaan_jumlah_instansi' => 'Jumlah Instansi',
                        'penghargaan_no_surat_tugas' => 'Nomer Surat Tugas',
                        'penghargaan_tanggal_surat_tugas' => 'Tanggal Surat Tugas',
                        'penghargaan_file_surat_tugas' => 'File Surat Tugas',
                        'penghargaan_file_sertifikat' => 'File Sertifikat',
                        'penghargaan_file_poster' => 'File Poster',
                        'penghargaan_photo_kegiatan' => 'Foto Kegiatan',
                        'penghargaan_score' => 'Skor',
                        'penghargaan_visible' => 'Visible',
                    ];
                @endphp

                @foreach ($fields as $field => $label)
                    <div class="form-group">
                        <label class="font-weight-bold">{{ $label }}</label>
                        <input type="{{ str_contains($field, 'tanggal') ? 'date' : 'text' }}" name="{{ $field }}"
                            id="{{ $field }}" class="form-control" placeholder="Masukkan {{ strtolower($label) }}"
                            value="{{ old($field, $prestasi->$field) }}" required>
                        <small id="error-{{ $field }}" class="error-text form-text text-danger"></small>
                    </div>
                @endforeach
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
    $(document).ready(function () {
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded. Please include the SweetAlert2 library.');
            window.Swal = {
                fire: function (opts) {
                    alert(opts.title + '\n' + opts.text);
                }
            };
        }

        // Set minimum end date based on start date
        $('#penghargaan_tanggal_mulai').change(function () {
            const startDate = $(this).val();
            $('#penghargaan_tanggal_selesai').attr('min', startDate);

            if ($('#penghargaan_tanggal_selesai').val() && $('#penghargaan_tanggal_selesai').val() < startDate) {
                $('#penghargaan_tanggal_selesai').val('');
            }
        });

        $('.form-group').each(function (i) {
            $(this).css({ 'opacity': 0, transform: 'translateY(20px)' });
            setTimeout(() => {
                $('.form-group').eq(i).css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.4s ease-out',
                });
            }, 100 * (i + 1));
        });

        if ($.validator) {
            $.validator.addMethod('after', function (value, element, param) {
                var startDate = $(param).val();
                if (!startDate || !value) return true;
                return new Date(value) > new Date(startDate);
            }, 'Tanggal selesai harus setelah tanggal mulai');
        } else {
            console.error('jQuery Validation plugin is not loaded');
        }

        $("#form-edit-prestasi").validate({
            rules: {
                mahasiswa_id: { required: true },
                lomba_id: { required: true },
                peringkat_id: { required: true },
                tingkatan_id: { required: true },
                penghargaan_judul: { required: true, maxlength: 255 },
                penghargaan_tempat: { required: true, maxlength: 255 },
                penghargaan_url: {
                    required: true,
                    url: true,
                },
                penghargaan_tanggal_mulai: {
                    required: true,
                    date: true,
                },
                penghargaan_tanggal_selesai: {
                    required: true,
                    date: true,
                    after: "#penghargaan_tanggal_mulai",
                },
                penghargaan_jumlah_peserta: { required: true, maxlength: 255 },
                penghargaan_jumlah_instansi: { required: true, maxlength: 255 },
                penghargaan_no_surat_tugas: { required: true, maxlength: 255 },
                penghargaan_tanggal_surat_tugas: {
                    required: true,
                    date: true,
                },
                penghargaan_file_surat_tugas: { required: true, maxlength: 255 },
                penghargaan_file_sertifikat: { required: true, maxlength: 255 },
                penghargaan_file_poster: { required: true, maxlength: 255 },
                penghargaan_photo_kegiatan: { required: true, maxlength: 255 },
                penghargaan_score: { required: true, maxlength: 255 },
                penghargaan_visible: { required: true, maxlength: 255 },
            },
            messages: {
                mahasiswa_id: { required: "Pilih mahasiswa" },
                lomba_id: { required: "Pilih lomba" },
                peringkat_id: { required: "Pilih peringkat" },
                tingkatan_id: { required: "Pilih tingkatan" },
                penghargaan_judul: {
                    required: "Nama penghargaan tidak boleh kosong",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_tempat: {
                    required: "Tempat tidak boleh kosong",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_url: {
                    required: "Link penghargaan harus diisi",
                    url: "Masukkan URL yang valid",
                },
                penghargaan_tanggal_mulai: {
                    required: "Tanggal mulai harus diisi",
                    date: "Format tanggal tidak valid",
                },
                penghargaan_tanggal_selesai: {
                    required: "Tanggal selesai harus diisi",
                    date: "Format tanggal tidak valid",
                    after: "Tanggal selesai harus setelah tanggal mulai",
                },
                penghargaan_jumlah_peserta: {
                    required: "Jumlah peserta harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_jumlah_instansi: {
                    required: "Jumlah instansi harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_no_surat_tugas: {
                    required: "Nomer surat harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_tanggal_surat_tugas: {
                    required: "Tanggal surat tugas harus diisi",
                    date: "Format tanggal tidak valid",
                },
                penghargaan_file_surat_tugas: {
                    required: "File surat tugas harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_file_sertifikat: {
                    required: "File sertifikat harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_file_poster: {
                    required: "File poster harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_photo_kegiatan: {
                    required: "Foto kegiatan harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_score: {
                    required: "Skor penghargaan harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
                penghargaan_visible: {
                    required: "Visible harus diisi",
                    maxlength: "Maksimal 255 karakter",
                },
            },
            errorPlacement: function (error, element) {
                var id = element.attr('id');
                $('#error-' + id).html(error);
            },
            submitHandler: function (form) {
                $(form).find('button[type="submit"]').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...'
                );

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        $(form).find('button[type="submit"]').prop('disabled', false).html(
                            '<i class="fas fa-save mr-2"></i> Simpan Perubahan'
                        );

                        if (response.status) {
                            $('#myModal').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Data prestasi berhasil diperbarui!',
                                timer: 1500,
                                showConfirmButton: false,
                                didClose: function () {

                                    // Check if we're on the detail/show page
                                    if ($('.card-header:contains("Detail Prestasi")').length > 0) {
                                        // Update the detail view with new lomba data
                                        updatePrestasiDetailView({
                                            judul: $('#penghargaan_judul').val(),
                                            tempat: $('#penghargaan_tempat').val(),
                                            url: $('#penghargaan_url').val(),
                                            tanggalMulai: $('#lomba_tanggal_mulai').val(),
                                            tanggalSelesai: $('#lomba_tanggal_selesai').val(),
                                            jumlahPeserta: $('#penghargaan_jumlah_peserta').val(),
                                            jumlahInstansi: $('#penghargaan_jumlah_instansi').val(),
                                            noSuratTugas: $('#penghargaan_no_surat_tugas').val(),
                                            tanggalSuratTugas: $('#penghargaan_tanggal_surat_tugas').val(),
                                            fileSuratTugas: $('#penghargaan_file_surat_tugas').val(),
                                            fileSertifikat: $('#penghargaan_file_sertifikat').val(),
                                            filePoster: $('#penghargaan_file_poster').val(),
                                            fotoKegiatan: $('#penghargaan_photo_kegiatan').val(),
                                            skor: $('#penghargaan_score').val(),
                                            visible: $('#penghargaan_visible').val(),
                                        });
                                    } else {
                                        // If on index page, reload the DataTable
                                        if (typeof dataPrestasi !== 'undefined') {
                                            dataPrestasi.ajax.reload();
                                        }
                                    }
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Terjadi kesalahan saat menyimpan data',
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        $(form).find('button[type="submit"]').prop('disabled', false).html(
                            '<i class="fas fa-save mr-2"></i> Simpan Perubahan'
                        );

                        console.error('AJAX Error:', xhr.responseText);

                        if (xhr.status === 422 && xhr.responseJSON) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                $('#error-' + field.replace(/\./g, '_')).text(errors[field][0]);
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: 'Silakan periksa kembali form input Anda',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                            });
                        }
                    }
                });

                function updateLombaDetailView(data) {
                    $('h4.font-weight-bold').text(data.judul);
                    $('#detail-tempat').text(data.tempat);
                    $('#detail-url').text(data.url);
                    $('#detail-tanggal-mulai').text(new Date(data.tanggalMulai).toLocaleDateString('id-ID'));
                    $('#detail-tanggal-selesai').text(new Date(data.tanggalSelesai).toLocaleDateString('id-ID'));
                    $('#detail-jumlah-peserta').attr('href', data.jumlahPeserta).text(data.jumlahPeserta);
                    $('#detail-jumlah-instansi').attr('href', data.jumlahInstansi).text(data.jumlahInstansi);
                    $('#detail-no-surat-tugas').attr('href', data.noSuratTugas).text(data.noSuratTugas);
                    $('#detail-tanggal-surat-tugas').text(new Date(data.tanggalSuratTugas).toLocaleDateString('id-ID'));
                    $('#detail-file-surat-tugas').attr('href', data.fileSuratTugas).text(data.fileSuratTugas);
                    $('#detail-file-poster').attr('href', data.filePoster).text(data.filePoster);
                    $('#detail-photo-kegiatan').attr('href', data.fotoKegiatan).text(data.fotoKegiatan);
                    $('#detail-score').attr('href', data.skor).text(data.skor);
                    $('#detail-visible').attr('href', data.visible).text(data.visible);
                    $('.detail-info').css({
                        'background-color': '#fffde7',
                        'transition': 'background-color 1s'
                    });

                    setTimeout(() => {
                        $('.detail-info').css('background-color', '');
                    }, 2000);
                }
            }
        });
    });
</script>
@endif