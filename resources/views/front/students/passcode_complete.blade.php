@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{url('/front/mypage')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('マイページ')}}</h3>
            </div>
            <div class="send-info">
                <h4>
                    <p>{{translate('お子様の追加登録が')}}</p>
                    <p>{{translate('完了しました')}}。</p>
                </h4>
                <img style="height: 90px" src="{{asset('images/front/girl.png')}}" alt="">
                <a href="{{url('/front/mypage')}}"><button class="btn-login margin-top-30">{{translate('マイページへ')}}</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
