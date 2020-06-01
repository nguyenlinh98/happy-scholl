@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="faq">
                <h4>
                    <p>携帯・スマートフォンの</p>
                    <p>アドレスをご利用の方</p>
                </h4>
                <p>docomo、au、softbankなど各キャリアのセキュリティ設定のためユーザー受信拒否と認識されているか、お客様が迷惑メール対策等で、ドメイン指定受信を設定されている場合に、メー ルが正しく届かないことがございます。info@hapisuku.comのメールを受信できるように設定してください。</p>
                <a href="#">ドメイン指定受信手順はこちらから</a>
                <h4>
                    <p>PCメールアドレスをご利用の方</p>
                </h4>
                <p>お使いのメールサービス、メールソフト、ウィルス対策ソフト等の設定により「迷惑メール」と認識され、メールが届かない場合があります。 （特にYahoo!メールやHotmailなどのフリーメールをお使いの方）<br/>その場合は「迷惑メールフォルダー」等をご確認いただくかお使いのサービス、ソフトウェアの設定をご確認ください。</p>
                <a href="#"><small>Yahoo!メールをご利用の方はこちらをご参照ください＞＞</small></a>
                <a href="#"><small>Hotmailをご利用の方はこちらをご参照ください＞＞</small></a>
                <a href="#"><small>Gmailをご利用の方はこちらをご参照ください＞＞</small></a>
                <button class="btn-faq">スマートフォンの場合</button>
                <div class="channel">
                    <p class="text-center">docomo</p>
                    <p>1.メールアプリ</p>
                    <p>2.メール設定</p>
                    <p>3.ドコモメール設定サイト</p>
                    <p>4.認証画面（パスワードが必要です。 初期設定「0000」）</p>
                    <p>5.指定受信/拒否設定</p>
                    <p>6.受信するメールアドレスの設定『@hapisuku.com』を追加して登録</p>
                    <a href="https://www.nttdocomo.co.jp/info/spam_mail/domain/">＞詳細はこちら</a>
                </div>
                <div class="channel">
                    <p class="text-center">au</p>
                    <p>1.<img src="{{asset('images/front/mail.png')}}" alt="">メールアイコン</p>
                    <p>2.Eメール設定</p>
                    <p>3.アドレス変更・その他の設定</p>
                    <p>4.迷惑メールフィルター設定・確認</p>
                    <p>5.暗証番号を入力</p>
                    <p>6.受信リスト設定で「有効」を選択</p>
                    <p>7.『@hapisuku.com』の入力および一致確認の範囲を選択</p>
                    <p>8.「変更」を選択、「OK」を選択</p>
                    <a href="https://www.au.com/support/service/mobile/trouble/mail/email/filter/detail/domain/">＞詳細はこちら</a>
                </div>
                <div class="channel">
                    <p class="text-center">SoftBank</p>
                    <p>1.My Softbank</p>
                    <p>2.メール設定の「Eメール(i)」を選択</p>
                    <p>3.「迷惑メールブロック設定」の「次へ」を選択</p>
                    <p>4.「受信許可リスト」の「変更」を選択</p>
                    <p>5.「利用選択」、「次へ」を選択</p>
                    <p>6.『@hapisuku.com』を登録し、照合方法を選択し「次へ」</p>
                    <p>7.「登録」、「OK」を選択</p>
                    <a href="https://www.softbank.jp/mobile/support/mail/antispam/mms/whiteblack/">＞詳細はこちら</a>
                </div>
                <button class="btn-faq">携帯電話の場合</button>
                <div class="channel">
                    <p class="text-center">docomo</p>
                    <p>1.i-menu</p>
                    <p>2.お客様サポート</p>
                    <p>3.各種設定</p>
                    <p>4.メール設定</p>
                    <p>5.詳細/設定解除</p>
                    <p>6.認証画面（パスワードが必要です。初期設定「0000」）</p>
                    <p>7.受信/拒否設定で「設定」を選び「次へ」</p>
                    <p>8.ステップ4の受信設定へ『@hapisuku.com』を追加して登録</p>
                    <a href="https://www.nttdocomo.co.jp/info/spam_mail/domain/">＞詳細はこちら</a>
                </div>
                <div class="channel">
                    <p class="text-center">au</p>
                    <p>1.<img src="{{asset('images/front/mail.png')}}" alt="">メールアイコン</p>
                    <p>2.Eメール設定</p>
                    <p>3.メールフィルター</p>
                    <p>4.迷惑メールフィルター</p>
                    <p>5.設定確認する</p>
                    <p>6.暗証番号を入力</p>
                    <p>7.指定受信リスト設定</p>
                    <p>8.『@hapisuku.com』を追加し登録</p>
                    <a href="https://www.au.com/support/service/mobile/trouble/mail/email/filter/detail/domain/">＞詳細はこちら</a>
                </div>
                <div class="channel">
                    <p class="text-center">SoftBank</p>
                    <p>1.Yメニュー</p>
                    <p>2.設定・申込</p>
                    <p>3.メール設定</p>
                    <p>4.メール設定（アドレス・迷惑メール等）</p>
                    <p>5.迷惑メールブロック設定</p>
                    <p>6.個別設定</p>
                    <p>7.受信許可・拒否設定</p>
                    <p>8.「受信許可リスト設定」を選択</p>
                    <p>9.「設定する」を選択し、『@hapisuku.com』を追加して登録</p>
                    <a href="https://www.softbank.jp/mobile/support/mail/antispam/mms/whiteblack/">＞詳細はこちら</a>
                </div>
            </div>
        </div>
    </div>
@endsection