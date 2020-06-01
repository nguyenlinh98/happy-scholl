@extends('layouts.topadmin')
@section('content')
    @if(session('action'))
        @includeIf('admin.message.action.' . session('action'))
    @endif
    <form method="POST" action="{{route('top_admin.setting.reset_password')}}" enctype="multipart/form-data" class="form--common" style="min-height: auto;" id="formResetPasswordTopAdmin">
        @csrf
        <div class="form--body bg-form px-3 pt-1 pb-4">

            <div class="pt-5 title-form-setting">
                <h4>現在の ID とパスワードを入力してください</h4>
            </div>

            <div class="form-group-form-setting row pt-4">
                
                <div class="col-md-3">
                    <label for="email" class="col-md-2 col-form-label text-md-right font-weight-bold field-name fs-form-setting text-center">ID</label>
                </div>
                <div class="col-md-8">
                    <input id="email" type="email" class="form-control fs-form-setting form-control-fix @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @if ($errors->any())
                        @foreach ($errors->get('email') as $message)
                            <div class="">
                                <ul>
                                    <li style="color: red">{{$message}}</li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group-form-setting row pt-4">
                
                <div class="col-md-3">
                    <label for="password" class="col-form-label fs-form-setting text-md-right font-weight-bold field-name">パスワード</label>
                </div>
                <div class="col-md-8">
                    <input id="password" type="password" class="form-control fs-form-setting @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @if ($errors->any())
                        @foreach ($errors->get('password') as $message)
                            <div class="">
                                <ul>
                                    <li style="color: red">{{$message}}</li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="form--body bg-form bg-form-top-admin px-3 pt-1 pb-4 mt-2">
            <div class="pt-5 title-form-setting">
                <h4>新しい ID とパスワードをご入力ください</h4>
            </div>

            <div class="form-group-form-setting row pt-4">
                <div class="col-md-3">
                    <label for="email-confirm" class="col-form-label fs-form-setting text-md-right font-weight-bold field-name">ID</label>
                </div>
                <div class="col-md-8">
                    <input id="new-email" type="email" class="form-control fs-form-setting form-control-fix @error('email') is-invalid @enderror" name="new_email" value="{{ old('new_email') }}" required autocomplete="new-email">
                    @if ($errors->any())
                        @foreach ($errors->get('new-email') as $message)
                            <div class="">
                                <ul>
                                    <li style="color: red">{{$message}}</li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group-form-setting row pt-4">
                <div class="col-md-3">
                    <label for="password-confirm" class="col-form-label fs-form-setting text-md-right font-weight-bold field-name">パスワード</label>
                </div>
                <div class="col-md-8">
                    <input id="new-password" type="password" class="form-control fs-form-setting @error('password') is-invalid @enderror" name="new_password" required autocomplete="new-password">
                    @if ($errors->any())
                        @foreach ($errors->get('new-password') as $message)
                            <div class="">
                                <ul>
                                    <li style="color: red">{{$message}}</li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <br><br>
            <div class="form-group-form-setting row pt-4">
                <div class="col-md-3">
                    <label for="email" class="col-form-label fs-form-setting text-md-right font-weight-bold field-name">ID</label>
                </div>
                <div class="col-md-8">
                    <input id="email-confirm" type="email" class="form-control fs-form-setting form-control-fix @error('email') is-invalid @enderror" name="email_confirm" value="{{ old('email_confirm') }}" required autocomplete="email-confirm">
                 @if ($errors->any())
                        @foreach ($errors->get('email-confirm') as $message)
                            <div class="">
                                <ul>
                                    <li style="color: red">{{$message}}</li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="form-group-form-setting row pt-4">
                <div class="col-md-3">
                    <label for="password-confirm" class="col-form-label fs-form-setting text-md-right font-weight-bold field-name">パスワード</label>
                </div>
                <div class="col-md-8">
                    <input id="password-confirm" type="password" class="form-control fs-form-setting @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                 @if ($errors->any())
                        @foreach ($errors->get('password-confirm') as $message)
                            <div class="">
                                <ul>
                                    <li style="color: red">{{$message}}</li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="topadmin-school text-center">
                <button type="button" class="btn btn-link btn-danger mt-4" style="color: white; padding: 5px 20px; font-size: 18px; border-radius: 50px" onclick="showDialogConfirm()">この内容で ID とパスワードを更新する</button>
            </div>
        </div>

    </form>
    <div class="modal modal-topadmin-formsubmit text-center" id="dialog-confirm" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <h3 style="color: white">この内容で更新してよろしいですか？</h3>
        <button type="button" class="btn btn-link btn-danger mt-4" id="submitFormResetPassword" style="color: white; padding: 5px 50px; font-size: 25px; border-radius: 50px">はい
        </button>
        <button type="button" class="btn btn-link btn-primary mt-4 ml-4" id="cancleFormResetPassword" style="color: white; padding: 5px 50px; font-size: 25px; border-radius: 50px">いいえ
        </button>
    </div>
    <script !src="">
        function showDialogConfirm() {
            $('#dialog-confirm').show();
            $('#submitFormResetPassword').click(function () {
                    $('#formResetPasswordTopAdmin').submit();
            });
            $('#cancleFormResetPassword').click(function () {
                $('#dialog-confirm').hide();
            })
        }
    </script>
@endsection

