@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.recycle.provide.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}" alt="">{{translate('戻る')}}</a>
                    <h3>リサイクル</h3>
                </div>
                <div class="calendar recycle new">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="text-t margin-top-50">
                        {{translate('指定のリサイクル場所')}}<br/>
                        {{translate('に商品をお届けの上、')}}<br/>
                        {{translate('通知ボタンを押してください。')}}<br/>
                    </div>
                    <button data-toggle="modal"
                            data-target="#confirmProvide{{$product->id}}" class="btn-school margin-top-50"><span>{{translate('確認する')}}</span></button>
                    <!-- Modal -->
                    <div class="modal fade" id="confirmProvide{{$product->id}}"
                         tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content dialog">
                                <div class="position">
                                    <p>{{translate('リサイクル品の'.$product->name.'の')}}</p>
                                    <p>{{translate('持込み連絡を')}}</p>
                                    <p>{{translate('してよろしいですか？')}}</p>
                                    <form action="{{route('front.recycle.provide.confirm.post',$product->id)}}"
                                          method="POST">
                                        @csrf
                                        <button class="btn-school">{{translate('確認する')}}</button>
                                    </form>
                                    <img src="{{asset('images/front/boy.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="{{asset('images/front/boy.png')}}" alt="" style="height: 100px"
                         class="margin-top-50">
                </div>
            </div>
        </div>
    </div>
@endsection