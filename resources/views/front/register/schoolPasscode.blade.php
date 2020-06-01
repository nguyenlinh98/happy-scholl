@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form register">
                <div class="logo">
                    <img src="{{asset('images/front/logo.png')}}" alt="">
                </div>
                <form action="{{route('register.schoolpasscode.post')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <div>
                            <p>{{translate('小文字アルファベット1文字と')}}</p>
                            <p>{{translate('4桁の数字の認証パスコードを')}}</p>
                            <p>{{translate('ご入力ください')}}</p>
                        </div>
                        <input type="text" name="schoolPasscode" value="{{old('schoolPasscode')?old('schoolPasscode'):$passcode}}"
                               class="form-control" placeholder="{{translate('認証パスコード')}}">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{translate($error)}}</p>
                            @endforeach
                            {{--<p class="text-danger">{{translate('再度ご登録のし直しをお願いします。')}}</p>--}}
                        @endif
                    </div>
                    <p>{{translate('※半角英数字でご入力ください')}}</p>
                    <div class="remember">
                        <label class="form-group form-check">
                            <input class="filter_check" id="exampleCheck1" type="checkbox" name="school_check" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <label class="form-check-label" for="exampleCheck1">{{translate('ご利用規約に同意する')}}</label>
                    </div>
                    <div class="form-group">
                        <a style="color: #1156A4" href="{{url('/option/agreement')}}">{{translate('ご利用規約を確認する')}}</a>
                    </div>
                    <button type="submit" class="btn btn-login">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
         $('.btn-login').attr('disabled', 'disabled');
         $('.filter_check').on("click", function() {
                if($(this).is(':checked')) {
                    $('.btn-login').removeAttr('disabled');
                } else {
                    $('.btn-login').attr('disabled', 'disabled');
                }
         });
    });
</script>
@endpush
