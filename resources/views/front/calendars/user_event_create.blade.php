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
            <div class="calendar">
                <div class="title">{{translate(getSchoolName())}}</div>
                {{--<div class="btn-cl">
                    <button class="btn-school ahref" data-href="{{ route('front.calendar.share') }}">
                        {{translate('カレンダーの共有・編集')}}
                    </button>
                    <button class="btn-school ahref" data-href="{{route('front.calendar.usereventcreate')}}?date={{Carbon\Carbon::parse()->isoFormat('YYYY-MM-DD')}}">
                        {{translate('予定入力')}}
                    </button>
                </div>--}}
                @include('layouts.partials.flash_message')
                <div class="add-event">
                    <div class="title">{{translate('予定の入力')}}</div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger"><br>{{translate($error)}}</p>
                        @endforeach
                    @endif
                    <form method="post" id="user_event_create" action="{{route('front.calendar.usereventstore')}}">
                          @csrf
                          @method('PATCH')
                    <ul>
                        <li class="action">
                            <a href="{{route('front.calendar.index')}}">{{translate('キャンセル')}}</a>
                            <a href="#" id="btn_submit_form" style="padding-left:26%;">{{translate('決定')}}</a>
                        </li>
                        <li><input type="text" value="{{old('title')}}" placeholder="{{translate('タイトル入力')}}" name="title"></li>
                        <li>
                            <div class="choose-time">
                                <div>
                                    <span id="label_start_date">
                                    {{Carbon\Carbon::parse($date)->locale('ja_JA')->isoFormat('M')}}{{translate('月')}}
                                    {{Carbon\Carbon::parse($date)->locale('ja_JA')->isoFormat('D')}}{{translate('日')}}
                                    ({{Carbon\Carbon::parse($date)->locale('ja_JA')->minDayName}})
                                    </span>
                                    <input type="text" readonly="readonly" id="start_date" name="start_date" value="{{old('start_date')?old('start_date'):Carbon\Carbon::parse()->locale('ja_JA')->isoFormat('Y-MM-DD HH:mm')}}" style="text-align: center !important;">
                                </div>
                                <div>_</div>
                                <div>
                                    <span id="label_end_date">
                                    {{Carbon\Carbon::parse($date)->locale('ja_JA')->isoFormat('M')}}{{translate('月')}}
                                    {{Carbon\Carbon::parse($date)->locale('ja_JA')->isoFormat('D')}}{{translate('日')}}
                                    ({{Carbon\Carbon::parse($date)->locale('ja_JA')->minDayName}})
                                    </span>
                                    <input type="text" id="end_date" name="end_date" value="{{old('end_date')?old('end_date'):Carbon\Carbon::parse()->locale('ja_JA')->isoFormat('Y-MM-DD HH:mm')}}" readonly="readonly">
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
                                        <option value="{{$k}}" {{old('event_remind') == $k ? 'selected' : ''}}>{{$event_remind}}</option>
                                    @endforeach
                                </select>{{translate('分前')}}
                            </a>
                        </li>
                    </ul>
                        <input type="hidden" id="startdate" name="startdate" value="{{$date}}">
                        <input type="hidden" id="data_color" name="data_color" value ="">
                     </form>
                </div>
            </div>
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
        $('#user_event_create').submit();
    });

    $(".color_event").each(function() {
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