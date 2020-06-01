@php
    $prependIdentifier = isset($prepend) ? $prepend : "";
    $multipleSelect = isset($multipleSelect) ? $multipleSelect : false;
@endphp
<div class="form-row" data-controller="class-group-department">
    @if(!$multipleSelect)
        @include('components.class_department_group.select')
    @endif

    @foreach(["1", "2", "3"] as $template)
        @if(strpos((string) $type, $template) !== false)
            @if($multipleSelect)
                @include('components.class_department_group.title')
            @endif
            @include("components.class_department_group.block", ["template" => hsp_block_index($template)])
        @endif
    @endforeach
</div>
