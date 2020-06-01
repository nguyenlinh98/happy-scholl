@extends('layouts.app')
@section('content')

@component('components.form')
{{-- @slot('title', __('require_feedback.title.index')) --}}

@slot('action', route('admin.require_feedback.confirm'))
@slot('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h2>回答必要通知</h2>
</div>
<div class="p-0 row-search-btn mb-3">
    <a href="{{route('admin.require_feedback.index')}}">
        <div class="text-center mr-3 btn-content btn-content-letter mb-0">
            <p class="mb-0">配信予約一覧</p>
        </div>
    </a>
</div>
@endslot
{{--@include("admin.require-feedback.form")--}}
<div class="p-4">
    @input([
    "for" => "require_feedback",
    "name" => "subject",
    "type" => "text",
    "value" => $requireFeedback->subject,
    ])
    @input([
    "for" => "require_feedback",
    "name" => "body",
    "type" => "textarea",
    "value" => $requireFeedback->body,
    "extra" => "data-controller=textarea data-action=input->textarea#input",
    ])
    <div class="form-group">
        <label for="class_group_toggle" class="form-label">@lang("message.form.label.receivers")</label>
        @class_department_group([
        "type" => 1,
        "prepend" => "required_feedback_for_"
        ])
    </div>
    <label for="body" class="form-label">配信日時</label>
    <div class="">
        <input type="radio" class="check-radio" id="checkDate" @if(old('checkDateSetting') !== 2) checked @endif name="checkDateSetting" value="1">
        <label for="checkDate" style="margin-left: 5px;font-size: 15.63px;font-weight: bold;color: #777;">すぐに送る</label> <br>
    </div>
    <input type="radio" id="checkdate2" class="check-radio" name="checkDateSetting" @if(old('checkDateSetting') == 2) checked  @endif value="2">
    <label for="checkdate2" style="margin-left: 5px;font-size: 15.63px;font-weight: bold;color: #777;">通知日時設定</label>
    <div class="form-row">
        <div class="col-sm-12 col-md-6">
            <div class="form-row  @error('scheduled_datetime') is-invalid @enderror" style="margin-left: 15px; width: 100%">
                <div class="col-8">
                    @input([
                    "for" => "require_feedback",
                    "name" => "scheduled_date",
                    "type" => "select",
                    "options" => hsp_date_generator('now',"+1 year"),
                    "value" => date("Y-m-d", strtotime($requireFeedback->scheduled_date)),
                    "class" => "checkDisable",
                    "extra" => "disabled"
                    ])
                </div>
                <div class="col-3 @error('scheduled_datetime') is-invalid @enderror">
                    @input([
                    "for" => "require_feedback",
                    "name" => "scheduled_time",
                    "type" => "select",
                    "options" => hsp_time_generator(),
                    "value" => $requireFeedback->scheduled_time,
                    "class" => "checkDisable",
                    "extra" => "disabled"
                    ])
                </div>
                @includeWhen($errors->has('scheduled_datetime'), 'components.form-error', ["name" => 'scheduled_datetime'])
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            @input([
            "for" => "require_feedback",
            "name" => "deadline_date",
            "type" => "select",
            "options" => hsp_date_generator('+1 day',"+1 year"),
            "value" => $requireFeedback->deadline_date->format("Y-m-d"),
            ])
        </div>
        <div class="col-sm-12 col-md-3">
            @input([
            "for" => "require_feedback",
            "name" => "clean_up_date",
            "type" => "select",
            "options" => hsp_date_generator('+2 day',"+1 year"),
            "value" => $requireFeedback->clean_up_date->format("Y-m-d"),
            ])
        </div>
    </div>

    <div class="form-group pt-3">
        <label for="confirm">ご確認の上「確認」ボタンよりお進みください。</label>
        <div class="form-check {{ $errors->has("confirmation") ? 'is-invalid' : '' }}">
            <input class="form-check-input checkbox--lg mt-2" type="checkbox" name="confirmation" id="confirm_checkbox" value="yes">
            <label class="form-check-label h3" for="confirm_checkbox" style="margin-right: 1em">削除指定日で回答内容は削除されます。削除された内容は復元することはできません。</label>
        </div>
        @includeWhen($errors->has("confirmation"), 'components.form-error', ["name" => "confirmation"])
    </div>

    <div class="row">
        <div class="col-6">
            @input([
            "for" => "require_feedback",
            "name" => "sender",
            "type" => "text",
            "value" => $requireFeedback->sender,
            ])
        </div>
    </div>

</div>

@slot("footer")
<button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/confirm.png')}}" alt=""></button>
<a href="{{route('admin.require_feedback.index')}}"> <img src="{{url('/css/asset/button/cancle.png')}}" alt=""></a>
@endslot
<script>
    $(document).ready(function() {
        $("input[name$='checkDateSetting']").click(function() {
            var value = $(this).val();
            if (value == ('1')){
                $(".checkDisable").attr('disabled','disabled');
            }
            else {
                $(".checkDisable").removeAttr('disabled');
            }
        });

        if($("input[name$='checkDateSetting']:checked").val() == ('1')){
            $(".checkDisable").attr('disabled','disabled');
        }
        else {
            $(".checkDisable").removeAttr('disabled');
        }
    });
</script>
@endcomponent
@endsection
