<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MBR Digital</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> -->

</head>
<body>
<div id="app">
    <?php
       $checar = \Auth::check();
       if($checar == true):
    ?>
        @include('layouts.inc.header');
        @include('layouts.inc.menu');

    <?php endif; //Checar se está logado ?>
    @yield('content')
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('html5lightbox/html5lightbox.js') }}" type="text/javascript" ></script>
<script src="{{ asset('js/nprogress.js') }}"></script>
</body>
</html>
