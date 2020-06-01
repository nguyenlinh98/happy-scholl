<div class="row-search-search float-right" data-controller="datatable-search" @isset($table_id) data-datatable-search-identifier="letters_table" @endisset @isset($columns) data-datatable-search-columns="destination,title" @endisset>
    <p class="btn-search-title mb-0 font-weight-bold ml-16">{{$title ?? 'キーワード検索'}}</p>
    <div class="dataTable-search dataTable-input-letter ml-16"><input id="idDataTableSearchbox" class="dataTable-input table-search-input" placeholder="" type="text" name="search" data-target="datatable-search.input">
        <button class="btn-search-submit" type="button" data-action="click->datatable-search#search">検索</button>
    </div>
</div>
    