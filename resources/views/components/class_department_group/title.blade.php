<div class="col-sm-12 col-md-3">
    <div class="form-group mb-0">
        <div class="bg-white p-1">
            @switch($template)
                @case("1")
                    <h3 class="mb-0">クラス</h3>
                    <input type="hidden" name="{{ $prependIdentifier }}select" value="school_classes">
                    @break
                @case("2")
                    <h3 class="mb-0">所属先</h3>
                    <input type="hidden" name="{{ $prependIdentifier }}select" value="departments">
                    @break
                @case("3")
                    <h3 class="mb-0">クラスグループ</h3>
                    <input type="hidden" name="{{ $prependIdentifier }}select" value="class_groups">
                    @break
            @endswitch
        </div>
    </div>
</div>
<div class="col-sm-12 col-md-9">
    <h4 class="mt-1">※複数ある場合は全て選択してください</h4>
</div>
