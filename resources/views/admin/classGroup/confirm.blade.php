@extends('layouts.app')
@section('content')

@component('components.form-confirm')
@slot('action', $classGroup->exists ? route('admin.cgroup.update', $classGroup) : route('admin.cgroup.store'))
@slot('title', 'お知らせ')

<input type="hidden" value="confirmed" name="confirmation">
@if($classGroup->exists)
@method('PATCH')

@endif
<div class="p-4">

    @confirm([
    "for" => "cgroup",
    "name" => "name",
    "value" => $classGroup->name
    ])

    <div class="form-group">
        <label for="class_group_toggle">@lang("cgroup.form.label.classes")</label>
        <div class="bg-white p-2 pt-3">
            @class_department_group_confirm([
            "model" => $classGroup,
            "prefix" => "class_group_selection_"
            ])
            <input type="hidden" name="class_group_selection_select" value="{{$classGroup->class_group_selection_select}}">
        </div>
    </div>

</div>
@endcomponent
@endsection
