<form method="POST" action="{{ route('admin.recycle_place.store') }}" class="pt-2">
    @csrf
    <div class="form-row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group {{ $errors->has('recycle_place_name') ? 'is-invalid' : '' }}">
                <label class="h5 text-danger">【必ずご記入ください】受取り指定場所（図書室・先生名・住所など）</label>
                <input class="form-control form-control-lg {{ $errors->has('recycle_place_name') ? 'is-invalid' : '' }}" type="text" name="recycle_place_name" value="{{ old('recycle_place_name', $recyclePlace->place) }}">
                @includeWhen($errors->has('recycle_place_name'), 'components.form-error', ["name" => 'recycle_place_name'])
                    <h5 class="pt-1">場所の変更は、新たにご入力いただくと、上書きされます。</h5>
            </div>

        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <label for="" class="h5">平日・土日祝</label>
                <select class="custom-select custom-select-lg {{ $errors->has('recycle_place_date') ? 'is-invalid' : '' }}" name="recycle_place_date">
                    @if(is_null(old('recycle_place_date, $recyclePlace->date')))
                        <option selected></option>
                    @endif
                    <option {{ old("recycle_place_date", $recyclePlace->date) === "平日" ? 'selected' : "" }} value="平日">平日</option>
                    <option {{ old("recycle_place_date", $recyclePlace->date) === "平日・土曜" ? 'selected' : "" }} value="平日・土曜">平日・土曜</option>
                    <option {{ old("recycle_place_date", $recyclePlace->date) === "土曜・日曜・祝日" ? 'selected' : "" }} value="土曜・日曜・祝日">土曜・日曜・祝日</option>
                    <option {{ old("recycle_place_date", $recyclePlace->date) === "日曜・祝日" ? 'selected' : "" }} value="日曜・祝日">日曜・祝日</option>
                    <option {{ old("recycle_place_date", $recyclePlace->date) === "全日" ? 'selected' : "" }} value="全日">全日</option>
                </select>
                @includeWhen($errors->has('recycle_place_date'), 'components.form-error', ["name" => 'recycle_place_date'])
            </div>
        </div>
        <div class="col-sm-12 col-md-1">
            <div class="form-group">
                <label for="recycles_table_search" class="h5">時間</label>
                <div class="d-flex frame-args {{ $errors->has('recycle_place_start_time') ? 'is-invalid' : '' }}">
                    <select class="custom-select custom-select-lg {{ $errors->has('recycle_place_start_time') ? 'is-invalid' : '' }}" name="recycle_place_start_time">
                        @if(is_null(old('recycle_place_start_time', $recyclePlace->start_time)))
                            <option selected></option>
                        @endif
                        @foreach(hsp_time_generator(1800) as $time)
                            <option @if(old('recycle_place_start_time', $recyclePlace->start_time)===$time) selected="selected" @endif value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>
                    {{-- <h4 class="d-sm-none d-sm-inline-block pl-2 pt-2">〜</h4> --}}
                </div>
                @includeWhen($errors->has('recycle_place_start_time'), 'components.form-error', ["name" => 'recycle_place_start_time'])
            </div>

        </div>
        <div class="col-sm-12 col-md-auto align-middle">
            <br>
            <span style=""><h4 class="d-sm-none d-sm-inline-block pl-2 pt-3">〜</h4></span>
        </div>
        <div class="col-sm-12 col-md-1">
            <div class="form-group">
                <label for="recycles_table_search" class="h5">&nbsp;</label>
                <select class="custom-select custom-select-lg {{ $errors->has('recycle_place_end_time') ? 'is-invalid' : '' }}" name="recycle_place_end_time">
                    @if(is_null(old('recycle_place_end_time', $recyclePlace->end_time)))
                        <option selected></option>
                    @endif
                    @foreach(hsp_time_generator(1800) as $time)
                        <option @if(old('recycle_place_end_time', $recyclePlace->end_time)===$time) selected="selected" @endif value="{{ $time }}">{{ $time }}</option>
                    @endforeach
                </select>
                @includeWhen($errors->has('recycle_place_end_time'), 'components.form-error', ["name" => 'recycle_place_end_time'])
            </div>
        </div>
        <div class="col-sm-12 col-md-1">
            <div class="form-group">
                <label for="" class="h4">&nbsp;</label>
                <div class="form-group">
                    <button type="submit " class="btn btn-secondary py-2">
                        <span class="h4 p-2">設定</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
