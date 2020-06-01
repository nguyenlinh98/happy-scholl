@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('お知らせ')}}</h3>
                </div>
                <div class="calendar letter log">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="list-card">
                    @if($notifications)
                        @foreach($notifications as $notification)
                            <div class="i-card @if($notification->read ==1) seen @endif">
                                <h4>{{translate($notification->subject)}}</h4>
                                <div class="description">
                                    <p>{{translate(showDateJP($notification->created_at))}}</p>
                                    <p>{{translate('配信者')}}：
                                        {{translate($notification->sender)}}
                                    </p>
                                    <span>{{translate($notification->body)}}</span>
                                </div>
                            </div>
                        @endforeach
                      @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .i-card.seen {
            background: #CBCCCC;
        }
    </style>
@endsection