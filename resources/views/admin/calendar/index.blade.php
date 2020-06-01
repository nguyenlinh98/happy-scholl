@extends('layouts.app')
@section('content')
<div class="calendar-holder" style="height: calc(100vh - 100px)">
    <div data-controller="calendar" data-calendar-events='@json($events)'>
        <button type="button" class="btn btn-primary" hidden data-toggle="modal" data-target="#createCalendarEvent" id="createCalendarEventHandler"></button>

        <!-- Modal -->
        <div class="modal fade" id="createCalendarEvent" tabindex="-1" role="dialog" aria-labelledby="createCalendarEventLabel" aria-hidden="true" data-target="calendar.createModal" data-controller="create-event" data-action="open->create-event#open">
            <div class="modal-dialog modal-dialog-centered" role="document" data-controller="">
                <form class="modal-content" method="POST" action="{{ route('admin.event.store') }}" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCalendarEventLabel" data-target="create-event.title">@lang('event.title.create')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        @csrf
                        @inlineInput([
                            "for" => "event",
                            "type" => "select",
                            "options" => hsp_school()->getCalendarsForEventsArray(),
                            "value" => old("calendar", ''),
                            "name" => "calendar"
                            ])
                            @inlineInput([
                                "for" => "event",
                                "type" => "text",
                                "placeholder" => __('event.form.placeholder.title'),
                                "name" => "title",
                                'extra' => 'data-target=create-event.name'
                                ])

                                <div class="form-group row">
                                    <label for="subject" class="col-sm-3 col-form-label">@lang('event.form.label.time')</label>
                                    <div class="col-sm-9">
                                        <div class="form-check pl-0">
                                            <input class="form-check-input" type="checkbox" id="all_day" name="all_day" data-action="change->create-event#toggleAllDayEvent" data-target="create-event.allDay">
                                            <label class="form-check-label" for="all_day">
                                                @lang('event.form.value.all_day')
                                            </label>
                                        </div>

                                        <div class="form-group" data-target="create-event.start">
                                        </div>
                                        <div class="form-group" data-target="create-event.end">
                                        </div>

                                    </div>
                                </div>
                                @inlineInput([
                                    "for" => "event",
                                    "type" => "text",
                                    "placeholder" => __('event.form.placeholder.location'),
                                    "name" => "location"
                                    ])
                                    <div class="text-right">
                                        <button type="submit" name="action" value="continue" class="btn btn-link">@lang('event.form.label.detail')</a>
                                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="action" value="submit">追加</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>

                    </div>
                </form>
            </div>
        </div>
        <div data-controller="calendar-event">
            <div class="modal fade" id="viewCalendarEvent" tabindex="-1" role="dialog" aria-labelledby="viewCalendarEventLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteCalendarEventLabel"><span data-target="calendar-event.title"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><span data-target="calendar-event.time"></span></p>
                            <div data-target="calendar-event.location"></div>
                            <blockquote data-target="calendar-event.detail"></blockquote>
                        </div>
                        <div class="modal-footer justify-content-between" data-target="calendar-event.footer">
                            <div class="button-group">
                                {{-- <button type="button" class="btn btn-primary">編集</button> --}}
                                <a href="#" data-target="calendar-event.editLink" class="btn btn-warning">編集</a>
                            </div>
                            <button type="button" class="btn btn-light" data-dismiss="modal" data-toggle="modal" data-target="#deleteCalendarEvent" id="deleteCalendarEventHandler">
                                <svg width="427pt" height="427pt" viewBox="-40 0 427 427" xmlns="http://www.w3.org/2000/svg" class="feather feather-delete">
                                    <path d="m232.4 154.7c-5.5234 0-10 4.4766-10 10v189c0 5.5195 4.4766 10 10 10 5.5234 0 10-4.4805 10-10v-189c0-5.5234-4.4766-10-10-10z" />
                                    <path d="m114.4 154.7c-5.5234 0-10 4.4766-10 10v189c0 5.5195 4.4766 10 10 10 5.5234 0 10-4.4805 10-10v-189c0-5.5234-4.4766-10-10-10z" />
                                    <path d="m28.398 127.12v246.38c0 14.562 5.3398 28.238 14.668 38.051 9.2852 9.8398 22.207 15.426 35.73 15.449h189.2c13.527-0.023438 26.449-5.6094 35.73-15.449 9.3281-9.8125 14.668-23.488 14.668-38.051v-246.38c18.543-4.9219 30.559-22.836 28.078-41.863-2.4844-19.023-18.691-33.254-37.879-33.258h-51.199v-12.5c0.058593-10.512-4.0977-20.605-11.539-28.031-7.4414-7.4219-17.551-11.555-28.062-11.469h-88.797c-10.512-0.085938-20.621 4.0469-28.062 11.469-7.4414 7.4258-11.598 17.52-11.539 28.031v12.5h-51.199c-19.188 0.003906-35.395 14.234-37.879 33.258-2.4805 19.027 9.5352 36.941 28.078 41.863zm239.6 279.88h-189.2c-17.098 0-30.398-14.688-30.398-33.5v-245.5h250v245.5c0 18.812-13.301 33.5-30.398 33.5zm-158.6-367.5c-0.066407-5.207 1.9805-10.219 5.6758-13.895 3.6914-3.6758 8.7148-5.6953 13.926-5.6055h88.797c5.2109-0.089844 10.234 1.9297 13.926 5.6055 3.6953 3.6719 5.7422 8.6875 5.6758 13.895v12.5h-128zm-71.199 32.5h270.4c9.9414 0 18 8.0586 18 18s-8.0586 18-18 18h-270.4c-9.9414 0-18-8.0586-18-18s8.0586-18 18-18z" />
                                    <path d="m173.4 154.7c-5.5234 0-10 4.4766-10 10v189c0 5.5195 4.4766 10 10 10 5.5234 0 10-4.4805 10-10v-189c0-5.5234-4.4766-10-10-10z" />
                                </svg>
                                削除
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteCalendarEvent" tabindex="-1" role="dialog" aria-labelledby="deleteCalendarEventLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <form class="modal-content" method="POST" data-target="calendar-event.deleteForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteCalendarEventLabel">予定の削除</span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            予定を削除してもよろしいですか?
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">削除</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal">キャンセル</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
