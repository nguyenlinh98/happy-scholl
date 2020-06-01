<?php
$option_functions = hsp_getConfig('option_functions');
?>

@extends('layouts.app')
@section('content')

    <div class="container-fluid menu-home">
        <div class=row-fluid>
            <main style="" role=main class="">

                <div class="row">

                    <div class="col-md-10">
                        <div
                            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                            <h2 class="page-title">{{ hsp_title() }}</h2>
                            <div class="btn-toolbar mb-2 mb-md-0" id=toolbar>
                                <div class="btn-group mr-2" id=toolbar-table-buttons>
                                </div>
                            </div>
                        </div>
                        <div class="" style="background-color: #56adaf; color: white; padding: 10px">
                            <p class="m-0 p-0">ハピスクメニュー設定</p>
                        </div>
                        <p class="pt-1">必要な機能を選んでください <br>
                            選択された内容が、アプリケーションメニューに反映されます</p>
                        @foreach($option_functions as $function)
                            @php $setting_column = $function['column']; @endphp
                            <form method="post" id="form-school{{$setting_column}}" action="{{route('admin.school_setting.update',[$schoolSetting->id])}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="{{$setting_column}}" id="{{$setting_column}}">
                                <label class="switch switch-fix">
                                    <input class="pl-0" type="checkbox" id="{{$setting_column}}_org"  {{$schoolSetting->$setting_column == 1 ? 'checked' :''}} onclick="switchbtn('{{$setting_column}}')">
                                    <span class="slider round"></span>
                                </label>
                                <span style="width: 70px;display: inline-block;">{{$schoolSetting->$setting_column == 1 ? 'ON' :'OFF'}}</span>
                                <span>{{$function['text']}}</span>
                                @if($setting_column == 'recycle_active')
                                    <span style="color: red">&nbsp;&nbsp;&nbsp;※リサイクルの管理ページにある、受取り指定場所を必ずご記入ください</span>
                                @endif
                                @if($setting_column == 'letter_individual_active')
                                    <span style="color: red">&nbsp;&nbsp;&nbsp;※お手紙メニューの中の「個別のお手紙」のON/OFF 設定ができます。</span>
                                @endif
                                @if($setting_column == 'urgent_contact_active')
                                    <span style="color: red">&nbsp;&nbsp;&nbsp;※右上上部の「緊急連絡ボタン」のON/OFF 設定ができます。</span>
                                @endif
                            </form>
                            <br>
                        @endforeach
                    </div>

                </div>
            </main>
        </div>
    </div>
    <script>
        function switchbtn(column) {
            if($('#'+column).is(":checked")) {
                $('#'+column).val(1);
            } else {
                $('#'+column).val(0);
            }
            $('#form-school'+column).submit();
        }
    </script>
@endsection
