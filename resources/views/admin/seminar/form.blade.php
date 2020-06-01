<div class="p-4">
    @input([
        "for" => "seminar",
        "name" => "subject",
        "type" => "text",
        "value" => $seminar->subject,
        "extra" => "form-confirm",
        ])

    @input([
        "for" => "seminar",
        "name" => "body",
        "type" => "textarea",
        "value" => $seminar->body,
        "extra" => "data-controller=textarea data-action=input->textarea#input",
        ])
    @input([
        "for" => "seminar",
        "name" => "address",
        "type" => "textarea",
        "value" => $seminar->address,
        "extra" => "data-controller=textarea data-action=input->textarea#input",
        ])
    <div class="form-group">
        <label for="class_group_toggle" class="form-label">@lang("message.form.label.receivers")</label>
        @class_department_group([
            "type" => 1,
            "prepend" => "seminar_for_"
            ])
    </div>
    @include("components.image-upload", [
        "name" => "images",
        "images" => array_values($seminar->getImageAssetsArray(false)),
    ])
    <div class="form-row">
        <div class="col-sm-12 col-md-4">
            <div class="form-row">
                <div class="col-8">
                    @input([
                        "for" => "seminar",
                        "name" => "scheduled_date",
                        "type" => "select",
                        "value" => old('scheduled_date', $seminar->exists ? $seminar->scheduled_at->format("Y-m-d") : now()->format("Y-m-d")),
                        "options" => hsp_date_generator('now',"+1 year"),
                        ])
                </div>
                <div class="col-4">
                    @input([
                        "for" => "seminar",
                        "name" => "scheduled_time",
                        "type" => "select",
                        "options" => hsp_time_generator(),
                        "value" => old('scheduled_time', $seminar->exists ? $seminar->scheduled_at->format('H:i') : ''),
                        "extra" => "form-confirm",
                        ])
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-3">
            @input([
                "for" => "seminar",
                "name" => "deadline_date",
                "type" => "select",
                "value" => old('deadline_date', $seminar->exists ? $seminar->deadline_at->format('Y-m-d') : now()->format("Y-m-d")),
                "options" => hsp_date_generator('now',"+1 year"),
                ])
        </div>
        <div class="col-sm-12 col-md-5 ">
            <div class="form-row {{ $errors->has('max_people') ? 'is-invalid' : '' }}">
                <div class="form-group col-6">
                    <label for="deadline_date">@lang("seminar.form.label.max_people")</label>
                    <input class="form-control {{ $errors->has('max_people') ? 'is-invalid' : '' }}" name="max_people" type="text" form-confirm="" value="{{ old('max_people', $seminar->max_people) }}">
                </div>
                <div class="col-6">
                    <label>&nbsp;</label>
                    <h3 class="mt-1 font-weight-bold">人</h3>
                </div>
            </div>
            @includeWhen($errors->has('max_people'), 'components.form-error', ["name" => 'max_people'])
                <h6 role="help-text" class="reference-mark ml-4 mt-n2 font-weight-bold hidden-on-form-confirm">@lang("seminar.form.helper.max_people")</h6>

        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 col-lg-6">
            @input([
                "for" => "seminar",
                "name" => "fee",
                "type" => "text",
                "value" => $seminar->fee,
                "extra" => "form-confirm",
                ])
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12 col-lg-6">
            @input([
                "for" => "seminar",
                "name" => "instructor",
                "type" => "text",
                "value" => $seminar->instructor,
                "extra" => "form-confirm",
                ])
        </div>
        <div class="col-md-12 col-lg-6">
            @input([
                "for" => "seminar",
                "name" => "tel",
                "type" => "text",
                "value" => $seminar->tel,
                "extra" => "form-confirm",
                ])

        </div>
    </div>
    <div class="form-group @if(old("enable_help", ($seminar->exists && $seminar->reason) ? 'on' : 'off') === "on") helper-on @endif" id="helper_toggle">
        <label for="deadline_date">@lang("seminar.form.label.help")</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="enable_help" id="helper_on" value="on" @if(old("enable_help", ($seminar->exists && $seminar->reason) ? 'on' : 'off') === "on") checked="checked" @endif data-controller="toggle" data-toggle-id="helper_toggle" data-toggle-class="helper-on" data-action="change->toggle#toggle">
                <label class="form-check-label h5 font-weight-bold" for="helper_on">@lang("seminar.form.label.help_on")</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="enable_help" id="helper_off" value="off" @if(old("enable_help", ($seminar->exists && $seminar->reason) ? 'on' : 'off') === "off") checked="checked" @endif data-controller="toggle" data-toggle-id="helper_toggle" data-toggle-class="helper-on" data-action="change->toggle#toggle">
                <label class="form-check-label h5 font-weight-bold" for="helper_off">@lang("seminar.form.label.help_off")</label>
            </div>
        </div>
    </div>
    <div class="helper--container">
        @input([
            "for" => "seminar",
            "name" => "reason",
            "type" => "textarea",
            "value" => old("reason", $seminar->reason),
            "extra" => "data-controller=textarea data-action=input->textarea#input",
            ])
        <div class="form-row">
            <div class="col-sm-12 col-md-4">
                <div class="form-row">
                    <div class="col-8">
                        @input([
                            "for" => "seminar",
                            "name" => "help_scheduled_date",
                            "type" => "select",
                            "value" => old('help_scheduled_date', $seminar->exists ? $seminar->help_scheduled_at->format("Y-m-d") : now()->format("Y-m-d")),
                            "options" => hsp_date_generator('now',"+1 year"),
                            ])
                    </div>
                    <div class="col-4">
                        @input([
                            "for" => "seminar",
                            "name" => "help_scheduled_time",
                            "type" => "select",
                            "options" => hsp_time_generator(),
                            "value" => old('help_scheduled_time', $seminar->exists ? $seminar->toLocalizeTime('scheduled_at') : ''),
                            "extra" => "form-confirm",
                            ])
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                @input([
                    "for" => "seminar",
                    "name" => "help_deadline_date",
                    "type" => "select",
                    "value" => old('help_deadline_date', $seminar->exists ? $seminar->help_deadline_at->format("Y-m-d") : now()->format("Y-m-d")),
                    "options" => hsp_date_generator('now',"+1 year"),
                    ])
            </div>
            <div class="col-sm-12 col-md-5 ">
                <div class="form-row {{ $errors->has('max_help_people') ? 'is-invalid' : '' }}">
                    <div class="form-group col-6">
                        <label for="deadline_date">@lang("seminar.form.label.max_help_people")</label>
                        <input class="form-control {{ $errors->has('max_help_people') ? 'is-invalid' : '' }} " name="max_help_people" type="text" form-confirm="" value="{{ old('max_help_people', $seminar->max_help_people) }}">
                    </div>
                    <div class="col-6">
                        <label>&nbsp;</label>
                        <h3 class="mt-1 font-weight-bold">人</h3>
                    </div>
                </div>
                @includeWhen($errors->has('max_help_people'), 'components.form-error', ["name" => 'max_help_people'])
                 <h6 role="help-text" class="reference-mark ml-4 mt-n2 font-weight-bold hidden-on-form-confirm">@lang("seminar.form.helper.max_help_people")</h6>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 col-lg-6">
                @input([
                    "for" => "seminar",
                    "name" => "help_tel",
                    "type" => "text",
                    "value" => $seminar->help_tel,
                    "extra" => "form-confirm",
                    ])
            </div>
        </div>
    </div>
    @input([
        "for" => "seminar",
        "name" => "sender",
        "type" => "text",
        "value" => old("sender", $seminar->sender),
        "extra" => "form-confirm",
        ])
</div>
