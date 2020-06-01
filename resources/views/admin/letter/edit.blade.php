@extends('layouts.app')
@section('content')
@component('components.form')
@slot('title', __('letter.title.index'))

@slot('action', route('admin.letter.confirm', $letter))
@slot('header')
<h2 class="page-title">{{hsp_title()}}</h1>
@endslot
<div class="p-4">
    @input([
    "for" => "letter",
    "name" => "subject",
    "value" => $letter->subject,
    "type" => "text",
    ])
    @input([
    "for" => "letter",
    "name" => "body",
    "value" => $letter->body,
    "type" => "textarea",
    "extra" => "data-controller=textarea data-action=input->textarea#input"
    ])
    @includeIf("admin.letter.form.select-" . ($letter->is_individuals ? 'individual' : 'collection'))
    <div class="row">
        <div class="col-sm-12 col-md-4">
            @input([
            "for" => "letter",
            "name" => "sender",
            "value" => $letter->sender,
            "type" => "text",
            ])
        </div>
        <div class="col-sm-12 col-md-2"></div>
        <div class="col-sm-12 col-md-6">
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
                    "for" => "letter",
                    "name" => "date",
                    "type" => "select",
                    "options" => hsp_date_generator('now','+1 year'),
                    "value" => $letter->date,
                    "groupClass" => "col-sm-12 col-md-8",
                    "class" => "checkDisable",
                    ])
                    @input([
                    "for" => "letter",
                    "name" => "time",
                    "type" => "select",
                    "options" => hsp_time_generator(),
                    "value" => $letter->time,
                    "groupClass" => "col-sm-12 col-md-4 @error('scheduled_datetime') is-invalid @enderror",
                    "class" => "checkDisable",
                    ])
                    @includeWhen($errors->has('scheduled_datetime'), 'components.form-error', ["name" => 'scheduled_datetime'])
                </div>
            </div>
        </div>
    </div>
    <div class="form-group {{$errors->has('file') ? 'is-invalid' : ''}}">
        <label for="letter_file">ファイル（PDF・jpeg）</label>

        <div for="letter_file">
            <div data-controller="file">
                <label for="upload_file" class="position-relative">
                    <button class="btn-uploadfile" type="button"> ファイルを選択</button>
                    <input type="file" name="file" id="upload_file" data-action="change->file#change" data-target="file.input" class="position-absolute inset-0 font-size-0 opacity-0 w-100">
                </label>
                <span id="file-label" data-target="file.label" class="font-weight-bold file--label">{{old('file_name', $letter->uploaded_file_name)}}</span>
                <span class="file--delete" data-target="file.trigger" data-action="click->file#delete">&times;</span>
                <input type="hidden" value="{{old('file_name', $letter->uploaded_file_name)}}" name="file_name" data-target="file.delete">
                <input type="hidden" value="{{old('file_path', $letter->file_path)}}" name="file_path" data-target="file.delete">
            </div>
        </div>
    </div>
    @includeWhen($errors->has('file'), 'components.form-error', ["name" => "file"])
    <input type="hidden" name="letter_type" value="{{request()->query('type', 'group-class')}}">
</div>

@slot("footer")
<button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/confirm.png')}}" alt=""></button>
<a href="{{route('admin.letter.index')}}"> <img src="{{url('/css/asset/button/cancle.png')}}" alt=""></a>
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
