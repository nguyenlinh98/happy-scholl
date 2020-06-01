@extends('front.layouts.front')
@section('content')
@php($option_event_user = hsp_getConfig('event_user'))
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{route('front.calendar.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('カレンダー')}}</h3>
            </div>

@if($event->calendar_id == $calendar_user)

        <div class="calendar">
            <div class="title">{{translate(getSchoolName())}}</div>
            @include('layouts.partials.flash_message')
            <div class="add-event">
                <div class="title">{{translate('予定の編集')}}</div>
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="text-danger"><br>{{translate($error)}}</p>
                    @endforeach
                @endif
                <form method="post" id="user_event_update" action="{{route('front.calendar.usereventupdate',[$id])}}">
                @csrf
                <ul>
                    <li class="action">
                        <a href="{{route('front.calendar.index')}}">{{translate('キャンセル')}}</a>
                        <a href="#" id="btn_submit_form">{{translate('決定')}}</a>
                        <a href="#"
                        onclick="event.preventDefault();document.getElementById('formDel-{{$id}}').submit();" style="width: 15%;">
                        {{translate('削除')}}</a>
                    </li>
                    <li><input type="text" placeholder="{{translate('タイトル入力')}}" name="title" value="{{old('title')?old('title'):$event->title}}"></li>
                    <li>
                        <div class="choose-time">
                            <div>
                                <span id="label_start_date">
                                {{Carbon\Carbon::parse($date_start)->locale('ja_JA')->isoFormat('M')}}{{translate('月')}}
                                {{Carbon\Carbon::parse($date_start)->locale('ja_JA')->isoFormat('D')}}{{translate('日')}}
                                ({{Carbon\Carbon::parse($date_start)->locale('ja_JA')->minDayName}})
                                </span>
                                <input type="text" id="start_date" name="start_date" readonly="readonly"
                                value="{{old('start_date')?old('start_date'):Carbon\Carbon::parse($event->start)->locale('ja_JA')->isoFormat('Y-MM-DD HH:mm')}}" style="text-align: center !important;">
                            </div>
                            <div>_</div>
                            <div>
                                <span id="label_end_date">
                                {{Carbon\Carbon::parse($date_end)->locale('ja_JA')->isoFormat('M')}}{{translate('月')}}
                                {{Carbon\Carbon::parse($date_end)->locale('ja_JA')->isoFormat('D')}}{{translate('日')}}
                                ({{Carbon\Carbon::parse($date_end)->locale('ja_JA')->minDayName}})
                                </span>
                                <input type="text" id="end_date" name="end_date" readonly="readonly"
                                    value="{{old('end_date')?old('end_date'):Carbon\Carbon::parse($event->end)->locale('ja_JA')->isoFormat('Y-MM-DD HH:mm')}}">
                            </div>
                        </div>
                        <div class="sw-d">
                            <span>{{translate('終日')}} <small>{{translate('OFF')}}</small></span>
                            <label class="switch">
                                <input type="checkbox" id="all_day_event" name="all_day_event">
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </li>
                    <li>
                        <img src="{{asset('images/front/color.png')}}" alt="">
                        <label>{{translate('カラー')}}</label>
                        <div class="list-color">
                            @foreach($option_event_user['event_color'] as $item)
                                <span class="color_event" style="background:{{$item}}" data-color="{{$item}}"></span>
                            @endforeach
                        </div>
                    </li>
                    <li><img src="{{asset('images/front/ring.png')}}" alt="">
                        <label>{{translate('通知')}}</label>
                        <a href="#">{{translate('予定時間')}}:
                            <select name="event_remind">
                                @foreach($option_event_user['event_remind'] as $k => $event_remind)
                                    <option value="{{$k}}"
                                    @if($k == $event->remind || $k == old('event_remind')) selected="selected"
                                    @endif>
                                    {{$event_remind}}
                                    </option>
                                @endforeach
                            </select>{{translate('分前')}}
                        </a>
                    </li>
                </ul>
                    <input type="hidden" id="startdate" name="startdate" value="{{$date_start}}">
                    <input type="hidden" id="enddate" name="enddate" value="{{$date_end}}">
                    <input type="hidden" id="data_color" name="data_color" value ="">
                 </form>

                 <form action="{{route('front.calendar.usereventdestroy',[$id])}}" method="POST"
                     id="formDel-{{$id}}" style="display:none;">
                   @csrf
                 </form>
            </div>
        </div>
@else
{{--event for school, class detail--}}
          <div class="calendar">
                <div class="title">{{translate(getSchoolName())}}</div>
                <div class="add-event">
                    <div class="title">{{translate('予定の編集')}}</div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger"><br>{{translate($error)}}</p>
                        @endforeach
                    @endif
                    <form method="post" id="user_event_update" action="{{route('front.calendar.usereventupdate',[$id])}}">
                          @csrf
                    <ul>
                        <li class="action">
                            <a href="{{route('front.calendar.index')}}">{{translate('キャンセル')}}</a>
                        </li>
                        <li><input type="text" placeholder="{{translate('タイトル入力')}}" name="title" value="{{old('title')?old('title'):$event->title}}"></li>
                        <li>
                            <div class="choose-time">
                                <div>
                                    <span id="label_start_date">
                                    {{Carbon\Carbon::parse($date_start)->locale('ja_JA')->isoFormat('M')}}{{translate('月')}}
                                    {{Carbon\Carbon::parse($date_start)->locale('ja_JA')->isoFormat('D')}}{{translate('日')}}
                                    ({{Carbon\Carbon::parse($date_start)->locale('ja_JA')->minDayName}})
                                    </span>
                                    <input type="text" id="start_date1" name="start_date" readonly="readonly"
                                    value="{{old('start_date')?old('start_date'):Carbon\Carbon::parse($event->start)->locale('ja_JA')->isoFormat('Y-MM-DD HH:mm')}}" style="text-align: center !important;">
                                </div>
                                <div>_</div>
                                <div>
                                    <span id="label_end_date">
                                    {{Carbon\Carbon::parse($date_end)->locale('ja_JA')->isoFormat('M')}}{{translate('月')}}
                                    {{Carbon\Carbon::parse($date_end)->locale('ja_JA')->isoFormat('D')}}{{translate('日')}}
                                    ({{Carbon\Carbon::parse($date_end)->locale('ja_JA')->minDayName}})
                                    </span>
                                    <input type="text" id="end_date1" name="end_date" readonly="readonly"
                                        value="{{old('end_date')?old('end_date'):Carbon\Carbon::parse($event->end)->locale('ja_JA')->isoFormat('Y-MM-DD HH:mm')}}">
                                </div>
                            </div>
                            <div class="sw-d">
                                <span>{{translate('終日')}} <small>{{translate('OFF')}}</small></span>
                                <label class="switch">
                                    <input type="checkbox" id="all_day_event" name="all_day_event">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </li>
                        <li>
                            <img src="{{asset('images/front/color.png')}}" alt="">
                            <label>{{translate('カラー')}}</label>
                            <div class="list-color">
                                @foreach($option_event_user['event_color'] as $item)
                                    <span class="color_event1" style="background:{{$item}}" data-color="{{$item}}"></span>
                                @endforeach
                            </div>
                        </li>
                        <li><img src="{{asset('images/front/ring.png')}}" alt="">
                            <label>{{translate('通知')}}</label>
                            <a href="#">{{translate('予定時間')}}:
                                <select name="event_remind" disabled>
                                    @foreach($option_event_user['event_remind'] as $k => $event_remind)
                                        <option value="{{$k}}"
                                        @if($k == $event->remind || $k == old('event_remind')) selected="selected"
                                        @endif>
                                        {{$event_remind}}
                                        </option>
                                    @endforeach
                                </select>{{translate('分前')}}
                            </a>
                        </li>
                        <li>
                            <label>{{translate('詳細')}}</label>
                            <div class="list-color" style="text-align: left !important;">{{translate($event->detail)}}
                            </div>
                        </li>
                    </ul>
                        <input type="hidden" id="startdate" name="startdate" value="{{$date_start}}">
                        <input type="hidden" id="enddate" name="enddate" value="{{$date_end}}">
                        <input type="hidden" id="data_color" name="data_color" value ="">
                     </form>
                </div>
            </div>
@endif
        </div>
    </div>
</div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('css/front/calendar/date_picker.css')}}">
    <style>
            .add-event input {
                font-size: 12px !important;
            }
            .calendar .btn-school {
                font-size:13px !important;
            }
    </style>
