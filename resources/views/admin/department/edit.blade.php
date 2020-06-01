@extends('layouts.app')
@section('content')
@component('components.form')
@slot('action', route('admin.department_setting.confirm', ["department_setting" => $department]))
@slot('back', route('admin.department_setting.list-department'))
@slot('header')
<div class="pt-3 pb-2">
    <h2 class="page-title">所属先設定</h2>
</div>
@endslot
@include('admin.department.form')
@endcomponent
@endsection
