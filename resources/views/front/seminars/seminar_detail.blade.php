@extends('front.layouts.front')
@section('content')
<div class="row">
<div class="col-md-12">
    <div class="select-school">
        <!-- NAVBAR -->
        <div class="nav-top">
        <a href="{{route('seminar.calendar',[$seminar->school_id])}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                        <h3>{{translate(\Lang::get('seminar.title.calendar'))}}</h3>
        </div>
        <div class="calendar course">
            <div class="title">{{translate(getSchool()->name)}}</div>
            <div class="slide-event">
                <div class="slide owl-carousel owl-theme">
                    <?php
                        $listImg = $seminar->getImageUrl();
                      ?>
                   @if(empty($listImg))
                       <div class="item-i">
                           <figure><img src="{{asset('images/front/slide-course.png')}}" alt="">
                           </figure>
                       </div>
                   @endif
                   @foreach($listImg as $img)
                      <div class="item-i">
                           <figure><img src="{{$img}}" alt=""></figure>
                       </div>
                   @endforeach
                </div>
            </div>
            <div class="text-event">
             <h4>{{translate($seminar->subject)}}</h4>
                <p>{{translate('日時')}}: {{Carbon\Carbon::parse($seminar->start_time)->locale('ja_JP')->isoFormat('YYYY年M月D日')}}</p>
                <p>{{translate('時間')}}: {{Carbon\Carbon::parse($seminar->start_time)->locale('ja_JP')->isoFormat('HH:mm')}}
                    ~{{Carbon\Carbon::parse($seminar->end_time)->locale('ja_JP')->isoFormat('HH:mm')}}
                </p>
                <p class="text-center1">{{translate('場所')}}:{{$seminar->address}}</p>
                <?php
                $url_map = '#';
                if($seminar->address != '' || $seminar->address != null) {
                    //$url_map = 'http://maps.google.com/?q='. $seminar->address;
                    $url_map = 'https://www.google.com/maps/dir/?api=1&destination='.$seminar->address.'&dir_action=navigate';
                }
                ?>
                <a href="{{$url_map}}" class="text-center">{{translate('地図を見る')}}</a>
                <p>{{translate('定員')}}: {{$seminar->max_people}}{{translate('名')}}
                ({{translate('残り')}}: {{$seminar->max_people - $count_seminar}}{{translate('名')}})</p>
                <p>{{translate('会費')}}:@if (0 == $seminar->fee) {{ translate('無料') }}@else {{$seminar->fee}}{{translate('円')}}@endif</p>
                <p>{{translate('詳細')}}: {{$seminar->subject}}</p>
                <p class="text-width"> {{$seminar->body}}</p>
                <p>{{translate('講師')}}: {{$seminar->instructor}}</p>
                <p>{{translate('問合先')}}: {{$seminar->tel}}</p>

                <a class="text-center" href="tel:{{$seminar->tel}}">
                {{translate('電話をする')}}</a>
                <a class="text-center" href="mailto:{{$seminar->email}}?Subject=Hi" target="_top">
                {{translate('メールをする')}}</a>
                <p class="description">
                     {{translate('※ご質問や申込後のキャンセル等に')}}<br/>
                　   {{translate('ついては問合先に記載の電話または')}}<br/>
                　   {{translate('メールにてお問合せください。')}}<br/>
                </p>

                @if($seminar->need_help == 1)
                <p class="margin-top-30">{{translate('お手伝い募集について')}}</p>
                <p>{{translate('日時')}}: {{Carbon\Carbon::parse($seminar->help_scheduled_at)->locale('ja_JP')->isoFormat('YYYY年M月D日')}}</p>
                <p>{{translate('時間')}}:
                    {{Carbon\Carbon::parse($seminar->help_scheduled_at)->locale('ja_JP')->isoFormat('HH:mm')}}
                    ~{{Carbon\Carbon::parse($seminar->help_deadline_at)->locale('ja_JP')->isoFormat('HH:mm')}}
                </p>
                <p>{{translate('募集人数')}}: {{$seminar->max_help_people}}{{translate('名')}}
                    （{{translate('残り')}}<b style="color: red;">{{$seminar->max_help_people - $count_seminar_help}}</b>{{translate('名')}}）
                </p>
                {{translate('詳細')}}: <p class="text-width">{{$seminar->reason}}</p>
                <p>{{translate('問合先')}}：{{$seminar->help_tel}}</p>
                <a class="text-center" href="tel:{{$seminar->help_tel}}">
                {{translate('電話をする')}}</a>
                <a class="text-center" href="mailto:{{$seminar->help_email}}?Subject=Hi" target="_top">
                {{translate('メールをする')}}</a>
                @endif

                {{--form save to seminar--}}
                <div class="seminar_student">
                <form method="POST" action="{{route('seminar.savejoin',[$id])}}" id="form_join_seminar">
                    @csrf
                    <input type="hidden" value="{{$seminar->school_id}}" name="school_id">
                    <input type="hidden" value="" name="seminar_apply_status" id="seminar_apply_status">
                    <input type="hidden" value="" name="seminar_apply_type" id="seminar_apply_type">
                    <p class="seminar_select">
                    <p>{{translate('参加者の選択をお願いします。')}}</p>
                    <div style="margin-left: 104px; text-align: left;">
                    @foreach($studentParents as $key => $s)
                        <div class="custom-control custom-radio" style="margin-left:-15px;">
                          <input
                          @if(!is_null($seminar_student) && $seminar_student->student_id == $s->id) checked
                          @endif
                          type="radio" id="{{$s->id}}" name="student_id"
                          class="custom-control-input" value="{{$s->id}}">
                          <label class="custom-control-label" for="{{$s->id}}">{{$s->name}}</label>
                        </div>
                    @endforeach
                    </div>
                        <select name="relationship" id="option" class="form-control">
                        @foreach($seminar_relationship as $s1)
                            <option value="{{$s1}}"
                             @if(!is_null($seminar_student) && $seminar_student->relationship == $s1) selected="selected"
                             @endif
                            >{{$s1}}</option>
                        @endforeach
                        </select>
                    </p>
                </form>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="join_seminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-body">
                              {{--<p>{{translate('この講座に')}}</p>--}}
                              <p class="message_custom"></p>
                              {{--<p>{{translate('欠席連絡をして')}}</p>
                              <p>{{translate('よろしいですか？')}}</p>--}}
                              <img src="{{asset('images/front/teacher_image.png')}}" alt="">
                              <a id="btn_join_seminar" class="btn-exit" href="#" data-dismiss="modal">{{translate('はい')}}</a>
                          </div>
                      </div>
                  </div>
                </div>
                <a class="btn-login btn_seminar_apply" id="join_seminar_apply" data-toggle="modal" data-target="#join_seminar" data-whatever="{{ translate($popup_1) }}">{{translate('講座に申込む')}}</a>
                <a class="btn-login btn_seminar_apply_help" id="join_seminar_apply_help" data-toggle="modal" data-target="#join_seminar" data-whatever="{{ translate($popup_2) }}">{{translate('講座とお手伝いに申込む')}}</a>
                <a class="btn-login btn_seminar_help" id="join_seminar_help" data-toggle="modal" data-target="#join_seminar" data-whatever="{{ translate($popup_3) }}">{{translate('お手伝いのみ申込む')}}</a>
                <a class="btn-login" id="join_seminar_not_fix" data-toggle="modal" data-target="#join_seminar" data-whatever="{{ translate($popup_4) }}">{{translate('未定')}}</a>
                <a class="btn-login" id="join_seminar_cancel" data-toggle="modal" data-target="#join_seminar" data-whatever="{{ translate($popup_5) }}">{{translate('欠席')}}</a>
             </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('styles')
