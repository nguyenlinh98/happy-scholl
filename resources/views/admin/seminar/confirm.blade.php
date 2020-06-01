@extends('layouts.app')
@section('content')

@component('components.form-confirm')
@slot('action', $seminar->exists ? route('admin.seminar.update', $seminar) : route('admin.seminar.store'))
@slot('title', 'お知らせ')

<input type="hidden" value="confirmed" name="confirmation">
@if($seminar->exists)
@method('PATCH')
@endif
<div class="p-4">

    @confirm([
        "for" => "seminar",
        "name" => "subject",
        "value" => $seminar->subject
    ])

    @confirm([
        "for" => "seminar",
        "name" => "body",
        "value" => $seminar->body
    ])

    @confirm([
        "for" => "seminar",
        "name" => "address",
        "value" => $seminar->address
    ])
    <div class="form-group">
        <label for="class_group_toggle">@lang("seminar.form.label.receivers")</label>
        <div class="p-2 pt-3">
            @class_department_group_confirm([
                "model" => $seminar,
                "prefix" => "seminar_for_"
            ])
            <input type="hidden" name="seminar_for_select" value="{{ $seminar->seminar_for_select }}">
        </div>
    </div>
    @include("components.image-upload-confirm", ["images" => $seminar->confirmImages])
    <div class="row">
        <div class="col-sm-12 col-md-4">
            @confirm([
            "for" => "seminar",
            "name" => "scheduled_at",
            "value" => $seminar->toLocalizeDateTime('scheduled_at'),
            "hiddens" => [
                "scheduled_date" => $seminar->scheduled_date,
                "scheduled_time" => $seminar->scheduled_time
                ]
            ])
        </div>
        <div class="col-sm-12 col-md-4">
            @confirm([
                "for" => "seminar",
                "name" => "deadline_at",
                "value" => $seminar->toLocalizeDate('deadline_at'),
                "hiddens" => [
                    "deadline_date" => $seminar->deadline_date,
                ]
            ])
        </div>
        <div class="col-sm-12 col-md-4">
            @confirm([
                "for" => "seminar",
                "name" => "max_people",
                "value" => $seminar->max_people,
                ])
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 col-lg-6">
            @confirm([
                "for" => "seminar",
                "name" => "fee",
                "value" => $seminar->fee,
            ])
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 col-lg-6">
            @confirm([
                "for" => "seminar",
                "name" => "instructor",
                "value" => $seminar->instructor,
            ])
        </div>
        <div class="col-md-12 col-lg-6">
            @confirm([
                "for" => "seminar",
                "name" => "tel",
                "value" => $seminar->tel,
            ])
        </div>
    </div>
    @if($seminar->need_help)
        <input type="hidden" name="enable_help" value="on">
        @confirm([
            "for" => "seminar",
            "name" => "reason",
            "value" => $seminar->reason
        ])
        <div class="row">
            <div class="col-sm-12 col-md-4">
                @confirm([
                "for" => "seminar",
                "name" => "help_scheduled_at",
                "value" => $seminar->toLocalizeDateTime('help_scheduled_at'),
                "hiddens" => [
                    "help_scheduled_date" => $seminar->help_scheduled_date,
                    "help_scheduled_time" => $seminar->help_scheduled_time
                    ]
                ])
            </div>
            <div class="col-sm-12 col-md-4">
                @confirm([
                    "for" => "seminar",
                    "name" => "help_deadline_at",
                    "value" => $seminar->toLocalizeDate('help_deadline_at'),
                    "hiddens" => [
                        "help_deadline_date" => $seminar->help_deadline_date,
                    ]
                ])
            </div>
            <div class="col-sm-12 col-md-4">
                @confirm([
                    "for" => "seminar",
                    "name" => "max_help_people",
                    "value" => $seminar->max_help_people,
                    ])
            </div>
        </div>
        @confirm([
            "for" => "seminar",
            "name" => "help_tel",
            "value" => $seminar->help_tel
        ])
    @endif
    @confirm([
        "for" => "seminar",
        "name" => "sender",
        "value" => $seminar->sender
    ])
</div>
@endcomponent
@endsection
