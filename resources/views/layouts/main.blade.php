<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>NicTracking | @yield('title')</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/material-helper.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/sweetalert.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/ol.css') }}">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">

</head>
<body>
    @yield('sidebar')

    @yield('navbar')

    @yield('content')

    @yield('footer')
    
  <script src="{{ asset('js/plugins/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/material.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>

  <script src="{{ asset('js/plugins/validator.min.js') }}" type="text/javascript"></script>

  <script src="{{ asset('js/plugins/moment.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/chartist.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/bootstrap-notify.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/jquery.datatables.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/sweetalert.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/jasny-bootstrap.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/material-helper.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/ol.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
  
  @yield('pagescript')
</body>
</html>