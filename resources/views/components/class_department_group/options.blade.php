<div class="form-group mb-0">
    <div class="form-row {{ $errors->has($prependIdentifier . $name) ? 'is-invalid' : '' }}">
        @if(blank(hsp_school()->{$name}))
            <div class="col-sm-6 col-md-3">
                所属先がありません。
            </div>
        @else
            @foreach(hsp_school()->{$name} as $item)
                <div class="col-sm-6 col-md-3">
                    @checkbox([
                        "name" => $prependIdentifier . $name . "[]",
                        "id" => "checkbox_type_{$name}_id_{$item->id}",
                        "value" => $item->id,
                        "label" => $item->name,
                        "class" => "{$prependIdentifier}checkbox--all--item--{$name}",
                        ])
                </div>
            @endforeach
        @endif
    </div>
    @includeWhen($errors->has($prependIdentifier . $name), 'components.form-error', ["name" => $prependIdentifier . $name])
</div>
