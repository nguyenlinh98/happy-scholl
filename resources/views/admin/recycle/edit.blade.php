@extends('layouts.app')
@section('content')

@component('components.form')
@slot('title', __('message.title.index'))
@slot('action', route('admin.recycle.confirm', $recycleProduct))
@slot("back", route("admin.recycle.admin"))
@include('admin.recycle.form')
@endcomponent
@endsection
