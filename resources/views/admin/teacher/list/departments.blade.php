<table class="table datatable" id="teachers_table">
    <thead>
        <tr>
            <th class="datatable--header--cell" scope="col">所属先</th>
            <th class="datatable--header--cell" scope="col">担当</th>
        </tr>
    </thead>
    <tbody>
        @foreach($departments as $department)
        @foreach ($department->managers as $manager)
        <tr>
            <td>
                <a class="btn" href="{{route("admin.teacher.edit", $manager->teacher)}}">{{$department->name}}</a></td>
            <td>
                <a class="btn" href="{{route("admin.teacher.edit", $manager->teacher)}}">{{$manager->teacher->name}}</a>
            </td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>
</div>
