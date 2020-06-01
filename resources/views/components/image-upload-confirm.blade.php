<div class="form-group">
    <label for="images">{{ $label ?? '写真を選んでください' }}</label>
    <div class="form-row">
        @foreach($images as $image)
            <div class="col-2 {{ $loop->first ? 'offset-1' : '' }}">
                <img src="data:image/jpeg;base64,{{ $image->base64String }}" class="img-thumbnail w-100 h-100" style="object-fit: cover;">
                <input type="hidden" name="images_paths[]" value="{{ $image->path }}">
            </div>
        @endforeach
    </div>
</div>
