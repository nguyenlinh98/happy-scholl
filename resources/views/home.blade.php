<?php
$sidebar_menus = hsp_getConfig('sidebar_menus');
$schoolSetting = \App\Models\SchoolSetting::where('school_id', auth()->user()->school_id)->first();
?>

@extends('layouts.app')

@section('content')
<div class="container-fluid menu-home">
    <div class="row pl-5 pt-5">
        @php $setting_column = $sidebar_menus['letter']['column']; @endphp
        @if($schoolSetting->$setting_column == 1)
            @php $show_letter = true; @endphp
        @else
            @php $show_letter = false; @endphp
        @endif
        @if($show_letter === true)
        <a class="ml-2" href="{{ route('admin.letter.index') }}">
            <img src="{{ url('/css/asset/homepage/letter.png') }}" alt="">
        </a>
        @endif

        @php $setting_column = $sidebar_menus['message']['column']; @endphp
        @if($schoolSetting->$setting_column == 1)
            @php $show_message = true; @endphp
        @else
            @php $show_message = false; @endphp
        @endif
        @if($show_message === true)
        <a class="ml-2" href="{{ route('admin.message.index') }}">

            <img src="{{ url('/css/asset/homepage/message.png') }}" alt="">
        </a>
        @endif
    </div>
    <div class="row pl-5 pt-2">
        @php $setting_column = $sidebar_menus['seminar']['column']; @endphp
        @if($schoolSetting->$setting_column == 1)
            @php $show_seminar = true; @endphp
        @else
            @php $show_seminar = false; @endphp
        @endif
        @if($show_seminar === true)
        <a class="ml-2" href="{{ route('admin.seminar.index') }}">
            <img src="{{ url('/css/asset/homepage/course.png') }}" alt="">
        </a>
        @endif
        @php $setting_column = $sidebar_menus['event']['column']; @endphp
        @if($schoolSetting->$setting_column == 1)
            @php $show_event = true; @endphp
        @else
            @php $show_event = false; @endphp
        @endif
        @if($show_event === true)
        <a class="ml-2" href="{{ route('admin.school_event.index') }}">
            <img src="{{ url('/css/asset/homepage/event.png') }}" alt="">
        </a>
        @endif
    </div>
    <div class="row pl-5 pt-2">
        <a class="ml-2" href="{{ route('admin.class.index') }}">
            <img src="{{ url('/css/asset/homepage/class.png') }}" alt="">
        </a>
        <a class="ml-2" href="{{ route('admin.school_setting.index') }}">
            <img src="{{ url('/css/asset/homepage/setting.png') }}" alt="">
        </a>
    </div>
</div>
@endsection
