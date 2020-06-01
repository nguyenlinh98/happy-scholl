@extends('layouts.app')
@section('content')
@if(session()->has("include"))
    @include(session("include"))
@endif
<header class="pt-3 pb-2">
    <h2 class="text-muted">リサイクル</h2>
</header>
{{-- <div class="recycle--place--container pb-4 mb-2">
    @include("admin.recycle.recycle-place-form")
</div> --}}
<article role="custom" style="width: calc(100vw - 50px);">
    <form method="POST" action="{{ route('admin.recycle.massDelete') }}">
        <div role="table-header" class="row">
            <div class="col-md-12 col-lg-6">
                <span class="h4">管理者の提供一覧</span><span class="h6 pl-3">※状況毎に色分けされます。背景色[黄色:申込有/青:お届け済/グレー:取引終了/白:出品中</span>
            </div>
            <div class="col-md-12 col-lg-6 text-right">
                <a href="{{ route('admin.recycle.create') }}" class="btn btn-primary toggle--delete-column--off">
                    <span class="h4">出品する</span>
                </a>
                <button type="button" class="btn toggle--delete-column--off" style="background: #FAAF3B">
                    <span class="h4">出品連絡する</span>
                </button>
                <button type="button" class="btn btn-primary toggle--delete-column--off" data-action=" click->toggle#toggle" data-toggle-id="main" data-toggle-class="toggle--delete-column">
                    <span class="h4">編集する</span>
                </button>
                <button data-toggle="modal" data-target="#massDeleteRecyclesModal" type="button" class="btn btn-danger toggle--delete-column--off">
                    <span class="h4">削除する</span>
                </button>
                <div class=" toggle--delete-column--on">
                    <button type="button" class="btn btn-sm btn-link" tabindex="0" data-action="click->toggle#toggle" data-toggle-id="main" data-toggle-class="toggle--delete-column">キャンセル</button>
                </div>
            </div>
        </div>
        <table class="table datatable" id="recycles_table" data-controller="datatable">
            <thead>
                <tr class="datatable--header--row">
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">名前</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell" data-column="product_name">商品名</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">画像</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell" data-column="detail">状態</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">詳細</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">出品日時</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">状態</th>
                    <th style="width: 100px;" scope="col" class="datatable--delete--cell datatable--header--cell" data-sortable="false">状態</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">選択</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recycleProducts as $product)
                    @if($product->status !== 0)
                        <tr class="recycle-status--{{ $product->status_class }}">
                            <td>{{ $product->user->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>@include("admin.recycle.figures", ["images" => $product->getImageUrl()])</td>
                            <td>@lang("recycle.product_status.$product->product_status")</td>
                            <td>{{ $product->detail }}</td>
                            <td>{{ $product->toLocalizeDateTime("created_at") }}</td>
                            <td>@lang("recycle.status.$product->status")</td>
                            <td style="width: 100px" class="datatable--delete--cell">
                                <a href="{{ route('admin.recycle.edit', $product) }}" class="btn btn-primary">
                                    <span class="h4">削除</span>
                                </a>
                            </td>
                            <td>
                                <div class="select-box">
                                    <input type="checkbox" name="select_product[]" id="select_product_{{ $product->id }}" value='{{ $product->id }}' />
                                    <label for="select_product_{{ $product->id }}" class="select-box--label"></label>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @include("admin.recycle.modal.confirm-delete-product")
    </form>
</article>

@endsection
