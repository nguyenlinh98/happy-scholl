@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h2 class="page-title">{{ hsp_title() }}</h2>
    </div>
    <div class="d-flex justify-content-between pb-3">
        <div class="row-buttons d-flex">
            <div class="p-0 row-search-btn">
                <a href="{{ route('admin.class.create') }}">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">クラスの追加</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <table class="table datatable text-center" id="teachers_table">
        <thead>
            <tr>
                <th scope="col" class="datatable--header--cell" aria-label="クラス名: 列を昇順に並べ替えるにはアクティブにする">クラス</th>
                <th scope="col" class="datatable--header--cell">担任</th>
                <th scope="col" class="datatable--header--cell">子どもの登録人数</th>
                <th scope="col" class="datatable--header--cell">登録済み保護者の人数</th>
                <th scope="col" class="datatable--header--cell">出席・欠席通知</th>
                <th scope="col" class="datatable--header--cell" data-sortable="false" data-exportable="false" style="width: 200px;">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $class)
                <tr>
                    <td><a href="{{ route('admin.class.show', $class) }}">{{ $class->name }}</a></td>
                    <td>
                        @foreach($class->homeroomTeachers as $teacher)
                            <a href="{{ route('admin.teacher.edit', $teacher) }}">{{ $teacher->name }}{{ $loop->last ? '' : ', ' }}</a>
                        @endforeach
                    </td>
                    <td>{{ $class->students_count }}人</td>
                    <td>{{ $class->parents_count }}人</td>
                    <td>{{ $class->today_attendances_count }}通</td>
                    <td>
                        @include('components.inline-buttons', [
                        "iteration" => $loop->iteration,
                        "editRoute" => route('admin.class.edit', $class),
                        "deleteRoute" => route('admin.class.destroy', $class),
                        "modelId" => $class->id,
                        ])
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
