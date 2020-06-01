{{-- @extends('layouts.app')
@section('content')

<form method="POST" action="{{route('cgroup.update',[$classGroup->id])}}" enctype="multipart/form-data" style="height: 100%">
    @csrf
    <div class="form--body bg-form px-3 pt-1 pb-4" style="height: 100%;">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 text-muted">
            <h2>クラスグループ設定</h2>
        </div>
     <div class="" style="width: 70%">
         <a href="{{route('cgroup.index')}}"> <img src="{{url('/css/asset/button/cgroup-action.png')}}" alt=""></a>
         <p class="font-weight-bold mb-1 mt-3" style="font-size: 24px;font-weight: bold;color: black;">グループ名をご入力ください</p>
         <div class="form-group">
             <input class="form-control" type="text" name="name" value="{{$classGroup->name}}">
         </div>

         <div class="form-group class_group_container class--container">
             <div class="font-weight-bold h4">
                 <label for="name" class="label">クラス</label>
                 <div class="row pl-3" style="width: 90%" >
                     @foreach($classes as $class)

                         <label class="d-block class-group-css mb-3">
                             <input type="checkbox" name="class_ids[]" id="checkbox-{{$class->id}}" class="ml-1" value="{{$class->id}}"
                                    @if($classGroup->classes->contains($class->id)) checked="checked" @endif>
                             <label for="checkbox-{{$class->id}}"> {{$class->name}}</label>
                         </label>

                     @endforeach
                 </div>
             </div>
         </div>

         <button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/cgroup-create.png')}}" alt=""></button>
     </div>
    </div>
</form>

@endsection --}}

@extends('layouts.app')
@section('content')
@component('components.form')
@slot('action', route('admin.cgroup.confirm', $classGroup))

@slot('header')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
    <h2 class="font-weight-bold text-secondary">{{hsp_title()}}</h2>
</div>
<a href="{{route('admin.cgroup.index')}}"> <img src="{{url('/css/asset/button/cgroup-action.png')}}" alt=""></a>
@endslot
@include('admin.classGroup.form')

@slot('footer')
<button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/cgroup-create.png')}}" alt=""></button>
<a href="{{ route('admin.cgroup.index') }}"> <img src="{{url('/css/asset/button/cancle.png')}}" alt="" data-dismiss="modal"> </a>
@endslot
@endcomponent
@endsection

