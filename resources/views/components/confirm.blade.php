<div class="form-group">
    <label>@lang("{$for}.form.label.{$name}")</label>

    <h4 class="font-weight-bold p-2">
        @isset($value)
            {{$value}}
        @else
            　
        @endisset
    </h4>
    <input type="hidden" value="{{$value}}" name="{{$name}}">
    @isset($hiddens)
    @foreach($hiddens as $key => $hidden)
    <input type="hidden" value="{{$hidden}}" name="{{$key}}">
    @endforeach
    @endisset
</div>
