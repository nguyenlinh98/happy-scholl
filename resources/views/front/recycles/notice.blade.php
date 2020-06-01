@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{url('/front/mypage')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('マイページ')}}</h3>
            </div>
            <div class="calendar send-info">
                <div class="title margin-bottom-30">{{translate(getSchoolName())}}</div>
                <a href="{{route('recycle.productregister')}}"><button class="btn-school">{{translate('お申込みの状況')}}（ <span class="text-danger">{{$provides->count() }}</span>）</button></a>
                <a href="{{route('front.recycle.provide.index')}}"><button class="btn-school">{{translate('リサイクル品提供状況')}}（<span class="text-danger">{{ $list->count() }}</span>）</button></a>
                <a href="{{url('/front/recycle/listprovide')}}"><button class="btn-school">{{translate('受取り済リスト')}}</button></a>
                <a href="{{url('/front/recycle/listreceive')}}"><button class="btn-school">{{translate('提供済リスト')}}</button></a>
                <a href="{{url('/front/recycle-product/remove-done')}}"><button class="btn-school">{{translate('削除一覧')}}</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
