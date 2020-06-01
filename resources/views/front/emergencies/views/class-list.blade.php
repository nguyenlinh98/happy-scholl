<div class="list-checkbox3">
    <h6>{{ translate('配信先') }}</h6>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="send_all" name="send_all" onchange="selectAll(this)">
        <label class="custom-control-label" for="send_all">{{ translate('全員に一斉送信') }}</label>
    </div>
    <div class="colw-1">
    @isset($schoolClasses)
        @foreach ($schoolClasses as $idx => $class)
            @if ($loop->odd)
                @component(
                    'front.emergencies.components.input',
                    [
                    'type' => 'class-list',
                    'label' => $class,
                    'class' => "school_class",
                    'nesting_name' => "school_classes",
                    'name' => $idx,
                    'oldInput' => "school_classes.$idx",
                    ]
                )
                @endcomponent
            @endif
        @endforeach
    @endisset
    </div>
    <div class="colw-1">
    @isset($schoolClasses)
        @foreach ($schoolClasses as $idx => $class)
            @if ($loop->even)
                @component(
                    'front.emergencies.components.input',
                    [
                    'type' => 'class-list',
                    'label' => $class,
                    'class' => "school_class",
                    'nesting_name' => "school_classes",
                    'name' => $idx,
                    'oldInput' => "school_classes.$idx",
                    ]
                )
                @endcomponent
            @endif
        @endforeach
    @endisset
    </div>
@if($errors->has('school_classes'))
<div style="display:inline-block;width:100%;" class="text-danger">{{ translate($errors->first('school_classes')) }}</div>
@endif
</div>
