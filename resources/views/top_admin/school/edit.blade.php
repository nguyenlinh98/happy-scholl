<?php
$prefectures_list = hsp_getConfig('prefectures');
?>

@extends('layouts.topadmin')
@section('content')
    @component('components.topadmin-form')
        @slot('title', hsp_title())
        @slot('action', route('top_admin.school.edit_confirm', $school))
        @input([
            'type' => 'text',
            'name' => 'name',
            'for' => 'school',
            'value' => old('name', $school->name),
        ])
        @input([
            'type' => 'text',
            'name' => 'namekana',
            'for' => 'school',
            'value' => old('namekana', $school->namekana),
        ])
        @input([
            'type' => 'text',
            'name' => 'postcode',
            'for' => 'school',
            'value' => old('postcode', $school->postcode),
        ])
        <div class="form-group topadmin-school">
            <label for="">都道府県</label><br>
            <select name="prefectures" id="prefectures" class="{{$errors->has('prefectures') ? 'is-invalid' : ''}}">
                @foreach($prefectures_list as $prefecture)
                    <option value="{{$prefecture}}" @if(old('prefectures', $school->prefectures) == $prefecture) selected @endif> {{$prefecture}}</option>
                @endforeach
            </select>
            @includeWhen($errors->has('prefectures'), 'components.form-error', ["name" => 'prefectures'])
        </div>

        {{-- @input([
            "for" => "school",
            "value" => old('prefectures'),
            "name" => "prefectures",
            "type" => "select",
            "options" => $prefectures,
            "extra" => "data-controller=select2"
        ]) --}}
        @input([
            'type' => 'text',
            'name' => 'address',
            'for' => 'school',
            'value' => old('address', $school->address),
        ])
        @input([
            'type' => 'text',
            'name' => 'representative_emails',
            'for' => 'school',
            'value' => old('representative_emails', $school->representative_emails),
        ])
        @input([
            'type' => 'text',
            'name' => 'tel',
            'for' => 'school',
            'value' => old('tel', $school->tel),
        ])
        @input([
            'type' => 'text',
            'name' => 'domain',
            'for' => 'school',
            'value' => old('domain', $school->domain),
            'extra' => 'disabled'
        ])
        @input([
            'type' => 'text',
            'name' => 'issueDate',
            'for' => 'school',
            'value' => old('issue_date', $school->issue_date),
            'extra' => 'disabled'
        ])
        @input([
            'type' => 'text',
            'name' => 'schoolCode',
            'for' => 'school',
            'value' => $schoolPasscode->passcode,
            'extra' => 'disabled',
        ])
        @input([
            'type' => 'text',
            'name' => 'schoolCodePass',
            'for' => 'school',
            'value' => isset($password) ? $password : '******',
            'extra' => 'disabled',
        ])

        @slot("footer")
        <div class="topadmin-school ">
            <button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/confirm.png')}}" alt=""></button>
        </div>
        @endslot

    @endcomponent

@endsection


