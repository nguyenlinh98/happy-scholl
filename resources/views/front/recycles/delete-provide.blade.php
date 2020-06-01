@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.recycle.provide.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar send-info">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <h4>
                        <p>{{translate('削除しました。')}}</p>
                    </h4>
                    <img style="height: 100px" src="{{asset('images/front/boy.png')}}" alt="" class="margin-top-50">
                </div>
            </div>
        </div>
    </div>
@endsection
