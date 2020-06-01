@extends('layouts.app')
@section('content')
{{-- @include('layouts.elements.title') --}}
@component('components.form')
    @slot('title')
    @endslot
    @slot('action')
        {{ route('admin.school_event.confirm', $schoolEvent) }}
    @endslot

    @slot("back")
        {{ route('admin.school_event.index') }}
    @endslot

    @include('admin.school-event.form')
@endcomponent
<div id="confirmDeleteModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <form class="modal-dialog modal-dialog-centered" role="document" action="{{ route('admin.school_event.destroy', $schoolEvent) }}" method="POST">
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
