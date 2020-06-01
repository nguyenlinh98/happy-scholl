@extends('layouts.topadmin')
@section('content')
    @if(session('action'))
        @includeIf('admin.message.action.' . session('action'))
    @endif

        <div class="form--body bg-form px-3 pt-1 pb-4">
            <div class="row pb-5 pt-5">
                <a href="{{route('top_admin.calendar.edit_calendar')}}">
                    <button style="position: absolute; right: 100px; background-color: #006db9!important; color: white; padding: 10px 50px; border-radius: 50px; outline: none">祝日設定編集</button>
                </a>
            </div>
            <form method="POST" action="{{route('top_admin.calendar.create')}}" enctype="multipart/form-data" class="form--common" style="min-height: auto;">
                @csrf
                @for($i = 0; $i<=5; $i ++)
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="">年</label>
                            <select class="form-control-calendar-topadmin" id="selectElementId{{$i}}" name="year{{$i}}"></select>
                        </div>

                        <div class="form-group col-2 ">
                            <label for="">月</label>
                            <select class="form-control-calendar-topadmin" id="selectMonthElementId{{$i}}" name="month{{$i}}"></select>
                        </div>
                        <div class="form-group col-2 ">
                            <label for="">日</label>
                            <select class="form-control-calendar-topadmin" id="selectDateElementId{{$i}}" name="date{{$i}}"></select>
                        </div>
                        <div class="form-group col-6 ">
                            <label for="">入力項目</label>
                            <input class="form-control-calendar-topadmin" type="text" name="subject{{$i}}">
                        </div>
                    </div>
                @endfor
                <div class="text-center">
                    <button type="submit" class="btn-danger"
                            style="padding: 0px 50px; color: white; border-radius: 50px; font-size: 24px">登録する
                    </button>
                </div>
            </form>
        </div>

  <script !src="">
      for (var k = 0; k <= 5; k++) {
          var min = new Date().getFullYear(),
              max = min + 10,
              selectYear = document.getElementById('selectElementId' + k);
          selectMonth = document.getElementById('selectMonthElementId'+ k);
          selectDate = document.getElementById('selectDateElementId'+ k);

        var blankOption = document.createElement('option');
        blankOption.value = '';
        blankOption.innerHTML = '';

        selectYear.appendChild(blankOption);
        for (var i = min; i <= max; i++) {
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = i;
            selectYear.appendChild(opt);
        }

        blankOption = document.createElement('option');
        blankOption.value = '';
        blankOption.innerHTML = '';
        selectMonth.appendChild(blankOption);
        for (var m = 1; m <= 12; m++) {
            var optMonth = document.createElement('option');
            if (m < 10) {
                optMonth.value = '0' + m;
                optMonth.innerHTML = '0' + m;
            } else {
                optMonth.value = m;
                optMonth.innerHTML = m;
            }
            selectMonth.appendChild(optMonth);
        }

        blankOption = document.createElement('option');
        blankOption.value = '';
        blankOption.innerHTML = '';
        selectDate.appendChild(blankOption);
        for (var d = 1; d <= 31; d++) {
            var optDay = document.createElement('option');
            if (d < 10) {
                optDay.value = '0' + d;
                optDay.innerHTML = '0' + d;
            } else {
                optDay.value = d;
                optDay.innerHTML = d;
            }
            selectDate.appendChild(optDay);
        }
    }
    </script>
@endsection

