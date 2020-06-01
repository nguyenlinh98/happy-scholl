@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school recycle mypage-pc">
                <div class="nav-top">
                    <a href="{{route('front.school.choose')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('マイページ')}}</h3>
                </div>
                <!-- MENU SELECT -->
                <div class="menu-select">
                    <select name="op" id="choose-lang">
                        <option @if(Session::get('lang')=='ja') selected
                                @endif data-url="{{route('front.mypage.lang','ja')}}"
                                value="ja">{{translate('日本語')}}</option>
                        <option @if(Session::get('lang')=='en') selected
                                @endif  data-url="{{route('front.mypage.lang','en')}}"
                                value="en">{{translate('英語')}}</option>
                        <option @if(Session::get('lang')=='zh-CN') selected
                                @endif data-url="{{route('front.mypage.lang','zh-CN')}}"
                                value="vi">{{translate('中国語')}}</option>
                        <option @if(Session::get('lang')=='ko') selected
                                @endif data-url="{{route('front.mypage.lang','ko')}}"
                                value="vi">{{translate('韓国語')}}</option>
                    </select>
                    <a href="{{route('front.mypage.index')}}" class="resize-img"><img
                                src="{{asset('images/front/reload.png')}}" alt=""></a>
                    <a data-toggle="collapse" href="#menu" class="resize-img" id="col-menu">
                        <img src="{{asset('images/front/menu.png')}}" alt="">
                        <span>{{translate('メニュー')}}</span>
                    </a>
                    <div class="collapse" id="menu">
                        <ul>
                            <li><a href="{{route('setting.index')}}">{{translate('設定')}}</a></li>
                            <li><a href="{{route('departments.index')}}">{{translate('所属先選択')}}<br/>
                                    {{translate('(部活動・習い事など)')}}</a></li>
                            <li><a href="#">{{translate('購入履歴')}}</a></li>
                            <li><a href="{{route('student.index')}}">{{translate('お子様情報の')}}<br/>
                                    {{translate('登録・編集・削除')}}</a></li>
                            <li><a href="{{ route('front.contact.index') }}">{{translate('連絡網')}}</a></li>
                            <li><a href="#">{{translate('お問い合わせ')}}</a></li>
                            <li><a href="#">{{translate('ご説明書')}}</a></li>
                            <li><a href="#">{{translate('会員規約')}}</a></li>
                            <li><a href="#">{{translate('バージョン')}}</a></li>
                            <li><a href="#">{{translate('特定商取引に関する法律に基づく表記')}}</a></li>
                            <li><a href="#">{{translate('プライバシーポリシー')}}</a></li>
                            <li><a href="{{route('customer.logout')}}">{{translate('ログアウト')}}</a></li>
                            <li><a href="#">{{translate('管理者用ページ')}}</a></li>
                        </ul>
                    </div>
                </div>
                <!-- LIST SCHOOL -->
                <div class="list-school">
                    <div class="student">
                        @foreach($students as $student)
                            <div class="school">
                                <div class="gird-test">
                                    <div class="grid1">
                                        <div class="title"><span>{{translate($school->name)}}</span></div>
                                    </div>

                                    <div class="grid-thumb">
                                        <div class="thumb">
                                            @if($student->avatar)
                                                <a href="{{route('student.edit',$student->id)}}">
                                                    <img src="{{asset('storage/uploads/' . $student->avatar)}}" alt=""></a>
                                            @else
                                                @if($student->gender == \App\Models\Student::GENDER_BOY)
                                                    <a href="{{route('student.edit',$student->id)}}">
                                                        <img src="{{asset('images/front/boy.png')}}" alt=""></a>
                                                @else
                                                    <a href="{{route('student.edit',$student->id)}}">
                                                        <img src="{{asset('images/front/girl.png')}}" alt=""></a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="grid-item">
                                        <div class="bg-if">{{translate($student->schoolClass->name)}}</div>
                                    </div>
                                    <div class="grid-item">
                                        <div class="bg-if">{{translate($student->name)}}</div>
                                    </div>
                                    @if($schoolSetting)
                                        <div class="grid-item"><a
                                                    href="{{route('front.student.attendance',$student->id)}}"
                                                    class="btn-school">{{translate('出席')}}</a></div>
                                    @endif
                                    @if($schoolSetting)
                                        <div class="grid-item"><a href="{{route('front.student.absence',$student->id)}}"
                                                                  class="btn-school">{{translate('欠席')}}</a></div>
                                    @endif
                                    @if($student->check_question_exist == 1)
                                        @if(count($arrCountSurvey[$student->id]) == 1)
                                            <div class="noti-red"><a href="{{route('emergency.student-questions', [$arrCountSurvey[$student->id][0], $student->id])}}">
                                                <img src="{{ asset('images/front/loa-yellow.png') }}" alt="">{{translate('緊急連絡')}}</a>
                                            </div>
                                        @else
                                            <div class="noti-red"><a href="{{route('emergency.student-questions-category',$student->id)}}">
                                                <img src="{{ asset('images/front/loa-yellow.png') }}" alt="">{{translate('緊急連絡')}}</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="grid-btn">
                                    @if($schoolSetting && $schoolSetting->letter_active)
                                        <div class="grid-item"><a href="{{route('front.letters.index',[$student->id])}}"
                                                                  class="btn-school"><img
                                                        src="{{asset('images/front/book.png')}}"
                                                        alt=""
                                                        class="fff">{{translate('お手紙')}}（<span
                                                        class="text-danger">{{$arrLetterCount[$student->id]}}</span>）</a>
                                        </div>
                                    @endif
                                    @if($schoolSetting && $schoolSetting->message_active)
                                        <div class="grid-item"><a
                                                    href="{{route('front.notification.index',$student->id)}}"
                                                    class="btn-school"><img
                                                        src="{{asset('images/front/quote.png')}}"
                                                        alt="">{{translate('お知らせ')}}（<span
                                                        class="text-danger">{{$arrMessageCount[$student->id]}}</span>）</a>
                                        </div>
                                    @endif
                                    @if($schoolSetting && $schoolSetting->calendar_active)
                                        <div class="grid-item"><a href="{{route('front.calendar.index')}}"
                                                                  class="btn-school"><img
                                                        src="{{asset('images/front/calculator.png')}}"
                                                        alt="">{{translate('カレンダー')}}</a></div>
                                    @endif
                                    @if($schoolSetting && $schoolSetting->require_feedback_active)
                                        <div class="grid-item">
                                            <a href="{{route('front.require_feedback.list',$student->id)}}"
                                               class="btn-school"><img
                                                        src="{{asset('images/front/ox.png')}}"
                                                        alt="">{{translate('回答必要通知')}} （<span
                                                        class="text-danger">{{$arrRequireFeedback[$student->id]}}</span>）</a>
                                        </div>
                                    @endif
                                    @if($schoolSetting && $schoolSetting->seminar_active)
                                        <div class="grid-item"><a href="{{route('seminar.index',[$school->id])}}" class="btn-school"><img
                                                        src="{{asset('images/front/teacher.png')}}"
                                                        alt="">{{translate('講座')}}（<span
                                                        class="text-danger">1</span>）</a></div>
                                    @endif
                                    @if($schoolSetting && $schoolSetting->event_active)
                                        <div class="grid-item"><a href="{{route('schoolevent.index',[$school->id])}}" class="btn-school"><img
                                                        src="{{asset('images/front/student.png')}}"
                                                        alt="">{{translate('イベント')}} （<span
                                                        class="text-danger">1</span>）</a></div>
                                    @endif
                                    {{-- @if($schoolSetting)
                                        <div class="grid-item"><a href="#" class="btn-school"><img
                                                        src="{{asset('images/front/cart.png')}}"
                                                        alt="">{{translate('物品購入')}}</a>
                                        </div>
                                    @endif --}}
                                    @if($schoolSetting && $schoolSetting->contact_book_active)
                                        <div class="grid-item"><a href="{{route('front.contact.list',$student->id)}}"
                                                                  class="btn-school"><img
                                                        src="{{asset('images/front/phone.png')}}"
                                                        alt="">{{translate('連絡網')}}</a></div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- @if($schoolSetting && $schoolSetting->happy_school_plus_active)
                        @if(($userSetting) && $userSetting->disp_happy_school_plus)
                            <a href="#" class="btn-add"><img src="{{asset('images/front/btn-add.png')}}" alt=""></a>
                        @endif
                    @endif --}}
                </div>
                <!-- LIST RELOAD -->
                <div class="list-reload">
                    <div class="title"><img src="{{asset('images/front/bar-reload.png')}}"
                                            alt="">{{translate('新着のリサイクル品')}}</div>
                    <a href="{{route('front.recycle.notice')}}">
                        <button class="btn-school noti">{{translate('リサイクル通知')}}（ <span
                                    class="text-danger">{{$list}}</span>）
                        </button>
                    </a>
                    <div class="list-item">

                    </div>
                    <a href="#" class="view-more" data-id="{{ $school->id }}" data-user="{{ $parents->id }}"
                       data-page="1">{{translate('もっと見る')}}</a>

                    <a href="{{route('front.recycle.notice')}}" class="a-btn" id="notice">
                        <button class="btn-school">{{translate('リサイクル品の状況')}}</button>
                    </a>
                    <a href="{{ url('front/recycle-product/create')}}" class="a-btn" id="create">
                        <button class="btn-school">{{translate('リサイクル品を提供する')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .menu-select select {
            border-color: #231815;
        }

        @media (min-width: 1024px) {
            .btn-school.noti {
                display: none;
            }
        }

        /*TODO remove fixed lang */
        .list-school {
            padding: initial;
        }

        .menu-select {
            position: initial;
            width: initial;
        }
        .noti-red a{
            color: #FFF462;
            width: 100%;
            height: 100%;
            display: block;
        }
        .noti{
             width: 90% !important;
        }

        @media (min-width: 1024px) {
            .mypage-pc .nav-top select {
                position: absolute;
                right: 30px;
                top: 30%;
                transform: translateY(-50%);

                border: 1px solid #000;
                -moz-appearance: none;
                -webkit-appearance: none;
                appearance: none;
                border-radius: 0;
                background-image: url(../../images/front/bg-select.png);
                background-repeat: no-repeat;
                background-position: calc(100% - 15px) center;
                background-size: 25px;
                background-color: #ffffff;
                height: 38px;
                padding: 2px 30px 2px 5px;
                width: 220px;
                font-size: 18px;
                font-weight: 300;
                margin: 15px 20px 15px 0;
                flex: 4;
                text-align-last: center;
                font-weight: 400;
            }
        }

        #menu {
            right: 0;
        }
        #choose-lang{
            text-align-last: initial;
        }
        @media (min-width: 1024px) {
            .mypage-pc .collapse:not(.show) {
                display: none;
            }
            .mypage-pc .grid-btn .grid-item:nth-child(1) .btn-school,
            .mypage-pc .grid-btn .grid-item:nth-child(2) .btn-school {
                position: inherit;
                width: 202px;
                padding: 9px 4px;
                top: 0;
                height: 100%;
            }
        }
        @media (min-width: 1364px) {
            .mypage-pc .grid-btn .grid-item:nth-child(1) .btn-school,
            .mypage-pc .grid-btn .grid-item:nth-child(2) .btn-school {
                position: inherit;
                width: 207px;
                padding: 9px 4px;
                top: 0;
                height: 100%;
            }
        }
    </style>
