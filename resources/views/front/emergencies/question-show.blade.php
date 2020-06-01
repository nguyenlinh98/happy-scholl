@extends('front.layouts.urgent-contact')
@section('content')
<div class="question">
    <p>{{ $className }}</p>
    <input type="text" disabled value="質問">
    <ul class="detail">
        <li>
            <a href="#" onclick="event.preventDefault()">・{{ $answers->first()->question_text }}</a>
        </li>
    </ul>
    <a href="{{ url()->current() }}" class="btn-choose">{{ translate('最新の情報に更新する') }}</a>
    <p class="margin-top-30">{{ translate('並べ替え') }}</p>
    <div class="list-btn">
    @if (1 === $answers->first()->question_type)
        <a href="#" class="btn-yes" onclick="showOnlyAnswerMeeting(this)">{{ translate('YES') }}</a>
        <a href="#" class="btn-no" onclick="showOnlyAnswerMeeting(this)">{{ translate('NO') }}</a>
        <a href="#" class="btn-choose" onclick="showOnlyAnswerMeeting(this)">{{ translate('未回答') }}</a>
    @elseif ( 2 === $answers->first()->question_type)
        <a href="#" class="btn-yes" onclick="showOnlyAnswerMeeting(this)">{{ translate('あり') }}</a>
        <a href="#" class="btn-no" onclick="showOnlyAnswerMeeting(this)">{{ translate('なし') }}</a>
    @endif
    </div>
    <small>{{ translate('※ボタンを選択すると上位に表示されます。') }}</small>
    <div class="head-table">
        <div class="grid-item">
            {{ $className }}（{{ mb_convert_kana($noStudent, 'N') }}人）<br/>
            回答者（{{ mb_convert_kana($noStudent - $notYetAnswerCount, 'N') }}人）  未回答者（{{ mb_convert_kana($notYetAnswerCount, 'N')  }}人）
        </div>
        <div class="grid-btn-item">
            <a href="{{ route('emergency.class.show', ['emergency_id' => $emergencyId, 'class_id' => $classId]) }}" class="btn-ene">{{ translate('戻る') }}</a>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ translate('回答者') }}</th>
                <th>{{ translate('回答日時') }}</th>
                <th>{{ translate('回答') }}</th>
            </tr>
        </thead>
    @foreach($answers as $answer)
        <tr class="@php
            if (1 === $answer->question_type) {
                if (0 === $answer->status) {
                    echo 'answer_notyet';
                } elseif (1 === $answer->yesno_answer) {
                    echo 'answer_yes';
                } else {
                    echo 'answer_no';
                }
            } elseif (2 === $answer->question_type) {
                if (0 === $answer->status) {
                    echo 'answer_nashi';
                } else {
                    echo 'answer_ari';
                }
            } @endphp">
            <td>{{ $answer->student->name }}</td>
            @if (1 === $answer->question_type)
                @if (0 === $answer->status)
                    <td></td>
                    <td><a href="#" onclick="event.preventDefault()" class="btn-notyet">{{ translate('未回答') }}</a></td>
                @else
                    <td>{{ $answer->updated_at->isoFormat('YYYY\年M\月Do\（dd\）\　HH:mm') }}</td>
                    <td><a href="#" onclick="event.preventDefault()" class="btn-{{ 1 === $answer->yesno_answer ? 'yes' : 'no' }}">{{ 1 === $answer->yesno_answer ? translate('YES') : translate('NO') }}</a></td>
                @endif
            @elseif (2 === $answer->question_type)
                @if (0 === $answer->status)
                    <td></td>
                    <td><a href="#" onclick="event.preventDefault()" class="btn-no">{{ translate('なし') }}</a></td>
                @else
                <td>{{ $answer->updated_at->isoFormat('YYYY\年M\月Do\（dd\）\　HH:mm') }}</td>
                <td><a
                    href="{{ url()->current().'?'.\Arr::query(['detail' => true, 'school_class' => $className, 'student' =>$answer->student->name, 'answer' => $answer->answer_text]) }}"
                    class="btn-yes"
                    >{{ translate('あり') }}</a>
                </td>
                @endif
            @endif
        </tr>
    @endforeach
    </table>
</div>
@endsection
@push('script')
<script>
    function showOnlyAnswerMeeting(target) {
        event.preventDefault();
        switch($(target).text()) {
        case 'YES':
            $('.answer_yes').fadeIn(0);
            $('.answer_notyet, .answer_no').fadeOut(0);
            break;
        case 'NO':
            $('.answer_no').fadeIn(0);
            $('.answer_notyet, .answer_yes').fadeOut(0);
            break;
        case '未回答':
            $('.answer_notyet').fadeIn(0);
            $('.answer_no, .answer_yes').fadeOut(0);
            break;
        case 'あり':
            $('.answer_ari').fadeIn(0);
            $('.answer_nashi').fadeOut(0);
            break;
        case 'なし':
            $('.answer_nashi').fadeIn(0);
            $('.answer_ari').fadeOut(0);
            break;
        }
    }
</script>
@endpush
