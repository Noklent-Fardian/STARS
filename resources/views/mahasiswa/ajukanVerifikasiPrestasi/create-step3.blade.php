@extends('layouts.template')

@section('title', 'Verifikasi Prestasi - Pengajuan Berhasil | STARS')

@section('page-title', 'Verifikasi Prestasi')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('student.achievement.create') }}">Verifikasi Prestasi</a></li>
    <li class="breadcrumb-item active">Pengajuan Berhasil</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Progress Steps -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="step-progress">
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Pilih Lomba</div>
                            </div>
                            <div class="step-line completed"></div>
                            <div class="step completed">
                                <div class="step-number">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="step-title">Data Penghargaan</div>
                            </div>
                            <div class="step-line completed"></div>
                            <div class="step active completed">
                                <div class="step-number">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="step-title">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg success-card">
                    <div class="card-header bg-gradient-success text-white text-center">
                        <div class="success-header-content">
                            <div class="success-icon-container">
                                <i class="fas fa-trophy success-icon"></i>
                                <div class="success-icon-bg"></div>
                                <div class="success-particles">
                                    <div class="particle"></div>
                                    <div class="particle"></div>
                                    <div class="particle"></div>
                                    <div class="particle"></div>
                                    <div class="particle"></div>
                                </div>
                            </div>
                            <h4 class="mb-0 mt-3 text-white font-weight-bold">Pengajuan Berhasil!</h4>
                            <p class="mb-0 text-white-50">Prestasi Anda telah berhasil disubmit</p>
                        </div>
                    </div>
                    <div class="card-body text-center py-5">
                        <!-- Success Message -->
                        <div class="success-content">
                            <div class="mb-4">
                                <div class="checkmark-container">
                                    <div class="checkmark">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="text-success mb-3 font-weight-bold">
                                <i class="fas fa-medal mr-2"></i>Pengajuan Verifikasi Prestasi Berhasil!
                            </h3>
                            
                            <p class="text-muted mb-4 lead">
                                Pengajuan verifikasi prestasi Anda telah berhasil disubmit dan sedang menunggu proses verifikasi dari admin dan dosen pembimbing.
                            </p>

                            <!-- Process Information -->
                            <div class="process-info-container">
                                <div class="alert alert-info border-left-info">
                                    <div class="alert-content">
                                        <h6 class="alert-heading">
                                            <i class="fas fa-info-circle text-info mr-2"></i>
                                            Proses Verifikasi Selanjutnya
                                        </h6>
                                        <div class="process-steps">
                                            <div class="process-step">
                                                <div class="process-step-number">1</div>
                                                <div class="process-step-content">
                                                    <strong>Verifikasi Admin</strong>
                                                    <p class="mb-0">Admin akan memverifikasi kelengkapan dokumen dan data prestasi</p>
                                                </div>
                                            </div>
                                            <div class="process-step">
                                                <div class="process-step-number">2</div>
                                                <div class="process-step-content">
                                                    <strong>Verifikasi Dosen</strong>
                                                    <p class="mb-0">Dosen pembimbing akan memvalidasi prestasi yang dicapai</p>
                                                </div>
                                            </div>
                                            <div class="process-step">
                                                <div class="process-step-number">3</div>
                                                <div class="process-step-content">
                                                    <strong>Prestasi Tersimpan</strong>
                                                    <p class="mb-0">Setelah diverifikasi, prestasi akan masuk ke sistem dan Anda mendapat poin</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification Info -->
                                <div class="alert alert-warning border-left-warning">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-bell fa-2x text-warning mr-3"></i>
                                        <div class="text-left">
                                            <h6 class="mb-1">
                                                <i class="fas fa-envelope mr-1"></i>Notifikasi
                                            </h6>
                                            <p class="mb-0">
                                                Penghargaan Anda akan kami proses melalui sistem.
                                                Pantau terus status prestasi Anda di STARS.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons mt-5">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 mb-3">
                                        <a href="{{ route('mahasiswa.riwayatPengajuanPrestasi.index') }}" class="btn btn-primary btn-lg btn-block btn-custom">
                                            <i class="fas fa-list-alt mr-2"></i>
                                            <span>Lihat Status Prestasi</span>
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <a href="{{ route('student.achievement.create') }}" class="btn btn-outline-primary btn-lg btn-block btn-custom">
                                            <i class="fas fa-plus-circle mr-2"></i>
                                            <span>Ajukan Prestasi Lain</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="additional-info mt-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-clock text-primary"></i>
                                            </div>
                                            <h6>Waktu Verifikasi</h6>
                                            <p class="text-muted mb-0">Biasanya 1-3 hari kerja</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-shield-alt text-success"></i>
                                            </div>
                                            <h6>Keamanan Data</h6>
                                            <p class="text-muted mb-0">Data Anda tersimpan aman</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="fas fa-headset text-info"></i>
                                            </div>
                                            <h6>Bantuan</h6>
                                            <p class="text-muted mb-0">Hubungi admin jika ada kendala</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        /* Step Progress Styling */
        .step-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step-number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            transition: var(--transition);
            font-size: 1.1rem;
        }

        .step.active .step-number {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: var(--shadow);
            animation: pulse-success 2s ease-in-out infinite;
        }

        .step.completed .step-number {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: var(--shadow);
        }

        .step-title {
            font-size: 14px;
            text-align: center;
            color: #6c757d;
            font-weight: 500;
        }

        .step.active .step-title,
        .step.completed .step-title {
            color: #28a745;
            font-weight: 600;
        }

        .step-line {
            width: 100px;
            height: 3px;
            background-color: #e9ecef;
            margin: 0 20px;
            margin-bottom: 25px;
            border-radius: 2px;
        }

        .step-line.completed {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        /* Success Card Styling */
        .success-card {
            border: none;
            border-radius: var(--border-radius);
            overflow: hidden;
            animation: slideInUp 0.8s ease-out;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
        }

        .success-header-content {
            position: relative;
            z-index: 2;
        }

        .success-icon-container {
            position: relative;
            display: inline-block;
        }

        .success-icon {
            font-size: 4rem;
            color: white;
            position: relative;
            z-index: 3;
            animation: bounceIn 1s ease-out;
        }

        .success-icon-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .success-particles {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            animation: float-particles 3s ease-in-out infinite;
        }

        .particle:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; }
        .particle:nth-child(2) { top: 20%; right: 15%; animation-delay: 0.5s; }
        .particle:nth-child(3) { bottom: 20%; left: 15%; animation-delay: 1s; }
        .particle:nth-child(4) { bottom: 15%; right: 20%; animation-delay: 1.5s; }
        .particle:nth-child(5) { top: 50%; left: 10%; animation-delay: 2s; }

        /* Checkmark Animation */
        .checkmark-container {
            display: inline-block;
            position: relative;
        }

        .checkmark {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #28a745, #20c997);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            animation: scaleIn 0.8s ease-out;
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        }

        .checkmark i {
            font-size: 2.5rem;
            color: white;
            animation: checkmarkDraw 0.8s ease-out 0.3s both;
        }

        /* Process Steps */
        .process-info-container {
            margin: 2rem 0;
        }

        .border-left-info {
            border-left: 4px solid #17a2b8 !important;
        }

        .border-left-warning {
            border-left: 4px solid var(--accent-color) !important;
        }

        .process-steps {
            margin-top: 1rem;
        }

        .process-step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            text-align: left;
            animation: fadeInLeft 0.6s ease-out;
        }

        .process-step:nth-child(1) { animation-delay: 0.2s; }
        .process-step:nth-child(2) { animation-delay: 0.4s; }
        .process-step:nth-child(3) { animation-delay: 0.6s; }

        .process-step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .process-step-content strong {
            color: var(--heading-color);
            display: block;
            margin-bottom: 0.25rem;
        }

        .process-step-content p {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Enhanced Buttons */
        .btn-custom {
            border-radius: var(--border-radius);
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-primary.btn-custom {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            box-shadow: var(--shadow);
        }

        .btn-primary.btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 32, 68, 0.3);
        }

        .btn-outline-primary.btn-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary.btn-custom:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .btn-secondary.btn-custom {
            background: linear-gradient(135deg, #6c757d, #5a6268);
            border: none;
        }

        .btn-secondary.btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(108, 117, 125, 0.3);
        }

        /* Info Cards */
        .info-card {
            text-align: center;
            padding: 1.5rem 1rem;
            border-radius: var(--border-radius);
            background: linear-gradient(135deg, #f8f9fc, #ffffff);
            border: 2px solid rgba(16, 32, 68, 0.1);
            transition: var(--transition);
            height: 100%;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-color: var(--primary-color);
        }

        .info-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .info-card h6 {
            color: var(--heading-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Animations */
        @keyframes pulse-success {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes pulse-glow {
            0%, 100% { 
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.3;
            }
            50% { 
                transform: translate(-50%, -50%) scale(1.1);
                opacity: 0.6;
            }
        }

        @keyframes float-particles {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0.8;
            }
            50% { 
                transform: translateY(-20px) rotate(180deg);
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes checkmarkDraw {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeInLeft {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .step-number {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .step-title {
                font-size: 12px;
            }

            .step-line {
                width: 50px;
                margin: 0 10px;
                margin-bottom: 20px;
            }

            .success-icon {
                font-size: 3rem;
            }

            .success-icon-bg {
                width: 100px;
                height: 100px;
            }

            .checkmark {
                width: 60px;
                height: 60px;
            }

            .checkmark i {
                font-size: 1.8rem;
            }

            .process-step {
                flex-direction: column;
                text-align: center;
            }

            .process-step-number {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }

            .btn-custom {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .info-card {
                margin-bottom: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .success-card {
                margin: 0 10px;
            }

            .action-buttons .col-md-6 {
                width: 100%;
            }

            .info-card {
                padding: 1rem;
            }
        }

        /* Alert Content Enhancement */
        .alert-content {
            text-align: left;
        }

        .alert-heading {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .success-content {
            opacity: 0;
            animation: fadeIn 0.8s ease-out 0.5s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Additional enhancements */
        .lead {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .text-white-50 {
            opacity: 0.7;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Show success animation when page loads
            setTimeout(() => {
                // Add any additional animations or effects here
                console.log('Success page loaded successfully');
            }, 500);

            // Add smooth scroll to buttons
            $('.btn-custom').on('click', function(e) {
                $(this).addClass('btn-clicked');
                setTimeout(() => {
                    $(this).removeClass('btn-clicked');
                }, 200);
            });

            // Add particle animation on hover
            $('.success-icon-container').on('mouseenter', function() {
                $(this).find('.particle').addClass('animate-hover');
            }).on('mouseleave', function() {
                $(this).find('.particle').removeClass('animate-hover');
            });

            // Check if redirected from AJAX success
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === 'true') {
                // Show additional success effects
                setTimeout(() => {
                    showSuccess('Pengajuan prestasi berhasil disubmit!', 'Berhasil!');
                }, 1000);
            }
        });

        // CSS for button click effect
        const style = document.createElement('style');
        style.textContent = `
            .btn-clicked {
                transform: scale(0.95) !important;
                transition: transform 0.1s ease !important;
            }
            
            .animate-hover {
                animation-duration: 1s !important;
                animation-iteration-count: 3 !important;
            }
        `;
        document.head.appendChild(style);
    </script>
@endpush