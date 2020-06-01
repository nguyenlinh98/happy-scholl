@extends('layouts.app')
@section('content')
    <header class="mb-4">
        <h1 class="text-secondary mb-2">{{hsp_title()}}</h1>
        <h3 class="font-weight-bold">回答削除日: {{$seminar->toLocalizeDate('scheduled_at')}}</h3>
        <div class="row align-items-center">
            <div class="col-2">
                <h3 class="mb-0 font-weight-bold">申込者数 <span class="border border-dark px-4 h3">{{$seminar->students->count()}}</span></h3>
            </div>
            <div class="col-3">
                <a href="#" class="btn btn-secondary btn-block rounded--lg"><span class="font-weight-bold h4">リストダウンロード</span></a>
            </div>
            <div class="col-4 offset-1">
                <h3 class="mb-0 font-weight-bold float-left">未定 <span class="border border-dark px-4 h3 font-weight-bold">{{$seminar->students->count()}}</span></h3>
                <h3 class="mb-0 font-weight-bold float-left ml-4">欠席 <span class="border border-dark px-4 h3 font-weight-bold">{{$seminar->students->count()}}</span></h3>
            </div>
        </div>
    </header>
    <table class="table datatable" id="seminar_students_table">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="datatable--header--cell">クラス</th>
                <th scope="col" class="datatable--header--cell">生徒名</th>
                <th scope="col" class="datatable--header--cell" style="width: 60%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($seminar->students as $student)
                <tr>
                    <td>{{$student->class->name}}</td>
                    <td>{{$student->name}}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
