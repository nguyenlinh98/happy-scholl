<div class="form-check">
    <input class="form-check-input checkbox--lg mt-2 {{$class ?? ''}}" type="checkbox" name="{{$name}}" id="{{isset($id) ? $id : $name}}" value="{{$value ?? ''}}" {{isset($clean) ? '' : hsp_checkbox_state($name, $value) }} {{$extra ?? ''}}>
    <label class="form-check-label" for="{{isset($id) ? $id : $name}}">&nbsp;{{$label}}</label>
</div>
