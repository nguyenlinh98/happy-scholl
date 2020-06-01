@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate($msg)}}</h3>
                </div>
                <form action="{{route('front.attendance.complete',$studentId)}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="{{$type}}">
                    <div class="calendar join">
                        <div class="title">{{translate(getSchoolName())}}</div>
                        <textarea name="content" placeholder="{{translate('コメント(30 文字以内）例：出席します。')}}"></textarea>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{translate($error)}}</p>
                            @endforeach
                            <p class="text-danger">{{translate('再度ご入力のし直しをお願いします。')}}</p>
                        @endif
                        <button class="btn-login margin-top-30">{{translate('送信')}}</button>
                        @if($avatar->avatar)
                            <img class="img-center" src="{{asset('storage/uploads/' . $avatar->avatar)}}" alt="">
                        @else
                            @if($avatar->gender == \App\Models\Student::GENDER_BOY)
                                <img class="img-center" src="{{asset('images/front/boy.png')}}" alt="">
                            @else
                                <img class="img-center" src="{{asset('images/front/girl.png')}}" alt="">
                            @endif
                        @endif
                        {{--<label for="files">{{translate('画像製作中')}}</label>
                        <span class="imgFileName"></span>
                       <input type="file" id="files" name="image" style="display: none">--}}
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .join textarea{
            border: 1.5px solid #dedede;
        }
        .join input, .join label {
            background: #C3C4C4;
            color: #E60013;
            width: 140px;
            height: 100px;
            display: block;
            text-align: center;
            margin: 45px auto 0;
            vertical-align: middle;
            line-height: 100px;
        }

        .imgFileName {
            text-align: center;
            display: block;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#files').change(function (e) {
                var fileName = e.target.value.split('\\').pop();
                $('.imgFileName').html(fileName);
            });
        });
    </script>
@endsection

