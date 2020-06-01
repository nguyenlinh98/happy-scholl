@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{route('front.calendar.index')}}?filter={{$filter}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('カレンダー')}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchoolName())}}</div>
                <h3>{{translate('カレンダー設定が完了しました。')}}</h3>
            </div>
            <a href="{{route('front.calendar.index')}}?filter={{$filter}}"><button class="btn-login margin-top-30">{{translate('カレンダーへ戻る')}}</button></a>
        </div>
    </div>
</div>
@endsection