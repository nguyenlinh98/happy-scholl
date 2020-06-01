@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{route('front.mypage.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate(\Lang::get('schoolevent.title.index'))}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div>
                <div class="course1">
                    <button class="btn-school margin-top-50 ahref" data-href="{{route('schoolevent.calendar',[$school_id])}}">{{translate('イベントを調べる')}}</button>
                    <button class="btn-school margin-top-50 ahref" data-href="{{route('schoolevent.register')}}">{{translate('申し込んだイベントを')}}<br/>{{translate('確認する')}}</button>
                    <button class="btn-school margin-top-50 ahref" data-href="{{route('schoolevent.not-register')}}">{{translate('未定・欠席通知したイベント')}}</button>
                    <img class="img-center" src="{{asset('images/front/teacher_image.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection