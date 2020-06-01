@extends('layouts.app')
@section('content')
@if(session('action'))
@includeIf('admin.department.action.' . session('action'))
@endif
<div class="container-fluid p-0">
    <div class="p-0">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
            <p class="title mb-0">所属先設定</p>
        </div>
        <div class="row m-0">
            <a href="{{route('admin.department_setting.create')}}">
                <div class="text-center mr-3 p-0 btn-content btn-content-department mb-0">
                    <p class="mb-0">新しい所属先を登録する</p>
                </div>
            </a>
            <a href="{{route('admin.department_setting.list-department')}}">
                <div class="text-center mr-3 p-0 btn-content btn-content-department mb-0 float-right">
                    <p class="text-center mr-3 btn-content mb-0">登録済みの所属先を編集する</p>
                </div>
            </a>
        </div>
    </div>

</div>

@endsection
