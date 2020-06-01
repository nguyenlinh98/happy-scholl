@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{url()->previous()}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('カレンダー')}}</h3>
            </div>
            <form method="POST" action="{{route('front.calendar.storeimage',[$id])}}" enctype="multipart/form-data">
                    @csrf
            <div class="calendar">
                <div class="title">{{translate(getSchool()->name)}}</div>
                <div class="head">
                    {{translate('オリジナル背景選択')}}
                </div>
                <div class="select-image">
                    <div class="select-library" style="margin-left:4%; margin-right:9%;">
                        <label for="files_camera">
                        <img src="{{asset('images/front/capture.png')}}" alt="">
                        <input id="files_camera" style="display:none;" type="file" name="image_camera" accept="image/*" capture="camera">
                         </label>
                        <span>{{translate('写真を撮る')}}</span>
                        <span id="error_upload_camera" class="text-danger"></span>
                    </div>
                    <div class="select-library">
                        <label for="files"><img src="{{asset('images/front/library.png')}}" alt=""></label>
                        <input id="files" type="file" name="image" accept="image/*">
                        <span>{{translate('アルバムから')}}</span>
                        <span id="error_upload" class="text-danger"></span>
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{translate($error)}}</p>
                            @endforeach
                        @endif
                    </div>
                    <div class="description">
                    <div>
                        <div id="post_take_buttons" style="display:none">
                        </div>
                    </div>
                    {{translate('※写真は3枚まで掲載できます。')}}</div>
                </div>
                <h4>{{translate('選択ファイル')}}</h4>
                <div class="list-preview">
                    <div class="item">
                    <input id="file_1" type="file" name="image_1" style="display: none;">
                    <input id="file_2" type="file" name="image_2" style="display: none;">
                    <input id="file_3" type="file" name="image_3" style="display: none;">
                    {{--camera input--}}
                    <input id="img_selected" type="hidden"  name="img_selected" value="">
                        <figure>
                        @if($theme && $theme->image1 != null)
                        <img src="{{asset('storage/uploads/' . $theme->image1)}}" id="file_image_1" class="filter_check">
                        <input id="old_img_1" type="hidden" name="old_img_1" value="{{$theme->image1}}" alt="{{$theme->image1}}">
                        @else
                        <img id="file_image_1" class="filter_check" src="{{asset('images/front/thumb-reload.png')}}" alt="">
                        @endif
                        </figure>
                    </div>
                    <div class="item">
                        <figure>
                        @if($theme && $theme->image2 != null)
                        <img src="{{asset('storage/uploads/' . $theme->image2)}}" id="file_image_2" class="filter_check" alt="{{$theme->image2}}">
                        <input id="old_img_2" type="hidden" name="old_img_2" value="{{$theme->image2}}">
                        @else
                        <img id="file_image_2" class="filter_check" src="{{asset('images/front/thumb-reload.png')}}" alt="">
                        @endif
                        </figure>
                    </div>
                    <div class="item">
                        <figure>
                        @if($theme && $theme->image3 != null)
                        <img src="{{asset('storage/uploads/' . $theme->image3)}}" id="file_image_3" class="filter_check" alt="{{$theme->image3}}">
                        <input id="old_img_3" type="hidden" name="old_img_3" value="{{$theme->image3}}">
                        @else
                        <img id="file_image_3" class="filter_check" src="{{asset('images/front/thumb-reload.png')}}" alt="">
                        @endif
                        </figure>
                    </div>
                </div>
            </div>
                <button type="submit" class="btn-login margin-top-30">{{translate('送信')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $(".filter_check").each(function() {
        $('.filter_check').css({"width":"188px","height":"102px","border":"none"});
        // image first selected
        $('.filter_check').first().css('border','2px solid red');
        $('#img_selected').val('file_image_1');
            $(this).click(function() {
                 var id = $(this).attr('id');
                 $('#img_selected').val(id);
                 $('.filter_check').css({"border":"none"});
                 $('#' + id).css('border','2px solid red');
            });
        });

        $("#files").on('change', function () {
            var file_image = $('#img_selected').val();
            var file_origin = document.querySelector('input[name=image]').files;
            var file_size = file_origin[0].size/1024/1024;
            if (!file_origin[0].name.match(/.(jpg|jpeg|png)$/i)) {
                  $('#error_upload').text('{{translate("画像が無効です")}}');
            }
            else if(file_size > 5) {
                   $('#error_upload').text('{{translate("5MB以下の写真のみをアップロードしてください")}}');
              }
             else {
                $('#error_upload').text('');
                if(file_image =='file_image_1') {
                    document.querySelector('input[name=image_1]').files = file_origin;
                } else if(file_image =='file_image_2') {
                    document.querySelector('input[name=image_2]').files = file_origin;
                } else {
                    document.querySelector('input[name=image_3]').files = file_origin;
                }

                if(file_image) {
                    var preview = document.querySelector('img[id=' + file_image + ']');
                }
                var reader = new FileReader();
                var file = file_origin[0];
                //var file_patch = document.getElementById('file_patch');
                reader.addEventListener("load", function () {
                    preview.src = reader.result;
                    //file_patch.value = reader.result;
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        });

        // camera input
        $("#files_camera").on('change', function () {
            var file_image = $('#img_selected').val();
            var file_origin = document.querySelector('input[name=image_camera]').files;
            var file_size = file_origin[0].size/1024/1024;
            if(file_size > 5) {
                  $('#error_upload_camera').text('{{translate("5MB以下の写真のみをアップロードしてください")}}');
            }
            else {
            $('#error_upload_camera').text('');
            if(file_image =='file_image_1') {
                document.querySelector('input[name=image_1]').files = file_origin;
            } else if(file_image =='file_image_2') {
                document.querySelector('input[name=image_2]').files = file_origin;
            } else {
                document.querySelector('input[name=image_3]').files = file_origin;
            }

            if(file_image) {
                var preview = document.querySelector('img[id=' + file_image + ']');
            }
            var reader = new FileReader();
            var file = file_origin[0];
            //var file_patch = document.getElementById('file_patch');
            reader.addEventListener("load", function () {
                preview.src = reader.result;
                //file_patch.value = reader.result;
            }, false);
            if (file) {
                reader.readAsDataURL(file);
            }
            }
        });

    });
</script>
@endpush