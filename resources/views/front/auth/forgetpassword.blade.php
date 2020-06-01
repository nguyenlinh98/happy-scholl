@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form">
                <div class="logo">
                    <img src="{{asset('images/front/logo.png')}}" alt="">
                </div>
                <form action="{{route('customer.resetpassword.post')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="email" type="email" class="form-control" id="email"
                               aria-describedby="emailHelp" placeholder="{{translate('メールアドレス')}}">
                    </div>
                    <div class="form-group">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{translate($error)}}</p>
                            @endforeach
                            <p class="text-danger">{{translate('再度ご入力お願いします。')}}</p>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-login">{{translate('ログイン')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
