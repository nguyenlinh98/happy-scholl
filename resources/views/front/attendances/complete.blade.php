@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate($msg_type)}}</h3>
                </div>
                <div class="calendar">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <h3>{{translate('送信が完了しました。')}}</h3>
                    @if($attendance->image)
                        <img class="img-center" src="{{asset('images/'.$attendance->image)}}" alt="">
                    @else
                        <img class="img-center" src="{{asset('images/front/teacher_image.png')}}" alt="">
                    @endif
                </div>
                <a href="{{route('front.mypage.index')}}">
                    <button class="btn-login margin-top-30">{{translate('マイページへ戻る')}}</button>
                </a>
            </div>
        </div>
    </div>
@endsection
