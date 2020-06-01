@extends('layouts.app')
@section('content')
<header class="row mb-4 mr-0 ml-0">
    <div class="col-sm-12 col-md-9">
        <h2 class="page-title">お手紙配信履歴</h2>
        <h4 class="font-weight-bolder">送信先：{{$schoolClass->name}}</h4>
        <h4 class="font-weight-bolder">お手紙タイトル：{{$letter->subject}}</h4>
        @include("components.search", [])
    </div>

</header>

<div class="row mr-0 ml-0">
    <div class="col-sm-12 col-md-9">
        <div class="float-right mb-2">
            既読・未読の有無
            <a href="{{route('admin.letter.class', [$letter, $schoolClass])}}{{request()->query('show') === 'read' ? '?show=all' : '?show=read'}}" class="btn {{request()->query('show') === 'read' ? 'btn-primary' : 'btn-dark'}} btn-sm">既読</a>
            <a href="{{route('admin.letter.class', [$letter, $schoolClass])}}{{request()->query('show') === 'unread' ? '?show=all' : '?show=unread'}}" class="btn {{request()->query('show') === 'unread' ? 'btn-primary' : 'btn-dark'}} btn-sm">未読</a>
        </div>
    </div>
</div>
<div class="row mr-0 ml-0">
    <div class="col-sm-12 col-md-9">
        <table class="table datatable" id="letter_receivers" data-controller="datatable">
            <thead>
                <tr>
                    <th class="datatable--header--cell">お子様名</th>
                    <th class="datatable--header--cell">開封日時</th>
                    <th class="datatable--header--cell">既読</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($letter->readStatuses as $readStatus)
                @if(request()->query('show', 'all') === 'all' || request()->query('show') === $readStatus->status)
                <tr>
                    <td>{{$readStatus->student->name}}</td>
                    <td>{{$readStatus->read ? $readStatus->toLocalizeDateTime("created_at") : '-'}}</td>
                    <td>
                        <div class="registration-status {{$readStatus->read ? 'registration-status--circle' : 'registration-status--cross'}}"></div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="hidden-sm col-md-3">
        {{-- <figure class="figure position-fixed px-5" style="bottom: 0">
            <img src="{{asset('/css/asset/bird.png')}}" class="figure-img img-fluid">
        </figure> --}}
    </div>
</div>
@endsection
