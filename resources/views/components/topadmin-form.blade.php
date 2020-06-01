<form method="POST" action="{{$action}}" enctype="multipart/form-data" class="form--common {{strpos(Route::current()->getName(), "top_admin.school.edit")!== false ? 'topadmin-school-fixheight' : ""}}" style="min-height: auto;">
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
         <div class="topadmin-school ">
             <button type="submit" class="btn btn-link"><img class="btn-hover" src="{{url('/css/asset/button/confirm.png')}}" alt=""></button>
             <input type="image" name="reject" value="return" alt="Cancel" src="{{url('/css/asset/button/cancle.png')}}" style="vertical-align: middle; border: none">
         </div>
        @endif
        {{$extraFooter ?? ''}}
    </div>
</form>
