@extends('front.layouts.front')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="select-school">
                <!-- NAVBAR -->
                <div class="nav-top">
                    <a href="{{route('front.contact.show',[$student->id,$student->id])}}" class="back-top"><img
                                src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                    <h3>{{translate('連絡網')}}</h3>
                </div>
                <div class="calendar list">
                    <form action="{{route('front.contact.save',[$student->id,$contact->id])}}" method="POST">
                        @csrf
                        <div class="title">{{translate(getSchoolName().$student->schoolClass->name)}}</div>
                        <h2 class="margin-top-30">{{translate('電話番号の変更')}}</h2>
                        <div class="form-group">
                            <label for="desc">{{translate('新しい電話番号を入力してください')}}</label>
                            <input type="text" name="tel" value="{{$contact->tel}}" id="desc"
                                   class="form-control valid-phone-number"
                                   oninput="validPhoneNumber(this, {{ json_encode($translation) }})">
                            <div class="valid-phone text-danger" style="text-align:left; font-size: 80%;">
                                <span>{{ translate('ハイフンなしで入力してください。') }}</span>
                            </div>
                            <div class="invalid-feedback valid-phone-msg" style="text-align:left"></div>
                        </div>
                        <button class="btn-login margin-top-30">{{translate('送信')}}</button>
                    </form>
                    <form action="{{route('front.contact.delete',[$student->id,$contact->id])}}" method="POST">
                        @csrf
                        @method('delete')
                        <h2 class="margin-top-50">{{translate('連絡網から削除')}}</h2>
                        <button class="btn-exit">{{translate('登録情報を削除する')}}</button>
                    </form>
                </div>
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
