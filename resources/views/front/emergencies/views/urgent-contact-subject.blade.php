<h6>{{ translate('件名') }}</h6>
<input style="text-align:left;"
    type="text"
    class="full-width"
    id="subject" name="subject"
    placeholder="{{ translate('緊急連絡です。質問内容にご回答ください。') }}"
    @if (! blank(old('subject'))) value="{{ old('subject') }}" @endif />
@if($errors->has('subject'))
<div class="text-danger">{{ translate($errors->first('subject')) }}</div>
@endif
<p>
{{ translate('※件名は「緊急連絡です。質問内容にご回答ください。') }}<br/>
{{ translate('が設定されていますが、別の件名に打ち替え可能です。') }}
</p>
