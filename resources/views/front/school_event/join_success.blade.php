@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{route('schoolevent.detail',[$id])}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate(\Lang::get('schoolevent.title.index'))}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div>
                <h3>{{translate($message)}}</h3>
                <img class="img-center" src="{{asset('images/front/custudent.png')}}" alt="">
            </div>
            <a href="{{route('schoolevent.detail',[$id])}}"><button class="btn-login margin-top-30">{{translate('講座へ戻る')}}</button></a>
        </div>
    </div>
</div>
@endsection
