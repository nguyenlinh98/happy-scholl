@extends('front.layouts.front')
@section('content')
<div class="row">
<div class="col-md-12">
    <div class="select-school">
        <!-- NAVBAR -->
        <div class="nav-top">
        <a href="{{URL::previous()}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                        <h3>{{translate(\Lang::get('seminar.title.not-register'))}}</h3>
        </div>
        <div class="calendar">
            <div class="title">{{translate(getSchool()->name)}}</div>
            <div class="detail-event">
            {{--    <h4>@if($seminars->count() > 0){{translate('の講座一覧')}}@endif</h4> --}}
                <ul>
                @foreach($seminars as $e)
                    <li>
                        <h5>{{translate($e->subject)}}</h5>
                        <p>{{translate('日時')}}:{{Carbon\Carbon::parse($e->start_time)->locale('ja_JP')->isoFormat('YYYY年M月D日')}}</p>
                        <p>{{translate('時間')}}:
                        {{Carbon\Carbon::parse($e->start_time)->locale('ja_JP')->isoFormat('HH:mm')}}
                        ~{{Carbon\Carbon::parse($e->end_time)->locale('ja_JP')->isoFormat('HH:mm')}}
                        </p>
                        <p>{{translate('場所')}}:{{$e->address}}</p>
                    </li>
                 @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
