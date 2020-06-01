@extends('layouts.app')
@section('content')

@component('components.form')
@slot('title', __('message.title.index'))
@slot('action', route('admin.message.confirm', $message))
<div class="p-4">
    @input([
    "for" => "message",
    "name" => "subject",
    "type" => "text",
    "value" => $message->subject,
    ])
    @input([
    "for" => "message",
    "name" => "body",
    "type" => "textarea",
    "value" => $message->body,
    "extra" => "data-controller=textarea data-action=input->textarea#input",
    ])
    <div class="form-group">
        <label for="class_group_toggle" class="form-label">@lang("message.form.label.receivers")</label>
        @class_department_group([
        "type" => 1,
        "prepend" => "message_send_to_",
        ])
    </div>
</div>
<div class="p-4 row">
    <div class="col-sm-12 col-md-4">
        @input([
        "for" => "message",
        "name" => "sender",
        "type" => "text",
        "value" => $message->sender,
        ])
    </div>
    <div class="col-sm-12 col-md-6 offset-md-2">
        <label for="body" class="form-label">配信日時</label>{{old('checkDateSetting')}}
        <div class="form-row">
            <input type="radio" class="check-radio" id="checkDate" @if(old('checkDateSetting') == 1) checked @endif name="checkDateSetting" value="1">
            <label for="checkDate" style="margin-left: 5px;font-size: 15.63px;font-weight: bold;color: #777;">すぐに送る</label> <br>
        </div>
        <div class="form-row">
            <input type="radio" id="checkdate2" class="check-radio" name="checkDateSetting" @if(old('checkDateSetting') !== 1) checked  @endif value="2">
            <label for="checkdate2" style="margin-left: 5px;font-size: 15.63px;font-weight: bold;color: #777;">タイマー設定</label>
            <div class="form-row @error('scheduled_datetime') is-invalid @enderror" style="margin-left: 15px; width: 100%">
            <div class="col-8">
                @input([
                "for" => "message",
                "name" => "scheduled_date",
                "type" => "select",
                "options" => hsp_date_generator('now','+1 year'),
                "value" => $message->scheduled_date,
                "class" => "checkDisable",
                "extra" => "disabled"
                ])
            </div>
            <div class="col-3">
                @input([
                "for" => "message",
                "name" => "scheduled_time",
                "type" => "select",
                "options" => hsp_time_generator(),
                "value" => $message->scheduled_time,
                "class" => "checkDisable",
                "extra" => "disabled"
                ])
            </div>
            </div>
            @includeWhen($errors->has('scheduled_datetime'), 'components.form-error', ["name" => 'scheduled_datetime'])
        </div>
    </div>
</div>
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
