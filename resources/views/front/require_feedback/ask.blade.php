@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{url('/front/mypage')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('回答必要通知')}}</h3>
            </div>
            <div class="calendar notification">
                <div class="title">{{translate('〇〇小学校')}}</div>
                <div class="i-card">
                    <h4>{{translate('〇〇についてご回答ください。')}}</h4>
                    <p>{{translate('2020年4月7日（火） 14:30')}}</p>
                    <p>{{translate('配信者：タダシ先生')}}</p>
                    <p>{{translate('回答期限：4月8日（○）')}}</p>
                    <p class="text-if">{{translate('〇〇について◯×でお答えください。')}}</p>
                </div>
                <div class="btn">
                    <button><img src="{{asset('images/front/o.png')}}" alt=""></button>
                    <button><img src="{{asset('images/front/x.png')}}" alt=""></button>
                </div>
            </div>
            <a href="{{url('front/qa/complete')}}"><button class="btn-login">{{translate('送信')}}</button></a>
        </div>
    </div>
</div>
@endsection
