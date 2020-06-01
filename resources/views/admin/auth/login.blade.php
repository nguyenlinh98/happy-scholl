@extends('layouts.slim')

@section('content')
<div class="container-fluild">
    <header class="m-5 text-lg-center">
        <img src="<?php echo e(url('/css/asset/logo-login.png')); ?>" alt="">
    </header>
    <div class="container">
        <div class="text-center font-weight-bold" style="font-size: 25px">管理者用</div>
    <div class="row justify-content-center">
        <div class="col-lg-12 my-3">
            <div class="">
                <div class="">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="school_login_id" class="col-md-3 col-form-label text-md-right font-weight-bold field-name">学校ナンバー</label>

                            <div class="col-md-6">
                                <input id="school_login_id" type="text" class="form-control @error('school_login_id') is-invalid @enderror" name="school_login_id" value="{{ old('school_login_id') }}" required autocomplete="school_login_id" autofocus>

                                {{-- @error('school_login_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right font-weight-bold field-name">パスワード</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                {{-- @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3 text-center">
                                @if ($errors->any())
                                        <p class="text-danger">ご入力いただいたIDとパスワードが違います。</p>
                                        <p class="text-danger">再度ご入力お願いします。</p>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3 text-center">
                                <button type="submit" class="btn btn-link"><img class="btn-hover" style="width: 100%" src="{{url('/css/asset/button/home-login.png')}}" alt=""></button>
                            </div>
                        </div>

                                <p class="text-center pt-3">
                                    学校ナンバー・パスワードは、HSP社と一番最初に取り決めた内容をご入力ください。
                                </p>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

</div>
@endsection
