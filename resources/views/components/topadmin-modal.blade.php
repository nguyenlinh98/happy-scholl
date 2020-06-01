<a class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{$iteration}}" style="color: white; float:right; margin-left: 10px;">
    情報を消去する
</a>
<a href="{{$editRoute}}">
    <button type="button" class="btn btn-default" style="color: white; background-color: #00D4F4; float:right;">情報を編集する</button>
</a>


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
                ［戻る］をクリックすると、元の画面に戻ります。
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  onclick="deleteTopAdmin({{$iteration}})">削除する</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">戻る</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteTopAdmin(id) {
        document.getElementById("deleteformtopadmin"+id).submit();
    }
</script>
