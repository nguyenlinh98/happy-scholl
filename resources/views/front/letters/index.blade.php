@extends('front.layouts.front')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('お手紙')}}</h3>
                </div>
                <div class="calendar letter">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <div class="list-btn">
                        <button class="btn-school ahref"
                                data-href="{{route('front.letters.index',$student_id)}}">{{translate('全てのお手紙')}}</button>
                        <button class="btn-school ahref"
                                data-href="{{route('front.letters.index',[$student_id,'favorite'])}}"><img
                                    src="{{asset('images/front/heart.png')}}" alt=""><span>{{translate('お気に入り')}}</span>
                        </button>
                        <button class="btn-school ahref"
                                data-href="{{route('front.letters.index',[$student_id,'recycle'])}}"><img
                                    src="{{asset('images/front/trash.png')}}" alt=""></button>
                    </div>
                    <div class="list-card">
                        @foreach($letters as $letter)
                            <div class="i-card @if($letter->read==1)seen @endif" data-read-status="{{$letter->read}}">
                                <a href="{{route('front.letters.view', [$student_id, $letter->letter_id])}}">
                                    <h4>{{translate($letter->subject)}}</h4>
                                    <div class="description">
                                        <p>{{translate(showDateJP($letter->created_at))}}</p>
                                        <p>{{translate('配信者')}}：{{translate($letter->sender)}}</p>
                                        <img src="{{asset('images/front/teacher_image.png')}}" alt="">
                                    </div>
                                </a>
                                <div class="list-btn">
                                    @if($letter->file && $letter->file_url)
                                        <a href="{{$letter->file_url}}">
                                            <div class="text-btn"></div>
                                        </a>
                                    @endif
                                    @if(isset($letter->favorist_flag) && $letter->favorist_flag == 1)
                                        <div id="btn_favourite_{{$letter->id}}"
                                             class="like-btn liked btn_click_favourite"
                                             data-type="{{$letter->favorist_flag}}" data-id="{{$letter->id}}"></div>
                                    @else
                                        <div id="btn_favourite_{{$letter->id}}" class="like-btn btn_click_favourite"
                                             data-type="{{$letter->favorist_flag}}" data-id="{{$letter->id}}"></div>
                                    @endif
                                    <div data-id="{{$letter->letter_id}}"
                                         id="btn_delete_{{$letter->letter_id}}"
                                         class="trash-btn btn_click_delete"
                                         data-deleted_at="{{$letter->deleted_at}}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .i-card.seen {
            background: #CBCCCC;
        }

    </style>
@endsection

@push('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // $(".i-card").each(function() {
        //     var data_status = $(this).attr('data-read-status');
        //     if(data_status == 1) $(this).css('opacity','0.6');
        // });
        $(".btn_click_favourite").each(function () {
            $(this).on("click", function () {

                var type = $(this).attr('data-type');
                var id = $(this).attr('data-id');
                var id_btn = "#btn_favourite_" + id;
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
                            {{--$(id_btn).css('background-image', "none !important");--}}
                            {{--$(id_btn).css('background-image', "{{asset('front/images/heart.png')}}");--}}
                        } else {
                            $(id_btn).removeClass("liked");

                            // $(id_btn).css('background-image', "none !important");
                            {{--$(id_btn).css('background-image', "{{asset('front/images/heart-n.png')}}");--}}
                        }
                    }
                })
            });
        });

        $(".btn_click_delete").each(function () {
            $(this).on("click", function () {
                var id = $(this).attr('data-id');
                var data_deleted_at = $(this).attr('data-deleted_at');
                var id_btn = "#btn_delete_" + id;
                $.ajax({
                    url: '{{route('front.letter.deleteLetter')}}',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        id: id,
                        data_deleted_at: data_deleted_at
                    },
                    success: function (rs) {
                        $(id_btn).parents()[1].remove();
                    }
                })
            });
        });
    </script>
@endpush
