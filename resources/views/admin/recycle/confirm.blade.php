@extends("layouts.app")
@section("content")
@component('components.form-confirm')
    @slot('action')
        {{ $recycleProduct->exists ? route('admin.recycle.update', $recycleProduct) : route('admin.recycle.store') }}
    @endslot
    @slot('title')
        {{ hsp_title() }}
    @endslot
    <input type="hidden" value="confirmed" name="confirmation">
    @if($recycleProduct->exists)
        @method('PATCH')
    @endif
    <div class="p-4">
        @confirm([
            "for" => "recycle",
            "name" => "name",
            "value" => $recycleProduct->name
        ])
        @include("components.image-upload-confirm", ["images" => $recycleProduct->confirmImages])
        @confirm([
            "for" => "recycle",
            "name" => "product_status_description",
            "value" => hsp_code_group_select("1001", $recycleProduct->product_status),
            "hiddens" => [
                "product_status" => $recycleProduct->product_status
            ]
        ])
        @confirm([
            "for" => "recycle",
            "name" => "detail",
            "value" => $recycleProduct->detail
        ])
    </div>
@endcomponent
@endsection
