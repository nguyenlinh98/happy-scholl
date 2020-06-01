<?php
$prefectures_list = hsp_getConfig('prefectures');
?>

@extends('layouts.topadmin')
@section('content')
    @component('components.topadmin-form')
        @slot('title', hsp_title())
        @slot('action', route('top_admin.school.create_confirm'))
        @input([
            'type' => 'text',
            'name' => 'name',
            'for' => 'school',
            'value' => old('name'),
        ])
        @input([
            'type' => 'text',
            'name' => 'namekana',
            'for' => 'school',
            'value' => old('namekana'),
        ])
        @input([
            'type' => 'text',
            'name' => 'postcode',
            'for' => 'school',
            'value' => old('postcode'),
        ])

        <div class="form-group topadmin-school">
            <label for="">都道府県</label><br>
            <select name="prefectures" id="prefectures" class="{{$errors->has('prefectures') ? 'is-invalid' : ''}}">
                @foreach($prefectures_list as $prefecture)
                    <option value="{{$prefecture}}" @if(old('prefectures') == $prefecture) selected @endif> {{$prefecture}}</option>
                @endforeach
            </select>
            @includeWhen($errors->has('prefectures'), 'components.form-error', ["name" => 'prefectures'])
        </div>
        @input([
            'type' => 'text',
            'name' => 'address',
            'for' => 'school',
            'value' => old('address'),
        ])
        @input([
            'type' => 'text',
            'name' => 'representative_emails',
            'for' => 'school',
            'value' => old('representative_emails'),
        ])
        @input([
            'type' => 'text',
            'name' => 'tel',
            'for' => 'school',
            'value' => old('tel'),
        ])
        @slot('footer')
            <div class="topadmin-school ">
                <button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/confirm.png')}}" alt=""></button>
{{--                <a href="{{ $back ?? url()->previous() }}"> <img src="{{url('/css/asset/button/cancle.png')}}" alt="" data-dismiss="modal"> </a>--}}
            </div>
        @endslot
    @endcomponent
@endsection

