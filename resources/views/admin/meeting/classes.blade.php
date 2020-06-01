@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <h2 class="page-title">お手紙配信履歴</h2>
    <div class="row">
        {{-- <div class="col-4">
            <div class="form-row mt-5">
                <div class="col-4">
                    <button href="#" class="btn btn-block btn-lg btn-dark py-3 rounded--lg" aria-disabled="true"><span class="h2 font-weight-bold">全体</span></button>
                </div>
                <div class="col-4">
                    <a href="#" class="btn btn-block btn-lg btn-primary py-3 rounded--lg"><span class="h2 font-weight-bold">クラス</span></a>
                </div>

                <div class="col-4">
                    <button href="#" class="btn btn-block btn-lg btn-dark py-3 rounded--lg"><span class="h2 font-weight-bold">個別</span></button>
                </div>
            </div>
        </div> --}}

        <div class="col offset-1">
            @include("components.search")
        </div>
    </div>


    <span class="title-content">{{ hsp_title() }}</span><span>※選択すると、既読の有無を確認できます。</span>

    <table class="table datatable" id="letter_for_class_table" data-controller="datatable">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="datatable--header--cell">送信先</th>
                <th scope="col" class="datatable--header--cell">お手紙タイトル</th>
                <th scope="col" class="datatable--header--cell">添付データタイトル</th>
                <th scope="col" class="datatable--header--cell">日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schoolClasses as $schoolClass)
                <tr data-controller="link" data-link-href="{{ route('admin.meeting.class', [$meeting, $schoolClass]) }}" data-action="click->link#go">
                    <td>{{ $schoolClass->name }}</td>
                    <td>{{ $meeting->subject }}</td>
                    <td>{{ $meeting->fileName }}</td>
                    <td>{{ $meeting->toLocalizeDateTime('scheduled_at') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
