$(document).ready(function() {
    $('#editInfoBtn').click(function() {
        // Hide view mode elements
        $('#viewInfoMode').addClass('d-none');
        $('#editInfoBtn').addClass('d-none');
        $('#viewProfileImage').addClass('d-none');

        $('#editInfoMode').removeClass('d-none').addClass('fadeIn');
        $('#saveButtons').removeClass('d-none').addClass('fadeIn');
        $('#editProfileImage').removeClass('d-none').addClass('fadeIn');
    });

    $('#cancelEditBtn').click(function() {
        $('#viewInfoMode').removeClass('d-none').addClass('fadeIn');
        $('#editInfoBtn').removeClass('d-none');
        $('#viewProfileImage').removeClass('d-none').addClass('fadeIn');
        $('#editInfoMode').addClass('d-none');
        $('#saveButtons').addClass('d-none');
        $('#editProfileImage').addClass('d-none');
    });

    $('#uploadTrigger').click(function() {
        $('#profilePhotoInput').click();
    });

    $('#profilePhotoInput').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profileImage').attr('src', e.target.result);
                $('#previewImage').removeClass('d-none').attr('src', e.target.result);
                $('#previewPlaceholder').addClass('d-none');
                $('#profileImagePlaceholder').addClass('d-none');

                $('#photoUploadForm').submit();
            }
            reader.readAsDataURL(file);
        }
    });

    $('#reviewTrigger').click(function() {
        if ($('#profileImage').length) {
            //modal review photo
            const imgSrc = $('#profileImage').attr('src');
            const modal = `
            <div class="modal fade" id="profileImageModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Foto Profil</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${imgSrc}" class="img-fluid" style="max-height: 70vh;">
                        </div>
                    </div>
                </div>
            </div>
        `;

            $('body').append(modal);
            $('#profileImageModal').modal('show');
            $('#profileImageModal').on('hidden.bs.modal', function() {
                $(this).remove();
            });

            $('#changePhotoBtn').click(function() {
                $('#profileImageModal').modal('hide');
                $('#editInfoBtn').click();
            });
        } else {
            $('#editInfoBtn').click();
        }
    });
    
    $('.toggle-password-btn').click(function() {
        const target = $(this).data('target');
        const input = $('#' + target);
        const icon = $(this).find('i');

        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Handle password form submission
    $('#passwordForm').submit(function(e) {
        e.preventDefault();

        // Remove previous error messages
        $('.password-error').remove();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Clear the form
                    $('#passwordForm')[0].reset();

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },

            error: function(xhr) {
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('error');

                        $('#' + key).closest('.password-input').after(
                            '<span class="password-error text-danger"><small><i class="fas fa-exclamation-circle mr-1"></i>' +
                            value[0] + '</small></span>');
                    });
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    $('.password-actions').before(
                        '<div class="password-error alert alert-danger mt-3 mb-0">' +
                        xhr.responseJSON.message + '</div>');
                }
            }
        });
    });
});