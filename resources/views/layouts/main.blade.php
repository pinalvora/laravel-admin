<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
   
    
    @yield('pageCss')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>
        @include('admin.pages.header')
        @include('admin.pages.sidebar')
        @yield('content')
        @include('admin.pages.footer')
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

<!-- jQuery -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- <script src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> --}}
{{-- <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> --}}
{{-- <script type="text/javascript" src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script> --}}
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript" src="{{ asset('js/root.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dist/js/adminlte.js')}}"></script>
<script type="text/javascript" src="{{ asset('dist/js/demo.js')}}"></script>
<script type="text/javascript" src="{{ asset('dist/js/pages/dashboard.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    setTimeout(function() {
        $('#errorMessage').fadeOut('fast');
        $('#successMessage').fadeOut('fast');
    }, 1000);
});
@if(Session::has('success'))
  toastr.options =
  {
    "closeButton" : true,
    timer: 3000
  }
toastr.success("{{ session('success') }}");
@endif
@if(Session::has('error'))
  toastr.options =
  {
    "closeButton" : true,
    timer: 3000
  }
toastr.error("{{ session('error') }}");
@endif
$(document).ready(function() {
    function disablePrev() { 
        window.history.forward() 
    }
    window.onload = disablePrev();
    window.onpageshow = function(evt) {
    if (evt.persisted) 
        disableBack() 
    } 
});
</script>
@yield('pageJS')
</body>
</html>
