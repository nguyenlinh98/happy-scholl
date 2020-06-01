@extends('layouts.app')
@section('content')
@component('components.form')
    @slot('title')
        {{ __('meeting.title.index') }}
    @endslot

    @slot('action')
        {{ route('admin.meeting.confirm', $meeting) }}
    @endslot
    @slot('header')
        <h2 class="page-title">{{ hsp_title() }}</h1>
    @endslot
    @include("admin.meeting.form")
@endcomponent
@endsection