<link href="{{url('css/front/calendar/owl.carousel.min.css')}}" rel="stylesheet">
<link href="{{url('css/front/calendar/owl.theme.default.min.css')}}" rel="stylesheet">
@endsection

@push('script')
<script src="{{url('js/front/calendar/owl.carousel.min.js')}}"></script>
<script>
  $(document).ready(function() {
      $('#join_seminar').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget);
          var message = button.data('whatever');
          var modal = $(this);
          modal.find('.message_custom').html(message);
      });
        // check submit form
        $("#join_seminar_apply").on("click", function() {
            $('#seminar_apply_status').val('apply');
            $('#seminar_apply_type').val('');
        });
        $("#join_seminar_apply_help").on("click", function() {
            $('#seminar_apply_status').val('apply');
            $('#seminar_apply_type').val('help');
        });
        $("#join_seminar_help").on("click", function() {
            $('#seminar_apply_status').val('');
             $('#seminar_apply_type').val('help');
        });

        $("#join_seminar_not_fix").on("click", function() {
            $('#seminar_apply_status').val('not_fix');
             $('#seminar_apply_type').val('');
        });

        $("#join_seminar_cancel").on("click", function() {
            $('#seminar_apply_status').val('cancel');
             $('#seminar_apply_type').val('');
        });

        $("#btn_join_seminar").on("click", function() {
            var selected = $("input[type='radio']:checked");
            if (selected.length == 0) {
                $('input[type=radio]:first').prop('checked', 'checked');
            }
            $('#form_join_seminar').submit();
        });
  });
</script>
@endpush
