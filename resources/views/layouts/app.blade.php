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
    <script type="text/javascript">
        window._urq = window._urq || [];
        _urq.push(['initSite', 'aa7a8a6c-9e4c-413c-a370-fc805d6503cc']);
        (function() {
            var ur = document.createElement('script'); ur.type = 'text/javascript'; ur.async = true;
            ur.src = ('https:' == document.location.protocol ? 'https://cdn.userreport.com/userreport.js' : 'http://cdn.userreport.com/userreport.js');
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ur, s);
        })();
    </script>

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
