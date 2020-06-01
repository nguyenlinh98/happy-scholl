@extends('layouts.app')
@section('content')
{{-- @include('layouts.elements.title') --}}
@component('components.form')
    @slot('title')
    @endslot
    @slot('action')
        {{ route('admin.seminar.confirm') }}
    @endslot

    @slot("back")
        {{ route('admin.seminar.index') }}
    @endslot

    @include('admin.seminar.form')
@endcomponent
@endsection
