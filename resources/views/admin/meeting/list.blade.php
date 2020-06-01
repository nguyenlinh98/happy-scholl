@extends('layouts.app')
@section('content')

<div class="container-fluid p-0">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
        <p class="title mb-0">お手紙配信履歴 </p>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="form-row mt-5">
                <div class="col-4">
                    <a href="#" class="btn btn-block btn-lg btn-dark py-3 rounded--lg" aria-disabled="true"><span class="h2 font-weight-bold">全体</span></a>
                </div>
                <div class="col-4">
                    <a href="{{route('admin.letter.class')}}" class="btn btn-block btn-lg btn-primary py-3 rounded--lg"><span class="h2 font-weight-bold">クラス</span></a>
                </div>
                <div class="col-4">
                    <a href="#" class="btn btn-block btn-lg btn-dark py-3 rounded--lg"><span class="h2 font-weight-bold">個別</span></a>
                </div>
            </div>
        </div>

        <div class="col-4 offset-1">
            <div class="form-group mt-2">
                <label for="searchbox" class="h1 font-weight-bold">キーワード検索</label>
                <div class="form-row">
                    <div class="form-group col-sm-12 col-md-9">
                        <input type="text" name="searchbox" id="searchbox" class="form-control form-control-lg" />
                    </div>
                    <div class="form-group col-sm-12 col-md-3">
                        <button class="btn-dark btn btn-block hidden-on-form-confirm btn-lg" data-toggle="modal" data-target="#selectClassModal" type="button">検索</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2 offset-1">
            {{-- <img src="{{url('/css/asset/bird.png')}}" alt="" style="width: 100%"> --}}
        </div>
    </div>
</div>

<div class="title-content">{{hsp_title()}}</div>

<table class="table datatable" id="letter_for_class_table">
    <thead>
        <tr class="datatable--header--row">
            <th scope="col" class="datatable--header--cell">送信先</th>
            <th scope="col" class="datatable--header--cell">お手紙タイトル</th>
            <th scope="col" class="datatable--header--cell">添付データタイトル</th>
            <th scope="col" class="datatable--header--cell">日時</th>
            <th scope="col" class="datatable--header--cell">既読</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($receivers as $receiver)
        <tr>
            <td>{{$receiver->receiver->name}}</td>
            <td>{{$receiver->letter->subject}}</td>
            <td>{{$receiver->letter->fileName}}</td>
            <td>{{$receiver->letter->toLocalizeDateTime('scheduled_at')}}</td>

            <td>

            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection
