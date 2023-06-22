<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th>ตำแหน่ง</th>
            <th>ประเภท</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{$user->employee_no}}</td>
            <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}</td>
            <td>{{$user->company_department->name}}</td>
            <td>{{$user->user_position->name}}</td>
            <td>{{$user->employee_type->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links() }}