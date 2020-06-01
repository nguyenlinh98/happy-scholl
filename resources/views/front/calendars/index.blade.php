@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('カレンダー')}}</h3>
                </div>
                <div class="calendar">
                    @if($getCalendarTheme && $getCalendarTheme->type == \App\Models\CalendarTheme::TYPE_ORIGINAL)
                        <div class="show_icon">
                            @if(count($arrListImage)!=0)
                                <ul class="list-circle">
                                    @for($i = 0 ; $i <5 ; $i ++)
                                        <li><img id="original_img_{{$i+1}}"
                                                 src="{{ $arrListImage[$i%count($arrListImage)] }}"/>
                                        </li>
                                    @endfor
                                </ul>
                            @endif
                        </div>
                    @endif
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="btn-cl">
                        <button class="btn-school ahref" data-href="{{ route('front.calendar.share') }}">
                            {{translate('カレンダーの共有・編集')}}
                        </button>
                        <button class="btn-school ahref" data-href="{{route('front.calendar.usereventcreate')}}?date={{Carbon\Carbon::parse()->isoFormat('YYYY-MM-DD')}}">
                            {{translate('予定入力')}}
                        </button>
                    </div>
                    <div id='calendar'></div>
                    <div id='event_by_click_day'></div>
                    <div class="change-view">
                        <button data="month" id="list_month"><img src="{{asset('images/front/grid.png')}}"
                                                                  alt=""><span>{{translate('月')}}</span></button>
                        <button data="listWeek" id="list_week"><img src="{{asset('images/front/list.png')}}"
                                                                    alt=""><span>{{translate('リスト')}}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="{{url('css/front/calendar/fullcalendar.min.css')}}" rel="stylesheet">
    <style>
        td.fc-more-cell {
            display: none;
        }

        ul.list-circle {
            padding: 0 !important;
        }

        .change-view button {
            background: unset;
            border: 0;
            margin-right: 10px;
        }

        .change-view button span {
            font-size: 12px;
        }

        .select-theme .fc-view, .select-theme .fc-view > table {
            background: rgb(239, 248, 254, 0.2) !important;
        }
        .calendar .btn-school {
                    font-size:13px !important;
                }
    </style>
@endsection

