<div class="p-4">
    @input([
        'type' => 'text',
        'name' => 'name',
        'for' => 'teacher',
        'value' => $teacher->name,
    ])
    @class_department_group([
        "type" => 12,
        "prepend" => "responsibility_",
        "multipleSelect" => true,
    ])

    <div class="form-group">
        <h4 class="bg-white py-2 px-3"> 担任の有無（クラスの担任の先生はチェックを入れてください）</h4>
        @checkbox([
            "name" => "homeroom",
            "id" => "homeroom_id",
            "value" => "yes",
            "default" => $teacher->homeroom ? "yes" : null,
            "label" => "担任"
        ])
    </div>
</div>
