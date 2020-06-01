@if(strlen($type) > 1)
    <div class="col-sm-12 col-md-3">
        <div class="form-group mb-0">
            <select name="{{ $prependIdentifier }}select" class="form-control" data-target="class-group-department.select" data-action="change->class-group-department#change">
                @if(strpos((string) $type, "1") !== false)
                    <option value="school_classes" @if( old($prependIdentifier."select")==="school_classes" ) selected="selected" @endif>クラス</option>
                @endif
                @if(strpos((string) $type, "2") !== false)
                    <option value="departments" @if( old($prependIdentifier."select")==="departments" ) selected="selected" @endif>所属先</option>
                @endif
                @if(strpos((string) $type, "3") !== false)
                    <option value="class_groups" @if( old($prependIdentifier."select")==="class_groups" ) selected="selected" @endif>クラスグループ</option>
                @endif
            </select>

        </div>
    </div>
@endif
<div class="col-sm-12 {{ strlen($type) > 1 ? 'col-md-9' : '' }}">
    <h4 class="mt-1">※複数ある場合は全て選択してください</h4>
    @if(strlen($type) === 1)
        <input type="hidden" name="{{ $prependIdentifier }}select" value="{{ hsp_block_index(strval($type)) }}">
    @endif
</div>
