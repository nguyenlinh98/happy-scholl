<div class="p-4">
    @input([
        "for" => "recycle",
        "name" => "name",
        "type" => "text",
        "value" => $recycleProduct->name,
    ])
    @include("components.image-upload", [
        "name" => "images",
        "images" => array_values($recycleProduct->getImageAssetsArray(false)),
    ])
    <div class="form-row">
        <div class="col-6">
            @input([
                "for" => "recycle",
                "name" => "product_status",
                "type" => "select",
                "options" => hsp_code_masters_group("1001"),
                "value" => $recycleProduct->product_status,
            ])
        </div>
    </div>
    @input([
        "for" => "recycle",
        "name" => "detail",
        "type" => "textarea",
        "value" => $recycleProduct->detail,
        "extra" => "data-controller=textarea data-action=input->textarea#input",
    ])
</div>
