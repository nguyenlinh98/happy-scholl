@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    @if(count(getStudent())==1)
                        <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                    src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}
                        </a>
                    @else
                        <a href="{{route('departments.index')}}" class="back-top"><img
                                    src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}
                        </a>
                    @endif

                    <h3>{{translate('所属先選択')}}</h3>
                </div>
                <form action="{{route('departments.success')}}" method="POST">
                    <div class="calendar">
                        <div class="title">{{getSchoolName()}}</div>
                        <div class="head">{{translate('所属先追加選択')}}</div>
                        <div class="check-list">
                            @csrf
                            <input type="hidden" name="studentId" value="{{$studentId}}">
                            @foreach($listDepartment as $department)
                                <label class="container-radio">{{translate($department->name)}}
                                    <input @if(in_array($department->id,$departmentChoose->toArray())) checked
                                           @endif type="checkbox" name="department[]" value="{{$department->id}}">
                                    <span class="checkmark"></span>
                                </label>
                            @endforeach

                        </div>
                    </div>
                    <button class="btn-login margin-top-30">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
