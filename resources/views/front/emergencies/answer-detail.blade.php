@extends('front.layouts.urgent-contact')
@section('content')
<div class="question">
    <p>{{ $details['school_class'] }}</p>
    <input type="text" value="{{ $details['student'] }}">
    <hr>
    <textarea rows="4" style="width:100%">{{ $details['answer'] }}</textarea>
</div>
<a href="{{ url()->current() }}" class="btn-ene">戻る</a>
@endsection

