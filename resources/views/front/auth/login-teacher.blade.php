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
    <!--Font awesome-->
    <link rel="stylesheet" href="{{ asset('css/front/font-awesome/all.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP:100,300,400,500,700,900&display=swap&subset=japanese" rel="stylesheet">

    <!-- JS -->
    <script src="{{ asset('js/front/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/front/bootstrap/bootstrap.min.js') }}"></script>

    <!--Custom CSS-->
    <link rel="stylesheet" href="{{ asset('css/front/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front/custom.css') }}">
</head>
<body>
    <main class="bg-gd">
        <div class="container max-width">
            <div class="row">
                <div class="col-md-12">
                    <div class="select-school emergency" style="padding-top:84px;">
                        <div class="nav-top">
                            <a href="{{ route('customer.login') }}" class="back-top"><img src="{{ asset('images/front/arr-left.png') }}">{{ translate('戻る') }}</a>
                            <h3>{{ translate('マイページ') }}</h3>
                        </div>
                        <!--Form-->
                        <form action="{{route('teacher.login.post')}}" method="POST" class="emergency-login">
                            <h4>{{ translate('緊急連絡用の') }}<br/>{{ translate('管理者用ログイン画面です。') }}</h4>
                            @csrf
                            <div class="form-group">
                                <input type="text" name="school_login_id" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="{{translate('学校ナンバー')}}" autocomplete="username">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="password" placeholder="{{translate('パスワード')}}" autocomplete="current-password">
                            </div>
                            <div class="form-group">
                            @if ($errors->any())
                                <p class="text-danger">{{translate('ご入力いただいた学校ナンバーアドレスとパスワードが違います。')}}</p>
                                <p class="text-danger">{{translate('再度ご入力お願いします。')}}</p>
                            @endif
                            </div>
                            <button type="submit" class="btn btn-login">{{ translate('ログイン') }}</button>
                            <p>{{ translate('※管理者用ページです。') }}<br/>
                            {{ translate('　一般ユーザーの保護者の方はご利用できません。') }}</p>
                        </form>
                        <!--End Form-->
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Custom JS-->
    <script src="{{ asset('js/front/main.js') }}"></script>
</body>
</html>
