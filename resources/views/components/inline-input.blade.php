<div class="form-group row">
    <label for="{{$name}}" class="col-sm-3 col-form-label">@lang($for . '.form.label.' . $name)</label>
    <div class="col-sm-9">
        @if($type === "textarea")
        <textarea class="form-control {{$errors->has($name) ? 'is-invalid' : ''}}" name="{{$name}}" id="{{$name}}" @isset($placeholder) placeholder="{{$placeholder}}" @endisset {{$extra ?? ''}}>{{$value ?? ''}}</textarea>
        @elseif($type === "select")
        <select name="{{$name}}" class="form-control {{$class ?? ''}} {{$errors->has($name) ? 'is-invalid' : ''}}" {{$extra ?? ''}}>
            @isset($options)
            @foreach ($options as $id => $option)
            <option value="{{$id}}" @if($id===$value) selected="selected" @endif>{{$option}}</option>
            @endforeach
            @endisset
        </select>
        @else
        <input class="form-control {{$errors->has($name) ? 'is-invalid' : ''}}" name="{{$name}}" type="{{$type}}" value="{{$value ?? ''}}" @isset($placeholder) placeholder="{{$placeholder}}" @endisset {{$extra ?? ''}}>
        @endif
        @includeWhen($errors->has($name), 'components.form-error', ["name" => $name])
    </div>

</div>
