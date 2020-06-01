@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    @if(isset($contactOfCurrentStudent)&&count($contactOfCurrentStudent)==0)
                        <a href="{{route('front.mypage.index')}}" class="back-top"><img
                                    src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                        <h3>{{translate('連絡網')}}</h3>
                    @else
                        <a href="{{route('front.contact.show',[$studentId,$studentId])}}" class="back-top"><img
                                    src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                        <h3>{{translate('連絡網')}}</h3>
                    @endif

                </div>
                <form action="{{route('front.contact.complete',$studentId)}}" method="POST">
                    @csrf
                    <div class="calendar list">
                        <div class="title">{{translate(getSchoolName())}}</div>
                        <div class="form-group">
                            <label for="desc">{{translate('電話番号を入力してください')}}</label>
                            <input type="text" name="tel" value="{{ old('tel') }}" id="desc" class="form-control valid-phone-number"
                                   oninput="validPhoneNumber(this, {{ json_encode($translation) }})">
                             <div class="valid-phone text-danger" style="text-align:left; font-size: 80%;">
                                 <span>{{ translate('ハイフンなしで入力してください。') }}</span>
                             </div>
                            <div class="invalid-feedback valid-phone-msg" style="text-align:left">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="option">{{translate('属性を選択してください')}}</label>
                            <select name="relationship" id="option" class="form-control">
                                <option value="父">{{translate('父')}}</option>
                                <option value="母">{{translate('母')}}</option>
                                <option value="叔父">{{translate('叔父')}}</option>
                                <option value="叔母">{{translate('叔母')}}</option>
                                <option value="祖父">{{translate('祖父')}}</option>
                                <option value="祖母">{{translate('祖母')}}</option>
                                <option value="その他">{{translate('その他')}}</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn-login margin-top-30">{{translate('送信')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            @if($errors->has('tel'))
            $('.valid-phone-number').addClass('is-invalid');
            $('.valid-phone-msg').html("{{ $errors->first('tel') }}");
            @endif
        });
    </script>
@endpush
