@extends('layouts.app')
@section('content')
    <div class="container-fluid pl-0">
        <div class="row m-0">
            <div class="col-10 pl-0">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    <p class="title mb-0">広告バナー設定</p>
                </div>
            </div>
        </div>
        <br>
    </div>
    <div class="form-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 pt-4">
                    <div class="title-content">バナー一覧</div>
                </div>
                <div class="col-6 pt-4 pb-3">
                    <button class="float-right btn-banner-delete" onclick="myFunctionDelete()">削除</button>
                    <button class="float-right btn-edit btn-banner-accept" onclick="myFunctionEdit()">編集</button>
                    <a href="{{ route('advertises.create') }}">
                        <button class="float-right btn-banner-add">追加</button>
                    </a>
                </div>
            </div>
            <form method="post" id="myForm" action="">
                @foreach($listAdvertises as $advertise)
                    <div class="row pl-15 pr-15 pb-3">
                        <div class="banner-list">
                            <div class="col-6 font-weight-bold">掲載期間：{{ $advertise->startdate }}
                                - {{ $advertise->enddate }}</div>
                            <div class="col-3 banner-list pt-1 pb-1">
                                <img style="width: 105%" src="{{ asset('storage\image-advertises/'.$advertise->filename) }}" alt="" title="">
                            </div>
                            <div class="col-3">
                                <input class="float-right ipt mr-5" name="checkbox[]" type="checkbox" value="{{$advertise->id}}">
                               <div class="div">
                                   @include('components.inline-buttons-advertise', [
                                            "iteration" => $loop->iteration,
                                            "editRoute" => route('advertises.edit', ['id']),
                                            "deleteRoute" => route('advertises.destroy', ['id']),
                                            "modelId" => $advertise->id,
                                    ])
                               </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div>
    </div>

    <script>
        function myFunctionEdit() {
            var id = [];
            $(':checkbox:checked').each(function (i) {
                id[i] = $(this).val();
            });
            if (id.length == 0) {
                alert('check');
                return false;
            }
            if (id.length == 1) {
                $('#btn-edit-advertise').attr("href", function (i, origValue) {
                    return origValue.replace('id', id);
                });
                document.getElementById('btn-edit-advertise').click();
            }
        }
        function myFunctionDelete() {
            var id = [];
            $(':checkbox:checked').each(function (i) {
                id[i] = $(this).val();
            });
            if (id.length == 0) {
                alert('check');
                return false;
            }
            document.getElementById('btn-delete-advertise').click();
            $('#btn-delete-advertise-test').attr("action", function (i, origValue) {
                return origValue.replace('id', id);
            });
        }
    </script>
@endsection

