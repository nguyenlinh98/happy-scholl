@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12 full-height">
            <div class="login-next">
                <a href="{{route('front.school.passcodeschool')}}">
                <button class="btn-faq">{{translate('学校・組織の追加')}}
                </button>
                </a>
                <span>{{translate('新しい学校・組織の追加はこちら')}}</span>
                @foreach($listSchools as $school_id=>$school)
                    <a href="{{route('front.school.action',$school_id)}}">
                        <button class="btn-school">{{translate($school['name'])}}</button>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection