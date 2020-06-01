@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="main-form col-md-4">
                <div >
                    <h5>ご指定のメールアドレスに</h5>
                    <h5>メールをお送りしました。</h5>
                </div>
                <div class="text-three">
                    <h5>メールに従い、確証を行い</h5>
                    <h5>パスワードの設定を</h5>
                    <h5>お願いいたします。</h5>
                </div>
                <div class="faq">
                    <a href="{{ route('register.faq') }}" class="btn btn-primary" style="background: white; color: #0068a3; border: white; float: left">
{{--                            <button style="padding:8px;border-color:#ccc; background-color: #ffffff; border-radius: 8px; color: blue;">--}}
                                {{translate('ハピスクからのメールが')}}<br>{{translate('届かない方へ')}}
                        </a>
                </div>

            </div>
        </div>
    </div>
@endsection
