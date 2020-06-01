@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{url()->previous()}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('緊急連絡')}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div><br>
                <div class="title1" style="font-size: 19px;">{{translate('緊急連絡です。')}}</div>
                <div class="fat-text">
                    <form method="POST" action="{{route('emergency.student-question.post', [$student_id])}}">
                    @csrf
                          @foreach($data as $key => $item)
                          <div>
                            <li>{{$rsDataQuestion[$key]}}:
                            <label style="color: red;padding-left: 6px;">
                                @if(isset($item['yesno_answer']) && $item['yesno_answer'] == 1)
                                    {{translate('YES')}}
                                @endif
                                @if(isset($item['yesno_answer']) && $item['yesno_answer'] == 0)
                                    {{translate('NO')}}
                                @endif
                                @if(isset($item['answer_text']))
                                    {{translate($item['answer_text'])}}
                                @endif
                            </label>
                            </li>
                            <input type="hidden" name="question_answer[{{$key}}]" value="{{json_encode($item)}}">
                          </div>
                        @endforeach
                        <br>
                        <div class="fat-btn">
                            <a href="#" class="btn-exit" onclick="$(this).closest('form').submit();return false">{{translate('送信')}}</a>
                            <a href="{{URL::previous()}}" class="btn-white" onclick="">{{translate('戻る')}}</a>
                            {{--<button type="submit" class="btn-exit">submit</button>--}}
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
