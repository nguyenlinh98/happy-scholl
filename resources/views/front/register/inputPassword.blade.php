@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form register">
                <form action="{{route('register.password.post')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="form-group">
                        <div>

                            <p>{{translate('パスワードの設定を')}}</p>
                            <p>{{translate('お願いします。')}}</p>
                            <p>{{translate('（半角英数字8文字以上20文字以内）')}}</p>
                        </div>
                        <input type="password" name="password" value="{{old('password')}}" class="form-control" placeholder="{{translate('パスワード')}}">
                    </div>
                    <div class="form-group">
                        <div><p>{{translate('パスワードの確認')}}</p></div>
                        <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}"  class="form-control" placeholder="{{translate('パスワード')}}">
                    </div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{translate($error)}}</p>
                        @endforeach
                        <p class="text-danger">{{translate('再度ご登録のし直しをお願いします。')}}</p>
                    @endif
                    <button type="submit" class="btn btn-login">{{translate('登録')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
