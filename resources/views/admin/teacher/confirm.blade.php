@extends('layouts.app')
@section('content')
@component('components.form-confirm')
@slot('title', hsp_title())
@slot('action', $teacher->exists ? route("admin.teacher.update", $teacher) : route('admin.teacher.store'))
@if($teacher->exists)
@method("PATCH")
@endif
@confirm([
"for" => "teacher",
"name" => "name",
"value" => $teacher->name,
])
<div class="form-group">
    <label>クラス</label>
    <div class="bg-white p-2 pt-3">
        @class_department_group_confirm([
            "model" => $teacher,
            "prefix" => "responsibility_",
            "multipleSelect" => true,
        ])
        <input type="hidden" name="responsibility_select" value="{{$teacher->responsibility_select}}">
    </div>
</div>
<div class="form-group">
    <label>担任</label>
    <div class="bg-white p-2">
        @if($teacher->responsibility_school_classes && $teacher->is_homeroom_teacher)
        @foreach ($teacher->responsibility_school_classes as $school_class)
        <h5>{{$school_class->name}}</h5>
        <input type="hidden" name="homeroom" value="yes">
        @endforeach
        @else
        　
        @endif
    </div>
</div>
<h4 class="text-center mt-4 mb-5">上記の内容でよろしければ登録ボタンからお進みください</h4>
@endcomponent
@endsection
