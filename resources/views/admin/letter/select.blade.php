<table class="table datatable" id="student_select_table" data-controller="datatable">
    <thead>
        <tr>
            <th scope="col" class="datatable--header--cell">クラス</th>
            <th scope="col" class="datatable--header--cell">生徒名</th>
            <th scope="col" class="datatable--header--cell">登録状況</th>
            <th scope="col" class="datatable--header--cell " style=" background: #ed1c24;color: white;" data-sortable="false">選択</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{$student->class->name}}</td>
                <td>{{$student->name}}</td>
                <td><div class="registration-status {{$student->hasParents ? 'registration-status--circle' : 'registration-status--cross'}} registration-status--bold"></div></td>
                <td>
                    <div class="select-box">
                        <input type="checkbox" name="select_student_{{$student->id}}" id="select_student_{{$student->id}}" value='@json(["id" => $student->id, "value" => "{$student->class->name}・{$student->name}"])' data-target="individual-select.student"/>
                        <label for="select_student_{{$student->id}}" class="select-box--label"></label>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
