<div class="p-4">
    @input([
        "for" => "meeting",
        "name" => "subject",
        "value" => $meeting->subject,
        "type" => "text",
    ])
    @input([
        "for" => "meeting",
        "name" => "body",
        "value" => $meeting->body,
        "type" => "textarea",
        "extra" => "data-controller=textarea data-action=input->textarea#input"
    ])
    @input([
        "for" => "meeting",
        "name" => "zoom_link",
        "value" => $meeting->zoom_link,
        "type" => "text",
    ])
    @input([
        "for" => "meeting",
        "name" => "contact_email",
        "value" => $meeting->contact_email,
        "type" => "text",
    ])
    @includeIf("admin.meeting.form.select-" . ($meeting->is_individuals ? 'individual' : 'collection'))
    <div class="row">
        <div class="col-sm-12 col-md-4">
            @input([
                "for" => "meeting",
                "name" => "sender",
                "value" => $meeting->sender,
                "type" => "text",
            ])
        </div>
        <div class="col-sm-12 col-md-6 offset-md-2">
            <label for="body" class="form-label">配信日時</label>
            <div class="form-row">
                <input type="radio" class="check-radio" id="checkDate" @if(old('checkDateSetting') == 1) checked @endif name="checkDateSetting" value="1">
                <label for="checkDate" style="padding-left: 5px;margin-left: 15px;font-size: 15.63px;font-weight: bold;color: #777;">すぐに送る</label> <br>
            </div>
            <div class="form-row">
                <input type="radio" id="checkdate2" class="check-radio" name="checkDateSetting" value="2" @if(old('checkDateSetting') !== 1) checked @endif>
                <label for="checkdate2" style="padding-left: 5px;margin-left: 15px;font-size: 15.63px;font-weight: bold;color: #777;">タイマー設定</label> <br>
                <div class="form-row" style="margin-left: 15px; width: 100%">
                    @input([
                        "for" => "meeting",
                        "name" => "date",
                        "type" => "select",
                        "options" => hsp_date_generator('now','+1 year'),
                        "value" => $meeting->date,
                        "groupClass" => "col-sm-12 col-md-8",
                        "class" => "checkDisable",
                    ])
                    @input([
                        "for" => "meeting",
                        "name" => "time",
                        "type" => "select",
                        "options" => hsp_time_generator(),
                        "value" => $meeting->time,
                        "groupClass" => "col-sm-12 col-md-4 @error('scheduled_datetime') is-invalid @enderror",
                        "class" => "checkDisable",
                    ])
                    @includeWhen($errors->has('scheduled_datetime'), 'components.form-error', ["name" => 'scheduled_datetime'])
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{$meeting->is_individuals? 'individual' : 'collection'}}" name="meeting_type">
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
