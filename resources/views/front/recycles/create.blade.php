@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school recycle">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{url('/front/mypage')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <form id="form-product" action="{{ route('recycle.product.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
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
                        @if($errors->has('product.images.*'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.images.*')) }}</div>
                        @endif
                        @if($errors->has('product.images'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.images')) }}</div>
                        @endif
                        <div class="image-input-area" style="display:none;"></div>
                        <div class="image-preview-area"
                             style="clear:both;padding-top:15px;display:flex;flex-wrap:wrap;justify-content:center;"></div>
                    </div>
                    <div class="form-group">
                        <label for="title">{{translate('品名')}}</label>
                        <input type="text" class="form-control" id="title" name="product[name]"
                               value="{{ old('product.name') }}">
                        @if($errors->has('product.name'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.name')) }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="option">{{translate('リサイクル品の状態')}}</label>
                        <select name="product[product_status]" id="option" class="form-control">
                            <option value="1" {{ old('product.product_status') == 1 ? 'selected' : '' }}>新品、未使用</option>
                            <option value="2" {{ old('product.product_status') == 2 ? 'selected' : '' }}>未使用に近い</option>
                            <option value="3" {{ old('product.product_status') == 3 ? 'selected' : '' }}>目立った傷や汚れなし
                            </option>
                            <option value="4" {{ old('product.product_status') == 4 ? 'selected' : '' }}>やや傷や汚れあり
                            </option>
                            <option value="5" {{ old('product.product_status') == 5 ? 'selected' : '' }}>傷や汚れあり</option>
                            <option value="6" {{ old('product.product_status') == 6 ? 'selected' : '' }}>全体的に状態が悪い
                            </option>
                        </select>
                        @if($errors->has('product.product_status'))
                            <div class="invalid-feedback"
                                 style="display:block;">{{ translate($errors->first('product.product_status')) }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="description">{{translate('詳細（サイズなど）')}}</label>
                        <textarea name="product[detail]" id="description"
                                  class="form-control">{{ old('product.detail') }}</textarea>
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
                    {{--<button data-href="{{route('front.mypage.index')}}" onclick="confirmBack($(this))"--}}
                            {{--data-text="{{translate('本気ですか？')}}" type="button"--}}
                            {{--class="btn-school">{{translate('削除する')}}</button>--}}
                </form>
            </div>
        </div>
    </div>
    {{--  Templates --}}
    <div class="template-input-image-capture" style="display:none;">
        <input class="image-input-file" type="file" accept="image/*" capture style="display:none;"></input>
    </div>
    <div class="template-input-image" style="display:none;">
        <input class="image-input-file" type="file" accept="image/*" style="display:none;"></input>
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
        function inputFactory(mocker, options) {
            var input = $($(mocker).html()).clone();
            var inputKlass = input.attr('class');

            return function appendTo(container) {
                var mostRecentElem = $(container + " ." + inputKlass + ":last-child");
                // Corner case: there are no image-input-file elem initially.
                var index = (1 === mostRecentElem.length) ? mostRecentElem.data('index') + 1 : 0;
                // Check for number of files.
                if ($(container + " ." + inputKlass).length >= options.numberOfFiles) {
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
                        // Clean up things if click to remove sign at this thumbnail.
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
                $('#btn-form-sent').removeClass('btn-grey');
                $('#btn-form-sent').prop('disabled', false);
            } else {
                $('#btn-form-sent').addClass('btn-grey');
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
