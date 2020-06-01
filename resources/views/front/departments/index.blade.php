@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{url('/front/mypage')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('所属先選択')}}</h3>
                </div>
                <div class="calendar">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="text-t margin-top-30">
                        <p>{{translate('選択してください。')}}</p>
                        @foreach( $students as $student)
                            {{--                        {{ print($student) }}--}}
                            <a href="{{ route('departments.list',['id'=> $student->id])}}">
                                <button class="btn-school">{{translate($student->schoolClass->name) }} - {{ translate($student->name) }}</button>

                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
