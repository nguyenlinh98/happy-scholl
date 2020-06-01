@extends('layouts.app')
@section('content')

<div class="container-fluid">
    <h2 class="page-title">回答必要通知</h2>
    <div class="row">
        <div class="col offset-1">
            @include("components.search")
        </div>
    </div>


    <span class="title-content">{{hsp_title()}}</span><span>※選択すると、既読の有無を確認できます。</span>

    <table class="table datatable" id="letter_for_class_table" data-controller="datatable">
        <thead>
            <tr class="datatable--header--row">
                <th scope="col" class="datatable--header--cell">送信先</th>
                <th scope="col" class="datatable--header--cell">タイトル</th>
                <th scope="col" class="datatable--header--cell">本文</th>
                <th scope="col" class="datatable--header--cell">日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schoolClasses as $schoolClass)
            <tr data-controller="link" data-link-href="{{route('admin.require_feedback.class', [$requireFeedback, $schoolClass])}}" data-action="click->link#go">
                <td>{{$schoolClass->name}}</td>
                <td>{{$requireFeedback->subject}}</td>
                <td>{{$requireFeedback->body}}</td>
                <td>{{$requireFeedback->toLocalizeDateTime('scheduled_at')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
