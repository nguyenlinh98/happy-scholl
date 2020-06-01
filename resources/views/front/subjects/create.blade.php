@extends('layouts.slim')

@section('content')
<div class="container-fluild">
    <header class="m-5 text-lg-center"> select subject
    </header>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 my-3">
            <div class="card">
                <div class="card-header">
                <a href="{{ url('/front/index') }}" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                                        @csrf
                    <div class="form-group row">
                       <div class="col-md-6">
                           {{--<label for="" class="col-md-9 col-form-label text-md-right">sport</label>--}}
                           {{--<input id="" type="checkbox" class="form-control col-md-6">--}}
                       </div>
                   </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
