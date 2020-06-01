@extends('layouts.app')
@section('content')
<header>
    <h1 class="page-title">管理者登録設定</h1>
    <h3 class="mb-3">編集する登録者を選んでください</h3>
</header>
<div class="row">
    <div class="col-sm-12 col-md-9">
        <div class="form-group text-right">
            <a href="{{route('admin.teacher.list')}}?view=homeroom" class="btn {{request()->query('view', 'homeroom') === 'homeroom' ? 'btn-primary' : 'btn-secondary' }} btn-small rounded--lg">担任管理者に切り替えする</a>
            <a href="{{route('admin.teacher.list')}}?view=departments" class="btn {{request()->query('view') === 'departments' ? 'btn-primary' : 'btn-secondary' }} btn-small rounded--lg">所属先に切り替える</a>
            <a href="{{route('admin.teacher.list')}}?view=teachers" class="btn {{request()->query('view') === 'teachers' ? 'btn-primary' : 'btn-secondary' }} btn-small rounded--lg">未設定管理者に切り替えする</a>
        </div>
        @include('admin.teacher.list.' . request()->query("view", "homeroom"))
    </div>
</div>

@endsection
