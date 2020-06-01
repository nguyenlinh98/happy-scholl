<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ hsp_title() }}</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/front/bootstrap/bootstrap.min.css') }}">
    <!--Font awesome-->
    <link rel="stylesheet" href="{{ asset('css/front/font-awesome/all.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900&amp;display=swap&amp;subset=japanese" rel="stylesheet">

    <!-- JS -->
    <script src="{{ asset('js/front/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/front/bootstrap/bootstrap.min.js') }}"></script>
    {{--<link href="{{ mix('css/app.css') }}" rel="stylesheet">--}}

    <!--Custom CSS-->
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/front/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/custom.css') }}">


</head>
<body>
<?php
    $controllerName = class_basename(Route::current()->controller);
    $className = 'bg-gd';
    if($controllerName == 'SeminarController') {
        $className = 'bg-calendar2';
    } elseif($controllerName == 'SchoolEventController') {
        $className = 'bg-calendar3';
    }
?>
<main class="{{$className}}">
    <div class="container max-width">
        @yield('content')
    </div>
</main>
<!--Custom JS-->
<script src="{{ asset('js/front/main.js') }}"></script>
@section('script')
@show
@stack('script')
</body>
</html>
