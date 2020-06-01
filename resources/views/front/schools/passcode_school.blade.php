@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form register">
                <div class="logo">
                    <img src="{{asset('images/front/logo.png')}}" alt="">
                </div>
                <form action="{{route('front.school.passcodeschool.post')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <div>
                            <p>{{translate('小文字アルファベット 1 文字と')}}</p>
                            <p>{{translate('4 桁の数字の学校パスコードを')}}</p>
                            <p>{{translate('ご入力ください')}}</p>
                        </div>
                        <input type="text" name="schoolPasscode" value="{{old('schoolPasscode')?old('schoolPasscode'):$passcode}}"
                               class="form-control" placeholder="{{translate('認証パスコード')}}">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{translate($error)}}</p>
                            @endforeach
                        @endif
                        <div><p>{{translate('※半角英数字でご入力ください')}}</p></div>
                    </div>
                    <button type="submit" class="btn btn-login">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
