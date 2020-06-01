<div role="individual_select" data-controller="individual-select" class="individual-select" data-individual-select-students-api="{{route('admin.letter.select_people')}}" data-individual-select-defaults="{{old('individual_receivers', isset($letter) ? $letter->individual_receivers : '[]')}}">
    <div class="form-group">
        {{-- <label for="individial_receivers">配信先</label> --}}
    </div>
    <div class="form-row mt-n3 mb-2">
        <div class="form-group col-sm-12 col-md-6">
            <input type="text" name="individual_receivers" id="individual_receivers" class="form-control {{$errors->has('individual_receivers') ? 'is-invalid' : ''}} " data-target="individual-select.tag" />
            @includeWhen($errors->has('individual_receivers'), 'components.form-error', ["name" => "individual_receivers"])
        </div>
        <div class="form-group col-sm-12 col-md-2">
            <button class="btn-dark btn btn-block hidden-on-form-confirm " data-toggle="modal" data-target="#selectClassModal" type="button">検索</button>
        </div>
    </div>
    <div class="modal" id="selectClassModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true" data-target="individual-select.modal">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content bg-form individual-select--select-class" data-target-="individual-select.selectClass" role="selectClass">
                <div class="modal-header border-bottom-0">
                    <h3>クラスを選んでください</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="form--chartboard p-2">
                    <div class="class-image p-5 overflow-auto">
                        <div class="row">
                            @foreach(hsp_school()->schoolClasses as $schoolClass)
                            <div class="col mb-5">
                                <a href="#" data-action="click->individual-select#selectClass" data-class-id="{{$schoolClass->id}}">
                                    <h2 class="text-white">{{$schoolClass->name}}</h2>
                                </a></div>
                            @if(0 === $loop->iteration % 3)
                        </div>
                        <div class="row">
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-content bg-form individual-select--select-student" data-target-="individual-select.selectStudent" role="selectStudent">
                <div class="modal-header border-bottom-0">
                    <h3>配信する人を選んでください</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body bg-white" data-target="individual-select.selectStudentBody">
                </div>
                <div class="modal-footer">
                    <div class="buttons mt-4 mb-3 mx-auto">
                        <button type="button" class="btn btn-danger btn-lg px-5 rounded-lg shadow mr-2" data-action="click->individual-select#selectStudent">送信</button>
                        <button type="button" class="btn btn-light btn-lg px-5 rounded-lg" data-dismiss="modal">戻る</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
