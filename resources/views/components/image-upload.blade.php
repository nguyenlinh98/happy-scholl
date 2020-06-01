    <div class="form-group">
        <label for="{{ $name }}">{{ $label ?? '写真を選んでください' }}</label>
        <input type="file" name="{{ $name }}{{ !isset($is_single) ? '[]' : '' }}" id="{{ $name }}" class="form-control visually-hidden" {{ !isset($is_single) ? 'multiple' : '' }} data-controller="image-preview" data-preview-selector=".image-preview-item--{{ $name }}" data-action="change->image-preview#updatePreview">
        <label for="{{ $name }}" class="form-row">
            <div class="col-2 text-center py-2">
                <img src={{ asset('css/asset/image-placeholder.png') }} class="pt-2">
                <h6 class="pt-3">アルバムから</h6>
            </div>
            @foreach($images as $image)
                <div class="col-2">
                    <div class="image-preview-item--{{ $name }} bg-secondary w-100 h-100 background-size-cover background-no-repeat background-center" @if($image) style="background-image: url({{ $image }});" @endif></div>
                </div>
            @endforeach
        </label>
        <h5 class="text-muted pt-2">※写真は {{ count($images) }} 枚まで掲載できます。</h5>
    </div>
