<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ hsp_title() }}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/front/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/font-awesome/all.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900&amp;display=swap&amp;subset=japanese" rel="stylesheet">

    <!-- JS -->
    <script src="{{ asset('js/front/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/front/bootstrap/bootstrap.min.js') }}"></script>

    <!--Custom CSS-->
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/front/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/custom.css') }}">
</head>
<body>
    <main class="bg-C0E2ED">
        <div class="container max-width">
            <div class="row">
                <div class="col-md-12">
                    <div class="select-school emergency">
                        <div class="bg-fat">
                            {{ translate('緊急連絡 ') }}<a href="#" onclick="event.preventDefault()">{{ translate('回答を確認する') }}</a>
                        </div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Custom JS-->
<script src="{{ asset('js/front/main.js') }}"></script>
@section('script')
@show
@stack('script')
</body>
</html>
