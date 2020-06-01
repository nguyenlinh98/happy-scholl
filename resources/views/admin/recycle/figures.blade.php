<div class="figure" data-controller="figure">
    @if(count($images))
        <div class="figure--wrapper">

            @foreach($images as $image)
                <img src="{{ $image }}" class="figure--image {{ $loop->first ? 'is-active' : '' }}" id="figure-{{ hsp_uuid() }}" data-target="figure.image">
            @endforeach
        </div>
        @if(count($images) > 1)
            <button class="figure--arrow arrow-prev" data-target="figure.prevLink" data-action="click->figure#prev" type="button"></button>
            <button class="figure--arrow arrow-next" data-target="figure.nextLink" data-action="click->figure#next" type="button"></button>
        @endif
    @endif
</div>
