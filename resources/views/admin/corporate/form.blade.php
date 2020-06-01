@extends('layouts.app')
@section('content')
    @component('components.form')
        @slot('title', '業者の追加')

        @if($corporate->exists)
            @method("PATCH")
            @slot('action', route('corporate.update', $corporate))
        @else
            @slot('action', route('corporate.store'))
        @endif
        @input([
            "for" => "corporate",
            "type" => "text",
            "name" => "name",
            "value" => $corporate->name
        ])

        @input([
            "for" => "corporate",
            "type" => "text",
            "name" => "tel",
            "value" => $corporate->tel
        ])

        @input([
            "for" => "corporate",
            "type" => "text",
            "name" => "fax",
            "value" => $corporate->fax
        ])
        @input([
            "for" => "corporate",
            "type" => "textarea",
            "name" => "memo",
            "value" => $corporate->memo
        ])
    @endcomponent
@endsection

