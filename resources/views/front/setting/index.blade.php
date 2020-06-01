@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{ translate('設定') }}</h3>
                </div>
                <form action="{{route('setting.success')}}" method="POST">
                    @csrf
                    <div class="calendar switchpage">
                        <div class="title">{{translate(getSchoolName())}}</div>
                        <h3>{{translate('プッシュ通知選択')}}</h3>
                        <ul class="list-switch">
                            <li>
                                <p>{{translate('お手紙')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_letter" value="1" @if($setting && $setting->push_letter==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('お知らせ')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_notice" value="1" @if($setting && $setting->push_notice==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('回答必要通知')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_require_feedback" value="1" @if($setting && $setting->push_require_feedback==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('所属先')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_organization" value="1" @if($setting && $setting->push_organization==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('リサイクル')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_recycle" value="1" @if($setting && $setting->push_recycle==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('講座')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_course" value="1" @if($setting && $setting->push_course ==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('イベント')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_event" value="1" @if($setting && $setting->push_event == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('カレンダー')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_calendar" value="1" @if($setting && $setting->push_calendar == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                            <li>
                                <p>{{translate('ハピスクタウン')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="push_happy_school_plus" value="1" @if($setting && $setting->push_happy_school_plus==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                        </ul>
                        <h3>{{translate('「ハピスクタウン」の表示')}}</h3>
                        <ul class="list-switch">
                            <li>
                                <p>{{translate('ハピスクタウン')}}</p>
                                <label class="switch">
                                    <input type="checkbox" name="disp_happy_school_plus" value="1" @if($setting && $setting->disp_happy_school_plus==1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <button class="btn-login margin-top-50">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

