@extends('layouts.app')
@section('content')

@component('components.form-confirm')
@slot('action', $department->exists ? route('admin.department_setting.update', $department) : route('admin.department_setting.store'))
@slot('title', '所属先')

<input type="hidden" value="confirmed" name="confirmation">
@if($department->exists)
@method('PATCH')

@endif
<div class="p-4">

    @confirm([
    "for" => "department",
    "name" => "name",
    "value" => $department->name
    ])

    {{-- <div class="form-group">
        <label for="class_group_toggle">クラス</label>
        <div class="bg-white p-2 pt-3">
            @class_department_group_confirm([
            "model" => $department,
            "prefix" => "department_setting_"
            ])
            <input type="hidden" name="department_setting_select" value="{{$department->department_setting_select}}">
        </div>
    </div> --}}

</div>
@endcomponent
@endsection
