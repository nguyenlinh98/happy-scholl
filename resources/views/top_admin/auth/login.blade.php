@extends('layouts.slim')

@section('content')
<div class="container-fluild">
    <header class="m-5 text-lg-center">
        <img src="<?php echo e(url('/css/asset/logo-login.png')); ?>" alt="">
    </header>
    <div class="container">
        <div class="text-center font-weight-bold" style="font-size: 25px">株式会社 HSP 専用管理画面</div>
    <div class="row justify-content-center">
        <div class="col-lg-12 my-3">
            <div class="">
                <div class="">
                    <form method="POST" action="{{ route('top_admin.login.post') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right font-weight-bold field-name" style="padding-right: 5%;">ID</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control form-control-fix @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right font-weight-bold field-name">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        ID とパスワードを記憶する
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pt-3">
                            <div class="col-md-6 offset-md-3 text-center">
                                <input type="image" alt="submit" style="border: none!important; outline: none" src="<?php echo e(url('/css/asset/button/manage-login.png')); ?>">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>
@endsection