@endsection
@section('script')
    <script>
        $(document).ready(function () {


            var sex =  $('#choose-lang option').textWidth();
            $('#choose-lang').css('text-indent','calc(50% - '+sex/2+'px)');

            var create = $('#create button').height();
            var notice = $('#notice button').height();
            if(create > notice){
                $('#notice button').height(create)
            }else{
                $('#create button').height(notice);
            }
            $('#menu').on('shown.bs.collapse', function () {
                var height = $(this).height() + $(this).offset().top + 50;
                $('main').css('min-height', height);

            });

            var id = $('.view-more').attr('data-id');
            var user_id = $('.view-more').attr('data-user');
            var page = $('.view-more').data('page');
            $('.view-more').data('page', page + 1);
            $.ajax({
                url: '{{route('front.recycle.loadDataAjax') }}',
                method: "POST",
                data: {id: id, user_id:user_id, page: page, _token: "{{csrf_token()}}"},
                dataType: "JSON",
                success: function (data) {
                    if (data.html != '') {
                        $('.list-item').append(data.html);
                    }
                    if (!data.hasPage) {
                        $('.view-more').addClass('d-none');
                        $('.view-more').css('display', 'none');
                    }
                }
            });

            $(document).on('click', '.view-more', function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                var page = $(this).data('page');
                $(this).data('page', page + 1);
                $.ajax({
                    url: '{{route('front.recycle.loadDataAjax') }}',
                    method: "POST",
                    data: {id: id, page: page, _token: "{{csrf_token()}}"},
                    dataType: "JSON",
                    success: function (data) {
                        if (data.html != '') {
                            $('.list-item').append(data.html);
                        }
                        if (!data.hasPage) {
                            $('.view-more').addClass('d-none');
                            $('.view-more').css('display', 'none');
                        }
                    }
                });
            });
        });
    </script>
@endsection
