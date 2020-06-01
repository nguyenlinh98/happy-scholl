@extends('layouts.topadmin')
@section('content')
    @if(session('action'))
        @includeIf('admin.message.action.' . session('action'))
    @endif

        <div class="form--body bg-form px-3 pt-1 pb-4">

            {{-- <div class="row pb-5 pt-5">
                <button style="position: absolute; right: 100px; background-color: #006db9!important; color: white; padding: 10px 50px; border-radius: 50px; outline: none">業者一覧</button>
            </div> --}}
            <form id="formCalendar" method="POST" action="{{route('top_admin.calendar.edit_calendar.update',['id'])}}" enctype="multipart/form-data" class="form--common" style="min-height: auto;">
                @csrf
                <div class="row">
                    <div class="form-group col-2">
                        <label for="">　</label>
                        <select class="form-control-calendar-topadmin" id="selectElementId" name="year" onchange="showTitle(this.value)">
                            <option value=""></option>
                            @foreach($detail as $key =>$event)
                                <option value="{{$key}}">{{$event['date']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-5">
                        <label for="">入力項目</label>
                             <input class="form-control-calendar-topadmin" id="inputTitleId" type="text" name="title" value="">
                             <input class="form-control-calendar-topadmin" id="inputEditId" type="hidden" name="id" value="">

                        @foreach($detail as $key => $event)
                            <input id="inputTitleIdHidden{{$key}}" type="hidden" name="subject" value="{{$event['title']}}">
                            <input id="inputTitleIdHiddenEdit{{$key}}" type="hidden" name="subject" value="{{$event['id']}}">
                        @endforeach
                    </div>
                    <div class="col-5" style="padding-top: 30px;">
                        <button type="button" class="btn-submit" style="background-color: #006db9!important; color: white; padding: 8px 50px;">上書</button>
                        <button type="button" class="btn-danger btn-delete" style="color: white; padding: 8px 50px; margin-left: 25px">削除</button>
                    </div>
                </div>
            </form>
        </div>
    <div class="modal modal-topadmin-formsubmit text-center" id="dialog-confirm" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <h3 style="color: white">この内容で更新してよろしいですか？</h3>
        <button type="button" class="btn btn-link btn-danger mt-4" id="submitFormEditCalendar" style="color: white; padding: 5px 50px; font-size: 25px; border-radius: 50px">はい
        </button>
        <button type="button" class="btn btn-link btn-primary mt-4 ml-4" id="cancleFormResetPassword" style="color: white; padding: 5px 50px; font-size: 25px; border-radius: 50px">いいえ
        </button>
    </div>
    <script>
        function showTitle(str) {
            $checkdate = $('#inputTitleIdHidden' + str).val();
            $getId = $('#inputTitleIdHiddenEdit' + str).val();
            $('#inputTitleId').val($checkdate);
            $('#inputEditId').val($getId);
            $('.btn-submit').click(function () {
                $('#dialog-confirm').show();
                $('#submitFormEditCalendar').click(function () {
                    $action = $('#formCalendar').attr('action');
                    $action = $action.replace('id', $getId);
                    $("#formCalendar").attr('action',$action);
                    $('#formCalendar').submit();
                });
                $('#cancleFormResetPassword').click(function () {
                    $('#dialog-confirm').hide();
                })
            });
            $('.btn-delete').click(function () {
                $('#dialog-confirm').show();
                $('#submitFormEditCalendar').click(function () {
                    $action = $('#formCalendar').attr('action');
                    $action = $action.replace('id', $getId);
                    $action = $action.replace('update', 'destroy');
                    $("#formCalendar").attr('action',$action);
                    $('#formCalendar').submit();
                });
                $('#cancleFormResetPassword').click(function () {
                    $('#dialog-confirm').hide();
                })
            })
        }
    </script>
@endsection

