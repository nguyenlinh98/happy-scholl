<div class="col-sm-12 col-md-12 mt-2" data-target="class-group-department.selectAll" for="{{ $prependIdentifier."select" }}--{{ $template }}" style="display: {{ hsp_class_group_department_block_display($prependIdentifier."select", $type, $template, $multipleSelect) }};">
    @include("components.class_department_group.options", ["name" => $template])
</div>

<div class="col-sm-12 col-md-12 mt-2" data-target="class-group-department.selectAll" for="{{ $prependIdentifier."select" }}--{{ $template }}" style="display: {{ hsp_class_group_department_block_display($prependIdentifier."select", $type, $template, $multipleSelect) }};">
    @if(filled(hsp_school()->{$template}))
        <div class="form-group">
            @checkbox([
                "name" => $prependIdentifier . "send_to_all_".$template,
                "value" => "",
                "label" => "全て",
                "extra" => 'data-controller=checkbox-all data-action=change->checkbox-all#trigger data-checkbox-all-identifier=.' . $prependIdentifier . 'checkbox--all--item--' .$template
                ])
        </div>
    @endif

</div>
