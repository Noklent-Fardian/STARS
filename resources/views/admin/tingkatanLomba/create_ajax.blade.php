<form action="{{ route('admin.master.tingkatanLomba.storeAjax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white font-weight-bold">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Tingkatan Lomba
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
                        <input type="text" name="tingkatan_nama" id="tingkatan_nama" class="form-control" 
                            placeholder="Masukkan nama tingkatan" required>
                    </div>
                    <small id="error-tingkatan_nama" class="error-text form-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Poin</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-warning text-white"><i class="fas fa-star"></i></span>
                        </div>
                        <input type="number" name="tingkatan_point" id="tingkatan_point" class="form-control" 
                            placeholder="Masukkan jumlah poin" min="0" value="0" required>
                    </div>
                    <small id="error-tingkatan_point" class="error-text form-text text-danger"></small>
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
    $(document).ready(function() {
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

        $("#form-tambah").validate({
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
                            dataTingkatan.ajax.reload();
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
    });
</script>