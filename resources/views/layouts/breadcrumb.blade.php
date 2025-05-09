<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">@yield('page-title', 'Dashboard')</h1>
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
    @yield('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">@yield('page-title', 'Dashboard')</li>
  </ol>
</div>