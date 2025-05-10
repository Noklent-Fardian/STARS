@empty($prodi)
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
                            <p class="mb-0">Maaf, data program studi yang Anda cari tidak ada dalam database.</p>
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
<form action="{{ route('admin.master.prodi.updateAjax', $prodi->id) }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-edit mr-2"></i> Edit Program Studi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">Nama Program Studi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-graduation-cap"></i></span>
                        </div>
                        <input value="{{ $prodi->prodi_nama }}" type="text" name="prodi_nama"
                            id="prodi_nama" class="form-control" placeholder="Masukkan nama program studi" required>
                    </div>
                    <small id="error-prodi_nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Kode Program Studi</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-info text-white"><i class="fas fa-code"></i></span>
                        </div>
                        <input value="{{ $prodi->prodi_kode }}" type="text" name="prodi_kode"
                            id="prodi_kode" class="form-control" placeholder="Masukkan kode program studi" required>
                    </div>
                    <small id="error-prodi_kode" class="error-text form-text text-danger"></small>
                </div>

                {{-- <div class="form-group">
                    <label class="font-weight-bold">Status</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-success text-white"><i class="fas fa-eye"></i></span>
                        </div>
                        <select name="prodi_visible" id="prodi_visible" class="form-control" required>
                            <option value="1" {{ $prodi->prodi_visible ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$prodi->prodi_visible ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                    <small id="error-prodi_visible" class="error-text form-text text-danger"></small>
                </div> --}}
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
        // Add animation to form elements when modal loads
        $('.form-group').each(function (i) {
            $(this).css({
                'opacity': 0,
                'transform': 'translateY(20px)'
            });

            setTimeout(function () {
                $('.form-group').eq(i).css({
                    'opacity': 1,
                    'transform': 'translateY(0)',
                    'transition': 'all 0.4s ease-out'
                });
            }, 100 * (i + 1));
        });

        $("#form-edit").validate({
            rules: {
                prodi_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                prodi_kode: {
                    required: true,
                    minlength: 2,
                    maxlength: 10
                },
                prodi_visible: {
                    required: true
                }
            },
            messages: {
                prodi_nama: {
                    required: "Nama program studi tidak boleh kosong",
                    minlength: "Nama program studi minimal 3 karakter",
                    maxlength: "Nama program studi maksimal 255 karakter"
                },
                prodi_kode: {
                    required: "Kode program studi tidak boleh kosong",
                    minlength: "Kode program studi minimal 2 karakter",
                    maxlength: "Kode program studi maksimal 10 karakter"
                },
                prodi_visible: {
                    required: "Status tidak boleh kosong"
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            // Check if we're on the detail/show page by looking for specific elements
                            if ($('.card-header:contains("Detail Program Studi")').length > 0) {
                                // Update the view with new data without page refresh
                                updateDetailView({
                                    nama: $('#prodi_nama').val(),
                                    kode: $('#prodi_kode').val(),
                                  
                                });
                            } else {
                                // If on index page, just reload the DataTable
                                if (typeof dataProdi !== 'undefined') {
                                    dataProdi.ajax.reload();
                                }
                            }
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Function to update the detail view without page refresh
        function updateDetailView(data) {
            // Update the heading and card info
            $('h4.font-weight-bold').text(data.nama);
            $('.badge.badge-primary').text('Kode: ' + data.kode);

            // Update the table data
            let tableRows = $('.user-info-item');
            $(tableRows[1]).find('.info-value').text(data.nama);
            $(tableRows[2]).find('.info-value').text(data.kode);
            
            // Update the timestamp with current time
            let now = new Date();
            let formattedDate = now.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            $(tableRows[4]).find('.info-value').text(formattedDate);

            // Add a highlight effect to show updated content
            $('.user-info-item .info-value').css({
                'background-color': '#fffde7',
                'transition': 'background-color 1s'
            });

            setTimeout(function () {
                $('.user-info-item .info-value').css('background-color', '');
            }, 2000);
        }
    });
</script>
@endif