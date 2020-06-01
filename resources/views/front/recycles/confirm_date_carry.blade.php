@extends('front.layouts.front')
@section('content')
    @php
        $listHours = getListHour();
        $listDate = getListDate();
    @endphp
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.recycle.provide.index')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar recycle new">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="heading">{{translate('リサイクル品の'.$product->name.'の')}}<br/>
                        申込みがありました。
                    </div>
                    <div class="alert">{{translate('申込者にメッセージをしてください。')}}</div>
                    <form action="{{route('front.recycle.product.confirm-date-post',$product->id)}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">指定場所の持込み場所は</label>
                            <select type="text" style="width: 100%" name="recycle_place_id" class="form-control"
                                    id="place">
                                @foreach($listPlace as $place)
                                    <option value="{{$place->id}}" data-date="{{$place->date}}"
                                            data-time="{{$place->start_time.'～'.$place->end_time}}">{{$place->place}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(count($listPlace) != 0)
                            <div class="form-group">
                                <label for="time">{{translate('日時は')}}</label>
                                <input type="text" class="form-control" id="date_time" value="{{$listPlace->first()->date }}"
                                       disabled>
                                <input type="text" class="form-control" id="time" value="{{$listPlace->first()->time }}"
                                disabled>
                                までです。
                            </div>
                        @else
                            <div class="form-group">
                                <label for="time">{{translate('日時は')}}</label>
                                <input type="text" class="form-control" id="date" value="{{translate('平日')}}" disabled>
                                <input type="text" class="form-control" id="time" value="00:00〜00:00" disabled>
                                までです。
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="option">{{translate('持込日')}}</label>
                            <select name="carrying_from_datetime" id="option" class="form-control">
                                @foreach($listDate as $date)
                                    <option value="{{$date}}">{{showDateJapan($date)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="time-s">{{translate('時間')}}</label>
                            <select name="carrying_from_datetime_hour" id="time-s" class="form-control time">
                                @foreach($listHours as $hours)
                                    <option value="{{$hours}}">{{$hours}}</option>
                                @endforeach
                            </select>
                        </div>
                        <h5>から</h5>
                        <div class="form-group">
                            <label for="option-2">{{translate('持込日')}}</label>
                            <select name="carrying_to_datetime" id="option-2" class="form-control">
                                @foreach($listDate as $date)
                                    <option value="{{$date}}">{{showDateJapan($date)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="time-s-2">{{translate('時間')}}</label>
                            <select name="carrying_to_datetime_hour" id="time-s-2" class="form-control time">
                                @foreach($listHours as $hours)
                                    <option value="{{$hours}}">{{$hours}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('carrying_to_datetime_hour'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('carrying_to_datetime_hour') }}</strong>
                                </span>
                            @endif
                        </div>
                        <p class="lastp">{{translate('までに指定場所へ')}}<br/>
                            {{translate('持って行きます。')}}</p>
                        <button type="submit" class="btn-school">
                            {{translate('申込者に送る内容を')}}<br/>
                            {{translate('確認する')}}
                        </button>
                        <img src="{{asset('images/front/boy.png')}}" alt="">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        .recycle.new select {
            border: solid 1px #ddd;
        }
    </style>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            let date = $(this).find('option:selected').data('date');
            let time = $(this).find('option:selected').data('time');
            $('#time').val(time);
            $('#date').val(date);
            $('#place').change(function () {
                let date = $(this).find('option:selected').data('date');
                let time = $(this).find('option:selected').data('time');
                $('#time').val(time);
                $('#date').val(date);
            });
        });
    </script>
@endsection
