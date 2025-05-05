<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{ asset('RuangAdmin/img/logo/logo.png') }}" rel="icon">
  <title>STARS</title>
  <link href="{{ asset('RuangAdmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('RuangAdmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('RuangAdmin/css/ruang-admin.min.css') }}" rel="stylesheet">
  @stack('css')
</head>

<body id="page-top">
  <div id="wrapper">
    @include('layouts.sidebar')
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content" class="wrapper">
        @include('layouts.header')
        <div class="container-fluid" id="container-wrapper">
          @include('layouts.breadcrumb')
          @yield('content')
        </div>
      </div>
      @include('layouts.footer')
    </div>
    <!-- End of Content Wrapper -->
  </div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script src="{{ asset('RuangAdmin/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('RuangAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('RuangAdmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('RuangAdmin/js/ruang-admin.min.js') }}"></script>
  <script src="{{ asset('RuangAdmin/vendor/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('RuangAdmin/js/demo/chart-area-demo.js') }}"></script>
  @stack('js')
</body>
</html>
