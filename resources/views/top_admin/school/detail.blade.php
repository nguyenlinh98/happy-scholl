<?php
$prefectures = hsp_getConfig('prefectures');
?>

@extends('layouts.topadmin')
@section('content')
    @if(hsp_title() !=="")
        <h2 class="page-title">{{hsp_title()}}</h2>
    @endif
       <div class="div" style="float:right;">
           @include('components.topadmin-modal', [
                   "iteration" => "$school->id",
                   "editRoute" => route('top_admin.school.edit', $school->id),
                   "deleteRoute" => route('top_admin.school.destroy', $school->id),
                   "modelId" => $school->id,
               ])
       </div>
        @slot('title', hsp_title())
        @if($school->exists)
            @slot('action', route('top_admin.school.update', $school))
            @method('PATCH')
        @else
            @slot('action', route('top_admin.school.confirm'))
        @endif
    <form method="get" action="{{route('top_admin.school.index')}}">
        @csrf
       <div class="form--body bg-form px-3 pt-1 pb-4">
        @input([
        'type' => 'text',
        'name' => 'name',
        'for' => 'school',
        'value' => $school->name,
        'extra' => 'disabled="disabled"',
        ])

        @input([
            'type' => 'text',
            'name' => 'namekana',
            'for' => 'school',
            'value' => $school->namekana,
            'extra' => 'disabled="disabled"',
        ])

        @input([
            'type' => 'text',
            'name' => 'postcode',
            'for' => 'school',
            'value' => $school->postcode,
            'extra' => 'disabled="disabled"',
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
            'type' => 'text',
            'name' => 'address',
            'for' => 'school',
            'value' => $school->address,
            'extra' => 'disabled="disabled"',
        ])

        @input([
            'type' => 'text',
            'name' => 'representative_emails',
            'for' => 'school',
            'value' => $school->representative_emails,
            'extra' => 'disabled="disabled"',
        ])

        @input([
            'type' => 'text',
            'name' => 'tel',
            'for' => 'school',
            'value' => $school->tel,
            'extra' => 'disabled="disabled"',
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
    </form>
            <form method="post" action="{{route('top_admin.school.school_code', $school->id)}}">
                @csrf
                @input([
                'type' => 'text',
                'name' => 'schoolCode',
                'for' => 'school',
                'value' => $schoolPasscode->passcode,
                'extra' => 'disabled'
                ])
                <div class="form-group topadmin-school ">
                    <label for="school">□ 学校パスワード</label>
                    <input class="form-control topadmin-schoolCode" disabled="disabled" type="text" name="schoolCodePass" value="{{isset($password) ? $password : '******'}}">
                </div>

                <div class="form-group  bg-form px-3 pt-1 pb-4">

                    <button type="submit" class="btn" style="background-color: red; color: white; margin-left: 50px;">パスワードを再発行する</button>
                </div>
            </form>
    <form id="deleteformtopadmin{{$school->id}}" enctype="multipart/form-data" method="POST" action="{{route('top_admin.school.destroy', $school->id)}}">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="id" value="{{$school->id}}">
    </form>
@endsection

