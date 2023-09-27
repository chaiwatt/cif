<table class="table table-bordered table-striped dataTable dtr-inline">
    <thead>
        <tr>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ-สกุล</th>
            <th>แผนก</th>
            <th class="text-right">เพิ่มเติม</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
        <tr>
            <td>{{$user->employee_no}}</td>
            <td>{{$user->name}}
                {{$user->lastname}}</td>
            <td>{{$user->company_department->name}}</td>
            <td class="text-right">
                @if ($permission->delete)
                <form
                    action="{{ route('groups.salary-system.setting.payday.assignment-user.delete', ['payday_id' => $payday->id, 'user_id' => $user->id]) }}"
                    method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{$users->links()}}