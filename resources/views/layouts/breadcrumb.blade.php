<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">@yield('page-title', 'Dashboard')</h1>
  <ol class="breadcrumb">
    @auth
      @if(Auth::user()->isAdmin())
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
      @elseif(Auth::user()->isDosen())
        <li class="breadcrumb-item"><a href="{{ route('dosen.dashboard') }}">Dosen</a></li>
      @elseif(Auth::user()->isMahasiswa())
        <li class="breadcrumb-item"><a href="{{ route('mahasiswa.dashboard') }}">Mahasiswa</a></li>
      @endif
    @else
      <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
    @endauth
    
    @yield('breadcrumb')
    
    <li class="breadcrumb-item active" aria-current="page">@yield('page-title', 'Dashboard')</li>
  </ol>
</div>