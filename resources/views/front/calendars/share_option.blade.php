@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{url()->previous()}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('カレンダー')}}</h3>
                </div>
                <form method="POST" action="{{route('front.calendar.share-save')}}">
                @csrf
                <div class="calendar">
                    <div class="title">{{translate(getSchoolName())}}</div>
                        <a href="{{route('front.calendar.edit')}}"><div class="head">{{translate('カレンダーの背景選択')}}</div></a>
                    <div class="check-list">
                        @foreach($arr as $key => $item)
                            @foreach($item as $key1 => $item1)
                                @if($loop->first && strpos($key1, 'school') !== false)
                                    <div class="school-name">{{reset($item1)}}</div>
                                @endif
                                @foreach($item1 as $key2 => $item2)
                                    <label class="container-radio">{{translate($item2)}}
                                        <input class="filter_check" type="checkbox"
                                               @if(in_array($key2, $arr_id_filter_save)) checked="checked" @endif
                                               name="filters[]" value="{{$key2}}">
                                        <span class="checkmark"></span>
                                    </label>
                                @endforeach
                            @endforeach
                        @endforeach
                    </div>
                    <img src="{{asset('images/front/quote_image.png')}}" alt="">
                </div>
                <button type="submit" id="btn_filter" class="btn-login margin-top-30">{{translate('送信')}}</button>
                 </form>
            </div>
        </div>
    </div>
    <style>
        .school-name {
            background: #97C741;
            font-size: 22px;
            color: #fff;
            text-align: center;
            margin: 15px;
            padding: 5px 15px;
        }
    </style>
@endsection