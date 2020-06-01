@extends('front.layouts.urgent-contact')
@section('content')
<form action="{{ route('emergency.store') }}" method="POST">
    @csrf
    <div class="fat-text">
        <p>{{ translate('件名') }}</p>
        <p>{{ $urgentContact->subject }}</p>
        <br/>
        <p>{{ translate('質問事項') }}</p>
        @foreach($urgentContact->questionnaire as $key => $question)
            <p>{{ $question }}</p>
        @endforeach
        <br/>
        <p>{{ translate('配信先') }}</p>
        @if (true === $urgentContact->sendAll)
            <p class="custom">{{ translate('全員に一斉送信') }}</p>
        @endif
        <p>{{ translate('クラス') }}</p>
        @foreach($urgentContact->schoolClasses as $key => $schoolClass)
            <p class="custom">{{ $schoolClass }}</p>
        @endforeach
        <p>{{ translate('配信者') }}</p>
        <p class="custom">{{ $urgentContact->sender }}</p>
    </div>
    <div class="fat-btn">
        <p class="center-elm">{{ translate('送信しました') }}</p>
        <a href="{{ route('emergency.top') }}" class="btn-white center-elm">{{ translate('戻る') }}</a>
    </div>
</form>
@endsection
