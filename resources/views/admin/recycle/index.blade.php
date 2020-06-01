@extends('layouts.app')
@section('content')
@if(session()->has("include"))
    @include(session("include"))
@endif
<header class="pt-3 pb-2">
    <h2 class="text-muted">リサイクル</h2>
</header>
<div class="recycle--place--container pb-4 mb-2">
    @include("admin.recycle.recycle-place-form")
</div>
<article role="custom" style="width: calc(100vw - 50px);">
    <form method="POST" action="{{ route('admin.recycle.massDelete') }}">
        <div role="table-header" class="row">
            <div class="col-md-12 col-lg-4">
                <h4>登録者様の提供一覧</h4>
            </div>
            <div class="col-md-12 col-lg-8 text-right">
                <a href="{{ route('admin.recycle.admin') }}" class="btn" style="background: #FAAF3B">
                    <span class="h4">管理者出品一覧</span>
                </a>
                <button data-toggle="modal" data-target="#massDeleteRecyclesModal" type="button" class="btn btn-danger">
                    <span class="h4">削除する</span>
                </button>
            </div>
        </div>
        <table class="table datatable" id="recycles_table" data-controller="datatable">
            <thead>
                <tr class="datatable--header--row">
                    <th style="width: 10%;" scope="col" class="datatable--header--cell" data-column="student_name">お子様の名前</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell" data-column="product_name">商品名</th>
                    {{-- <th style="display: none" scope="col" class="datatable--header--cell" data-column="product_place" data-visible="false">product_place</th> --}}
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">画像</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell" data-column="detail">状態</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">詳細</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">出品日時</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">状態</th>
                    <th style="width: 10%;" scope="col" class="datatable--header--cell">選択</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recycleProducts as $product)
                    @if($product->status !== 0)
                        <tr class="recycle-status--{{ $product->status_class }}">
                            <td>
                                @if($product->parents)
                                    @foreach($product->parents->student as $student)
                                        <p>{{ $student->class->name }}・{{ $student->name }}</p>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            {{-- <td>{{$product->recyclePlace->place }}</td> --}}
                            <td>@include("admin.recycle.figures", ["images" => $product->getImageUrl()])</td>
                            <td>@lang("recycle.product_status.$product->product_status")</td>
                            <td>{{ $product->detail }}</td>
                            <td>{{ $product->toLocalizeDateTime("created_at") }}</td>
                            <td>@lang("recycle.status.$product->status")</td>
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
