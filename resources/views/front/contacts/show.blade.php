@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.contact.list',$currentStudentId)}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('連絡網')}}</h3>
                </div>
                <div class="calendar list">
                    <div class="title">{{translate(getSchoolName().$student->schoolClass->name)}}</div>
                    <div class="confirm">
                        <p>{{translate($student->name)}} </p>
                        @if($currentStudentId == $student->id)
                            @foreach($contacts as $contact)
                                <a href="{{route('front.contact.edit',[$student->id,$contact->id])}}">
                                    <button>{{$contact->relationship }} - {{$contact->tel  }}</button>
                                </a>

                            @endforeach
                            @if(count($contacts) < 2)
                                <div style="width: 100%;">
                                    <a class="btn-school" style="margin: 30px auto;float: unset"
                                       href="{{route('front.contact.create',$student->id)}}">
                                        {{translate('追加')}}
                                    </a>
                                </div>
                            @endif

                        @else
                            @foreach($contacts as $contact)
                                <a href="tel:{{$contact->tel}}">
                                    <button>{{$contact->relationship}} - {{$contact->tel  }}</button>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .list > div .btn-school:last-child {
            width: initial;
        }
    </style>
@endsection
