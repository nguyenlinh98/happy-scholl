@extends('layouts.app')
@section('content')
@if(session('action'))
    @includeIf('admin.school_event.action.' . session('action'))
    @endif
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        @include('layouts.elements.title')
        <div class="btn-toolbar mb-2 mb-md-0" id="toolbar">
            <div class="mr-2 toggle--delete-column--off" id="toolbar-table-buttons">
                <a href="{{ route('admin.school_event.create') }}" class="btn  btn-sm btn-secondary" tabindex="0">
                    {{ hsp_action('create') }}
                </a>
            </div>
            <div class="mr-2 toggle--delete-column--on">
                <button type="submit" class="btn btn-sm btn-danger toggle--delete-column--trigger-off" tabindex="0">削除の確認</button>
                <button type="button" class="btn btn-sm btn-link toggle--delete-column--trigger-off" tabindex="0" data-action="click->toggle#toggle" data-toggle-id="main" data-toggle-class="toggle--delete-column">キャンセル</button>
            </div>
        </div>
    </div>
    <div class="form-row mb-3">
        <div class="col-2">
            <a href="{{ route('admin.school_event.index') }}?view=reservation" class="btn btn-block btn-lg {{ request()->query('view', 'reservation') === 'reservation' ? 'btn-primary' : 'btn-dark' }} rounded--lg"><span class="h5 font-weight-bold">予約一覧</span></a>
        </div>
        <div class="col-2">
            <a href="{{ route('admin.school_event.index') }}?view=distribution" class="btn btn-block btn-lg {{ request()->query('view') === 'distribution' ? 'btn-primary' : 'btn-dark' }} rounded--lg"><span class="h5 font-weight-bold">配信一覧</span></a>
        </div>
    </div>
    <table class="table datatable" id="messages_table">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="datatable--header--cell">配信者</th>
                <th scope="col" class="datatable--header--cell">配信先</th>
                <th scope="col" class="datatable--header--cell">講座タイトル</th>
                <th scope="col" class="datatable--header--cell">予約日時</th>
                <th scope="col" class="datatable--header--cell" data-sortable="false">修正する</th>
            </tr>
        </thead>
        @foreach($schoolEvents as $schoolEvent)
            <tr>
                <td>{{ $schoolEvent->sender }}</td>
                <td></td>
                <td>{{ $schoolEvent->subject }}</td>
                <td>{{ $schoolEvent->toLocalizeDateTime('scheduled_at') }}</td>
                <td>
                    @if(request()->query('view', 'reservation') === 'reservation')
                        <a href="{{ route('admin.school_event.edit', $schoolEvent) }}" class="btn btn-secondary"><span class="text-white">修正</span></a>
                    @else
                        <a href="{{ route('admin.school_event.show', $schoolEvent) }}" class="btn btn-secondary">修正</a>
                    @endif
                </td>

            </tr>
        @endforeach
    </table>
    @endsection
