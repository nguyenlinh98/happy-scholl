@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.recycle.product.confirm-date',$id)}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}" alt="">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar recycle new">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="text-t margin-top-30">
                        {{translate(showDateJapan($data['carrying_from_datetime']))}} {{$data['carrying_from_datetime_hour']}}
                        <br/>
                        {{translate('から')}}<br/>
                        {{translate(showDateJapan($data['carrying_to_datetime']))}} {{$data['carrying_to_datetime_hour']}}
                        <br/>
                        <br/>
                        {{translate('までに指定場所へ持っていきます。')}}<br/><br/>
                        {{translate('この内容で送信してよろしいですか？')}}<br/><br/><br/>
                    </div>
                    <form action="{{route('front.recycle.product.success-date-post',$id)}}" method="POST">
                        @csrf
                        @foreach($data as $k=>$v)
                            <input type="hidden" name="{{$k}}" value="{{$v}}">
                        @endforeach
                        <button class="btn-school"><span>{{translate('送信する')}}</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
