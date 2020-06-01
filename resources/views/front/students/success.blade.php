@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{url('/front/mypage')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('マイページ')}}</h3>
                </div>
                <div class="send-info">
                    @if(!empty($act))
                        <h4>
                            <p>{{translate('お子様の情報が変更しました')}}</p>
                        </h4>
                    @else
                        <h4>
                            <p>{{translate('お子様の登録が削除しました')}}</p>
                        </h4>
                    @endif
                    <div id="result " style="padding-top: 10px;">
                        <figure>
                            @if($student->avatar)
                                <img src="{{asset('storage/uploads/' . $student->avatar)}}" alt="" id="file_image"
                                     style="height: 113px;position: relative;">
                            @else
                                @if($student->gender == \App\Models\Student::GENDER_BOY)
                                    <img class="img-center" id="file_image"
                                         src="{{asset('images/front/boy.png')}}"
                                         alt="" style="height: 113px;position: relative;">
                                @else
                                    <img class="img-center" id="file_image" src="{{asset('images/front/girl.png')}}"
                                         alt="" style="height: 113px;position: relative;">
                                @endif
                            @endif
                        </figure>
                    </div>
                    <a href="{{ route('front.mypage.index') }}">
                        <button class="btn-login margin-top-30">{{translate('マイページへ')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
