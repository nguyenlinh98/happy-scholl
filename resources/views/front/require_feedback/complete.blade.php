@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.require_feedback.list',$student->id)}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('回答必要通知')}}</h3>
                </div>
                <div class="calendar notification">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <h3>{{translate('回答が完了しました。')}}</h3>
                    <img class="img-center" src="{{asset('images/front/teacher_image.png')}}" alt="">
                </div>
                <a href="{{route('front.mypage.index')}}">
                    <button class="btn-login">{{translate('回答必要通知へ戻る')}}</button>
                </a>
            </div>
        </div>
    </div>
@endsection
