@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{route('front.calendar.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('カレンダー')}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchoolName())}}</div>
                <div class="btn-cl">
                    <button class="btn-school ahref" style="margin-right: 20px; width: auto;" data-href="{{route('front.calendar.share')}}">
                        {{translate('カレンダーの共有・編集')}}
                    </button>
                    <button class="btn-school ahref" style="width: auto;" data-href="{{route('front.calendar.usereventcreate')}}?date={{Carbon\Carbon::parse()->isoFormat('YYYY-MM-DD')}}">
                    {{translate('予定入力')}}</button>
                </div>
                <div class="list-week">
                    <div class="bar-title">
                    <span>{{ Carbon\Carbon::parse($date_now)->locale('ja_JP')->isoFormat('YYYY\年M\月') }}</span>
                    {{--<button data="month" style="float: right;" id="by_date">
                       <a href='{{ route("front.calendar.showeventbymonth",[$student_id,$school_id,$class_id])."/?type=date&date=$date_now" }}'>{{translate('日')}}</a>
                    </button>--}}
                    </div>
                    <div class="day-in-week">
                      @foreach($arr_date as $k => $event1)
                        <div class="day">
                            <div class="show-time">
                            @if((isset($arr_special_color[$k]) && $arr_special_color[$k] == 'red')
                                || Carbon\Carbon::parse($k)->format('D') == 'Sun')
                                <div style="color: red;">
                            @elseif(Carbon\Carbon::parse($k)->format('D') == 'Sat')
                                 <div style="color: blue;">
                            @else
                                <div>
                            @endif
                                    {{Carbon\Carbon::parse($k)->locale('ja_JA')->day}}
                                     <span>{{Carbon\Carbon::parse($k)->locale('ja_JA')->minDayName}}</span>
                                </div>
                            </div>
                            @if(isset($event1) && is_array($event1))
                                <div class="list-event">
                                    @foreach($event1 as $event)
                                    <div class="event">
                                        <div class="time-to">
                                            <span>
                                            @if($event['type'] == 1)
                                            {{translate('終日')}}
                                            @else
                                            {{Carbon\Carbon::parse($event['start'])->format('h')}}:
                                            {{Carbon\Carbon::parse($event['start'])->locale('ja_JA')->format('i')}}<br>
                                            {{Carbon\Carbon::parse($event['end'])->locale('ja_JA')->format('h')}}:
                                            {{Carbon\Carbon::parse($event['end'])->locale('ja_JA')->format('i')}}
                                            @endif
                                            </span>
                                        </div>
                                        <div class="content-event" style="background-color:{{$event['bg_color']}};">
                                            <span style="color: {{$event['title_color']}} !important;">
                                            @if($calendarId == $event['calendar_id'])
                                            <a style="color: {{$event['title_color']}}" href="{{ route('front.calendar.usereventedit', [$event['id']]) }}">
                                                {{$event['title']}}
                                            </a>
                                            @else
                                            <a style="color: {{$event['title_color']}}" href="{{ route('front.calendar.event-detail', [$event['id']]) }}">
                                                {{$event['title']}}
                                            </a>
                                            @endif
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <i class="fas fa-plus click_to_add" data-date="{{Carbon\Carbon::parse($k)->isoFormat('YYYY-MM-DD')}}"></i>
                            @else
                                <div class="list-event">
                                    <div class="event">
                                        <div class="time-to">
                                        </div>
                                        <div class="content-event2"></div>
                                    </div>
                                </div>
                                <i class="fas fa-plus click_to_add" data-date="{{Carbon\Carbon::parse($k)->isoFormat('YYYY-MM-DD')}}"></i>
                            @endif
                        </div>
                      @endforeach
                    </div>
                </div>
                <div class="change-view">
                    <button data="month" id="list_month"><img src="{{asset('images/front/grid.png')}}" alt=""><span>{{translate('月')}}</span></button>
                    <button data="listWeek" id="list_week"><img src="{{asset('images/front/list.png')}}" alt=""><span>{{translate('リスト')}}</span></button>
                </div>
            </div>
        </div>
     </div>
</div>

<style>
        .change-view button {
            background: unset;
            border: 0;
            margin-right: 10px;
        }
        .change-view button span {
            font-size: 12px;
        }
        .calendar .btn-school {
            font-size:13px !important;
        }
</style>
@endsection
@push('script')
<script src="{{url('js/front/calendar/moment.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $(".click_to_add").each(function() {
        $(this).on("click", function() {
            var data_date = $(this).attr('data-date');
            var url = "{{route('front.calendar.usereventcreate')}}?date=" + data_date;
            window.location.href = url;
        });

    });

          var date_int = '{{$date_now}}';
          var month_int = '{{Carbon\Carbon::parse($date_now)->format('m')}}';
          var url = "{{route('front.calendar.showeventbymonth')}}"
                     + "/?type=month&month=" + month_int + "&date=" + date_int;
          $('#list_week').on("click", function() {
                  window.location.href = url;
                  });
          $('#list_month').on("click", function() {
                   window.location.href = '{{ route('front.calendar.index') }}';
                   });
  });
</script>
@endpush
