<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Landing STARS</title>
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
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">


</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="#" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('img/logo.svg') }}" class="me-2" alt="STARS Logo" height="40">
                <h1 class="sitename">Pencatatan Prestasi</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="nav-link">Beranda</a></li>
                    <li><a href="#about" class="nav-link">Tentang Kami</a></li>
                    <li><a href="#services" class="nav-link">Fitur</a></li>
                    <li><a href="#pricing" class="nav-link">Hall Of Fame</a></li>
                    <li><a href="#contact" class="nav-link">Hubungi Kami</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <form method="get" action="login" class="login-form">
                <button class="btn-login" id="login-go" type="submit">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Login
                </button>
            </form>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1 class="">Simpan Penghargaan Anda
                            Dengan STARS</h1>
                        <p class="">Selamat Atas Penghargaan Anda !! ✋😊 </p>
                        <div class="d-flex">
                            <a href="https://youtu.be/8TO38KzkgaI?si=-MrDUZStIz2cm2EL"
                                class="glightbox btn-watch-video d-flex align-items-center"><i
                                    class="bi bi-play-circle"></i><span>Watch Video</span></a>
                        </div>
                    </div>
                    <div
                        class="col-lg-6 order-1 order-lg-2 hero-img text-center d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/logo.svg') }}" class="img-fluid animated mx-auto d-block" alt=""
                            style="width: 61%;">
                    </div>
                </div>
            </div>

        </section><!-- /Hero Section -->

        <!-- Clients 2 Section -->
        <section id="clients-2" class="clients-2 section">

            <div class="container">

                <div class="swiper">
                    <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 800,
                            "autoplay": {
                                "delay": 3000
                            },
                            "slidesPerView": "auto",
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            },
                            "breakpoints": {
                                "320": { "slidesPerView": 2, "spaceBetween": 40 },
                                "480": { "slidesPerView": 3, "spaceBetween": 60 },
                                "640": { "slidesPerView": 4, "spaceBetween": 80 },
                                "992": { "slidesPerView": 5, "spaceBetween": 120 },
                                "1200": { "slidesPerView": 6, "spaceBetween": 120 }
                            }
                        }
                        </script>
                    <div class="swiper-wrapper align-items-center">
                        @forelse($banners as $banner)
                            <div class="swiper-slide">
                                <a href="{{ $banner->banner_link }}" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ asset('storage/' . $banner->banner_gambar) }}" class="img-fluid"
                                        alt="{{ $banner->banner_nama }}">
                                </a>
                            </div>
                        @empty
                            <!-- Fallback to default competition links if no banners in database -->
                            <div class="swiper-slide">
                                <a href="https://pimnas37.unair.ac.id/" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/pimnas.png') }}" class="img-fluid" alt="PIMNAS">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://www.instagram.com/kmipn2024_pnj/" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/kmipn.png') }}" class="img-fluid"
                                        alt="KMIPN">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://en.wikipedia.org/wiki/Google_Code_Jam" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/codejam.png') }}" class="img-fluid"
                                        alt="Google Code Jam">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://gemastik.kemdikbud.go.id/" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/gemastik.png') }}" class="img-fluid"
                                        alt="GEMASTIK">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://jti.polinema.ac.id/playit2024/" target="_blank"
                                    rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/playit.png') }}" class="img-fluid"
                                        alt="PLAYIT">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://lldikti6.kemdikbud.go.id/program-kreativitas-mahasiswa-pkm-5-bidang/"
                                    target="_blank" rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/pkm.png') }}" class="img-fluid" alt="PKM">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="http://porseni.polinema.ac.id/" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/porseni.png') }}" class="img-fluid"
                                        alt="PORSENI">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="https://worldskills.org/" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ asset('img/clients/worldskill.png') }}" class="img-fluid"
                                        alt="World Skills">
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </section><!-- /Clients 2 Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2 class="">Tentang Kami</h2>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6 content" data-aos="fade-right" data-aos-duration="1000">
                        <div class="about-content-box">
                            <p class="lead-text">
                                STARS atau Student Achievement Record Sistem ini dirancang untuk mencatat
                                dan mengelola informasi prestasi mahasiswa Jurusan Teknologi Informasi Polinema secara
                                terpusat dan terstruktur.
                            </p>

                            <div class="team-section">
                                <h4 class="team-title"><i class="bi bi-people-fill me-2"></i>Dibuat Oleh Kelompok 6
                                </h4>
                                <ul class="team-members">
                                    <li class="team-member">
                                        <div class="member-icon"><i class="bi bi-person-check-fill"></i></div>
                                        <div class="member-info">
                                            <span class="member-name">Achmad Maulana Hamzah</span>
                                            <span class="member-id">2341720172</span>
                                        </div>
                                    </li>
                                    <li class="team-member">
                                        <div class="member-icon"><i class="bi bi-person-check-fill"></i></div>
                                        <div class="member-info">
                                            <span class="member-name">Candra Ahmad Dani</span>
                                            <span class="member-id">2341720187</span>
                                        </div>
                                    </li>
                                    <li class="team-member">
                                        <div class="member-icon"><i class="bi bi-person-check-fill"></i></div>
                                        <div class="member-info">
                                            <span class="member-name">Necha Syifa Syafitri</span>
                                            <span class="member-id">2341720167</span>
                                        </div>
                                    </li>
                                    <li class="team-member">
                                        <div class="member-icon"><i class="bi bi-person-check-fill"></i></div>
                                        <div class="member-info">
                                            <span class="member-name">Noklent Fardian Erix</span>
                                            <span class="member-id">2341720082</span>
                                        </div>
                                    </li>
                                    <li class="team-member">
                                        <div class="member-icon"><i class="bi bi-person-check-fill"></i></div>
                                        <div class="member-info">
                                            <span class="member-name">Taufik Dimas Edystara</span>
                                            <span class="member-id">2341720062</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                        <div class="about-feature-box">
                            <div class="feature-header">
                                <div class="feature-icon-container">
                                    <i class="bi bi-lightning-charge-fill feature-icon"></i>
                                </div>
                                <h3 class="feature-title">Fitur Utama</h3>
                            </div>

                            <div class="feature-content">
                                <p>
                                    Fitur utamanya mencakup input data prestasi akademik dan non
                                    akademik, validasi oleh dosen atau staf terkait, serta laporan prestasi mahasiswa
                                    dalam bentuk grafik
                                    atau tabel. Sistem ini akan mempermudah akses informasi prestasi secara real-time
                                    bagi mahasiswa,
                                    dosen, dan pihak administrasi, sehingga mendukung evaluasi dan apresiasi yang lebih
                                    transparan dan
                                    efisien.
                                </p>

                                <div class="feature-highlights">
                                    <div class="highlight"><i class="bi bi-check-circle-fill"></i> Input data prestasi
                                    </div>
                                    <div class="highlight"><i class="bi bi-check-circle-fill"></i> Validasi oleh dosen
                                    </div>
                                    <div class="highlight"><i class="bi bi-check-circle-fill"></i> Laporan prestasi
                                        visual</div>
                                    <div class="highlight"><i class="bi bi-check-circle-fill"></i> Akses informasi
                                        real-time</div>
                                </div>

                                <a href="#services" class="read-more">
                                    <span>Lihat Fitur Lainnya</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /About Section -->

        <!--  Services Section -->
        <section id="services" class="services section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Fitur STARS</h2>
                <p>Dengan STARS menuju prestasi tingkat dunia </p>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row gy-4">
                    <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="1000">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-people-fill"></i></div>
                            <h4><a href="#" class="stretched-link">Sentralilasi Data Mahasiswa</a></h4>
                            <p>Sistem ini akan mencatat data mahasiswa yang nantinya akan mengajukan verifikasi
                                prestasinya.</p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="1000">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-patch-check-fill"></i></div>
                            <h4><a href="#" class="stretched-link">Verifikasi Prestasi Mahasiswa </a></h4>
                            <p>Sistem juga dapat melakukan verifikasi prestasi oleh dosen pembimbing dan admin jurusan.
                            </p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-xl-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="1000">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-person-badge-fill"></i></div>
                            <h4><a href="#" class="stretched-link">Sentralilasi Data Dosen</a></h4>
                            <p>Sistem ini akan mencatat data dosen yang nantinya akan melakukan verifikasi prestasi.</p>
                        </div>
                    </div><!-- End Service Item -->


                </div>

            </div>

        </section><!-- /Services Section -->
        <!-- Call To Action Section -->
        <section id="call-to-action" class="call-to-action section">
            <img src="{{ asset('img/cta-bg.jpg') }}" class="call-to-action-bg" alt="">

            <div class="container">
                <div class="row justify-content-between align-items-center" data-aos="zoom-in" data-aos-delay="100">
                    <div class="col-xl-7 text-center text-xl-start">
                        <div class="cta-content">
                            <h3 class="mb-4">User STARS</h3>

                            <div class="role-cards">
                                <div class="role-card">
                                    <div class="role-icon">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </div>
                                    <div class="role-info">
                                        <h4>Mahasiswa</h4>
                                        <p>Mahasiswa jurusan JTI dapat menggunakan sistem ini untuk pencatatan prestasi
                                            akademik dan non-akademik</p>
                                    </div>
                                </div>

                                <div class="role-card">
                                    <div class="role-icon">
                                        <i class="bi bi-person-workspace"></i>
                                    </div>
                                    <div class="role-info">
                                        <h4>Dosen</h4>
                                        <p>Dosen berperan sebagai pembimbing dan validator prestasi mahasiswa dalam
                                            lomba</p>
                                    </div>
                                </div>

                                <div class="role-card">
                                    <div class="role-icon">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </div>
                                    <div class="role-info">
                                        <h4>Admin</h4>
                                        <p>Admin memiliki kontrol penuh untuk mengelola dan menghapus akun pengguna</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 d-none d-xl-block">

                    </div>
                </div>
            </div>
        </section><!-- /Call To Action Section -->


        <!-- Pricing Section -->
        <section id="pricing" class="pricing section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>HALL OF FAME</h2>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="1000">
                        <div class="pricing-item featured">
                            <h3>Prestasi Terbaru</h3>
                            <h4><sup>Mahasiswa</sup></h4>
                            <ol class="p-0" style="list-style: none;">
                                @if (isset($top10NewVerifikasi) && $top10NewVerifikasi->count() > 0)
                                    @foreach ($top10NewVerifikasi as $index => $prestasi)
                                        <li class="d-flex align-items-center mb-3">
                                            <span class="badge bg-gradient-primary px-3 py-2 rounded-pill me-3"
                                                style="background: linear-gradient(45deg, {{ $index == 0 ? '#FFD700, #FFA500' : ($index == 1 ? '#C0C0C0, #D3D3D3' : ($index == 2 ? '#CD7F32, #B8860B' : '#4e54c8, #8f94fb')) }}); width: 50px; text-align: center;">
                                                {{ $index + 1 }}{{ $index + 1 == 1 ? 'st' : ($index + 1 == 2 ? 'nd' : ($index + 1 == 3 ? 'rd' : 'th')) }}
                                            </span>
                                            <span>{{ $prestasi->mahasiswa_name }} - {{ $prestasi->judul }} -
                                                {{ $prestasi->tingkatan_name }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="d-flex align-items-center mb-3">
                                        <span class="text-muted">Belum ada prestasi terbaru</span>
                                    </li>
                                @endif
                            </ol>
                            <a href="{{ route('hallOfFame') }}" class="buy-btn">Lihat Selengkapnya</a>
                        </div>
                    </div>

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="1000">
                        <div class="pricing-item featured">
                            <h3>TOP 10</h3>
                            <h4><sup>Mahasiswa</sup></h4>
                            <ol class="p-0" style="list-style: none;">
                                @if (isset($top10mahasiswas) && $top10mahasiswas->count() > 0)
                                    @foreach ($top10mahasiswas as $index => $mahasiswa)
                                        <li class="d-flex align-items-center mb-3">
                                            <span class="badge bg-gradient-primary px-3 py-2 rounded-pill me-3"
                                                style="background: linear-gradient(45deg, {{ $index == 0 ? '#FFD700, #FFA500' : ($index == 1 ? '#C0C0C0, #D3D3D3' : ($index == 2 ? '#CD7F32, #B8860B' : '#4e54c8, #8f94fb')) }}); width: 50px; text-align: center;">
                                                {{ $index + 1 }}{{ $index + 1 == 1 ? 'st' : ($index + 1 == 2 ? 'nd' : ($index + 1 == 3 ? 'rd' : 'th')) }}
                                            </span>
                                            <span>{{ $mahasiswa->name }} - {{ number_format($mahasiswa->score, 0) }}
                                                Points</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="d-flex align-items-center mb-3">
                                        <span class="text-muted">Belum ada data mahasiswa</span>
                                    </li>
                                @endif
                            </ol>
                            <a href="{{ route('hallOfFame') }}" class="buy-btn">Lihat Selengkapnya</a>
                        </div>
                    </div>

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="1000">
                        <div class="pricing-item featured">
                            <h3>TOP 10</h3>
                            <h4><sup>Dosen</sup></h4>
                            <ol class="p-0" style="list-style: none;">
                                @if (isset($top10dosen) && $top10dosen->count() > 0)
                                    @foreach ($top10dosen as $index => $dosen)
                                        <li class="d-flex align-items-center mb-3">
                                            <span class="badge bg-gradient-primary px-3 py-2 rounded-pill me-3"
                                                style="background: linear-gradient(45deg, {{ $index == 0 ? '#FFD700, #FFA500' : ($index == 1 ? '#C0C0C0, #D3D3D3' : ($index == 2 ? '#CD7F32, #B8860B' : '#4e54c8, #8f94fb')) }}); width: 50px; text-align: center;">
                                                {{ $index + 1 }}{{ $index + 1 == 1 ? 'st' : ($index + 1 == 2 ? 'nd' : ($index + 1 == 3 ? 'rd' : 'th')) }}
                                            </span>
                                            <span>{{ $dosen->name }} - {{ number_format($dosen->score, 0) }}
                                                Points</span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="d-flex align-items-center mb-3">
                                        <span class="text-muted">Belum ada data dosen</span>
                                    </li>
                                @endif
                            </ol>
                            <a href="{{ route('hallOfFame') }}" class="buy-btn">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Pricing Section -->


        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Hubungi Kami</h2>
                <p>Berikan saran dan kritik agar membantu dalam perkembangan website kami.</p>
            </div><!-- End Section Title -->

            <!-- Contact Form -->
            <div class="container" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <div class="contact-info-card">
                            <div class="contact-info-header">
                                <div class="info-header-icon">
                                    <i class="bi bi-map"></i>
                                </div>
                                <h3>Informasi Kontak</h3>
                            </div>

                            <div class="info-items">
                                <div class="info-item" data-aos="fade-up" data-aos-delay="100">
                                    <i class="bi bi-geo-alt flex-shrink-0 pulse-icon"></i>
                                    <div>
                                        <h4>Alamat</h4>
                                        <p>Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa
                                            Timur 65141</p>
                                    </div>
                                </div>

                                <div class="info-item" data-aos="fade-up" data-aos-delay="200">
                                    <i class="bi bi-telephone flex-shrink-0 pulse-icon"></i>
                                    <div>
                                        <h4>Nomor Telepon</h4>
                                        <p>+62 878-6630-1810</p>
                                    </div>
                                </div>

                                <div class="info-item" data-aos="fade-up" data-aos-delay="300">
                                    <i class="bi bi-envelope flex-shrink-0 pulse-icon"></i>
                                    <div>
                                        <h4>Email</h4>
                                        <p>info@sansigma.ac.id</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="map-container" data-aos="fade-up" data-aos-delay="300">
                            <div class="map-header">
                                <div class="map-icon">
                                    <i class="bi bi-pin-map-fill"></i>
                                </div>
                                <h3>Lokasi Kami</h3>
                            </div>

                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15806.497797965125!2d112.61442606697996!3d-7.934233362695417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78827687d272e7%3A0x789ce9a636cd3aa2!2sPoliteknik%20Negeri%20Malang!5e0!3m2!1sid!2sid!4v1732764514137!5m2!1sid!2sid"
                                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                            </iframe>


                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Contact Section -->


    </main>

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
                        <div class="footer-contact mt-4">
                            <p><i class="bi bi-geo-alt-fill me-2"></i>Jl. Soekarno Hatta No.9, Jatimulyo, Kec.
                                Lowokwaru, Kota Malang, Jawa Timur 65141</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Review</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#hero">Beranda</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#about">Tentang Kami</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#services">Fitur</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#pricing">Hall of Fame</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Hubungi Kami</h4>
                        <p class="mt-3">
                            <i class="bi bi-telephone-fill me-2"></i> +62 878-6630-1810<br>
                            <i class="bi bi-envelope-fill me-2"></i> info@sansigma.ac.id<br>
                        </p>
                        <div class="social-links mt-4">
                            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
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

    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/aos/aos.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('js/landing.js') }}"></script>

</body>

</html>
