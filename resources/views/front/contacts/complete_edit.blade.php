@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{route('front.mypage.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('連絡網')}}</h3>
            </div>
            <div class="calendar list">
                <div class="title">{{translate(getSchoolName().$student->schoolClass->name)}}</div>
                <h3>{{translate('電話番号を変更しました')}}</h3>
                <img class="img-center" src="{{asset('images/front/boy.png')}}" alt="">
            </div>
            <a href="{{route('front.mypage.index')}}"><button class="btn-login">{{translate('マイページに戻る')}}</button></a>
        </div>
    </div>
</div>
@endsection