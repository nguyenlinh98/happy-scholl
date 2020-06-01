<div class="bg-primary py-4">
    <h1 class="text-white text-center">お子様コードの発行</h1>
    <div class="w-50 mx-auto mt-4">
        <form method="POST" action="{{ route('admin.class.passcode', $class) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="col-6">
                    <div class="h5 py-2 text-center" style="background: #DADBDB;" aria-label="クラス名: 列を昇順に並べ替えるにはアクティブにする">クラス</div>
                </div>
                <div class="col-6">
                    <div class="h5 py-2 text-center" style="background: #DADBDB;">お子様</div>
                </div>
                <div class="col-6">
                    <div class="h5 py-2 text-center" style="background: #DADBDB;">{{ $class->name }}</div>
                </div>
                <div class="col-6">
                    <select class="form-control" name="student_id" data-controller="select2">
                        @foreach($students as $student)
                            <option id="select_student_id_{{ $student->id }}" value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row mt-4">
                <div class="col-4">
                    <button type="submit" name="action" value="generate" class="btn btn-block btn-danger btn-lg rounded-lg shadow mr-2">発行する</button>
                </div>
                <div class="col-4">
                    <button type="submit" name="action" value="generateAll" class="btn btn-block btn-info btn-lg rounded-lg shadow mr-2">クラス一括発行</button>
                </div>
                <div class="col-4"><a class="btn btn-block btn-success btn-lg rounded-lg" style="" data-dismiss="modal"><span class="text-white">戻る</span></a></div>

            </div>
        </form>
    </div>
</div>
