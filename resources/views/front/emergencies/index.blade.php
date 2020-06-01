@extends('front.layouts.urgent-contact')
@section('content')
    <div class="head">{{ translate('緊急連絡を選んでください') }}</div>
    <div class="question">
        <ul>
            @foreach($urgentContacts as $urgent)
                <li><a class="underline" href="{{ route('emergency.show', $urgent->id) }}">・{{ $urgent->subject }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    <a href="{{ route('emergency.top') }}" class="btn-ene">戻る</a>
    <style>
        .question ul{
            color: #828387;
           word-break: break-word;
        }

    </style>
@endsection
