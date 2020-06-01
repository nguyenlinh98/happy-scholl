@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school recycle">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{URL::previous()}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('リサイクル')}}</h3>
                </div>
                <div class="calendar">
                    <div class="slide owl-carousel owl-theme">
                        @php
                            $listImg = $recycleProduct->getImageUrl()
                        @endphp
                        @if(empty($listImg))
                            <div class="item-i thumb-in-1">
                                <figure><img src="{{asset('images/front/thumb-reload.png')}}" alt="">
                                </figure>
                            </div>
                        @endif
                        @foreach($listImg as $img)
                            <div class="item-i thumb-in-1">
                                <figure><img src="{{$img}}" alt="">
                                </figure>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-r" style="text-align: justify">
                        <span>{{$recycleProduct->name}}</span>
                        <span class="text-center">{{translate('＜リサイクル品の状態＞')}}</span>
                        <span
                                class="text-center">{{translate(getProductStatus($recycleProduct->product_status))}}</span>
                        <span class="text-center">{{translate('＜詳細（サイズなど）＞')}}</span>
                        <div>
                            {{translate($recycleProduct->detail)}}
                        </div>
                        <p>{{translate('ご確認事項')}}</p>
                        <p>{{translate('万一紛失等で受取できなかった場合、')}}</p>
                        <p>{{translate('一切の責任を負いません。')}}</p>
                    </div>
                    @if($recycleProduct->status  == 1 && $recycleProduct->user_id != \Illuminate\Support\Facades\Auth::guard('parents')->user()->id)
                        <form action="{{route('front.recycle.apply',$recycleProduct->id)}}" method="POST">
                            @csrf
                            <div class="remember">
                                <label class="form-group form-check">
                                    <input type="checkbox" id="agree">
                                    <span class="checkmark"></span>
                                </label>
                                <label class="form-check-label" for="agree">{{translate('注意事項に同意して')}}
                                    <br/>{{translate('お申込みください。')}}</label>
                            </div>
                            <button type="button" id="btnAgree"
                                    class="btn-school margin-top-30 btn-grey">{{translate('申込み')}}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style>
        .btn-grey{
            background-color: #D1D2D2;
            border-color: #D1D2D2;
        }
    </style>
@endsection
@section('styles')
    <link href="{{url('css/front/calendar/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{url('css/front/calendar/owl.theme.default.min.css')}}" rel="stylesheet">
@endsection
@push('script')

    <script src="{{url('js/front/calendar/owl.carousel.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#agree').change(function () {
                let argee = $(this).prop('checked');
                if (argee) {
                    $('#btnAgree').attr('type', 'submit');
                }
            });
            $('#agree').on('change',function () {
                if($(this).prop('checked')){
                    $('#btnAgree').removeClass('btn-grey');
                }else{
                    $('#btnAgree').addClass('btn-grey');
                }
            });
        });
    </script>
@endpush
