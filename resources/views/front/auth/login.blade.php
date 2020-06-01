@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form">
                <div class="logo">
                    <img src="{{asset('images/front/logo.png')}}" alt="">
                </div>
                <form action="{{route('customer.login.post')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="{{translate('メールアドレス')}}">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="password" placeholder="{{translate('パスワード')}}">
                    </div>
                    <div class="form-group">
                    @if ($errors->any())
                            <p class="text-danger">{{translate('ご入力いただいたメールアドレスとパスワードが違います。')}}</p>
                            <p class="text-danger">{{translate('再度ご入力お願いします。')}}</p>
                    @endif
                    </div>
                    <div class="remember">
                        <label class="form-group form-check">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} >
                            <span class="checkmark"></span>
                        </label>
                        <label class="form-check-label" for="remember">{{translate('簡易ログイン')}}</label>
                    </div>
                    <button type="submit" class="btn btn-login">{{translate('ログイン')}}</button>
                    <a href="{{route('customer.forget-password')}}">{{translate('パスワードを忘れの方はこちら')}}</a>
                </form>
            </div>
        </div>
    </div>
    <style>
        .text-danger{
            padding: 0 20px;
        }
    </style>
@endsection