@extends('layouts.app')
@section('content')

@component('components.form-confirm')
@slot('action', $schoolEvent->exists ? route('admin.school_event.update', $schoolEvent) : route('admin.school_event.store'))
@slot('title', 'お知らせ')

<input type="hidden" value="confirmed" name="confirmation">
@if($schoolEvent->exists)
@method('PATCH')
@endif
<div class="p-4">

    @confirm([
        "for" => "school_event",
        "name" => "subject",
        "value" => $schoolEvent->subject
    ])

    @confirm([
        "for" => "school_event",
        "name" => "body",
        "value" => $schoolEvent->body
    ])

    <div class="form-group">
        <label for="class_group_toggle">@lang("seminar.form.label.receivers")</label>
        <div class="p-2 pt-3">
            @class_department_group_confirm([
                "model" => $schoolEvent,
                "prefix" => "school_event_for_"
            ])
            <input type="hidden" name="school_event_for_select" value="{{ $schoolEvent->school_event_for_select }}">
        </div>
    </div>
    @include("components.image-upload-confirm", ["images" => $schoolEvent->confirmImages])
    <div class="row">
        <div class="col-sm-12 col-md-4">
            @confirm([
            "for" => "school_event",
            "name" => "scheduled_at",
            "value" => $schoolEvent->toLocalizeDateTime('scheduled_at'),
            "hiddens" => [
                "scheduled_date" => $schoolEvent->scheduled_date,
                "scheduled_time" => $schoolEvent->scheduled_time
                ]
            ])
        </div>
        <div class="col-sm-12 col-md-4">
            @confirm([
                "for" => "school_event",
                "name" => "deadline_at",
                "value" => $schoolEvent->toLocalizeDate('deadline_at'),
                "hiddens" => [
                    "deadline_date" => $schoolEvent->deadline_date,
                ]
            ])
        </div>
        <div class="col-sm-12 col-md-4">
            @confirm([
                "for" => "school_event",
                "name" => "max_people",
                "value" => $schoolEvent->max_people,
                ])
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 col-lg-6">
            @confirm([
                "for" => "school_event",
                "name" => "email",
                "value" => $schoolEvent->email,
            ])
        </div>
        <div class="col-md-12 col-lg-6">
            @confirm([
                "for" => "school_event",
                "name" => "tel",
                "value" => $schoolEvent->tel,
            ])
        </div>
    </div>
    @if($schoolEvent->need_help)
        <input type="hidden" name="enable_help" value="on">
        @confirm([
            "for" => "school_event",
            "name" => "reason",
            "value" => $schoolEvent->reason
        ])
        <div class="row">
            <div class="col-sm-12 col-md-4">
                @confirm([
                "for" => "school_event",
                "name" => "help_scheduled_at",
                "value" => $schoolEvent->toLocalizeDateTime('help_scheduled_at'),
                "hiddens" => [
                    "help_scheduled_date" => $schoolEvent->help_scheduled_date,
                    "help_scheduled_time" => $schoolEvent->help_scheduled_time
                    ]
                ])
            </div>
            <div class="col-sm-12 col-md-4">
                @confirm([
                    "for" => "school_event",
                    "name" => "help_deadline_at",
                    "value" => $schoolEvent->toLocalizeDate('help_deadline_at'),
                    "hiddens" => [
                        "help_deadline_date" => $schoolEvent->help_deadline_date,
                    ]
                ])
            </div>
            <div class="col-sm-12 col-md-4">
                @confirm([
                    "for" => "school_event",
                    "name" => "max_help_people",
                    "value" => $schoolEvent->max_help_people,
                    ])
            </div>
        </div>
    @endif
    @confirm([
        "for" => "school_event",
        "name" => "sender",
        "value" => $schoolEvent->sender
    ])
</div>
@endcomponent
@endsection
