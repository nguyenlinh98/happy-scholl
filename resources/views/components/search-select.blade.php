<?php
$options = [
    '〇' => '〇 のみ',
    '✖' => '✖ のみ',
    'ー' => '末回答者のみ',
    '4' => '回答者のみ'
];

?>

<div class="row-search-search float-right" data-controller="datatable-search" @isset($table_id) data-datatable-search-identifier="letters_table" @endisset @isset($columns) data-datatable-search-columns="destination,title" @endisset>
    <p class="btn-search-title mb-0 font-weight-bold ml-16">{{$title ?? 'キーワード検索'}}</p>
    <div class="dataTable-search dataTable-input-letter ml-16">
        <select class="form-search-select dataTable-input table-search-input" id="idDataTableSearchbox" name="search" data-target="datatable-search.input">
            @isset($options)
                @foreach ($options as $id => $option)
                    <option value="{{$id}}">{{$option}}</option>
                @endforeach
            @endisset
        </select>
        <button class="btn-search-submit" type="button" data-action="click->datatable-search#search">検索</button>
    </div>
</div>
