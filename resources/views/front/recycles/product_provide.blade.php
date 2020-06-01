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
                    <div class="title">{{translate(getSchool()->name)}}</div>
                    <div class="profiles">
                        @if(count($list) != 0)
                            <h5>{{translate('リサイクル品提供状況')}}</h5>
                            <a href="{{ route('recycle.listpace', ['school_id' => getSchool()->id]) }}">
                                <button class="btn-school first">{{translate('持込み場所を確認する')}}</button>
                            </a>
                            <div class="list-profile">
                                @foreach($list as $product)
                                    <div class="profile">
                                        <div class="info">
                                            <figure class="thumb_recycle"><img src="{{$product->getThumbnailImage()}}"
                                                                               alt=""></figure>
                                            <p>{{translate($product->name)}}</p>
                                            @if($product->status ==1)
                                                <p>（{{translate('出品中')}}）</p>
                                            @else
                                                <p>（ <span class="text-danger">{{translate('申込みあり')}}</span>）</p>
                                            @endif
                                        </div>
                                        <div class="btns">
                                            @if($product->status ==1)
                                                <button class="btn-clear">{{translate('持込み日時通知')}}</button>
                                                <button class="btn-clear">{{translate('持込み完了通知')}}</button>
                                                <button class="btn-school" id="btn-edit"><a
                                                        href="{{ route('recycle.productEdit',['id' => $product->id] )  }}">{{translate('編集・削除')}}</a>
                                                </button>
                                            @endif
                                            @if($product->status ==2)
                                                <a href="{{route('front.recycle.product.confirm-date',$product->id)}}">
                                                    <button class="btn-school">{{translate('持込み日時通知')}}</button>
                                                </a>
                                                <button class="btn-clear">{{translate('持込み完了通知')}}</button>
                                                <button class="btn-clear">{{translate('編集・削除')}}</button>
                                                <button data-toggle="modal"
                                                        data-target="#cancelProvide{{$product->id}}"
                                                        class="btn-school">{{translate('取引キャンセル')}}</button>

                                            @endif
                                            @if($product->status ==3)
                                                <button class="btn-clear">{{translate('持込み日時通知')}}</button>

                                                <a href="{{route('front.recycle.provide.confirm',$product->id)}}">
                                                    <button class="btn-school">{{translate('持込み完了通知')}}</button>
                                                </a>

                                                <button class="btn-clear">{{translate('編集・削除')}}</button>
                                                <button data-toggle="modal"
                                                        data-target="#cancelProvide{{$product->id}}"
                                                        class="btn-school">{{translate('取引キャンセル')}}</button>
                                            @endif
                                            @if($product->status ==4)
                                                <button class="btn-clear">{{translate('持込み日時通知')}}</button>

                                                <button class="btn-clear">{{translate('持込み完了通知')}}</button>

                                                <button class="btn-clear">{{translate('編集・削除')}}</button>
                                                <button data-toggle="modal"
                                                        data-target="#cancelProvide{{$product->id}}"
                                                        class="btn-school">{{translate('取引キャンセル')}}</button>
                                            @endif
                                            @if($product->status ==5)
                                                <button class="btn-clear">{{translate('持込み日時通知')}}</button>

                                                <button class="btn-clear">{{translate('持込み完了通知')}}</button>

                                                <button class="btn-clear">{{translate('編集・削除')}}</button>
                                                <button class="btn-clear">{{translate('取引キャンセル')}}</button>
                                            @endif
                                            <div class="modal fade" id="cancelProvide{{$product->id}}"
                                                 tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content dialog">
                                                        <div class="position">
                                                            <p>{{translate('お申込者に')}}</p>
                                                            <p>{{translate('キャンセル通知して')}}</p>
                                                            <p>{{translate('よろしいですか？')}}</p>
                                                            <form
                                                                action="{{route('front.recycle.provide.cancel',$product->id)}}"
                                                                method="POST">
                                                                @csrf
                                                                <button
                                                                    class="btn-school">{{translate('キャンセルする')}}</button>
                                                            </form>
                                                            <img src="{{asset('images/front/boy.png')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="deleteRecycleProduct{{$product->id}}"
                                                 tabindex="-1"
                                                 role="dialog"
                                                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content dialog">
                                                        <div class="position">
                                                            <p>{{translate('本当に削除して')}}</p>
                                                            <p>{{translate('よろしいですか？')}}</p>
                                                            <form
                                                                action="{{route('front.recycle.provide.delete',$product->id)}}"
                                                                method="POST">
                                                                @csrf
                                                                <button class="btn-school">{{translate('削除')}}</button>
                                                            </form>
                                                            <img src="{{asset('images/front/boy.png')}}" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="btn-school lastp">
                                {{translate('過去の履歴を確認する')}}
                                <span>{{translate('（取引終了後1ヶ月で削除されます）')}}</span>
                            </button>
                        @else
                            <h5>{{translate('リサイクル品提供がありません')}}</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .profile .info p {
            width: 95px;
            margin-left: 20px;
            word-break: break-word;
            max-height: 75px;
            overflow: hidden;
        }
    </style>
@endsection
