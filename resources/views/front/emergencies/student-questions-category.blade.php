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
                <div class="course1">
                @foreach($urgent_contact as $key => $contact)
                    <button class="btn-school margin-top-50 ahref" data-href="{{route('emergency.student-questions', [$key, $student_id])}}">
                        {{translate($contact)}}
                    </button>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection