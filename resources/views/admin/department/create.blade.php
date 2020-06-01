@extends('layouts.app')
@section('content')
@component('components.form')
@slot('action', route('admin.department_setting.confirm'))

@slot('header')
<div class="pt-3 pb-2">
    <h2 class="page-title">所属先設定</h2>
</div>
@endslot
@include('admin.department.form')
@slot("footer")
<button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/confirm.png')}}" alt=""></button>
<a href="{{route('admin.department_setting.index')}}"> <img src="{{url('/css/asset/button/cancle.png')}}" alt=""></a>
@endslot
@endcomponent
@endsection
