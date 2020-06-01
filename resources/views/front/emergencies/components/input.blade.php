<div class="custom-control custom-checkbox">
    {{-- Class List --}}
    @if ('class-list' === $type)
    <input type="checkbox"
        class="custom-control-input {{ $class ?? ''}}{{ $errors->has($oldInput) ? ' is-invalid' : '' }}"
        id="{{ "{$nesting_name}_$name"  }}" name="{{ "{$nesting_name}[$name]" }}"
            @if(! blank(old($oldInput)))
                checked
            @endif
    />
    <label class="custom-control-label" for="{{ "{$nesting_name}_$name"  }}">{{ $label ?? '' }}</label>

    {{-- YES|NO and INPUT Questions --}}
    @else
    <input type="checkbox"
    class="custom-control-input {{ $class ?? ''}}{{ $errors->has($oldInput) ? ' is-invalid' : '' }}"
    id="{{ $name }}" name="{{ "{$nesting_name}[{$name}]" }}"
        @if(! blank(old($oldInput)))
            checked
        @endif
    />
    <label class="custom-control-label" for="{{ $name }}">{{ $label ?? '' }}</label>
    @endif
        {{-- custom questions --}}
        @if ('user-defined' === $type)
            <input type="text"
                id="{{ "{$name}_text" }}"
                name="{{ "{$nesting_name}[{$name}_text]" }}"
                @isset($placeholder) placeholder="{{$placeholder}}" @endisset
                @if (! blank(old("{$nesting_name}.{$name}_text"))) value="{{ old("{$nesting_name}.{$name}_text") }}" @endif
                onchange="autoCheckbox(this)"
            />
            @includeWhen($errors->has($nesting_name), 'components.form-error', ["name" => $nesting_name])
        {{-- default questions --}}
        @elseif ('default' === $type)
            <input type="text"
                id="{{ "{$name}_text" }}"
                name="{{ "{$nesting_name}[{$name}_text]" }}"
                value="{{ $label }}" style="display:none;"
            />
        @else
        @endif
</div>
