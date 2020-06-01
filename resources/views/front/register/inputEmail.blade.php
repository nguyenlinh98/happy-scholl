@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form register">
                <form action="{{route('register.email.post')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <div>
                            <p>{{translate('メールアドレスの')}}</p>
                            <p>{{translate('ご登録をお願いします')}}</p>
                        </div>
                        <input type="text" name="email"  value="{{ old('email')?old('email'):(isset($data['email'])?$data['email']:'') }}"  class="form-control" placeholder="{{translate('メールアドレス')}}">
                    </div>
                    <div class="form-group">
                        <div><p>{{translate('メールアドレスの確認')}}</p></div>
                        <input type="text" name="email_confirmation" value="{{ old('email_confirmation')?old('email_confirmation'):(isset($data['email'])?$data['email']:'') }}"  class="form-control" placeholder="{{translate('メールアドレス')}}">
                    </div>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{translate($error)}}</p>
                        @endforeach
                        <p class="text-danger">{{translate('再度ご登録のし直しをお願いします。')}}</p>
                    @endif
                    <button type="submit" class="btn btn-login">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
