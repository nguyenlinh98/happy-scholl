@extends('layouts.pdf')
@section("content")
@foreach($class->students as $student)
    @include("admin.class.passcode", ["student" => $student, "passcode" => $passcodeList[$student->id]->passcode])
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
@endsection
