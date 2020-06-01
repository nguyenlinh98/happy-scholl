@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.recycle.notice')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}" alt="">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar recycle">
                    <div class="title">{{translate(getSchoolName())}}</div>
                        <div class="tin1">
                            @if(count($lists) != 0)
                            <h5>{{translate('提供済リスト')}}</h5>
                            <p>{{translate('（取引終了後1ヶ月で削除されます）')}}</p>
                            <div class="list-thumb">
                                @foreach( $lists as $list)
                                    <div class="thumb-in-1">
                                        <a href="{{route('front.recycle.show', $list->id) }}">
                                            <figure class="thumb_recycle"><img src="{{$list->getThumbnailImage()}}"
                                                                               alt=""></figure>
                                            <span>{{translate($list->name)}}</span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <h5>{{ translate('リサイクル品提供がありません') }}</h5>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
