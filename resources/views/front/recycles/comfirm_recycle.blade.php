@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{url('/front/mypage')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">戻る</a>
                    <h3>リサイクル</h3>
                </div>
                <form action="{{route('recycle.confirmRecycle', $recycle->id)}}" method="POST">
                    @csrf
                    <div class="calendar">
                        <div class="title">{{translate(getSchoolName())}}</div>
                        <div class="card-f">
                            <h4>
                                {{translate('申し込みのリサイクル品が')}}<br/>
                                {{translate('指定の場所に届きました・')}}
                            </h4>
                            <p>指定のリサイクル場所でリサイクル品を<br/>
                                お受け取りの上、受取り通知ボタンを<br/>
                                押してください。<br/></p>
                            <button class="btn-school margin-top-50"><span>商品を受け取りました</span></button>
                        </div>
                        <img style="height: 100px" src="images/custudent.png" alt="" class="margin-top-50">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
