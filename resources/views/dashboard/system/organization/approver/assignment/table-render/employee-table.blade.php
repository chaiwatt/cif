<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>เลือก</th>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th>ตำแหน่ง</th>
        </tr>
    </thead>
    <tbody id="employee_tbody">
        @foreach ($users as $user)
        <tr>
            <td>
                <div class="icheck-primary d-inline">
                    <input name="users[]" type="checkbox" id="checkboxPrimary{{$user->id}}" value="{{$user->id}}">
                    <label for="checkboxPrimary{{$user->id}}">
                    </label>
                </div>
            </td>
            <td>{{$user->employee_no}}</td>
            <td>{{$user->prefix->name}}{{$user->name}} {{$user->lastname}}
            </td>
            <td>{{$user->company_department->name}}</td>
            <td>{{$user->user_position->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links() }}