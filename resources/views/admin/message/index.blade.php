@extends('layouts.app')
@section('content')
@if(session('action'))
@includeIf('admin.message.action.' . session('action'))
@endif
<div class="container-fluid">
    {{-- <header class="row">
        <div class="col-6">
            <h2 class="page-title">{{hsp_getTitle()}}</h2>
        </div>
        <div class="col-6">
            @include("components.search", [])
        </div>
    </header> --}}

    <h2 class="page-title">{{hsp_title()}}</h2>
    <div class="d-flex justify-content-between pb-3">
        <div class="row-buttons d-flex">
            <div class="p-0 row-search-btn">
                <a href="{{route('admin.message.create')}}">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">お知らせの作成</p>
                    </div>
                </a>
            </div>
            <div class="p-0 row-search-btn">
                <a href="{{route('admin.message.sent_list')}}">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">配信済み一覧</p>
                    </div>
                </a>
            </div>
        </div>
        @include("components.search", [])
    </div>

    <div class="title-content">予約一覧</div>
    <table class="table datatable" id="messages_table" data-controller="datatable">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="datatable--header--cell">配信者</th>
                <th scope="col" class="datatable--header--cell">配信先</th>
                <th scope="col" class="datatable--header--cell">お知らせタイトル</th>
                <th scope="col" class="datatable--header--cell">予約日時</th>
                <th scope="col" class="datatable--header--cell" data-sortable="false" style="width: 100px;">修正する</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
            <tr>
                <td>{{$message->sender}}</td>
                <td>{{$message->getClassList()}}</td>
                {{-- <td>{{$message->send_to_all_classes ? '全体' : $message->getClassList()}}</td> --}}
                <td>{{$message->subject}}</td>
                <td>{{$message->toLocalizeDateTime('scheduled_at')}}</td>
                <td><a href="{{route('admin.message.edit', $message)}}" class="btn btn-edit btn-sm"><span class="text-middle fs-btn-edit">修正</span></a></td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
