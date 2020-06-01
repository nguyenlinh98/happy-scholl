@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school emergency1">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{route('emergency.student-questions-category',$student_id)}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('緊急連絡')}}</h3>
            </div>
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div>
                <p class="title2">{{ translate('緊急連絡です。') }}</p>
                <p class="title2">{{ translate('質問内容にご回答ください。') }}</p>
                <div class="title-red">{{ translate('必ず一世帯一名様のみお答えください。') }}</div>
                    <form method="POST" action="{{route('emergency.student-answer-confirm', [$contact_id, $student_id])}}">
                    <div class="content-red">
                    @csrf
                    @include('layouts.partials.flash_message')
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{translate($error)}}</p>
                        @endforeach
                    @endif
                    @foreach($rsQuestion as $rs)
                        <p>・{{$rs->question_text}}</p>
                        @if($rs->question_type == \App\Models\UrgentContactDetailStatus::TYPE_YESNO)
                        <div class="list_btn">
                            <a href="#" onclick="event.preventDefault()" class="btn-yes" style="background:white;color:#c1272d;border:1px solid white;" name="yes">{{translate('YES')}}</a>
                            <a href="#" onclick="event.preventDefault()" class="btn-no" style="background:white;color:#b5b6b6;border:1px solid white;" name="no">{{translate('NO')}}</a>
                            <input type="hidden" name="question_answer_yes_no[{{$rs->id}}]" value="">
                        </div>
                        <span>{{ translate('選んでないものはグレー表記') }}</span>
                        @else
                        <div>
                            <textarea name="question_answer_text[{{$rs->id}}]" maxlength="150"></textarea>
                        </div>
                        <small>{{translate('※150文字まで')}}</small>
                        @endif
                    @endforeach
                    @if($rsQuestion->count() > 0)
                        <button type="submit" class="btn-yes custom">{{translate('送信')}}</button>
                    @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('styles')
<style>
    .btn-yes:hover{
        border:1px solid #c1272d!important;
    }
    .btn-no:hover{
        border:1px solid #b5b6b6!important;
    }
</style>
@endsection
@push('script')
<script>
    $(".list_btn .btn-yes").each(function () {
        $(this).on('click', function() {
            $(this).css({'background': '#c1272d', 'color': 'white'});
            $(this).closest(".list_btn").find(".btn-no").css({'background': 'white', 'color': '#b5b6b6'});
            var val = $(this).closest(".list_btn").find("input");
            val.val(1);
        });
    });

    $(".list_btn .btn-no").each(function () {
        $(this).on('click', function() {
            $(this).css({'background': '#b5b6b6', 'color': 'white'});
            $(this).closest(".list_btn").find(".btn-yes").css({'background': 'white', 'color': '#c1272d'});
            var val = $(this).closest(".list_btn").find("input");
            val.val(0);
        });
    });
</script>
@endpush
