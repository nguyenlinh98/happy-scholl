@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('student.edit',$id)}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('マイページ')}}</h3>
                </div>
                <div class="change-info">
                    <h3>{{translate('更新するお子様情報の確認')}}</h3>
                    <form action="{{ route('student.update',['id' => $id]) }}" method="post"
                          enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="lastName">{{translate('姓名')}}</label>
                            <input type="text" name="name" class="form-control" id="lastName"
                                   value="{{ $data['name'] }}" placeholder="姓名" readonly>
                        </div>
                        <div class="form-group">
                            <label for="class">{{translate('クラス')}}</label>
                            <input type="text" class="form-control col-xs-12" id="class"
                                   value="{{ $class->name}}" placeholder="クラス" readonly>
                            <input type="hidden" name="school_class_id" value="{{$data['class']}}"/>
                        </div>
                        <div class="form-group">
                            <label for="sex">{{translate('性別')}}</label>
                            @if($student->gender == \App\Models\Student::GENDER_BOY)
                                <input type="text" class="form-control col-xs-12" id="sex"
                            value="{{ translate('男') }}" placeholder="性別" readonly>
                            @else
                                <input type="text" class="form-control col-xs-12" id="sex"
                            value="{{ translate('女') }}" placeholder="性別" readonly>
                            @endif
                            {{-- <input type="text" class="form-control col-xs-12" id="sex"
                                   value="{{ __('男') }}" placeholder="性別" readonly> --}}
                            <input type="text" name="gender" value="{{$data['sex']}}" style="display: none"/>
                        </div>
                        <div class="select-image">
                            @if($student->avatar == null)
                                @if($avatar!= null)
                                    <input type="hidden" name="avatar" value="{{$avatar}}">
                                    <figure><img src="{{asset('storage/uploads/'.$avatar)}}" alt="" id="file_image" style="width: 100%;height: 113px;position: relative;"></figure>
                                @else
                                <figure>
                                     @if($student->gender == \App\Models\Student::GENDER_BOY)
                                        <img src="{{asset('images/front/boy.png')}}" alt="" style="width: 100%;height: 113px;position: relative;">
                                     @else
                                         <img src="{{asset('images/front/girl.png')}}" alt="" style="width: 100%;height: 113px;position: relative;">
                                     @endif
                                </figure>
                                @endif
                            @else
                                @if($avatar!= null)
                                    <input type="hidden" name="avatar" value="{{$avatar}}">
                                    <figure><img src="{{asset('storage/uploads/'.$avatar)}}" alt="" id="file_image" style="width: 100%;height: 113px;position: relative;"></figure>
                                @else
                                    <figure><img src="{{asset('storage/uploads/'.$student->avatar)}}" alt="" id="file_image" style="width: 100%;height: 113px;position: relative;"></figure>
                                @endif
                            @endif
                        </div>
                        <input type="hidden" name="file_input_status" value="{{$file_input_status}}">
                        <button type="submit" class="btn btn-login">{{translate('変更を確定する')}}</button>
                        <button type="cancel" class="btn btn-exit" name="cancel" value="cancel">{{translate('戻る')}}</button>
                    </form>
                        {{--<a href="{{url()->previous()}}"><button class="btn btn-exit">{{translate('戻る')}}</button></a>--}}
                </div>
            </div>
        </div>
    </div>
@endsection