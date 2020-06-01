@extends('layouts.app')
@section('content')
<div role="wrapper" class="bg-form h-100 px-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-5">
        <h2 class="page-title">{{ hsp_title() }}</h2>
    </div>
    <nav class="">
        <div class="row">
            {{-- <a href="{{route('admin.teacher.create')}}">
                <div class="text-center btn-content btn-content-teacher mb-0">
                    <p class="mb-0">新しい管理者を登録する</p>
                </div>
            </a>

            <a href="{{route('admin.teacher.list')}}">
                <div class="text-center btn-content btn-content-teacher mb-0">
                    <p class="mb-0">登録管理者を編集する</p>
                </div>
            </a> --}}

            <div class="btn-content-teacher col-sm-12 col-md-6">
                <a href="{{route('admin.teacher.create')}}" class="btn btn-primary btn-lg btn-block py-5 rounded--lg"><span class="h1">新しい管理者を登録する</span></a>
            </div>
            <div class="btn-content-teacher col-sm-12 col-md-6">
                <a href="{{route('admin.teacher.list')}}" class="btn btn-primary btn-lg btn-block py-5 rounded--lg"><span class="h1">登録管理者を編集する</span></a>
            </div>
        </div>
    </nav>
</div>
@endsection
