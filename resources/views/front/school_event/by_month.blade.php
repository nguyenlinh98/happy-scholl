@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{route('schoolevent.calendar',[$school_id])}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate(\Lang::get('schoolevent.title.eventbymonth'))}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div>
                <div class="list-week">
                    <div class="bar-title">
                    <span>{{ Carbon\Carbon::parse($date_now)->locale('ja_JP')->isoFormat('YYYY\年M\月') }}</span>
                    </div>
                    <div class="day-in-week">
                      @foreach($arr_date as $k => $event1)
                      <a href="@if(isset($arr_link[$k])){{$arr_link[$k]}}@else#@endif">
                      {{--<a href="{{ route('schoolevent.eventbyday') }}?date={{$k}}&school={{$school_id}}">--}}
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
                                            @if(isset($event['type']) && $event['type'] == 1)
                                                {{translate('終日')}}
                                            @else
                                                {{Carbon\Carbon::parse($event['scheduled_at'])->format('H')}}:
                                                {{Carbon\Carbon::parse($event['scheduled_at'])->locale('ja_JA')->format('i')}}<br>
                                                {{Carbon\Carbon::parse($event['deadline_at'])->locale('ja_JA')->format('H')}}:
                                                {{Carbon\Carbon::parse($event['deadline_at'])->locale('ja_JA')->format('i')}}
                                            @endif
                                            </span>
                                        </div>
                                        @if(isset($event['calendars']) && is_array($event['calendars']))
                                            <div class="content-event" style="background-color:{{$event['bg_color']}};">
                                                <span style="color: {{$event['title_color']}} !important;">
                                                    {{$event['title']}}
                                                </span>
                                            </div>
                                         @else
                                             <div class="content-event" style="background-color:{{$schools_color['event_color']}};">
                                               <span style="color: white !important;">
                                                   {{$event['subject']}}
                                               </span>
                                           </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            @else  {{--if array event 1--}}
                                <div class="list-event">
                                    <div class="event">
                                        <div class="time-to">
                                        </div>
                                        <div class="content-event2">{{--no event--}}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        </a>
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
@endsection
@push('script')
<script>
    $(document).ready(function() {
     var date_int = '{{$date_now}}';
               var month_int = '{{Carbon\Carbon::parse($date_now)->format('m')}}';
               var url = "{{route('schoolevent.eventbymonth')}}"
                          + "/?type=month&month=" + month_int + "&date=" + date_int + "&school=" + '{{$school_id}}';
               $('#list_week').on("click", function() {
                       window.location.href = url;
                       });
               $('#list_month').on("click", function() {
                        window.location.href = '{{ route('schoolevent.calendar',[$school_id]) }}';
                        });
      });
</script>
@endpush