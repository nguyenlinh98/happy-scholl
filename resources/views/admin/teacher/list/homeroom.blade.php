<table class="table datatable" id="teachers_table">
    <thead>
        <tr>
            <th class="datatable--header--cell" scope="col">クラス</th>
            <th class="datatable--header--cell" scope="col">担任</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $class)
        @foreach ($class->managers as $manager)
        <tr>
            <td><a href="{{route("admin.teacher.edit", $manager->teacher)}}" class="btn">{{$class->name}}</a></td>
            <td>
                <a class="btn" href="{{route("admin.teacher.edit", $manager->teacher)}}">{{$manager->teacher->name}}</a>
            </td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>
</div>
