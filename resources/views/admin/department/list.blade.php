@extends('layouts.app')
@section('content')
@if(session('action'))
    @includeIf('admin.department.action.' . session('action'))
    @endif
    <h2 class="page-title">所属先編集</h2>
    <h4>編集する所属先を選んでください</h4>
    <table class="table datatable">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="text-center datatable--header--cell" data-sortable="false">所属先</th>
                <th scope="col" class="text-center datatable--header--cell">担当（管理者）</th>
                <th scope="col" class="datatable--header--cell"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>
                        @if($department->managers->count() === 0)
                            未設定（管理者登録設定よりご登録ください）
                        @else
                            @foreach($department->managers as $manager)
                                {{-- <a href="{{ route('admin.teacher.show', $manager->teacher) }}" class="btn btn-link px-0">{{ $manager->teacher->name }}@if(!$loop->last), @endif</a> --}}
                                {{ $manager->teacher->name }}@if(!$loop->last), @endif
                            @endforeach
                        @endif
                    </td>
                    <td><a href="{{ route('admin.department_setting.edit', ['department_setting' => $department]) }}" class="btn btn-secondary">修正</a></td>
                </tr>
            @endforeach
        </tbody>

    </table>

    @endsection
