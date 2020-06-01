<h6>{{ translate('配信者') }}</h6>
<input style="text-align:left;"
    type="text"
    class="full-width"
    id="sender" name="sender"
    @if (! blank(old('sender'))) value="{{ old('sender') }}" @endif />
@if($errors->has('sender'))
<div class="text-danger">{{ translate($errors->first('sender')) }}</div>
@endif
