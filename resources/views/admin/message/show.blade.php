@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>{{ hsp_title() }}</h2>
</div>
<div class="card mt-3">
    <h5 class="card-header">{{$message->subject}}</h5>
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">タイトル</dt><dd class="col-sm-9">{{$message->subject}}</dd>
            <dt class="col-sm-3">配信者</dt><dd class="col-sm-9">{{$message->sender}}</dd>
            <dt class="col-sm-3">配信先（クラスグループ）</dt><dd class="col-sm-9">1 set per year</dd>
            <dt class="col-sm-3">配信日時</dt><dd class="col-sm-9">{{$message->created_at->format("Y-m-d h:i:s")}}</dd>
            <dt class="col-sm-3">ファイル（PDF・jpeg）</dt><dd class="col-sm-9">@if(filled($message->file)) <a href="{{route('admin.message.file', $message)}}">{{basename($message->file)}}</a> @endif</dd>
        </dl>
        <blockquote>
            {{$message->body}}
        </blockquote>
    </div>
    <hr>
    <table class="table datatable" id="message_table">
        <thead>
            <tr>
                <th scope="col">配信先（親 / 子）</th>
                <th scope="col">未読 / 既読</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>
@endsection
