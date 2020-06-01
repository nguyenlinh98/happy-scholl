{{-- YES/NO TYPE --}}
{{-- Default Questions --}}
<div class="list-checkbox1">
    <h6>{{ translate('質問事項 ') }}<span>{{ translate('※「YES」または「NO」による回答') }}</span></h6>
    @isset($yesNoQuestions)
        @foreach ($yesNoQuestions as $question)
            @component(
                'front.emergencies.components.input',
                [
                'type' => 'default',
                'label' => $question,
                'class' => null,
                'nesting_name' => "yn_questions",
                'name' => "YN{$loop->iteration}",
                'oldInput' => "yn_questions.YN{$loop->iteration}",
                ]
            )
            @endcomponent
        @endforeach
    @endisset
</div>
{{-- User-definded Questions --}}
<div class="list-checkbox2">
    <h6><span>{{ translate('ご質問内容を入力してください。') }}</span></h6>
        @for ($id = 7; $id <= 10; ++$id)
            @component(
                'front.emergencies.components.input',
                [
                'type' => 'user-defined',
                'label' => null,
                'class' => null,
                'nesting_name' => "yn_questions",
                'name' => "YN{$id}",
                'oldInput' => "yn_questions.YN{$id}",
                ]
            )
            @endcomponent
        @endfor
</div>
@if($errors->has('yn_questions'))
<div style="display:inline-block;width:100%;" class="text-danger">{{ translate($errors->first('yn_questions')) }}</div>
@endif