@endsection
@push('script')
<script src="{{asset('js/front/jquery/jquery.datetimepicker.full.min.js')}}"></script>
<script src="{{url('js/front/calendar/moment.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment-with-locales.min.js"></script>
<script>
    var lang_code = "{{(\Session::get('lang'))?\Session::get('lang'):\Illuminate\Support\Facades\Lang::getLocale()}}";
    $("#start_date, #end_date").datetimepicker({
          //datepicker: false,
          format: 'Y-m-d H:i',
          step: 30
    });
    $.datetimepicker.setLocale(lang_code);

    $('#btn_submit_form').on("click", function() {
        event.preventDefault();
        $('#user_event_update').submit();
    });

    var selected_type = '{{$event->type}}';
    if(selected_type == 1) {
        $('#all_day_event').prop("checked",true);
    }
    $(".color_event").each(function() {
    var selected_color_val = '{{$event->bg_color}}';
    var selected_color = $(this).attr('data-color');
    if(selected_color == selected_color_val) {
        $(this).css({'border':'3px solid red'});
    }
    $('#data_color').val(selected_color_val);

        $(this).on("click", function() {
        var color_value = $(this).attr('data-color');
            $('#data_color').val(color_value);
            $('.color_event').css({'border':'none'});
            $(this).css({'border':'3px solid red'});
        });
    });

    $(".sw-d label input").change(function() {
            if(this.checked) {
                $('#end_date, #start_date').attr('disabled', 'disabled');
                $('#end_date').val(''); $('#start_date').val('');
            }else {
                $('#end_date, #start_date').removeAttr('disabled');
            }
     });
     if($('.sw-d label input:checked').length > 0){
         $('#end_date, #start_date').attr('disabled', 'disabled');
         $('#end_date').val(''); $('#start_date').val('');
     }else{
          $('#end_date, #start_date').removeAttr('disabled');
     }

     $("#start_date").change(function() {
          var start_date = moment($(this).val());
          var day = start_date.format("D");
          var month = start_date.format("M");
          var weekDayName = start_date.locale("ja").format('ddd');
          var rs =  month + '月' +  day + '日' + '(' + weekDayName + ')';
          $('#label_start_date').html(rs);
       });
       $("#end_date").change(function() {
            var start_date = moment($(this).val());
            var day = start_date.format("D");
            var month = start_date.format("M");
            var weekDayName = start_date.locale("ja").format('ddd');
            var rs =  month + '月' +  day + '日' + '(' + weekDayName + ')';
            $('#label_end_date').html(rs);
        });
</script>
@endpush