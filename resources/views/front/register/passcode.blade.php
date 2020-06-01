@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form register">
                <div class="logo">
                    <img src="{{ asset('images/front/logo.png') }}" alt="">
                </div>
                <form action="{{route('register.passcode.post')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <div>
                            <h3 style="text-align: center;">{{translate($schoolName->name)}}</h3>
                            <p>{{translate('お子様の 7 桁のパスコードを')}}</p>
                            <p>{{translate('ご入力ください')}}</p>
                        </div>
                        <input type="text" name="passcode" value="{{old('passcode')?old('passcode'):$passcode}}"
                               class="form-control" placeholder="{{translate('お子様パスコード')}}">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{translate($error)}}</p>
                            @endforeach
                        @endif
                        <p><br>{{translate('※半角英数字でご入力ください')}}</p>
                    </div>
                    <button type="submit" class="btn btn-login">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection