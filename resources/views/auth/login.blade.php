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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/loginPage.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.svg') }}">

    <style>
        /* Custom Modal Styles */
        .custom-modal .modal-dialog {
            max-width: 450px;
        }

        .custom-modal .modal-content {
            border: none;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .custom-modal .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
            padding: 20px 30px;
        }

        .custom-modal .modal-header h5 {
            font-weight: 600;
            margin: 0;
        }

        .custom-modal .modal-body {
            padding: 30px;
            text-align: center;
        }

        .custom-modal .modal-body i {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }

        .custom-modal .modal-body h6 {
            color: var(--heading-color);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .custom-modal .modal-body p {
            color: var(--text-color);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .admin-contact {
            background: #f8f9fa;
            border: 2px solid var(--accent-color);
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
        }

        .admin-contact h6 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .contact-item {
            align-items: center;
            justify-content: center;
            margin: 8px 0;
            color: var(--text-color);
        }

        .contact-item i {
            font-size: 1rem !important;
            margin-right: 10px;
            color: var(--accent-color);
        }

        .custom-modal .btn-close {
            background: linear-gradient(135deg, var(--accent-color), var(--accent-color-gradient));
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .custom-modal .btn-close:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(250, 157, 28, 0.3);
        }

        .politeknik-info {
            background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .politeknik-info h6 {
            color: var(--primary-color);
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <!-- Welcome Section -->
    <div class="welcome-section">
        <!-- ...existing code... -->
        <div class="shape circle circle-1"></div>
        <div class="shape circle circle-2"></div>
        <div class="shape circle circle-3"></div>
        <div class="shape ring ring-1"></div>
        <div class="shape ring ring-2"></div>
        <div class="shape triangle triangle-1"></div>
        <div class="shape square square-1"></div>
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
                    <span class="toggle-password" id="togglePassword"
                        style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10;">
                        <i class="fas fa-eye"></i>
                    </span>
                    <small id="error-password" class="error-text"></small>
                </div>

                <div class="form-options">
                    <label>
                        <a href="#" class="forgot-password" data-toggle="modal"
                            data-target="#forgotPasswordModal">Lupa Password ?</a>
                    </label>
                </div>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Log In</span>
                </button>
                <br>
                <div class="form-options">
                    <p>Kenapa tidak mendaftar Akun ? <a href="#" data-toggle="modal"
                            data-target="#registerInfoModal">Lihat Kebijakan</a></p>
                </div>
            </form>
        </div>
    </div>


    <!-- Forgot Password Modal -->
    <div class="modal fade custom-modal" id="forgotPasswordModal" tabindex="-1" role="dialog"
        aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">
                        <i class="fas fa-lock mr-2"></i>Lupa Password
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-user-shield"></i>
                    <h6>Hubungi Administrator</h6>
                    <p>Silakan hubungi admin jika ingin mereset password Anda. Admin akan membantu Anda untuk mengatur
                        ulang kata sandi.</p>

                    <div class="admin-contact">
                        <h6><i class="fas fa-headset mr-2"></i>Kontak Admin</h6>
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>+62 8579-2079-623</span>
                        </div>
                    </div>

                    <p class="text-muted small mb-0">
                        <i class="fas fa-clock mr-1"></i>
                        Jam kerja: Senin - Jumat, 08:00 - 16:00 WIB
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-close" data-dismiss="modal">Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Info Modal -->
    <div class="modal fade custom-modal" id="registerInfoModal" tabindex="-1" role="dialog"
        aria-labelledby="registerInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerInfoModalLabel">
                        <i class="fas fa-info-circle mr-2"></i>Informasi Pendaftaran
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <i class="fas fa-university"></i>
                    <h6>Sistem Khusus Civitas Akademika</h6>
                    <p>Sistem STARS ini hanya diperuntukkan untuk anggota civitas akademika Politeknik Negeri Malang.
                    </p>

                    <div class="politeknik-info">
                        <h6><i class="fas fa-shield-alt mr-2"></i>Kebijakan Akun</h6>
                        <p class="mb-2">• Semua akun akan dibuatkan langsung oleh administrator</p>
                        <p class="mb-2">• Hanya mahasiswa dan dosen terdaftar yang dapat mengakses sistem</p>
                        <p class="mb-0">• Akun diberikan berdasarkan data akademik resmi</p>
                    </div>

                    <div class="admin-contact">
                        <h6><i class="fas fa-user-plus mr-2"></i>Butuh Akun Baru?</h6>
                        <p class="mb-2">Hubungi admin untuk pembuatan akun:</p>
                        <div class="contact-item">
                            <i class="fab fa-whatsapp"></i>
                            <span>+62 8579-2079-623</span>
                        </div>
                    </div>

                    <p class="text-muted small mb-0">
                        <i class="fas fa-graduation-cap mr-1"></i>
                        Politeknik Negeri Malang - Student Achievement Record System
                    </p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-close" data-dismiss="modal">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

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
                                        $btn.html(
                                            '<i class="fas fa-check"></i> Success!'
                                        );
                                        $btn.css('background',
                                            'linear-gradient(135deg, #28a745, #20c997)'
                                        );
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

            // Password toggle functionality
            $("#togglePassword").click(function() {
                const passwordField = $("#password");
                const toggleIcon = $(this).find("i");

                if (passwordField.attr("type") === "password") {
                    passwordField.attr("type", "text");
                    toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    passwordField.attr("type", "password");
                    toggleIcon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });

            // Modal animation
            $('.modal').on('show.bs.modal', function() {
                $(this).find('.modal-dialog').addClass('animate__animated animate__fadeInDown');
            });

            $('.modal').on('hide.bs.modal', function() {
                $(this).find('.modal-dialog').removeClass('animate__animated animate__fadeInDown');
            });
        });
    </script>
</body>

</html>
