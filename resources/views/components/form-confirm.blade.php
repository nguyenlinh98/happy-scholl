<form method="POST" action="{{$action}}" enctype="multipart/form-data" class="form--common">
    @isset($header)
    {{$header}}
    @else
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
        <h2 class="page-title">{{$title}}</h2>
    </div>
    @endif

    <div class="form--body bg-form px-3 pt-1 pb-4">

        @csrf
        {{$slot}}

        @isset($footer)
        {{$footer}}
        @else
        <div id="confirmation-box" class="py-2 bg-primary text-center mt-2">
            <h4 class="text-white font-weight-bold">この内容で、送信・予約設定してよろしいですか？</h4>

            <div class="buttons mt-4 mb-3 mx-auto">
                <input type="image" name="submit" alt="Submit" style="border: 0; margin-bottom: -35px;" src="{{url('/css/asset/button/send.png')}}" data-controller="submit" data-action="click->submit#preventDouble">
                <input type="image" name="reject" value="return" alt="Cancel" style="border: 0; margin-bottom: -13px;" src="{{url('/css/asset/button/send-cancle.png')}}">
            </div>

            <h6 class="font-weight-bold">※予約設定は変更可能ですが、一度送信した{{$title}}は変更できません。</h6>
        </div>
        @endif
        {{$extraFooter ?? ''}}
    </div>
</form>
