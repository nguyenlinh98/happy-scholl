@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>登録業者一覧</h2>
    <div class="btn-toolbar mb-2 mb-md-0" id="toolbar">
        <div class="btn-group mr-2" id="toolbar-table-buttons">
            <div class="dt-buttons btn-group">
                <button class="btn buttons-copy buttons-html5 btn-sm btn-outline-secondary" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>Copy</span>
                </button>
                <button class="btn buttons-csv buttons-html5 btn-sm btn-outline-secondary" tabindex="0" data-controller="datatable-export" export-table-identifier='corporates_table' data-action="click->datatable-export#export" type="button">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>Excel(CSV)</span>
                </button>
            </div>
        </div>
    </div>
</div>
<nav class="mb-4">
    <a href="{{route('corporate.create')}}" class="btn btn-primary btn-lg btn-block">業者の追加</a>
</nav>
<table class="table datatable" data-action="export@window->datatable#export" id="corporates_table">
    <thead>
        <tr>
            <th scope="col">業者名</th>
            <th scope="col">連絡先Tel</th>
            <th scope="col">連絡先Fax</th>
            <th scope="col" data-type="date" data-format="Y年m月d日 h:i" data-exportable="true">登録日時</th>
            <th scope="col" data-sortable="false" data-exportable="false">操作</th>
            <th scope="col" data-sortable="false" data-exportable="false">担当者</th>
        </tr>
    </thead>
    <tbody>
        @foreach($corporates as $corporate)
            <tr>
                <td>{{$corporate->name}}</td>
                <td>{{$corporate->tel}}</td>
                <td>{{$corporate->fax}}</td>
                <td>{{$corporate->created_at->format('Y年m月d日 h:i')}}</td>
                <td>
                    @include('components.inline-buttons', [
                        "iteration" => $loop->iteration,
                        "editRoute" => route('corporate.edit', $corporate),
                        "deleteRoute" => route('corporate.destroy', $corporate),
                        "modelId" => $corporate->id,
                    ])
                </td>
                <td></td>

            </tr>
        @endforeach
    </tbody>
</table>
@endsection
