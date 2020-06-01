@extends('layouts.app')
@section('content')
@component('components.form')
@slot('title', hsp_title())
@slot('action', route('admin.teacher.confirm'))
@slot("back", route("admin.teacher.index"))
@include('admin.teacher.form')
@endcomponent
@endsection
