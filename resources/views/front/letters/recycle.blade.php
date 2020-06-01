@extends('front.layouts.front')

@section('content')

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
                    <span class="text-t margin-top-30">{{translate('ゴミ箱')}}</span>
                    <div class="list-card">
                    <input type="hidden" name="student_id" id="student_id" value="{{$student_id}}">
                        @foreach($letters as $letter)
                                <div class="i-card @if($letter->read==1)seen @endif" data-read-status="{{$letter->letterStatus->read}}">
                                    <a href="{{route('front.letters.view', [$student_id, $letter->letter_id])}}">
                                    <h4>{{translate($letter->subject)}}</h4>
                                    <div class="description">
                                        <p>{{translate(showDateJP($letter->created_at))}}</p>
                                        <p>{{translate('配信者')}}：{{translate($letter->sender)}}</p>
                                        <img src="{{asset('images/front/cumeoto.png')}}" alt="">
                                    </div>
                                    <div class="list-btn">
                                        {{--<div class="text-btn"></div>--}}
                                        @if($letter->file && $letter->file_url)
                                            <a href="{{$letter->file_url}}"><div class="text-btn"></div></a>
                                        @endif
                                    </div>
                                    <button class="btn-login btn_click_delete" data-id="{{$letter->letter_id}}" id="btn_delete_{{$letter->letter_id}}">
                                    {{translate('ゴミ箱から全てのお手紙へ戻す')}}</button>
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


     $(".btn_click_delete").each(function() {
            $(this).on("click", function() {
                var id = $(this).attr('data-id');
                var student_id = $('#student_id').val();
                var id_btn = "#btn_delete_" + id;
                $.ajax({
                    url: '{{route('front.letter.removeLetterTrash')}}',
                    type: 'POST',
                    dataType: 'html',
                    data: {id: id, student_id: student_id},
                    success: function (rs) {
                        $(id_btn).parents()[0].remove();
                    }
                })
            });
        });
</script>
@endpush