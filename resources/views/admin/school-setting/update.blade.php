@extends('layouts.app')
@section('content')
    @component('components.form')
        @slot('title', hsp_title())


        @method("PATCH")
        @slot('action', route('teacher.update', $teacher))
        <input type="hidden" name="user_id" value="{{$teacher->id}}">

        @input([
            'type' => 'text',
            'name' => 'last_name',
            'for' => 'teacher',
            'value' => $teacher->last_name,
        ])
        @input([
            'type' => 'text',
            'name' => 'first_name',
            'for' => 'teacher',
            'value' => $teacher->first_name,
        ])

        @input([
            'type' => 'email',
            'name' => 'email',
            'for' => 'teacher',
            'value' => $teacher->email,
        ])
    @endcomponent
@endsection

