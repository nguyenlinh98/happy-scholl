@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.recycle.notice')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar recycle">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="tin1">
                        @if(count($product_deletes) != 0)
                            <h5>{{translate('削除一覧')}}</h5>
                            <p>{{translate('取引終了後1ヶ月で削除されます')}}</p>
                            <div class="list-thumb">
                                @foreach( $product_deletes as $product_delete)
                                    <div class="thumb-in-1">
                                        <a href="{{ route('front.recycle.show',$product_delete->id) }}">
                                            <figure class="thumb_recycle"><img
                                                    src="{{$product_delete->getThumbnailImage()}}" alt=""></figure>
                                            <span>{{ translate($product_delete->name)  }}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <h5> {{ translate('削除品がありません') }}</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
