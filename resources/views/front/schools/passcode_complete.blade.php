@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form register">
                <div class="logo">
                    <img src="{{asset('images/front/logo.png')}}" alt="">
                </div>
            <div class="send-info">
                <p>{{translate('お子様の認証が確認できました。')}}<br/>
                    {{translate('マイページよりご確認ください。')}}<br/>
                </p>
                <a href="{{route('front.school.choose')}}">
                    <button class="btn-login margin-top-30" type="submit">{{translate('マイページへ')}}</button>
                </a>
            </div>
        </div>
        </div>
    </div>
@endsection