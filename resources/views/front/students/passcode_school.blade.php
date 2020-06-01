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
                <p>{{translate('小文字アルファベット1文字と')}}<br/>
                    {{translate('4桁の数字の認証パスコードを')}}<br/>
                    {{translate('ご入力ください')}}<br/>
                </p>
                <form action="{{route('student.postpasscodeschool')}}" method="POST">
                    @csrf
                    <input type="text" class="input-send" placeholder="{{translate('認証パスコード')}}" name="schoolPasscode">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{translate($error)}}</p>
                        @endforeach
                    @endif
                    <p>{{translate('※半角英数字でご入力ください')}}</p>
                    <div class="form-group">
                        <div class="remember">
                            <label class="form-group form-check">
                                <input class="filter_check" id="exampleCheck1" type="checkbox" name="school_check" value="1">
                                <span class="checkmark"></span>
                            </label>
                            <label class="form-check-label" for="exampleCheck1" id="label_check">{{translate('ご利用規約に同意する')}}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <a class="agreement"  href="{{url('/option/agreement')}}">{{translate('ご利用規約を確認する')}}</a>
                    </div>
                    <button class="btn-login margin-top-30" type="submit">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .agreement{
        text-align: center;
        margin: 0 auto;
        display: block;
        color: #1156A4;
        font-size: 18px;
        font-weight: 500;
    }
    #label_check{
        padding-top: 20px !important;
    }
    .checkmark{
        top: -2px;
    }
</style>
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
