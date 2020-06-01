<div class="btn-group btn-group-sm" role="group">
    <a href="{{$editRoute}}" class="btn btn-primary" style="display: none" id="btn-edit-advertise">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg>
        <span>編集</span>
    </a>
    <a class="btn btn-danger btn-delete-advertise btn-sm text-white" style="display: none" id="btn-delete-advertise" data-toggle="modal" data-target="#deleteModal{{$iteration}}">
        削除
    </a>
    <form name="deleteform{{$iteration}}" method="POST" action="{{$deleteRoute}}" id="btn-delete-advertise-test">
        @csrf
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="{{$modelId}}">
    </form>

    <div class="modal fade" id="deleteModal{{$iteration}}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{$iteration}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    ［戻る］をクリックすると、編集画面に戻ります。
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="btnClick()">削除する</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function btnClick() {
        $('#btn-delete-advertise-test').submit();
    }
</script>
