@empty($tingkatan)
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
                            <p class="mb-0">Maaf, data tingkatan lomba yang Anda cari tidak ada dalam database.</p>
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
    <form action="{{ route('admin.master.tingkatanLomba.updateAjax', $tingkatan->id) }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white font-weight-bold">
                        <i class="fas fa-edit mr-2"></i> Edit Tingkatan Lomba
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Tingkatan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white"><i class="fas fa-trophy"></i></span>
                            </div>
                            <input value="{{ $tingkatan->tingkatan_nama }}" type="text" name="tingkatan_nama"
                                id="tingkatan_nama" class="form-control" placeholder="Masukkan nama tingkatan" required>
                        </div>
                        <small id="error-tingkatan_nama" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Poin</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white"><i class="fas fa-star"></i></span>
                            </div>
                            <input value="{{ $tingkatan->tingkatan_point }}" type="number" name="tingkatan_point"
                                id="tingkatan_point" class="form-control" placeholder="Masukkan jumlah poin" min="0"
                                required>
                        </div>
                        <small id="error-tingkatan_point" class="error-text form-text text-danger"></small>
                    </div>
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
        $(document).ready(function() {

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

            $("#form-edit").validate({
                rules: {
                    tingkatan_nama: {
                        required: true,
                        minlength: 1,
                        maxlength: 255
                    },
                    tingkatan_point: {
                        required: true,
                        number: true,
                        min: 0
                    },
                    tingkatan_visible: {
                        required: true
                    }
                },
                messages: {
                    tingkatan_nama: {
                        required: "Nama tingkatan tidak boleh kosong",
                        minlength: "Nama tingkatan minimal 1 karakter",
                        maxlength: "Nama tingkatan maksimal 255 karakter"
                    },
                    tingkatan_point: {
                        required: "Poin tidak boleh kosong",
                        number: "Poin harus berupa angka",
                        min: "Poin minimal 0"
                    },
                    tingkatan_visible: {
                        required: "Status tidak boleh kosong"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
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
                                if ($('.card-header:contains("Detail Tingkatan Lomba")')
                                    .length > 0) {
                                    // Update the view with new data without page refresh
                                    updateDetailView({
                                        nama: $('#tingkatan_nama').val(),
                                        point: $('#tingkatan_point').val(),

                                    });
                                } else {
                                    // If on index page, just reload the DataTable
                                    if (typeof dataTingkatan !== 'undefined') {
                                        dataTingkatan.ajax.reload();
                                    }
                                }
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
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

            // Function to update the detail view without page refresh
            function updateDetailView(data) {
                // Update the heading and card info
                $('h4.font-weight-bold').text(data.nama);
                $('.badge.badge-warning.px-3.py-2').html(data.point + ' Poin');

                // Update the table data
                let tableRows = $('.user-info-item');
                $(tableRows[1]).find('.info-value').text(data.nama);
                $(tableRows[2]).find('.info-value').text(data.point);

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

                setTimeout(function() {
                    $('.user-info-item .info-value').css('background-color', '');
                }, 2000);
            }
        });
    </script>
    @endif
