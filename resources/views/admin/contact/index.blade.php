@extends('layouts.app')
@section('content')
@if(session('action'))
@includeIf('admin.contact.action.' . session('action'))
@endif
<header>
    <h2 class="page-title">{{ hsp_title() }}</h2>
    <h4>確認したい連絡網のクラスを選んでください</h4>
</header>
<table class="table datatable" id="contact_table">
    <thead>
        <tr class="datatable--header--row">
            <th scope="col" class="datatable--header--cell">クラス</th>
            <th scope="col" class="datatable--header--cell">担任</th>
            <th scope="col" class="datatable--header--cell">登録状況</th>
            <th scope="col" class="datatable--header--cell">欠席通知</th>
        </tr>
    </thead>
    <tbody>
        @foreach($schoolClasses as $schoolClass)
        <tr data-controller="link" data-link-href="{{route("admin.contact.class", $schoolClass)}}" data-action="click->link#go">
            <td>{{$schoolClass->name}}</td>
            <td>@foreach ($schoolClass->homeroomTeachers as $teacher)
                <a class="btn" href="#">{{$teacher->name}}</a>
                @endforeach
            </td>
            <td>
                {{$schoolClass->students_count}}人
            </td>
            <td>0通</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
