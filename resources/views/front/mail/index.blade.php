@extends('front.layouts.front')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('お問い合わせ')}}</h3>
                </div>
                <div class="calendar">
                    <div class="title">{{translate($school->name)}}</div>
                </div>

                <div class="contact-mail mt-4">
                    <form action="{{route('email-contact.post')}}" method="POST">
                        @csrf
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('お名前')}}</label> <span>{{translate('必須')}}</span><br>
                            <input type="text" name="name" placeholder="山田　太郎">
                            @if ($errors->any())
                                @foreach ($errors->get('name') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('フリガナ')}}</label> <span>{{translate('必須')}}</span><br>
                            <input type="text" name="name_kata" placeholder="ヤマダ　タロウ">
                            @if ($errors->any())
                                @foreach ($errors->get('name_kata') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('お子様所属学校名')}}</label> <span>{{translate('必須')}}</span><br>
                            <input type="text" name="school_name" placeholder="ハッピースクール">
                            @if ($errors->any())
                                @foreach ($errors->get('school_name') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('学年')}}</label><br>
                            <input type="text" name="year" placeholder="1 年">
                            @if ($errors->any())
                                @foreach ($errors->get('year') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('クラス')}}</label><br>
                            <input type="text" name="class_name" placeholder="1 組">
                            @if ($errors->any())
                                @foreach ($errors->get('class_name') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('電話番号')}}</label><br>
                            <input type="text" name="tel" placeholder="03-3562-5551">
                            @if ($errors->any())
                                @foreach ($errors->get('tel') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('メールアドレス')}} </label> <span>{{translate('必須')}}</span><br>
                            <input type="text" name="email" placeholder="info@hapisuki.com">
                            @if ($errors->any())
                                @foreach ($errors->get('email') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group-contact-mail">
                            <label for="">{{translate('お問い合せ内容')}} </label> <span>{{translate('必須')}}</span><br>
                            <textarea name="detail" id="" cols="30" rows="10"></textarea>
                            @if ($errors->any())
                                @foreach ($errors->get('detail') as $message)
                                    <div class="">
                                        <ul>
                                            <li style="color: red">{{translate($message)}}</li>
                                        </ul>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button class="btn-login margin-top-30" type="submit">{{translate('送信')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
