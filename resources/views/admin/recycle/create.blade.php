@extends('layouts.app')
@section('content')
@component('components.form')
    @slot('action', route('admin.recycle.confirm'))
    @slot("back", route('admin.recycle.admin'))
    @include('admin.recycle.form')
@endcomponent
@endsection
