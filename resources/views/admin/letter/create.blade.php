@extends('layouts.app')
@section('content')
@component('components.form')
@slot('title', __('letter.title.index'))

@slot('action', route('admin.letter.confirm'))
@slot('header')

<div class="container-fluid p-0">
    <div class="p-0 mb-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            @if( request()->get('type') === 'individual' )
            <h2 class="text-muted">個別のお手紙</h2>
            @else
            <h2 class="text-muted">お手紙</h2>
            @endif
        </div>
    </div>
</div>

@endslot
<div class="d-flex row-search pt-4 px-4">
    <div class="p-0 row-search-btn">
        @if( request()->get('type') === 'individual' )
        <a href="{{route('admin.letter.create')}}?type=collection">
            <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                <p class="mb-0">お手紙の作成</p>
            </div>
        </a>
        @else
        <div class="text-center mr-3 btn-content-deactive btn-content-letter-action mb-0">
            <p class="mb-0">お手紙の作成</p>
        </div>
        @endif
    </div>
    @if(hsp_setting('letter_individual_active'))
    <div class="p-0 row-search-btn">
        @if( request()->get('type') === 'individual' )
        <div class="text-center mr-3 btn-content-deactive btn-content-letter mb-0 float-right">
            <p class="mb-0">個別お手紙の作成</p>
        </div>
        @else
        <a href="{{route('admin.letter.create')}}?type=individual">
            <div class="text-center mr-3 btn-content btn-content-letter mb-0 float-right">
                <p class="mb-0">個別お手紙の作成</p>
            </div>
        </a>
        @endif
    </div>
    @endif
</div>
<div class="p-4">
    @input([
    "for" => "letter",
    "name" => "subject",
    "value" => old("subject"),
    "type" => "text",
    ])
    @input([
    "for" => "letter",
    "name" => "body",
    "value" => old("body"),
    "type" => "textarea",
    "extra" => "data-controller=textarea data-action=input->textarea#input"
    ])
    <label for="body" class="form-label">@lang("message.form.label.receivers")</label>
    @includeIf("admin.letter.form.select-" . request()->query('type', 'collection'))
    <div class="row">
        <div class="col-sm-12 col-md-4">
            @input([
            "for" => "letter",
            "name" => "sender",
            "value" => old("sender"),
            "type" => "text",
            ])
        </div>
        <div class="col-sm-12 col-md-2"></div>
        <div class="col-sm-12 col-md-6">
            <label for="body" class="form-label">配信日時</label>
            <div class="form-row">
                <input type="radio" class="check-radio" id="checkDate" @if(old('checkDateSetting') !== 2) checked @endif name="checkDateSetting" value="1">
                <label for="checkDate" style="margin-left: 5px;font-size: 15.63px;font-weight: bold;color: #777;">すぐに送る</label> <br>
            </div>
            <div class="form-row">
                <input type="radio" id="checkdate2" class="check-radio" @if(old('checkDateSetting') == 2) checked  @endif name="checkDateSetting" value="2">
                <label for="checkdate2" style="margin-left: 5px;font-size: 15.63px;font-weight: bold;color: #777;">タイマー設定</label> <br>
                <div class="form-row" style="margin-left: 15px; width: 100%">
                    @input([
                    "for" => "letter",
                    "name" => "date",
                    "type" => "select",
                    "options" => hsp_date_generator('now','+1 year'),
                    "value" => old('date'),
                    "groupClass" => "col-sm-12 col-md-8",
                    "class" => "checkDisable",
                    "extra" => "disabled"
                    ])
                    @input([
                    "for" => "letter",
                    "name" => "time",
                    "type" => "select",
                    "options" => hsp_time_generator(),
                    "value" => old('time'),
                    "groupClass" => "col-sm-12 col-md-4 @error('scheduled_datetime') is-invalid @enderror",
                    "class" => "checkDisable",
                    "extra" => "disabled"
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
                <span id="file-label" data-target="file.label" class="font-weight-bold file--label">{{old('file_name')}}</span>
                <span class="file--delete" data-target="file.trigger" data-action="click->file#delete">&times;</span>
                <input type="hidden" value="{{old('file_name')}}" name="file_name" data-target="file.delete">
                <input type="hidden" value="{{old('file_path')}}" name="file_path" data-target="file.delete">
            </div>
        </div>
    </div>
    @includeWhen($errors->has('file'), 'components.form-error', ["name" => "file"])
    <input type="hidden" name="letter_type" value="{{request()->query('type', 'collection')}}">
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
