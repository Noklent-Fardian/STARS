<form action="{{ route('admin.adminKelolaLomba.storeAjax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Lomba
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">

                <div class="form-group">
                    <label class="font-weight-bold">
                        <i class="fas fa-code mr-1"></i>
                        Bidang Keahlian <span class="text-danger">*</span>
                    </label>
                    <div class="keahlian-input-container position-relative">
                        <input type="text" id="keahlianInput" class="form-control keahlian-input"
                            placeholder="Masukkan bidang keahlian" autocomplete="off">
                        <div id="dropdownContainer" class="dropdown-container"></div>
                    </div>
                    <div class="selected-keahlian mt-2" id="selectedKeahlian"></div>
                    <div id="hiddenKeahlianInputs"></div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Ketik untuk mencari bidang keahlian. Tekan Enter untuk menambah bidang baru jika tidak
                        ditemukan.
                    </small>
                    <small id="error-lomba_keahlian_ids" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">ID Tingkatan</label>
                    <select name="tingkatan_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Tingkatan</option>
                        @foreach($tingkatans as $tingkatan)
                            <option value="{{ $tingkatan->id }}">{{ $tingkatan->tingkatan_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-tingkatan_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">ID Semester</label>
                    <select name="semester_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Semester</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}">{{ $semester->semester_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-semester_id" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Nama Lomba</label>
                    <input type="text" name="lomba_nama" class="form-control" placeholder="Masukkan nama lomba"
                        required>
                    <small id="error-lomba_nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Penyelenggara</label>
                    <input type="text" name="lomba_penyelenggara" class="form-control"
                        placeholder="Masukkan nama penyelenggara" required>
                    <small id="error-lomba_penyelenggara" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Kategori Lomba</label>
                    <select name="lomba_kategori" class="form-control" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Non-Akademik">Non-Akademik</option>
                    </select>
                    <small id="error-lomba_kategori" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tanggal Mulai</label>
                    <input type="date" name="lomba_tanggal_mulai" id="lomba_tanggal_mulai" class="form-control"
                        required>
                    <small id="error-lomba_tanggal_mulai" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Tanggal Selesai</label>
                    <input type="date" name="lomba_tanggal_selesai" id="lomba_tanggal_selesai" class="form-control"
                        required>
                    <small id="error-lomba_tanggal_selesai" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Link Pendaftaran</label>
                    <input type="url" name="lomba_link_pendaftaran" class="form-control"
                        placeholder="Masukkan URL pendaftaran" required>
                    <small id="error-lomba_link_pendaftaran" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Link Poster</label>
                    <input type="url" name="lomba_link_poster" class="form-control" placeholder="Masukkan URL poster"
                        required>
                    <small id="error-lomba_link_poster" class="error-text form-text text-danger"></small>
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
        let keahlianList = [];
        let newKeahlianNames = [];
        $(document).ready(function () {
            let dropdown = $('#dropdownContainer');
            let selectedKeahlian = [];
            let selectedKeahlianNama = {};
            let keahlianTimer = null;

            function refreshSelectedKeahlian() {
                let html = '';
                selectedKeahlian.forEach(function (itemId) {
                    html += `<span class="badge badge-info mr-1 mb-1">
                        ${selectedKeahlianNama[itemId]}
                        <a href="#" class="text-white ml-1 remove-keahlian" data-id="${itemId}">&times;</a>
                    </span>`;
                });
                newKeahlianNames.forEach(function (nama) {
                    html += `<span class="badge badge-success mr-1 mb-1">
                        ${nama}
                        <a href="#" class="text-white ml-1 remove-keahlian" data-id="new-${nama}">&times;</a>
                    </span>`;
                });
                $("#selectedKeahlian").html(html);

                // Hidden input for keahlian IDs
                let hidden = '';
                selectedKeahlian.forEach(function (itemId) {
                    hidden += `<input type="hidden" name="lomba_keahlian_ids[]" value="${itemId}">`;
                });
                newKeahlianNames.forEach(function (nama) {
                    hidden += `<input type="hidden" name="new_keahlian_names[]" value="${nama}">`;
                });
                $("#hiddenKeahlianInputs").html(hidden);
            }

            $('#keahlianInput').on('input', function () {
                let val = $(this).val();
                clearTimeout(keahlianTimer);
                if (val.length > 0) {
                    keahlianTimer = setTimeout(function () {
                        $.get("{{ route('admin.adminKelolaLomba.ajaxKeahlianSearch') }}", { q: val }, function (data) {
                            let items = data.data || [];
                            let html = '';
                            items.forEach(function (item) {
                                html += `<div class="dropdown-item keahlian-item" data-id="${item.id}" data-nama="${item.keahlian_nama}">
                                    <i class="fas fa-code mr-1"></i> ${item.keahlian_nama}
                                </div>`;
                            });
                            // Tampilkan opsi create jika tidak ada
                            let found = items.some(i => i.keahlian_nama.toLowerCase() === val.toLowerCase());
                            if (!found && val.trim() !== '') {
                                html += `<div class="dropdown-item keahlian-item-create text-success" data-nama="${val}">
                                    <i class="fas fa-plus mr-1"></i> Buat "<b>${val}</b>"
                                </div>`;
                            }
                            dropdown.html(html).show();
                        });
                    }, 300);
                } else {
                    dropdown.hide();
                }
            });

            // Pilih dari dropdown
            dropdown.on('click', '.keahlian-item', function () {
                let id = $(this).data('id');
                let nama = $(this).data('nama');
                if (!selectedKeahlian.includes(id)) {
                    selectedKeahlian.push(id);
                    selectedKeahlianNama[id] = nama;
                    refreshSelectedKeahlian();
                }
                $('#keahlianInput').val('');
                dropdown.hide();
            });

            // Buat baru
            dropdown.on('click', '.keahlian-item-create', function () {
                let nama = $(this).data('nama');
                if (!newKeahlianNames.includes(nama)) {
                    newKeahlianNames.push(nama);
                    refreshSelectedKeahlian();
                }
                $('#keahlianInput').val('');
                dropdown.hide();
            });

            // Enter untuk tambah bidang baru jika tidak ada di list
            $('#keahlianInput').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    let val = $(this).val().trim();
                    if (val !== '') {
                        let exists = Object.values(selectedKeahlianNama).some(nama => nama.toLowerCase() === val.toLowerCase());
                        let isNew = newKeahlianNames.some(nama => nama.toLowerCase() === val.toLowerCase());
                        if (!exists && !isNew) {
                            newKeahlianNames.push(val);
                            refreshSelectedKeahlian();
                        }
                        $(this).val('');
                        dropdown.hide();
                    }
                }
            });

            // Remove keahlian
            $('#selectedKeahlian').on('click', '.remove-keahlian', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                if (id.toString().startsWith('new-')) {
                    let val = id.substr(4);
                    newKeahlianNames = newKeahlianNames.filter(nama => nama !== val);
                } else {
                    selectedKeahlian = selectedKeahlian.filter(i => i != id);
                    delete selectedKeahlianNama[id];
                }
                refreshSelectedKeahlian();
            });

            // Hide dropdown jika klik di luar
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.keahlian-input-container').length) {
                    dropdown.hide();
                }
            });

            refreshSelectedKeahlian();
        });
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
                lomba_keahlian_ids: { required: true },
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
                lomba_keahlian_ids: { required: "Pilih minimal satu bidang keahlian" },
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
                    required: "Pilih kategori"
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
                                    location.reload();
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