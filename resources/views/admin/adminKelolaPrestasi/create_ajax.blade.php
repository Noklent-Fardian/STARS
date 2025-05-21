<form action="{{ route('admin.adminKelolaPrestasi.storeAjax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Prestasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">

                <div class="form-group">
                    <label class="font-weight-bold">ID Mahasiswa</label>
                    <select name="keahlian_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $mahasiswa)
                            <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->mahasiswa_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-mahasiswa_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">ID Lomba</label>
                    <select name="tingkatan_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Lomba --</option>
                        @foreach($lombas as $lomba)
                            <option value="{{ $lomba->id }}">{{ $lomba->lomba_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-lomba_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">ID Peringkat</label>
                    <select name="semester_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Peringkat --</option>
                        @foreach($peringkats as $peringkat)
                            <option value="{{ $peringkat->id }}">{{ $peringkat->peringkat_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-peringkat_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">ID Tingkatan</label>
                    <select name="semester_id" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Tingkatan --</option>
                        @foreach($tingkatans as $tingkatan)
                            <option value="{{ $tingkatan->id }}">{{ $tingkatan->tingkatan_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-tingkatan_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Nama Penghargaan</label>
                    <input type="text" name="penghargaan_judul" class="form-control" 
                    placeholder="Masukkan judul penghargaan" required>
                    <small id="error-penghargaan_judul" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tempat</label>
                    <input type="text" name="penghargaan_tempat" class="form-control"
                        placeholder="Masukkan tempat lomba" required>
                    <small id="error-penghargaan_tempat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Penghargaan Url</label>
                    <input type="url" name="penghargaan_url" class="form-control" placeholder="Masukkan url penghargaan"
                        required>
                    <small id="error-penghargaan_url" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tanggal Mulai</label>
                    <input type="date" name="penghargaan_tanggal_mulai" id="penghargaan_tanggal_mulai" class="form-control"
                        required>
                    <small id="error-penghargaan_tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tanggal Selesai</label>
                    <input type="date" name="penghargaan_tanggal_selesai" id="penghargaan_tanggal_selesai" class="form-control"
                        required>
                    <small id="error-penghargaan_tanggal_selesai" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Jumlah Peserta</label>
                    <input type="text" name="penghargaan_jumlah_peserta" class="form-control"
                        placeholder="Masukkan jumlah peserta" required>
                    <small id="error-penghargaan_jumlah_peserta" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Jumlah Instansi</label>
                    <input type="text" name="penghargaan_jumlah_instansi" class="form-control" placeholder="Masukkan jumlah instansi"
                        required>
                    <small id="error-penghargaan_jumlah_instansi" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Nomer Surat Tugas</label>
                    <input type="text" name="penghargaan_no_surat_tugas" class="form-control" placeholder="Masukkan nomer surat tugas"
                        required>
                    <small id="error-penghargaan_no_surat_tugas" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tanggal Surat Tugas</label>
                    <input type="date" name="penghargaan_tanggal_surat_tugas" id="penghargaan_tanggal_surat_tugas" class="form-control"
                        required>
                    <small id="error-penghargaan_tanggal_surat_tugas" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">File Surat Tugas</label>
                    <input type="text" name="penghargaan_file_surat_tugas" class="form-control" placeholder="Masukkan file surat tugas"
                        required>
                    <small id="error-penghargaan_file_surat_tugas" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">File Sertifikat</label>
                    <input type="text" name="penghargaan_file_sertifikat" class="form-control" placeholder="Masukkan file sertifikat"
                        required>
                    <small id="error-penghargaan_file_sertifikat" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">File Poster</label>
                    <input type="text" name="penghargaan_file_poster" class="form-control" placeholder="Masukkan file poster"
                        required>
                    <small id="error-penghargaan_file_poster" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Foto Kegiatan</label>
                    <input type="text" name="penghargaan_photo_kegiatan" class="form-control" placeholder="Masukkan foto kegiatan"
                        required>
                    <small id="error-penghargaan_photo_kegiatan" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Skor</label>
                    <input type="text" name="penghargaan_score" class="form-control" placeholder="Masukkan skor"
                        required>
                    <small id="error-penghargaan_score" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Visible</label>
                    <input type="text" name="penghargaan_visible" class="form-control" placeholder="Masukkan visible"
                        required>
                    <small id="error-penghargaan_visible" class="error-text form-text text-danger"></small>
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
        if (typeof Swal === 'undefined') {
            console.error('SweetAlert2 is not loaded. Please include the SweetAlert2 library.');
            window.Swal = {
                fire: function (opts) {
                    alert(opts.title + '\n' + opts.text);
                }
            };
        }

        // Set minimum end date based on start date
        $('#lomba_tanggal_mulai').change(function () {
            const startDate = $(this).val();
            $('#lomba_tanggal_selesai').attr('min', startDate);

            if ($('#lomba_tanggal_selesai').val() && $('#lomba_tanggal_selesai').val() < startDate) {
                $('#lomba_tanggal_selesai').val('');
            }
        });

        $('.form-group').each(function (i) {
            $(this).css({ 'opacity': 0, 'transform': 'translateY(20px)' });
            setTimeout(function () {
                $('.form-group').eq(i).css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.4s ease-out',
                });
            }, 100 * (i + 1));
        });

        if ($.validator && !$.validator.methods.after) {
            $.validator.addMethod('after', function (value, element, param) {
                var startDate = $(param).val();
                if (!startDate || !value) return true;
                return new Date(value) > new Date(startDate);
            }, 'Tanggal selesai harus setelah tanggal mulai');
        }

        $("#form-tambah").validate({
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
            submitHandler: function (form) {
                var submitBtn = $(form).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...'
                );

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (response) {
                        submitBtn.prop('disabled', false).html(
                            '<i class="fas fa-save mr-2"></i> Simpan'
                        );

                        $('.error-text').text('');

                        if (response.status) {
                            $('#myModal').modal('hide');

                            setTimeout(function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message || 'Data lomba berhasil disimpan!',
                                    timer: 1500,
                                    showConfirmButton: false,
                                }).then(function () {
                                    if (typeof dataLomba !== 'undefined') {
                                        dataLomba.ajax.reload();
                                    }
                                });
                            }, 300);
                        } else {
                            if (response.msgField) {
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message || 'Terjadi kesalahan saat menyimpan data.',
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        submitBtn.prop('disabled', false).html(
                            '<i class="fas fa-save mr-2"></i> Simpan'
                        );

                        console.error('AJAX Error:', xhr.responseText);

                        if (xhr.status === 422 && xhr.responseJSON) {
                            $('.error-text').text('');

                            var errors = xhr.responseJSON.errors || {};
                            $.each(errors, function (field, messages) {
                                $('#error-' + field.replace(/\./g, '_')).text(messages[0]);
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                text: 'Silakan periksa kembali form input Anda.',
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
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                var fieldName = element.attr('name');
                $('#error-' + fieldName).text(error.text());
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>