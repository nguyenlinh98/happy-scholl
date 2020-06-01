@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{route('front.mypage.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('緊急連絡')}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div>
                <h3>{{translate('送信完了しました')}}</h3>
                <div class="course1">
                    <button class="btn-school margin-top-50 ahref" data-href="{{route('front.mypage.index')}}">
                        {{translate('マイページへ戻る')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection