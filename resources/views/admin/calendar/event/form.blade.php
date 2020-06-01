@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>{{ hsp_title() }}</h2>
    <div class="btn-toolbar mb-2 mb-md-0" id="toolbar">
        <div class="btn-group mr-2" id="toolbar-table-buttons">
        </div>
    </div>
</div>
<form method="POST" action="{{ $event->exists() ? route('admin.event.update', $event) : route('admin.event.store') }}">
    @csrf
    @if($event->exists)
        @method("PATCH")
    @endif
    <div class="card">
        <div class="card-body" data-controller="create-event">
            @csrf
            <div class="row">
                <div class="col-6">
                    @inlineInput([
                        "type" => "text",
                        "name" => "title",
                        "for" => "event",
                        "placeholder" => __('event.form.placeholder.title'),
                        'extra' => 'data-target=create-event.title',
                        "value" => $event->title
                    ])

                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <div class="form-check pl-0">
                                <input class="form-check-input" type="checkbox" id="all_day" name="all_day" @if( $event->all_day_event === "on" ) checked="checked" @endif data-action="change->create-event#toggleAllDayEvent" data-target="create-event.allDay">
                                <label class="form-check-label" for="all_day">
                                    @lang('event.form.value.all_day')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">@lang('event.form.placeholder.start_date')</label>
                        <div class="col-sm-9" data-target="create-event.start">
                            <div class="form-row {{ $errors->hasAny(["start_date", "start_time", "start_date_time"]) ? 'is-invalid' : '' }}">
                                <div class="{{ $event->all_day_event === 'on' ? 'col-12' : 'col-8'}}">
                                    <input type="text" class="form-control {{ $errors->hasAny(["start_date_time", "start_date"]) ? 'is-invalid' : ''}}" id="startDate" name="start_date" data-controller="datepicker" value="{{ $event->start_date }}" aria-label="Use the arrow keys to pick a date">
                                </div>
                                @if(!$event->all_day_event)
                                <div class="col-4">
                                    <input type="hidden" id="startTime" name="start_time" data-controller="timepicker" value="{{ $event->start_time }}" class="visually-hidden {{ $errors->hasAny(["start_time", "start_date_time"]) ? 'is-invalid' : '' }}">
                                </div>
                                @endif
                            </div>
                            @includeWhen($errors->has("start_date"), 'components.form-error', ["name" => "start_date"])
                            @includeWhen($errors->has("start_time"), 'components.form-error', ["name" => "start_time"])
                            @includeWhen($errors->has("start_date_time"), 'components.form-error', ["name" => "start_date_time"])
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">@lang('event.form.placeholder.end_date')</label>

                        <div class="col-sm-9" data-target="create-event.end">
                            <div class="form-row {{ $errors->hasAny(["end_date", "end_time"]) ? 'is-invalid' : '' }}">
                                <div class="{{ $event->all_day_event === 'on' ? 'col-12' : 'col-8'}}">
                                    <input type="text" class="form-control @error("end_date") is-invalid @enderror" id="endDate" name="end_date" data-controller="datepicker" value="{{ $event->end_date }}" aria-label="Use the arrow keys to pick a date">
                                </div>
                                @if(!$event->all_day_event)
                                <div class="col-4">
                                    <input type="hidden" id="endTime" name="end_time" data-controller="timepicker" value="{{ $event->end_time }}" class="visually-hidden {{$errors->has("end_time") ? 'is-invalid' : ''}}">
                                </div>
                                @endif
                            </div>
                            @includeWhen($errors->has("end_date"), 'components.form-error', ["name" => "end_date"])
                            @includeWhen($errors->has("end_time"), 'components.form-error', ["name" => "end_time"])
                        </div>

                    </div>

                    @inlineInput([
                        "type" => "textarea",
                        "name" => "detail",
                        "placeholder" => __('event.form.placeholder.detail'),
                        "for" => "event",
                        "extra" => 'rows=10',
                        "value" => $event->detail
                    ])
                    @inlineInput([
                        "type" => "text",
                        "name" => "location",
                        "for" => "event",
                        "placeholder" => __('event.form.placeholder.location'),
                        "value" => $event->location
                    ])
                </div>
                <div class="col-6">
                    @input([
                        "for" => "event",
                        "type" => "select",
                        "options" => hsp_school()->getCalendarsForEventsArray(),
                        "value" => old("calendar", ''),
                        "name" => "calendar"
                    ])
                    @input([
                        "for" => "event",
                        "type" => "select",
                        "options" => config('core.config.event_user.event_remind'),
                        "value" => old("remind", ''),
                        "name" => "remind"
                    ])
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ $event->exists() ? "保存": "追加" }}</button>
            <a href="{{ route('admin.calendar.index') }}" class="btn btn-light">キャンセル</a>
        </div>
    </div>
</form>
@endsection
