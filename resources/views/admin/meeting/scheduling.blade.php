@extends('layouts.app')
@section('content')
@if(session('action'))
    @includeIf('admin.meeting.action.' . session('action'))
    @endif

    <h2 class="page-title">{{ hsp_title() }}</h2>
    <div class="d-flex justify-content-between pb-3">
        <div class="row-buttons d-flex">
            <div class="p-0 row-search-btn">
                <a href="{{ route('admin.meeting.create') }}">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">お手紙の作成</p>
                    </div>
                </a>
            </div>
            <div class="p-0 row-search-btn">
                <a href="{{ route('admin.meeting.index') }}">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">配信履歴一覧</p>
                    </div>
                </a>
            </div>
        </div>
        @include("components.search", [])
    </div>
    {{--
<div class="container-fluid p-0">
    <div class="p-0">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4">
            <h3 class="page-title">お手紙配信予約</h3>
            {{-- @include("components.search", []) --}}
    {{-- </div>

    </div>

</div> --}}
    <span class="title-content">予約一覧</span><span>※修正ボタンをクリックすると、配信設定から編集できます。</span>
    <table class="table datatable" id="letters_scheduling_table" data-controller="datatable">
        <thead>
            <tr class="datatable--header--row text-center">
                <th scope="col" class="datatable--header--cell">配信者</th>
                <th scope="col" class="datatable--header--cell">配信先（クラス・グループ）</th>
                <th scope="col" class="datatable--header--cell">お手紙タイトル</th>
                <th scope="col" class="datatable--header--cell">添付データタイトル</th>
                <th scope="col" class="datatable--header--cell">予約日時</th>
                @isset($editable)
                    <th scope="col" class="datatable--header--cell">修正する</th>
                @endisset
            </tr>
        </thead>
        <tbody>
            @foreach($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->sender }}</td>
                    <td>{{ $meeting->receivers_list->slice(0, 2)->join("、") }}</td>
                    <td>{{ $meeting->subject }}</td>
                    <td>{{ $meeting->file_name }}</td>
                    <td>{{ $meeting->toLocalizeDateTime('scheduled_at') }}</td>
                    @isset($editable)
                        <td>
                            <a href="{{ route('admin.meeting.edit', $meeting) }}" class="btn btn-edit">修正</a>
                        </td>
                    @endisset
                </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
