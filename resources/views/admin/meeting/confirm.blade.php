@extends('layouts.app')
@section('content')
@component('components.form-confirm')
@slot('title', __('meeting.title.index'))

@slot('action', $meeting->exists ? route('admin.meeting.update', $meeting) : route('admin.meeting.store'))
@slot('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3">
    <h2 class="font-weight-bold text-secondary title-fs">{{$title}}</h2>
</div>

@endslot
<div class="p-4">
    <input type="hidden" value="confirmed" name="confirmation">
    @if($meeting->exists)
    @method('PATCH')
    @endif
    @confirm([
    "for" => "meeting",
    "name" => "subject",
    "value" => $meeting->subject,
    ])
    @confirm([
    "for" => "meeting",
    "name" => "body",
    "value" => $meeting->body,
    ])
    @confirm([
        "for" => "meeting",
        "name" => "zoom_link",
        "value" => $meeting->zoom_link,
    ])
    @confirm([
        "for" => "meeting",
        "name" => "contact_email",
        "value" => $meeting->contact_email,
    ])
    <div class="form-group">
        <label for="class_group_toggle">@lang("meeting.form.label.receiver_type")</label>
        <div class="p-2 pt-3">
            @isset($meeting->send_to_select)
            @class_department_group_confirm([
            "model" => $meeting,
            "prefix" => "send_to_"
            ])
            <input type="hidden" name="send_to_select" value="{{$meeting->send_to_select}}">
            @else
            <div class="form-row">
                @foreach ($meeting->receiversCollection as $student)
                @if($loop->first)
                <div class="col-sm-12 col-md-12 border-bottom mb-2">
                    <h3>{{$student->class->name}}</h3>
                </div>
                @endif
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <h4 class="font-weight-bold">{{$student->name}}</h4>
                    </div>
                </div>
                @endforeach
                <input type="hidden" name="individual_receivers" value="{{$meeting->individual_receivers}}">
            </div>
            @endif
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-12 col-md-4">

            @confirm([
            "for" => "meeting",
            "name" => "sender",
            "value" => $meeting->sender,
            ])
        </div>
        <div class="col-sm-12 col-md-6 offset-md-2">
            <input type="hidden" value="{{request()->post('checkDateSetting')}}" name="checkDateSetting">
            @if(request()->post('checkDateSetting') == 2)
            @confirm([
            "for" => "meeting",
            "name" => "scheduled_at",
            "value" => $meeting->toLocalizeDateTime('scheduled_at'),
            "hiddens" => [
            "date" => $meeting->date,
            "time" => $meeting->time
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
    <input type="hidden" name="letter_type" value="{{$meeting->letter_type}}">
</div>
@endcomponent
@endsection
