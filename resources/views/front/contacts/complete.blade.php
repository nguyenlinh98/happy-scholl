@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.contact.list',$studentId)}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('連絡網')}}</h3>
                </div>
                <div class="calendar">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <h3>{{translate('電話番号の登録が完了しました。')}}</h3>
                    <img class="img-center" src="{{asset('images/front/boy.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
