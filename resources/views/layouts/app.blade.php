<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

{{--<link rel="stylesheet" href="//cdn.bootcss.com/popper.js/1.13.0/popper.js">--}}
{{--<script src="//cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.js"></script>--}}
{{--<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.css">--}}

<!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container {{ route_class() }}-page">
  @include('layouts._header')

  @yield('content')

  @include('layouts._footer')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
