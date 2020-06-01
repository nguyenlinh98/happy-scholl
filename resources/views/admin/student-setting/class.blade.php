@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.student_setting.massDelete') }}">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3">
            <h2 class="page-title">{{ hsp_title() }}</h2>
            <div class="btn-toolbar mb-2 mb-md-0" id="toolbar">
                <div class="mr-2 toggle--delete-column--off" id="toolbar-table-buttons">
                    <button class="btn btn-sm btn-secondary" tabindex="0" type="button" data-target="#uploadFormModal" data-toggle="modal">
                        {{ hsp_action('import') }}
                    </button>
                    <button class="btn btn-sm btn-secondary" tabindex="0" type="button" data-target="#createFormModal" data-toggle="modal">
                        {{ hsp_action('create') }}
                    </button>
                    <button class="btn btn-sm btn-secondary " tabindex="0" type="button" data-action="click->toggle#toggle" data-toggle-id="main" data-toggle-class="toggle--delete-column">
                        {{ hsp_action('delete') }}
                    </button>
                </div>
                <div class="mr-2 toggle--delete-column--on">
                    <button type="submit" class="btn btn-sm btn-danger toggle--delete-column--trigger-off" tabindex="0">削除の確認</button>
                    <button type="button" class="btn btn-sm btn-link toggle--delete-column--trigger-off" tabindex="0" data-action="click->toggle#toggle" data-toggle-id="main" data-toggle-class="toggle--delete-column">キャンセル</button>
                </div>
            </div>
        </div>

        <table class="table datatable" id="students_table">
            <thead>
                <tr class="datatable--header--row">
                    <th scope="col" class="datatable--header--cell">クラス</th>
                    <th scope="col" class="datatable--header--cell">お子様</th>
                    <th scope="col" class="datatable--header--cell">登録状況</th>
                    <th scope="col" class="datatable--header--cell">出席・欠席通知</th>
                    <th scope="col" class="datatable--header--cell datatable--header--delete" style="width: 100px;" data-sortable="false">選択</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $schoolClass->name }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->parents_count }}人</td>
                        <td>
                            @include("admin.student-setting.student-attendance")
                        </td>
                        <td class="datatable--delete--cell" style="width: 100px;">
                            <div class="ml-n4">
                                @checkbox([
                                    "name" => "delete_student_ids[]",
                                    "id" => "delete_student_id_{$student->id}",
                                    "value" => $student->id,
                                    "label" => "",
                                    "class" => ""
                                    ])
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>
<div class="modal" id="createFormModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close modal--close--float" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                @include('admin.student-setting.form')
            </div>
        </div>
    </div>
</div>
@include("admin.student-setting.modal.import-modal")
@if($errors->any())
    <script>
        $('#createFormModal').show();
        $('.modal--close--float').click(function () {
            $('#createFormModal').hide();
        })

    </script>
@endif
@endsection
