@extends('layouts.app')
@section('content')
    @component('components.form')
        @slot('title', hsp_title())
        @if($class->exists)
            @slot('action', route('admin.class.update', $class))
            @method('PATCH')
        @else
            @slot('action', route('admin.class.store'))
        @endif
        @input([
            'type' => 'text',
            'name' => 'name',
            'for' => 'class',
            'value' => $class->name,
            ])
    @endcomponent
@endsection
