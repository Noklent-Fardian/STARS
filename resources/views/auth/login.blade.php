<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login STARS</title>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/loginPage.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.svg') }}">
</head>

</head>

<body>
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">

            <!-- Circle Shapes -->
            <div class="shape circle circle-1"></div>
            <div class="shape circle circle-2"></div>
            <div class="shape circle circle-3"></div>

            <!-- Ring Shapes -->
            <div class="shape ring ring-1"></div>
            <div class="shape ring ring-2"></div>

            <!-- Polygon Shapes -->
            <div class="shape triangle triangle-1"></div>
            <div class="shape square square-1"></div>
            <!-- Glass Effect -->
            <div class="glass-effect glass-1"></div>
            
            <div class="welcome-content">
                <img src="{{ asset('img/logo.svg') }}" alt="Logo" class="logo">
                <h1>Selamat Datang!</h1>
                <p>STARS siap membantu Anda mengelola dan mengabadikan pencapaian berharga Anda.</p>
            </div>
        </div>

        <!-- Login Section -->
        
        <div class="login-section">
            <div class="login-box">
                <h2>Login</h2>
                <form action="{{ url('login') }}" method="POST" id="form-login">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="username" name="username" placeholder="Username or email" required>
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <small id="error-username" class="error-text"></small>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <small id="error-password" class="error-text"></small>
                    </div>
                    <div class="form-options">
                        <label>
                            <input type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Log In</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // Custom validation styling
            $.validator.setDefaults({
                errorClass: 'error',
                errorElement: 'span'
            });

            $("#form-login").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    }
                },
                messages: {
                    username: {
                        required: "Username diperlukan",
                        minlength: "Username minimal 4 karakter",
                        maxlength: "Username maksimal 20 karakter"
                    },
                    password: {
                        required: "Password diperlukan",
                        minlength: "Password minimal 4 karakter",
                        maxlength: "Password maksimal 20 karakter"
                    }
                },
                submitHandler: function(form) {
                    $('.error-text').text('');

                    // Add loading state to button
                    const $btn = $(form).find('.btn-primary');
                    const originalText = $btn.html();
                    $btn.html('<i class="fas fa-circle-notch fa-spin"></i> Processing...');
                    $btn.prop('disabled', true);

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                // Success case
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil Login!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 750,
                                    timerProgressBar: true,
                                    allowOutsideClick: false,
                                    heightAuto: false,
                                    position: 'center',
                                    customClass: {
                                        container: 'swal-container-fixed'
                                    },
                                    didOpen: () => {
                                        $btn.html('<i class="fas fa-check"></i> Success!');
                                        $btn.css('background', 'linear-gradient(135deg, #28a745, #20c997)');
                                        Swal.showLoading();
                                    }
                                }).then(function() {
                                    // Redirect with slight delay for better UX
                                    window.location = response.redirect;
                                });
                            } else {
                                // Error case
                                $btn.html(originalText);
                                $btn.prop('disabled', false);
                                
                                // Display field-specific errors
                                $('.error-text').text('');
                                if (response.msgField) {
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                }
                                
                                // Show error popup
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Gagal',
                                    text: response.message,
                                    confirmButtonText: 'oke',
                                    confirmButtonColor: '#6a11cb',
                                    heightAuto: false,
                                    position: 'center',
                                    customClass: {
                                        container: 'swal-container-fixed'
                                    },
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown'
                                    }
                                });
                            }
                        }
                    });
                    return false;
                },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    error.insertAfter(element);
                },
                highlight: function(element, errorClass, validClass) {

                    $(element).addClass('error');
                    $(element).closest('.input-group').addClass('has-error');
                },
                unhighlight: function(element, errorClass, validClass) {

                    $(element).removeClass('error');
                    $(element).closest('.input-group').removeClass('has-error');
                }
            });
        });
    </script>
</body>

</html>
