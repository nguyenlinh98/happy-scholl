@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{ route('recycle.productregister')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar recycle">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="status-app">
                        @if(!is_null($recycle_place))
                            <h5>{{translate('持込・受取り場所')}}</h5>
                            <div class="profiles">
                                <button
                                    class="place_list"> {{ $recycle_place->place }} <br>{{ $recycle_place->date}}
                                    <br>{{ $recycle_place->start_time}}～{{ $recycle_place->end_time}}</button>
                            </div>
                        @else
                            <h5>持込・受取り場所が設定されておりません。</h5>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
