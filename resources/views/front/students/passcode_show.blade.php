@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <div class="nav-top">
                <a href="{{route('student.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('マイページ')}}</h3>
            </div>
            <div class="send-info">
                <h3>{{translate($schoolName->name)}}</h3>
                <p>{{translate('お子様の 7 桁のパスコードを')}}</p>
                <p>{{translate('ご入力ください')}}</p>
                <form action="{{route('student.passcodecomplete')}}" method="POST">
                    @csrf
                    <input type="text" class="input-send" placeholder="{{translate('お子様パスコード')}}" name="passcode">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{translate($error)}}</p>
                        @endforeach
                    @endif
                    <p><br>{{translate('※半角英数字でご入力ください')}}</p>
                    <button class="btn-login margin-top-30" type="submit">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
