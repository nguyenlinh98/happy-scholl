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
    <form method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="form-content p-4">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-8 p-0">
                        <p class="title mb-0">バナーファイルをアップロードしてください。</p><br>
                        <div class="upload-btn-wrapper">
                            <button class="btn-uploadfile" style="border-radius: 25px !important;">ファイルから選ぶ</button>
                            <input type='file' name="filename" onchange="readURL(this);" aria-describedby="fileHelp"/>
                            <img id="img-choose" src="#" alt="your image"/>
                        </div>
                        <br><br>
                        <div class="div" style="display: none">
                            <p class="title mb-0">配信リンク URL</p>
                            <input type="text" style="width: 80%">
                        </div>
                        <div class="container-fluid">
                            <div class="row pr-5">
                                <div class="col-6 p-0">
                                    <p class="mb-1">通知日時設定</p>

                                    <div class="date-pick mb-1">
                                        <input class="pl-0" type="text" name="startdate" value="2019-11-17"
                                               style="padding-left: 10px!important; padding-top: 5px; padding-bottom: 5px; font-weight: bold">
                                    </div>
                                </div>
                                <div class="col-6">

                                    <p class="mb-1">終了日設定</p>
                                    <div class="date-pick mb-1">
                                        <input class="pl-0" type="text" name="enddate" value="2019-11-17"
                                               style="padding-left: 10px!important; padding-top: 5px; padding-bottom: 5px; font-weight: bold">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <button type="submit" class="btn btn-primary btn-submit-form" style="color: black">確認</button>
                        <button type="submit" class="btn btn-submit-form" style="color: black; background: #99b4b4">戻る
                        </button>
                    </div>
                    <div class="col-4 p-0">
                        <p class="title mb-0">デモ画面（下部に表示されます）</p><br>
                        <img src="<?php echo e(url('/images/phone.png')); ?>" alt="" style="width: 70%">
                    </div>

                </div>
            </div>
        </div>
    </form>
@endsection
<script>    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-choose')
                    .attr('src', e.target.result)
                    .width('50%')
                    .height('auto');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }</script>