@push('script')
    <script src="{{url('js/front/calendar/moment.min.js')}}"></script>
    <script src="{{url('js/front/calendar/fullcalendar.min.js')}}"></script>
    <script src="{{url('js/front/calendar/scheduler.min.js')}}"></script>
    <script src="{{url('js/front/calendar/ja.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            // $('.fc table').css({'border-collapse':'separate'});
            var imageUrl = "{{isset($getCalendarTheme)?$getCalendarTheme->getBackGroupImg():''}}";
            @if(file_exists(public_path($theme_calendar)))
            $(".bg-gd").css({
                "background-image": "url(" + imageUrl + ")",
                'background-repeat': 'no-repeat',
                'background-size': 'cover'
            });
            @endif
            @if($getCalendarTheme && $getCalendarTheme->type == "select")
            $('#calendar').addClass("select");
            @endif
            $('#calendar').fullCalendar({
                locale: "{{(\Session::get('lang'))?\Session::get('lang'):\Illuminate\Support\Facades\Lang::getLocale()}}",
                eventLimit: 3,
                eventLimitText: "",
                editable: true,
                displayEventTime: false,
                fixedWeekCount: false,
                swiping : true,
                draggable: true,
                dragScroll:true,
                contentHeight: 'auto',
                header: {
                    //left: 'month,basicWeek,basicDay,listMonth',
                    right: 'prev,next'
                },
                //footer: {
                //left: 'month, custom1'
                // },
                customButtons: {
                    custom1: {
                        text: '{{translate('リスト')}}',
                        click: function (date) {
                            var month_int = $("#calendar").fullCalendar('getDate').format('MM');
                            var date_int = $("#calendar").fullCalendar('getDate').format('Y-MM-DD');
                            var url = "{{route('front.calendar.showeventbymonth')}}"
                                + "/?type=month&month=" + month_int + "&date=" + date_int;
                            window.location.href = url;
                        }
                    }
                },
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',

                events: [
                        @foreach($events as $event)
                    {
                        title: '{{translate($event->title)}}',
                        start: '{{$event->start}}',
                        end: '{{$event->end}}',
                        calendar_id: '{{$event->calendar_id}}',
                        backgroundColor: '{{$event->bg_color}}',
                        borderColor: '{{$event->bg_color}}',
                        textColor: '#ffffff',
                        allDay: '{{$event->allDay}}'
                    },
                    @endforeach
                ],
                eventAfterAllRender: function (event, element) {
                    $('.fc table').css({'border-collapse': 'separate'});
                    $('.fc-day-grid-container').css("height", "100% !important");
                },
                eventRender: function (event, element) {
                },

                dayClick: function (date, jsEvent, view) {
                    $('.calendar .fc td').css({'border': 'none'});
                    $(this).attr('style', 'border: 2px solid red !important');
                    var start = date.format();
                    $.ajax({
                        url: '{{route('front.calendar.usereventclick')}}',
                        type: 'POST',
                        dataType: 'html',
                        data: {start_date: start},
                        success: function (rs) {
                            var event_exist = $(rs).find(".event").length;
                            $('#event_by_click_day').html(rs);
                            $("#event_by_click_day").insertBefore(".fc-toolbar.fc-footer-toolbar");
                            if (event_exist > 0) {
                                $('body, html').scrollTop($("#event_by_click_day").offset().top);
                            }
                        }
                    })
                },
                eventClick: function (calEvent, jevent, view, info) {
                    var start = moment(calEvent.start).format('YYYY-MM-DD');
                    $(".fc-day").each(function () {
                        var weekDayIndex = $(this).attr("data-date");
                        if (weekDayIndex == start) {
                            $('td.fc-day').css({'border': 'none'});
                            $(this).attr('style', 'border: 2px solid red !important');
                        }
                    });
                    $.ajax({
                        url: '{{route('front.calendar.usereventclick')}}',
                        type: 'POST',
                        dataType: 'html',
                        data: {start_date: start},
                        success: function (rs) {
                            var event_exist = $(rs).find(".event").length;
                            $('#event_by_click_day').html(rs);
                            $("#event_by_click_day").insertBefore(".fc-toolbar.fc-footer-toolbar");
                            if (event_exist > 0) {
                                $('body, html').scrollTop($("#event_by_click_day").offset().top);
                            }
                        }
                    })
                }
            })

            var date_int = $("#calendar").fullCalendar('getDate').format('Y-MM-DD');
            var month_int = $("#calendar").fullCalendar('getDate').format('MM');
                        $('#list_week').attr('data-date',date_int);
                        $('#list_week').attr('data-month',month_int);
            $('.fc-next-button, .fc-prev-button').on("click", function () {
                var date_int = $("#calendar").fullCalendar('getDate').format('Y-MM-DD');
                var month_int = $("#calendar").fullCalendar('getDate').format('MM');
                $('#list_week').attr('data-date',date_int);
                $('#list_week').attr('data-month',month_int);
            });

            //var date_int = $("#calendar").fullCalendar('getDate').format('Y-MM-DD');
            //var month_int = $("#calendar").fullCalendar('getDate').format('MM');
            $('#list_week').on("click", function () {
                var date_int = $('#list_week').attr('data-date');
                var month_int = $('#list_week').attr('data-month');
                var url = "{{route('front.calendar.showeventbymonth')}}"
                                + "/?type=month&month=" + month_int + "&date=" + date_int;
                window.location.href = url;
            });
            $('#list_month').on("click", function () {
                window.location.href = '{{ route('front.calendar.index') }}';
            });
        });
    </script>
@endpush
