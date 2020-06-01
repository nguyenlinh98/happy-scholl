<div class="modal" id="massDeleteRecyclesModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-primary p-4 individual-select--select-class">
            <h2 class="text-white my-4 text-center">本当に削除してよろしいですか？</h2>
            <div class="form-row">
                <div class="col-9">
                    <button type="submit" class="btn btn-danger btn-block"><span class="h4">削除する</span></button>
                </div>
                <div class="col-3">
                    <button type="button" data-dismiss="modal" class="btn btn-block btn-light"><span class="h4">戻る</span></button>
                </div>
            </div>
            @csrf
        </div>
    </div>
</div>
