<div class="modal" id="uploadFormModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body bg-primary py-4">
                <h1 class="text-white text-center">CSVの読み込み</h1>
                <div class="w-75 mx-auto mt-4">
                    <form method="POST" action="{{ route('admin.student_setting.verify', $schoolClass) }}" enctype="multipart/form-data" class="form--common">
                        @csrf
                        <input type="hidden" value="{{ $schoolClass->id }}" name="school_class_id">
                        <div class="form-group mb-4">
                            <label for="csv_file">CSVファイル選択</label>
                            <input type="file" name="csv_file" id="csv_file" accept=".csv" class="form-control">
                        </div>

                        <div class="form-row mt-5 w-50">
                            <div class="col-6">
                                <button type="submit" name="action" value="generate" class="btn btn-block btn-danger btn-lg rounded-lg shadow mr-2">読み込みする</button>
                            </div>
                            <div class="col-4"><a class="btn btn-block btn-success btn-lg rounded-lg" style="" data-dismiss="modal"><span class="text-white">戻る</span></a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
