@foreach($recycleProduct as $product)
    <div class="item-reload">
        <a href="{{route('front.recycle.show',$product->id)}}">
            <figure class="thumb_recycle"><img src="{{$product->getThumbnailImage()}}" alt=""></figure>
            <div>{{translate($product->name)}}</div>
        </a>
    </div>
@endforeach
