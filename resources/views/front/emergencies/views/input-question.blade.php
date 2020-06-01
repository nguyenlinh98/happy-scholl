{{-- INPUT TYPE --}}
{{-- Default Questions --}}
<div class="list-checkbox1">
    <h6>{{ translate('質問事項 ') }}<span>{{ translate('※自由回答') }}</span></h6>
    @isset($inputQuestions)
        @foreach ($inputQuestions as $question)
            @component(
                'front.emergencies.components.input',
                [
                'type' => 'default',
                'label' => $question,
                'class' => null,
                'nesting_name' => "in_questions",
                'name' => "IN{$loop->iteration}",
                'oldInput' => "in_questions.IN{$loop->iteration}",
                ]
            )
            @endcomponent
        @endforeach
    @endisset
</div>
{{-- User-definded Questions --}}
<div class="list-checkbox2">
    <h6><span>{{ translate('ご質問内容を入力してください。') }}</span></h6>
        @for ($id = 4; $id <= 7; ++$id)
            @component(
                'front.emergencies.components.input',
                [
                'type' => 'user-defined',
                'label' => null,
                'class' => null,
                'nesting_name' => "in_questions",
                'name' => "IN{$id}",
                'oldInput' => "in_questions.IN{$id}",
                ]
            )
            @endcomponent
        @endfor
</div>
@if($errors->has('in_questions'))
<div style="display:inline-block;width:100%;" class="text-danger">{{ translate($errors->first('in_questions')) }}</div>
@endif
