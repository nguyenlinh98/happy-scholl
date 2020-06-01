@extends('layouts.app')
@section('content')
    @component('components.form')
        @slot('title', hsp_title())
        @if($school->exists)
            @slot('action', route('school.update', $school))
            @method('PATCH')
        @else
            @slot('action', route('school.store'))
        @endif
        @input([
            'type' => 'text',
            'name' => 'name',
            'for' => 'school',
            'value' => $school->name,
        ])
    @endcomponent
@endsection

