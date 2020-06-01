@extends('front.layouts.front')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{url()->previous()}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('お手紙')}}</h3>
                </div>
                <div class="calendar letter">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="card-detail">
                        <h4>{{translate($letter->subject)}}</h4>
                        <p>{{translate(showDateJP($letter->created_at))}}</p>
                        <p>{{translate('配信者')}}：{{translate($letter->sender)}}</p>
                        <div class="text">{{translate($letter->body)}}</div>
                        <div class="list-btn">
                            @if($letter->file && $letter->file_url)
                                <a href="{{$letter->file_url}}">
                                    <div class="text-btn"></div>
                                </a>
                            @else
                                <div class="text-btn" style="opacity: 0;"></div>
                            @endif
                            @if(isset($letter->favorist_flag) && $letter->favorist_flag == 1)
                                <div id="btn_favourite" class="like-btn liked btn_click_favourite"
                                     data-type="{{$letter->favorist_flag}}" data-id="{{$letter->id}}">
                                    <span>{{translate('お気に入り')}}</span>
                                </div>
                            @else
                                <div id="btn_favourite" class="like-btn btn_click_favourite"
                                     data-type="{{$letter->favorist_flag}}" data-id="{{$letter->id}}">
                                    <span>{{translate('お気に入り')}}</span>
                                </div>
                            @endif
                            @if($letter->deleted_at =='')
                                <div id="btn_delete" class="trash-btn btn_click_delete"
                                     data-id="{{$letter->letter_id}}"></div>
                            @endif
                        </div>
                        <a href="{{url()->previous()}}">
                            <button class="btn-school">{{translate('一覧画面へ戻る')}}</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card-detail .list-btn .like-btn span{
            word-break: initial;
            overflow: initial;
            line-height: 45px;
            left: 50px;
            width: calc(100% - 50px);
        }
        .card-detail .list-btn .like-btn{
            background-size: 29%;
        }
        @if(Session::get('lang') && Session::get('lang')=='en')
        .card-detail .list-btn .like-btn span {
            word-break: initial;
            overflow: initial;
            line-height: 40px;
            left: 56px;
        }
        @endif
    </style>
@endsection

@push('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".btn_click_favourite").on("click", function () {
            var type = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            var id_btn = "#btn_favourite";
            $.ajax({
                url: '{{route('front.letter.updateLetterType')}}',
                type: 'POST',
                dataType: 'html',
                data: {
                    type: type,
                    id: id
                },
                success: function (rs) {
                    var obj = $.parseJSON(rs);
                    $(id_btn).attr("data-type", obj.receiver_type_update);
                    if (obj.receiver_type_update == 1) {
                        $(id_btn).addClass("liked");
                    } else {
                        $(id_btn).removeClass("liked");
                    }
                }
            })
        });

        $(".btn_click_delete").on("click", function () {
            var id = $(this).attr('data-id');
            var id_btn = "#btn_delete";
            $.ajax({
                url: '{{route('front.letter.deleteLetter')}}',
                type: 'POST',
                dataType: 'html',
                data: {
                    id: id
                },
                success: function (rs) {
                    $(id_btn).parents()[1].remove();
                }
            })
        });
    </script>
@endpush