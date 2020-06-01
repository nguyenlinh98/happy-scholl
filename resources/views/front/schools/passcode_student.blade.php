@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form register">
                <div class="logo">
                    <img src="{{asset('images/front/logo.png')}}" alt="">
                </div>
            <div class="send-info">
                <h3>{{translate($schoolName->name)}}</h3>
                <p>{{translate('お子様のパスコードを')}}<br/>
                    {{translate('ご入力ください')}}<br/>
                </p>
                <form action="{{route('front.school.passcodestudent.post')}}" method="POST">
                    @csrf
                    <input type="text" class="input-send" placeholder="{{translate('お子様パスコード')}}" name="passcode">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{translate($error)}}</p>
                        @endforeach
                    @endif
                    <button class="btn-login margin-top-30" type="submit">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection