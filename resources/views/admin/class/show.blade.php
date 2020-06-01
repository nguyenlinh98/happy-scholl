@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{ $class->name }} </h2>
        <div class="btn-toolbar mb-2 mb-md-0" id="toolbar">
            <div class="btn-group mr-2" id="toolbar-table-buttons">
                <div class="dt-buttons btn-group">
                    <button type="button" data-toggle="modal" data-target="#studentExport" class="btn btn-link">
                        <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                            <p class="mb-0 text-dark">お子様コードの発行</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <table class="table datatable text-center" id="teachers_table">
        <thead>
            <tr>
                <th scope="col" class="datatable--header--cell" aria-label="クラス名: 列を昇順に並べ替えるにはアクティブにする">お子様</th>
                <th scope="col" class="datatable--header--cell">性別</th>
                <th scope="col" class="datatable--header--cell">登録状況</th>
                <th scope="col" class="datatable--header--cell">出席・欠席通知</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{$student->name}}</td>
                <td>{{$student->gender == 1 ? '男' : '女'}}</td>
                <td>
                    @if ($student->hasParents)
                    {{$student->parents->count()}}人
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if($student->todayAttendance)
                    <div class="registration-status {{$student->todayAttendance->is_absence ? 'registration-status--cross' : 'registration-status--circle text-danger'}}"></div>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="studentExport" tabindex="-1" role="dialog" aria-labelledby="viewCalendarEventLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                @include('admin.class.student')
            </div>
        </div>
    </div>
</div>
@endsection
