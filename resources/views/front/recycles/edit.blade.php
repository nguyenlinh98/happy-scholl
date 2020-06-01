@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school recycle">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.recycle.provide.index')}}" class="back-top"><img
                            src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <form id="form-product" action="{{ route('recycle.product.update',['id' => $recycle->id]) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="select-image">
                        <div class="capture">
                            <label class="choose-capture"><img src="{{asset('images/front/capture.png')}}" alt=""
                                                               onclick="inputFactory('.template-input-image-capture', { sizeLimit: '2MB', numberOfFiles: 5, showMessageAt: '.capture .messages-error'})('.image-input-area')('.template-preview-image', '.image-preview-area')"></label>
                            <span>{{translate('写真を撮る')}}</span>
                            <div class="messages-error"></div>
                        </div>
                        <div class="select-library">
                            <label class="choose-library"><img src="{{asset('images/front/library.png')}}" alt=""
                                                               onclick="inputFactory('.template-input-image', { sizeLimit: '2MB', numberOfFiles: 5, showMessageAt: '.select-library .messages-error'})('.image-input-area')('.template-preview-image', '.image-preview-area')"></label>
                            <span>{{translate('アルバムから')}}</span>
                            <div class="messages-error" style="display:none;"></div>
                        </div>
                        <div class="description">{{translate('※写真は5枚まで掲載できます。')}}</div>
                         <span id="error_upload"></span>
                        @if($errors->has('product.images.*'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.images.*')) }}</div>
                        @endif
                        @if($errors->has('product.images'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.images')) }}</div>
                        @endif
                        <div class="image-input-area" style="display:none;">
                            @foreach($listImg as $index => $img)
                                <input class="image-input-file" type="text" accept="image/*"
                                       style="display:none;" data-index="{{$index}}" name="product[images][{{$index}}]"
                                       value="image{{$index +1}}">
                            @endforeach
                        </div>
                        <div class="image-preview-area"
                             style="clear:both;padding-top:15px;display:flex;flex-wrap:wrap;justify-content:center;">
                            @foreach( $listImg as $index => $img)
                                <div style="margin:0 10px;display:inline-block;" class="img_preview_old">
                                    <img class='product-preview'
                                         src="{{  $img }}"
                                         style="height:10em!important;width:10em;object-fit:cover;border:solid 3px #FFF462;border-radius:10px;"
                                         id="image1">
                                    <div style="color:red;font-size:20px;text-align:center"><i
                                            class="fas fa-minus-circle remove-image"
                                            onclick="deleteImg('.image-preview-area')" data-index="{{$index}}"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">{{translate('品名')}}</label>
                        <input type="text" class="form-control" id="title" name="product[name]"
                               value="{{$recycle->name}}">
                        @if($errors->has('product.name'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.name')) }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="option">{{translate('リサイクル品の状態')}}</label>
                        <select name="product[product_status]" id="option" class="form-control">
                            <option value="1" {{ $recycle->status == 1 ? 'selected' : '' }}>新品、未使用</option>
                            <option value="2" {{ $recycle->status == 2 ? 'selected' : '' }}>未使用に近い</option>
                            <option value="3" {{ $recycle->status == 3 ? 'selected' : '' }}>目立った傷や汚れなし</option>
                            <option value="4" {{$recycle->status == 4 ? 'selected' : '' }}>やや傷や汚れあり</option>
                            <option value="5" {{ $recycle->status == 5 ? 'selected' : '' }}>傷や汚れあり</option>
                            <option value="6" {{ $recycle->status == 6 ? 'selected' : '' }}>全体的に状態が悪い</option>
                        </select>
                        @if($errors->has('product.product_status'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.product_status')) }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">{{translate('詳細（サイズなど）')}}</label>
                        <textarea name="product[detail]" id="description"
                                  class="form-control">{{ $recycle->detail }}</textarea>
                        @if($errors->has('product.detail'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.detail')) }}</div>
                        @endif
                    </div>
                    <div class="text-r">
                        <p>{{translate('ご確認事項')}}</p>
                        <p>{{translate('万一紛失等で受取できなかった場合、')}}</p>
                        <p>{{translate('一切の責任を負いません。')}}</p>
                    </div>
                    <div class="remember">
                        <label class="form-group form-check">
                            <input type="checkbox" id="form-consent">
                            <span class="checkmark"></span>
                        </label>
                        <label class="form-check-label" for="form-consent">{{translate('注意事項に同意して')}}
                            <br/>{{translate('お申込みください。')}}</label>
                    </div>
                    <button id="btn-form-sent" class="btn-school btn-grey" type="button"
                            onClick="allowSubmitOnlyIfConsent(this)">{{translate('出品する')}}</button>
                </form>
            </div>
            <div class="btn-check select-school recycle">
                <button class="btn-school " data-toggle="modal"
                        data-target="#deleteRecycleProduct{{$recycle->id}}">{{translate('削除')}}</button>
            </div>
            <div class="modal fade" id="deleteRecycleProduct{{$recycle->id}}" tabindex="-1"
                 role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content dialog">
                        <div class="position">
                            <p>{{translate('本当に削除して')}}</p>
                            <p>{{translate('よろしいですか？')}}</p>
                            <form action="{{route('front.recycle.provide.delete',$recycle->id)}}"
                                  method="POST">
                                @csrf
                                <button class="btn-school">{{translate('削除')}}</button>
                            </form>
                            <img src="{{asset('images/front/custudent.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--  Templates --}}
    <div class="template-input-image-capture" style="display:none;">
        <input class="image-input-file" type="file" accept="image/*" capture style="display:none;">
    </div>
    <div class="template-input-image" style="display:none;">
        <input class="image-input-file" type="file" accept="image/*" style="display:none;">
    </div>
    <div class="template-preview-image" style="display:none;">
        <div style="margin:0 10px;display:inline-block;">
            <img class='product-preview'
                 style="height:10em!important;width:10em;object-fit:cover;border:solid 3px #FFF462;border-radius:10px;">
            <div style="color:red;font-size:20px;text-align:center"><i class="fas fa-minus-circle remove-image"></i>
            </div>
        </div>
    </div>
    {{--  Templates --}}
    <style>
        .btn-grey{
            background-color: #D1D2D2;
            border-color: #D1D2D2;
        }
    </style>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            $('#form-consent').on('change',function () {
                if($(this).prop('checked')){
                    $('#btn-form-sent').removeClass('btn-grey');
                }else{
                    $('#btn-form-sent').addClass('btn-grey');
                }
            });
        });
        function deleteImg() {
            $(".image-preview-area").on('click', '.remove-image', function (event) {
                let value = $('.product-preview').attr('src');
                let dataIndex = $(this).attr('data-index');
                $(this).parent().parent('.img_preview_old').remove();
                let input = $('input[data-index=' + dataIndex + ']').remove();
            });
        };

        function inputFactory(mocker, options) {
            let input = $($(mocker).html()).clone();
            let inputKlass = input.attr('class');

            return function appendTo(container) {
                let mostRecentElem = $(container + " ." + inputKlass + ":last-child");
                // Corner case: there are no image-input-file elem initially.
                let index = (1 === mostRecentElem.length) ? mostRecentElem.data('index') + 1 : 0;
                console.log(index);
                // Check for number of files.
                if ($(container + " ." + inputKlass).length >= options.numberOfFiles || $('.image-preview-area .product-preview').length >= 5) {
                    $(options.showMessageAt).text("{{ translate('画像の数を五枚すぎできません') }}").fadeIn();
                    setTimeout(() => $(options.showMessageAt).fadeOut(), 700);

                    return () => {
                    }
                }
                input.attr('data-index', index);
                input.attr('name', 'product[images][' + index + ']');
                input.trigger('click');

                return function previewFactory(previewTemplate, previewContainer) {
                    input.on('change', function () {
                        if (1 !== this.files.length) {

                            return;
                        }
                        // Check for file size.
                        if (this.files[0].size > parseInt(options.sizeLimit) * 1024 * 1024) {
                            $(options.showMessageAt).text("{{ translate('ファイルが大きすぎます。大きくないファイルが追加できます。') }}" + " " + options.sizeLimit + ".").fadeIn();
                            setTimeout(() => $(options.showMessageAt).fadeOut(), 700);

                            return;
                        }
                        // Actually attach input of the file to final form.
                        $(this).appendTo(container);
                        // Create a corresponding thumbnail of the input.
                        let preview = $($(previewTemplate).html()).clone();
                        $('.product-preview', preview).attr('src', URL.createObjectURL(this.files[0]));
                        var file = $('.product-preview').attr('src');
                        if (!file.match(/.(jpg|jpeg|png)$/i)) {
                            $('#error_upload').text('{{translate("画像が無効です")}}');
                        }
                        // Clean up things if click to remove sign at this thumbnail
                        preview.on('click', '.remove-image', {inputOfThis: this}, function (event) {
                            $(event.data.inputOfThis).remove();
                            {{-- use <pre>this.remove()</pre> remove only (-) sign --}}
                            preview.remove();
                            // Empty error messages if needed.
                            $(options.showMessageAt).text('');
                        });
                        preview.appendTo(previewContainer);
                    });
                }
            }
        }

        function enableSubmitOnlyIfConsent(input) {
            if ($(input).prop('checked')) {
                $('#btn-form-sent').prop('disabled', false);
            } else {
                $('#btn-form-sent').prop('disabled', true);
            }

            return;
        };

        function confirmBack(self) {
            let result = confirm(self.data('text'));
            if (result == true) {
                window.location.href = self.data('href');
            }
        }

        function allowSubmitOnlyIfConsent(submit) {
            if ($('#form-consent').prop('checked')) {
                $(submit).closest('form').submit();
            } else {
                return false;
            }

            return true;
        };
    </script>
@endpush
