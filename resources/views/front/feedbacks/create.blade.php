@extends('front.layouts.front')
@section('content')
    <div class="row">
            <div class="col-md-12">
                <div class="select-school">
                    <!-- NAVBAR -->
                    <form action="{{url('/front/feedback/complete')}}" method="#">
                    <div class="nav-top">
                        <a href="{{url('/front/mypage')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                        <h3>{{translate('出席通知')}}</h3>
                    </div>
                    <div class="calendar join">
                        <div class="title">{{translate('〇〇小学校')}}</div>
                        <textarea name="join" placeholder="コメント"></textarea>
                        <button class="btn-login margin-top-30">{{translate('送信')}}</button>
                        <a href="#">{{translate('画像製作中')}}</a>
                    </div>
                    </form>
                </div>
            </div>
     </div>
@endsection
