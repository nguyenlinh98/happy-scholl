<form method="POST" action="{{$action}}" enctype="multipart/form-data" class="form--common">
    @isset($header)
    {{$header}}
    @else
    {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2"> --}}
        @if(hsp_title() !=="")
        <h2 class="page-title">{{hsp_title()}}</h2>
        @endif
    {{-- </div> --}}
    @endif

    <div class="form--body bg-form px-3 pt-1 pb-4">

        @csrf
        {{$slot}}

        @isset($footer)
        {{$footer}}
        @else
        <button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/confirm.png')}}" alt=""></button>
        <a href="{{ $back ?? url()->previous() }}"> <img src="{{url('/css/asset/button/cancle.png')}}" alt="" data-dismiss="modal"> </a>
        @endif
        {{$extraFooter ?? ''}}
    </div>
</form>
