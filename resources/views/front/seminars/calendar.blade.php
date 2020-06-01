@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{route('seminar.index', [$school_id])}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate(\Lang::get('seminar.title.calendar'))}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div>
                <div class="calendar-noti">{{translate('講座の日付を選んでください')}}</div>
                <div id='calendar'></div>
                <div id='event_by_click_day'></div>
                <div class="change-view">
                    <input type="hidden" name="school_id" id="school_id" value="{{$school_id}}">
                    <button data="month" id="list_month"><img src="{{asset('images/front/grid.png')}}" alt=""><span>{{translate('月')}}</span></button>
                    <button data="listWeek" id="list_week"><img src="{{asset('images/front/list.png')}}" alt=""><span>{{translate('リスト')}}</span></button>
                </div>
            </div>
        </div>
     </div>
</div>
@endsection

@section('styles')
    <link href="{{url('css/front/calendar/fullcalendar.min.css')}}" rel="stylesheet">
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

  $(document).ready(function() {
         $('#calendar').fullCalendar({
             locale: 'ja',
             eventLimit: true,
             editable:true,
             displayEventTime: false,
             contentHeight: 'auto',
             eventLimit: 4,
             eventLimitText: "",
             header: {
                 right: 'custom_link'
                     },
                    customButtons: {
                       custom_link: {
                         text: '週間変更',
                         click: function(date) {
                           var month_int = $("#calendar").fullCalendar('getDate').format('MM');
                           var date_int = $("#calendar").fullCalendar('getDate').format('Y-MM-DD');
                           var custom_link = "{{route('seminar.seminarbymonth')}}"
                            + "/?type=month&month=" + month_int + "&date=" + date_int + "&school=" + '{{$school_id}}';
                            window.location.href = custom_link;
                         }
                       }
                    },
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',

            events : [
             @foreach($events as $event)
             {
                 title : '{{$event->title}}',
                 start : '{{$event->start}}',
                 end : '{{$event->end}}',
                 calendar_id:'{{$event->calendar_id}}',
                 backgroundColor: '{{$event->bg_color}}',
                 borderColor: '{{$event->bg_color}}',
                 textColor:'#ffffff',
                 allDay:'{{$event->allDay}}'
             },
             @endforeach
             @foreach($seminars as $seminar)
             {
                   title : '{{$seminar->subject}}',
                   start : '{{$seminar->start_time}}',
                   end : '{{$seminar->end_time}}',
                   backgroundColor: '{{$schools_color['seminar_color']}}',
                    borderColor: '{{$schools_color['seminar_color']}}',
                    textColor:'#ffffff'
             },
             @endforeach
            ],
            viewRender: function (view,event,calEvent,date) {
                $('.fc table').css({'border-collapse':'separate'});
            },
            eventAfterAllRender: function(event,element){
                $('.fc-day-grid-container').css("height","100% !important");
            },
            eventRender: function(event, element) {},

            dayClick: function(date, jsEvent, view) {
                $('.calendar .fc td').css({'border':'none'});
                var school_id = $('#school_id').val();
                $(this).attr('style', 'border: 2px solid red !important');
                 var start = date.format();
                 $.ajax({
                      url: '{{route('seminar.usereventclick')}}',
                      type: 'POST',
                      dataType: 'html',
                      data: {start_date: start, school_id : "{{$school_id}}"},
                      success: function (rs) {
                          $('#event_by_click_day').html(rs);
                          $('body, html').scrollTop($("#event_by_click_day").offset().top);
                      }
                  })
             },
             eventClick: function (calEvent, jevent, view, info) {
                var school_id = $('#school_id').val();
                 var start = moment(calEvent.start).format('YYYY-MM-DD');
                 $(".fc-day").each(function () {
                     var weekDayIndex = $(this).attr("data-date");
                     if (weekDayIndex == start) {
                         $('td.fc-day').css({'border': 'none'});
                         $(this).attr('style', 'border: 2px solid red !important');
                     }
                 });
                 $.ajax({
                     url: '{{route('seminar.usereventclick')}}',
                     type: 'POST',
                     dataType: 'html',
                     data: {start_date: start, school_id : "{{$school_id}}"},
                     success: function (rs) {
                         var event_exist = $(rs).find(".event").length;
                         $('#event_by_click_day').html(rs);
                         if (event_exist > 0) {
                             $('body, html').scrollTop($("#event_by_click_day").offset().top);
                         }
                     }
                 })
             }
         })

         var date_int = $("#calendar").fullCalendar('getDate').format('Y-MM-DD');
           var month_int = $("#calendar").fullCalendar('getDate').format('MM');
           var url = "{{route('seminar.seminarbymonth')}}"
                      + "/?type=month&month=" + month_int + "&date=" + date_int + "&school=" + '{{$school_id}}';
           $('#list_week').on("click", function() {
                   window.location.href = url;
                   });
           $('#list_month').on("click", function() {
                    window.location.href = '{{ route('seminar.calendar',[$school_id]) }}';
                    });
  });
</script>
@endpush