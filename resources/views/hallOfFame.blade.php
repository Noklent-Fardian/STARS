<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Hall of Fame - STARS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/logo.svg') }}" rel="icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">

    <style>
        .hall-of-fame-header {
            background: linear-gradient(135deg, #102044 0%, #1a2a4d 50%, #2a3a5d 100%);
            color: white;
            padding: 100px 0 80px 0;
            position: relative;
            overflow: hidden;
            min-height: 40vh;
        }

        .hall-of-fame-header::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(250, 157, 28, 0.15) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        .hall-of-fame-header::after {
            content: "";
            position: absolute;
            top: 20%;
            left: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(250, 157, 28, 0.08) 0%, transparent 60%);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) scale(1);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-20px) scale(1.1);
                opacity: 0.8;
            }
        }

        .hall-of-fame-header .container {
            position: relative;
            z-index: 3;
        }

        .header-trophy-icon {
            font-size: 5rem;
            color: #FA9D1C;
            margin-bottom: 20px;
            text-shadow: 0 0 30px rgba(250, 157, 28, 0.5);
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            0% {
                transform: scale(1);
                text-shadow: 0 0 30px rgba(250, 157, 28, 0.5);
            }

            100% {
                transform: scale(1.05);
                text-shadow: 0 0 40px rgba(250, 157, 28, 0.8);
            }
        }

        .header-title {
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(45deg, #ffffff 0%, #FA9D1C 50%, #ffffff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .header-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .header-stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 20px 30px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }

        .stat-item:hover::before {
            left: 100%;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(250, 157, 28, 0.3);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #FA9D1C;
            display: block;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }

        .floating-star {
            position: absolute;
            color: rgba(250, 157, 28, 0.6);
            font-size: 1.5rem;
            animation: float-star 8s ease-in-out infinite;
        }

        .floating-star:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-star:nth-child(2) {
            top: 60%;
            left: 85%;
            animation-delay: 2s;
        }

        .floating-star:nth-child(3) {
            top: 80%;
            left: 15%;
            animation-delay: 4s;
        }

        .floating-star:nth-child(4) {
            top: 30%;
            left: 90%;
            animation-delay: 6s;
        }

        @keyframes float-star {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-30px) rotate(180deg);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .hall-of-fame-header {
                padding: 80px 0 60px 0;
                min-height: 30vh;
            }

            .header-trophy-icon {
                font-size: 3.5rem;
            }

            .header-title {
                font-size: 2.5rem;
            }

            .header-subtitle {
                font-size: 1.1rem;
            }

            .header-stats {
                gap: 20px;
            }

            .stat-item {
                padding: 15px 20px;
            }

            .stat-number {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .header-stats {
                flex-direction: column;
                align-items: center;
            }

            .stat-item {
                width: 100%;
                max-width: 200px;
            }
        }

        .filter-section {
            background: #f8f9fa;
            padding: 30px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .achievement-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            border-left: 5px solid var(--accent-color);
        }

        .achievement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .student-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--accent-color);
        }

        .rank-badge {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 14px;
        }

        .rank-1 {
            background: linear-gradient(45deg, #FFD700, #FFA500);
        }

        .rank-2 {
            background: linear-gradient(45deg, #C0C0C0, #D3D3D3);
        }

        .rank-3 {
            background: linear-gradient(45deg, #CD7F32, #B8860B);
        }

        .rank-other {
            background: linear-gradient(45deg, #4e54c8, #8f94fb);
        }

        .section-header {
            background: white;
            padding: 40px 0;
            border-bottom: 3px solid var(--accent-color);
            margin-bottom: 40px;
        }

        .tab-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 25px;
            border: 2px solid var(--accent-color);
            background: white;
            color: var(--accent-color);
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .tab-btn.active,
        .tab-btn:hover {
            background: var(--accent-color);
            color: white;
            transform: translateY(-2px);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .student-info h5 {
            color: var(--heading-color);
            margin-bottom: 5px;
        }

        .student-info .text-muted {
            font-size: 14px;
        }

        .achievement-info {
            background: rgba(var(--accent-color-rgb), 0.1);
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
        }

        .score-badge {
            background: linear-gradient(45deg, var(--accent-color), #f38c00);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        /* Back Button Styles */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 12px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 32, 68, 0.3);
            text-decoration: none;
        }

        .back-button i {
            transition: transform 0.3s ease;
        }

        .back-button:hover i {
            transform: translateX(-3px);
        }

        /* Alternative back button in header section */
        .breadcrumb-back {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb-back:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .achievement-card {
                padding: 20px;
            }

            .student-photo {
                width: 60px;
                height: 60px;
            }

            .rank-badge {
                width: 40px;
                height: 40px;
                font-size: 12px;
            }

            .back-button {
                top: 15px;
                left: 15px;
                padding: 10px 16px;
                font-size: 12px;
            }

            .hall-of-fame-header {
                padding: 60px 0 40px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Fixed Back Button -->
    <a href="{{ route('landing') }}" class="back-button">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
    </a>

    <main class="main">
        <!-- Enhanced Hall of Fame Header -->
        <section class="hall-of-fame-header">
            <!-- Floating Elements -->
            <div class="floating-elements">
                <div class="floating-star">⭐</div>
                <div class="floating-star">🏆</div>
                <div class="floating-star">🌟</div>
                <div class="floating-star">🎖️</div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="header-trophy-icon">🏆</div>
                        <h1 class="header-title">Hall of Fame</h1>
                        <p class="header-subtitle">
                            Menampilkan prestasi terbaik mahasiswa dan dosen<br>
                            <strong>Politeknik Negeri Malang</strong>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="filter-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('hallOfFame') }}"
                                class="d-flex align-items-center gap-3 flex-wrap">
                                <label for="year" class="form-label mb-0 fw-semibold">Filter Berdasarkan
                                    Tahun:</label>
                                <select name="year" id="year" class="form-select" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="all" {{ $selectedYear == 'all' ? 'selected' : '' }}>Semua Tahun
                                    </option>
                                    @foreach ($availableYears as $year)
                                        <option value="{{ $year }}"
                                            {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($selectedYear != 'all')
                                    <a href="{{ route('hallOfFame') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-x-circle me-1"></i>Reset Filter
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-5">
            <div class="container">
                <!-- Tab Buttons -->
                <div class="tab-buttons justify-content-center d-flex">
                    <button class="tab-btn active" onclick="showTab('prestasi')">
                        <i class="bi bi-trophy me-2"></i>Prestasi Terbaru
                    </button>
                    <button class="tab-btn" onclick="showTab('mahasiswa')">
                        <i class="bi bi-mortarboard me-2"></i>Top Mahasiswa
                    </button>
                    <button class="tab-btn" onclick="showTab('dosen')">
                        <i class="bi bi-person-workspace me-2"></i>Top Dosen
                    </button>
                </div>

                <!-- Prestasi Terbaru Tab -->
                <div id="prestasi" class="tab-content active">
                    <div class="section-header text-center">
                        <h2 class="display-5 fw-bold">🌟 Prestasi Terbaru</h2>
                        <p class="lead text-muted">Prestasi yang telah diverifikasi dan disetujui</p>
                    </div>

                    @if ($prestasiTerbaru->count() > 0)
                        <div class="row">
                            @foreach ($prestasiTerbaru as $index => $prestasi)
                                <div class="col-lg-6 mb-4">
                                    <div class="achievement-card">
                                        <div class="d-flex align-items-start">
                                            <div
                                                class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }} me-3">
                                                #{{ $index + 1 }}
                                            </div>

                                            <img src="{{ $prestasi->mahasiswa_photo ? asset('storage/' . $prestasi->mahasiswa_photo) : asset('img/default_avatar.jpg') }}"
                                                alt="{{ $prestasi->mahasiswa_nama }}" class="student-photo me-3">

                                            <div class="student-info flex-grow-1">
                                                <h5 class="mb-1">{{ $prestasi->mahasiswa_nama }}</h5>
                                                <p class="text-muted mb-2">
                                                    <i class="bi bi-card-text me-1"></i>{{ $prestasi->mahasiswa_nim }}
                                                    |
                                                    <i class="bi bi-building me-1"></i>{{ $prestasi->prodi_nama }} |
                                                    <i
                                                        class="bi bi-calendar me-1"></i>{{ $prestasi->mahasiswa_angkatan }}
                                                </p>

                                                <div class="achievement-info">
                                                    <h6 class="text-primary mb-2">
                                                        <i
                                                            class="bi bi-award me-1"></i>{{ $prestasi->penghargaan_judul }}
                                                    </h6>
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <div>
                                                            <span
                                                                class="badge bg-info me-2">{{ $prestasi->tingkatan_nama }}</span>
                                                            <span
                                                                class="badge bg-success">{{ $prestasi->peringkat_nama }}</span>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span
                                                                class="score-badge">{{ $prestasi->penghargaan_score }}
                                                                Poin</span>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($prestasi->verifikasi_verified_at)->format('d M Y') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-trophy"></i>
                            <h4>Belum Ada Prestasi</h4>
                            <p>Tidak ada prestasi yang ditemukan untuk tahun
                                {{ $selectedYear == 'all' ? 'yang dipilih' : $selectedYear }}.</p>
                        </div>
                    @endif
                </div>

                <!-- Top Mahasiswa Tab -->
                <div id="mahasiswa" class="tab-content">
                    <div class="section-header text-center">
                        <h2 class="display-5 fw-bold">🎓 Top Mahasiswa</h2>
                        <p class="lead text-muted">Mahasiswa dengan skor prestasi tertinggi</p>
                    </div>

                    @if ($topMahasiswa->count() > 0)
                        <div class="row">
                            @foreach ($topMahasiswa as $index => $mahasiswa)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="achievement-card text-center">
                                        <div
                                            class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }} mx-auto mb-3">
                                            #{{ $index + 1 }}
                                        </div>

                                        <img src="{{ $mahasiswa->mahasiswa_photo ? asset('storage/' . $mahasiswa->mahasiswa_photo) : asset('img/default_avatar.jpg') }}"
                                            alt="{{ $mahasiswa->mahasiswa_nama }}"
                                            class="student-photo mx-auto mb-3">

                                        <h5 class="mb-2">{{ $mahasiswa->mahasiswa_nama }}</h5>
                                        <p class="text-muted mb-3">
                                            <i class="bi bi-card-text me-1"></i>{{ $mahasiswa->mahasiswa_nim }}<br>
                                            <i class="bi bi-building me-1"></i>{{ $mahasiswa->prodi_nama }}<br>
                                            <i class="bi bi-calendar me-1"></i>Angkatan
                                            {{ $mahasiswa->mahasiswa_angkatan }}
                                        </p>

                                        <div class="score-badge mx-auto">
                                            {{ number_format($mahasiswa->mahasiswa_score, 0) }} Poin
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-mortarboard"></i>
                            <h4>Belum Ada Data Mahasiswa</h4>
                            <p>Tidak ada data mahasiswa yang ditemukan untuk tahun
                                {{ $selectedYear == 'all' ? 'yang dipilih' : $selectedYear }}.</p>
                        </div>
                    @endif
                </div>

                <!-- Top Dosen Tab -->
                <div id="dosen" class="tab-content">
                    <div class="section-header text-center">
                        <h2 class="display-5 fw-bold">👨‍🏫 Top Dosen</h2>
                        <p class="lead text-muted">Dosen pembimbing dengan kontribusi prestasi tertinggi</p>
                    </div>

                    @if ($topDosen->count() > 0)
                        <div class="row">
                            @foreach ($topDosen as $index => $dosen)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="achievement-card text-center">
                                        <div
                                            class="rank-badge {{ $index == 0 ? 'rank-1' : ($index == 1 ? 'rank-2' : ($index == 2 ? 'rank-3' : 'rank-other')) }} mx-auto mb-3">
                                            #{{ $index + 1 }}
                                        </div>

                                        <img src="{{ $dosen->dosen_photo ? asset('storage/' . $dosen->dosen_photo) : asset('img/default_avatar.jpg') }}"
                                            alt="{{ $dosen->dosen_nama }}" class="student-photo mx-auto mb-3">

                                        <h5 class="mb-2">{{ $dosen->dosen_nama }}</h5>
                                        <p class="text-muted mb-3">
                                            <i class="bi bi-card-text me-1"></i>{{ $dosen->dosen_nip }}
                                        </p>

                                        <div class="score-badge mx-auto">
                                            {{ number_format($dosen->dosen_score, 0) }} Poin
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-person-workspace"></i>
                            <h4>Belum Ada Data Dosen</h4>
                            <p>Tidak ada data dosen yang ditemukan untuk tahun
                                {{ $selectedYear == 'all' ? 'yang dipilih' : $selectedYear }}.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-4 col-md-6 footer-info">
                        <a href="#" class="footer-logo d-flex align-items-center">
                            <span class="gradient-text">STARS</span>
                        </a>
                        <p class="mt-3">Sistem Pencatatan Prestasi Digital Mahasiswa yang dirancang untuk pencatatan
                            dan pengelolaan prestasi mahasiswa secara terpusat.</p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('landing') }}">Beranda</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('hallOfFame') }}">Hall of
                                    Fame</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="{{ route('login') }}">Login</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Hubungi Kami</h4>
                        <p class="mt-3">
                            <i class="bi bi-telephone-fill me-2"></i> +62 878-6630-1810<br>
                            <i class="bi bi-envelope-fill me-2"></i> info@sansigma.ac.id<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container footer-bottom">
            <div class="copyright">
                &copy; <span id="current-year">2024</span> <strong><span>STARS</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('js/landing.js') }}"></script>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked button
            event.target.closest('.tab-btn').classList.add('active');
        }

        // Update year display
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Initialize AOS
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    </script>
</body>

</html>
