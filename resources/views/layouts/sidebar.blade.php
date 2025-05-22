<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    @if (Auth::user()->admin)
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('img/logo.svg') }}" style="max-height: 40px">
            </div>
            <div class="sidebar-brand-text mx-3">STARS</div>
        </a>

        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Manajemen Pengguna -->
        <div class="sidebar-heading">Manajemen Pengguna</div>

        <li class="nav-item {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.mahasiswa.index') }}">
                <i class="fas fa-fw fa-user-graduate"></i>
                <span>Kelola Mahasiswa</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dosen.index') }}">
                <i class="fas fa-fw fa-chalkboard-teacher"></i>
                <span>Kelola Dosen</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.adminManagement.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.admin.index') }}">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Kelola Admin</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Manajemen Prestasi -->
        <div class="sidebar-heading">Manajemen Prestasi</div>

        <li class="nav-item {{ request()->routeIs('admin.prestasi.verification') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.prestasi.verification') }}">
                <i class="fas fa-fw fa-check-circle"></i>
                <span>Verifikasi Prestasi</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.prestasi.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.prestasi.index') }}">
                <i class="fas fa-fw fa-trophy"></i>
                <span>Kelola Prestasi</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Manajemen Lomba -->
        <div class="sidebar-heading">Manajemen Lomba</div>

        <li class="nav-item {{ request()->routeIs('admin.lomba.verification') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.lomba.verification') }}">
                <i class="fas fa-fw fa-clipboard-check"></i>
                <span>Verifikasi Lomba</span>
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.lomba.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.lomba.index') }}">
                <i class="fas fa-fw fa-medal"></i>
                <span>Kelola Lomba</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <!-- Master Data -->
        <div class="sidebar-heading">Master Data</div>

        @php
            $masterRoutes = [
                'admin.master.periode',
                'admin.master.prodi',
                'admin.master.keahlian',
                'admin.master.tingkatanLomba.index',
                'admin.master.peringkatLomba.index',
            ];

            $isMasterActive = collect($masterRoutes)->contains(function ($route) {
                return request()->routeIs($route) ||
                    (Str::contains($route, '.index') && request()->routeIs(Str::beforeLast($route, '.index') . '.*'));
            });
        @endphp

        <li class="nav-item {{ $isMasterActive ? 'active' : '' }}">
            <a class="nav-link {{ !$isMasterActive ? 'collapsed' : '' }}" href="#" data-toggle="collapse"
                data-target="#collapseMaster" aria-expanded="{{ $isMasterActive ? 'true' : 'false' }}"
                aria-controls="collapseMaster">
                <i class="fas fa-fw fa-database"></i>
                <span>Master Data</span>
            </a>
            <div id="collapseMaster" class="collapse {{ $isMasterActive ? 'show' : '' }}" aria-labelledby="headingMaster"
                data-parent="#accordionSidebar">
                <div class="py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Master:</h6>
                    <a class="collapse-item {{ request()->routeIs('admin.master.periode') ? 'active' : '' }}"
                        href="{{ route('admin.master.periode') }}">
                        <i class="fas fa-fw fa-calendar-alt"></i> Periode Semester</a>
                    <a class="collapse-item {{ request()->routeIs('admin.master.prodi.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.prodi.index') }}">
                        <i class="fas fa-fw fa-graduation-cap"></i> Program Studi</a>
                    <a class="collapse-item {{ request()->routeIs('admin.master.keahlian') ? 'active' : '' }}"
                        href="{{ route('admin.master.keahlian') }}">
                        <i class="fas fa-fw fa-tools"></i> Bidang Keahlian</a>
                    <a class="collapse-item {{ request()->routeIs('admin.master.tingkatanLomba.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.tingkatanLomba.index') }}">
                        <i class="fas fa-fw fa-trophy"></i> Tingkatan Lomba</a>
                    <a class="collapse-item {{ request()->routeIs('admin.master.peringkatLomba.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.peringkatLomba.index') }}">
                        <i class="fas fa-fw fa-medal"></i> Peringkat Lomba</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <!-- Settings -->
        <div class="sidebar-heading">Pengaturan</div>

        <li class="nav-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.profile') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Profil Saya</span>
            </a>
        </li>
    @endif


    @if(Auth::user()->dosen)
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dosen.dashboard') }}">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('img/logo.svg') }}" style="max-height: 40px">
            </div>
            <div class="sidebar-brand-text mx-3">STARS</div>
        </a>

        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dosen.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Manajemen</div>

        <li class="nav-item {{ request()->routeIs('dosen.lomba.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dosen.lomba.index') }}">
                <i class="nav-icon fas fa-list"></i>
                <span>Lihat Lomba</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('dosen.bimbingan.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dosen.bimbingan.index') }}">
                <i class="nav-icon fas fa-users"></i>
                <span>Bimbingan</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Pengaturan</div>

        <li class="nav-item {{ request()->routeIs('dosen.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dosen.profile') }}">
                <i class="nav-icon fas fa-user"></i>
                <span>Profil</span>
            </a>
        </li>
    @endif
    @if (Auth::user()->mahasiswa)
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('mahasiswa.dashboard') }}">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('img/logo.svg') }}" style="max-height: 40px">
            </div>
            <div class="sidebar-brand-text mx-3">STARS</div>
        </a>

        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Prestasi Mahasiswa</div>

        <li class="nav-item {{ request()->routeIs('mahasiswa.lomba.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('mahasiswa.lomba.index') }}">
                <i class="nav-icon fas fa-medal"></i>
                <span>Lihat Lomba</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('mahasiswa.prestasi') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('mahasiswa.prestasi.index') }}">
                <i class="nav-icon fas fa-plus-circle"></i>
                <span>Pencatatan Prestasi</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">Pengaturan</div>

        <li class="nav-item {{ request()->routeIs('mahasiswa.profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('mahasiswa.profile') }}">
                <i class="nav-icon fas fa-user"></i>
                <span>Profil</span>
            </a>
        </li>
    @endif
    <hr class="sidebar-divider d-none d-md-block">
    <li class="nav-item logout-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt text-danger"></i>
            <span class="logout-text">Logout</span>
        </a>
    </li>
</ul>
<!-- End of Sidebar -->