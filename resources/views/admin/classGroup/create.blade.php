@extends('layouts.app')
@section('content')

@component('components.form')
@slot('action', route('admin.cgroup.confirm'))

@slot('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h2 class="page-title">{{ hsp_title() }}</h2>
</div>
<a href="{{route('admin.cgroup.index')}}"> <img src="{{url('/css/asset/button/cgroup-action.png')}}" alt=""></a><span>グループ編集・削除はこちらから</span>
@endslot
@include('admin.classGroup.form')

@slot('footer')
<p class="text-center">
<button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/cgroup-create.png')}}" alt=""></button>
</p>
{{-- <a href="{{ route('admin.cgroup.index') }}"> <img src="{{url('/css/asset/button/cancle.png')}}" alt="" data-dismiss="modal"> </a> --}}
@endslot
@endcomponent
@endsection
