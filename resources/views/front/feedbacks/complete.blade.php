@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{url('/front/mypage')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('出席通知')}}</h3>
                </div>
                <div class="calendar">
                    <div class="title">{{translate('〇〇小学校')}}</div>
                    <h3>{{translate('送信が完了しました。')}}</h3>
                    <img class="img-center" src="{{asset('images/front/teacher_image.png')}}" alt="">
                </div>
                <button class="btn-login margin-top-30">{{translate('マイページへ戻る')}}</button>
            </div>
        </div>
    </div>
@endsection
