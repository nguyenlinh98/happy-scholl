<table class="table datatable" id="teachers_table">
    <thead>
        <tr>
            <th class="datatable--header--cell" scope="col">担任</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teachers as $teacher)
        <tr>
            <td><a href="{{route("admin.teacher.edit", $teacher)}}" class="btn">{{$teacher->name}}</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
