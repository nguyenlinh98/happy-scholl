@extends('front.layouts.front')

@section('content')
    {{--@php($letters = [1,2,3,4])--}}
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.letters.index',$student_id)}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('お手紙')}}</h3>
                </div>
                <div class="calendar letter">
                    <div class="title">{{translate(getSchoolName())}}</div>
                    <span class="text-t margin-top-30">{{translate('お気に入り')}}</span>
                    <div class="list-card">
                    @if($letters)
                        @foreach($letters as $letter)
                                <div class="i-card @if($letter->read==1)seen @endif" data-read-status="{{$letter->read}}">
                                    <a href="{{route('front.letters.view', [$student_id, $letter->letter_id])}}">
                                    <h4>{{translate($letter->subject)}}</h4>
                                    <div class="description">
                                        <p>{{translate(showDateJP($letter->created_at))}}</p>
                                        <p>{{translate('配信者')}}：{{translate($letter->sender)}}</p>
                                        <img src="{{asset('images/front/cumeoto.png')}}" alt="">
                                    </div>
                                    <div class="list-btn">
                                    @if($letter->file && $letter->file_url)
                                        <a href="{{$letter->file_url}}"><div class="text-btn"></div></a>
                                    @endif
                                        {{--<div class="text-btn"></div>--}}
                                        <div data-id="{{$letter->letter_id}}"
                                            id="btn_delete_{{$letter->letter_id}}"
                                            class="trash-btn btn_click_delete"></div>
                                    </div>
                                    <button id="btn_click_favourite_{{$letter->id}}" data-id="{{$letter->id}}" class="btn-login btn_click_favourite">{{translate('お気に入り登録を外す')}}</button>
                                </div>
                        @endforeach
                     @endif
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

    $(".btn_click_favourite").each(function() {
        $(this).on("click", function() {
            var id = $(this).attr('data-id');
            var id_btn = "#btn_click_favourite_" + id;
            $.ajax({
                url: '{{route('front.letter.removeLetterFavorite')}}',
                type: 'POST',
                dataType: 'html',
                data: {id: id},
                success: function (rs) {
                   $(id_btn).parents()[0].remove();
                }
            })
        });
    });

    $(".btn_click_delete").each(function() {
        $(this).on("click", function() {
            var id = $(this).attr('data-id');
            var id_btn = "#btn_delete_" + id;
            $.ajax({
                url: '{{route('front.letter.deleteLetter')}}',
                type: 'POST',
                dataType: 'html',
                data: {id: id},
                success: function (rs) {
                    $(id_btn).parents()[1].remove();
                }
            })
        });
    });
</script>
@endpush