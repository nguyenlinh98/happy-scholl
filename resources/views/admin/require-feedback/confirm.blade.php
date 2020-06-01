@extends('layouts.app')
@section('content')
@component('components.form-confirm')
@slot('action', $requireFeedback->exists ? route('admin.require_feedback.update', $requireFeedback) : route('admin.require_feedback.store'))
@slot('header')
<h1 class="page-title">回答必要通知</h1>
@endslot
<div class="p-4">
    <input type="hidden" value="confirmed" name="confirmation">

    @if($requireFeedback->exists)
    @method('PATCH')
    @endif
    @confirm([
        "for" => "require_feedback",
        "name" => "subject",
        "value" => $requireFeedback->subject
    ])
    @confirm([
        "for" => "require_feedback",
        "name" => "body",
        "value" => $requireFeedback->body
    ])

    <div class="form-group">
        <label for="class_group_toggle">@lang("require_feedback.form.label.receivers")</label>
        <div class="p-2 pt-3">
            @class_department_group_confirm([
                "model" => $requireFeedback,
                "prefix" => "required_feedback_for_"
            ])
            <input type="hidden" name="required_feedback_for_select" value="{{ $requireFeedback->required_feedback_for_select }}">
        </div>
    </div>

    <div class="form-row">
            <div class="col-sm-12 col-md-4">
                <input type="hidden" value="{{request()->post('checkDateSetting')}}" name="checkDateSetting">
                @if(request()->post('checkDateSetting') == 2)
                @confirm([
                    "for" => "require_feedback",
                    "name" => "scheduled_at",
                    "value" => $requireFeedback->toLocalizeDateTime('scheduled_at'),
                    "hiddens" => [
                    "scheduled_date" => $requireFeedback->scheduled_at->format("Y-m-d"),
                    "scheduled_time" => $requireFeedback->scheduled_at->format("H:i")
                    ]
                    ])
                @else
                    <label for="body" class="form-label">配信日時</label>
                    <div class="form-row">
                        <h4 class="font-weight-bold p-2">
                            すぐに送る
                        </h4>
                    </div>
                @endif
            </div>
        <div class="col-sm-12 col-md-4">
            @confirm([
                "for" => "require_feedback",
                "name" => "deadline_at",
                "value" => $requireFeedback->toLocalizeDate('deadline_at'),
                "hiddens" => [
                "deadline_date" => $requireFeedback->deadline_at->format("Y-m-d"),
                ]
            ])
        </div>
        <div class="col-sm-12 col-md-4">
            @confirm([
                "for" => "require_feedback",
                "name" => "clean_up_at",
                "value" => $requireFeedback->toLocalizeDate('clean_up_at'),
                "hiddens" => [
                "clean_up_date" => $requireFeedback->clean_up_at->format("Y-m-d"),
                ]
            ])
        </div>
    </div>
    @confirm([
        "for" => "require_feedback",
        "name" => "sender",
        "value" => $requireFeedback->sender
    ])
    <input type="hidden" value="yes" name="confirmation">
</div>
@slot("footer")
<div id="confirmation-box" class="py-2 bg-primary text-center mt-2">
    <h4 class="text-white font-weight-bold">この内容で、送信・予約設定してよろしいですか？</h4>
    <div class="buttons mt-4 mb-3 mx-auto">
        <input type="image" name="submit" alt="Submit" style="border: 0; margin-bottom: -35px;" src="{{url('/css/asset/button/send.png')}}">
        <input type="image" name="reject" value="return" alt="Cancel" style="border: 0; margin-bottom: -13px;" src="{{url('/css/asset/button/send-cancle.png')}}">
    </div>
    <h6 class="font-weight-bold mt-5">※予約設定は変更可能ですが、一度送信した回答必要通知は変更できません。</h6>
</div>
@endslot
@endcomponent
@endsection
