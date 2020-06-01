<div class="p-4">
    @input([
    "for" => "cgroup",
    "name" => "name",
    "value" => $classGroup->name,
    "type" => "text",
    ])
    <div class="form-group">
        <label for="class_group_toggle">@lang("cgroup.form.label.classes")</label>
        @class_department_group([
        "type" => 1,
        "prepend" => "class_group_selection_"
        ])
    </div>

</div>
