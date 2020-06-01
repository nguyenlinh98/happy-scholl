@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <header>
        <h2 class="page-title">{{ hsp_title() }}</h2>
    </header>
    <table class="table datatable" id="students_table">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="datatable--header--cell">クラス</th>
                <th scope="col" class="datatable--header--cell">担任</th>
                <th scope="col" class="datatable--header--cell">子どもの登録人数</th>
                <th scope="col" class="datatable--header--cell">登録済み保護者の人数</th>
                <th scope="col" class="datatable--header--cell">出席・欠席通知</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schoolClasses as $schoolClass)
                <tr>
                    <td><a href="{{ route('admin.student_setting.class', $schoolClass) }}">{{ $schoolClass->name }}</a></td>
                    <td>
                        @foreach($schoolClass->homeroomTeachers as $teacher)
                            <a href="{{ route('admin.teacher.edit', $teacher) }}">{{ $teacher->name }}{{ $loop->last ? '' : '、' }}</a>
                        @endforeach
                    </td>
                    <td>{{ $schoolClass->students_count }}人</td>
                    <td>{{ $schoolClass->parents_count }}人</td>
                    <td>{{ $schoolClass->today_attendances_count }}通</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
