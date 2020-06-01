@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('連絡網')}}</h3>
                </div>
                <div class="calendar list">
                    <div class="title">{{translate(getSchoolName().$currentStudent->schoolClass->name)}}</div>
                    <div class="text-center">
                        <button class="btn-school">
                            <a href="{{route('front.contact.show',[$currentStudent->id,$currentStudent->id])}}">{{translate('登録・編集・削除')}}</a>
                        </button>
                        @php
                            $sort = $sort=='asc'?'desc':'asc';
                        @endphp
                        <button class="btn-school"><a
                                    href="{{route('front.contact.list', [$currentStudent->id,'sort'=> $sort])}}">{{translate('並替え')}}</a>
                        </button>
                    </div>

                    <ul>
                        @foreach($listStudent as $student)
                            <li>
                                <a href="{{route('front.contact.show',[$currentStudent->id,$student->id])}}">{{translate($student->name)}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        .list ul li a {
            word-break: break-word;
        }

        @media (max-width: 1024px) {
            .list > div .btn-school:last-child {
                width: 50%;
                margin-right: initial;

            }
        }
    </style>
@endsection
@push('script')
    <script>

    </script>
@endpush
