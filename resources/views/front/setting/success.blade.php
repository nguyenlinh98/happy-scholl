@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('setting.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('出席通知')}}</h3>
                </div>
                <div class="calendar">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <h3>{{translate('通知・表示設定が完了しました。')}}</h3>
                    <img class="img-center" src="{{asset('images/front/boy.png')}}" alt="">
                </div>
                <a href="{{route('front.mypage.index')}}" class="btn-login margin-top-30">{{translate('マイページへ戻る')}}</a>
            </div>
        </div>
    </div>
@endsection

