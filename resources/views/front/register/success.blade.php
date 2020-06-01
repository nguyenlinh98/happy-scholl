@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="faq-end" style="text-align: center;">
                {{translate('パスワードの設定が完了しました。')}}<br/><br/>
                {{translate('ストアで「ハピスク」で検索するか')}}<br/>
                {{translate('下記バナーをタップしてインストール')}}<br/>
                {{translate('してログインしご利用ください。')}}<br/>

                <img src="{{asset('images/front/app.png')}}" alt="" class="logo_app" style="width: 275px;"><br/>
                <img src="{{asset('images/front/g00gle.png')}}" alt="" class="logo_google"><br/><br/>

                {{translate('PC やガラケーご利用の方、')}}<br/>
                {{translate('アプリをご利用になれない方は')}}<br/>
                {{translate('下記をクリックして')}}<br/>
                {{translate('WEB ブラウザよりご利用ください。')}}<br/><br/>

             <a href="{{route('customer.login')}}" target="_blank">
                <button style="padding:7px;border-color:#53727E; background-color: #53727E; border-radius: 7px; color: #ffffff;">{{translate('WEB ブラウザから開く')}}</button>
             </a>
            </div>
        </div>
    </div>
@endsection
