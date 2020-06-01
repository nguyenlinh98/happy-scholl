@extends('layouts.app')
@section('content')
@component('components.form-confirm')
@slot('title', __('letter.title.index'))

@slot('action', $letter->exists ? route('admin.letter.update', $letter) : route('admin.letter.store'))
@slot('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3">
    <h2 class="font-weight-bold text-secondary title-fs">{{$title}}</h2>
</div>

@endslot
<div class="p-4">
    <input type="hidden" value="confirmed" name="confirmation">
    @if($letter->exists)
    @method('PATCH')
    @endif
    @confirm([
    "for" => "letter",
    "name" => "subject",
    "value" => $letter->subject,
    ])
    @confirm([
    "for" => "letter",
    "name" => "body",
    "value" => $letter->body,
    ])

    <div class="form-group">
        <label for="class_group_toggle">@lang("letter.form.label.receiver_type")</label>
        <div class="p-2 pt-3">
            @isset($letter->send_to_select)
            @class_department_group_confirm([
            "model" => $letter,
            "prefix" => "send_to_"
            ])
            <input type="hidden" name="send_to_select" value="{{$letter->send_to_select}}">
            @else
            <div class="form-row">
                @foreach ($letter->receiversCollection as $student)
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
                <input type="hidden" name="individual_receivers" value="{{$letter->individual_receivers}}">
            </div>
            @endif
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-12 col-md-4">

            @confirm([
            "for" => "letter",
            "name" => "sender",
            "value" => $letter->sender,
            ])
        </div>
        <div class="col-sm-12 col-md-6 offset-md-2">
            <input type="hidden" value="{{request()->post('checkDateSetting')}}" name="checkDateSetting">
            @if(request()->post('checkDateSetting') == 2)
            @confirm([
            "for" => "letter",
            "name" => "scheduled_at",
            "value" => $letter->toLocalizeDateTime('scheduled_at'),
            "hiddens" => [
            "date" => $letter->date,
            "time" => $letter->time
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
    <div class="form-group">
        <label>ファイル（PDF・jpeg）</label>
        <h4 class="font-weight-bold">{{$letter->uploadedFileName}}</h4>
        <input type="hidden" value="{{$letter->filePath}}" name="file_path">
        <input type="hidden" value="{{$letter->uploadedFileName}}" name="file_name">
    </div>
    <input type="hidden" name="letter_type" value="{{$letter->letter_type}}">
</div>
@endcomponent
@endsection
