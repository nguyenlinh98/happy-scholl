@extends('layouts.app')
@section('content')
<header class="row mb-4 mr-0 ml-0">
    <div class="col-sm-12 col-md-9">
        <h2 class="page-title">{{$requireFeedback->subject}}</h2>
        <span>{{$requireFeedback->body}}</span>
        <h4 class="font-weight-bolder">回答削除日：{{date_format($requireFeedback->clean_up_at, "Y-m-d") }}</h4>
        <h4 class="font-weight-bolder">回答者数： <span style="border: 1px solid; padding: 0px 20px">{{$countStudent}}</span></h4>
        @include("components.search", [])
    </div>

</header>

<div class="row mr-0 ml-0">
    <div class="col-sm-12 col-md-9">
        <div class="float-right mb-2">
            <?php
            $options = [
                'all' => '全て',
                'ok' => '〇 のみ',
                'ng' => '✖ のみ',
                'notyet'=> '末回答者のみ',
                'okorng' => '回答者のみ'
            ];
            ?>
            <div class="row-search-search float-right" data-controller="datatable-search" @isset($table_id) data-datatable-search-identifier="letters_table" @endisset @isset($columns) data-datatable-search-columns="destination,title" @endisset>
                <p class="btn-search-title mb-0 font-weight-bold ml-16">{{$title ?? 'キーワード検索'}}</p>
                <div class="dataTable-search dataTable-input-letter ml-16">
                    <form method="get" action="{{route('admin.require_feedback.class', [$requireFeedback, $schoolClass])}}">
                        {{-- @csrf --}}
                        <select class="form-search-select dataTable-input table-search-input" id="idDataTableSearchbox" name="show" data-target="datatable-search.input">
                            @isset($options)
                                @foreach ($options as $key => $value)
                                    @if(request()->query('show', 'all') === $key)
                                        <option value="{{$key}}" selected="selected">{{$value}}</option>
                                    @else
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endif
                                @endforeach
                            @endisset
                        </select>
                        <button class="btn-search-submit" type="submit">検索</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mr-0 ml-0">
    <div class="col-sm-12 col-md-9">
        <table class="table datatable" id="require_feedbacks_table" data-controller="datatable">
            <thead>
                <tr>
                    <th class="datatable--header--cell">クラス</th>
                    <th class="datatable--header--cell">生徒名</th>
                    <th class="datatable--header--cell">回答</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($requireFeedback->statuses as $readStatus)
                    @if(request()->query('show', 'all') === 'okorng')
                        @if($readStatus->status === 'ok' || $readStatus->status === 'ng')
                            <tr>
                                <td>{{$schoolClass->name}}</td>
                                <td>{{$readStatus->student->name}}</td>
                                <td>
                                    <div class="registration-status ">
                                        @if($readStatus->status == 'ok')
                                            〇
                                        @elseif($readStatus->status == 'ng')
                                            ✖
                                        @else
                                            ー
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @elseif(request()->query('show', 'all') === 'all' || request()->query('show') === $readStatus->status)
                        <tr>
                            <td>{{$schoolClass->name}}</td>
                            <td>{{$readStatus->student->name}}</td>
                            <td>
                                <div class="registration-status ">
                                    @if($readStatus->status == 'ok')
                                        〇
                                    @elseif($readStatus->status == 'ng')
                                        ✖
                                    @else
                                        ー
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="hidden-sm col-md-3">
    </div>
</div>
@endsection
