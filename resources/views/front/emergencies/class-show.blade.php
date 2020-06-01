@extends('front.layouts.urgent-contact')
@section('content')
<div class="question">
    <p>{{ $className }}</p>
    <input type="text" disabled value="質問一覧">
    <ul>
    @foreach($questionnaire as $question)
    <li><a class="underline" href="{{ route('emergency.question.show', [
                'emergency_id' => $emergencyId,
                'class_id' => $classId,
                'question_id' => strtolower($question->question_id)]) }}"
        >・{{ $question->question_text }}</a></li>
    @endforeach
    </ul>
</div>
<a href="{{ route('emergency.show', $emergencyId) }}" class="btn-ene">{{ translate('戻る') }}</a>
@endsection
