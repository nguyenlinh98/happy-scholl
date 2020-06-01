<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- CSRF Token -->
    <title>{{ hsp_title() }}</title>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <style type="text/css">
        @font-face {
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }

        @font-face {
            font-family: ipag;
            font-style: bold;
            font-weight: bold;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        body {
            font-family: ipag !important;
        }
        /* @font-face {
            font-family: 'Noto Sans JP';
            font-style: normal;
            font-weight: 400;
            src: url({{ asset('font/NotoSansCJKjp-Regular.ttf') }});
        } */
        /* @font-face {
            font-family: 'Noto Sans JP', sans-serif;
            font-style: normal;
            font-weight: 900;
            src: url('{{ storage_path('fonts/NotoSansJP-Black.ttf') }}') format('truetype');
        } */
        /* body {
            font-family: 'Noto Sans JP', sans-serif !important;
        } */

        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body>
    <main>
        @yield('content')
    </main>
</body>

</html>
