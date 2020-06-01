@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('回答必要通知')}}</h3>
                </div>
                <div class="calendar notification">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    @foreach($requireFeedback as $feedback)
                        @php
                            $status = $feedback->statuses->where('student_id',$studentId);
                            $isSeen = false;
                            if($status->first()){
                                $isSeen = $status->first()->feedback!=0;
                            }
                            $isDeadline = false;
                            if(time()>strtotime($feedback->deadline)){
                                $isDeadline = true;
                            }
                        @endphp
                        @if($isSeen)

                            <div class="card-i seen">
                                <form data-action="{{route('front.require_feedback.success',[$studentId,$feedback->id])}}"
                                      method="POST">
                                    @csrf
                                    <div class="i-card">
                                        <h4>{{translate($feedback->subject)}}</h4>
                                        <p>{{translate($feedback->toLocalizeDateTime('scheduled_at'))}}</p>
                                        <p>{{translate('配信者: '.$feedback->sender)}}</p>
                                        <p>{{translate('回答期限：'.$feedback->toLocalizeDate('deadline'))}}</p>
                                        <p class="text-if">{{translate($feedback->body)}}</p>
                                    </div>
                                    <div class="btn">
                                        {{--                                        {{dd($status)}}--}}
                                        <button class="@if($status->first()->feedback == 1) selected @endif"
                                                type="button" name="btn" value="yes"><img

                                                    data-feedback="{{$feedback->id}}"
                                                    src="{{asset('images/front/o.png')}}"
                                                    alt=""></button>
                                        <button class="2 @if($status->first()->feedback == 2) selected @endif"
                                                type="button" name="btn" value="no"><img

                                                    data-feedback="{{$feedback->id}}"
                                                    src="{{asset('images/front/x.png')}}"
                                                    alt=""></button>

                                    </div>
                                    @if(!$isDeadline)
                                        <button type="button" class="btn-chooose-again">{{translate('回答をし直す')}}</button>
                                    @endif
                                </form>
                            </div>
                        @else
                            @if($isDeadline)
                                <div class="card-i seen">
                                    <div class="i-card">
                                        <h4>{{translate($feedback->subject)}}</h4>
                                        <p>{{translate($feedback->toLocalizeDateTime('scheduled_at'))}}</p>
                                        <p>{{translate('配信者: '.$feedback->sender)}}</p>
                                        <p>{{translate('回答期限：'.$feedback->toLocalizeDate('deadline'))}}</p>
                                        <p class="text-if">{{translate($feedback->body)}}</p>
                                    </div>
                                    <div class="btn">

                                        <button type="button" name="btn" value="yes"><img
                                                    data-feedback="{{$feedback->id}}"
                                                    src="{{asset('images/front/o.png')}}"
                                                    alt=""></button>
                                        <button type="button" name="btn" value="no"><img
                                                    data-feedback="{{$feedback->id}}"
                                                    src="{{asset('images/front/x.png')}}"
                                                    alt=""></button>

                                    </div>
                                </div>
                            @else

                                <div class="card-i">
                                    <form action="{{route('front.require_feedback.success',[$studentId,$feedback->id])}}"
                                          method="POST">
                                        @csrf
                                        <div class="i-card">
                                            <h4>{{translate($feedback->subject)}}</h4>
                                            <p>{{translate($feedback->toLocalizeDateTime('scheduled_at'))}}</p>
                                            <p>{{translate('配信者: '.$feedback->sender)}}</p>
                                            <p>{{translate('回答期限：'.$feedback->toLocalizeDate('deadline'))}}</p>
                                            <p class="text-if">{{translate($feedback->body)}}</p>
                                        </div>
                                        <div class="btn">

                                            <button name="btn" value="yes">
                                                <img class=""
                                                     data-feedback="{{$feedback->id}}"
                                                     src="{{asset('images/front/o.png')}}"
                                                     alt=""></button>
                                            <button name="btn" value="no">
                                                <img class=""
                                                     data-feedback="{{$feedback->id}}"
                                                     src="{{asset('images/front/x.png')}}"
                                                     alt=""></button>

                                        </div>
                                    </form>
                                </div>

                            @endif

                        @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <style>
        .card-i:nth-child(odd) .i-card {
            background-color: #fff;
        }

        .card-i.seen .i-card {
            background: #CBCCCC;
        }
        .btn-chooose-again {
            background: #99CC00 !important;
            color: #fff;
            font-size: 18px !important;
            font-weight: 700;
            margin: 0px auto 40px !important;
            display: block;
            width: calc(100% - 40px) !important;
            border-radius: 12px;
            box-shadow: 4px 3px 5px #4e5655;
            text-align: center;
            padding: 6px 5px !important;
        }
        .btn-chooose-again:hover {
            background: #fff !important;
            color: #9AC718;
            border-color: #9AC718 !important;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.btn-chooose-again').click(function () {
                $(this).closest('.card-i').removeClass('seen');
                $(this).closest('.card-i').find('button[name=btn] img').removeClass('selected');
                let action = $(this).closest('.card-i').find('form').data('action');
                $(this).closest('.card-i').find('form').attr('action', action);
                $(this).closest('.card-i').find('button[name=btn]').attr('type', 'submit');
            });
        });
    </script>
@endsection
