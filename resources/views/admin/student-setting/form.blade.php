
@component('components.form')
    @slot('header')
    <h1 class="page-title">お子様の追加</h1>
    @endslot
    @slot('action', route('admin.student_setting.store'))

    @input([
        "for" => "student",
        "value" => $schoolClass->name,
        "name" => "school_class_name",
        "type" => "input",
        //"options" => hsp_school()->schoolClasses->mapWithKeys(function ($item) { return [$item->id => $item->name]; }),
        "extra" => " disabled "
    ])
    @input([
        "for" => "student",
        "value" => $schoolClass->id,
        "name" => "school_class_id",
        "type" => "hidden",
    ])

    <div class="form-group {{$groupClass ?? ''}}">
        <label for="">お子様</label> <span>&nbsp;&nbsp;※姓と名の間にスペースを入れてください。</span>
        <input class="form-control" name="name" type="text" value="{{old('name') ?? ''}}">
        @if ($errors->any())
            @foreach ($errors->get('name') as $message)
            <div class="">
                <ul>
                    <li style="color: red">{{$message}}</li>
                </ul>
            </div>
            @endforeach
        @endif
    </div>


    <div class="form-group {{$groupClass ?? ''}}">
        <label for="">セイ</label> <span>&nbsp;&nbsp;（フリガナ）※カタカナでご入力ください。</span>
        <input class="form-control" name="first_name" type="text" value="{{old('first_name') ?? ''}}">
        @if ($errors->any())
            @foreach ($errors->get('first_name') as $message)
            <div class="">
                <ul>
                    <li style="color: red">{{$message}}</li>
                </ul>
            </div>
            @endforeach
        @endif
    </div>

    <div class="form-group {{$groupClass ?? ''}}">
        <label for="">メイ</label> <span>&nbsp;&nbsp;（フリガナ）※カタカナでご入力ください。</span>
        <input class="form-control" name="last_name" type="text" value="{{old('last_name') ?? ''}}">
        @if ($errors->any())
            @foreach ($errors->get('last_name') as $message)
            <div class="">
                <ul>
                    <li style="color: red">{{$message}}</li>
                </ul>
            </div>
            @endforeach
        @endif
    </div>
    @input([
        "for" => "student",
        "value" => old('gender'),
        "name" => "gender",
        "type" => "select",
        "options" => ['1' => '男', '0' => '女'],
    ])
@endcomponent

