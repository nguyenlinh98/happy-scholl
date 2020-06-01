@extends('layouts.app')
@section('content')
@if(session('action'))
@includeIf('admin.require-feedback.action.' . session('action'))
@endif
<div class="container-fluid">
    @include('layouts.elements.title')
    <div class="d-flex justify-content-between pb-3">
        <div class="row-buttons d-flex">
            <div class="p-0 row-search-btn">
                <a href="{{route('admin.require_feedback.create')}}" >
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0" style="width: 310px">
                        <p class="mb-0">   {{ hsp_action('create') }}</p>
                    </div>
                </a>
            </div>
            <div class="p-0 row-search-btn">
                <a href="{{route('admin.require_feedback.list')}}" >
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0" style="width: 310px">
                        <p class="mb-0">配信予約一覧</p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            @include("components.search")
        </div>
    </div>

    <div class="title-content mt-3">履歴一覧</div>
    <table class="table datatable" id="require_feedbacks_table" data-controller="datatable">
        <thead>
            <tr>
                <th class="datatable--header--cell text-center" style="width:10%;">配信者</th>
                <th class="datatable--header--cell text-center" style="width:10%;">配信先</th>
                <th class="datatable--header--cell text-center" style="width:24%;">タイトル</th>
                <th class="datatable--header--cell text-center" style="width:18%;">配信日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requireFeedbacks as $requireFeedback)
            <tr class="text-center" data-controller="link" data-link-href="{{$requireFeedback->isIndividuals ? route('admin.admin.require_feedback.edit', $requireFeedback) : route('admin.require_feedback.classes', $requireFeedback)}}" data-action="click->link#go">
                <td>{{$requireFeedback->sender}}</td>
                <td>{{$requireFeedback->receivers_list->slice(0, 2)->join("、")}}</td>
                <td>{{$requireFeedback->subject}}</td>
                <td>{{$requireFeedback->toLocalizeDateTime('scheduled_at')}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endsection
</div>
