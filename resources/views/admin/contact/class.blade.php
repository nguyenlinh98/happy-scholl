@extends('layouts.app')
@section('content')
@if(session('action'))
@includeIf('admin.contact.action.' . session('action'))
@endif
<form method="POST" action="{{route("admin.contact.massDelete")}}">
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <header>
                <div class="d-flex justify-content-between mb-2">
                    <h2 class="page-title">連絡網登録一覧 - {{$schoolClass->name}}</h2>
                    <br/>
                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="#massDeleteRecyclesModal"><span>チェックした方を削除する</span></button>
                </div>
                <span>電話番号の登録・追加は保護者様が行います。管理からは確認・削除削除のみ行えます。</span>
            </header>
            <table class="table datatable" id="contact_table">
                <thead>
                    <tr class="datatable--header--row">
                        <th scope="col" class="datatable--header--cell">お子様</th>
                        <th scope="col" class="datatable--header--cell">属性(ご関係)</th>
                        <th scope="col" class="datatable--header--cell">チェック</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    @foreach($student->contact as $contact)
                    <tr>
                        <td><span class="{{$loop->first ? '' :'visually-hidden'}}">{{$student->name}}</span></td>
                        <td>{{$contact->relationship}}</td>
                        <td>
                            <div class="select-box">
                                <input type="checkbox" name="contacts[]" id="contacts_{{$contact->id}}" value='{{$contact->id}}' />
                                <label for="contacts_{{$contact->id}}" class="select-box--label"></label>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal" id="massDeleteRecyclesModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content bg-primary p-4 individual-select--select-class">
                <h1 class="text-white my-4 text-center">連絡網から削除しますか?</h1>
                <div class=" pt-4 mx-auto form-row w-75">
                    <div class="col-6">
                        <button type="submit" class="btn btn-danger btn-block" style="background: blue; border-color: blue"><span class="h4">削除する</span></button>
                    </div>
                    <div class="col-6">
                        <button type="button" data-dismiss="modal" class="btn btn-danger btn-block"><span class="h4">連絡網一覧画面に戻る</span></button>
                    </div>
                </div>
                @csrf
            </div>
        </div>
    </div>
</form>
@endsection
