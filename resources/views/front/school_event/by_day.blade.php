@extends('front.layouts.front')
@section('content')
<div class="row">
<div class="col-md-12">
    <div class="select-school">
        <!-- NAVBAR -->
        <div class="nav-top">
        <a href="{{URL::previous()}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                        <h3>{{translate(\Lang::get('schoolevent.title.eventbyday'))}}</h3>
        </div>
        <div class="calendar">
            <div class="title">{{translate(getSchool()->name)}}</div>
            <div class="detail-event">
                <div class="date">{{Carbon\Carbon::parse($date_select)->locale('ja_JA')->isoFormat('ll')}}</div>
                <h4>{{translate('のイベント一覧')}}</h4>
                <ul>
                @foreach($schoolEvents as $e)
                <a href="{{ route('schoolevent.detail',[$e->id])}}">
                    <li>
                        <h5>{{translate($e->subject)}}</h5>
                        <p>{{translate('日時')}}:{{Carbon\Carbon::parse($e->scheduled_at)->locale('ja_JP')->isoFormat('YYYY年M月D日')}}</p>
                        <p>{{translate('時間')}}:
                        {{Carbon\Carbon::parse($e->scheduled_at)->locale('ja_JP')->isoFormat('HH:mm')}}
                          ~{{Carbon\Carbon::parse($e->scheduled_at)->locale('ja_JP')->isoFormat('HH:mm')}}
                        </p>
                        <p>{{translate('場所')}}:{{$e->reason}}</p>
                    </li>
                 </a>
                 @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('styles')
    <style>
         a {color: #58595B;}
    </style>
@endsection
