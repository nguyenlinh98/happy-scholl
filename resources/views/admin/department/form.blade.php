{{-- @extends('layouts.app')
@section('content')
<div class="container-fluid menu-home p-5">
    @component('components.form')
    @slot('title', __('department.title.index'))

    @slot('action', route('department_setting.store'))
    @slot('header')
    <div class="container-fluid p-0 mb-3">
        <div class="row m-0">
            <div class="col-10 pl-0">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
                    <p class="title mb-0">所属先設定</p>
                </div>
                <p>所属先名を入力してください</p>

                @includeWhen($errors->has('receivers'), 'components.form-error', ["name" => 'receivers'])
            </div>
        </div>
    </div>
    @endslot

    @slot("footer")
    <div class="hidden-on-form-confirm">
        <button type="button" data-toggle-id="main" data-toggle-class="form--confirm" data-action="click->toggle#toggle" class="btn btn-primary btn-lg form--submit px-5 rounded-lg shadow mr-2">送信
        </button>
        <a class="btn btn-dark btn-lg px-5 rounded-lg" href="{{route('department_setting.index')}}">戻る</a>
</div>
<div class="show-on-form-confirm">
    <div id="confirmation-box" class="py-2 bg-primary text-center mt-2">
        <h4 class="text-white font-weight-bold">この内容で、送信・予約設定してよろしいですか？</h4>

        <div class="buttons mt-4 mb-3 mx-auto">
            <button type="submit" class="btn btn-danger btn-lg px-5 rounded-lg shadow mr-2">送信</button>
            <button type="button" class="btn btn-light btn-lg px-5 rounded-lg" data-toggle-id="main" data-toggle-class="form--confirm" data-action="click->toggle#toggle">戻る
            </button>
        </div>

        <h6 class="font-weight-bold">※予約設定は変更可能ですが、一度送信したお手紙は変更できません。</h6>
    </div>
</div>
@endslot

@endcomponent
</div>
@endsection
--}}

<div class="p-4">
    @input([
    "for" => "department",
    "name" => "name",
    "value" => $department->name,
    "type" => "text",
    ])
    {{-- <div class="form-group">
        <label for="class_group_toggle">所属先の対象となるクラスを選択してください</label>
        @class_department_group([
        "type" => 1,
        "prepend" => "department_setting_"
        ])
    </div> --}}
</div>
