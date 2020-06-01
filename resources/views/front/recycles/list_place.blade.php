@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{ route('front.recycle.provide.index')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar recycle">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="status-app">
                        <h5>{{translate('持込・受取り場所')}}</h5>
                        @foreach( $lists as $list)
                            <div class="profiles">
                                <button class="place_list"> {{ $list->place }} <br>{{ $list->date}}
                                    <br>{{ $list->start_time}}～{{ $list->end_time}}</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
