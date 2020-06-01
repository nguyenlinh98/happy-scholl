@extends('layouts.app')
@section('content')
@if(session('action'))
@includeIf('admin.letter.action.' . session('action'))
@endif

<div class="container-fluid">
    <h2 class="page-title">{{hsp_title()}}</h2>
    <div class="d-flex justify-content-between pb-3">
        <div class="row-buttons d-flex">
            <div class="p-0 row-search-btn">
                <a href="{{route('admin.letter.create')}}">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">お手紙の作成</p>
                    </div>
                </a>
            </div>
            <div class="p-0 row-search-btn">
                <a href="{{route('admin.letter.scheduling')}}">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">配信予約一覧</p>
                    </div>
                </a>
            </div>
        </div>
        @include("components.search", [])
    </div>


    <div class="title-content">履歴一覧</div>
    <table class="table datatable" id="letters_table" data-controller="datatable">
        <thead>
            <tr class="datatable--header--row text-center">
                <th scope="col" class="datatable--header--cell">配信者</th>
                <th scope="col" class="datatable--header--cell" data-column="destination">配信先（クラス・グループ）</th>
                <th scope="col" class="datatable--header--cell" data-column="title">お手紙タイトル</th>
                <th scope="col" class="datatable--header--cell" data-column="attachment">添付データタイトル</th>
                <th scope="col" class="datatable--header--cell">日時</th>
                @isset($editable)
                <th scope="col" class="datatable--header--cell">修正する</th>
                @endisset
            </tr>
        </thead>
        <tbody>
            @foreach($letters as $letter)
            <tr data-controller="link" data-link-href="{{$letter->isIndividuals ? route('admin.letter.students', $letter) : route('admin.letter.classes', $letter)}}" data-action="click->link#go">
                <td>{{$letter->sender}}</td>
                <td>{{$letter->receivers_list->slice(0, 2)->join("、")}}</td>
                <td>{{$letter->subject}}</td>
                <td>{{$letter->file_name}}</td>
                <td>{{$letter->toLocalizeDateTime('scheduled_at')}}</td>
                @isset($editable)
                <td>
                    <a href="{{route('admin.letter.edit', $letter)}}" class="btn btn-dark">修正</a>
                </td>
                @endisset
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
