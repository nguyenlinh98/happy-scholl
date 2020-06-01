@extends('layouts.app')
@section('content')
@component('components.form')
@slot('title', hsp_title())
@slot('action', route('admin.teacher.confirm', ["teacher" => $teacher]))
@slot("back", route("admin.teacher.list"))
@include('admin.teacher.form')
@slot("extraFooter")
<button type="button" class="btn btn-danger btn-lg px-5 rounded--lg float-right" data-toggle="modal" data-target="#confirmDeleteModal">削除</button>
@endslot
@endcomponent
<div id="confirmDeleteModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <form class="modal-dialog modal-dialog-centered" role="document" action="{{route('admin.teacher.destroy', $teacher)}}" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">削除確認</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                @method('DELETE')
                <h4 class="font-weight-bold">削除しますか？（この動きが実装しています）</h4>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">送信</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
            </div>
        </div>
    </form>
</div>
@endsection
