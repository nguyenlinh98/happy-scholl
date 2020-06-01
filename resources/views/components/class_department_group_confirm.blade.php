@foreach(["school_classes", "departments", "class_groups"] as $relation)
    @if(!is_null($model->getAttribute($prefix.$relation)))
        @isset($multipleSelect)
            <h4 class="border-bottom">
                @if($relation === "school_classes")
                    クラス
                @elseif($relation === "departments")
                    所属先
                @elseif($relation === "class_groups")
                    クラスグループ
                @endif
            </h4>
        @endisset
        @foreach($model->getAttribute($prefix.$relation) as $item)
            <h5>{{ $item->name }}</h5>
            <input type="hidden" name="{{ $prefix }}{{ $relation }}[]" value="{{ $item->id }}">
        @endforeach

        <div class="pt-2"></div>
    @endif
@endforeach
