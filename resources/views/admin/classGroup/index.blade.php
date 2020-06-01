@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="page-title">{{ hsp_title() }}</h2>
</div>
<span>グループを削除する場合は、グループを選択して削除ボタンを押してください。</span>

<form method="post" action="{{ route('admin.cgroup.delete-multi') }}" enctype="multipart/form-data" class="form--common" id="form-xxx" style="height: 100%">
    {{ csrf_field() }}
    <table class="table datatable" data-action="export@window->datatable#export" id="class_groups_table">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="text-center datatable--header--cell" data-sortable="false">選択</th>
                <th scope="col" class="text-center datatable--header--cell">グループ名</th>
                <th scope="col" class="text-center datatable--header--cell">クラス</th>
                <th scope="col" class="datatable--header--cell"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($classGroups as $classGroup)
                <tr>
                    <td>
                        <label class="d-block class-group-css mb-3">
                            <input type="checkbox" name="class_group_ids[]" id="checkbox-{{ $classGroup->id }}" class="ml-1" value="{{ $classGroup->id }}">
                            <label for="checkbox-{{ $classGroup->id }}"></label>
                        </label>
                    </td>
                    <td>{{ $classGroup->name }}</td>
                    <td>
                        @foreach($classGroup->classes as $class)
                            <a href="{{ route('admin.class.show', $class) }}" class="btn btn-link px-0">{{ $class->name }}@if(!$loop->last), @endif</a>
                        @endforeach
                    </td>
                    <td>
                        @include('components.inline-buttons-cgroup', [
                        "iteration" => $loop->iteration,
                        "editRoute" => route('admin.cgroup.edit', $classGroup),
                        "deleteRoute" => route('admin.cgroup.destroy', $classGroup),
                        "modelId" => $classGroup->id,
                        ])
                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="text-center">
        <button type="submit" class="btn btn-link text-center" onclick=""><img class="btn-hover" src="{{ url('/css/asset/button/cg-action-del.png') }}" alt=""></button>
    </div>
</form>

@endsection
