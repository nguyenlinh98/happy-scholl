<div class="form-group {{ strpos(Route::current()->getName(), "top_admin.school")!== false || strpos(Route::current()->getName(), "top_admin.setting")!== false ? 'topadmin-school' : "" }} {{ $groupClass ?? '' }}">
    @if($type != "hidden" && $name!=="")
        <label for="{{ $name }}">@lang($for . '.form.label.' . $name)</label>
    @endif
    @if($type === "textarea")
        <textarea class="form-control {{ $class ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}" name="{{ $name }}" id="{{ $name }}" @isset($placeholder) placeholder="{{ $placeholder }}" @endisset {{ $extra ?? '' }}>{{ $value ?? '' }}</textarea>
    @elseif($type === "select")
        <select name="{{ $name }}" class="form-control {{ $class ?? '' }} {{ $errors->has($name) ? 'is-invalid' : '' }}" {{ $extra ?? '' }}>
            @isset($options)
                @foreach($options as $id => $option)
                    <option value="{{ $id }}" @if($id==$value) selected="selected" @endif>{{ $option }}</option>
                @endforeach
            @endisset
        </select>
    @else
        <input class="form-control {{ $class ?? '' }} {{ strpos(Route::current()->getName(), "top_admin.school")!== false || strpos(Route::current()->getName(), "top_admin.setting")!== false ? 'topadmin-'.$name : "" }} {{ $errors->has($name) ? 'is-invalid' : '' }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value ?? '' }}" @isset($placeholder) placeholder="{{ $placeholder }}" @endisset {{ $extra ?? '' }}>
    @endif
    @includeWhen($errors->has($name), 'components.form-error', ["name" => $name])
</div>
