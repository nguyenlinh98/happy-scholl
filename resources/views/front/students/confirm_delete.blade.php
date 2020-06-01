@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('マイページ')}}</h3>
                </div>
                <div class="change-info">
                    <h3>{{translate('削除するお子様情報の確認')}}</h3>
                    <form action="{{route('student.destroy',['id' => $student->id])}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <label for="lastName">{{translate('姓名')}}</label>
                            <input type="text" name="name" class="form-control" id="lastName"
                                   value="{{$student->name}}" placeholder="姓名" readonly>
                        </div>
                        <div class="form-group">
                            <label for="class">{{translate('クラス')}}</label>
                            <input type="text" class="form-control col-md-2" id="class"
                                   value="{{ $class->name}}" placeholder="クラス" readonly>
                            <input type="hidden" name="school_class_id" value="{{$class->name}}"/>
                        </div>
                        <div class="form-group">
                            <label for="sex">{{translate('性別')}}</label>
                            @if($student->gender == \App\Models\Student::GENDER_BOY)
                                <input type="text" class="form-control col-md-2" id="sex"
                            value="{{ translate('男') }}" placeholder="性別" readonly>
                            @else
                                <input type="text" class="form-control col-md-2" id="sex"
                            value="{{ translate('女') }}" placeholder="性別" readonly>
                            @endif
                            
                            <input type="text" name="gender" value="{{$student->gender}}" style="display: none"/>
                        </div>
                        <div class="select-image">
                            @if($student->avatar == null)
                                <figure>
                                @if($student->gender == \App\Models\Student::GENDER_BOY)
                                    <img src="{{asset('images/front/boy.png')}}" alt="" style="width: 100%;height: 113px;position: relative;">
                                 @else
                                     <img src="{{asset('images/front/girl.png')}}" alt="" style="width: 100%;height: 113px;position: relative;">
                                 @endif
                                </figure>
                                <input type="hidden" name="avatar" value="{{$student->avatar}}">
                            @else
                                <figure><img src="{{asset('storage/uploads/'.$student->avatar)}}" alt="" id="file_image"
                                             style="width: 100%;height: 113px;position: relative;"></figure>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-login">{{translate('お子様情報を削除する')}}</button>
                    </form>
                        <a href="{{url()->previous()}}"><button class="btn btn-exit">{{translate('戻る')}}</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection