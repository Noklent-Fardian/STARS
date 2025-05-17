@empty($lomba)
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
                            <p class="mb-0">Maaf, data lomba yang Anda cari tidak ada dalam database.</p>
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
<form action="{{ route('admin.adminKelolaLomba.updateAjax', $lomba->id) }}" method="POST" id="form-edit-lomba">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-edit mr-2"></i> Edit Data Lomba
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">ID Keahlian</label>
                    <select name="keahlian_id" id="keahlian_id" class="form-control" required>
                        <option value="" disabled>-- Pilih Keahlian --</option>
                        @foreach ($keahlians as $keahlian)
                            <option value="{{ $keahlian->id }}" {{ old('keahlian_id', $lomba->keahlian_id) == $keahlian->id ? 'selected' : '' }}>
                                {{ $keahlian->keahlian_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-keahlian_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">ID Tingkatan</label>
                    <select name="tingkatan_id" id="tingkatan_id" class="form-control" required>
                        <option value="" disabled>-- Pilih Tingkatan --</option>
                        @foreach ($tingkatans as $tingkatan)
                            <option value="{{ $tingkatan->id }}" {{ old('tingkatan_id', $lomba->tingkatan_id) == $tingkatan->id ? 'selected' : '' }}>
                                {{ $tingkatan->tingkatan_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-tingkatan_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">ID Semester</label>
                    <select name="semester_id" id="semester_id" class="form-control" required>
                        <option value="" disabled>-- Pilih Semester --</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ old('semester_id', $lomba->semester_id) == $semester->id ? 'selected' : '' }}>
                                {{ $semester->semester_nama }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-semester_id" class="error-text form-text text-danger"></small>
                </div>
                @php
                    $fields = [
                        'lomba_nama' => 'Nama Lomba',
                        'lomba_penyelenggara' => 'Penyelenggara',
                        'lomba_kategori' => 'Kategori',
                        'lomba_tanggal_mulai' => 'Tanggal Mulai',
                        'lomba_tanggal_selesai' => 'Tanggal Selesai',
                        'lomba_link_pendaftaran' => 'Link Pendaftaran',
                        'lomba_link_poster' => 'Link Poster'
                    ];
                @endphp

                @foreach ($fields as $field => $label)
                    <div class="form-group">
                        <label class="font-weight-bold">{{ $label }}</label>
                        <input type="{{ str_contains($field, 'tanggal') ? 'date' : 'text' }}" name="{{ $field }}"
                            id="{{ $field }}" class="form-control" placeholder="Masukkan {{ strtolower($label) }}"
                            value="{{ old($field, $lomba->$field) }}" required>
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
        $('#lomba_tanggal_mulai').change(function () {
            const startDate = $(this).val();
            $('#lomba_tanggal_selesai').attr('min', startDate);

            if ($('#lomba_tanggal_selesai').val() && $('#lomba_tanggal_selesai').val() < startDate) {
                $('#lomba_tanggal_selesai').val('');
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

        $("#form-edit-lomba").validate({
            rules: {
                keahlian_id: { required: true },
                tingkatan_id: { required: true },
                semester_id: { required: true },
                lomba_nama: { required: true, maxlength: 255 },
                lomba_penyelenggara: { required: true, maxlength: 255 },
                lomba_kategori: { required: true, maxlength: 255 },
                lomba_tanggal_mulai: {
                    required: true,
                    date: true,
                },
                lomba_tanggal_selesai: {
                    required: true,
                    date: true,
                    after: "#lomba_tanggal_mulai",
                },
                lomba_link_pendaftaran: {
                    required: true,
                    url: true,
                },
                lomba_link_poster: {
                    required: true,
                    url: true,
                },
            },
            messages: {
                keahlian_id: { required: "Pilih keahlian" },
                tingkatan_id: { required: "Pilih tingkatan" },
                semester_id: { required: "Pilih semester" },
                lomba_nama: {
                    required: "Nama lomba tidak boleh kosong",
                    maxlength: "Maksimal 255 karakter",
                },
                lomba_penyelenggara: {
                    required: "Penyelenggara tidak boleh kosong",
                    maxlength: "Maksimal 255 karakter",
                },
                lomba_kategori: {
                    required: "Kategori tidak boleh kosong",
                    maxlength: "Maksimal 255 karakter",
                },
                lomba_tanggal_mulai: {
                    required: "Tanggal mulai harus diisi",
                    date: "Format tanggal tidak valid",
                },
                lomba_tanggal_selesai: {
                    required: "Tanggal selesai harus diisi",
                    date: "Format tanggal tidak valid",
                    after: "Tanggal selesai harus setelah tanggal mulai",
                },
                lomba_link_pendaftaran: {
                    required: "Link pendaftaran harus diisi",
                    url: "Masukkan URL yang valid",
                },
                lomba_link_poster: {
                    required: "Link poster harus diisi",
                    url: "Masukkan URL yang valid",
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
                                text: response.message || 'Data lomba berhasil diperbarui!',
                                timer: 1500,
                                showConfirmButton: false,
                                didClose: function () {

                                    // Check if we're on the detail/show page
                                    if ($('.card-header:contains("Detail Lomba")').length > 0) {
                                        // Update the detail view with new lomba data
                                        updateLombaDetailView({
                                            nama: $('#lomba_nama').val(),
                                            penyelenggara: $('#lomba_penyelenggara').val(),
                                            kategori: $('#lomba_kategori').val(),
                                            tanggalMulai: $('#lomba_tanggal_mulai').val(),
                                            tanggalSelesai: $('#lomba_tanggal_selesai').val(),
                                            linkPendaftaran: $('#lomba_link_pendaftaran').val(),
                                            linkPoster: $('#lomba_link_poster').val()
                                        });
                                    } else {
                                        // If on index page, reload the DataTable
                                        if (typeof dataLomba !== 'undefined') {
                                            dataLomba.ajax.reload();
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
                    $('h4.font-weight-bold').text(data.nama);
                    $('#detail-penyelenggara').text(data.penyelenggara);
                    $('#detail-kategori').text(data.kategori);
                    $('#detail-tanggal-mulai').text(new Date(data.tanggalMulai).toLocaleDateString('id-ID'));
                    $('#detail-tanggal-selesai').text(new Date(data.tanggalSelesai).toLocaleDateString('id-ID'));
                    $('#detail-link-pendaftaran').attr('href', data.linkPendaftaran).text(data.linkPendaftaran);
                    $('#detail-link-poster').attr('href', data.linkPoster).text(data.linkPoster);

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