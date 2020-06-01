@extends('front.layouts.urgent-contact')
@section('content')
<form action="{{ route('emergency.store') }}" method="POST">
    @csrf
    <div class="fat-text">
        <p>{{ translate('件名') }}</p>
        <p>{{ $urgentContact->subject }}</p>
        <input type="text" id="subject" name="subject" value="{{ $urgentContact->subject }}" style="display:none;"/>
        <br/>
        <p>{{ translate('質問事項') }}</p>
        @foreach($urgentContact->yesNoQuestions as $key => $question)
            <p>{{ $question }}</p>
            <input type="checkbox" id ="{{ $key }}" name="{{ "yn_questions[{$key}]" }}" style="display:none;" checked/>
            <input type="text" id ="{{ "{$key}_text" }}" name="{{ "yn_questions[{$key}_text]" }}" style="display:none;" value="{{ $question }}"/>
        @endforeach
        @foreach($urgentContact->inputQuestions as $key => $question)
            <p>{{ $question }}</p>
            <input type="checkbox" id ="{{ $key }}" name="{{ "in_questions[{$key}]" }}" style="display:none;" checked/>
            <input type="text" id ="{{ "{$key}_text" }}" name="{{ "in_questions[{$key}_text]" }}" style="display:none;" value="{{ $question }}"/>
        @endforeach
        <br/>
        <p>{{ translate('配信先') }}</p>
        @if (true === $urgentContact->sendAll)
            <p class="custom">{{ translate('全員に一斉送信') }}</p>
        @endif
        <p>{{ translate('クラス') }}</p>
        @foreach ($urgentContact->schoolClasses as $key => $schoolClass)
            <p class="custom">{{ $schoolClass }}</p>
            <input type="checkbox" id ="{{ $key }}" name="school_classes[{{ $key }}]" style="display:none;" checked/>
        @endforeach
        <p>{{ translate('配信者') }}</p>
        <p class="custom">{{ $urgentContact->sender }}</p>
        <input type="text" id="sender" name="sender" value="{{ $urgentContact->sender }}" style="display:none;"/>
    </div>
    <div class="fat-btn">
        <p>{{ translate('この内容で、送信してよろしいですか？') }}</p>
        <a href="#" class="btn-exit" onclick="$(this).closest('form').submit();return false">{{ translate('送信') }}</a>
        <a href="#" class="btn-white" onclick="backToHistory(this)">{{ translate('戻る') }}</a>
        <small>{{ translate('※予約設定は変更可能ですが、一度送信したお手紙は変更できません。') }}</small>
    </div>
</form>
@push('script')
<script>
    function backToHistory(target) {
        $(target).closest('form').append('<input type="text" name="reject" value="return" alt="Cancel" style="display:none;"/>').submit();
        return false;
    }
</script>
@endpush
@endsection
