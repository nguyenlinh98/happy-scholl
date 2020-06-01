@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.recycle.notice')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar recycle">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="status-app">
                        @if(count($provides) != 0)
                            <h5>{{translate('お申込みの状況')}}</h5>
                            @foreach( $provides as $provide)
                                <div class="profiles">
                                    <a href="{{ route('recycle.showPlace',['id'=> $provide->id])}}">
                                        <button class="btn-place">{{translate('受取り場所を確認する')}}</button>
                                    </a>
                                </div>
                                <div class="preview thumb-in-1">
                                    <a href="{{route('front.recycle.show', $provide->id) }}">
                                        <figure><img src="{{$provide->getThumbnailImage()}}" alt=""></figure>
                                        <span>{{translate($provide->name)}}</span>
                                    </a>
                                </div>
                                @if($provide->status !=4)
                                    <button class="btn-school btn-grey">{{translate('受取り連絡する')}}</button>
                                @else
                                    <a href="{{ route('recycle.confirm_register',$provide->id) }}">
                                        <button class="btn-school">{{translate('受取り連絡する')}}</button>
                                    </a>
                                @endif

                                <h5>{{translate('通知')}}</h5>
                                @if( !empty($provide->carrying_from_datetime) && !empty($provide->carrying_to_datetime))
                                    <div class="text-w">
                                        {{$provide->toLocalizeDateTime('carrying_from_datetime')}}<br/>
                                        {{translate('から')}}<br/>
                                        {{$provide->toLocalizeDateTime('carrying_to_datetime')}}<br/><br/>
                                        {{translate('までに指定場所へ持っていきます。')}}
                                    </div>
                                @endif
                                <div class="text-w">
                                    {{translate('指定のリサイクル場所')}}<br/>
                                    {{translate('に商品をお届けしました。')}}
                                </div>
                            @endforeach
                        @else
                            <h5>{{ translate('リサイクル品の申込みがありません') }}</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .btn-grey {
            background-color: #D1D2D2;
            border-color: #D1D2D2;
        }
    </style>
@endsection
