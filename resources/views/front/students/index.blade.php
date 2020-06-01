@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{route('front.mypage.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('マイページ')}}</h3>
            </div>
            <div class="send-info">
                <a href="{{route('student.passcodeschool')}}"><button class="btn-school">{{translate('お子様の追加登録')}}</button></a>
                <a href="{{route('student.showedit')}}"><button class="btn-school">{{translate('お子様情報編集・削除')}}</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
