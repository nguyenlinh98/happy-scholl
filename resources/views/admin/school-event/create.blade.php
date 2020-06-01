@extends('layouts.app')
@section('content')
{{-- @include('layouts.elements.title') --}}
@component('components.form')
    @slot('title')
    @endslot
    @slot('action')
        {{ route('admin.school_event.confirm') }}
    @endslot

    @slot("back")
        {{ route('admin.school_event.index') }}
    @endslot

    @include('admin.school-event.form')
@endcomponent
@endsection
