<form action="{{ route('admin.master.peringkatLomba.storeAjax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Peringkat Lomba
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold">Nama Peringkat</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-trophy"></i></span>
                        </div>
                        <input type="text" name="peringkat_nama" id="peringkat_nama" class="form-control"
                            placeholder="Masukkan nama peringkat" required>
                    </div>
                    <small id="error-peringkat_nama" class="error-text form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Bobot</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-warning text-white"><i class="fas fa-star"></i></span>
                        </div>
                        <input type="number" name="peringkat_bobot" id="peringkat_bobot" class="form-control"
                            placeholder="Masukkan jumlah bobot" min="0" value="0" required>
                    </div>
                    <small id="error-peringkat_bobot" class="error-text form-text text-danger"></small>
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

        $("#peringkat_bobot").on('blur', function () {
            let value = $(this).val();
            let formattedValue = parseFloat(value).toFixed(2);
            $(this).val(formattedValue);
        });

        $("#form-tambah").validate({
            rules: {
                peringkat_nama: {
                    required: true,
                    minlength: 1,
                    maxlength: 255
                },
                peringkat_bobot: {
                    required: true,
                    number: true,
                    min: 0,
                    step: 0.01
                },
            },
            messages: {
                peringkat_nama: {
                    required: "Nama peringkat tidak boleh kosong",
                    minlength: "Nama peringkat minimal 1 karakter",
                    maxlength: "Nama peringkat maksimal 255 karakter"
                },
                peringkat_bobot: {
                    required: "Bobot tidak boleh kosong",
                    number: "Bobot harus berupa angka",
                    min: "Bobot minimal 0"
                },

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
                            dataPeringkat.ajax.reload();
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
    });
</script>