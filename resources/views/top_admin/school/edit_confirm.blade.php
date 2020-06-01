<?php
$prefectures = hsp_getConfig('prefectures');
?>

@extends('layouts.topadmin')
@section('content')

    @component('components.topadmin-form')
        @slot('title', hsp_title())
        @slot('action', route('top_admin.school.update', $school))

        @input([
            'type' => 'text',
            'name' => 'name',
            'for' => 'school',
            'value' => $school->name,
            'extra' => 'disabled="disabled"',
        ])
        @input([
            'type' => 'hidden',
            'name' => 'name',
            'for' => 'school',
            'value' => $school->name,
        ])

        @input([
            'type' => 'text',
            'name' => 'namekana',
            'for' => 'school',
            'value' => $school->namekana,
            'extra' => 'disabled="disabled"',
        ])
        @input([
            'type' => 'hidden',
            'name' => 'namekana',
            'for' => 'school',
            'value' => $school->namekana,
        ])

        @input([
            'type' => 'text',
            'name' => 'postcode',
            'for' => 'school',
            'value' => $school->postcode,
            'extra' => 'disabled="disabled"',
        ])
        @input([
            'type' => 'hidden',
            'name' => 'postcode',
            'for' => 'school',
            'value' => $school->postcode,
        ])

        @input([
            "for" => "school",
            "value" => $school->prefectures,
            "name" => "prefectures",
            "type" => "select",
            "options" => $prefectures,
            "extra" => "data-controller=select2 disabled='disabled'",
        ])
        @input([
            'type' => 'hidden',
            'name' => 'prefectures',
            'for' => 'school',
            'value' => $school->prefectures,
        ])

        @input([
            'type' => 'text',
            'name' => 'address',
            'for' => 'school',
            'value' => $school->address,
            'extra' => 'disabled="disabled"',
        ])
        @input([
            'type' => 'hidden',
            'name' => 'address',
            'for' => 'school',
            'value' => $school->address,
        ])

        @input([
            'type' => 'text',
            'name' => 'representative_emails',
            'for' => 'school',
            'value' => $school->representative_emails,
            'extra' => 'disabled="disabled"',
        ])
        @input([
            'type' => 'hidden',
            'name' => 'representative_emails',
            'for' => 'school',
            'value' => $school->representative_emails,
        ])

        @input([
            'type' => 'text',
            'name' => 'tel',
            'for' => 'school',
            'value' => $school->tel,
            'extra' => 'disabled="disabled"',
        ])
        @input([
            'type' => 'hidden',
            'name' => 'tel',
            'for' => 'school',
            'value' => $school->tel,
        ])

        @input([
            'type' => 'text',
            'name' => 'domain',
            'for' => 'school',
            'value' => $school->domain,
            'extra' => 'disabled="disabled"'
        ])

        @input([
            'type' => 'text',
            'name' => 'issue_date',
            'for' => 'school',
            'value' => $school->issue_date,
            'extra' => 'disabled="disabled"',
        ])
    @endcomponent
@endsection

