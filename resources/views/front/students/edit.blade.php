@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <div class="nav-top">
                    <a href="{{route('student.showedit')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('マイページ')}}</h3>
                </div>
                <div class="change-info">
                    <h3>{{translate('お子様情報の編集')}}</h3>
                    <form action="{{route('student.confirmedit',['id'=> $student->id])}}" method="post"
                          enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="lastName">{{translate('姓名')}}</label>
                            <input type="text" name="name" class="form-control" id="lastName" placeholder="姓名"
                                   value="{{translate($student->name)}}">
                        </div>
                        <div class="form-group">
                            <label for="class">{{translate('クラス')}}</label>
                            <select name="class" style="width: 100%" id="class" class="form-control default" disabled="disabled">
                                <option value="{{$student->schoolClass->id}}"
                                        selected>{{translate($student->schoolClass->name)}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sex">{{translate('性別')}}</label>
                            <select name="sex" style="width: 100%" id="sex" class="form-control" disabled="disabled">
                            @if($student->gender == \App\Models\Student::GENDER_BOY)
                                <option value="{{$student->gender}}" selected>{{translate('男')}}</option>
                            @else
                                <option value="{{$student->gender}}" selected>{{translate('女')}}</option>
                            @endif
                            </select>
                        </div>
                        <div class="select-image">
                            <div class="row">
                                <div class="select-library" id="my_camera1" style="margin-left:7%;margin-right:8%; width: 38%;">
                                    <label for="files_camera">
                                    <img src="{{asset('images/front/capture.png')}}" alt="">
                                    <input id="files_camera" style="display:none;" type="file" name="image_camera" accept="image/*" capture="camera">
                                    </label>
                                    <span>{{translate('写真を撮る')}}</span>
                                    <span id="error_upload_camera"></span>
                                </div>
                                <div class="select-library" style="width: 38%;">
                                    <label for="files">
                                        <img src="{{asset('images/front/library.png')}}" alt="">
                                        <input id="files" type="file" name="image" accept="image/*">
                                    </label>
                                    <span>{{translate('アルバムから')}}</span>
                                    <span id="error_upload"></span>
                                </div>
                            </div>
                            <div id="result" style="padding-top: 10px;">
                                <figure>
                                    @if($student->avatar)
                                        <img src="{{asset('storage/uploads/' . $student->avatar)}}" alt="" id="file_image"
                                                      style="width: 100%;height: 113px;position: relative;">
                                    @else
                                          @if($student->gender == \App\Models\Student::GENDER_BOY)
                                              <img class="img-center" id="file_image" src="{{asset('images/front/boy.png')}}"
                                                alt="" style="width: 100%;height: 113px;position: relative;">
                                          @else
                                              <img class="img-center" id="file_image" src="{{asset('images/front/girl.png')}}"
                                                alt="" style="width: 100%;height: 113px;position: relative;">
                                          @endif
                                    @endif
                                </figure>
                                <input type="text" name="file_patch" style="display: none" id="file_patch"/>
                                <input type="hidden" name="avatar" value="" id="avatar">
                            </div>
                            <div class="description">
                                {{translate('※写真を選択しない場合は')}}<br/>
                                　{{translate('男の子は「ハピくん」')}}<img src="{{asset('images/front/boy.png')}}"
                                                                 alt=""><br/>
                                　{{translate('女の子は「ユキちゃん」')}}<img src="{{asset('images/front/girl.png')}}"
                                                                  alt=""><br/>
                                　{{translate('になります。')}}
                            </div>
                        </div>
                        <button class="btn btn-login" type="submit">{{translate('変更内容の確認')}}</button>
                    </form>
                    <a href="{{route('student.confirmdelete',$student->id)}}">
                        <button class="btn btn-exit">{{translate('削除')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <style>
        .change-info select{
            background-image: none;
        }
        .change-info select{
            text-align-last: initial;
        }
    </style>
@endsection

@push('script')
<script>
    $("#files").on('change', function () {
        var preview = document.querySelector('img[id=file_image]');
        var file = document.querySelector('input[name=image]').files[0];
        var file_size = file.size/1024/1024;
        if (!file.name.match(/.(jpg|jpeg|png)$/i)) {
            $('#error_upload').text('{{translate("画像が無効です")}}');
        } else if(file_size > 5) {
            $('#error_upload').text('{{translate("5MB以下の写真のみをアップロードしてください")}}');
        }
           else {
           $('#error_upload').text('');
            var reader = new FileReader();
            //var file_patch = document.getElementById('file_patch');
            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);
            if (file) {
                reader.readAsDataURL(file);
            }
        }
    });
    // for camera
     $("#files_camera").on('change', function () {
        var preview = document.querySelector('img[id=file_image]');
        var file = document.querySelector('input[name=image_camera]').files[0];
        var file_size = file.size/1024/1024;
        if(file_size > 5) {
                $('#error_upload_camera').text('{{translate("5MB以下以下の写真のみをアップロードしてください")}}');
        }
        else {
        $('#error_upload_camera').text('');
        var reader = new FileReader();
        //var file_patch = document.getElementById('file_patch');
        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);
        if (file) {
            reader.readAsDataURL(file);
        }
     }
     });

    $("form").submit(function() {
        $("#class, #sex").prop("disabled", false);
    });

    $(document).ready(function () {
        var textWidth =  $('#class option').textWidth();
        $('#class').css('text-indent','calc(50% - '+textWidth/2+'px)');
        var sex =  $('#sex option').textWidth();
        $('#sex').css('text-indent','calc(50% - '+sex/2+'px)');
    });
</script>
@endpush