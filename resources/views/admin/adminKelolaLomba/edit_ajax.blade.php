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
                    <label class="font-weight-bold">
                        <i class="fas fa-code mr-1"></i>
                        Bidang Keahlian <span class="text-danger">*</span>
                    </label>
                    <div class="keahlian-input-container position-relative">
                        <input type="text" id="keahlianInputEdit" class="form-control keahlian-input"
                            placeholder="Masukkan bidang keahlian" autocomplete="off">
                        <div id="dropdownContainerEdit" class="dropdown-container"></div>
                    </div>
                    <div class="selected-keahlian mt-2" id="selectedKeahlianEdit"></div>
                    <div id="hiddenKeahlianInputsEdit"></div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Ketik untuk mencari bidang keahlian. Tekan Enter untuk menambah bidang baru jika tidak
                        ditemukan.
                    </small>
                    <small id="error-lomba_keahlian_ids" class="error-text form-text text-danger"></small>
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
                        @if (str_contains($field, 'tanggal'))
                            <input type="date" name="{{ $field }}" id="{{ $field }}" class="form-control"
                                placeholder="Masukkan {{ strtolower($label) }}"
                                value="{{ old($field, optional($lomba->$field)->format('Y-m-d')) }}" required>
                        @elseif (str_contains($field, 'link'))
                            <input type="url" name="{{ $field }}" id="{{ $field }}" class="form-control"
                                placeholder="Masukkan {{ strtolower($label) }}" value="{{ old($field, $lomba->$field) }}"
                                required>
                        @else
                            <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control"
                                placeholder="Masukkan {{ strtolower($label) }}" value="{{ old($field, $lomba->$field) }}"
                                required>
                        @endif
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

        let dropdownEdit = $('#dropdownContainerEdit');
        let selectedKeahlianEdit = [];
        let selectedKeahlianNamaEdit = {};
        let newKeahlianNamesEdit = [];
        let keahlianTimerEdit = null;

        // Inisialisasi data dari $lomba->keahlians
        @if(!empty($lomba->keahlians))
            @foreach($lomba->keahlians as $keahlian)
                selectedKeahlianEdit.push({{ $keahlian->id }});
                selectedKeahlianNamaEdit[{{ $keahlian->id }}] = @json($keahlian->keahlian_nama);
            @endforeach
        @endif

        function refreshSelectedKeahlianEdit() {
            let html = '';
            selectedKeahlianEdit.forEach(function (itemId) {
                html += `<span class="badge badge-info mr-1 mb-1">
                        ${selectedKeahlianNamaEdit[itemId]}
                        <a href="#" class="text-white ml-1 remove-keahlian-edit" data-id="${itemId}">&times;</a>
                    </span>`;
            });
            newKeahlianNamesEdit.forEach(function (nama) {
                html += `<span class="badge badge-success mr-1 mb-1">
                        ${nama}
                        <a href="#" class="text-white ml-1 remove-keahlian-edit" data-id="new-${nama}">&times;</a>
                    </span>`;
            });
            $("#selectedKeahlianEdit").html(html);

            // Hidden input for keahlian IDs
            let hidden = '';
            selectedKeahlianEdit.forEach(function (itemId) {
                hidden += `<input type="hidden" name="lomba_keahlian_ids[]" value="${itemId}">`;
            });
            newKeahlianNamesEdit.forEach(function (nama) {
                hidden += `<input type="hidden" name="new_keahlian_names[]" value="${nama}">`;
            });
            $("#hiddenKeahlianInputsEdit").html(hidden);
        }

        $('#keahlianInputEdit').on('input', function () {
            let val = $(this).val();
            clearTimeout(keahlianTimerEdit);
            if (val.length > 0) {
                keahlianTimerEdit = setTimeout(function () {
                    $.get("{{ route('admin.adminKelolaLomba.ajaxKeahlianSearch') }}", { q: val }, function (data) {
                        let items = data.data || [];
                        let html = '';
                        items.forEach(function (item) {
                            html += `<div class="dropdown-item keahlian-item-edit" data-id="${item.id}" data-nama="${item.keahlian_nama}">
                                    <i class="fas fa-code mr-1"></i> ${item.keahlian_nama}
                                </div>`;
                        });
                        // Tampilkan opsi create jika tidak ada exact match
                        let found = items.some(i => i.keahlian_nama.toLowerCase() === val.toLowerCase());
                        if (!found && val.trim() !== '') {
                            html += `<div class="dropdown-item keahlian-item-create-edit text-success" data-nama="${val}">
                                    <i class="fas fa-plus mr-1"></i> Buat "<b>${val}</b>"
                                </div>`;
                        }
                        dropdownEdit.html(html).show();
                    });
                }, 300);
            } else {
                dropdownEdit.hide();
            }
        });

        // Pilih dari dropdown
        dropdownEdit.on('click', '.keahlian-item-edit', function () {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            if (!selectedKeahlianEdit.includes(id)) {
                selectedKeahlianEdit.push(id);
                selectedKeahlianNamaEdit[id] = nama;
                refreshSelectedKeahlianEdit();
            }
            $('#keahlianInputEdit').val('');
            dropdownEdit.hide();
        });
        // Buat baru
        dropdownEdit.on('click', '.keahlian-item-create-edit', function () {
            let nama = $(this).data('nama');
            if (!newKeahlianNamesEdit.includes(nama)) {
                newKeahlianNamesEdit.push(nama);
                refreshSelectedKeahlianEdit();
            }
            $('#keahlianInputEdit').val('');
            dropdownEdit.hide();
        });

        // Enter untuk tambah bidang baru jika tidak ada di list
        $('#keahlianInputEdit').on('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                let val = $(this).val().trim();
                if (val !== '') {
                    let exists = Object.values(selectedKeahlianNamaEdit).some(nama => nama.toLowerCase() === val.toLowerCase());
                    let isNew = newKeahlianNamesEdit.some(nama => nama.toLowerCase() === val.toLowerCase());
                    if (!exists && !isNew) {
                        newKeahlianNamesEdit.push(val);
                        refreshSelectedKeahlianEdit();
                    }
                    $(this).val('');
                    dropdownEdit.hide();
                }
            }
        });

        // Remove keahlian
        $('#selectedKeahlianEdit').on('click', '.remove-keahlian-edit', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            if (id.toString().startsWith('new-')) {
                let val = id.substr(4);
                newKeahlianNamesEdit = newKeahlianNamesEdit.filter(nama => nama !== val);
            } else {
                selectedKeahlianEdit = selectedKeahlianEdit.filter(i => i != id);
                delete selectedKeahlianNamaEdit[id];
            }
            refreshSelectedKeahlianEdit();
        });

        // Hide dropdown jika klik di luar
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.keahlian-input-container').length) {
                dropdownEdit.hide();
            }
        });

        refreshSelectedKeahlianEdit();

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
                                showConfirmButton: false
                            }).then(function () {
                                location.reload();
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
            }
        });
    });
</script>
@endif