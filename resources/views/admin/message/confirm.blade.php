@extends('layouts.app')
@section('content')

@component('components.form-confirm')
@slot('action', $message->exists ? route('admin.message.update', $message) : route('admin.message.store'))
@slot('title', 'お知らせ')

<input type="hidden" value="confirmed" name="confirmation">
@if($message->exists)
@method('PATCH')
@endif
<div class="p-4">

    @confirm([
    "for" => "message",
    "name" => "subject",
    "value" => $message->subject
    ])

    @confirm([
    "for" => "message",
    "name" => "body",
    "value" => $message->body
    ])
    <div class="form-group">
        <label for="class_group_toggle">@lang("message.form.label.receivers")</label>
        <div class="p-2 pt-3">
            @class_department_group_confirm([
            "model" => $message,
            "prefix" => "message_send_to_"
            ])
            <input type="hidden" name="message_send_to_select" value="{{$message->message_send_to_select}}">
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-4">
            @confirm([
            "for" => "message",
            "name" => "sender",
            "value" => $message->sender
            ])
        </div>
        <div class="col-sm-12 col-md-6 offset-md-2">
            <input type="hidden" value="{{request()->post('checkDateSetting')}}" name="checkDateSetting">
            @if(request()->post('checkDateSetting') == 2)
            @confirm([
            "for" => "message",
            "name" => "scheduled_at",
            "value" => $message->toLocalizeDateTime('scheduled_at'),
            "hiddens" => [
            "scheduled_date" => $message->scheduled_date,
            "scheduled_time" => $message->scheduled_time
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
    </div>
</div>
@endcomponent
@endsection
